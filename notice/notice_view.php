<?php
session_start();
$notic = new Notic($conn);
include $_SERVER['DOCUMENT_ROOT'] . "/ilhase/common/lib/db_connector.php";

$num = $page = $hit = "";

if (isset($_GET['num'])) {
  $num = $notic->filter_data($_GET['num']);
}

if (isset($_GET['page'])) {
  $page =
    $notic->filter_data($_GET['page']);
}

if (isset($_GET['hit'])) {
  $hit =
    $notic->filter_data($_GET['hit']);
}

if (isset($_GET["num"]) && !empty($_GET["hit"])) {
  // $num = filter_data($_GET["num"]);
  // $hit = filter_data($_GET["hit"]);
  $n_num = mysqli_real_escape_string($conn, $num);

  $sql = "UPDATE `notice` SET `hit`=$hit WHERE `num`=$n_num;"; // 조회수 증가

  $result = mysqli_query($conn, $sql);
  if (!$result) {
    die('Error: ' . mysqli_error($conn));
  } // 조회수 증가
}
$sql = "SELECT * from `notice` where num ='$num';"; // 글 번호로 내용 가져오기
$result = mysqli_query($conn, $sql);
if (!$result) {
  die('Error: ' . mysqli_error($conn));
}

$row = mysqli_fetch_array($result); // 쿼리문 실행 결과를 배열로 받아서 한 레코드를 가져옴

// 레코드의 각 필드 값을 가져옴
$subject = $row['subject'];
$content = $row['content'];
$file_name = $row['file_name'];
$file_type = $row['file_type'];
$file_copied = $row['file_copied'];
$hit = $row['hit'];
$regist_date = $row['regist_date'];

$content = str_replace(" ", "&nbsp;", $content);
$content = str_replace("\n", "<br>", $content);

