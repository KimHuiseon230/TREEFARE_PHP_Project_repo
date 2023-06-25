<!-- DB에 저장된 쪽지 삭제 -->
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/db_connect.php";
$num = (isset($_GET["num"]) and is_numeric($_GET["num"])) ? (int)$_GET["num"] : '';
$mode = (isset($_GET["mode"]) and is_numeric($_GET["mode"])) ? (int)$_GET["mode"] : '';
$sql = "delete from message where num=$num";

mysqli_query($conn, $sql);
mysqli_close($conn);                // DB 연결 끊기

if ($mode == "send")
	$url = "message_box.php?mode=send";
else
	$url = "message_box.php?mode=rv";

echo "
	<script>
		location.href = '$url';
	</script>
	";
