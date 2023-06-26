<?php
//보안부분(세션등록, 체크할내용, GET, POST)

// 공통적으로 처리하는 부분
$js_array = ['/js/login_form.js'];
$title = "로그인";
$menu_code = "login";

//헤더부분 시작
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_header.php"
?>

<!-- 메인부분 시작 -->
<div class="container mt-5 p-5">
  <main class="w-50 p-5 border rounded-5 mx-auto" style="height: calc(100vh - 260px);">
    <form name="input_form" class="w-50 mx-auto" method="post" action="" autocomplete="off">

      <div class="d-flex justify-content-center">
        <i class="fa-solid fa-user mt-2 me-2" id="icon" style="font-size: 2rem; color: #F29727"></i>
        <h1>로그인</h1>
      </div>

      <div class="form-floating mt-3">
        <input type="text" class="form-control" id="form_id" placeholder="아이디 입력">
        <label for="form_id">아이디</label>
      </div>
      <div class="form-floating mt-3">
        <input type="password" class="form-control" id="form_pw" placeholder="비밀번호 입력">
        <label for="form_pw">비밀번호</label>
      </div>

      <button type="button" class="btn btn-primary w-100 mt-5 btn-lg" id="btn_login" onkeyup="enterkey();">로그인</button>

    </form>
  </main>
</div>
<!-- 메인부분 종료 -->

<!-- 푸터부분 시작 -->
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_footer.php"
?>