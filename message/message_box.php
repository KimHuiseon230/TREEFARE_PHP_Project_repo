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
$title = "쪽지 목록";
$menu_code = "message";

//헤더부분 시작
if ($ses_level == 10) {
  include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_admin_header.php";
} else {
  include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_header.php";
}
?>
<!-- 메인부분 시작 -->
<section class="mb-5 p-5" style="height: calc(100vh - 330px);">
  <div id="message_box">
    <h3>
      <?php
      $page = (isset($_GET['page']) && $_GET["page"] != '') ? $_GET['page'] : 1;
      $mode = (isset($_GET['mode']) && $_GET["mode"] != '') ? $_GET['mode'] : '';

      if ($mode == "send")
        echo "송신 쪽지함 > 목록보기";
      else
        echo "수신 쪽지함 > 목록보기";
      ?>
    </h3>
    <div>
      <table id="message" class="table table-hover">
        <thead>
          <tr>
            <th class="col1">번호</th>
            <th class="col2">제목</th>
            <th class="col3"><?php
                              if ($mode == "send")
                                print "받은이";
                              else
                                print "보낸이";
                              ?></th>
            <th class="col4">등록일</th>
          </tr>
        </thead>
        <?php
        include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/db_connect.php";
        include $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/message_page_lib.php";
        include $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/create_table.php";
        ///create_table($conn, "message");
        include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/message.php";
        $message = new Message($conn);

        if ($mode == "send") {
          $row = $message->sel_cnt_message_id_chk($ses_id, $mode);
        } else {
          $row = $message->sel_cnt_message_id_chk($ses_id, $mode);
        }
        // 전체 글 수
        $total_record = $row['cnt'];
        $scale = 10;

        // 전체 페이지 수($total_page) 계산 
        if ($total_record % $scale == 0)
          $total_page = floor($total_record / $scale);
        else
          $total_page = floor($total_record / $scale) + 1;

        // 표시할 페이지($page)에 따라 $start 계산  
        $start = ($page - 1) * $scale;
        $number = $total_record - $start;

        if ($mode == "send")
          $rows = $message->sel_message_id_chk($ses_id,  $start, $scale, $mode);
        else
          $rows = $message->sel_message_id_chk($ses_id,  $start, $scale, $mode);

        foreach ($rows as $row) {
          // 하나의 레코드 가져오기
          $num         = $row["num"];
          $subject     = $row["subject"];
          $regist_day  = $row["regist_day"];

          if ($mode == "send")
            $msg_id = $row["rv_id"];
          else
            $msg_id = $row["send_id"];
          $record = $message->sel_member_id_info($msg_id);

          $msg_name = $record["name"];
        ?>
          <tbody class="table-group-divider">
            <tr>
              <th class="col1"><?= $number ?></th>
              <td class="col2"><a href="message_view.php?mode=<?= $mode ?>&num=<?= $num ?>"><?= $subject ?></a></td>
              <td class="col3"><?= $msg_name ?>(<?= $msg_id ?>)</td>
              <td class="col4"><?= $regist_day ?></td>
            </tr>
          </tbody>
        <?php
          $number--;
        }
        ?>
      </table>
      <ul id="page_num">
        <div class="container d-flex justify-content-center aling-items-start gap-3 mb-3">
          <?php
          $limit = 9;
          $page_limit = 9;
          echo  pagination($total_record, $limit, $page_limit, $page);
          ?>
      </ul> <!-- page -->
      <ul class="buttons">
        <li><button class="btn btn-sm btn-primary" onclick="location.href='message_box.php?mode=rv'">수신 쪽지함</button></li>
        <li><button class="btn btn-sm btn-primary" onclick="location.href='message_box.php?mode=send'">송신 쪽지함</button></li>
        <li><button class="btn btn-sm btn-primary" onclick="location.href='message_form.php'">쪽지 보내기</button></li>
      </ul>
    </div> <!-- message_box -->
</section>
<!-- 메인부분 종료 -->

<!-- 푸터부분 시작 -->
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_footer.php"
?>