<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/db_connect.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/product.php";
$product = new Product($conn);
session_start();
if (isset($_SESSION["seid"])) $userid = $_SESSION["seid"];
if (isset($_SESSION["sename"])) $username = $_SESSION["sename"];
if (isset($_POST["mode"]) && $_POST["mode"] === "delete") {
    $num = $_POST["num"];
    $page = $_POST["page"];
    $product->find_of_num($num);

    // $copied_name = $row["file_copied"];
    // if ($copied_name) {
    //     $file_path = "./data/" . $copied_name;
    //     // unlink($file_path);
    // }

    $product->del_of_num($num);
    echo "
	     <script>
	         location.href = 'product_list.php?page=$page';
	     </script>
	   ";
} elseif (isset($_POST["mode"]) && $_POST["mode"] === "insert") {

    //세션값확인
    if (!$userid) {
        echo ("
		<script>
		alert('게시판 글쓰기는 로그인 후 이용해 주세요!');
		history.go(-1)
		</script>    
        ");
        exit;
    }
    $name = $_POST["name"];
    $kind = $_POST["kind"];
    $price = $_POST["price"];
    $sale = $_POST["sale"];
    $content = $_POST["content"];
    $regist_day = date("Y-m-d (H:i)");  // 현재의 '년-월-일-시-분'을 저장
    $upload_dir = "./data/";
    $upfile_name = $_FILES["upfile"]["name"];
    $upfile_tmp_name = $_FILES["upfile"]["tmp_name"];
    $upfile_type = $_FILES["upfile"]["type"];
    $upfile_size = $_FILES["upfile"]["size"];  // 안되면 php init 에서 최대 크기 수정!
    $upfile_error = $_FILES["upfile"]["error"];

    if ($upfile_name && !$upfile_error) { // 업로드가 잘되었는지 판단
        $file = explode(".", $upfile_name); // trim과 같다. (memo.sql)
        $file_name = $file[0]; //(memo)
        $file_ext = $file[1]; //(sql)

        $new_file_name = date("Y_m_d_H_i_s");
        $new_file_name = $new_file_name . "_" . $file_name;
        $copied_file_name = $new_file_name . "." . $file_ext; // 2020_09_23_11_10_20_memo.sql
        $uploaded_file = $upload_dir . $copied_file_name; // ./data/2020_09_23_11_10_20_memo.sql 다 합친것

        if ($upfile_size > 1000000) {
            echo ("
				<script>
				alert('업로드 파일 크기가 지정된 용량(1MB)을 초과합니다!<br>파일 크기를 체크해주세요! ');
				history.go(-1)
				</script>
				");
            exit;
        }
        if (!move_uploaded_file($upfile_tmp_name, $uploaded_file)) {
            echo ("
					<script>
					alert('파일을 지정한 디렉토리에 복사하는데 실패했습니다.');
					history.go(-1)
					</script>
				");
            exit;
        }
    } else {
        $upfile_name = "";
        $upfile_type = "";
        $copied_file_name = "";
    }


    // 연관배열
    $arr = [
        'name' => $name,
        'kind' => $kind,
        'price' => $price,
        'sale' => $sale,
        'content' => $content,
        'upfile_name' => $upfile_name,
        'upfile_type' => $upfile_type,
        'copied_file_name' => $copied_file_name,
        'regist_day' => $regist_day
    ];
    $product->insert_of_num($arr);

    // $sql = "insert into image_board (id, name, subject, content, regist_day, hit,  file_name, file_type, file_copied) ";
    // $sql .= "values('$userid', '$username', '$subject', '$content', '$regist_day', 0, ";
    // $sql .= "'$upfile_name', '$upfile_type', '$copied_file_name')";
    // $stmt = $conn->prepare($sql); // $sql 에 저장된 명령 실행
    // $stmt->execute();

    // 포인트 부여하기
    $point_up = 100;

    // $sql = "select point from `member` where id='$seid'";
    // $stmt = $conn->prepare($sql);
    // $row = $stmt->fetch();
    // // $result = mysqli_query($con, $sql);
    // // $row = mysqli_fetch_array($result);
    // $new_point = $row["point"] + $point_up;

    // $sql = "update `member` set point=$new_point where id='$seid'";
    // $stmt = $conn->prepare($sql);
    // $stmt->execute();

    echo "
	   <script>
	    location.href = 'product_list.php';
	   </script>
	";
} elseif (isset($_POST["mode"]) && $_POST["mode"] === "modify") {

    $num = $_POST["num"];
    $page = $_POST["page"];
    $name = $_POST["name"];
    $price = $_POST["price"];
    $sale = $_POST["sale"];
    $content = $_POST["content"];
    $regist_day = date("Y-m-d (H:i)");  // 현재의 '년-월-일-시-분'을 저장
    $file_delete = (isset($_POST["file_delete"])) ? $_POST["file_delete"] : 'no';

    $row = $product->find_of_num2($num);

    $copied_name = $row["file_copied"];

    $upfile_name = $row["file_name"];
    $upfile_type = $row["file_type"];
    $copied_file_name = $row["file_copied"];
    if ($file_delete === "yes") {
        if ($copied_name) {
            $file_path = "./data/" . $copied_name;
            unlink($file_path);
        }
        $upfile_name = "";
        $upfile_type = "";
        $copied_file_name = "";
    } else {
        if (isset($_FILES["upfile"])) {
            if ($copied_name) {
                /* $file_path = "./data/" . $copied_name;
                unlink($file_path); */
            }

            $upload_dir = "./data/";

            $upfile_name = $_FILES["upfile"]["name"];
            $upfile_tmp_name = $_FILES["upfile"]["tmp_name"];
            $upfile_type = $_FILES["upfile"]["type"];
            $upfile_size = $_FILES["upfile"]["size"];  // 안되면 php init 에서 최대 크기 수정!
            $upfile_error = $_FILES["upfile"]["error"];
            if ($upfile_name && !$upfile_error) { // 업로드가 잘되었는지 판단
                $file = explode(".", $upfile_name); // trim과 같다. (memo.sql)
                $file_name = $file[0]; //(memo)
                $file_ext = $file[1]; //(sql)

                $new_file_name = date("Y_m_d_H_i_s");
                $new_file_name = $new_file_name . "_" . $file_name;
                $copied_file_name = $new_file_name . "." . $file_ext; // 2020_09_23_11_10_20_memo.sql
                $uploaded_file = $upload_dir . $copied_file_name; // ./data/2020_09_23_11_10_20_memo.sql 다 합친것

                if ($upfile_size > 1000000) {
                    echo ("
				<script>
				alert('업로드 파일 크기가 지정된 용량(1MB)을 초과합니다!<br>파일 크기를 체크해주세요! ');
				history.go(-1)
				</script>
				");
                    exit;
                }

                if (!move_uploaded_file($upfile_tmp_name, $uploaded_file)) {
                    echo ("
					<script>
					alert('파일을 지정한 디렉토리에 복사하는데 실패했습니다.');
					history.go(-1)
					</script>
				");
                    exit;
                }
            } else {
                $upfile_name = $row["file_name"];
                $upfile_type = $row["file_type"];
                $copied_file_name = $row["file_copied"];
            }
        }
    }
    // 연관배열
    $arr = [
        'num' => $num,
        'name' => $name,
        'price' => $price,
        'sale' => $sale,
        'content' => $content,
        'upfile_name' => $upfile_name,
        'upfile_type' => $upfile_type,
        'copied_file_name' => $copied_file_name,
        'regist_day' => $regist_day
    ];

    $product->update_of_num($arr);

    // $sql = "update `image_board` set subject=:subject, content=:content,  file_name=:upfile_name, file_type=:upfile_type, file_copied=:copied_file_name";
    // $sql .= " where num=$num";
    // $stmt = $conn->prepare($sql);
    // $stmt->bindParam(':subject', $subject);
    // $stmt->bindParam(':content', $content);
    // $stmt->bindParam(':upfile_name', $upfile_name);
    // $stmt->bindParam(':upfile_type', $upfile_type);
    // $stmt->bindParam(':copied_file_name', $copied_file_name);
    // $result = $stmt->execute();
    echo "
	      <script>
	          location.href = 'product_list.php?page=$page';
	      </script>
	  ";
} else if (isset($_POST["mode"]) && $_POST["mode"] == "insert_ripple") {
    if (empty($_POST["ripple_content"])) {
        echo "<script>alert('내용입력요망!');history.go(-1);</script>";
        exit;
    }
    //"덧글을 다는사람은 로그인을 해야한다." 말한것이다.

    $userid = (isset($_SESSION['seuserid']) && $_SESSION['seuserid'] != '') ? $_SESSION['seuserid'] : '';

    $q_userid =  $userid;

    $sql = "select * from `member` where id =:q_userid";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':q_userid', $q_userid);
    $row = $stmt->fetch();
    $result = $stmt->execute();


    exit;
    if (!$result) {
        die('Error: ' . mysqli_error($conn));
    }

    // $rowcount = mysqli_num_rows($result);


    if (!$rowcount) {
        echo "<script>alert('없는 아이디!!');history.go(-1);</script>";
        exit;
    } else {
        $content = $_POST["ripple_content"];
        $page = $_POST["page"];
        $parent = $_POST["parent"];
        $hit = $_POST["hit"];
        $q_usernick = isset($_SESSION['usernick']) ? HTMLSPECIALCHARS($_SESSION['usernick']) : null;

        $q_username = $_SESSION['username'];

        $q_content = HTMLSPECIALCHARS($content);
        $q_parent = HTMLSPECIALCHARS($parent);
        $regist_day = date("Y-m-d (H:i)");

        $sql = "INSERT INTO `image_board_ripple` VALUES (null,'$q_parent','$q_userid','$q_username', '$q_usernick','$q_content','$regist_day')";
        $stmt = $conn->prepare($sql);
        $row = $stmt->fetch();
        $result = $stmt->execute();

        if (!$result) {
            die('Error: ' . mysqli_error($conn));
        }
        echo "<script>location.href='./board_view.php?num=$parent&page=$page&hit=$hit';</script>";
    } //end of if rowcount
} else if (isset($_POST["mode"]) && $_POST["mode"] == "delete_ripple") {
    $page = $_POST["page"];
    $hit = $_POST["hit"];
    $num = $_POST["num"];
    $parent = $_POST["parent"];

    $sql = "DELETE FROM `image_board_ripple` WHERE num=:num";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':num', $num);
    $result = $stmt->execute();
    $row = $stmt->fetch();
    if (!$result) {
        die('Error: ' . mysqli_error($conn));
    }
    echo "<script>location.href='./board_view.php?num=$parent&page=$page&hit=$hit';</script>";
}
