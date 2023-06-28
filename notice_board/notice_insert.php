<meta charset="utf-8">
<?php
session_start();
$ses_id = (isset($_SESSION["ses_id"]) && $_SESSION["ses_id"] != '') ? $_SESSION["ses_id"] : '';
$ses_name = (isset($_SESSION["ses_name"]) && $_SESSION["ses_name"] != '') ? $_SESSION["ses_name"] : '';
if ($ses_id == '' && $ses_name == '') {
	die("
	<script>
    alert('게시판 글쓰기는 로그인 후 이용해 주세요!');
    history.go(-1)
    </script>           
   ");
}
$subject = (isset($_POST["subject"]) && $_POST["subject"] != '') ? $_POST["subject"] : '';
$content = (isset($_POST["content"]) && $_POST["content"] != '') ? $_POST["content"] : '';
$subject = htmlspecialchars($subject, ENT_QUOTES);
$content = htmlspecialchars($content, ENT_QUOTES);
$regist_date = date("Y-m-d (H:i)");  // 현재의 '년-월-일-시-분'을 저장
$upload_dir = './data/';
$upfile_name	 = $_FILES["upfile"]["name"];
$upfile_tmp_name = $_FILES["upfile"]["tmp_name"];
$upfile_type     = $_FILES["upfile"]["type"];
$upfile_size     = $_FILES["upfile"]["size"];
$upfile_error    = $_FILES["upfile"]["error"];

if ($upfile_name && !$upfile_error) {
	$file = explode(".", $upfile_name);
	$file_name = $file[0];
	$file_ext  = $file[1];
	$new_file_name = date("Y_m_d_H_i_s");
	$copied_file_name = $new_file_name . "." . $file_ext;
	$uploaded_file = $upload_dir . $copied_file_name;

	if ($upfile_size  > 1000000) {
		die("
				<script>
				alert('업로드 파일 크기가 지정된 용량(1MB)을 초과합니다!<br>파일 크기를 체크해주세요! ');
				history.go(-1)
				</script>
				");
	}

	if (!move_uploaded_file($upfile_tmp_name, $uploaded_file)) {
		die("
					<script>
					alert('파일을 지정한 디렉토리에 복사하는데 실패했습니다.');
					history.go(-1)
					</script>
				");
	}
} else {
	$upfile_name      = "";
	$upfile_type      = "";
	$copied_file_name = "";
}

include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/db_connect.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/notice_board.php";
$noticeboard = new NoticeBoard($conn);

// 연관배열
$arr = [
	'subject' => $subject,
	'content' => $content,
	'upfile_name' => $upfile_name,
	'upfile_type' => $upfile_type,
	'copied_file_name' => $copied_file_name,
	'regist_date' => $regist_date,
];

$noticeboard->insert_of_num($arr);

echo "
	   <script>
	    location.href = '../admin/admin_notice_board.php';
	   </script>
	";
?>