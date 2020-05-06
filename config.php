<?php
  define('BASEURL', $_SERVER['DOCUMENT_ROOT'].'/ecom/');#path to root of document
  define('CART_COOKIE', 'SbafgSD45uidklw');#cooki string
  define('CART_COOKIE_EXPIRE', time() + (86400 * 30));#for 30 days
  define('TAXRATE', 0.087);#tax rate

  define('CURRENCY', 'ETB');
  define('CHECKOUTMODE','TEST');#change to live after testing


  if (CHECKOUTMODE == 'TEST') {
    define('STRIPE_PRIVATE','sk_test_e9QeZI7IdSwkjCrnG9kSzFUJ');
    define('STRIPE_PUBLIC','pk_test_y7cuQ1CZxwUTJcoGVQV5g0JQ');
  }
  #not gonna be used
  if (CHECKOUTMODE == 'LIVE') {
    define('STRIPE_PRIVATE','');
    define('STRIPE_PUBLIC','');
  }
