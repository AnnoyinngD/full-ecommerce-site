<?php

    require_once $_SERVER['DOCUMENT_ROOT'].'/ecom/core/init.php';
    if (!is_logged_in()) {
      login_error_redirect();
    }
    include 'includes/header.php';

    $hashed = $user_data['password'];
    $old_password = ((isset($_POST['old_password']))?$_POST['old_password']:'');
    $password = ((isset($_POST['password']))?$_POST['password']:'');
    $confirm = ((isset($_POST['confirm']))?$_POST['confirm']:'');
    $new_hashed = password_hash($password, PASSWORD_DEFAULT);
    $user_id = $user_data['id'];
    $errors = array();
?>

<style>
  #login-form{
    width: 50%;
    height: 60%;
    border: 2px solid #000;
    border-radius: 15px;
    box-shadow: 7px 7px 15px rgba(0,0,0,0.6);
    margin: 5% auto;
    padding: 15px;
    background-color: #fff;
  }
</style>
<div  id="login-form">
  <div>
    <?php
      if ($_POST) {
        #Form validation
        if (empty($_POST['old_password']) || empty($_POST['password']) || empty($_POST['confirm'])) {
          $errors[] = 'You must fill out all filds.';
        }

        #password more than 6 charcter
        if (strlen($password) < 6) {
          $errors[] = 'Your password must be above 6 charcter.';
        }
        #if confirm matchs
        if ($password != $confirm) {
          $errors[] = 'Password do not match.';
        }
        #verifi password
        if (!password_verify($old_password, $hashed)) {
          $errors[] = 'worng old password';
        }
        #check for errors
        if (!empty($errors)) {
          echo display_errors($errors);
        }else {
          #change passwords
          $db->query("UPDATE users SET password = '$new_hashed' WHERE id = '$user_id'");
          $_SESSION['success_MSG'] = 'Your password has been updated';
          header('Location: index.php');
        }

      }
    ?>
  </div>
  <h2 class="text-center">Change Password</h2><hr>
  <form action="change_password.php" method="post">
    <div class="form-group">
      <label for="old_password">Old Password:</label>
      <input type="password" name="old_password" id="old_password" class="form-control" value="<?=$old_password?>">
    </div>
    <div class="form-group">
      <label for="password">New Password:</label>
      <input type="password" name="password" id="password" class="form-control" value="<?=$password?>">
    </div>
    <div class="form-group">
      <label for="confirm">Confirm New Password:</label>
      <input type="password" name="confirm" id="confirm" class="form-control" value="<?=$confirm?>">
    </div>
    <div class="form-group">
      <a href="index.php" class="btn btn-default">Cancel</a>
      <input type="submit" value="Change" class="btn btn-primary">
    </div>
  </form>
  <p class="text-right"> <a href="/ecom/index.php">Visit Site</a> </p>
</div>


<?php include 'includes/footer.php'?>
