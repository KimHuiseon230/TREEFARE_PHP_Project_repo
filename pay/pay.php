<!DOCTYPE html>
<html lang="en">
<?php
session_start();
$ses_level = (isset($_SESSION['ses_level']) && $_SESSION['ses_level'] != '') ? $_SESSION['ses_level'] : '';
$js_array = ['/pay/js/main_slide2.js'];
?>

<head>
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/php_treefare/pay/css/pay.css?v=<?= date('Ymdhis') ?>">
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/php_treefare/pay/css/card_slide.css?v=<?= date('Ymdhis') ?>">
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
    include $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/create_table.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/cart.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/member.php";
    create_table($conn, "cart");
    $cart = new Cart($conn);
    $member = new Member($conn);

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
  $memArr = $member->getInfo($ses_id);
  ?>
  <section>
    <div class="main_content">
      <h2 class="main_text">ORDER</h2>
      <div class="blank"></div>
      <div class="center">
        <div class="container border rounded-5 p-5" style="width: 1000px;">
          <div class="cart_top">
            <h2>YOUR CART</h2>
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
              <form method="POST" class="item" action="../cart/cart_di.php">
                <input type="hidden" name="mode" value="delete2">
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
            <p><?= number_format($calculate) ?>&nbsp;원</p>
          </div>
        </div>
      </div>
    </div>

    <!-- 메인부분 시작 -->
    <div class="container">
      <main class=" p-5 border rounded-5 mx-auto" style="width: 1000px;">
        <h2 class="text-center">주문자 정보</h2>
        <form name="input_form" method="post" action="../pg/member_process.php" autocomplete="off" enctype="multipart/form-data">
          <input type="hidden" name="id_check" value="0">
          <input type="hidden" name="email_check" value="0">
          <input type="hidden" name="mode" value="input">

          <div class="d-flex align-items-end gap-3">
            <div class="w-50">
              <label for="form_id" class="form-label">아이디</label>
              <input type="text" name="id" class="form-control" id="form_id" value="<?= $id ?>" readonly>
            </div>

            <div class="w-50">
              <label for="form_name" class="form-label">이름</label>
              <input type="text" name="name" class="form-control" id="form_name" value="<?= $memArr['name'] ?>" readonly>
            </div>
          </div>

          <div class="mt-3 d-flex align-items-end gap-3">
            <div class="w-50">
              <label for="form_addr1" class="form-label">기본주소</label>
              <input type="text" name="addr1" class="form-control" id="form_addr1" value="<?= $memArr['addr1'] ?>">
            </div>
            <div class="w-50">
              <label for="form_addr2" class="form-label">상세주소</label>
              <input type="text" name="addr2" class="form-control" id="form_addr2" value="<?= $memArr['addr2'] ?>">
            </div>
          </div>
          <div class="mt-3 gap-3">
            <div>
              <label for="form_message" class="form-label">주문메세지<span>(100자내외)</span></label>
              <input type="text" name="message" class="form-control" id="message">
            </div>
          </div>
          <!-- <div class="mt-3 d-flex justify-content-center gap-3">
            <button type="button" class="btn btn-primary w-50" id="btn_submit">결제하기</button>
            <input type="reset" value="취소" class="btn btn-secondary w-50">
          </div> -->
        </form>
      </main>
    </div>
    <div class="container" style="margin-top: 50px">
      <div class="container border rounded-5 p-5 " style="width: 1000px;">
        <main class="p-5 border rounded-5" style="font-size: 20px;">
          <h1 class="text-center">결제수단 선택</h1>
          <input type="radio" checked><span style="vertical-align: middle;">&nbsp;&nbsp;계좌 간편결제</span></input><br>
          <div class="container">
            <div id="main_slide">
              <div class="image-slider">
                <div class="slide-wrapper">
                  <div class="slide">
                    <img src="http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/pay/img/card1.png"  ' ?>" alt="1">
                  </div>
                  <div class="slide">
                    <img src="http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/pay/img/card2.png"  ' ?>" alt="1">
                  </div>
                  <div class="slide">
                    <img src="http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/pay/img/card3.png"  ' ?>" alt="1">
                  </div>
                  <div class="slide">
                    <img src="http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/pay/img/card4.png"  ' ?>" alt="1">
                  </div>
                  <div class="slide">
                    <img src="http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/pay/img/card5.png"  ' ?>" alt="1">
                  </div>
                  <div class="slide">
                    <img src="http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/pay/img/card6.png"  ' ?>" alt="1">
                  </div>
                </div>
              </div>
            </div>
            <input type="radio"><span style="vertical-align: middle;">&nbsp;&nbsp;카카오페이</span><img src="./img/kakaopay.png" style="margin-left: 5px;"></input><br>
            <input type="radio"><span style="vertical-align: middle;">&nbsp;&nbsp;페이코</span><img src="./img/payco.png" style="margin-left: 5px; width: 25px; height:25px;"></input><br>
            <input type="radio"><span style="vertical-align: middle;">&nbsp;&nbsp;네이버페이</span><img src="./img/npay.png" style="margin-left: 5px; width: 60px; height:23px;"></input><br>
            <input type="radio"><span style="vertical-align: middle;">&nbsp;&nbsp;토스</span><img src="./img/toss.png" style="margin-left: 5px; width: 60px; height:25px;"></input><br>
            <div class="d-flex gap-2">
              <div>
                <input type="radio"><span style="vertical-align: middle;">&nbsp;&nbsp;무통장입금</span></input>
              </div>
              <div class="w-50">
                <input type="text" class="form-control d-flex w-50"></input>
              </div>
            </div>
          </div>
        </main>
      </div>
    </div>


    <!-- 결제 이용약관 -->
    <div class="container" style="margin-top: 50px">
      <div class="container border rounded-5 p-5 " style="width: 1000px;">
        <main class="p-5 border rounded-5">
          <h1 class="text-center">결제 이용약관 동의</h1>
          <h4 class="mt-3">이용약관</h4>
          <textarea name="stipulation_1" cols="20" rows="5" class="form-control">
        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ratione, ullam cupiditate? Natus mollitia voluptas dolorem accusantium, 
        cumque est amet repellendus fugit iure sint officiis culpa beatae. Quisquam deserunt excepturi sed possimus nulla aspernatur minus neque vel. 
        Illum fugiat ratione corporis deserunt voluptate laborum tenetur laudantium est beatae, expedita accusamus perspiciatis obcaecati amet rem quia, 
        quis enim modi quidem incidunt saepe recusandae minus, architecto fuga. Architecto dolor eum, a quam quae doloribus explicabo voluptate 
        soluta et accusantium nisi adipisci maxime iusto, tempora amet laboriosam sapiente corrupti est dolorem veniam. Maxime non sint tempora 
        voluptas eligendi ut recusandae, odio architecto esse ipsa? Tempora deleniti et voluptate cupiditate architecto, officiis eum explicabo possimus 
        culpa nam aperiam quae voluptates perferendis natus quam enim esse veritatis eius illum rem omnis.
      </textarea>
          <div class="form-check mt-1 d-flex justify-content-end">
            <input class="form-check-input" type="checkbox" value="" id="chk_member1">
            <label class="form-check-label" for="chk_member1">
              위 약관에 동의합니다.
            </label>
          </div>
          <h4 class="mt-3 ">개인정보 취급방침</h4>
          <textarea name="stipulation_2" cols="20" rows="5" class="form-control">
        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ratione, ullam cupiditate? Natus mollitia voluptas dolorem accusantium, 
        cumque est amet repellendus fugit iure sint officiis culpa beatae. Quisquam deserunt excepturi sed possimus nulla aspernatur minus neque vel. 
        Illum fugiat ratione corporis deserunt voluptate laborum tenetur laudantium est beatae, expedita accusamus perspiciatis obcaecati amet rem quia, 
        quis enim modi quidem incidunt saepe recusandae minus, architecto fuga. Architecto dolor eum, a quam quae doloribus explicabo voluptate 
        soluta et accusantium nisi adipisci maxime iusto, tempora amet laboriosam sapiente corrupti est dolorem veniam. Maxime non sint tempora 
        voluptas eligendi ut recusandae, odio architecto esse ipsa? Tempora deleniti et voluptate cupiditate architecto, officiis eum explicabo possimus 
        culpa nam aperiam quae voluptates perferendis natus quam enim esse veritatis eius illum rem omnis. 
      </textarea>
          <div class="form-check mt-1 d-flex justify-content-end">
            <input class="form-check-input" type="checkbox" value="" id="chk_member2">
            <label class="form-check-label" for="chk_member2">
              위 약관에 동의합니다.
            </label>
          </div>
          <div class="mt-4 d-flex justify-content-end gap-3">
            <button type="button" class="btn btn-primary w-50" id="btn_member">결제하기</button>
            <button type="button" class="btn btn-secondary w-50" id="btn_cancel">취소</button>
          </div>
          <form name="member_form" action="./member/member_input.php" method="post" style="display: none;">
            <input type="hidden" name="chk" value="0">
          </form>
        </main>
      </div> <!-- container div end -->
      <!-- 메인부분 종료 -->
  </section>
  <footer>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_footer.php" ?>
  </footer>
</body>

</html>