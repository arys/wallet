<?php
require 'db.php';
function verifyTransction($email, $amount) {
  if($_SESSION[$_POST['random_hash']] != md5($email . $amount)) {
    throw new Exception("Не удалось подтвердить транзакцию", 400);
  }
  unset($_SESSION[$_POST['random_hash']]);
}

function doTransaction($email, $amount) {
  $db = new Db();
  $res = $db->row("SELECT * FROM users WHERE email=:email", [ 'email' => $email ]);
  if(!$res) {
    throw new Exception("Ошибка произведения транзакции, пользватель не найден", 404);
  }
  $to_user = $res[0];

  $db->query("UPDATE users SET balance = balance + :amount WHERE id=:id", [
    'amount' => $amount,
    'id' => $to_user['id'],
  ]);

  $db->query("UPDATE users SET balance = balance - :amount WHERE id=:id", [
    'amount' => $amount,
    'id' => $_SESSION['user']['id'],
  ]);

  $db->query("INSERT INTO transactions(amount, from_id, to_id) VALUES (:amount, :from_id, :to_id)", [
    'amount' => $amount,
    'from_id' => $_SESSION['user']['id'],
    'to_id' => $to_user['id'],
  ]);

  $db->query("INSERT INTO notifications(text, for_user, type) VALUES (:text, :for_user, :type)", [
    'text' => "На ваш счет поступил перевод от " . $_SESSION['user']['email'] . " на сумму $" . $amount,
    'for_user' => $to_user['id'],
    'type' => 'payment',
  ]);

  throw new Exception("Перевод выполнен успешно", 200);
}

function enoughBalance($amount) {
  $balance = getCurrentUser()['balance'];
  if($balance == null) {
    throw new Exception("Сессия пользователя закончена", 400);
  }
  if($balance < $amount) {
    throw new Exception("Недостаточно средств на балансе", 400);
  }
}

function issetUser($email) {
  $db = new Db();
  if($email == $_SESSION['user']['email']) {
    throw new Exception("Укажите email другого пользователя", 400);
  }
  if(!$db->row("SELECT * FROM users WHERE email=:email", [ 'email' => $email ])) {
    throw new Exception("Такого пользователя не существует", 404);
  }
}

function getCurrentUser() {
  $db = new Db();
  return $db->row("SELECT * FROM `users` WHERE id=:id", [ 'id' => $_SESSION['user']['id'] ])[0];
}

function getUser($user_id) {
  $db = new Db();
  return $db->row("SELECT * FROM `users` WHERE id=:id", [ 'id' => $user_id ])[0];
}

function getUserByEmail($email) {
  $db = new Db();
  return $db->row("SELECT * FROM `users` WHERE email=:email", [ 'email' => $email ])[0];
}

function getNotifications() {
  $db = new Db();
  return $db->row("SELECT * FROM notifications WHERE for_user=:for_user OR for_user='all'", [
    'for_user' => $_SESSION['user']['id']
  ]);
}

function parseDate($mysqldate) {
  $phpdate = strtotime( $mysqldate );
  return date( 'd.m.Y H:i', $phpdate );
}

function getTransactions() {
  $db = new Db();
  return $db->row("SELECT * FROM transactions WHERE from_id=:user_id OR to_id=:user_id", [
    'user_id' => $_SESSION['user']['id'],
  ]);
}

function generateHistory() {
  $transactions = getTransactions();
  $history = [];
  if(count($transactions) > 0) {
    foreach($transactions as $transaction) {
      if($transaction['from_id'] == $_SESSION['user']['id']) {
        $to_user = getUser($transaction['to_id']);
        $history[] = [
          'title' => 'Перевод',
          'text' => $transaction['amount'] . "$ на счет " . $to_user['email'],
          'details' => $transaction,
          'display_date' => parseDate($transaction['date']),
        ];
      } elseif($transaction['to_id'] == $_SESSION['user']['id']) {
        $from_user = getUser($transaction['to_id']);
        $history[] = [
          'title' => 'Перевод',
          'text' => $transaction['amount'] . "$ со счета " . $from_user['email'],
          'details' => $transaction,
          'display_date' => parseDate($transaction['date']),
        ];
      }
    }
  }
  return $history;
}

function updateBalance($amount) {
  $db = new Db();
  $db->query("UPDATE users SET balance = balance + :amount WHERE id=:id", [ 
    'amount' => $amount,
    'id' => $_SESSION['user']['id'] 
  ]);
}

function register($name, $lastName, $email, $password, $repeatPassword) {
  if( $password != $repeatPassword) {
    throw new Exception("Пароли не совпадают", 400);
  }
  $db = new Db();
  $issetUser = $db->row("SELECT * FROM users WHERE email=:email", [
    'email' => $email
  ]);
  if(count($issetUser) > 0) {
    throw new Exception("Пользователь с такой почтой уже существует", 400);
  }
  $db->query("INSERT INTO users(email, password, balance) VALUES (:email, :password, :balance)", [
    'email' => $email,
    'password' => md5($password),
    'balance' => 0,
  ]);
}
?>