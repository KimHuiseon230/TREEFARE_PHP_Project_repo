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
  <nav class="navbar bg-dark fixed-top d-flex">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a style="position: fixed; left: 43%;" class="navbar-brand" href="http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/index.php' ?>" class="nav-link <?= ($menu_code == 'home') ? 'active' : '' ?>"><img id="imglog" style="width: 250px; height: auto; ;" src="http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/images/log/003.png' ?>" alt=""></a>

      <div class="navbar navbar-expand-lg " id="mainNav">
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
            <!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
              Menu
              <i class="fas fa-bars ms-1"></i>
            </button> -->
            <div class="d-flex align-items-end">
              <?php if (isset($ses_level) && $ses_level != '' && $ses_level == 10) { ?>
                <!-- 관리자 로그인 상태 -->
                <li class="nav-item"><a href="#" class="nav-link text-white"><?= $ses_name  . "님" ?></a></li>
                <div class="dropdown" style="text-decoration-line: none;">
                  <a href="#" class="btn text-white" role="text" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false" style="margin-right: 110px;">
                    ↓
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <li class="dropdown-item"><a href="http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/admin/admin_member.php' ?>" class="nav-link  <?= ($menu_code == 'admin_member') ? 'active' : '' ?>">회원관리</a></li>
                    <li class="dropdown-item"><a href="http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/admin/admin_product.php' ?>" class="nav-link  <?= ($menu_code == 'admin_product') ? 'active' : '' ?>">상품관리</a></li>
                    <li class="dropdown-item"><a href="http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/admin/admin_review.php' ?>" class="nav-link  <?= ($menu_code == '') ? 'active' : '' ?>">리뷰게시판관리</a></li>
                    <li class="dropdown-item"><a href="http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/admin/admin_notice_board.php' ?>" class="nav-link  <?= ($menu_code == '') ? 'active' : '' ?>">공지사항관리</a></li>
                    <li class="dropdown-item"><a href="http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/message/message_box.php' ?>" class="nav-link  <?= ($menu_code == '') ? 'active' : '' ?>">1:1문의사항</a></li>
                    <li class="dropdown-item"><a href="http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/pg/logout.php' ?>" class="nav-link <?= ($menu_code == 'login') ? 'active' : '' ?>">로그아웃</a></li>
                  </ul>
                </div>
              <?php  } ?>
          </ul>
        </div>

      </div>
    </div>

    <!-- 장바구니 offcanvas바 -->
    <div class="offcanvas offcanvas-start" style="width: 30%;" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
      <div class="offcanvas-header border-bottom">
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body row-cols-1">
        <?php
        // include $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/cart/cart_list.php";
        ?>
      </div>
    </div>
  </nav>
</body>

</html>