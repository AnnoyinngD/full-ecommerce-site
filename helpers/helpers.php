
<?php
function display_errors($errors){
  $display = '<ul class="bg-danger">';
  foreach ($errors as $error) {
    $display .= '<li class="text-danger">'.$error.'</li>';
  }
  $display .= '</ul>';
  return $display;
}
  function sanitize($dirty){
    return htmlentites($dirty,ENT_QUOTES,"UTF-8");
  }

function money($number){
  return number_format($number, 2).' ETB';
}
function login($user_id){
  $_SESSION['SBUser'] = $user_id;
  global $db;
  $date = date("Y-m-d H:i:s");
  $db->query("UPDATE users SET last_login = '$date' WHERE id = '$user_id'");
  $_SESSION['success_MSG'] = 'you are now loggd in';
  header('Location: index.php');
}
function is_logged_in(){
  if (isset($_SESSION['SBUser']) && $_SESSION['SBUser'] > 0) {
    return true;
  }else {
    return false;
  }
}
function login_error_redirect($url = 'login.php'){
  $_SESSION['error_MSG'] = 'You must be logged in';
  header('Location: '.$url);
}
function permission_error_redirect($url = 'login.php'){
  $_SESSION['error_MSG'] = 'You do not have permission';
  header('Location: '.$url);
}
#permission level
 function has_permission($permission = 'admin'){
   global $user_data;
   $permissions = explode(',', $user_data['permissions']);
   if (in_array($permission,$permissions, true)) {
     return true;
   }
   else {
     return false;
   }
 }
function pretty_date($date){
  return date("M d, Y h:i A",strtotime($date));
}
function get_category($child_id){

  global $db;
  $id = $child_id;
  $sql = "SELECT p.id AS 'pid', p.category AS 'parent', c.id AS 'cid', c.category AS 'child'
        FROM categories c
        INNER JOIN categories p
        WHERE c.id = '$id'";
  $query = $db->query($sql);
  $category = mysqli_fetch_assoc($query);
  return $category;
}

function sizesToArray($string){
  $sizesArray = explode(',',$string);
  $returnArray = array();
  foreach ($sizesArray as $size) {
    $s = explode(':',$size);
    $returnArray[] = array('size' => $s[0], 'quantity' => $s[1]);
  }
  return $returnArray;
}
function sizesToString($sizes){
  $sizeString = '';
  foreach ($sizes as $size) {
    $sizeString .= $size['size'].':'.$size['quantity'].',';
  }
  $trimed = rtrim($sizeString, ',');
  return $trimed;
}
