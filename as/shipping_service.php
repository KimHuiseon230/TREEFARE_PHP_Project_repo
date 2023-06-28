<style>
  #card-text {
    font-size: 0.8rem;
    /* 폰트 크기를 12rem으로 적용 */
  }

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
<div class="container mt-5 p-5" style="min-height: 100vh; overflow: auto;">
  <div class="container-fluid ">
    <h2 class="mt-4 mb-4"><strong>배송 서비스</strong></h2>
    <div class="row">
      <div class="col-md-7 mt-3 mb-3">
        <div class="ratio ratio-16x9">
          <iframe width="560" height="315" src="https://www.youtube.com/embed/kZjZS9Pj4As" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
      </div>
      <div class="col-md-5">
        <div class=" h-100">
          <div class="body">
            <p class="card-title mb-2 mt-2"><strong>더 낮은 가격으로 만나는 TREEFARE 배송 서비스</strong></p>
            <p id="card-text">온/오프라인, 구매 금액에 상관없이 언제 어디서나 더 쉽고 편하게 이용할 수 <br> 있는 TREEFARE의 배송/픽업 서비스로 여러분의 홈퍼니싱 생활이 더욱 즐거워집니다.</p>
          </div>
        </div>
      </div>
    </div>
  </div> <!-- container-fluid end -->
  <hr>
  <div class="container-fluid mt-5">
    <div class="row">
      <div class="row no-gutters">
        <div class="col-md-7 mt-3 mb-3">
          <div class="row m-auto h-100"> <!-- 요소 높이를 100%로 설정 -->
            <div class="col-md-12  py-4 mb-2">
              <h3><strong>TREEFARE의 3단계 배송 & 픽업 서비스</strong></h3>
              <p>가구 배송과 픽업 서비스, 택배 배송 요금의 구매 금액 조건이 없어지고 더욱 낮아졌어요. 온/오프라인 구분없이, 필요에 따라쉽고 편하게 배송 옵션을 선택하여 이용해 보세요.</p>
              <ul>
                <strong>
                  <li>택배 배송 : 3,000원부터~</li>
                  <li> 픽업 서비스 : 9,000원</li>
                  <li> 가구 배송 : 29,000원부터~</li>
                </strong>
              </ul>
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-3 py-4 h-100"> <!-- 요소 높이를 100%로 설정 -->
          <h5>오른쪽 영역</h5>
          <p>오른쪽 영역에서는 추가적인 내용이 위치할 수 있습니다.</p>
        </div>
      </div>
    </div>
  </div>
  <hr>
  <div class="container justify-content-around mt-5 mb-5">
    <div class="row">
      <div class="card m-3 " style="width: 23rem;">
        <img src="http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/images/main_ad_img1.jpg' ?>" class="card-img-top" alt="..." style="margin-top: 15px;">
        <div class="card-body">
          <p>￦<strong class="card-text text-lg-center text-blue" id="strong_card-text">&nbsp;3,000~</strong>
          </p>
        </div>
      </div>
      <div class="card m-3 " style="width: 23rem;">
        <img src="http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/images/main_ad_img2.jpg' ?>" class="card-img-top" alt="..." style="margin-top: 15px;">
        <div class="card-body">
          <p>￦<strong class="card-text text-lg-center text-blue" id="strong_card-text">&nbsp;9,000~</strong>
        </div>
      </div>
      <div class="card m-3 " style="width: 23rem;">
        <img src="http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/images/main_ad_img3.jpg' ?>" class="card-img-top" alt="..." style="margin-top: 15px;">
        <div class="card-body">
          <p>￦<strong class="card-text text-lg-center text-blue" id="strong_card-text">&nbsp;29,000~</strong>
        </div>
      </div>
    </div>
  </div>
  <hr>
  <div class="container justify-content-around mt-5 mb-5">
    <div class="row">
      <div class="col m-auto">
        <div class="">
          <h3>TREEFARE 가구 배송비는 29,000원부터</h3>
          <p>구매 금액 관계 없이, 온/오프라인 어디서나 더 가벼워진 가격으로 TREEFARE 가구를 편하게 배송 받으실 수 있습니다</p>
          <strong>
            <p>1. 서울, 경기, 인천, 부산 지역 배송 시 29,000원<br />(일부 경기 지역 제외 : 여주, 양평, 가평, 안성, 이천, 연천, 포천)</p>
            <p>2. 기본 요금 지역 외 모든 지역(제주도 제외) 배송 시 39,000원<br /> (제주도 지역 가구 배송비 : 150,000원)</p>
          </strong>
          <p>* 주문 부피 5㎥ (양문형 냉장고 2개 반 부피)까지 해당 요금으로 배송 가능합니다.<br /> * 엘리베이터가 없는 4층 이상 건물의 경우, 사다리차 서비스(약 9만원)가 필요합니다. 배송 신청 후 24시간 내에 TREEFARE 고객지원센터 (1670-4532)를 통해 신청해주세요.</p>
        </div>
      </div>
      <div class="col-md-auto m-auto justify-content-around">
        <div class="">
          <img src="../images/main_ad_img4.png" class="card-img-center" alt="..." style="height: 280px;">
        </div>
      </div>
    </div>
  </div> <!-- container-fluid end -->
  <hr>
  <div class="container justify-content-around mt-5">
    <div class="row" style="border: 1px black;">
      <div class="card m-auto  " style="width: 24rem;">
        <img src="../images/main_ad_img5.png" class="card-img-top " alt="..." style="margin-top: 15px;">
        <div class="card-body">
          <strong>3,000원</strong>
          <p>
          <ul>
            <li>주문의 가로, 세로, 높이 합: 80cm 미만</li>
            <li> 포장 후 최대 길이: 80cm 미만</li>
            <li> 포장 후 총 무게: 2kg 미만</li>
            <li> 예시 제품: LILLNAGGEN 릴나겐 유리닦이</li>
          </ul>
          </p>
        </div>
      </div>
      <div class="card m-auto  " style="width: 24rem;">
        <img src="../images/main_ad_img6.png" class="card-img-top" alt="..." style="margin-top: 15px;">
        <div class="card-body">
          <strong>5,000원</strong>
          <p>
          <ul>
            <li> 주문의 가로, 세로, 높이 합: 160cm 미만</li>
            <li> 포장 후 최대 길이: 100cm 미만</li>
            <li> 포장 후 총 무게: 25kg 미만</li>
            <li> 예시 제품: DUKTIG 둑티그 주방놀이세트</li>
          </ul>
          </p>
        </div>
      </div>
      <div class="card m-auto  " style="width: 24rem;">
        <img src="../images/main_ad_img7.png" class="card-img-top" alt="..." style="margin-top: 15px;">
        <div class="card-body">
          <strong>8,000원</strong>
          <p>
            <li> 주문의 가로, 세로, 높이 합: 220cm 미만</li>
            <li> 포장 후 최대 길이: 140cm 미만</li>
            <li> 포장 후 총 무게: 25kg 미만</li>
            <li> 예시 제품: HUGAD 후가드 커튼봉</li>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- 메인부분 종료 -->

<!-- 푸터부분 시작 -->
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_footer.php"
?>