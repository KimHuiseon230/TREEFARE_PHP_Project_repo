<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/db_connect.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/product.php";
$product = new Product($conn);
session_start();
if (isset($_SESSION["ses_id"])) $userid = $_SESSION["ses_id"];
if (isset($_SESSION["ses_name"])) $username = $_SESSION["ses_name"];
if (isset($_SESSION["ses_level"])) $ses_level = $_SESSION["ses_level"];
if (isset($_POST["mode"]) && $_POST["mode"] === "delete") {
    $num = $_POST["num"];
    $page = $_POST["page"];

    $product->find_of_num($num);
    $product->del_of_num($num);
    echo "
	     <script>
	         location.href = 'product_list.php?page=$page';
	     </script>
	   ";
} elseif (isset($_POST["mode"]) && $_POST["mode"] === "insert") {

    //세션값확인
    if ($ses_level != 10) {
        echo ("
		<script>
		alert('권한이 없습니다.');
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

        if ($upfile_size > 5000000) {
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
    echo ("
	   <script>
	    self.location.href = 'http://{$_SERVER['HTTP_HOST']}/php_treefare/admin/admin_product.php';
	   </script>
	");
} elseif (isset($_POST["mode"]) && $_POST["mode"] === "modify") {

    $num = $_POST["num"];
    $page = $_POST["page"];
    $name = $_POST["name"];
    $kind = $_POST["kind"];
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
                    die("
                        <script>
                        alert('업로드 파일 크기가 지정된 용량(1MB)을 초과합니다!<br>파일 크기를 체크해주세요! ');
                        history.go(-1)
                        </script>
				       ");
                }

                if (!move_uploaded_file($upfile_tmp_name, $uploaded_file)) {
                    die("
                        <script>
                        alert('파일을 지정한 디렉토리에 복사하는데 실패했습니다.');
                        history.go(-1)
                        </script>
	            	    ");
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
        'kind' => $kind,
        'price' => $price,
        'sale' => $sale,
        'content' => $content,
        'upfile_name' => $upfile_name,
        'upfile_type' => $upfile_type,
        'copied_file_name' => $copied_file_name,
        'regist_day' => $regist_day
    ];

    $product->update_of_num($arr);
    echo "
	      <script>
	          location.href = '../admin/admin_product.php';
	      </script>
	  ";
}