if (!empty($file_copied)) {
  // file_copied가 빈 값이 아니면 파일 정보를 가져옴
  $image_info = getimagesize("./data/" . $file_copied);
  $image_width = $image_info[0];
  $image_height = $image_info[1];
  $image_type = $image_info[2];
  if ($image_width > 780) {
    $image_width = 780;
  }
} else {
  $image_width = 0;
  $image_height = 0;
  $image_type = "";
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
  <link rel="icon" href="http://<?= $_SERVER['HTTP_HOST']; ?>/ilhase/common/img/favicon.png" sizes="128x128">
  <title>일하세</title>
  <script src="http://<?= $_SERVER['HTTP_HOST']; ?>/ilhase/admin/js/check_notification.js"></script>
</head>

<body <?php
      if (isset($_SESSION['userid']) && $_SESSION['userid'] === 'admin') {
        echo "onload='get_unanswerd_questions();'";
      }
      $user_id = $_SESSION['userid'];
      ?>>
  <header>

    <?php
    if (!$user_id) {
      echo "<script>alert('로그인 후 이용해주세요!');
                history.go(-1);
              </script>";
    } else if ($user_id === 'admin') {
      // 관리자일 경우
      include $_SERVER["DOCUMENT_ROOT"] . "/ilhase/common/lib/header_admin.php";
    ?>
      <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST']; ?>/ilhase/admin/css/plain_admin_header.css">
    <?php
    } else {
      // 회원일 경우
      include $_SERVER["DOCUMENT_ROOT"] . "/ilhase/common/lib/header.php";
    } ?>
  </header>
  <div class="container">
    <h3 class="title">공지사항 > 내용</h3>
    <div id="list_top_title">

      <span class="col1"><b>제목 : </b><?= $subject ?></span>
      <span class="col2_view"><?= $regist_date ?></span>

    </div><!--end of list_top_title  -->

    <div id="notice_contents">
      <?php
      if ($file_name) {
        $real_name = $file_copied;
        $file_path = "./data/" . $real_name;
        $file_size = filesize($file_path);
        echo "<br>📁 첨부파일 : $file_name ($file_size Byte) &nbsp;&nbsp;&nbsp;&nbsp;
                <a href='board_download.php?num=$num&real_name=$real_name&file_name=$file_name&file_type=$file_type'>[저장]</a><br><br>
                <img src='" . $file_path . "' width='" . $image_width . "' height='" . $image_height . "' /><br /><br />";
        // 올린 파일 글 내용에 보이기
      }
      ?>
      <div><?= $content ?></div>
    </div>
    <div class="comment_box">

      <ul id="comment_list">
        <!-- 해당 글에 등록된 코멘트 가져오기-->
        <?php
        $sql = "select * from notice_comment where parent = $num order by regist_date asc";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($result)) {
          $c_num = $row['num'];
          $c_name = $row['name'];
          $c_id = $row['id'];
          $c_content = $row['content'];
          $c_regist_date = $row['regist_date'];

          if ($_SESSION["userid"] === $c_id) {
            // 본인이 쓴 댓글인 경우 (삭제 가능)
            echo '<li class="comment">
                    <span class="comment_writer">💬' . $c_name . '(' . $c_id . ')</span><span class="comment_date">' . $c_regist_date . '&nbsp;&nbsp;<span class="btn_delete_comment" onclick="delete_comment(this);" data-num="' . $c_num . '">X</span></span><br/>
                    <span class="comment_content">' . $c_content . '</span>
                  </li>';
          } else {
            echo '<li class="comment">
                    <span class="comment_writer">💬' . $c_name . '(' . $c_id . ')</span><span class="comment_date">' . $c_regist_date . '</span><br/>
                    <span class="comment_content">' . $c_content . '</span>
                  </li>';
          }
        }
        ?>

      </ul>

      <div class="input_comment_area">
        <span>댓글</span><textarea id="c_content" cols="80" rows="3" maxlength="150"></textarea><button onclick="add_comment();">입력</button>
      </div>
    </div>

    <ul class="notice_buttons">
      <br>
      <li><button class="list_button" onclick="location.href='notice.php?page=<?= $page ?>'">목록</button></li>
      <?php
      // 세션 값을 검사해서 관리자일 때만 수정/삭제 버튼
      if ($_SESSION['userid'] === 'admin') {
      ?>
        <li><button class="list_button" onclick="location.href='write_notice_form.php?mode=update&num=<?= $num ?>&page=<?= $page ?>'">수정</button></li>
        <li><button class="list_button" onclick="location.href='dml_notice.php?mode=delete&num=<?= $num ?>&page=<?= $page ?>'">삭제</button></li>
      <?php
      }
      ?>
    </ul>
    <!-- page=<?= $page ?> -->

  </div> <!-- container -->
  <footer class="py-5 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; ilhase 2020</p>
    </div>
  </footer>
  <link rel="stylesheet" href="./css/notice.css">
  <script>
    function add_comment() {
      let comment_area = document.querySelector('#c_content');

      if (!comment_area.value) {
        alert("댓글을 입력해주세요");
        return false;
      }

      // 테이블에 insert
      $.ajax({
        type: "post",
        async: false,
        url: "dml_notice.php?mode=add_comment&p_num=" + <?= $n_num ?>,
        data: {
          content: comment_area.value,
          id: '<?= $_SESSION['userid'] ?>',
          name: '<?= $_SESSION['username'] ?>'
        },
        success: function(response) {
          // ul에 append
          $('#comment_list').append(response);
          // textarea 비우기
          comment_area.value = "";
        }
      });
    }

    function delete_comment(btn_delete) {
      // data-num값 가져오기
      const comment_num = btn_delete.dataset.num;
      console.log(comment_num);

      const response = confirm('댓글을 삭제하시겠습니까?');

      if (response) {
        $.ajax({
          type: "get",
          url: "dml_notice.php?mode=delete_comment&c_num=" + comment_num,
          data: "data",
          success: function(response) {
            // ul에 remove
            comment_list.removeChild(btn_delete.parentNode.parentNode);
            alert('댓글을 삭제하였습니다.');
          }
        });
      }

    }
  </script>
</body>

</html>