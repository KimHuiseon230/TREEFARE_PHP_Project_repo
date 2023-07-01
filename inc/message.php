<?php

class Message
{
  private $conn;

  public function __construct($db)
  {
    $this->conn = $db;
  }

  public function
  message_insert($send_id, $rv_id, $subject, $content)
  {
    $subject = htmlspecialchars($subject, ENT_QUOTES);
    $content = htmlspecialchars($content, ENT_QUOTES);
    $regist_day = date("Y-m-d (H:i)");

    $sql = "select * from `member` where id=:rv_id";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':rv_id', $rv_id);
    $result = $stmt->execute();

    if (!$result) {
      die("<script>
      alert('아이디 쿼리문 오류');
      history.go(-1);
      </script>");
    }
    $count = $stmt->rowCount() ? true : false;
    if ($count != 0) {
      $sql = "insert into message(send_id, rv_id, subject, content, regist_day) values (:send_id, :rv_id, :subject, :content, :regist_day)";
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(':send_id', $send_id);
      $stmt->bindParam(':rv_id', $rv_id);
      $stmt->bindParam(':subject', $subject);
      $stmt->bindParam(':content', $content);
      $stmt->bindParam(':regist_day', $regist_day);
      $stmt->execute();
    } else {
      die("<script>
      alert('수신 아이디가 잘못되었습니다!');
      history.go(-1);
      </script>");
    }
    echo "
    <script>
    self.location.href = 'http://{$_SERVER['HTTP_HOST']}/php_treefare/message/message_box.php?mode=send'</script>
    ";
  }

  public function
  sel_message_num($num)
  {
    $sql = "select * from message where num=:num";
    $stmt = $this->conn->prepare($sql);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->bindParam(':num', $num);
    $stmt->execute();
    return  $stmt->fetch();
  }
  public function
  sel_name_member_id_chk($rv_id, $send_id)
  {
    $mode = (isset($_GET['mode']) && $_GET['mode'] != '') ? (int)$_GET['mode'] : '';
    $sql = "SELECT name FROM `member` WHERE `id`=:id";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(':id', ($mode == "send" ? $rv_id : $send_id));
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->execute();
    return  $stmt->fetch();
  }
  public function
  sel_cnt_message_id_chk($ses_id, $mode)
  {
    if ($mode == "send")
      $sql = "select count(*) as cnt from message where send_id=:ses_id order by num desc";
    else
      $sql = "select count(*) as cnt from message where rv_id=:ses_id order by num desc";

    $stmt = $this->conn->prepare($sql);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->bindParam(':ses_id', $ses_id);
    $stmt->execute();
    return  $stmt->fetch();
  }
  public function
  sel_message_id_chk($ses_id,  $start, $scale, $mode)
  {
    if ($mode == "send")
      $sql = "select * from message where send_id=:ses_id order by num desc limit {$start}, {$scale}";
    else
      $sql = "select * from message where rv_id=:ses_id order by num desc limit {$start}, {$scale}";

    $stmt = $this->conn->prepare($sql);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->bindParam(':ses_id', $ses_id);
    $stmt->execute();
    return  $stmt->fetchAll();
  }

  public function
  sel_member_id_info($msg_id)
  {
    $sql = "select name from `member` where `id`=:msg_id";
    $stmt = $this->conn->prepare($sql);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->bindParam(':msg_id', $msg_id);
    $stmt->execute();
    return $stmt->fetch();
  }
  public function
  del_message_num($num)
  {
    $sql = "delete from `message` where `num`=:num";
    $stmt = $this->conn->prepare($sql);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->bindParam(':num', $num);
    $stmt->execute();
  }
}
