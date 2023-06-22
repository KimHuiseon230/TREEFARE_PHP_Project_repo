<?php
  session_start();
  include $_SERVER['DOCUMENT_ROOT']."/ilhase/common/lib/db_connector.php";

  if(isset($_SESSION['usermember_type'])){
    $member_type = $_SESSION['usermember_type'];
  } else {
    // 로그인하지 않은 경우
    echo "<script>
      alert('잘못된 접근입니다.');
      history.go(-1);
    </script>";
  }

  // 수정, 등록 구분
  $mode="";

  $num=$id=$subject=$content=$day=$hit="";
  $mode="insert";
  $num= $_GET['num'];

  $mode=$_GET["mode"];//$mode="update"or"response"
  $q_num = mysqli_real_escape_string($conn, $num);

  //update 이면 해당된글, response이면 부모의 해당된글을 가져옴.
  $sql="SELECT * from `qna` where num ='$q_num';";
  $result = mysqli_query($conn,$sql);
  if (!$result) {
    die('Error: ' . mysqli_error($conn));
  }
  $row=mysqli_fetch_array($result);

  $origin_content = explode("\n", $row['content'])[0];

  $subject= htmlspecialchars($row['subject']);
  $content= htmlspecialchars($row['content']);
  $subject=str_replace("\n", "<br>",$subject);
  $subject=str_replace(" ", "&nbsp;",$subject);
  $content=str_replace("\n", "<br>",$content);
  $content=str_replace(" ", "&nbsp;",$content);
  $day=$row['regist_date'];
  $hit=$row['hit'];
  if($mode == "response"){
    $subject="[re]".$subject;
    // $content="re>".$content;
    // $content=str_replace("<br>", "<br>▶",$content);
    $disabled="disabled";
  }
  mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="icon" href="http://<?= $_SERVER['HTTP_HOST'];?>/ilhase/common/img/favicon.png" sizes="128x128">
    <title>일하세</title>

    <script type="text/javascript">
      const mode = '<?=$mode?>';
      function check_input(){
        const subject = document.getElementById('input_subject');
        const content = document.getElementById('textarea_content');
          if (!subject.value){
              alert("제목을 입력하세요!");
              document.write_qna.subject.focus();
              return;
          } else if (!content.value) {
              alert("내용을 입력하세요!");
              document.write_qna.content.focus();
              return;
          }
          switch(mode){
            case 'response':
              console.log('<?=$origin_content?>');
              document.write_qna.action = "dml_qna.php?mode=r_insert&num=<?=$q_num?>&question=<?=$origin_content?>";
              break;

            case 'update':
              document.write_qna.action = "dml_qna.php?mode=update&num=<?=$q_num?>&hit=<?=$hit?>&m_type=<?=$member_type?>";
              break;
          }
          document.write_qna.submit();

      }
    </script>
  </head>
  <body>
    <header>

        <?php
          if($member_type !== 'admin'){
            // 회원일 경우
            include $_SERVER["DOCUMENT_ROOT"]."/ilhase/common/lib/header.php";
          } else {
            // 관리자일 경우
            include $_SERVER["DOCUMENT_ROOT"]."/ilhase/common/lib/header_admin.php";
        ?>
          <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'];?>/ilhase/admin/css/plain_admin_header.css">
        <?php
          }
        ?>
    </header>
      <div class="container">
      <h3 class="title">1 : 1 문의 > 댓글</h3>
      <form name="write_qna" action="dml_qna.php?mode=r_insert&num=<?=$q_num?>" method="post">
        <ul id="write_qna">
            <li>
              <label for="input_subject">제목</label>
              <input id="input_subject" type="text" name="subject" value="<?php if($mode !== 'insert') echo $subject;?>"></li>
            <li>
              <label for="textarea_content" style="vertical-align: top;">내용</label>
              <textarea id="textarea_content" name="content"><?php if($mode === 'update') echo $content;?></textarea></li></li>
        </ul>
      </form>

      <ul class="qna_buttons">
        <li><button class="list_button" type="button" onclick="check_input();">완 료</button></li>
        <li>
          <button class="list_button" onclick="location.href='qna_view.php?num=<?=$num?>&hit=<?=$hit?>'">취 소</button></li>
        </ul>
      </div> <!--End Of Content -->

    </div>
    <!-- Footer -->
    <?php include $_SERVER["DOCUMENT_ROOT"]."/ilhase/common/lib/footer.php";?>
    <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'];?>/ilhase/cs/css/notice.css">
    <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'];?>/ilhase/cs/css/qna.css">
  </body>
</html>
