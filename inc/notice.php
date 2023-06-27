<?php

class Notic
{
  private $conn;

  public function __construct($db)
  {
    $this->conn = $db;
  }
  // filtering data from user
  function filter_data($data)
  {
    $data = trim($data); // 양 끝의 공백 제거
    $data = stripslashes($data); //  backslash 제거
    $data = htmlspecialchars($data); // 특수문자를 HTML entities로 변환
    return $data;
  }

  function test()
  {
    include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/db_connect.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/notice.php";;
    if (isset($_GET["mode"]) && $_GET["mode"] == "search") {
      //제목, 내용, 아이디
      $find = $Notic->filter_data($_POST["find"]);
      $search = $Notic->filter_data($_POST["search"]);

      $q_search = mysqli_real_escape_string($conn, $search);
      $sql = "SELECT * FROM `notice` WHERE $find LIKE '%$q_search%' ORDER BY num DESC";

      $stmt = $this->conn->prepare($sql);
      $stmt->execute();
      $result = $stmt->fetch();
      return $result;
    } else {
      $sql = "SELECT * from `notice` order by num desc";
      $stmt = $this->conn->prepare($sql);
      $stmt->execute();
      $result = $stmt->fetch();
      return $result;
    }

    // $result = mysqli_query($conn, $sql);
    $stmt->$total_record = mysqli_num_rows($result);
    return $total_record;
  }

  function insert_question()
  {
    $ses_id = (isset($_SESSION['ses_id']) && $_SESSION['ses_id'] != '') ? $_SESSION['ses_id'] : '';
    $ses_name = (isset($_SESSION['ses_name']) && $_SESSION['ses_name'] != '') ? $_SESSION['ses_name'] : '';


    global $conn, $user_id, $user_name;
    $subject = "1:1 문의합니다.";
    $content = $this->filter_data($_POST["content"]);
    $regist_date = date("Y-m-d (H:i)");

    // prepare statement를 이용하여 쿼리 생성 및 실행
    $sql = "INSERT INTO `qna` (`group_num`, `depth`, `order`, `id`, `name`, `subject`, `content`, `hit`, `regist_date`) 
    VALUES (0, 0, 0, :user_id, :user_name, :subject, :content, 0, :regist_date);";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':user_id', $ses_id);
    $stmt->bindValue(':user_name', $ses_name);
    $stmt->bindValue(':subject', $subject);
    $stmt->bindValue(':content', $content);
    $stmt->bindValue(':regist_date', $regist_date);
    $result = $stmt->execute();

    if (!$result) {
      die('insert_question error1: ' . $conn->errorInfo());
    } else {
      // insert 성공 시 group_num 세팅
      $stmt = $conn->prepare("SELECT MAX(num) FROM qna;");
      $result = $stmt->execute();
      if (!$result) {
        die('insert_question error2: ' . $conn->errorInfo());
      }
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $max_num = $row['MAX(num)'];

      // 그 num을 group_num으로 세팅
      $stmt = $conn->prepare("UPDATE qna SET `group_num` = :max_num WHERE `num` = :max_num;");
      $result = $stmt->bindValue(':max_num', $max_num);
      if (!$result) {
        die('insert_question error3: ' . $conn->errorInfo());
      }
    }
    echo "<script> 
            alert('문의 메세지를 성공적으로 남겼습니다.');
            location.href = 'http://" . $_SERVER['HTTP_HOST'] . "/php_treefare/notice/qna.php';
        </script>";
    echo "<script>
                alert('문의 메세지를 성공적으로 남겼습니다.');
                location.href = 'http://" . $_SERVER['HTTP_HOST'] . "/ilhase/cs/qna.php';
            </script>";
  }


  function select_by_user()
  {
    $ses_id = (isset($_SESSION['ses_id']) && $_SESSION['ses_id'] != '') ? $_SESSION['ses_id'] : '';
    $ses_name = (isset($_SESSION['ses_name']) && $_SESSION['ses_name'] != '') ? $_SESSION['ses_name'] : '';


    global $conn, $ses_id, $ses_name;

    $sql = "SELECT * FROM `qna` WHERE `group_num` IN (SELECT `group_num` FROM `qna` WHERE `id`=:user_id)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $ses_id);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$result) {
      die('select_by_user error: ' . $conn->errorInfo());
    }

    foreach ($result as $row) {
      $num = $row['num'];
      $hit = $row['hit'];
      $content = str_replace([" ", "\n"], ["&nbsp;", "<br>"], $row['content']);

      if ($row['depth'] === '0') {
        // 질문글인 경우
        echo '
            <div class="question_preview">
                <a href="qna_view.php?num=' . $num . '&hit=' . $hit . '"><span class="message">' . $content . '</span></a>
                <span class="date">' . $row['regist_date'] . '</span>
            </div>';
      } else {
        // 답변글인 경우
        echo '
            <div class="answer_preview">
                <span class="date">' . $row['regist_date'] . '</span>
                <span class="message">' . $content . '</span>
            </div>';
      }
    }
  }
}
