<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST']; ?>/hwaeun/css/common.css">
</head>

<body>
  <header>
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc_header.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/db_connect.php";
    ?>
  </header>
  <section>
    <div class="main_content">
      <div class="center">
        <div>
          <h2>상품</h2>
          <div class="shop_top">
            <p> </p>
          </div>
          <?php

          $num = $_GET["num"];
          $page = $_GET["page"];

          $sql = "select * from `product` where num = :num";
          $stmt = $conn->prepare($sql);
          $stmt->bindParam(':num', $num);
          $stmt->setFetchMode(PDO::FETCH_ASSOC);
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


          $file_name   = $row['file_name'];
          $file_copied = $row['file_copied'];
          $file_type   = $row['file_type'];
          $file_size   = 0;

          if (!empty($file_name)) {
            $image_info = getimagesize("./data/" . $file_copied);
            $image_width = $image_info[0];
            $image_height = $image_info[1];
            $image_type = $image_info[2];
            $image_width = 400;
            $image_height = 180;
            if ($image_width > 400) $image_width = 400;
          } else {
            echo "
              <script>
                alert('가져올 내용이 없습니다.');
                history.go(-1);
              </script>
            ";
          }
          ?>
          <div class="order">
            <div class="product">
              <div class="context">
                <?php
                if (strpos($file_type, "image") !== false) {
                  $file_size = filesize("./data/" . $file_copied);
                  $real_name = $file_copied;
                  echo "<img src='./data/$file_copied' width='$image_width' class='img'><br>";
                } else if ($file_name) {
                  $real_name = $file_copied;
                  $file_path = "./data/" . $real_name;
                  $file_size = filesize($file_path);
                }
                ?>
              </div>

              <form name="cart_form" action="../cart/cart_di.php" method="POST">
                <input type="hidden" name="mode" value="insert">
                <input type="hidden" name="file_name" value="<?= $file_name ?>">
                <input type="hidden" name="file_type" value="<?= $file_type ?>">
                <input type="hidden" name="file_copied" value="<?= $file_copied ?>">
                <input type="hidden" name="type" value="<?= $type ?>">
                <input type="hidden" name="name" value="<?= $name ?>">
                <input type="hidden" name="price" value="<?= $price ?>">
                <input type="hidden" name="content" value="<?= $content ?>">
                <ul id="view_shop">
                  <li class="name"><?= $name ?></li>
                  <li class="price"><?= "&#92;" . $price . "원" ?></li>
                  <li class="content"><?= $content ?></li>
                  <li class="options">
                    수량
                    <select name="count" id="select_count">
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                    </select>
                  </li>
                  <li class="cart"><button class="green_button">장바구니</button></li>
                </ul>
              </form>
            </div>


          </div>

          <ul class="buttons">
            <li><button type="button" onclick="location.href='shop_list.php'" class="green_button">목록</button></li>
            <?php
            $id = isset($_SESSION['id']) ? $_SESSION['id'] : "";
            if ($id == 'admin') {
              echo "
                  <li class=\"inline\">
                    <form class=\"inline\" action=\"shop_modify_form.php\" method=\"POST\">
                      <button class=\"green_button\">수정</button>
                      <input type=\"hidden\" name=\"id\" value={$id}>
                      <input type=\"hidden\" name=\"num\" value={$num}>
                      <input type=\"hidden\" name=\"hit\" value=\"$hit\">
                      <input type=\"hidden\" name=\"page\" value={$page}>
                      <input type=\"hidden\" name=\"mode\" value=\"modify\">
                    </form>
                  </li>
                  <li class=\"inline\">
                    <form class=\"inline\" action=\"shop_dui.php\" method=\"POST\">
                      <button class=\"red_button\">삭제</button>
                      <input type=\"hidden\" name=\"id\" value={$id}>
                      <input type=\"hidden\" name=\"num\" value={$num}>
                      <input type=\"hidden\" name=\"page\" value={$page}>
                      <input type=\"hidden\" name=\"name\" value={$name}>
                      <input type=\"hidden\" name=\"mode\" value=\"delete\">
                    </form>
                  </li>
                  ";
            }
            ?>
          </ul>
        </div>
      </div>
    </div>
    </div>
  </section>
  <footer>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc_footer.php" ?>
  </footer>
</body>
<script src="http://<?= $_SERVER['HTTP_HOST']; ?>/hwaeun/js/header.js"></script>

