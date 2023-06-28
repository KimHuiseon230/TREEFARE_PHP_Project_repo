<?php
session_start();
$ses_level = (isset($_SESSION['ses_level']) && $_SESSION['ses_level'] != '') ? $_SESSION['ses_level'] : '';

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>게시글</title>
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
	<section class="p-5">
		<div id="board_box">
			<h3 class="title">
				리뷰게시판 > 내용보기
			</h3>
			<?php
			if (!$ses_id) {
				echo ("<script>
							alert('로그인 후 이용해주세요!');
							history.go(-1);
							</script>
						");
				exit;
			}

			include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/db_connect.php";
			$num = $_GET["num"];
			$page = $_GET["page"];

			$row = $imageboard->find_of_num2($num);

			$id = $row["id"];
			$name = $row["name"];
			$regist_day = $row["regist_day"];
			$subject = $row["subject"];
			$content = $row["content"];
			$rating = $row["rating"];
			$file_name = $row["file_name"];
			$file_type = $row["file_type"];
			$file_copied = $row["file_copied"];

			$content = str_replace(" ", "&nbsp;", $content);
			$content = str_replace("\n", "<br>", $content);

			$file_name_0 = $row['file_name'];
			$file_copied_0 = $row['file_copied'];
			$file_type_0 = $row['file_type'];
			//이미지 정보를 가져오기 위한 함수 width, height, type
			if (!empty($file_name_0)) {
				$image_info = getimagesize("./data/" . $file_copied_0);
				$image_width = $image_info[0];
				$image_height = $image_info[1];
				$image_type = $image_info[2];
				$image_width = 300;
				$image_height = 300;
				if ($image_width > 300) $image_width = 300;
			}
			?>
			<ul id="view_content">
				<li>
					<span class="col1"><b>제목 :</b> <?= $subject ?></span>
					<span class="col2"><?= $name ?> | <?= $regist_day ?></span>
				</li>
				<li>
					<span class="col1"><b>별점 :</b> <?php echo $imageboard->fetch_star($rating); ?></span>
				</li>
				<li>
					<?php

					if (strpos($file_type_0, "image") !== false) {
						echo "<img src='./data/$file_copied_0' width='$image_width'><br>";
					} else if ($file_name) {
						$real_name = $file_copied;
						$file_path = "./data/" . $real_name;
						$file_size = filesize($file_path);  //파일사이즈를 구해주는 함수

						echo "▷ 첨부파일 : $file_name ($file_size Byte) &nbsp;&nbsp;&nbsp;&nbsp;
			       		<a href='board_download.php?num=$num&real_name=$real_name&file_name=$file_name&file_type=$file_type'>[저장]</a><br><br>";
					}
					?>

				</li>
				<li>
					<span class="col1"> <?= $content ?></span>
				</li>
			</ul>
			<!--덧글내용시작  -->
			<div id="ripple">
				<div id="ripple1">덧글</div>
				<div id="ripple2">
					<?php
					$rowArray = $imageboard->find_of_ripple_num($num);

					foreach ($rowArray as $row) {
						$ripple_num = $row['num'];
						$ripple_id = $row['id'];
						$ripple_date = $row['regist_day'];
						$ripple_content = $row['content'];
						$ripple_content = str_replace("\n", "<br>", $ripple_content);
						$ripple_content = str_replace(" ", "&nbsp;", $ripple_content);

					?>
						<div id="ripple_title">
							<ul>
								<li><?= $ripple_id . "&nbsp;&nbsp;" . $ripple_date ?></li>
								<li id="mdi_del">
									<span><?= $ripple_content ?></span>
									<?php
									if ($_SESSION['ses_id'] == "admin" || $_SESSION['ses_id'] == $ripple_id) {
										echo '
                            <form style="display:inline" action="dmi_board.php" method="post">
													    <input type="hidden" name="page" value="' . $page . '">
													    <input type="hidden" name="mode" value="delete_ripple">
													    <input type="hidden" name="num" value="' . $ripple_num . '">
													    <input type="hidden" name="parent" value="' . $num . '">
													    <input type="submit" value="삭제">
													  </form>';
									}
									?>
								</li>
							</ul>
						</div>
					<?php
					} //end of while
					?>

					<form name="ripple_form" action="dmi_board.php" method="post">
						<input type="hidden" name="mode" value="insert_ripple">
						<input type="hidden" name="parent" value="<?= $num ?>">
						<input type="hidden" name="hit" value="<?= $hit ?>">
						<input type="hidden" name="page" value="<?= $page ?>">
						<div id="ripple_insert">
							<div id="ripple_textarea"><textarea name="ripple_content" rows="3" cols="80"></textarea></div>
							<div id="ripple_button"><input type="image" src="./img/memo_ripple_button.png">
							</div>
						</div><!--end of ripple_insert -->
					</form>
				</div><!--end of ripple2  -->
			</div><!--end of ripple  -->

			<div id="write_button">

				<ul class="buttons">
					<li>
						<button onclick="location.href='board_list.php?page=<?= $page ?>'">목록</button>
					</li>
					<?php
					if ($ses_id == $id) {
					?>
						<li>
							<form action="board_form.php" method="post">
								<button>수정</button>
								<input type="hidden" name="num" value=<?= $num ?>>
								<input type="hidden" name="page" value=<?= $page ?>>
								<input type="hidden" name="mode" value="modify">
							</form>
						</li>
						<li>
							<form action="dmi_board.php" method="post">
								<button>삭제</button>
								<input type="hidden" name="num" value=<?= $num ?>>
								<input type="hidden" name="page" value=<?= $page ?>>
								<input type="hidden" name="mode" value="delete">
							</form>
						</li>
					<?php
					}
					?>
					<li>
						<button onclick="location.href='board_form.php'">글쓰기</button>
					</li>
				</ul>
			</div> <!-- board_box -->
	</section>
	<footer>
		<?php include $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_footer.php"; ?>
	</footer>

</body>

</html>