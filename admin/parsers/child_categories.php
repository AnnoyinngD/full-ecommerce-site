<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/ecom/core/init.php';
  $parentID = (int)$_POST['parentID'];
  $selected = $_POST['selected'];
  $childQuery = $db->query("SELECT * FROM categories WHERE parent = '$parentID' ORDER BY category");
#start buffer
  ob_start();
 ?>
  <option value=""></option>
  <?php while($child = mysqli_fetch_assoc($childQuery)): ?>
    <option value="<?=$child['id']?>"<?=(($selected == $child['id'])?' selected':'')?>><?=$child['category']?></option>
  <?php endwhile; ?>
 <?php /* release memory */ echo ob_get_clean(); ?>