</html>
<style>
  .main_content {
    padding-top: 90px;
    width: 100%;
    min-width: 1320px;
    font-family: 'S-CoreDream-3Light';
  }

  .main_content a {
    text-decoration-line: none;
  }

  .blank {
    height: 8px;
  }

  .center {
    display: flex;
    justify-content: center;
    margin-bottom: 50px;
  }

  .somenu {
    font-family: 'YUniverse-B';
    display: flex;
    flex-direction: column;
    font-size: 23px;
    margin-top: 20px;
    margin-right: 150px;
  }

  .somenu li {
    margin-top: 5px;
  }

  #li_somenu {
    color: rgb(200, 200, 200);
    font-family: 'S-CoreDream-3Light';
    font-size: 16px;
  }

  #li_somenu:hover {
    color: #5d7759;
    font-size: 18px;
  }

  #title_somenu {
    color: #2b3729;
    font-family: 'YUniverse-B';
  }

  #li_somenu_first {
    color: #2b3729;
    font-family: 'S-CoreDream-3Light';
    font-size: 18px;
  }

  .minimap {
    margin-top: 10px;
    font-size: 13px;
    width: 100%;
    min-width: 1320px;
  }

  .minimap ul {
    display: flex;
    padding-left: 160px;
  }

  .minimap ul li {
    padding: 2px 5px;
  }

  .minimap a {
    color: var(--normal_font);
  }

  .gray {
    color: rgb(204, 204, 204);
  }

  .title_line {
    height: 1px;
    background-color: #2b3729;
    margin: 0;
  }

  .box {
    display: flex;
    align-items: center;
    padding: 5px;
    justify-content: space-between;
    margin-top: 5px;
    margin-bottom: 5px;
  }

  #view_shop {
    display: flex;
    flex-direction: column;
    padding: 30px 5px 30px 5px;
    width: 400px;
  }

  .title {
    width: 300px;
  }

  .title span {
    margin-left: 15px;
  }

  .shop_top {
    border-bottom: 2px solid #3a4a37;
  }

  .shop_top p {
    margin-bottom: 5px;
    font-weight: 600;
  }

  .red_button {
    border: none;
    background-color: #782f2f;
    color: white;
    height: 40px;
    width: 100px;
    font-family: 'S-CoreDream-3Light';
    margin-right: 20px;
    float: right;
  }

  .green_button {
    border: none;
    background-color: #3a4a37;
    color: white;
    height: 40px;
    width: 100px;
    font-family: 'S-CoreDream-3Light';
    margin-right: 20px;
    float: right;
  }

  .context {
    padding: 10px;
    margin-bottom: 40px;
  }

  .context img {
    text-align: center;
  }

  .content {
    padding: 5px;
    margin-top: 5px;
  }

  .buttons {
    display: flex;
    justify-content: flex-end;
    margin-top: 40px;
  }

  .product {
    display: flex;
  }

  .type {
    color: #a2a2a2;
    font-size: 16px;
  }

  .name {
    font-size: 25px;
    font-weight: 600;
    margin-top: 20px;
  }

  .price {
    font-size: 25px;
    font-weight: 600;
    color: #2b3729;
    margin-top: 30px;
  }

  .content {
    margin-top: 20px;
  }

  #ripple_title ul {
    padding: 0;
    margin: 5px;
  }

  #ripple_comment {
    margin-bottom: 5px;
    font-weight: 600;
  }

  #ripple_insert {
    display: flex;
  }

  #ripple_textarea {
    border: 1px solid #9d9d9d;
    padding: 5px;
    margin-right: 10px;
  }

  #ripple_textarea textarea {
    resize: none;
    border: none;
    background-color: transparent;
    outline: none;
    font-size: 14px;
    font-family: 'S-CoreDream-3Light';
    width: 700px;
  }

  .ripple_button {
    border: none;
    background-color: #3a4a37;
    color: white;
    font-family: 'S-CoreDream-3Light';
    height: 73px;
    width: 90px;
  }

  .ripple_delete_button {
    border: none;
    background-color: #782f2f;
    color: white;
    height: 15px;
    width: 15px;
    font-family: 'S-CoreDream-3Light';
    text-align: center;
    font-size: 5px;
    padding: 0;
  }

  .ripple_list {
    display: flex;
    flex-direction: column;
  }

  .ripple_list li:nth-child(1) {
    font-weight: 600;
  }

  #ripple_line {
    margin: 2px auto;
    margin-top: 4px;
  }

  #select_count {
    border: 1px solid #2b3729;
    margin-top: 15px;
    font-size: 18px;
    width: 100px;
    height: 35px;
  }

  .count {
    margin-top: 50px;
    display: flex;
    flex-direction: column;
  }

  .cart {
    margin-top: 50px;
  }

  .cart .green_button {
    float: left;
  }
</style>