<?php
  require_once '../core/init.php';
  if (!is_logged_in()) {
    header('Location: login.php');
  }

  include 'includes/header.php';
  include 'includes/nav.php';

 ?>

Admin home



 <?php include 'includes/footer.php' ?>
