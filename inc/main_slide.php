<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/db_connect.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/product.php";
$product = new Product($conn);
$num = 10;
$row = $product->find_of_num2($num);
if ($row) {
  echo "
        <div class='container w-auto mt-5 '>
        <h2>상품</h2>
       <div class='allGames'>
      <div class='row row-cols-1 row-cols-md-4 g-4'>
    ";

  $name = $row['name'];
  $file_copied_0 = $row['file_copied'];
  $file_type_0 = $row['file_type'];
  $price = $row['price'];
  $sale = $row['sale'];
  $image_width = 295;
  $image_height = 200;
?>
  <div class="col ">
    <div class="card" style="padding: 5px;">
      <a class="navbar-brand" href="http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/product/product_view.php?num=' . $num ?>">
        <?php if (strpos($file_type_0, "image") !== false) echo "<img  class='hover:grow hover:shadow-lg' src='./product/data/$file_copied_0' 
                width='$image_width' height='$image_height'><br>";
        else echo "<img src='./data/interior3.jpg' width='$image_width' height='$image_height'><br>" ?>
        <div class="card-body" style="text-align: center; ">
          <?= $name ?>
          <h5 class="card-text"><?= $sale ?> 원</h5>
        </div>
      </a>
    </div>
  </div>
<?php
}
?>
<?php
$num = 16;
$row = $product->find_of_num2($num);
if ($row) {
  $name = $row['name'];
  $file_copied_0 = $row['file_copied'];
  $file_type_0 = $row['file_type'];
  $price = $row['price'];
  $sale = $row['sale'];
  $image_width = 295;
  $image_height = 200;
?>
  <div class="col ">
    <div class="card" style="padding: 5px;">
      <a class="navbar-brand" href="http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/product/product_view.php?num=' . $num ?>">
        <?php if (strpos($file_type_0, "image") !== false) echo "<img  class='hover:grow hover:shadow-lg' src='./product/data/$file_copied_0' 
                width='$image_width' height='$image_height'><br>";
        else echo "<img src='./data/interior3.jpg' width='$image_width' height='$image_height'><br>" ?>
        <div class="card-body" style="text-align: center; ">
          <?= $name ?>
          <h5 class="card-text"><?= $sale ?> 원</h5>
        </div>
      </a>
    </div>
  </div>
<?php
}
?>
<?php
$num = 22;
$row = $product->find_of_num2($num);
if ($row) {
  $name = $row['name'];
  $file_copied_0 = $row['file_copied'];
  $file_type_0 = $row['file_type'];
  $price = $row['price'];
  $sale = $row['sale'];
  $image_width = 295;
  $image_height = 200;
?>
  <div class="col ">
    <div class="card" style="padding: 5px;">
      <a class="navbar-brand" href="http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/product/product_view.php?num=' . $num ?>">
        <?php if (strpos($file_type_0, "image") !== false) echo "<img  class='hover:grow hover:shadow-lg' src='./product/data/$file_copied_0' 
                width='$image_width' height='$image_height'><br>";
        else echo "<img src='./data/interior3.jpg' width='$image_width' height='$image_height'><br>" ?>
        <div class="card-body" style="text-align: center; ">
          <?= $name ?>
          <h5 class="card-text"><?= $sale ?> 원</h5>
        </div>
      </a>
    </div>
  </div>
<?php
}
?>
<?php
$num = 28;
$row = $product->find_of_num2($num);
if ($row) {
  $name = $row['name'];
  $file_copied_0 = $row['file_copied'];
  $file_type_0 = $row['file_type'];
  $price = $row['price'];
  $sale = $row['sale'];
  $image_width = 295;
  $image_height = 200;
?>
  <div class="col ">
    <div class="card" style="padding: 5px;">
      <a class="navbar-brand" href="http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/product/product_view.php?num=' . $num ?>">
        <?php if (strpos($file_type_0, "image") !== false) echo "<img  class='hover:grow hover:shadow-lg' src='./product/data/$file_copied_0' 
                width='$image_width' height='$image_height'><br>";
        else echo "<img src='./data/interior3.jpg' width='$image_width' height='$image_height'><br>" ?>
        <div class="card-body" style="text-align: center; ">
          <?= $name ?>
          <h5 class="card-text"><?= $sale ?> 원</h5>
        </div>
      </a>
    </div>
  </div>
<?php
}
?>

</div>
</div>
</div> <!-- end of container -->
</div>