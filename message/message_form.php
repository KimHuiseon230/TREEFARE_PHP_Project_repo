<?php
session_start();
$ses_id = (isset($_SESSION['ses_id']) && $_SESSION['ses_id'] != '') ? $_SESSION['ses_id'] : '';
$ses_level = (isset($_SESSION['ses_level']) && $_SESSION['ses_level'] != '') ? $_SESSION['ses_level'] : '';
//보안부분(세션등록, 체크할내용, GET, POST)
if ($ses_id == '') {
  die("
  <script>
    alert('로그인 후 접근이 가능한 페이지 입니다.')
    self.location.href = 'http://" . $_SERVER['HTTP_HOST'] . "/php_treefare/index.php';
  </script>");
}
//공통적으로 처리하는 부분
$css_array = ['css/message.css'];
$js_array = ['/js/message.js'];
$title = "쪽지 작성";
$menu_code = "message";

//헤더부분 시작
if ($ses_level == 10) {
  include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_admin_header.php";
} else {
  include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_header.php";
}
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/db_connect.php";
include $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/create_table.php";
create_table($conn, "message");
$ses_id = (isset($_SESSION['ses_id']) && $_SESSION['ses_id'] != '') ? $_SESSION['ses_id'] : '';

?>
<!-- 메인부분 시작 -->
<section class="p-5" style="height: calc(100vh - 280px);">
  <?php
  if (!$ses_id) {
    die("<script>
              alert('로그인 후 이용해주세요!');
              self.location.href = 'http://{$_SERVER['HTTP_HOST']}/php_treefare/login/login_form.php';
              </script>
          ");
  }
  ?>
  <div id="message_box">
    <h3 id="write_title">
      쪽지 보내기
    </h3>
    <ul class="top_buttons">
      <li><span><a href="message_box.php?mode=rv">수신 쪽지함 </a></span></li>
      <li><span><a href="message_box.php?mode=send">송신 쪽지함</a></span></li>
    </ul>
    <form name="message_form" method="post" action="./message_insert.php" autocomplete="off">
      <input type="hidden" name="send_id" value="<?= $ses_id ?>">
      <div id="write_msg">
        <ul>
          <li>
            <span class="col1">보내는 사람 : </span>
            <span class="col2"><?= $ses_id ?></span>
          </li>
          <li>
            <span class="col1">수신 아이디 : </span>
            <?php
            if ($ses_level == 10) {
            ?>
              <span class="col2"><input name="rv_id" type="text"></span>
            <?php
            } else {
            ?>
              <span class="col2"><input name="rv_id" type="text" value="admin01" readonly></span>
            <?php
            }
            ?>
          </li>
          <li>
            <span class="col1">제목 : </span>
            <span class="col2"><input name="subject" type="text"></span>
          </li>
          <li id="text_area">
            <span class="col1">내용 : </span>
            <span class="col2">
              <textarea name="content"></textarea>
            </span>
          </li>
        </ul>
        <button type="button" class="btn btn-secondary btn-sm" id="message_send">보내기</button>
      </div>
    </form>
  </div> <!-- message_box -->
</section>
<!-- 메인부분 종료 -->

<!-- 푸터부분 시작 -->
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_footer.php"
?>