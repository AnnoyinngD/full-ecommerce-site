<?php
  $db = mysqli_connect('localhost', 'root', '', 'delux');

    if (mysqli_connect_errno()) {
      echo "Database connection faild with following errors: ". mysqli_connect_error();
      die();
    }
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT'].'/ecom/config.php';
    require_once BASEURL.'helpers/helpers.php';
    require BASEURL.'vendor/autoload.php';
    #if there is a session set to have the user data
    $cart_id = '';
    if (isset($_COOKIE[CART_COOKIE])) {
      $cart_id = $_COOKIE[CART_COOKIE];
    }

    if (isset($_SESSION['SBUser'])) {
      $user_id = $_SESSION['SBUser'];
      $query =  $db->query("SELECT * FROM users WHERE id = '$user_id'");
      $user_data = mysqli_fetch_assoc($query);
      $fn = explode(' ', $user_data['full_name']);
      $user_data['first'] = $fn[0];
      #$user_data['last'] = $fn[1];
    }
    if (isset($_SESSION['success_MSG'])) {
      echo '<div class="bg-success"><br><br><p class="text-success text-center">'.$_SESSION['success_MSG'].'</p></div>';
      unset($_SESSION['success_MSG']);
    }
    if (isset($_SESSION['error_MSG'])) {
      echo '<div class="bg-danger"><p class="text-danger text-center">'.$_SESSION['error_MSG'].'</p></div>';
      unset($_SESSION['error_MSG']);
    }


 ?>
