<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."/ilhase/common/lib/db_connector.php";

if(isset($_SESSION['usermember_type'])){
  $member_type = $_SESSION['usermember_type'];
} else {
  // 로그인하지 않은 경우
  echo "<script>
    alert('잘못된 접근입니다.');
    location.href='http://".$_SERVER['HTTP_HOST']."/ilhase/index.php';
  </script>";
}

$num=$subject=$content=$regist_date=$hit="";

if(empty($_GET['page'])){
  $page=1;
}else{
  $page=$_GET['page'];
}

if(isset($_GET["num"])&&!empty($_GET["num"])){
    $num = filter_data($_GET["num"]);
    $hit = filter_data($_GET["hit"]);
    $q_num = mysqli_real_escape_string($conn, $num);

    $sql="UPDATE `qna` SET `hit`=$hit WHERE `num`=$q_num;";
    $result = mysqli_query($conn,$sql);
    if (!$result) {
      die('Error: ' . mysqli_error($conn));
    }

    $sql="SELECT * from `qna` where num ='$q_num';";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
      die('Error: ' . mysqli_error($conn));
    }
    $row=mysqli_fetch_array($result);

    $subject= htmlspecialchars($row['subject']);
    $content= htmlspecialchars($row['content']);
    $subject=str_replace("\n", "<br>",$subject);
    $subject=str_replace(" ", "&nbsp;",$subject);
    $content=str_replace("\n", "<br>",$content);
    $content=str_replace(" ", "&nbsp;",$content);
    $regist_date = $row['regist_date'];
    $depth = $row['depth'];
    $hit = $row['hit'];
    $writer = $row['id'];
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="icon" href="http://<?= $_SERVER['HTTP_HOST'];?>/ilhase/common/img/favicon.png" sizes="128x128">
    <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script>
      function get_unanswerd_questions(){
      $.get('../admin/dml_chart.php', {mode : 'questions_count'}, function(data){
          if(data != 0){
              $('.notification').show();
          } else {
            $('.notification').hide();
            console.log("get", data);
          }
        });
      } 
    </script>
    <title>일하세</title>
    <script>
      const member_type = '<?=$member_type?>';
      function confirm_to_delete(){
        const resopnse = confirm('해당 글을 삭제하시겠습니까?');

        if(!resopnse) return;

        if(member_type === 'admin'){
          location.href = "dml_qna.php?mode=delete&num=<?=$num?>&page=<?=$page?>&m_type=<?=$member_type?>";
        } else {
          location.href = "dml_qna.php?mode=delete&num=<?=$num?>&m_type=<?=$member_type?>";
        }
      }
    </script>
  </head>
  <body
    <?php
      if($member_type === 'admin'){
        echo "onload='get_unanswerd_questions();'";
      }
    ?>
  >
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
      <h3 class="title">1 : 1 문의 > 내용</h3>
        <div id="list_top_title">
          <li>
            <span class="col1"><b>제목 : </b><?=$subject?></span>
            <span class="col2_view"><?=$regist_date?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              조회 : <?=$hit?>&nbsp;&nbsp;&nbsp;</span>
          </li>
        </div><!--end of list_top_title  -->

        <div id="qna_contents">
          <?=$content ?>
        </div>

        <ul class="qna_buttons">
          <li>
          <br>
          <?php
            // 세션 값을 검사해서 관리자일 때만 수정 버튼
            if($member_type === 'admin'){
              // 관리자일 경우
              if($writer === 'admin'){
              // 관리자가 쓴 글인 경우 수정 가능
          ?>
              <li><button class="list_button" onclick="location.href='write_qna_form.php?mode=update&num=<?=$num?>&page=<?=$page?>'">수 정</button></li>
          <?php
                }
              if($depth == 0){
                // 질문일 때만 답변 달 수 있음 (답변에는 답변을 달 수 없음)
          ?>
              <li><button class="list_button" onclick="location.href='write_qna_form.php?mode=response&num=<?=$num?>&page=<?=$page?>'">답 변</button></li>
          <?php
              }
            
          ?>
            <li><button class="list_button" onclick="confirm_to_delete();">삭 제</button></li>
            <li><button class="list_button" onclick="location.href='qna_list.php?page=<?=$page?>'">목 록</button></li>
          <?php
            } else {
              // 회원일 경우
          ?>
            <li><button class="list_button" onclick="location.href='write_qna_form.php?mode=update&num=<?=$num?>&page=<?=$page?>'">수 정</button></li>
            <li><button class="list_button" onclick="confirm_to_delete();">삭 제</button></li>
            <li><button class="list_button" onclick="location.href='http://<?=$_SERVER['HTTP_HOST']?>/ilhase/cs/qna.php'">목 록</button></li>

          <?php
            }
          ?>
        </ul>
 <!-- page=<?=$page?> -->

    </div>
    <?php include $_SERVER["DOCUMENT_ROOT"]."/ilhase/common/lib/footer.php";?>
    <link rel="stylesheet" href="./css/notice.css">
    <link rel="stylesheet" href="./css/qna.css">
  </body>
</html>
