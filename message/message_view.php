<?php
session_start();
$ses_id = (isset($_SESSION['ses_id']) && $_SESSION['ses_id'] != '') ? $_SESSION['ses_id'] : '';
$ses_level = (isset($_SESSION['ses_level']) && $_SESSION['ses_level'] != '') ? $_SESSION['ses_level'] : '';
//보안부분(세션등록, 체크할내용, GET, POST)
if ($ses_id == '') {
	die("
  <script>
    alert('로그인 후 접근이 가능한 페이지 입니다.')
    self.location.href = 'http://" . $_SERVER['HTTP_HOST'] . "/php_treefare/index.php';
  </script>");
}
$css_array = ['css/message.css'];
$title = "쪽지 상세";
$menu_code = "message";
?>
<header>
	<?php
	//헤더부분 시작
	if ($ses_level == 10) {
		include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_admin_header.php";
	} else {
		include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_header.php";
	}
	include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/db_connect.php";
	include $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/create_table.php";
	include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/message.php";
	$message = new Message($conn);
	$ses_id = (isset($_SESSION['ses_id']) && $_SESSION['ses_id'] != '') ? $_SESSION['ses_id'] : '';
	$ses_name = (isset($_SESSION['ses_name']) && $_SESSION['ses_name'] != '') ? $_SESSION['ses_name'] : '';
	$ses_level = (isset($_SESSION['ses_level']) && $_SESSION['ses_level'] != '') ? $_SESSION['ses_level'] : ''; ?>
</header>
<!-- 메인부분 시작 -->
<section>
	<div class="p-5" id="message_box" style="height: calc(100vh - 280px);">
		<h3 class="title">
			<?php
			//먼저 선언을 해야하는 파일들
			$mode = (isset($_GET['mode']) && $_GET['mode'] != '') ? $_GET['mode'] : '';
			$num = (isset($_GET['num']) && $_GET['num'] != '') ? (int)$_GET['num'] : '';
			$row = $message->sel_message_num($num);

			// 보낸 사용자의 정보
			date_default_timezone_set('Asia/Seoul');
			$regist_day = date("Y-m-d (H:i)");
			$rv_id = isset($row["rv_id"]) ? $row["rv_id"] : '';
			$send_id = isset($row["send_id"]) ? $row["send_id"] : '';
			$subject = isset($row["subject"]) ? $row["subject"] : '';
			$content = isset($row["content"]) ? $row["content"] : '';
			$content = str_replace(" ", "&nbsp;", $content);
			$content = str_replace("\n", "<br>", $content);

			$record = $message->sel_name_member_id_chk($rv_id, $send_id);
			$msg_name = isset($record["name"]) ? $record["name"] : '';
			if ($mode == "send") {
				echo "송신 쪽지함 > 내용보기";
			} else {
				echo "수신 쪽지함 > 내용보기";
			}
			?>
		</h3>
		<ul id="view_content">
			<li>
				<span class="col1"><b>제목 :</b> <?= $subject ?></span>
				<span class="col2"><?= $msg_name ?> | <?= $regist_day ?></span>
			</li>
			<li>
				<?= $content ?>
			</li>
		</ul>
		<ul class="buttons">
			<li><button type="button" class="btn btn-secondary" onclick="location.href='message_box.php?mode=rv'">수신 쪽지함</button></li>
			<li><button type="button" class="btn btn-secondary" onclick="location.href='message_box.php?mode=send'">송신 쪽지함</button></li>
			<?php
			if ($_GET['mode'] == "rv") {
			?>
				<li><button type="button" class="btn btn-secondary" onclick="location.href='message_response_form.php?num=<?= $num ?>'">답변 쪽지</button></li>
			<?php
			}
			?>
			<li><button type="button" class="btn btn-secondary" onclick="location.href='message_delete.php?num=<?= $num ?>&mode=<?= $mode ?>'">삭제</button></li>
		</ul>
	</div> <!-- message_box -->
</section>
<!-- 메인부분 종료 -->

<!-- 푸터부분 시작 -->
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_footer.php"
?>