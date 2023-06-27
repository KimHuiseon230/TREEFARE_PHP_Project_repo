<?php
session_start();
$ses_level = (isset($_SESSION['ses_level']) && $_SESSION['ses_level'] != '') ? $_SESSION['ses_level'] : '';

//보안부분(세션등록, 체크할내용, GET, POST)
$title = "설치 서비스-TREEFARE";
$menu_code = "treefare";

//헤더부분 시작
if ($ses_level == 10) {
  include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_admin_header.php";
} else {
  include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_header.php";
}
?>

<!-- 메인부분 시작 -->
<div class="container my-4 mt-5" style="min-height: 100vh; overflow: auto;">
  <div class="container-fluid mt-5  mb-5">
    <h2 class="mt-4 mb-4"><strong>배송 서비스</strong></h2>
    <p>혼자서 설치할 수도 있지만, 유료 설치 서비스를 받을 수도 있어요. TREEFARE의 전문 협력업체가 제공하는 설치서비스를 통하여 시공에 소요되는 시간과 에너지를 아껴보세요. TREEFARE의 공식 설치서비스는 플랜에 따라 다양한 디자인을 구현하며 안전 규정을 준수하는 책임 시공을 보장합니다.</p>
  </div>
  <hr>
  <div class="container-fluid mt-5  mb-5">
    <h2 class="mt-4 mb-4"><strong>주방 설치 서비스</strong></h5>
      <p>주방 설치 서비스는 크게 캐비넷과 상판, 싱크대와 수전 설치 부분으로 나뉘어 설치 비용이 책정되며 조명과 벽선반 설치, 철거 등 고객의 요구 사항에 따라 추가 비용이 발생합니다. 미니주방의 경우에는 주방 갯수에 따라 설치 비용이 정해집니다.</p>
  </div>
  <hr>
  <div class="container-fluid mt-5 mb-5">
    <div class="row">
      <div class="col-md-6">
        <div class="body">
          <img src="../images/installation_service_img.jpg" alt="">
        </div>
      </div>
      <div class="col-md-6 ">
        <div class=" h-100">
          <h5><strong>서비스 가격</strong></h5>
          <ul>
            <li>METOD 메토드: 55,000원/캐비넷</li>
            <li>ENHET 엔헤트 및 KNOXHULT 크녹스훌트: 50,000원/캐비넷</li>
            <li>싱크대와 수전: 50,000원/세트</li>
            <li>상판: 15,000원/m</li>
            <li>미니주방(SUNNERSTA 순네르스타, ÄSPINGE 에스핑에, GRILLSKÄR 그릴셰르): 110,000원/개</li>
          </ul>
          <p>* 미니주방은 모듈에 따라 추가 요금이 발생할 수 있습니다.</p>
          <h5><strong>서비스 가능 지역</strong></h5>
          <ul>
            <li>서울 및 경기 수도권</li>
            <li>강원도: 원주, 춘천</li>
            <li>충청도: 청주, 충주, 천안, 아산</li>
            <li>경상도: 부산, 양산, 김해, 창원, 마산, 울산</li>
            <li>광주광역시, 대구광역시, 대전광역시, 세종특별시</li>
          </ul>
          <p>* 미니주방은 모듈에 따라 추가 요금이 발생할 수 있습니다.</p>
          <div>
            <h5><strong>서비스 신청 방법</strong></h5>
            <p>쉽고 편한 전화주문 1670-4532 헤이오더를 이용하거나 가까운 TREEFARE 매장의 직원에게 문의해주세요.</p>
            <p>*1670-4532 거신후 3번 > 2번 누르면 바로 연결됩니다. </p>
          </div>
        </div>
      </div>
    </div>
  </div><!-- 첫번째-->
  <hr>
  <div class="container-fluid mt-5   mb-5">
    <div class="row">
      <div class="col-md-6">
        <div class="body">
          <img src="../images/installation_service_img2.jpg" alt="">
        </div>
      </div>
      <div class="col-md-6 ">
        <div class=" h-100">
          <h5><strong>서비스 가격</strong></h5>
          <ul>
            <li>욕실 세트 설치 서비스: 75,000원/세트</li>
            <li>기본 세트: 수전, 세면기, 하부장, 다리</li>
            <li>기본 세트 설치시 무료(택1): 상부장, 키큰장, 욕실 거울, 샤워기, 액세서리 3개 (수건고리, 미니거울, 휴지걸이 등) </li>
            <li>기본 세트 외 추가: 25,000원/개</li>
          </ul>
          <ul>
            <li>샤워기 설치 서비스: 50,000원/개</li>
            <li>기존 샤워기 철거/수거</li>
            <li>신규 구매 샤워기 설치</li>
          </ul>
          <h5><strong>서비스 가능 지역</strong></h5>
          <ul>
            <li>서울 및 경기 수도권</li>
            <li>경상도: 부산, 양산, 김해, 창원, 마산, 울산</li>
          </ul>
          <div>
            <h5><strong>서비스 신청 방법</strong></h5>
            <p>쉽고 편한 전화주문 1670-4532 헤이오더를 이용하거나 가까운 TREEFARE 매장의 직원에게 문의해주세요.</p>
            <p>*1670-4532 거신후 3번 > 2번 누르면 바로 연결됩니다. </p>
          </div>
        </div>
      </div>
    </div><!-- 첫번째-->
  </div> <!-- container-fluid end -->
</div>
<!-- 메인부분 종료 -->
<!-- 푸터부분 시작 -->
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_footer.php"
?>