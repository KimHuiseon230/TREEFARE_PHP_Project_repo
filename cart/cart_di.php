<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/db_connect.php";
include $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/create_table.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/cart.php";
$cart = new Cart($conn);
create_table($conn, "cart");

session_start();
if (isset($_SESSION["ses_id"])) $id = $_SESSION["ses_id"];
else $id = "";
if (isset($_SESSION["ses_name"])) $name = $_SESSION["ses_name"];
else $name = "";

if (!$id) {
  echo ("
      <script>
        alert('로그인 후 이용이 가능합니다.');
        history.go(-1)
      </script>
    ");
  exit;
}

$mode = (isset($_POST['mode']) && $_POST['mode'] != '') ? $_POST['mode'] : '';
$mode2 = (isset($_POST['mode2']) && $_POST['mode2'] != '') ? $_POST['mode2'] : '';



switch ($mode) {
  case "insert":
    $arr = [
      'id' => $id,
      'name' => $_POST['name'],
      'sale' => $_POST['sale'],
      'count' => $_POST['count'],
      'regist_day' => date("Y-m-d [H:i]"),
      'file_name' => $_POST['file_name'],
      'file_type' => $_POST['file_type'],
      'file_copied' => $_POST['file_copied']
    ];
    $result = $cart->insert_of_num($arr);

    echo "
          <script>
            if(!confirm('장바구니로 이동하시겠습니까?')){
              history.go(-1)
            }else{
              location.href = 'cart_list.php';
            }
          </script>
       	";
    break;
  case "delete":
    $num_item = 0;
    if (isset($_POST["item"])) {
      $num_item = count($_POST["item"]);
    }

    for ($i = 0; $i < $num_item; $i++) {
      $s_num = $_POST['item'][$i];
      $cart->del_of_num($s_num);
    }
    header("location:cart_list.php");
    exit();

    break;
  case "delete2":
    $num_item = 0;
    if (isset($_POST["item"])) {
      $num_item = count($_POST["item"]);
    }

    for ($i = 0; $i < $num_item; $i++) {
      $s_num = $_POST['item'][$i];
      $cart->del_of_num($s_num);
    }
    header("location:../pay/pay.php");
    exit();

    break;
  case "calculate":
    $num_item = $calculate = 0;

    if (isset($_GET["item"])) {
      $num_item = count($_GET["item"]);
    } else {
      echo ("
            <script>
              alert('계산할 상품을 선택해주세요!');
              history.go(-1)
            </script>
          ");
    }

    for ($i = 0; $i < $num_item; $i++) {
      $s_num = $_GET['item'][$i];

      $row = $cart->calculate($s_num);

      $per_price = (int)str_replace(',', '', $row['s_price']);

      $per_count = (int)$row['s_count'];

      $calculate += $per_price * $per_count;
    }
    break;
}

switch ($mode2) {
  case "insert2":
    $arr = [
      'id' => $id,
      'name' => $_POST['name'],
      'sale' => $_POST['sale'],
      'count' => $_POST['count'],
      'regist_day' => date("Y-m-d [H:i]"),
      'file_name' => $_POST['file_name'],
      'file_type' => $_POST['file_type'],
      'file_copied' => $_POST['file_copied']
    ];
    $result = $cart->insert_of_num($arr);

    echo "
          <script>
              location.href = '../pay/pay.php';
          </script>
       	";
    break;
}
