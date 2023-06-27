<?php
session_start();
$ses_level = (isset($_SESSION['ses_level']) && $_SESSION['ses_level'] != '') ? $_SESSION['ses_level'] : '';

//보안부분(세션등록, 체크할내용, GET, POST)
$title = "조립 서비스-TREEFARE";
$menu_code = "treefare";
//헤더부분 시작
if ($ses_level == 10) {
  include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_admin_header.php";
} else {
  include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_header.php";
}
?>
<!-- 메인부분 시작 -->
<div class="container my-4 mt-5 p-5" style="min-height: 100vh; overflow: auto;">
  <img src="../images/assembly_service_img.jpg" alt="">
  <h2 class="mt-4 mb-4"><strong>조립 서비스</strong></h2>
  <p>TREEFARE 제품은 고객이 직접 조립할 수 있도록 명확하게 디자인되어 있지만 도움이 필요한 경우 집이나 사무실에서 이용할 수 있도록 조립 서비스를 준비했습니다. TREEFARE에게 조립을 맡기고 소중한 시간을 아끼세요. 간단한 가구 조립부터 PAX 옷장 시스템 전체에 이르기까지 조립 서비스 신청이 가능합니다.
  </p>
  <hr>
  <div class="container-fluid mt-5  mb-5">
    <h3><strong>서비스 요금</strong></h3>
    <p>보다 합리적으로 변화된 조립 서비스를 만나보세요. 조립 비용은 <strong>제품의 조립 난이도 및 구성 요소에 따라 달라지며</strong> 가구 배송 서비스와 함께 이용 가능합니다.</p>
  </div>
  <hr>
  <div class="container-fluid mt-5  mb-5">
    <h3><strong>서비스 요금</strong></h3>
    <p>매장에서 주문시, 직원에게 문의하거나 TREEFARE 고객지원센터(1670-4532)를 통해 신청해주세요.</p>
    <p>온라인몰에서 주문시, TREEFARE 고객지원센터(1670-4532)로 24시간 이내 전화하거나 또는 주문내역 페이지에서 신청하실 수 있습니다.</p>
    <a href="../login/login_form.php"><button class="btn btn-primary">페이지 이동</button></a>
    </p>
  </div>
  <hr>
  <div class="container-fluid mt-5 mb-5">
    <h4><strong>서비스 이용 시 유의사항 </strong></h4>
    <ul class="m-3">
      <li>TREEFARE 조립 서비스는 TREEFARE의 파트너인 독립적인 조립 서비스 업체가 제공합니다.</li>
      <li>서비스 당일 현장 방문 이후 조립 불가능할 경우 또는 서비스 당일 고객 변심이나 부재로 인해 조립 취소되는 경우에는 조립 서비스 금액의 30% (최소 2만원) 취소 비용이 부과됩니다.</li>
      <li>조립서비스 진행시 제품사이즈의 2배정도의 공간이 필요합니다. 미리 공간 확보 부탁 드립니다.</li>
      <li>원포장 상태에서만 조립서비스 신청이 가능하며, 이미 배송이 완료된 제품의 경우 별도로 출장비가 부과됩니다.</li>
      <li>일부 주방 제품과 일부 욕실 제품은 조립서비스 신청이 불가합니다. </li>
      <li>알뜰코너 제품은 플랫팩 상태로 구매한 경우 조립 서비스 이용 가능합니다.</li>
      <li>홈퍼니싱 액세서리류는 조립서비스 제공이 어려우므로 신청 항목에서 제외될 수 있습니다.</li>
      <li>조립서비스 가능 지역과 제품 문의는 TREEFARE 고객지원센터 (1670-4532)로 연락 주시기 바랍니다.</li>
      <li>포장재는 환경친화적인 방식으로 처리합니다. </li>
      <li>원포장 상태에서만 조립서비스 신청이 가능하며, 이미 배송이 완료된 상태라면 별도로 출장비가 부과됩니다. </li>
      <li>일부 주방 및 욕실 제품은 조립서비스 신청이 불가합니다. </li>
    </ul>
  </div>
  <hr>
</div>
<!-- 메인부분 종료 -->
<!-- 푸터부분 시작 -->
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_footer.php"
?>