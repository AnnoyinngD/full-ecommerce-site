<?php
      require_once $_SERVER['DOCUMENT_ROOT'].'/ecom/core/init.php';
      $name = $_POST['full_name'];
      $email= $_POST['email'];
      $street = $_POST['street'];
      $street2 = $_POST['street2'];
      $city = $_POST['city'];
      $zip_code = $_POST['zip_code'];
      $country = $_POST['country'];
      $errors = array();
      $required = array(
        'full_name' => 'Full Name',
        'email'     => 'Email',
        'street'    => 'Street Address',
        'city'      => 'City',
        'zip_code'  => 'Zip Code',
        'country'   => 'Country',
      );
      # Check if all req filds are filld
      # $f = fild, $d = display
      foreach ($required as $f => $d) {
        if (empty($_POST[$f]) || $_POST[$f] == '') {
          $errors[] = $d.' is required';
        }
      }
      #check for valid email
      if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please Enter a Valid Email';
      }

      if (!empty($errors)) {
        echo display_errors($errors);
      }else{
        echo true;
      }
