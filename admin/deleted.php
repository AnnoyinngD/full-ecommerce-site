<?php

    require_once $_SERVER['DOCUMENT_ROOT'].'/ecom/core/init.php';
    if (!is_logged_in()) {
      login_error_redirect();
    }
    include 'includes/header.php';
    include 'includes/nav.php';
    #show deleted
    $presults = $db->query("SELECT * FROM products WHERE deleted = 1 ");
    #Delete Product
    if (isset($_GET['delete'])) {
      $id = $_GET['delete'];
      $db->query("UPDATE products SET deleted = 0 WHERE id = '$id'");
      header('Location: deleted.php');
    }
?>
<h2 class="text-center">Archived</h2>

<div class="clearfix"></div>

    <table class="table table-bordered table-condensed table-striped">
      <thead>
        <th></th>
        <th>Products</th>
        <th>Price</th>
        <th>Category</th>
        <th>Featured</th>
        <th>Sold</th>
      </thead>
      <tbody>
        <?php while($product = mysqli_fetch_assoc($presults)):
              #search for parent and display
            $childID = $product['categories'];
            $catsql = "SELECT * FROM categories WHERE id = '$childID'";
            $result = $db->query($catsql);
            $child = mysqli_fetch_assoc($result);
            $parentID = $child['parent'];
            $pSql = "SELECT * FROM categories WHERE id = '$parentID'";
            $presult = $db->query($pSql);
            $parent = mysqli_fetch_assoc($presult);
            $category = $parent['category']. '~' .$child['category'];
          ?>
          <tr>
            <td>
                <a href="deleted.php?delete=<?=$product['id']?>" class="btn btn-xs btn-default"> <span class="glyphicon glyphicon-refresh"></span> </a>
            </td>
            <td><?=$product['title']?></td>
            <td><?=money($product['price']);?></td>
            <td><?=$category ?></td>
            <td><a href="products.php?featured=<?=(($product['featured'] == 0)?'1':'0')?>&id=<?=$product['id']?>" class="btn btn-xs btn-default">
              <span class="glyphicon glyphicon-<?=(($product['featured'] == 1)?'minus':'plus')?>"></span>
            </a>&nbsp; <?=(($product['featured'] == 1)?'Featured Product':'')?></td>
            <td>0</td>
          </tr>
      <?php endwhile; ?>
      </tbody>
    </table>




<?php
 include 'includes/footer.php'; ?>
