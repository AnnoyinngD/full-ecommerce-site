<?php

    require_once $_SERVER['DOCUMENT_ROOT'].'/ecom/core/init.php';
    include 'includes/header.php';

    $email = ((isset($_POST['email']))?$_POST['email']:'');
    $password = ((isset($_POST['password']))?$_POST['password']:'');
    $errors = array();
?>

<style>
  body{
    background-image: url("/ecom/images/headerlogo/background.png");
    background-size: 100vw 100vh;
    background-attachment: fixed;
  }
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
        if (empty($_POST['email']) || empty($_POST['password'])) {
          $errors[] = 'You must provide an email and a password.';
        }

        #validate email
        if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
          $errors[] = 'You must enter a valid email';
        }
        #password more than 6 charcter
        if (strlen($password) < 6) {
          $errors[] = 'Your password must be above 6 charcter.';
        }

        #check if email exists
        $query = $db->query("SELECT * FROM users WHERE email = '$email'");
        $user = mysqli_fetch_assoc($query);
        $userCount = mysqli_num_rows($query);
        if ($userCount < 1) {
          $errors[] = 'The email do not exists in the database.';
        }
        #verifi password
        if (!password_verify($password, $user['password'])) {
          $errors[] = 'Password dose not match, pleas try again';
        }
        #check for errors
        if (!empty($errors)) {
          echo display_errors($errors);
        }else {
          #log user in
          $user_id = $user['id'];
          login($user_id);
        }

      }
    ?>
  </div>
  <h2 class="text-center">Login</h2><hr>
  <form action="login.php" method="post">
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" name="email" id="email" class="form-control" value="<?=$email?>">
    </div>
    <div class="form-group">
      <label for="password">Password:</label>
      <input type="password" name="password" id="password" class="form-control" value="<?=$password?>">
    </div>
    <div class="form-group">
      <input type="submit" value="Login" class="btn btn-primary">
    </div>
  </form>
  <p class="text-right"> <a href="/ecom/index.php">Visit Site</a> </p>
</div>


<?php include 'includes/footer.php'?>
