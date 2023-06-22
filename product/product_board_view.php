<!DOCTYPE html>
<html>

<head>
	<link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/php_treefare/product/css/board.css?v=<?= date('Ymdhis') ?>">
</head>

<body>
	<header>
		<?php include $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc_header.php";
		?>
	</header>
	<?php
	if (!$selevel == 1) {
		die("<script>alert('권한이 없습니다.!');
						history.go(-1);
					</script>");
	}
	?>
	<section>
		<div id="board_box">
			<h3 class="title">
				관리자 상품페이지
			</h3>
			<?php
			include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/db_connect.php";
			$num = $_GET["num"];
			$page = $_GET["page"];

			$sql = "select * from product where num=:num";
			$stmt = $conn->prepare($sql);
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			$stmt->bindParam(':num', $num);
			$stmt->execute();
			$row = $stmt->fetch();


			$num = $row["num"];
			$name = $row["name"];
			$kind = $row["kind"];
			$price = $row["price"];
			$sale = $row["sale"];
			$content = $row["content"];
			$file_name_0 = $row['file_name'];
			$file_copied_0 = $row['file_copied'];
			$file_type_0 = $row['file_type'];
			$regist_day = $row["regist_day"];

			$content = str_replace(" ", "&nbsp;", $content);
			$content = str_replace("\n", "<br>", $content);
			// if ($seid !== $id) {
			// 	$new_hit = $hit + 1;
			// 	$sql2 = "update image_board set hit=$new_hit where num=:num";
			// 	$stmt2 = $conn->prepare($sql2);
			// 	$stmt->execute();
			// }
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
					<span class="col1"><b>상품명 :</b> <?= $name ?></span>
					<span class="col2">등록일 : <?= $regist_day ?></span>
				</li>
				<li><span class="col1"><b>종류 :</b> <?= $kind ?></span></li>

				<li><span class="col1"><b>원가 :</b> <?= $price ?></span></li>

				<li><span class="col1"><b>세일가격 :</b> <?= $sale ?></span></li>

				<li><span class="col1"><b>제품설명 :</b> <?= $content ?></span></li>
				<li><span class="col1"><b>제품 이미지 :</b> <?= $file_name_0 ?></li>
				<li>
					<?php
					if (strpos($file_type_0, "image") !== false) {
						echo "<img src='./data/$file_copied_0' width='$image_width'><br>";
					}
					// } else if ($file_name) {
					// 	$real_name = $file_copied;
					// 	$file_path = "./data/" . $real_name;
					// 	$file_size = filesize($file_path);  //파일사이즈를 구해주는 함수
					// 	echo "▷ 첨부파일 : $file_name ($file_size Byte) &nbsp;&nbsp;&nbsp;&nbsp;
					// 	<a href='board_download.php?num=$num&real_name=$real_name&file_name=$file_name&file_type=$file_type'>[저장]</a><br><br>";
					// }
					?>
				</li>
			</ul>
			<!-- 밑에 버튼 -->
			<div id="write_button">
				<ul class="buttons">
					<li>
						<button onclick="location.href='product_list.php?page=<?= $page ?>'">목록</button>
					</li>
					<li>
						<form action="product_form.php" method="post">
							<button>수정</button>
							<input type="hidden" name="num" value=<?= $num ?>>
							<input type="hidden" name="page" value=<?= $page ?>>
							<input type="hidden" name="mode" value="modify">
						</form>
					</li>
					<li>
						<form action="dmi_product_board.php" method="post">
							<button>삭제</button>
							<input type="hidden" name="num" value=<?= $num ?>>
							<input type="hidden" name="page" value=<?= $page ?>>
							<input type="hidden" name="mode" value="delete">
						</form>
					</li>
					<li>
						<button onclick="location.href='product_form.php'">글쓰기</button>
					</li>
				</ul>
			</div> <!-- board_box -->
	</section>
	<footer>
		<?php include $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc_footer.php"; ?>
</body>

</html>