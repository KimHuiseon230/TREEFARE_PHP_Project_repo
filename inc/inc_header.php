<?php
//보안부분(세션등록, 체크할내용, GET, POST)
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

$ses_id = (isset($_SESSION['ses_id']) && $_SESSION['ses_id'] != '') ? $_SESSION['ses_id'] : '';
$ses_name = (isset($_SESSION['ses_name']) && $_SESSION['ses_name'] != '') ? $_SESSION['ses_name'] : '';
$ses_level = (isset($_SESSION['ses_level']) && $_SESSION['ses_level'] != '') ? $_SESSION['ses_level'] : '';

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= (isset($title) && $title != '') ? $title : 'TEST' ?></title>
  <!-- 부트스트랩 css -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- 부트스트랩 js -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- 폰트어썸 -->
  <script src="https://kit.fontawesome.com/6a2bc27371.js" crossorigin="anonymous"></script>
  <!-- Favicon-->
  <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
  <!-- Font Awesome icons (free version)-->
  <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
  <!-- Google fonts-->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
  <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
  <!-- Core theme CSS (includes Bootstrap)-->
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/php_treefare/css/footer.css?v=<?= date('Ymdhis') ?>">
  <!-- <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/php_treefare/css/styles.css?v=<?= date('Ymdhis') ?>"> -->
  <!-- 외부스크립트 -->
  <?php
  if (isset($js_array)) {
    foreach ($js_array as $value) {
      print "<script src='http://" . $_SERVER['HTTP_HOST'] . "/php_treefare/$value?v=" . date('Ymdhis') . "' defer></script>" . PHP_EOL;
    }
  }

  if (isset($css_array)) {
    foreach ($css_array as $value) {
      print "<link rel=\"stylesheet\" href=\"http://{$_SERVER['HTTP_HOST']}/php_treefare/{$value}?v=" . date('Ymdhis') . "\">";
    }
  }
  ?>

</head>

<body>
  <nav class="navbar bg-light fixed-top d-flex ">
    <div class="container-fluid justify-content-end">
      <a style="position: fixed; left: 43%;" class="navbar-brand" href="http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/index.php' ?>" class="nav-link <?= ($menu_code == 'home') ? 'active' : '' ?>"><img id="imglog" style="width: 250px; height: auto; ;" src="http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/images/log/003.png' ?>" alt=""></a>
      <div class="navbar navbar-expand-lg" id="mainNav">
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
            <div class="d-flex align-items-end">
              <?php if (isset($ses_id) && $ses_id != '' && $ses_level != 10) { ?>
                <!-- 로그인상태 -->
                <li class="nav-item"><a href="#" class="nav-link"><?= $ses_name  . "님" ?></a></li>
                <li class="nav-item"><a href="http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/product/product_list.php' ?>" class="nav-link <?= ($menu_code == 'intro') ? 'active' : '' ?>">상품</a></li>
                <li class="nav-item"><a href="http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/image_board/board_list.php' ?>" class="nav-link <?= ($menu_code == 'board') ? 'active' : '' ?>">리뷰게시판</a></li>
                <li class="nav-item"><a href="http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/member/member_modify_form.php' ?>" class="nav-link <?= ($menu_code == 'member') ? 'active' : '' ?>">회원수정</a></li>
                <li class="nav-item"><a href="http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/pg/logout.php' ?>" class="nav-link <?= ($menu_code == 'login') ? 'active' : '' ?>">로그아웃</a></li>
                <div class="dropdown" style="text-decoration-line: none;">
                  <a href="#" class="btn" role="text" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false" style="">
                    메뉴
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <li><a class="dropdown-item" href=" http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/message/message_box.php' ?>">문의하기</a></li>
                    <li><a class="dropdown-item" href=" http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/notice_board/notice_list.php' ?>">공지사항</a></li>
                  </ul>
                </div>
                <li class="nav-item"><a href="http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/cart/cart_list.php' ?>"><img src="http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/images/shopping-cart.png' ?>" style="width: 25px; height: 25px; margin-bottom: 7px; margin-left: 10px; margin-right: 90px;"></a></li>
              <?php  } else { ?>
                <!-- 비 로그인상태 -->
                <li class="nav-item"><a href="http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/index.php' ?>" class="nav-link <?= ($menu_code == 'board') ? 'active' : '' ?>">Home</a></li>
                <li class="nav-item"><a href="http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/product/product_list.php' ?>" class="nav-link <?= ($menu_code == 'intro') ? 'active' : '' ?>">상품</a></li>
                <li class="nav-item"><a href="http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/inc/Introduction.php' ?>" class="nav-link <?= ($menu_code == 'board') ? 'active' : '' ?>">사이트소개</a></li>
                <li class="nav-item"><a href="http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/image_board/board_list.php' ?>" class="nav-link <?= ($menu_code == 'board') ? 'active' : '' ?>">리뷰게시판</a></li>
                <li class="nav-item"><a href="http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/stipulation.php' ?>" class="nav-link <?= ($menu_code == 'member') ? 'active' : '' ?>">회원가입</a></li>
                <li class="nav-item"><a href="http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/login/login_form.php' ?>" class="nav-link <?= ($menu_code == 'login') ? 'active' : '' ?>">로그인</a></li>
              <?php  } ?>
          </ul>
        </div>

      </div>
    </div>


  </nav>
</body>

</html>