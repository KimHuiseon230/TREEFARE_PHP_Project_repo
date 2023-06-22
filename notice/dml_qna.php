<?php
  session_start();
// 회원정보 가져오기(DB연결, Member Class 로딩)
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/db_connect.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/notice.php";
$ses_id = (isset($_SESSION['ses_id']) && $_SESSION['ses_id'] != '') ? $_SESSION['ses_id'] : '';
$ses_name = (isset($_SESSION['ses_name']) && $_SESSION['ses_name'] != '') ? $_SESSION['ses_name'] : '';

$notic = new Notic($conn);


    if(isset($_GET['mode'])){
        $mode = $_GET['mode'];
    }

    if(isset($_POST['ses_id'])){
        $user_id = $_POST['ses_id'];
    } else {
      $user_id = $_SESSION['ses_id'];
    }

    if(isset($_POST['ses_name'])){
        $user_name = $_POST['ses_name'];
    }

    switch($mode){
        case 'q_insert':
            // 질문 등록
            $notic->insert_question();
            break;

        case 'r_insert':
            // 답변 등록
            insert_response();
            break;

        case 'update':
            update_question();
            break;

        case 'delete':
            delete_question();
            break;

        case 'insert':
            break;

        case 'select_by_user':
            $notic-> select_by_user();
            break;
    }

    // function insert_question(){
    //     global $conn, $user_id, $user_name;

    //     $subject = "1:1 문의합니다.";
    //     $content = filter_data($_POST["content"]);
    //     $q_content = mysqli_real_escape_string($conn, $content);
    //     $regist_date = date("Y-m-d (H:i)");
    //     $sql = "insert into qna values(null, 0, 0, 0, '$user_id', '$user_name', '$subject', '$q_content', 0, '$regist_date');";
    //     $result = mysqli_query($conn, $sql);
    //     if(!$result){
    //         mysqli_error($conn);
    //     } else {
    //         // insert 성공 시 group_num 세팅
    //         $sql="SELECT max(num) from qna;"; // 방금 insert한 글의 num 가져오기
    //         $result = mysqli_query($conn, $sql);
    //         if (!$result) {
    //           die('insert_question error1: ' . mysqli_error($con n));
    //         }
    //         $row=mysqli_fetch_array($result);
    //         $max_num=$row['max(num)'];
    //         $sql="update qna set group_num= $max_num where num = $max_num;"; // 그 num을 group_num으로 세팅
    //         $result = mysqli_query($conn, $sql);
    //         if (!$result) {
    //           die('insert_question error2: ' . mysqli_error($conn));
    //         }

    //         echo "<script>
    //             alert('문의 메세지를 성공적으로 남겼습니다.');
    //             location.href = 'http://".$_SERVER['HTTP_HOST']."/ilhase/cs/qna.php';
    //         </script>";
    //     }
    // }

    // function select_by_user(){
    //     global $conn, $user_id;

    //     $sql = "select * from qna where group_num in (select group_num from qna where id = '$user_id');";
    //     $result = mysqli_query($conn, $sql);
    //     if(!$result){
    //         die('select_by_user error: ' . mysqli_error($conn));
    //     }

    //     while($row = mysqli_fetch_array($result)){
    //         $num = $row['num'];
    //         $hit = $row['hit'];
    //         $content = str_replace(" ", "&nbsp;", $row['content']);
    //         $content = str_replace("\n", "<br>", $row['content']);

    //         if($row['depth'] === '0' ){
    //             // 질문글인 경우
    //             echo '
    //                 <div class="question_preview">
    //                     <a href="qna_view.php?num='.$num.'&hit='.$hit.'"><span class="message">'.$content.'</span></a>
    //                     <span class="date">'.$row['regist_date'].'</span>
    //                 </div>';
    //         } else {
    //             // 답변글인 경우
    //             echo '
    //                 <div class="answer_preview">
    //                     <span class="date">'.$row['regist_date'].'</span>
    //                     <span class="message">'.$content.'</span>
    //                 </div>';
    //         }
    //     }

    // }

    function insert_response(){
      global $conn, $user_id;
      
      $short_question = iconv_substr($_GET['question'], 0, 8); // 질문글 내용 

      $subject = filter_data($_POST["subject"]);
      $content = filter_data($_POST["content"]);

      $user_name = $_SESSION['username'];
      $num = filter_data($_GET["num"]);
      // $hit = filter_data($_POST["hit"]);
      $hit =0;
      $q_subject = mysqli_real_escape_string($conn, $subject);
      $q_content = mysqli_real_escape_string($conn, $content);
      $q_num = mysqli_real_escape_string($conn, $num);
      $regist_day=date("Y-m-d (H:i)");

      $sql="SELECT * from qna where num =$q_num;";
      $result = mysqli_query($conn,$sql);
      if (!$result) {
        die('Error: ' . mysqli_error($conn));
      }
      $row=mysqli_fetch_array($result);

      // 질문글 작성자
      $writer = $row['id'];

      //현재 그룹넘버값을 가져와서 저장한다.
      $group_num=(int)$row['group_num'];
      //현재 들여쓰기값을 가져와서 증가한후 저장한다.
      $depth=(int)$row['depth'] + 1;
      //현재 순서값을 가져와서 증가한후 저장한다.
      $order=(int)$row['order'] + 1;

      //현재 그룹넘버가 같은 모든 레코드를 찾아서 현재 $ord값보다 같거나 큰 레코드에 $ord 값을 1을 증가시켜 저장한다.
      $sql="UPDATE `qna` SET `order`=`order`+1 WHERE `group_num` = $group_num and `order` >= $order";
      $result = mysqli_query($conn,$sql);
      if (!$result) {
        die('UPDATE Error: ' . mysqli_error($conn));
      }

      $sql="INSERT INTO `qna` VALUES (null,
        $group_num, $depth, $order, '$user_id','$user_name','$q_subject','$q_content', $hit,'$regist_day');";
      $result = mysqli_query($conn,$sql);
      if (!$result) {
        die('INSERT Error: ' . mysqli_error($conn));
      }

      $sql="SELECT max(num) from qna;";
      $result = mysqli_query($conn,$sql);
      if (!$result) {
        die('SELECT Error: ' . mysqli_error($conn));
      }
      $row = mysqli_fetch_array($result);
      $max_num = $row['max(num)'];

      // 답변 등록 알림
      $noti_subject = '1:1문의 답변이 도착했습니다.';
      $noti_content = '문의하신 ['.$short_question.'...]에 대한 답변이 도착하였습니다.';
      $receiver = $writer;
      insert_notification($noti_subject, $noti_content, $receiver);
      echo "<script>location.href='./qna_view.php?num=$max_num&hit=$hit';</script>";

    }

    function update_question(){
        global $conn;

        $num = $_GET['num'];
        $hit = $_GET['hit'];
        $member_type = $_GET['m_type'];

        $subject = $_POST['subject'];
        $content = $_POST['content'];

        $sql = "update qna set subject = '$subject', content = '$content' where num = '$num';";
        $result = mysqli_query($conn, $sql);

        if(!$result){
            die(mysqli_error($conn));
        }

        if($member_type === 'admin'){
            // 관리자면 1:1문의 게시판으로 
            echo "<script>location.href='./qna_view.php?num=$num&hit=$hit';</script>";
        } else {
            // 회원이면 1:1문의 페이지로
            echo "<script>location.href='http://".$_SERVER['HTTP_HOST']."/ilhase/cs/qna.php';</script>";
        }
    }

    function delete_question(){
        global $conn;

        $num = $_GET['num'];
        $member_type = $_GET['m_type'];
        if(isset($_GET['page'])){
            $page = $_GET['page'];
        }

        // 해당글이 질문글인지 답변글인지 파악
        $sql = "select depth from qna where num = '$num';";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_array($result)){
            $depth = $row[0];
        }

        if($depth == 0){
            // 질문글인 경우 그룹 전체 삭제
            $sql = "delete from qna where group_num = '$num';";
        } else {
            // 답변글인 경우 해당 답변만 삭제
            $sql = "delete from qna where num = '$num';";
        }
        $result = mysqli_query($conn, $sql);

        if(!$result){
            die(mysqli_error($conn));
        }

        echo "<script>alert('삭제 되었습니다.');</script>";

        if($member_type === 'admin'){
            // 관리자면 1:1문의 게시판으로 
            echo "<script>location.href='./qna_list.php?page=$page';</script>";
        } else {
            // 회원이면 1:1문의 페이지로
            echo "<script>location.href='http://".$_SERVER['HTTP_HOST']."/ilhase/cs/qna.php';</script>";
        }
    }
