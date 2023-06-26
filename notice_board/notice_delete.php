<?php

$num = (isset($_GET["num"]) && $_GET["num"] != '') ? $_GET["num"] : '';
$page = (isset($_GET["page"]) && $_GET["page"] != '') ? $_GET["page"] : '';

if ($num == '' && $page == '') {
	die("
	<script>
    alert('해당되는 정보가 없습니다.');
    history.go(-1)
    </script>           
   ");
}

include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/db_connect.php";
$sql = "select * from notice where num = :num";
$stmt = $conn->prepare($sql);
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$stmt->bindParam(':num', $num);
$stmt->execute();
$row = $stmt->fetch();

$copied_name = $row["file_copied"];

if ($copied_name) {
	$file_path = "./data/" . $copied_name;
	unlink($file_path);
}

$sql2 = "delete from notice where num = :num";
$stmt2 = $conn->prepare($sql2);
$stmt2->bindParam(':num', $num);
$stmt2->execute();

echo "
	     <script>
	         location.href = 'notice_list.php?page=$page';
	     </script>
	   ";
