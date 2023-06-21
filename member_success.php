<?php
//보안부분(세션등록, 체크할내용, GET, POST)


// 공통적으로 처리하는 부분
$js_array = ['js/member_success.js'];
$title = "회원가입성공";
$menu_code = "member";

//헤더부분 시작
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc_header.php"
?>
<!-- 메인부분 시작 -->
<div class="container">
  <main class="w-75 d-flex p-5 border rounded-5 mx-auto gap-5" style="height: calc(100vh - 260px);">
    <i class="fa-solid fa-user me-2" id="icon" style="font-size: 100px; color: #F29727"></i>
    <div>
      <h3>회원가입을 축하드립니다.</h3>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Odit aliquid tempore magnam quo
        s fugiat assumenda debitis minima, harum repudiandae natus repellendus eveniet! Id esse officiis expedita,
        quia maiores nisi. Repellendus.</p>
      <button class="btn btn-primary" id="btn_login">로그인</button>
    </div>
  </main>
</div>
<!-- 메인부분 종료 -->

<?php
// 푸터부분 시작
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc_footer.php"
?>