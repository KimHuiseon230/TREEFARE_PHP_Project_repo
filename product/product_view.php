<!DOCTYPE html>
<html lang="en">

<?php
session_start();
$ses_level = (isset($_SESSION['ses_level']) && $_SESSION['ses_level'] != '') ? $_SESSION['ses_level'] : '';

$js_array = ['js/product_view.js'];
?>

<head>
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/php_treefare/product/css/product_view.css?v=<?= date('Ymdhis') ?>">
</head>

<body>
  <header>
    <?php
    if ($ses_level == 10) {
      include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_admin_header.php";
    } else {
      include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_header.php";
    }
    include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/db_connect.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/product.php";
    $product = new Product($conn);
    ?>
  </header>
  <section>
    <div class="main_content">
      <div class="center">
        <div class="center2">
          <div class="shop_top">
            <p> </p>
          </div>
          <?php

          $num = $_GET["num"];
          $page = $_GET["page"];

          $row = $product->find_of_num2($num);
          $num = $row["num"];
          $name = $row["name"];
          $kind = $row["kind"];
          $price = $row["price"];
          $sale = $row["sale"];
          $content = $row["content"];
          $file_name_0 = $row['file_name'];
          $file_copied_0 = $row['file_copied'];
          $file_type_0 = $row['file_type'];
          $regist_day = $row["regist_day"];


          $content = str_replace(" ", "&nbsp;", $content);
          $content = str_replace("\n", "<br>", $content);


          $file_name   = $row['file_name'];
          $file_copied = $row['file_copied'];
          $file_type   = $row['file_type'];
          $file_size   = 0;

          if (!empty($file_name)) {
            $image_info = getimagesize("./data/" . $file_copied);
            $image_width = $image_info[0];
            $image_height = $image_info[1];
            $image_type = $image_info[2];
            $image_width = 500;
            $image_height = 600;
            if ($image_width > 500) $image_width = 500;
          } else {
            echo "
              <script>
                alert('가져올 내용이 없습니다.');
                history.go(-1);
              </script>
            ";
          }
          ?>
          <div class="order">
            <div class="product" style="margin-top: 50px;">
              <div class="context">
                <?php
                if (strpos($file_type, "image") !== false) {
                  $file_size = filesize("./data/" . $file_copied);
                  $real_name = $file_copied;
                  echo "<img src='./data/$file_copied' width='$image_width' class='img'><br>";
                } else if ($file_name) {
                  $real_name = $file_copied;
                  $file_path = "./data/" . $real_name;
                  $file_size = filesize($file_path);
                }
                ?>
              </div>

              <form name="cart_form" action="../cart/cart_di.php" method="POST">
                <input type="hidden" name="mode" value="insert">
                <input type="hidden" name="file_name" value="<?= $file_name ?>">
                <input type="hidden" name="file_type" value="<?= $file_type ?>">
                <input type="hidden" name="file_copied" value="<?= $file_copied ?>">
                <input type="hidden" name="type" value="<?= $type ?>">
                <input type="hidden" name="name" value="<?= $name ?>">
                <input type="hidden" name="sale" value="<?= $sale ?>">
                <input type="hidden" name="content" value="<?= $content ?>">
                <ul id="view_shop">
                  <div class="info">
                    <div style="position:relative;">
                      <span class="aname" style="cursor:pointer;">[트리페어]</span>
                      <img style="height:17px; vertical-align:unset; margin-left:10px;" src='https://atimg.sonyunara.com/2022/view/today.gif'>
                    </div>
                    <h2 class="name">
                      <?= $name ?>
                    </h2>
                    <div class="price">
                      <div class="price-box">
                        </style>
                        <div>
                          <span class="sell"><strong style="font-size:25px; font-weight:900; color:#999999"><?= $price ?></strong></span>
                          <span class="sale"><strong style="font-size:25px; font-weight:900"><?= $sale ?></strong> 원</span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <a href="#" style="display:block; background:#ffefef; color:#ff9a95; text-align:center; padding:7px; letter-spacing: 1px; font-size:14px; font-weight: 400; margin-top: 20px">
                    사용 가능한 쿠폰 확인하기
                  </a>
                  <div style="border-top: 1px solid #e9e9e9; margin-bottom:16px;"></div>
                  <table class="list">
                    <colgroup>
                      <col style="width: 100px;">
                      <col>
                    </colgroup>
                    <tbody>
                      <tr class="bef">
                        <th scope="row">카드혜택</th>
                        <td>
                          <a href="#" style=" text-decoration: underline;color: #999999; margin:5px 0 ;">
                            무이자 혜택
                          </a>
                        </td>
                      </tr>

                      <!--//카드혜택-->
                      <tr class="bef">
                        <th scope="row">맴버쉽혜택</th>
                        <td>
                          <div class="benefit">
                            <div>
                              <a href="#">
                                등급별혜택보기
                              </a>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td colspan='2' height='10'></td>
                      </tr>
                    </tbody>
                  </table>
                  <div style="padding-top:27px; border-top: 1px solid #e9e9e9; margin-top:5px;"></div>
                  <table class="list">
                    <colgroup>
                      <col style="width: 100px;">
                      <col>
                    </colgroup>
                    <tbody>
                      <tr class="bef">
                        <th scope="row">배송구분</th>
                        <td>
                          <div class="benefit">
                            <div>
                              <a href="#">
                                8만원이상 구매시 <span style="color:#9265ee; font-style: oblique; font-weight:600; font-size:14px;">무료배송</span>
                              </a>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr class="bef">
                        <th scope="row">배송예상</th>
                        <td style="vertical-align: bottom; ">
                          <div class="todayDelivery">
                            <span>배송가능</span>
                            </a>
                          </div>
                        </td>
                      </tr>
                  </table>
                  <div style="padding-top:27px; border-top: 1px solid #e9e9e9; margin-top:5px;"></div>
                  <li class="options">
                    수량
                    <select name="count" id="select_count">
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                    </select>
                  </li>
                  <div class="d-flex justify-content-center ">
                    <li class="cart"><button class="green_button">장바구니</button></li>
                    <li class="cart"><button type="button" id="btn_buy" class="green_button">구매하기</button></li>
                  </div>
                </ul>
              </form>
              <form name="cart_form2" action="../cart/cart_di.php" method="POST">
                <input type="hidden" name="mode2" value="insert2">
                <input type="hidden" name="file_name" value="<?= $file_name ?>">
                <input type="hidden" name="file_type" value="<?= $file_type ?>">
                <input type="hidden" name="file_copied" value="<?= $file_copied ?>">
                <input type="hidden" name="type" value="<?= $type ?>">
                <input type="hidden" name="name" value="<?= $name ?>">
                <input type="hidden" name="sale" value="<?= $sale ?>">
                <input type="hidden" id="count" name="count" value="">
                <input type="hidden" name="content" value="<?= $content ?>">
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/product/product_detail.php"; ?>
  </section>
  <footer>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_footer.php" ?>
  </footer>
</body>

</html>