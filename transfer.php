<?php
include 'init.php';

if(!empty($_POST['type']) && !empty($_POST['email']) && !empty($_POST['amount'])) {
  switch($_POST['type']) {
    case 'check':
      try {
        enoughBalance($_POST['amount']);
        issetUser($_POST['email']);
        $random_hash = substr(md5(openssl_random_pseudo_bytes(20)),-20);
        $_SESSION[$random_hash] = md5($_POST['email'] . $_POST['amount']);
        $confirm_data = [
          'email' => $_POST['email'],
          'amount' => $_POST['amount'],
          'random_hash' => $random_hash,
        ];
      } catch(Exception $e) {
        $type = $e->getCode() == 200 ? 'success' : 'danger';
        $alert = [
          'message' => $e->getMessage(),
          'type' => $type,
        ];
      }
      break;
    case 'confirm':
      try {
        verifyTransction($_POST['email'], $_POST['amount']);
        doTransaction($_POST['email'], $_POST['amount']);
      } catch(Exception $e) {
        $type = $e->getCode() == 200 ? 'success' : 'danger';
        $alert = [
          'message' => $e->getMessage(),
          'type' => $type,
        ];
      }
      break;
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Account</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <? require 'sidebar.php' ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <? require 'navbar.php' ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

        <div class="row justify-content-center">
          <div class="col-lg-6">
            <div class="p-5">

            <!-- <div class="alert alert-success alert-dismissible fade show" role="alert">
              Перевод произведен успешно!
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div> -->

            <? if($alert): ?>
            <div class="alert alert-<?=$alert['type']?>" role="alert">
              <?=$alert['message']?>
            </div>
            <? endif; ?>

              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Перевод</h1>
              </div>
              <form class="user" method="post" action="transfer.php">
                <div class="form-group">
                  <input name="email" type="email" class="form-control form-control-user" id="email" placeholder="Email" required>
                </div>
                <div class="form-group">
                  <input name="amount" type="number" class="form-control form-control-user" id="amount" placeholder="Сумма" required>
                </div>
                <div class="form-group">
                  <input name="type" type="hidden" class="form-control form-control-user" value="check">
                </div>
                <button class="btn btn-primary btn-user btn-block">
                  Перевести
                </button>
              </form>

              <? if($confirm_data): ?>
              <form class="user mt-4" method="post" action="transfer.php">
                <div class="form-group">
                  <input name="email" type="hidden" class="form-control form-control-user" value="<?=$confirm_data['email']?>">
                </div>
                <div class="form-group">
                  <input name="amount" type="hidden" class="form-control form-control-user" value="<?=$confirm_data['amount']?>">
                </div>
                <div class="form-group">
                  <input name="type" type="hidden" class="form-control form-control-user" value="confirm">
                </div>
                <div class="form-group">
                  <input name="random_hash" type="hidden" class="form-control form-control-user" value="<?=$confirm_data['random_hash']?>">
                </div>
                <div class="text-center">
                  <h1 class="h4 text-gray-900 mb-4"><?=$confirm_data['amount']?>$ на счет <?=$confirm_data['email']?></h1>
                </div>
                <button class="btn btn-success btn-user btn-block">
                  Подтвердить и оплатить
                </button>
              </form>
              <? endif; ?>
            </div>
          </div>
        </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <? require 'footer.php' ?>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <? require 'logout.modal.php' ?>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
