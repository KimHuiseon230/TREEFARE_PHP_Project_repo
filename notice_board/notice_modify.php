<?php
$num = (isset($_GET["num"]) && $_GET["num"] != '') ? $_GET["num"] : '';

if ($num == '') {
	die("
	<script>
    alert('해당되는 정보가 없습니다.');
    history.go(-1)
    </script>           
   ");
}

$subject = (isset($_POST["subject"]) && $_POST["subject"] != '') ? $_POST["subject"] : '';
$content = (isset($_POST["content"]) && $_POST["content"] != '') ? $_POST["content"] : '';
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/db_connect.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/notice_board.php";
$noticeboard = new NoticeBoard($conn);

// 연관배열
$arr = [
	'num' => $num,
	'subject' => $subject,
	'content' => $content,
];
$noticeboard->update_of_num($arr);

echo "
	      <script>
	          location.href = '../admin/admin_notice_board.php';
	      </script>
	  ";
