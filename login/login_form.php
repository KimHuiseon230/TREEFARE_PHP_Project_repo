<?php
//보안부분(세션등록, 체크할내용, GET, POST)

// 공통적으로 처리하는 부분
$js_array = ['/js/login_form.js'];
$title = "로그인";
$menu_code = "login";

//헤더부분 시작
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_header.php"
?>

<head>
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/php_treefare/login/css/login_form.css?v=<?= date('Ymdhis') ?>">
</head>
<section class="login">
  <div class="login_box">
    <div class="left">
      <div class="contact">
        <form name="input_form" method="post" action="" autocomplete="off">
          <h3>SIGN IN</h3>
          <div class="form-floating mt-3">
            <input type="text" class="form-control" id="form_id" placeholder="아이디 입력">
            <label for="form_id">아이디</label>
          </div>
          <div class="form-floating mt-3">
            <input type="password" class="form-control" id="form_pw" placeholder="비밀번호 입력">
            <label for="form_pw">비밀번호</label>
          </div>
          <button type="button" class="btn btn-success w-100 mt-5 btn-lg" id="btn_login" onkeyup="enterkey();">로그인</button>
        </form>
      </div>
    </div>
    <div class="right">
      <div class="right-text">
        <!-- <h2>FREE FARE</h2>
        <h5>A UX BASED CREATIVE AGENCEY</h5> -->
      </div>
    </div>
  </div>
</section>s

<!-- 푸터부분 시작 -->
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_footer.php"
?>