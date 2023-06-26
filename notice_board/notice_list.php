<!DOCTYPE html>
<html>

<?php
// 공통적으로 처리하는 부분
$js_array = ['/image_board/js/board.js', '/image_board/js/board_form.php',  '/image_board/js/board_excel.js'];
$title = "공지사항";
$menu_code = "notice";
?>

<head>
    <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/php_treefare/image_board/css/board.css?v=<?= date('Ymdhis') ?>">
</head>

<body>
    <header>
        <?php
        include $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_header.php";
        include $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/page_lib.php";
        include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/db_connect.php";
        include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/create_table.php";
        create_table($conn, "notice");

        ?>
    </header>
    <section>
        <div id="board_box" class="container w-50">
            <h3>
                공지사항 > 목록보기
            </h3>
            <ul id="board_list">
                <li>
                    <span class="col1">번호</span>
                    <span class="col2">제목</span>
                    <span class="col3">날짜</span>
                    <span class="col4">조회수</span>
                </li>
                <?php

                $page = (isset($_GET["page"]) && is_numeric($_GET["page"]) && $_GET["page"] != "") ? $_GET["page"] : 1;
                $sql = "select count(*) as cnt from notice order by num desc";
                $stmt = $conn->prepare($sql);
                $stmt->setFetchMode(PDO::FETCH_ASSOC);

                $result = $stmt->execute();
                $row = $stmt->fetch();
                $total_record = $row['cnt'];
                $scale = 10;             // 전체 페이지 수($total_page) 계산


                // 전체 페이지 수($total_page) 계산 
                if ($total_record % $scale == 0)
                    $total_page = floor($total_record / $scale);
                else
                    $total_page = floor($total_record / $scale) + 1;

                // 표시할 페이지($page)에 따라 $start 계산  
                $start = ($page - 1) * $scale;

                $number = $total_record - $start;
                $sql2 = "select * from  notice order by num desc limit {$start}, {$scale}";
                $stmt2 = $conn->prepare($sql2);
                $stmt2->setFetchMode(PDO::FETCH_ASSOC);

                $result = $stmt2->execute();
                $rowArray = $stmt2->fetchAll();

                foreach ($rowArray as $row) {
                    // mysqli_data_seek($result, $i);
                    // 가져올 레코드로 위치(포인터) 이동

                    // 하나의 레코드 가져오기
                    $num         = $row["num"];
                    // $id          = $row["id"];
                    // $name        = $row["name"];
                    $subject     = $row["subject"];
                    $regist_date  = $row["regist_date"];
                    $hit         = $row["hit"];
                    if ($row["file_name"])
                        $file_image = "<img src='./img/file.gif'>";
                    else
                        $file_image = " ";
                ?>
                    <li>
                        <span class="col1"><?= $number ?></span>
                        <span class="col2"><a href="notice_view.php?num=<?= $num ?>&page=<?= $page ?>"><?= $subject ?></a></span>
                        <span class="col3"><?= $regist_date ?></span>
                        <span class="col4"><?= $hit ?></span>
                    </li>
                <?php
                    $number--;
                }
                ?>
            </ul>

            <div class="container d-flex justify-content-center align-items-start gap-2 mb-3">
                <?php
                $page_limit = 5;
                echo pagination($total_record, 10, $page_limit, $page);

                ?>
            </div>

            <ul class="buttons">
                <li>
                    <button onclick="location.href='notice_list.php'">목록</button>
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