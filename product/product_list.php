<!DOCTYPE html>
<html lang="ko" dir="ltr">
<?php
session_start();
$ses_level = (isset($_SESSION['ses_level']) && $_SESSION['ses_level'] != '') ? $_SESSION['ses_level'] : '';

// 공통적으로 처리하는 부분
$js_array = ['js/product.js'];
$title = "상품";
$menu_code = "product";
?>

<head>
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/php_treefare/product/css/product.css?v=<?= date('Ymdhis') ?>">
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
    include $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/page_lib.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/create_table.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/product.php";
    $product = new Product($conn);
    create_table($conn, "product");

    $kind = (isset($_GET['value']) && $_GET['value'] != '') ? $_GET['value'] : '0';

    ?>
    <section>
      <div class="wrap">
        <!-- 카테고리 -->
        <h3 class="title" id="search_all">카테고리 </h3>
        <div id="job_box">
          <div class="col_box" id="kind_0">
            <button>
              <img src="./img/0.png" alt="기타">
              <span>전체</span>
            </button>
          </div>
          <div class="col_box" id="kind_1">
            <button>
              <img src="./img/1.png" alt="책상">
              <span>책상</span>
            </button>
          </div>

          <div class="col_box" id="kind_2">
            <button>
              <img src="./img/2.png" alt="의자">
              <span>의자</span>
            </button>
          </div>
          <div class="col_box" id="kind_3">
            <button>
              <img src="./img/3.png" alt="쇼파">
              <span>쇼파</span>
            </button>
          </div>
          <div class="col_box" id="kind_4">
            <button>
              <img src="./img/4.png" alt="침대">
              <span>침대</span>
            </button>
          </div>
          <div class="col_box" id="kind_5">
            <button>
              <img src="./img/5.png" alt="식탁">
              <span>식탁</span>
            </button>
          </div>
          <div class="col_box" id="kind_6">
            <button>
              <img src="./img/6.png" alt="서랍장">
              <span>서랍장</span>
            </button>
          </div>
          <div class="col_box" id="kind_7">
            <button>
              <img src="./img/7.png" alt="장롱">
              <span>장롱</span>
            </button>
          </div>

        </div>
        <h3 class="title" id="sh_text"><span id="search_ico"></span></h3>

        <!-- 전체상품 -->
        <div class="products">
          <h2>our All products</h2>
          <?php



          // product 데이터 가져오기
          $rowArray = $product->page_limit($kind);

          foreach ($rowArray as $row) {
            // 하나의 레코드 가져오기
            $num = $row["num"];
            $name = $row["name"];
            $price = $row["price"];
            $sale = $row["sale"];
            $content = $row["content"];
            $file_name_0 = $row['file_name'];
            $file_copied_0 = $row['file_copied'];
            $file_type_0 = $row['file_type'];
            $regist_day = $row["regist_day"];
            $image_width = 370;
            $image_height = 300;
          ?>

            <div class="product-list">
              <a href="product_view.php?num=<?= $num ?>" class="product">
                <?php if (strpos($file_type_0, "image") !== false) echo "<img  class='hover:grow hover:shadow-lg' src='./data/$file_copied_0' 
                width='$image_width' height='$image_height'><br>";
                else echo "<img src='./data/interior3.jpg' width='$image_width' height='$image_height'><br>" ?>
                <div class="product-name">
                  <?= $name ?>
                </div>
                <div class="product-price"><?= $price ?></div>
                <div class="sale-price"><?= $sale ?></div>
              </a>
            <?php
          }
            ?>
            <div class="interest_insert">
              <span class="heart_img click_heart"></span>
              <input type="hidden" name="pick_job" value="'.$num.'">
            </div>
            <div class="clearfix"></div>
            </div>
        </div>


        <!-- 목록, 글쓰기 버튼(관리자만 가능)  -->
        <ul class="buttons">
          <li>
            <?php
            if ($ses_level == 10) {
            ?>
              <button class="btn btn-primary" onclick="location.href='product_form.php'">상품 추가하기</button>
            <?php
            }
            ?>
          </li>
        </ul>
    </section>
    <footer>
      <?php include $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_footer.php"; ?>
    </footer>
</body>

</html>