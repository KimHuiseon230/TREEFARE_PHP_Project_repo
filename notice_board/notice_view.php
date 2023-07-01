<!DOCTYPE html>
<html>
<?php
session_start();
$ses_level = (isset($_SESSION['ses_level']) && $_SESSION['ses_level'] != '') ? $_SESSION['ses_level'] : '';
// 공통적으로 처리하는 부분
// $js_array = ['/image_board/js/board.js'];
$title = "공지사항";
$menu_code = "notice";
?>

<head>
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/php_treefare/notice_board/css/board.css?v=<?= date('Ymdhis') ?>">
</head>

<body>
  <header>
    <?php
    if ($ses_level == 10) {
      include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_admin_header.php";
    } else {
      include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_header.php";
    }
    include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/db_connect.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/image_board.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/notice_board.php";
    $noticeboard = new NoticeBoard($conn);
    ?>
  </header>
  <section style="height: calc(100vh - 380px);">
    <div id="board_box" style="margin-top: 100px;">
      <h3 class="title">
        공지사항 > 내용보기
      </h3>
      <?php
      $num = (isset($_GET["num"]) && $_GET["num"] != '') ? $_GET["num"] : '';
      $page = (isset($_GET["page"]) && $_GET["page"] != '') ? $_GET["page"] : 1;

      if ($num == "") {
        die("
	        <script>
          alert('저장되는 정보가 없습니다.,');
          history.go(-1)
          </script>           
          ");
      }

      $row = $noticeboard->find_of_num2($num);
      $subject    = $row["subject"];
      $content    = $row["content"];
      $file_name    = $row["file_name"];
      $file_type    = $row["file_type"];
      $file_copied  = $row["file_copied"];
      $hit          = $row["hit"];
      $regist_date          = $row["regist_date"];
      $content = str_replace(" ", "&nbsp;", $content);
      $content = str_replace("\n", "<br>", $content);
      $new_hit = $hit + 1;

      $noticeboard->update_of_hit($new_hit, $num);
      ?>
      <ul id="view_content">
        <li>
          <span class="col1"><b>제목 :</b> <?= $subject ?></span>
          <span class="col2"><?= $regist_date ?></span>
        </li>
        <li>
          <?php
          if ($file_name) {
            $real_name = $file_copied;
            $file_path = "./data/" . $real_name;
            $file_size = filesize($file_path);

            echo "▷ 첨부파일 : $file_name ($file_size Byte) &nbsp;&nbsp;&nbsp;&nbsp;
			       		<a href='notice_download.php?num=$num&real_name=$real_name&file_name=$file_name&file_type=$file_type'>[저장]</a><br><br>";
          }
          ?>
          <?= $content ?>
        </li>
      </ul>
      <ul class="buttons">
        <li><button class="btn btn-primary" onclick="location.href='notice_list.php?page=<?= $page ?>'">목록</button></li>
      </ul>
    </div> <!-- board_box -->
  </section>
  <footer>
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_footer.php"; ?>
  </footer>
</body>

</html>