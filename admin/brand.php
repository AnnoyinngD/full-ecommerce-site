<?php
  require_once '../core/init.php';
  if (!is_logged_in()) {
    login_error_redirect();
  }
  include 'includes/header.php';
  include 'includes/nav.php';
  #get brands DB
  $sql = "SELECT * FROM brand ORDER BY brand";
  $results = $db->query($sql);
  $errors = array();
  #EDIT brand

  if (isset($_GET['edit']) && !empty($_GET['edit'])) {
    $edit_id = (int)$_GET['edit'];
    #$delete_id = (int)$_GET['edit'];
    $sql2 = "SELECT * FROM brand WHERE id = '$edit_id'";
    $edit_result = $db->query($sql2);
    $eBrand = mysqli_fetch_assoc($edit_result);
    #header('Location: brand.php');
  }

  #DELETE Brand
  if (isset($_GET['delete']) && !empty($_GET['delete'])) {
    $delete_id = (int)$_GET['delete'];
    #$delete_id = sanitize($delete_id);
    $sql = "DELETE FROM brand WHERE id = '$delete_id'";
    $db->query($sql);
    header('Location: brand.php');
  }

  #if add form is submited
  if(isset($_POST['add_submit'])){
    # $brand = sanitize($_POST['brand']);
    $brand = $_POST['brand'];
    #check if brand is blank
    if($_POST['brand'] == ''){
      echo "<br><br><br>";
      $errors[] .= 'You must enter a brand';
    }
    #check if brand exists
    $sql = "SELECT * FROM brand WHERE brand = '$brand'";
    if (isset($_GET['edit'])) {
      $sql = "SELECT * FROM brand WHERE brand = '$brand' AND id != '$edi_id'";
    }
    $result = $db->query($sql);
    $count = mysqli_num_rows($result);
    if ($count > 0) {
    #  echo "<br><br><br>";
      $errors[] .= $brand.' exists';
    }
    #display_errors
    if(!empty($errors)){
      echo display_errors($errors);
    }else {
      #Add brand to DB
      $sql = "INSERT INTO brand (brand) VALUES ('$brand')";
      if (isset($_GET['edit'])) {
        $sql = "UPDATE brand SET brand = '$brand' WHERE id = '$edit_id'";
      }
      $db->query($sql);
      header('Location: brand.php');#to refresh
    }
  }

 ?>

<h2 class="text-center">Brands</h2><hr>
<!-- Brand form -->
<div class="text-center">
  <form class="form-inline" action="brand.php<?=((isset($_GET['edit']))?'?edit='.$edit_id:''); ?>" method="post">
    <div class="form-group">
      <?php
      $brand_value = '';
       if (isset($_GET['edit'])) {
      $brand_value = $eBrand['brand'];
    }
    else {
      if(isset($_POST['brand'])){
        $brand_value = $_POST['brand'];
      }
    } ?>
      <label for="brand"><?=((isset($_GET['edit']))?'Edit':'Add A');?> Brand:</label>
      <input type="text" name="brand" id="brand" class="form-control" value="<?=$brand_value; ?>">
      <?php if(isset($_GET['edit'])): ?>
        <a href="brand.php" class="btn btn-default">Cancel</a>
      <?php endif; ?>
      <input type="submit" name="add_submit" value="<?=((isset($_GET['edit']))?'Edit':'Add');?> Brand" class="btn btn-success">
    </div>
  </form>
</div>
<hr>

<table class="table table-bordered table-stripe table-auto table-condensed">
  <thead>
    <th></th>
    <th>Brands</th>
    <th></th>
  </thead>
  <tbody>
    <?php while($brand = mysqli_fetch_assoc($results)): ?>
    <tr>
      <td><a href="brand.php?edit=<?=$brand['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a></td>
      <td><?=$brand['brand']; ?></td>
      <td><a href="brand.php?delete=<?=$brand['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a></td>
    </tr>
  <?php endwhile; ?>
  </tbody>
</table>
 <?php include 'includes/footer.php' ?>
