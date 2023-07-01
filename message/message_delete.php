<!-- DB에 저장된 쪽지 삭제 -->
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/db_connect.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/message.php";
$num = (isset($_GET["num"]) and is_numeric($_GET["num"])) ? (int)$_GET["num"] : '';
$mode = (isset($_GET["mode"]) and is_numeric($_GET["mode"])) ? (int)$_GET["mode"] : '';
$message = new Message($conn);

$message->del_message_num($num);

if ($_GET['mode'] == "rv")
	$url = "message_box.php?mode=rv";
else
	$url = "message_box.php?mode=send";

echo "
	<script>
		location.href = '$url';
	</script>
	";
