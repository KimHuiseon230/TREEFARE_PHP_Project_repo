<style>
  #strong_card-text {
    font-size: 2rem;
    /* 폰트 크기를 12rem으로 적용 */
  }

  .text-blue {
    color: cornflowerblue;
    /* 글자 색을 파란색으로 적용 */
  }
</style>
<?php
session_start();
$ses_level = (isset($_SESSION['ses_level']) && $_SESSION['ses_level'] != '') ? $_SESSION['ses_level'] : '';

//보안부분(세션등록, 체크할내용, GET, POST)
$title = "배송 서비스-TREEFARE";
$menu_code = "treefare";

//헤더부분 시작
if ($ses_level == 10) {
  include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_admin_header.php";
} else {
  include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_header.php";
}
?>
<!-- 메인부분 시작 -->
<div class="container mt-5 p-5" style="min-height: 100vh;">
  <div class="container-fluid ">
    <h2 class="mt-4 mb-4"><strong>배송 서비스</strong></h2>
    <div class="row">
      <div class="col-md-7 mt-3 mb-3">
        <div class="ratio ratio-16x9">
          <iframe width="560" height="315" src="https://www.youtube.com/embed/kZjZS9Pj4As" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
      </div>
      <div class="col-md-5  mt-3">
        <div class=" h-100">
          <div class="body">
            <p id="card-text">
              꿈의 주방을 현실로 이루고 싶다면 TREEFARE 전문가와 함께 시작해보세요. 공간을 최적화하고 원하는 스타일과 일상에서 필요한 부분을 모두 충족시켜주는 주방을 만들 수 있을 거예요. 주방의 치수와 도면 또는 사진만 가져오세요. 수납장, 가전제품부터 수납공간, 조명과 싱크대 위치까지, 모든 부분에 대해 풍부한 아이디어와 기능적인 솔루션으로 도움을 드립니다.</p>
          </div>
        </div>
      </div>
    </div>
  </div> <!-- container-fluid end -->
  <hr>
  <div class="container-fluid mt-5 mb-5">
    <div class="row no-gutters">
      <div class="col  ">
        <h3><strong>어떤 방법이 편하세요?</strong></h3>
        <p>주방을 구매할 때는 단계별로 매장과 온라인에서 상담을 받으며 구매 결정을 내릴 수 있는 3단계 주방 서비스와
          상담부터 실측, 결제까지 한 번에 진행할 수 있는 원스톱 찾아가는 주방 서비스가 있어요.</p>
        </p>
      </div>
    </div>
  </div>
  <hr>
  <div class="container mt-5 mb-5 d-flex justify-content-center align-items-center" style="background-color: #47A992; height: 100px; color: white;">
    <h2 class="text-center">
      3단계 주방 서비스
    </h2>
  </div>
  <hr>
  <div class="container mt-5  mb-5 ">
    <div class="row">
      <div class="col-md-4">
        <div class="card" style="height:450px;">
          <div class="card-body p-4">
            <h5 class="card-title"><strong>1단계</strong></h5>
            <h5 class="card-title"><strong>주방 구매 상담</strong></h5><br>
            <p class="card-text">꿈에 그리던 주방을 구매하는 여정의 첫 단계, 구매 상담을 시작해보세요. 60분에 걸친 구매상담을 통하여 주방에 대한 1차 도면과 제품 및 설치 서비스에 대한 가견적을 받아보실 수 있습니다</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card" style="height:450px;">
          <div class="card-body p-4">
            <h5 class="card-title"><strong>2단계</strong> </h5>
            <h5 class="card-title"><strong>주방 실측 및 구매 상담</strong></h5><br>
            <p class="card-text">멋진 디자인은 정확한 실측에서부터 시작합니다. TREEFARE 공식 협력업체의 플래너가 고객님의 집을 방문하여 주방 현장에 대한 실측을 진행하고, 1단계에서 계획한 주방 디자인 및 도면을 완성합니다. </p>
            <p class="card-text">서비스 신청 방법: 서비스 신청은 가까운 TREEFARE 매장 주방 코너를 방문하시거나 TREEFARE 고객지원센터(1670-4532)로 연락해주세요. </p>
            <p class="card-text"><strong>서비스 요금</strong></p>
            <p class="card-text">₩120,000</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card" style="height:450px;">
          <div class="card-body p-4">
            <h5 class="card-title"><strong>3단계</strong></h5>
            <h5 class="card-title"><strong>결제상담 예약</strong></h5><br>
            <p class="card-text">주방 구매를 결정하셨다면 직원과의 결제 상담을 예약하세요. 주방 도면에 대한 최종 검토와 재고 확인 절차를 거쳐 주문서를 작성하고 결제를 진행합니다.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <hr>
  <div class="container mt-5 mb-5 d-flex justify-content-center align-items-center" style="background-color: #47A992; height: 100px; color: white;">
    <h2 class="text-center">
      <h2 class="text-center">
        원스톱 찾아가는 주방 서비스
      </h2>
  </div>
  <p>TREEFARE 직원과 공식 협력업체가 집을 직접 방문하여 주방 실측, 3D 도면 작업, 맞춤형 플래닝을 진행합니다. 현장에서 바로 디자인 및 견적 상담, 제품 구매까지 TREEFARE 주방 전문가가 도와드립니다.</p>
  <div>
    <h4> <strong>서비스 요금</strong></h4>
    <p> <strong> ₩120,000</strong>
      (실측 서비스 5만원 / 플래닝 서비스 7만원) </p>
    <p>
      *주방 도면의 제품 구매 시, 서비스 비용 120,000원을 기프트 카드로 환급해드립니다.</p>
  </div>
</div>
<!-- 메인부분 종료 -->

<!-- 푸터부분 시작 -->
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_footer.php"
?>