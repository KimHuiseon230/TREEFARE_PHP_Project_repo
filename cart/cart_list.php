<?php
session_start();
$ses_level = (isset($_SESSION['ses_level']) && $_SESSION['ses_level'] != '') ? $_SESSION['ses_level'] : '';

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/php_treefare/cart/css/cart_list.css?v=<?= date('Ymdhis') ?>">
</head>

<body>
  <header>
    <?php
    $js_array = ['js/cart_list.js'];

    if ($ses_level == 10) {
      include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_admin_header.php";
    } else {
      include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_header.php";
    }
    include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/db_connect.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/create_table.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/cart.php";
    $cart = new Cart($conn);
    create_table($conn, "cart");
    ?>
  </header>
  <?php
  session_start();
  if (!$_SESSION["ses_id"]) {
    echo ("
        <script>
          alert('로그인 후에 장바구니 이용이 가능합니다.');
          history.go(-1);
				</script>
			");
    exit;
  }
  ?>
  <section>
    <div class="main_content">
      <div class="blank"></div>
      <div class="center">
        <div style="width: 1000px;">
          <div class="cart_top">
            <h2>YOUR CART</h2>
          </div>
          <div class="cart__information" style=" background-color: whitesmoke; padding: 10px; ">
            <ul>
              <li style="color: limegreen;">장바구니 상품은 최대 30일간 저장됩니다.</li>
              <li>가격, 옵션 등 정보가 변경된 경우 주문이 불가할 수 있습니다.</li>
              <li>오늘출발 상품은 판매자 설정 시점에 따라 오늘출발 여부가 변경될 수 있으니 주문 시 꼭 다시 확인해 주시기 바랍니다.</li>
            </ul>
          </div>
          <ul id="cart_list">
            <li class="cart_title">
              <div class="check">선택</div>
              <div class="pic">상품</div>
              <div class="name">상품명</div>
              <div class="price">가격</div>
              <div class="count">수량</div>
            </li>
            <?php
            $id = $_SESSION["ses_id"];
            $rowArray = $cart->find_of_num($id);

            foreach ($rowArray as $row) {
              $s_num = $row["s_num"];
              $s_name = $row["s_name"];
              $s_price = $row["s_sale"];
              $s_count = $row["s_count"];
              $s_file_name = $row["s_file_name"];
              $s_file_type = $row["s_file_type"];
              $s_file_copied = $row["s_file_copied"];

              $image_width = 100;
              $image_height = 100;

              if (!empty($s_file_name)) {
                $image_info = getimagesize("../product/data/" . $s_file_copied);
                $image_width = $image_info[0];
                $image_height = $image_info[1];
                $image_type = $image_info[2];
                if ($image_width > 100) $image_width = 100;
                if ($image_height > 100) $image_height = 100;
                $file_copied_0 = $s_file_copied;
              }
            ?>
              <form method="POST" class="item" action="cart_di.php">
                <input type="hidden" name="mode" value="delete">
                <span class="subject">
                  <div class="check"><input type="checkbox" name="item[]" value="<?= $s_num ?>"></div>
                  <?php
                  echo "<img src='../product/data/$file_copied_0' width='$image_width' height='$image_height' class='pic'><br>";
                  ?>

                  <div class="name"><?= $s_name ?></div>
                  <div class="price"><?= "&#92;" . $s_price ?></div>
                  <div class="count"><?= $s_count . "개" ?></div>
                </span>
              <?php
            }
              ?>
              <button type="submit" class="red_button">선택된 상품 삭제</button>
              </form>
          </ul>
          <div class="calculate">
            <p class="cal_title">총 결제 금액 &nbsp;&nbsp; : &nbsp;&nbsp;</p>
            <?php
            $calculate = 0;
            $rowArray = $cart->find_of_num($id);
            foreach ($rowArray as $row) {
              $s_price = (int)str_replace(',', '', $row["s_sale"]);
              $s_count = (int)$row['s_count'];

              $calculate += $s_price * $s_count;
            }
            ?>
            <p id="p_price"><?= number_format($calculate) ?>&nbsp;원</p>
            <li><button id="btn_purchase" class="btn btn-secondary" style="margin-left: 10px;">구매하기</button></li>
          </div>
        </div>
      </div>
    </div>
  </section>
  <footer>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_footer.php" ?>
  </footer>
</body>

</html>