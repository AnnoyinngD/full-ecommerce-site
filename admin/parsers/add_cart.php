<?php

  require_once $_SERVER['DOCUMENT_ROOT'].'/ecom/core/init.php';
  $product_id = $_POST['product_id'];
  $size = $_POST['size'];
  $available = $_POST['available'];
  $quantity = $_POST['quantity'];


  $item = array();
  $item[] = array(
    'id'       => $product_id,
    'size'     => $size,
    'quantity' => $quantity,
  );

  $domain = ($_SERVER['HTTP_HOST'] != 'localhost')?'.'.$_SERVER['HTTP_HOST']:false;
  $query = $db->query("SELECT * FROM products WHERE id = '{$product_id}'");
  $product = mysqli_fetch_assoc($query);
  $_SESSION['success_MSG'] = $product['title']. ' is added to your cart.';

  #if Cart COOKIE exists
  if ($cart_id != '') {
    $cartQ = $db->query("SELECT * FROM cart WHERE id = '{$cart_id}'");
    $cart = mysqli_fetch_assoc($cartQ);
    $previous_items = json_decode($cart['items'],true);#returns assoc array
    $item_match = 0;
    $new_items = array();
    foreach ($previous_items as $pitem) {
      if ($item[0]['id'] == $pitem['id'] && $item[0]['size'] == $pitem['size']) {
        $pitem['quantity'] = $pitem['quantity'] + $item[0]['quantity'];
        #check if Available
        if ($pitem['quantity'] > $available) {
          $pitem['quantity'] = $available;
        }
        $item_match = 1;
      }
      $new_items[] = $pitem;
    }
    #if new item merge
    if ($item_match != 1) {
      $new_items = array_merge($item,$previous_items);
    }
    $items_json = json_encode($new_items);
    $cart_expire = date("y-m-d H:i:s",strtotime("+30 days"));
    $db->query("UPDATE cart SET items = '{$items_json}', expire_date = '{$cart_expire}' WHERE id = '{$cart_id}'");
    setcookie(CART_COOKIE,'',1,"/",$domain,false);
    setcookie(CART_COOKIE,$cart_id,CART_COOKIE_EXPIRE,"/",$domain,false);

  }else {
    #add cart to db and set COOKIE
    $items_json = json_encode($item);
    $cart_expire = date("y-m-d H:i:s",strtotime("+30 days"));
    $db->query("INSERT INTO cart (items, expire_date) VALUES ('{$items_json}','{$cart_expire}')");
    $cart_id = $db->insert_id;#return last inserted id in db
    setcookie(CART_COOKIE,$cart_id,CART_COOKIE_EXPIRE,'/',$domain,false);#turning security off to access on localhost
  }
 ?>
