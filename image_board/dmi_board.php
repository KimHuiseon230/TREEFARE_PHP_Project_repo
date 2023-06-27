<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/db_connect.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/image_board.php";
session_start();
$ses_id = (isset($_SESSION['ses_id']) && $_SESSION['ses_id'] != '') ? $_SESSION['ses_id'] : '';
$ses_name = (isset($_SESSION['ses_name']) && $_SESSION['ses_name'] != '') ? $_SESSION['ses_name'] : '';
$ses_level = (isset($_SESSION['ses_level']) && $_SESSION['ses_level'] != '') ? $_SESSION['ses_level'] : '';
$imageboard = new ImageBoard($conn);


if (isset($_POST["mode"]) && $_POST["mode"] === "delete") {
    $num = $_POST["num"];
    $page = $_POST["page"];

    $copied_name = (isset($row["file_copied"]) && $row["file_copied"] != '') ? $row["file_copied"] : '';

    if ($copied_name != '') {
        $file_path = "./data/" . $copied_name;
        unlink($file_path);
    }

    $imageboard->del_of_num($num);
    echo "
	     <script>
	         location.href = 'board_list.php?page=$page';
	     </script>
	   ";
} elseif (isset($_POST["mode"]) && $_POST["mode"] === "insert") {

    //세션값확인
    if (!$ses_id) {
        echo ("
		<script>
		alert('게시판 글쓰기는 로그인 후 이용해 주세요!');
		history.go(-1)
		</script>    
        ");
        exit;
    }

    $subject = $_POST["subject"];
    $content = $_POST["content"];
    $rating = $_POST["rating"];
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
        'ses_id' => $ses_id,
        'ses_name' => $ses_name,
        'subject' => $subject,
        'content' => $content,
        'rating' => $rating,
        'regist_day' => $regist_day,
        'upfile_name' => $upfile_name,
        'upfile_type' => $upfile_type,
        'copied_file_name' => $copied_file_name
    ];
    $imageboard->insert_of_num($arr);
    echo "
	   <script>
	    location.href = 'board_list.php';
	   </script>
	";
} elseif (isset($_POST["mode"]) && $_POST["mode"] === "modify") {
    $num = $_POST["num"];
    $page = $_POST["page"];

    $subject = $_POST["subject"];
    $content = $_POST["content"];
    $rating = $_POST["rating"];
    $file_delete = (isset($_POST["file_delete"])) ? $_POST["file_delete"] : 'no';

    $row = $imageboard->find_of_num2($num);

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
        'subject' => $subject,
        'content' => $content,
        'rating' => $rating,
        'upfile_name' => $upfile_name,
        'upfile_type' => $upfile_type,
        'copied_file_name' => $copied_file_name,
    ];

    $imageboard->update_of_num($arr);
    echo "
	      <script>
	          location.href = 'board_list.php?page=$page';
	      </script>
	  ";
} elseif (isset($_POST["mode"]) && $_POST["mode"] === "admin_modify") {
    $num = $_POST["num"];
    // $page = $_POST["page"];

    $subject = $_POST["subject"];
    $content = $_POST["content"];
    $rating = $_POST["rating"];
    $file_delete = (isset($_POST["file_delete"])) ? $_POST["file_delete"] : 'no';

    $row = $imageboard->find_of_num2($num);

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
        'subject' => $subject,
        'content' => $content,
        'rating' => $rating,
        'upfile_name' => $upfile_name,
        'upfile_type' => $upfile_type,
        'copied_file_name' => $copied_file_name,
    ];

    $imageboard->update_of_num($arr);
    echo "
	      <script>
	          location.href = '../admin/admin_review.php';
	      </script>
	  ";
} else if (isset($_POST["mode"]) && $_POST["mode"] == "insert_ripple") {
    if (empty($_POST["ripple_content"])) {
        echo "<script>alert('내용입력요망!');history.go(-1);</script>";
        exit;
    }
    //"덧글을 다는사람은 로그인을 해야한다." 말한것이다.

    $ses_id = (isset($_SESSION['ses_id']) && $_SESSION['ses_id'] != '') ? $_SESSION['ses_id'] : '';
    $q_ses_id =  $ses_id;
    $rowcount = $imageboard->find_test($q_ses_id);

    if (!$rowcount) {
        echo "<script>alert('없는 아이디!!');history.go(-1);</script>";
        exit;
    } else {
        $content = $_POST["ripple_content"];
        $page = $_POST["page"];
        $parent = $_POST["parent"];
        $hit = $_POST["hit"];
        $q_parent = HTMLSPECIALCHARS($parent);
        $q_username = $_SESSION['ses_name'];
        $q_content = HTMLSPECIALCHARS($content);
        $regist_day = date("Y-m-d (H:i)");
        // 연관배열
        $arr = [
            'q_parent' =>  $q_parent,
            'q_ses_id' => $q_ses_id,
            'q_username' => $q_username,
            'q_content' => $q_content,
            'regist_day' => $regist_day,
        ];

        $imageboard->insert_image_board_ripple($arr);
        echo "<script>location.href='./board_view.php?num=$parent&page=$page';</script>";
    } //end of if rowcount
} else if (isset($_POST["mode"]) && $_POST["mode"] == "delete_ripple") {
    $page = $_POST["page"];
    $num = $_POST["num"];
    $parent = $_POST["parent"];

    $imageboard->del_image_board_ripple($num);
    echo "<script>location.href='./board_view.php?num=$parent&page=$page';</script>";
}
