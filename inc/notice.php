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
}
