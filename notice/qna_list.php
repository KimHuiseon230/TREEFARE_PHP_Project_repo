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

define('SCALE', 10);
//*****************************************************
$sql=$result=$total_record=$total_page=$start="";
$row="";
$memo_content="";
$total_record=0;
//*****************************************************

$sql="select * from qna order by `group_num` desc, `order` asc;";

$result=mysqli_query($conn,$sql);
$total_record=mysqli_num_rows($result);
$total_page=($total_record % SCALE == 0 )?($total_record/SCALE):(ceil($total_record/SCALE));

//2.페이지가 없으면 디폴트 페이지 1페이지
if(empty($_GET['page'])){
  $page=1;
}else{
  $page=$_GET['page'];
}

$start=($page -1) * SCALE;
$number = $total_record - $start;
?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'];?>/ilhase/common/css/common.css">
    <link rel="icon" href="http://<?= $_SERVER['HTTP_HOST'];?>/ilhase/common/img/favicon.png" sizes="128x128">
    <link rel="stylesheet" href="./css/notice.css">
    <title>일하세</title>
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
  </head>
  <body onload="get_unanswerd_questions();">
    <header>
        <?php include $_SERVER["DOCUMENT_ROOT"]."/ilhase/common/lib/header_admin.php";?>
        <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'];?>/ilhase/admin/css/plain_admin_header.css">
    </header>
      <div class="container">
        <h2 class="title">1 : 1 문의</h2><br>
         <div id="list_top_title">

           <ul class="notice_list_menu">
             <li id="list_title1">번호</li>
             <li id="list_title2">제목</li>
             <li id="list_title3">작성자</li>
             <li id="list_title4">조회수</li>
             <li id="list_title5">날짜</li>
           </ul>
         </div><!--end of list_top_title  -->

         <div id="list_content">

         <?php
          for ($i = $start; $i < $start+SCALE && $i<$total_record; $i++){
            mysqli_data_seek($result,$i);
            $row=mysqli_fetch_array($result);
            $num=$row['num'];
            $hit = $row['hit'];
            $name=$row['name'];
            $date= substr($row['regist_date'],0,10);
            $subject=$row['subject'];
            $subject=str_replace("\n", "<br>",$subject);
            $subject=str_replace(" ", "&nbsp;",$subject);
            $depth=(int)$row['depth'];//공간을 몆칸을 띄어야할지 결정하는 숫자임
            $space="";
            for($j=0 ; $j < $depth ; $j++){
              $space="&nbsp;&nbsp;".$space;
            }
        ?>
            <div class="list_item">
              <div class="list_item1"><?=$number?></div>
              <div class="list_item2">
                  <a href="./qna_view.php?num=<?=$num?>&page=<?=$page?>&hit=<?=$hit + 1?>"><?=$space.$subject?></a>
              </div>
              <div class="list_item3"><?=$name?></div>
              <div class="list_item4"><?=$hit?></div>
              <div class="list_item5"><?=$row['regist_date']?></div>
            </div><!--end of list_item -->
        <?php
            $number--;
         }//end of for
        ?>

        <div id="page_button">
          <?php
            if ($total_page>=2 && $page >= 2) {
          		$new_page = $page-1;
          		echo "<li><a href='qna_list.php?page=$new_page'>◀ 이전&nbsp;&nbsp;&nbsp;</a> </li>";
          	}
          	else {
              echo "<li>&nbsp;</li>";
            }

            for ($i=1; $i <= $total_page ; $i++) {
              if($page==$i){
                echo "<b>&nbsp;$i&nbsp;</b>";
              }else{
                echo "<a href='./qna_list.php?page=$i'>&nbsp;$i&nbsp;</a>";
              }
            }
            if ($total_page>=2 && $page != $total_page) {
            $new_page = $page+1;
              echo "<li> <a href='qna_list.php?page=$new_page'>&nbsp;&nbsp;&nbsp;다음 ▶</a> </li>";
            }
            else {
              echo "<li>&nbsp;</li>";
            }
           ?>

        </div><!--end of page num -->
      </div><!--end of page button -->
      </div><!--end of list content -->

      </div><!--end of content -->
      <!-- Footer -->
      <?php include $_SERVER["DOCUMENT_ROOT"]."/ilhase/common/lib/footer.php";?>
    <link rel="stylesheet" href="./css/qna.css">
  </body>
</html>
