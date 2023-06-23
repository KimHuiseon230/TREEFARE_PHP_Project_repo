<!DOCTYPE html>
<html lang="ko" dir="ltr">
<?php
// 공통적으로 처리하는 부분
$js_array = ['js/product.js'];
$title = "상품";
$menu_code = "product";
?>

<head>
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/php_treefare/product/css/product.css?v=<?= date('Ymdhis') ?>">
  <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
</head>

<body>
  <header>
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_header.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/db_connect.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/page_lib.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/create_table.php";
    create_table($conn, "product");
    ?>
    <section>
      <div class="wrap">
        <!-- 카테고리 -->
        <h3 class="title" id="search_all">카테고리 </h3>
        <?php

        $sql = "select * from `product` where kind=:kind";
        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->bindParam(':kind', $kind);
        $result = $stmt->execute();
        $row = $stmt->fetch();

        ?>
        <div id="job_box">
          <div class="col_box" id="kind_1">
            <button>
              <img src="./img/searchimg1.jpg" alt="책상">
              <span>책상</span>
            </button>
          </div>
          <div class="col_box" id="kind_2">
            <button>
              <img src="./img/searchimg2.jpg" alt="의자">
              <span>의자</span>
            </button>
          </div>
          <div class="col_box" id="kind_3">
            <button>
              <img src="./img/searchimg3.jpg" alt="쇼파">
              <span>쇼파</span>
            </button>
          </div>
          <div class="col_box" id="kind_4">
            <button>
              <img src="./img/searchimg4.jpg" alt="침대">
              <span>침대</span>
            </button>
          </div>
          <div class="col_box" id="kind_5">
            <button>
              <img src="./img/searchimg5.jpg" alt="식탁">
              <span>식탁</span>
            </button>
          </div>
          <div class="col_box" id="kind_6">
            <button>
              <img src="./img/searchimg9.jpg" alt="서랍장">
              <span>서랍장</span>
            </button>
          </div>
          <div class="col_box" id="kind_7">
            <button>
              <img src="./img/searchimg7.jpg" alt="장롱">
              <span>장롱</span>
            </button>
          </div>
          <div class="col_box" id="kind_9">
            <button>
              <img src="./img/searchimg8.jpg" alt="기타">
              <span>기타</span>
            </button>
          </div>
        </div>
        <h3 class="title" id="sh_text"><span id="search_ico"></span></h3>

        <!-- 전체상품 -->
        <div class="products">
          <h2>our All products</h2>
          <?php
          if (isset($_GET["page"]))
            $page = $_GET["page"];
          else
            $page = 1;

          $page = (isset($_GET["page"])  && $_GET["page"] != "") ? $_GET["page"] : 1;
          $sql = "select count(*) as cnt from `product` order by num desc";
          $stmt = $conn->prepare($sql);
          $stmt->setFetchMode(PDO::FETCH_ASSOC);
          $result = $stmt->execute();
          $row = $stmt->fetch();
          $total_record = $row['cnt'];
          $scale = 9;

          // 표시할 페이지($page)에 따라 $start 계산  
          $start = ($page - 1) * $scale;

          $number = $total_record - $start;
          $sql2 = "select * from  `product` order by num desc limit {$start}, {$scale}";
          $stmt2 = $conn->prepare($sql2);
          $stmt2->setFetchMode(PDO::FETCH_ASSOC);
          $result = $stmt2->execute();
          $rowArray = $stmt2->fetchAll();

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
              <a href="product_board_view.php?num=<?= $num ?>&page=<?= $page ?>" class="product">
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
            $number--;
          }
            ?>
            <div class="interest_insert">
              <span class="heart_img click_heart"></span>
              <input type="hidden" name="pick_job" value="'.$num.'">
            </div>
            <div class="clearfix"></div>
            </div>
        </div>

        <!-- 페이지네이션 -->
        <div class="container d-flex justify-content-center align-items-start mb-3 gap-3">
          <?php
          $set_page_limit = 5;
          echo pagination($total_record, $scale, $set_page_limit, $page);
          ?>
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