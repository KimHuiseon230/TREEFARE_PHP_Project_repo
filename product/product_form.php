<?php
session_start();
$ses_level = (isset($_SESSION['ses_level']) && $_SESSION['ses_level'] != '') ? $_SESSION['ses_level'] : '';

// 공통적으로 처리하는 부분
$js_array = ['js/product_form.js'];
$title = "상품";
$menu_code = "product";
?>
<!DOCTYPE html>
<html>

<head>
	<link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/php_treefare/product/css/board.css?v=<?= date('Ymdhis') ?>">
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
		include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/product.php";
		include $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/create_table.php";
		create_table($conn, "product");
		$product = new Product($conn);
		?>

	</header>
	<section class="p-5 mt-5" style="height: calc(100vh - 330px);">
		<?php
		$mode = isset($_POST["mode"]) ? $_POST["mode"] : "insert";
		$name = "";
		$kind = "";
		$price = "";
		$sale = "";
		$content = "";
		$file_name = "";

		if (isset($_POST["mode"]) && $_POST["mode"] === "modify") {
			$num = $_POST["num"];
			$page = $_POST["page"];
			$rows = $product->find_of_num($num);

			// 비로그인 이거나 관리자가 아닌경우
			if ($ses_level != 10) {
				"alert_back('수정권한이 없습니다.')";
				exit;
			}
			foreach ($rows as $row) {
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
				if (empty($file_name)) $file_name = "없음";
			}
		}
		?>
		<div id="board_box">
			<h3 id="board_title">
				<?php if ($mode === "modify") : ?>
					상품 수정 하기
				<?php else : ?>
					상품 추가하기
				<?php endif; ?>
			</h3>
			<form name="board_form" method="post" action="dmi_product_board.php" enctype="multipart/form-data">
				<?php if ($mode === "modify") : ?>
					<input type="hidden" name="num" value=<?= $num ?>>
					<input type="hidden" name="page" value=<?= $page ?>>
				<?php endif; ?>

				<input type="hidden" name="mode" value=<?= $mode ?>>
				<ul id="board_form">
					<li>
						<span class="col1">상품명 : </span>
						<span class="col2"><input name="name" type="text" value="<?= $name ?>"></span>
					</li>
					<li>
						<span class="col1">종류 : </span>
						<span class="col2"><input name="kind" type="text" value="<?= $kind ?>"></span>
					</li>
					<li>
						<span class="col1">원가 : </span>
						<span class="col2"><input name="price" type="text" value="<?= $price ?>"></span>
					</li>
					<li>
						<span class="col1">세일가격 : </span>
						<span class="col2"><input name="sale" type="text" value="<?= $sale ?>"></span>
					</li>
					<li>
						<span class="col1">설명 : </span>
						<span class="col2"><input name="content" type="text" value="<?= $content ?>"></span>
					</li>
					<li>
						<span class="col1"> 첨부 파일 : </span>
						<span class="col2"><input type="file" name="upfile">
							<?php if ($mode === "modify") : ?>
								<input type="checkbox" value="yes" name="file_delete">&nbsp;파일 삭제하기
								<br>현재 파일 : <?= $file_copied_0 ?>
							<?php endif; ?>
						</span>
					</li>
				</ul>
				<ul class="buttons">
					<li>
						<button class="btn btn-sm btn-primary" type="button" id="btn_input">완료</button>
					</li>
					<li>
						<button class="btn btn-sm btn-primary" type="button" id="btn_back">목록</button>
					</li>
				</ul>
			</form>
		</div> <!-- board_box -->
	</section>
	<!-- 푸터부분 시작 -->
	<footer>
		<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_footer.php" ?>
	</footer>
</body>

</html>