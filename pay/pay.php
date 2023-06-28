<!DOCTYPE html>
<html lang="en">
<?php
session_start();
$ses_level = (isset($_SESSION['ses_level']) && $_SESSION['ses_level'] != '') ? $_SESSION['ses_level'] : '';
$js_array = ['/pay/js/main_slide2.js', '/js/pay.js'];
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
        </form>
      </main>
    </div>
    <div class="container" style="margin-top: 50px">
      <div class="container border rounded-5 p-5 " style="width: 1000px;">
        <main class="p-5 border rounded-5" style="font-size: 20px;">
          <h1 class="text-center">결제수단 선택</h1>
          <input type="radio" checked name="pay"><span style="vertical-align: middle;">&nbsp;&nbsp;계좌 간편결제</span></input><br>
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
            <input type="radio" name="pay"><span style="vertical-align: middle;">&nbsp;&nbsp;카카오페이</span><img src="./img/kakaopay.png" style="margin-left: 5px;"></input><br>
            <input type="radio" name="pay"><span style="vertical-align: middle;">&nbsp;&nbsp;페이코</span><img src="./img/payco.png" style="margin-left: 5px; width: 25px; height:25px;"></input><br>
            <input type="radio" name="pay"><span style="vertical-align: middle;">&nbsp;&nbsp;트리페어페이</span><img src="./img/npay.png" style="margin-left: 5px; width: 60px; height:23px;"></input><br>
            <input type="radio" name="pay"><span style="vertical-align: middle;">&nbsp;&nbsp;토스</span><img src="./img/toss.png" style="margin-left: 5px; width: 60px; height:25px;"></input><br>
            <div class="d-flex gap-2">
              <div>
                <input type="radio" name="pay"><span style="vertical-align: middle;">&nbsp;&nbsp;무통장입금</span></input>
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
    <div class="container" style="margin-top: 50px; margin-bottom: 30px;">
      <div class="container border rounded-5 p-5 " style="width: 1000px;">
        <main class="p-5 border rounded-5">
          <h1 class="text-center">결제 이용약관 동의</h1>
          <h4 class="mt-3">이용약관</h4>
          <textarea name="stipulation_1" cols="20" rows="5" class="form-control">
          트리페어페이 이용약관제 1 장 트리페어페이 서비스제 1 조 (목적)이 약관은 트리페어파이낸셜(주)(이하 "회사")가 제공하는 트리페어페이 서비스의 이용과 관련하여 회사와 회원과의 권리, 의무 및 책임사항, 기타 필요한 사항을 규정함을 목적으로 합니다.제 2 조 (용어의 정의)① 이 약관에서 사용하는 용어의 의미는 다음과 같습니다.1. "트리페어페이 서비스"라 함은 가맹점회원이 운영하는 가게나 웹사이트(이하 "쇼핑몰"), 판매회원이운영하는 웹사이트(이하 "스마트스토어"), 트리페어 유료 서비스 또는 트리페어페이 안전결제가 제공되는 제휴업체에서 이용회원이 재화 또는 용역 등(이하 "상품")을 구입하는 경우(이하 "구매") 및 이용회원의 트리페어 아이디로 상품을 거래・결제하는 경우에 이를 용이하게 할 수 있도록 회사가 각 제공하는 통신판매 또는 통신판매중개서비스, 결제서비스, 전자지급결제대행서비스 및 결제대금 보호서비스, 송금 서비스, 통합조회서비스를 총칭합니다.2. "회원"이라 함은 다음 각 목의 자를 말하며, 가맹점회원과 판매회원을 통칭하여 "판매자회원"이라 합니다.가. 이용회원: 이 약관 제6조에 따라 회사와 이용계약을 체결하여 회사가 제공하는 트리페어페이 서비스를 이용하는 자나. 가맹점회원: 트리페어페이 가맹점 이용약관 또는 가맹계약(약관)에 따라 회사와 이용계약을 체결하여 트리페어페이 서비스를 통하여 이용회원과 상품을 거래하는 쇼핑몰 운영 사업자다. 판매회원: 스마트스토어 판매이용약관에 따라 회사와 이용계약을 체결하여 트리페어페이 서비스를 이용해 스마트스토어 내에서 상품을 판매하는 자라. 안전결제 판매회원: 회사에서 정한 본인인증 절차를 완료한 후 트리페어 주식회사의 블로그나 카페 서비스 내에서 혹은 회사와 제휴된 타 사이트에서 물품을 판매하는 이용회원을 말합니다.3. "트리페어 유료 서비스"라 함은 트리페어페이 서비스를 통해 유료로 이용 가능한 트리페어가 제공하는각종 온라인 디지털콘텐츠 및 제반 서비스를 말합니다.4. "결제대금 보호서비스"란 트리페어페이 서비스에서 이용회원이 결제한 결제대금의 보호를 위하여회사가 일정 기간 동안 결제대금을 예치하고 배송이 완료되는 등 구매가 확정된 후 상품 대금을판매자회원에게 지급하는 서비스를 말합니다.5. "트리페어페이 안전결제"라 함은 안전결제 판매회원으로부터 상품을 구매한 이용회원이 트리페어페이 서비스를 이용해 결제를 할 경우 제공되는 결제대금 보호서비스를 말합니다.6. "트리페어페이 사용처"라 함은 트리페어페이 서비스를 이용하여 상품의 결제, 트리페어페이 포인트의적립이 가능한 사용처를 말합니다.7. "수취인"이라 함은 상품을 실제로 수신자를 말하며, 이용회원과 동일인이거나 다른 사람일 수 있습니다.
      </textarea>
          <div class="form-check mt-1 d-flex justify-content-end">
            <input class="form-check-input" type="checkbox" value="" id="chk_member1">
            <label class="form-check-label" for="chk_member1">
              위 약관에 동의합니다.
            </label>
          </div>
          <h4 class="mt-3 ">전자금융거래약관</h4>
          <textarea name="stipulation_2" cols="20" rows="5" class="form-control">
          전자금융거래약관제 1 장 총칙제 1 조 (목적)본 약관은 트리페어파이낸셜(주)(이하 "회사"라 합니다)가 제공하는 직불전자지급수단의 발행 및 관리서비스, 선불전자지급수단의 발행 및 관리서비스, 전자지급결제대행서비스, 결제대금예치서비스 및전자고지결제서비스(이하 통칭하여 "전자금융거래서비스"라 합니다)를 "회원"이 이용함에 있어, "회사"와 "회원" 간 권리, 의무 및 "회원"의 서비스 이용절차 등에 관한 사항을 규정하는 것을 그 목적으로 합니다.제 2 조 (용어의 정의)① 본 약관에서 정한 용어의 정의는 아래와 같습니다.1. "전자금융거래"라 함은 "회사"가 "전자적 장치"를 통하여 전자금융업무를 제공하고, " 회원"이 "회사"의 종사자와 직접 대면하거나 의사소통을 하지 아니하고 자동화된 방식으로 이를 이용하는 거래를 말합니다.2. "전자지급거래"라 함은 자금을 주는 자가 "회사"로 하여금 전자지급수단을 이용하여 자금을 받는자에게 자금을 이동하게 하는 "전자금융거래"를 말합니다.3. "전자적 장치"라 함은 "전자금융거래"정보를 전자적 방법으로 전송하거나 처리하는 데 이용되는장치로서 현금자동지급기, 자동입출금기, 지급용단말기, 컴퓨터, 전화기 그 밖에 전자적 방법으로정보를 전송하거나 처리하는 장치를 말합니다.4. " 접근매체"라 함은 "전자금융거래"에 있어서 "거래지시"를 하거나 이용자 및 거래내용의 진실성과 정확성을 확보하기 위하여 사용되는 수단 또는 정보로서 "전자금융거래서비스"를 이용하기 위하여 "회사"에 등록된 아이디 및 비밀번호, 기타 "회사"가 지정한 수단을 말합니다.5. "아이디"란 "회원"의 식별과 서비스 이용을 위하여 "회원"이 설정하고 "회사"가 승인한 숫자와 문자의 조합을 말합니다.6. "비밀번호"라 함은 "회원"의 동일성 식별과 "회원" 정보의 보호를 위하여 "회원"이 설정하고 "회사"가 승인한 숫자와 문자의 조합을 말합니다.7. "회원"이라 함은 본 약관에 동의하고 본 약관에 따라 "회사"가 제공하는 "전자금융거래서비스"를이용하는 자를 말합니다.8. "거래지시"라 함은 "회원"이 본 약관에 따라 "회사"에게 "전자금융거래"의 처리를 지시하는 것을말합니다.9. "오류"라 함은 "회원"의 고의 또는 과실 없이 "전자금융거래"가 본 약관 또는 "회원"의 "거래지시"에 따라 이행되지 아니한 경우를 말합니다.② 본 조 및 본 약관의 다른 조항에서 정의한 것을 제외하고는 전자금융거래법 등 관련 법령에 정한 바에 따릅니다
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