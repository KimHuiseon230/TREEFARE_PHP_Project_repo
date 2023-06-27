<!DOCTYPE html>
<html>

<?php
// 공통적으로 처리하는 부분
$js_array = ['/image_board/js/board.js', '/image_board/js/board_form.php',  '/image_board/js/board_excel.js'];
$title = "공지사항";
$menu_code = "notice";
?>

<head>
    <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/php_treefare/notice_board/css/board.css?v=<?= date('Ymdhis') ?>">
</head>

<body>
    <header>
        <?php
        include $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_header.php";
        include $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/page_lib.php";
        include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/db_connect.php";
        include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/create_table.php";
        include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/notice_board.php";
        $noticeboard = new NoticeBoard($conn);
        create_table($conn, "notice");

        ?>
    </header>
    <section style="margin-top: 100px">
        <div id="board_box">
            <div id="board_box">
                <h3>
                    게시판 > 목록보기
                </h3>
                <table class="table table-striped table-hover">
                    <thead class="table-light">
                        <th>번호</th>
                        <th>제목</th>
                        <th>첨부</th>
                        <th>등록일</th>
                        <th>조회</th>
                    </thead>
                    <?php

                    $page = (isset($_GET["page"]) && is_numeric($_GET["page"]) && $_GET["page"] != "") ? $_GET["page"] : 1;
                    $row = $noticeboard->row_cnt();
                    $total_record = $row['cnt'];
                    $scale = 5;             // 전체 페이지 수($total_page) 계산


                    // 전체 페이지 수($total_page) 계산 
                    if ($total_record % $scale == 0)
                        $total_page = floor($total_record / $scale);
                    else
                        $total_page = floor($total_record / $scale) + 1;

                    // 표시할 페이지($page)에 따라 $start 계산  
                    $start = ($page - 1) * $scale;
                    $number = $total_record - $start;
                    $rowArray = $noticeboard->row_limit($start, $scale);

                    foreach ($rowArray as $row) {
                        // mysqli_data_seek($result, $i);
                        // 가져올 레코드로 위치(포인터) 이동
                        // 하나의 레코드 가져오기
                        $num         = $row["num"];
                        $subject     = $row["subject"];
                        $regist_date  = $row["regist_date"];
                        $hit         = $row["hit"];
                        if ($row["file_name"])
                            $file_image = "<img src='./img/file.gif'>";
                        else
                            $file_image = " ";
                    ?>
                        <tbody>
                            <td><?= $number ?></td>
                            <td><a href="notice_view.php?num=<?= $num ?>&page=<?= $page ?>"><?= $subject ?></a></td>
                            <td><?= $file_image ?></td>
                            <td><?= $regist_date ?></td>
                            <td><?= $hit ?></td>
                        </tbody>
                    <?php
                        $number--;
                    }
                    ?>
                </table>

                <div class="container d-flex justify-content-center align-items-start gap-2 mb-3">
                    <?php
                    $page_limit = 5;
                    echo pagination($total_record, $scale, $page_limit, $page);

                    ?>
                </div>

                <ul class="buttons">
                    <li>
                        <button class="btn btn-primary" onclick="location.href='notice_list.php'">목록</button>
                    </li>
                    <li>
                        <?php
                        if ($ses_level == 10) {
                        ?>
                            <button class="btn btn-primary" onclick="location.href='notice_form.php'">글쓰기</button>
                        <?php
                        }
                        ?>
                    </li>
                </ul>
            </div>
    </section>
    <footer>
        <?php include $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_footer.php"; ?>
    </footer>
</body>

</html>