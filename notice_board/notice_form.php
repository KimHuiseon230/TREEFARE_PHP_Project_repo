<?php
session_start();
$ses_level = (isset($_SESSION['ses_level']) && $_SESSION['ses_level'] != '') ? $_SESSION['ses_level'] : '';
// 공통적으로 처리하는 부분
$js_array = ['/js/notice_form.js'];
$title = "공지사항";
$menu_code = "notice";
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/php_treefare/notice_board/css/board.css?v=<?= date('Ymdhis') ?>">
</head>

<body>
    <header>
        <header>
            <?php
            if ($ses_level == 10) {
                include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_admin_header.php";
            } else {
                include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_header.php";
            }
            include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/db_connect.php";
            include $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/create_table.php";
            create_table($conn, "notice");
            ?>
        </header>
        <section style="margin-top: 100px; height: calc(100vh - 380px);">
            <div id="board_box">
                <h3 id="board_title">
                    공지사항 > 글쓰기
                </h3>
                <form name="notice_form" method="post" action="notice_insert.php" enctype="multipart/form-data">
                    <ul id="notice_form">
                        <li>
                            <span class="col1">제목 : </span>
                            <span class="col2"><input name="subject" type="text"></span>
                        </li>
                        <li id="text_area">
                            <span class="col1">내용 : </span>
                            <span class="col2">
                                <textarea name="content"></textarea>
                            </span>
                        </li>
                        <li id="file_li">
                            <span class="col1"> 첨부 파일</span>
                            <span class="col2"><input type="file" name="upfile"></span>
                        </li>
                    </ul>
                    <ul class="buttons">
                        <li><button class="btn btn-primary" id="complete">완료</button></li>
                        <li><button type="button" class="btn btn-primary" id="btn_back">목록</button></li>
                    </ul>
                </form>
            </div>
        </section>
        <footer>
            <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_footer.php" ?>
        </footer>
</body>

</html>