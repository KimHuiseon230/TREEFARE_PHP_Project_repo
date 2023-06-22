
<?php
include $_SERVER['DOCUMENT_ROOT']."/ilhase/common/lib/db_connector.php";

$mode = $_GET['mode'];

$num = $page = "";
if(isset($_GET['num'])){
  $num = $_GET['num'];
}

if(isset($_GET['page'])){
  $page = $_GET['page'];
}

// 제목 / 내용 / 첨부파일 폼

if($mode === 'update'){
  // 수정일 경우
  // 원래 글을 불러온다.
  $sql = "select * from notice where num = $num";
  $result = mysqli_query($conn,$sql);
  if (!$result) {
    die('Error: ' . mysqli_error($conn));
  }

  $row = mysqli_fetch_array($result);
  $subject = $row['subject'];
  $content = $row['content'];
  $file_name = $row['file_name'];
  $file_type = $row['file_type'];
  $file_copied = $row['file_copied'];
  $hit = $row['hit'];
  $regist_date = $row['regist_date'];

}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="http://<?= $_SERVER['HTTP_HOST'];?>/ilhase/admin/js/check_notification.js"></script>
    <script>
      function check_input() {
        const mode = '<?=$mode?>';
        const subject = document.getElementById('input_subject');
        const content = document.getElementById('textarea_content');
          if (!subject.value){
              alert("제목을 입력하세요!");
              document.write_notice.subject.focus();
              return;
          } else if (!content.value) {
              alert("내용을 입력하세요!");
              document.write_notice.content.focus();
              return;
          }

          if(mode === 'insert'){
            document.write_notice.action = 'dml_notice.php?mode=insert';
          } else if (mode === 'update'){
            document.write_notice.action = 'dml_notice.php?mode=update&num=<?=$num?>&page=<?=$page?>&del_file='+$("#del_file").val();
          }

          document.write_notice.submit();
       }
    </script>
    <link rel="icon" href="http://<?= $_SERVER['HTTP_HOST'];?>/ilhase/common/img/favicon.png" sizes="128x128">
    <title>일하세</title>
  </head>

  <body onload="get_unanswerd_questions();">
    <header>
        <?php include $_SERVER["DOCUMENT_ROOT"]."/ilhase/common/lib/header_admin.php";?>
        <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'];?>/ilhase/admin/css/plain_admin_header.css">
    </header>

    <div class="container">
        <h3 class="title">
          <?php
            if($mode === "insert"){
              echo "공지사항 > 작성";
            } else {
              echo "공지사항 > 수정";
            }
          ?>
        </h3>
  	    <form name="write_notice" method="post" action="" enctype="multipart/form-data">
            <ul id="write_notice">
              <li>
                <label for="input_subject">제목</label>
                <input id="input_subject" type="text" name="subject" value="<?php if($mode === "update") echo $subject;?>"></li>
              <li>
                <label for="textarea_content" style="vertical-align: top;">내용</label>
                <textarea id="textarea_content" name="content"><?php if($mode === "update") echo $content;?></textarea></li></li>
              <li>
                <div class="notice_file_view"><label for="upfile">파일 업로드</label>
                  <?php
                    if($mode=="insert"){
                      echo '<input type="file" name="upfile" >이미지(2MB)파일(0.5MB)';
                    }else{
                  ?>
                    <input type="file" name="upfile" onclick='document.getElementById("del_file").checked=true; document.getElementById("del_file").disabled=true'>
                 <?php
                    }
                  ?>
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <?php
                    if($mode=="update" && !empty($file_name)){
                      echo "$file_name 파일등록";
                      echo '<input type="checkbox" id="del_file" name="del_file" value="1">삭제';
                      echo '<div class="clear"></div>';
                    }
                  ?>
                </div>
              </li>
            </ul>

        </form>
      <!-- php로 mode 검사 해서 수정일 경우 제목,내용,파일 불러오기 -->
      <ul class="notice_buttons">
        <li><button class="list_button" type="button" onclick="check_input()">완료</button></li>
        <li>
          <?php
            if($mode === 'update'){
          ?>
            <button class="list_button" onclick="location.href='http://<?= $_SERVER['HTTP_HOST'];?>/ilhase/cs/notice.php?main=true'">취소</button></li>
          <?php
            } else {
          ?>
              <button class="list_button" onclick="history.go(-1);">취소</button></li>
              <li><button class="list_button" onclick="location.href='http://<?= $_SERVER['HTTP_HOST'];?>/ilhase/cs/notice.php?page=1'">목록</button></li>
          <?php
            }
          ?>
      </ul>
      </div> <!--End Of Content -->
      <?php include $_SERVER["DOCUMENT_ROOT"]."/ilhase/common/lib/footer.php";?>
      <link rel="stylesheet" href="./css/notice.css">
  </body>
</html>
