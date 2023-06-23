<?php
//보안부분(세션등록, 체크할내용, GET, POST)
if (!isset($_POST['chk']) || $_POST['chk'] != 1) {
  die("
<script>
  alert('약관동의 후 접근가능');
  self.location.href = './stipulation.php';
</script>");
}

// 공통적으로 처리하는 부분
$js_array = ['js/member_input.js'];
$title = "회원가입";
$menu_code = "member";

//헤더부분 시작
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_header.php"
?>
<!-- 메인부분 시작 -->

<!-- 메인부분 종료 -->

<!-- 푸터부분 시작 -->
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_footer.php"
?>