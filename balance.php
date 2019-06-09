<?php 
include 'init.php';
if(!empty($_POST['amount'])) {
  if($_POST['amount'] > 0) {
    updateBalance($_POST['amount']);
    $alert = [
      'message' => 'Баланс пополнен на $' . $_POST['amount'],
      'type' => 'success',
    ];
  } else {
    $alert = [
      'message' => 'Введите сумму правильно',
      'type' => 'danger',
    ];
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

  <title>Balance</title>

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

            <? if($alert): ?>
            <div class="alert alert-<?=$alert['type']?>" role="alert">
              <?=$alert['message']?>
            </div>
            <? endif; ?>

              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Пополнение счета</h1>
              </div>
              <form class="user" method="post" action="balance.php">
                <div class="form-group">
                  <input name="amount" type="number" class="form-control form-control-user" id="amount" placeholder="Сумма" required>
                </div>
                <button class="btn btn-primary btn-user btn-block">
                  VISA / MASTER CARD
                </button>
                <button class="btn btn-warning btn-user btn-block">
                  QIWI
                </button>
                <button class="btn btn-info btn-user btn-block">
                  PAYPAL
                </button>
              </form>
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
