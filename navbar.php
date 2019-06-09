<?php
$user = getCurrentUser();
$notifications = getNotifications();
?>

<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

<!-- Sidebar Toggle (Topbar) -->
<button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
  <i class="fa fa-bars"></i>
</button>

<a class="navbar-brand" href="#">Главная</a>

<!-- Topbar Navbar -->
<ul class="navbar-nav ml-auto">

  <!-- Nav Item - Alerts -->
  <li class="nav-item dropdown no-arrow mx-1">
    <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <i class="fas fa-bell fa-fw"></i>
      <!-- Counter - Alerts -->
      <? if(count($notifications) > 0): ?>
      <span class="badge badge-danger badge-counter"><?=count($notifications)?></span>
      <? endif; ?>
    </a>
    <!-- Dropdown - Alerts -->
    <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
      <h6 class="dropdown-header">
        Уведомления
      </h6>
      <? foreach($notifications as $notification): ?>
      <? if($notification['type'] == 'payment'): ?>
      <a class="dropdown-item d-flex align-items-center" href="#">
        <div class="mr-3">
          <div class="icon-circle bg-success">
            <i class="fas fa-donate text-white"></i>
          </div>
        </div>
        <div>
          <div class="small text-gray-500"><?=parseDate($notification['date'])?></div>
          <?=$notification['text']?>
        </div>
      </a>
      <? elseif($notification['type'] == 'news'): ?>
      <a class="dropdown-item d-flex align-items-center" href="#">
        <div class="mr-3">
          <div class="icon-circle bg-primary">
            <i class="fas fa-file-alt text-white"></i>
          </div>
        </div>
        <div>
          <div class="small text-gray-500">Декабрь 12, 2019</div>
          <span class="font-weight-bold"><?=$notification['text']?></span>
        </div>
      </a>
      <? elseif($notification['type'] == 'alert'):?>
      <a class="dropdown-item d-flex align-items-center" href="#">
        <div class="mr-3">
          <div class="icon-circle bg-warning">
            <i class="fas fa-exclamation-triangle text-white"></i>
          </div>
        </div>
        <div>
          <div class="small text-gray-500">Декабрь 2, 2019</div>
          <?=$notification['text']?>
        </div>
      </a>
      <? endif;?>
      <? endforeach; ?>
      <a class="dropdown-item text-center small text-gray-500" href="#">Показать все уведомления</a>
    </div>
  </li>

  <div class="topbar-divider d-none d-sm-block"></div>

  <!-- Nav Item - User Information -->
  <li class="nav-item dropdown no-arrow">
  <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?=$user['balance']?>$</span>
    </a>
    <!-- Dropdown - User Information -->
    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
      <a class="dropdown-item" href="#" data-toggle="modal" data-target="#">
        <i class="fas fa-dollar-sign fa-sm fa-fw mr-2 text-gray-400"></i>
        <?=$user['balance']?>
      </a>
      <a class="dropdown-item" href="#" data-toggle="modal" data-target="#">
        <i class="fas fa-tenge fa-sm fa-fw mr-2 text-gray-400"></i>
        0
      </a>
    </div>
  </li>

  <!-- Nav Item - User Information -->
  <li class="nav-item dropdown no-arrow">
  <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?=$user['email']?></span>
      <img class="img-profile rounded-circle" src="https://image.flaticon.com/icons/svg/1246/1246351.svg">
    </a>
    <!-- Dropdown - User Information -->
    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
        Выход
      </a>
    </div>
  </li>

</ul>

</nav>