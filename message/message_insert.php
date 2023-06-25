<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/db_connect.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/message.php";
$send_id = (isset($_POST['send_id']) && $_POST['send_id'] != '') ? $_POST['send_id'] : '';
$rv_id = (isset($_POST['rv_id']) && $_POST['rv_id'] != '') ? $_POST['rv_id'] : '';
$subject = (isset($_POST['subject']) && $_POST['subject'] != '') ? $_POST['subject'] : '';
$content = (isset($_POST['content']) && $_POST['content'] != '') ? $_POST['content'] : '';

$message = new Message($conn);

if ($send_id == "" or $rv_id == "" or $subject == "" or $content == "") {
  die("
  <script>
  alert('모든 항목을 입력해주세요!');
  history.go(-1);
  </script>
  ");
}

$message->message_insert($send_id, $rv_id, $subject, $content);
