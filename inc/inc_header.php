<?php
//보안부분(세션등록, 체크할내용, GET, POST)
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
$ses_id = (isset($_SESSION['ses_id']) && $_SESSION['ses_id'] != '') ? $_SESSION['ses_id'] : '';
$ses_name = (isset($_SESSION['ses_name']) && $_SESSION['ses_name'] != '') ? $_SESSION['ses_name'] : '';
$ses_level = (isset($_SESSION['ses_level']) && $_SESSION['ses_level'] != '') ? $_SESSION['ses_level'] : '';

?>
<!DOCTYPE html>
<html lang="ko">

<head>
  <title><?= (isset($title) && $title != '') ? $title : '홈홈홈' ?></title>
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
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/php_treefare/css/styles.css?v=<?= date('Ymdhis') ?>">
  <!-- 외부스크립트 -->
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/php_treefare/css/footer.css?v=<?= date('Ymdhis') ?>">


  <?php
  if (isset($js_array)) {
    foreach ($js_array as $value) {
      print "<script src='http://" . $_SERVER['HTTP_HOST'] . "/php_treefare/$value?v=" . date('Ymdhis') . "' defer></script>" . PHP_EOL;
    }
  }
  ?>
</head>

<body id="page-top">
  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav" style="background-color: white;">
    <div class="container">
      <a class="navbar-brand" href="#page-top">트리페어</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        Menu
        <i class="fas fa-bars ms-1"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">

          <?php if (isset($ses_id) && $ses_id != '' && $ses_level != 10) { ?>
            <!-- 로그인상태 -->
            <li class="nav-item"><a href="#" class="nav-link"><?= $ses_name  . "님" ?></a></li>
            <li class="nav-item"><a href="http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/index.php' ?>" class="nav-link <?= ($menu_code == 'home') ? 'active' : '' ?>">Home</a></li>
            <li class="nav-item"><a href="http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/product/product_list.php' ?>" class="nav-link <?= ($menu_code == 'intro') ? 'active' : '' ?>">상품</a></li>
            <li class="nav-item"><a href="http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/image_board/board_list.php' ?>" class="nav-link <?= ($menu_code == 'board') ? 'active' : '' ?>">리뷰게시판</a></li>
            <li class="nav-item"><a href="http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/member/member_modify_form.php' ?>" class="nav-link <?= ($menu_code == 'member') ? 'active' : '' ?>">회원수정</a></li>
            <li class="nav-item"><a href="http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/pg/logout.php' ?>" class="nav-link <?= ($menu_code == 'login') ? 'active' : '' ?>">로그아웃</a></li>
            <div class="dropdown" style="text-decoration-line: none;">
              <a href=" #" role="text" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                Dropdown link
              </a>

              <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <li><a class="dropdown-item" href="http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/notice/faq.php' ?>">자주 묻는 질문</a></li>
                <li><a class="dropdown-item" href="http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/notice/qna.php' ?>"> 1:1 문의</a></li>
                <li><a class="dropdown-item" href="#">공지사항</a></li>
              </ul>
            </div>
            <!-- 관리자로 로그인 상태 -->
          <?php  } else if (isset($ses_level) && $ses_level != '' && $ses_level == 10) { ?>
            <li class="nav-item"><a href="#" class="nav-link"><?= $ses_name  . "님" ?></a></li>
            <div class="dropdown">
              <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Dropdown
              </button>
              <ul class="dropdown-menu">
                <li class="nav-item"><a href="http://<?= $_SERVER['HTTP_HOST'] . '/php_member/admin/admin_member.php' ?>" class="nav-link <?= ($menu_code == 'admin_member') ? 'active' : '' ?>">회원관리</a></li>
                <li class="nav-item"><a href="#" class="nav-link <?= ($menu_code == '') ? 'active' : '' ?>">게시판관리</a></li>
                <li class="nav-item"><a href="#" class="nav-link <?= ($menu_code == '') ? 'active' : '' ?>">공지사항관리</a></li>
                <li class="nav-item"><a href="#" class="nav-link <?= ($menu_code == '') ? 'active' : '' ?>">상품관리</a></li>
                <li class="nav-item"><a href="#" class="nav-link <?= ($menu_code == '') ? 'active' : '' ?>">고객센터</a></li>
                <li class="nav-item"><a class="dropdown-item" href="http://<?= $_SERVER['HTTP_HOST']; ?>/ilhase/cs/qna_list.php">문의 메세지<span class="notification"> •</span></a></li>
                <li class="nav-item"><a href="http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/pg/logout.php' ?>" class="nav-link <?= ($menu_code == 'login') ? 'active' : '' ?>">로그아웃</a></li>
                <li class="nav-item dropdown" id="nav_user">
              </ul>
            </div>
            </li>

          <?php  } else { ?>
            <!-- 비 로그인상태 -->
            <li class="nav-item"><a href="#" class="nav-link <?= ($menu_code == 'home') ? 'active' : '' ?>">Home</a></li>
            <li class="nav-item"><a href="http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/product/product_list.php' ?>" class="nav-link <?= ($menu_code == 'intro') ? 'active' : '' ?>">상품</a></li>
            <li class="nav-item"><a href="#" class="nav-link <?= ($menu_code == 'intro') ? 'active' : '' ?>">사이트소개</a></li>
            <li class="nav-item"><a href="http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/view/review_list.php' ?>" class="nav-link <?= ($menu_code == 'review') ? 'active' : '' ?>">게시판2</a></li>
            <li class="nav-item"><a href="http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/image_board/board_list.php' ?>" class="nav-link <?= ($menu_code == 'board') ? 'active' : '' ?>">게시판</a></li>

            <li class="nav-item"><a href="http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/stipulation.php' ?>" class="nav-link <?= ($menu_code == 'member') ? 'active' : '' ?>">회원가입</a></li>
            <li class="nav-item"><a href="http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/login/login_form.php' ?>" class="nav-link <?= ($menu_code == 'login') ? 'active' : '' ?>">로그인</a></li>
          <?php  } ?>
        </ul>

      </div>
    </div>
  </nav>
  <!-- Masthead-->
  <header class="masthead">
    <div class="container">
      <img src="http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/product/data/interior9.jpg' ?>" alt="">
    </div>
  </header>