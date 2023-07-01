<?php
session_start();
$ses_id = (isset($_SESSION['ses_id']) && $_SESSION['ses_id'] != '') ? $_SESSION['ses_id'] : '';
$ses_name = (isset($_SESSION['ses_name']) && $_SESSION['ses_name'] != '') ? $_SESSION['ses_name'] : '';
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
$js_array = ['js/message.js'];
$css_array = ['css/message.css'];
$title = "쪽지 답장";
$menu_code = "message";

//헤더부분 시작
if ($ses_level == 10) {
  include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_admin_header.php";
} else {
  include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_header.php";
}
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/db_connect.php";
include $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/create_table.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/message.php";
$message = new Message($conn);
?>

<!-- 메인부분 시작 -->
<section class="p-5" style="height: calc(100vh - 280px);">
  <div id="message_box">
    <h3 id="write_title">
      답변 쪽지 보내기
    </h3>
    <?php
    $num = (isset($_GET['num']) && $_GET['num'] != '') ? $_GET['num'] : '';
    if ($num == "") {
      die("<script>
          alert('경고');
          history.go(-1);
          </script>
        ");
    }
    // +++++++ 함수 사용 +++++++
    $row = $message->sel_message_num($num);
    $send_id = $row["send_id"];
    $rv_id = $row["rv_id"];
    $subject = $row["subject"];
    $content = $row["content"];
    $subject = "RE: " . $subject;
    $content = "> " . $content;
    $content = str_replace("\n", "\n>", $content);
    $content = "\n\n\n-----------------------------------------------\n" . $content;
    // +++++++ 함수 사용 +++++++
    $record = $message->sel_name_member_id_chk($rv_id, $send_id);
    $send_name = $record["name"];
    ?>
    <form name="message_form" action="message_insert.php?send_id=<?= $ses_id ?>" method="post">
      <input type="hidden" name="rv_id" value="<?= $send_id ?>">
      <input type="hidden" name="send_id" value="<?= $rv_id ?>">
      <div id="write_msg">
        <ul>
          <li>
            <span class="col1">보내는 사람 : </span>
            <span class="col2"><?= $ses_id ?></span>
          </li>
          <li>
            <span class="col1">수신 아이디 : </span>
            <span class="col2"><?= $send_name ?>(<?= $send_id ?>)</span>
          </li>
          <li>
            <span class="col1">제목 : </span>
            <span class="col2"><input name="subject" type="text" value="<?= $subject ?>"></span>
          </li>
          <li id="text_area">
            <span class="col1">글 내용 : </span>
            <span class="col2">
              <textarea name="content"><?= $content ?></textarea>
            </span>
          </li>
        </ul>
        <button type="button" id="message_send">보내기</button>
      </div>
    </form>
  </div> <!-- message_box -->
</section>
<!-- 메인부분 종료 -->

<!-- 푸터부분 시작 -->
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_footer.php"
?>