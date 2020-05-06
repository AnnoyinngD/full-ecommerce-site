<?php
  $cat_id = ((isset($_REQUEST['cat']))?$_REQUEST['cat']:'');
  $price_sort = ((isset($_REQUEST['price_sort']))?$_REQUEST['price_sort']:'');
  $min_price =((isset($_REQUEST['min_price']))?$_REQUEST['min_price']:'');
  $max_price =((isset($_REQUEST['max_price']))?$_REQUEST['max_price']:'');
  $b = ((isset($_REQUEST['brand']))?$_REQUEST['brand']:'');
  $brandQ = $db->query("SELECT * FROM brand ORDER BY brand");
?>
<h3 class="text-center">Search by:</h3>
<h4 class="text-center">Price</h4>
<form action="search.php" method="post">
  <input type="hidden" name="cat" value="<?=$cat_id?>">
  <!-- if not checked high or low -->
  <input type="hidden" name="price_sort" value="0">
  <input type="radio" name="price_sort" value="low"<?=(($price_sort == 'low')?' checked':'')?>>low to high <br>
  <input type="radio" name="price_sort" value="high"<?=(($price_sort == 'high')?' checked':'')?>>high to low <br>
  <input type="text" name="min_price" class="price_range" placeholder="min ETB" value="<?=$min_price?>"> To
  <input type="text" name="max_price" class="price_range" placeholder="max ETB" value="<?=$max_price?>"><br><br>
  <h4 class="text-center">Brand</h4><br>
  <input type="radio" name="brand" value=""<?=(($b == '')?' checked':'')?>>All <br>
  <?php while ($brand = mysqli_fetch_assoc($brandQ)): ?>
    <input type="radio" name="brand" value="<?=$brand['id']?>"<?=(($b == $brand['id'])?' checked':'')?>><?=$brand['brand']?><br>
  <?php endwhile; ?>
  <br> <input type="submit" name="" value="Search" class="btn btn-xs btn-primary">
</form>
