<?php
session_start();
$ses_level = (isset($_SESSION['ses_level']) && $_SESSION['ses_level'] != '') ? $_SESSION['ses_level'] : '';

//보안부분(세션등록, 체크할내용, GET, POST)
$title = "픽업 서비스-TREEFARE";
$menu_code = "treefare";
//헤더부분 시작
if ($ses_level == 10) {
  include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_admin_header.php";
} else {
  include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_header.php";
}
?>
<!-- 메인부분 시작 -->
<div class="container mt-5 p-5" style="min-height: 100vh; overflow: auto;">
  <div class="container-fluid mt-5  mb-5">
    <h2 class="mt-4 mb-4"><strong>클릭 앤 콜렉트</strong></h2>
    <div class="row">
      <div class="col-md-7">
        <div class="body">
          <div class="">
            <p>TREEFARE 매장이 멀리 있어도,​ 가까운 픽업 포인트에서 빠르고 편하게 직접 픽업할 수 있어요.</p>
            <p>클릭 앤 콜렉트 (Click and Collect)는 온라인에서 주문한 제품을 전국에 위치한
              <strong>31개의 픽업 포인트에서 9,000원</strong>의 배송비로 수령할 수 있는 서비스입니다.
            </p>
            <strong>
              <p> * 주소지에서 이용할 수 있는 픽업 포인트는 온라인 결제 단계에서 자동으로 확인할 수 있습니다.</p>
              <p> * 제주도 픽업 포인트로의 배송비는 29,000원입니다.</p>
            </strong>
          </div>
        </div>
      </div>
      <div class="col-md-5">
        <div>
          <img src="../images/click_pickup_img.png" alt="">
        </div>
      </div>
    </div>
  </div> <!-- container-fluid end -->
  <hr>
  <div class="container-fluid mt-5  mb-5">
    <h5><strong>9천원으로 배송받기 - 클릭 앤 콜렉트, 이렇게 이용해보세요.</strong></h5>
    <p>구매하실 제품을 장바구니에 담은 후 결제를 진행해 주세요. 등록한
      <strong>주소지 근처에 픽업 포인트가 있다면 결제단계에서 픽업 포인트 수령 옵션이 활성화</strong>됩니다.
    </p>
    <ul class="m-3">
      <li>1. 결제 단계에서 [픽업 포인트 수령]을 선택해주세요.</li>
      <li>2. 목록에서 원하는 픽업 장소를 선택해주세요.</li>
      <li>3. 지정된 날짜에 픽업 장소를 방문하여 제품을 수령하세요.</li>
    </ul>
  </div>
  <hr>
  <div class="container-fluid mt-5  mb-5">
    <h5><strong>픽업 포인트로 배송 가능한 제품을 살펴보세요.</strong></h5>
    <ul class="m-3">
      <li>
        <p><strong>최대 길이가 180cm를 넘지 않고 부피가 0.6CBM 미만, 무게가 100kg 이하인 크기의 가구 제품</strong>까지 배송이 가능해요.</p>
      </li>
      <li>
        <p><strong>택배 배송 제품 단독으로는 픽업 포인트로 배송할 수 없지만</strong>까지 배송이 가능해요.</p>
      </li>
      <li>
        <p>주문하실 제품이 싣고 이동할 차에 실리는 크기인지 꼭 확인해주세요. 패키지 크기는 상세 페이지에서 확인할 수 있어요.</p>
      </li>
    </ul>
  </div>
  <hr>
</div>
<!-- 메인부분 종료 -->
<!-- 푸터부분 시작 -->
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_footer.php"
?>