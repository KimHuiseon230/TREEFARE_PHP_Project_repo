<?php
//공통적으로 처리하는 부분
session_start();
$ses_level = (isset($_SESSION['ses_level']) && $_SESSION['ses_level'] != '') ? $_SESSION['ses_level'] : '';
$css_array = ['css/main_slide2.css'];
$js_array = ['/js/main_slide2.js'];
$title = "treefare";
$menu_code = "mian";
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/db_setting.php";
//헤더부분 시작
if ($ses_level == 10) {
  include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_admin_header.php";
} else {
  include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_header.php";
}
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/slide.php";
?>
<!-- 메인부분 시작 -->
<div>
  <?php
  include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/main_as.php";
  include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/main_slide.php";
  include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/main_slide2.php";
  ?>
  <!-- 메인부분 종료 -->
  <!-- 푸터부분 시작 -->
  <?php
  include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_footer.php"
  ?>
  <!-- 푸터부분 종료 -->