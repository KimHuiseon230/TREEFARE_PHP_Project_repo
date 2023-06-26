<?php
// 공통적으로 처리하는 부분
$js_array = ['/js/notice_form.js'];
$title = "공지사항";
$menu_code = "notice";
?>

<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/php_treefare/image_board/css/board.css?v=<?= date('Ymdhis') ?>">
</head>

<body>
  <header>
    <?php
    include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_header.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/db_connect.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/create_table.php";
    create_table($conn, "notice");
    ?>
  </header>
  <section>
    <div id="board_box">
      <h3 id="board_title">
        공지사항 > 글 수정
      </h3>
      <?php
      $num = (isset($_GET["num"]) && $_GET["num"] != '') ? $_GET["num"] : '';
      $page = (isset($_GET["page"]) && $_GET["page"] != '') ? $_GET["page"] : '';

      if ($num == '' && $page == '') {
        die("
	          <script>
            alert('해당되는 정보가 없습니다.');
            history.go(-1)
            </script>           
            ");
      }


      $sql = "select * from notice where num=:num";
      $stmt = $conn->prepare($sql);
      $stmt->setFetchMode(PDO::FETCH_ASSOC);
      $stmt->bindParam(':num', $num);
      $stmt->execute();
      $row = $stmt->fetch();

      $subject    = $row["subject"];
      $content    = $row["content"];
      $file_name  = $row["file_name"];
      ?>
      <form name="notice_form" method="post" action="notice_modify.php?num=<?= $num ?>&page=<?= $page ?>" enctype="multipart/form-data">
        <ul id="notice_form">
          <li>
            <span class="col1">제목 : </span>
            <span class="col2"><input name="subject" type="text" value="<?= $subject ?>"></span>
          </li>
          <li id="text_area">
            <span class="col1">내용 : </span>
            <span class="col2">
              <textarea name="content"><?= $content ?></textarea>
            </span>
          </li>
          <li>
            <span class="col1"> 첨부 파일 :</span>
            <span class="col2"><?= $file_name ?></span>
          </li>
        </ul>
        <ul class="buttons">
          <li><button type="button" id="complete">수정하기</button></li>
          <li><button type="button" onclick="location.href='notice_list.php'">목록</button></li>
        </ul>
      </form>
    </div> <!-- board_box -->
  </section>
  <footer>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_footer.php" ?>
  </footer>
</body>

</html>