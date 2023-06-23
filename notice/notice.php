<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/db_connect.php";

define('SCALE', 10);
//*****************************************************
$sql = $result = $total_record = $total_page = $start = "";
$row = "";
$memo_content = "";
$total_record = 0;
//*****************************************************
// include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/db_connect.php";
// include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/notic.php";;
// if (isset($_GET["mode"]) && $_GET["mode"] == "search") {
//   //제목, 내용, 아이디
//   $find->$Notic->filter_data($_POST["find"]);
//   $search->$Notic->filter_data($_POST["search"]);
//   $q_search = mysqli_real_escape_string($conn, $search);
//   $sql = "SELECT * from `notice` where $find like '%$q_search%' order by num desc;";
// } else {
//   $sql = "SELECT * from `notice` order by num desc";
// }
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/db_connect.php";
include $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_header.php";
include $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/create_table.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/notice.php";
create_table($conn, "notice");
create_table($conn, "qna");
$notic = new Notic($conn);
$result = $notic->test();

// // $result = mysqli_query($conn, $sql);
// $total_record = mysqli_num_rows($result);

$total_page = ($total_record % SCALE == 0) ? ($total_record / SCALE) : (ceil($total_record / SCALE));

//2.페이지가 없으면 디폴트 페이지 1페이지
if (empty($_GET['page'])) {
  $page = 1;
} else {
  $page = $_GET['page'];
}

$start = ($page - 1) * SCALE;
$number = $total_record - $start;
?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">

<head>
  <meta charset="utf-8">
  <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST']; ?>/ilhase/member_page/common/css/notification.css">
  <script src="http://<?= $_SERVER['HTTP_HOST']; ?>/ilhase/admin/js/check_notification.js"></script>
  <title>일하세</title>
</head>

<body <?php
      if (isset($_SESSION['userid']) && $_SESSION['userid'] === 'admin') {
        echo "onload='get_unanswerd_questions();'";
        $user_id = $_SESSION['userid'];
      }
      ?>>
  <header>
    <?php
    if (isset($_SESSION['userid']) && $_SESSION['userid'] === 'admin') {
      include $_SERVER["DOCUMENT_ROOT"] . "/ilhase/common/lib/header_admin.php";
    ?>
      <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST']; ?>/ilhase/admin/css/plain_admin_header.css">
    <?php
    } else {
      include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_header.php";
    }
    ?>
  </header>
  <div class="container">
    <h2 class="title">공지사항</h2>
    <div id="list_top_title">

      <ul class="notice_list_menu">
        <li id="list_title1">번호</li>
        <li id="list_title2">제목</li>
        <li id="list_title3">날짜</li>
        <li id="list_title4">조회수</li>
      </ul>
    </div><!--end of list_top_title  -->

    <div id="list_content">

      <?php
      for ($i = $start; $i < $start + SCALE && $i < $total_record; $i++) {
        mysqli_data_seek($result, $i);
        $row = mysqli_fetch_array($result);
        $num = $row['num'];

        $hit = $row['hit'];
        $date = substr($row['regist_date'], 0, 10);
        $subject = $row['subject'];
        $subject = str_replace("\n", "<br>", $subject);
        $subject = str_replace(" ", "&nbsp;", $subject);
        exit;
      ?>
        <div class="list_item">
          <div class="list_item1"><?= $number ?></div>
          <div class="list_item2">
            <a href="./notice_view.php?num=<?= $num ?>&page=<?= $page ?>&hit=<?= $hit + 1 ?>"><?= $subject ?></a>
          </div>

          <div class="list_item3"><?= $date ?></div>
          <div class="list_item4"><?= $hit ?></div>
        </div><!--end of list_item -->
      <?php
        $number--;
      } //end of for
      ?>

      <div id="page_button">
        <div id="page_num">이전 ◂ &nbsp;&nbsp;&nbsp;
          <?php
          for ($i = 1; $i <= $total_page; $i++) {
            if ($page == $i) {
              echo "<b>&nbsp;$i&nbsp;</b>";
            } else {
              echo "<a href='./notice.php?page=$i'>&nbsp;$i&nbsp;</a>";
            }
          }
          ?>
          &nbsp;&nbsp;&nbsp;▸ 다음
        </div><!--end of page num -->
        <?php //세션 아이디가 admin일 경우만 수정 허용
        if (isset($_SESSION['userid']) && $_SESSION['userid'] === 'admin') {
        ?>
          <button id="btn_write_notice" onclick="location.href='write_notice_form.php?mode=insert';">글쓰기</button>
        <?php
        }
        ?>
      </div><!--end of button -->
    </div><!--end of page button -->
  </div><!--end of list content -->

  </div><!--end of content -->

  <!-- footer -->
  <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_footer.php"; ?>

  <link rel="stylesheet" href="./css/notice.css">
  <script>
    //nav active 활성화
    document.querySelectorAll('.nav-item').forEach(function(data, idx) {
      console.log(data, idx);
      data.classList.remove('active');

      if (idx === 3) {
        data.classList.add('active');
      }
    });
  </script>
</body>

</html>