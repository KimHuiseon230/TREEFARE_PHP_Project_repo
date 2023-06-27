<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/db_connect.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/notice_board.php";
$noticeboard = new NoticeBoard($conn);
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
$row = $noticeboard->find_of_num2($num);
$copied_name = $row["file_copied"];
if ($copied_name) {
	$file_path = "./data/" . $copied_name;
	unlink($file_path);
}
$noticeboard->del_of_num($num);
echo "
	     <script>
	         location.href = 'notice_list.php?page=$page';
	     </script>
	   ";
