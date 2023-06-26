<?php
// 공통적으로 처리하는 부분
$js_array = ['/js/notice_form.js'];
$title = "공지사항";
$menu_code = "notice";
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/php_treefare/image_board/css/board.css?v=<?= date('Ymdhis') ?>">
</head>

<body>
    <header>
        <header>
            <?php
            include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_header.php";
            include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/db_connect.php";
            include $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/create_table.php";
            create_table($conn, "notice");
            ?>
        </header>
        <section>
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
                        <li>
                            <span class="col1"> 첨부 파일</span>
                            <span class="col2"><input type="file" name="upfile"></span>
                        </li>
                    </ul>
                    <ul class="buttons">
                        <li><button type="button" id="complete">완료</button></li>
                        <li><button type="button" onclick="location.href='notice_list.php'">목록</button></li>
                    </ul>
                </form>
            </div>
        </section>
        <footer>
            <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_footer.php" ?>
        </footer>
</body>

</html>