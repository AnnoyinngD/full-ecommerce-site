<?php

  require_once $_SERVER['DOCUMENT_ROOT'].'/ecom/core/init.php';
  if (!is_logged_in()) {
    login_error_redirect();
  }
  include 'includes/header.php';
  include 'includes/nav.php';

  $sql = "SELECT * FROM categories WHERE parent = 0";
  $result = $db->query($sql);
  $errors = array();
  $category = '';
  $post_parent = '';
  #Edit Category
    if (isset($_GET['edit']) && !empty($_GET['edit'])) {
      $edit_id = (int)$_GET['edit'];
      $edit_sql= "SELECT * FROM categories WHERE id = '$edit_id'";
      $edit_result = $db->query($edit_sql);
      $edit_category = mysqli_fetch_assoc($edit_result);
    }
  # Delete Category
  if (isset($_GET['delete']) && !empty($_GET['delete'])) {
    $delete_id = (int)$_GET['delete'];
    # to delete de childs wen the fucking parentis shot down lol...
    $sql = "SELECT * FROM categories WHERE id = '$delete_id'";
    $result = $db->query($dsql);
    $category = mysqli_fetch_assoc($result);
    if ($category['parent'] == 0) {
      $sql = "DELETE FROM categories WHERE parent = '$delete_id'";
      $db->query($sql);
    }
    # up to fucking here god this is BS
    #if the above is relay bs then just fucking delete the child
    $dsql = "DELETE FROM categories WHERE id = '$delete_id'";
    $db->query($dsql);
    header('Location: categories.php');
  }

  # Procces form
  if (isset($_POST) && !empty($_POST)) {
    $post_parent = $_POST['parent'];
    $category = $_POST['category'];
    $sqlform = "SELECT * FROM categories WHERE category = '$category' AND parent = '$post_parent'";
    if (isset($_GET['edit'])) {
      #redefine de form
      #to check if de id don't match, unles update won't work ''''
      $id = $edit_category['id'];
      $sqlform = "SELECT * FROM categories WHERE category = '$category' AND parent = '$post_parent' AND id != '$id' ";
    }
    $fresult = $db->query($sqlform);
    $count = mysqli_num_rows($fresult);
    # if category is blank

    if ($category == "") {
      $errors[] .= 'The Category cannot be blank.';
    }
    # if exists in db

    if ($count > 0) {
      $errors[] .= $category. ' already exists. Pleas choose a new category';
    }

    #Display errors or update db
    if (!empty($errors)) {
      #Display errors
      $display = display_errors($errors); ?>
      <script>
        jQuery('document').ready(function() {
          jQuery('#error').html('<?=$display; ?>');
        })
      </script>
    <?php
        }else {
            #UPDATE db
            $updatesql = "INSERT INTO categories (category, parent) VALUES ('$category', '$post_parent')";
            if (isset($_GET['edit'])) {
            $updatesql = "UPDATE categories SET category = '$category', parent = '$post_parent' WHERE id = '$edit_id'";
            }
            $db->query($updatesql);
            header('Location: categories.php');
          }
  }
  #simple dum thing, just to see the category that is being edited
  $category_value = '';# to avoid undefined error
  $parent_value = 0;
  if (isset($_GET['edit'])) {
    $category_value = $edit_category['category'];
    $parent_value = $edit_category['parent'];
  }else {
    if (isset($_POST)) {
      #for _POST method
      $category_value = $category;#for _POST method
      $parent_value = $post_parent;
    }
  }
////////////////////////////////////////////////////////////////////////
 ?>

<h2 class="text-center">Categories</h2><hr>

<div class="row">
  <div class="col-md-6">
    <!-- Form -->
    <form class="form" action="categories.php<?=((isset($_GET['edit']))?'?edit= '.$edit_id:'');?>" method="post">
      <legend><?=((isset($_GET['edit']))?'Edit':'Add A');?> Category</legend>
      <div id="error"></div>
      <div class="form-group">
        <label for="parent">Parent</label>
        <select class="form-control" name="parent" id="parent">
          <option value="0"<?=(($parent_value == 0))?' selected="selected"':'';?>>Parent</option>
          <?php while($parent = mysqli_fetch_assoc($result)): ?>
            <option value="<?=$parent['id'];?>"<?=(($parent_value == $parent['id']))?' selected="selected"':'';?>><?=$parent['category'];?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="form-group">
        <label for="category">Category</label>
        <input type="text" class="form-control" id="category" name="category" value="<?=$category_value; ?>">
      </div>
      <div class="form-group">
        <input type="submit" class="btn btn-success" value="<?=((isset($_GET['edit']))?'Edit':'Add ');?> Category">
      </div>
    </form>

  </div>
  <div class="col-md-6">
    <!-- Categories Table -->
    <table class="table table-borderd">
      <thead>
        <th>Category</th>
        <th>Parent</th>
        <th></th>
      </thead>
      <tbody>
        <?php
        $sql = "SELECT * FROM categories WHERE parent = 0";
        $result = $db->query($sql);
        while($parent = mysqli_fetch_assoc($result)):
          $parent_id = (int)$parent['id'];
          $sql2 = "SELECT * FROM categories WHERE parent = '$parent_id'";
          $cresult = $db->query($sql2);
          ?>
          <tr class="bg-primary">
            <td><?=$parent['category'];?></td>
            <td>Parent</td>
            <td>
              <a href="categories.php?edit=<?=$parent['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></a>
              <a href="categories.php?delete=<?=$parent['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></a>
            </td>
          </tr>
          <?php while($child = mysqli_fetch_assoc($cresult)): ?>
            <tr class="bg-info">
              <td><?=$child['category'];?></td>
              <td><?=$parent['category'];?></td>
              <td>
                <a href="categories.php?edit=<?=$child['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></a>
                <a href="categories.php?delete=<?=$child['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></a>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<?php
  include 'includes/footer.php';
 ?>
