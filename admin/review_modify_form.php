<?php
session_start();
$ses_level = (isset($_SESSION['ses_level']) && $_SESSION['ses_level'] != '') ? $_SESSION['ses_level'] : '';
// 공통적으로 처리하는 부분
$js_array = ['/image_board/js/board_form.js'];
$title = "게시판";
$menu_code = "board";
?>
<!DOCTYPE html>
<html>

<head>
	<link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/php_treefare/image_board/css/board.css?v=<?= date('Ymdhis') ?>">
</head>

<body>
	<header>
		<?php
		if ($ses_level == 10) {
			include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_admin_header.php";
		} else {
			include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_header.php";
		}
		include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/db_connect.php";
		include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/image_board.php";
		$imageboard = new ImageBoard($conn);
		?>

	</header>
	<?php
	if (!$ses_level == 10) {
		die("<script>alert('관리자 권한 페이지 입니다.');
						history.go(-1);
					</script>");
	}
	?>
	<section class="p-5" style="height: calc(100vh - 280px);">

		<?php
		$num = $_GET['num'];

		$rows = $imageboard->find_of_num($num);

		foreach ($rows as $row) {
			$writer = $row["id"];
			$name = $row["name"];
			$subject = $row["subject"];
			$content = $row["content"];
			$rating = $row["rating"];
			$file_name = $row["file_name"];
			$file_copied = $row["file_copied"];
			if (empty($file_name)) $file_name = "없음";
		}
		?>

		<div id="board_box">
			<h3 id="board_title">
				리뷰게시판 > 수정 하기
			</h3>
			<form name="board_form" method="post" action="../image_board/dmi_board.php" enctype="multipart/form-data">
				<?php $mode = "admin_modify" ?>
				<input type="hidden" name="num" value=<?= $num ?>>
				<input type="hidden" name="mode" value=<?= $mode ?>>
				<ul id="board_form">
					<li>
						<span class="col1">이름 : </span>
						<span class="col2"><?= $name ?></span>
					</li>
					<li>
						<span class="col1">제목 : </span>
						<span class="col2"><input name="subject" type="text" value=<?= $subject ?>></span>
					</li>
					<li>
						<span class="col1">별점 : </span>
						<select name="rating" id="rating">
							<option name="rating" value="1">1</option>
							<option name="rating" value="2">2</option>
							<option name="rating" value="3">3</option>
							<option name="rating" value="4">4</option>
							<option name="rating" value="5">5</option>
						</select>
					</li>
					<li id="text_area">
						<span class="col1">내용 : </span>
						<span class="col2">
							<textarea name="content"><?= $content ?></textarea>
						</span>
					</li>
					<li>
						<span class="col1"> 첨부 파일 : </span>
						<span class="col2"><input type="file" name="upfile">
							<?php if ($mode === "modify") : ?>
								<input type="checkbox" value="yes" name="file_delete">&nbsp;파일 삭제하기
								<br>현재 파일 : <?= $file_name ?>
							<?php endif; ?>
						</span>
					</li>
				</ul>
				<ul class="buttons">
					<li>
						<button class="btn btn-sm btn-primary" type="button" id="check_input">완료</button>
					</li>
					<li>
						<button class="btn btn-sm btn-primary" type="button" onclick="location.href='admin_review.php'">목록</button>
					</li>
				</ul>
			</form>
		</div> <!-- board_box -->
	</section>
	<!-- 푸터부분 시작 -->
	<footer>
		<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_footer.php" ?>
	</footer>
	<script>
		const rating = document.querySelector("#rating");
		rating.value = '<?= $rating ?>';
	</script>
</body>

</html>