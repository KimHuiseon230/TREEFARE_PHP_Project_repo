<?php
// 1. 보안부분
session_start();
$ses_id = (isset($_SESSION['ses_id']) && $_SESSION['ses_id'] != '') ? $_SESSION['ses_id'] : '';
$ses_level = (isset($_SESSION['ses_level']) && $_SESSION['ses_level'] != '') ? $_SESSION['ses_level'] : '';

if ($ses_id == '' || $ses_level == '' || $ses_level != 10) {
  die("
  <script>
    alert('관리자 접근 페이지입니다.');
    self.location.href = history.go(-1);
  </script>");
}

$id = (isset($_POST['id']) && $_POST['id'] != '') ? $_POST['id'] : '';
$idx = (isset($_POST['idx']) && $_POST['idx'] != '') ? $_POST['idx'] : '';
$name = (isset($_POST['name']) && $_POST['name'] != '') ? $_POST['name'] : '';
$password1 = (isset($_POST['password1']) && $_POST['password1'] != '') ? $_POST['password1'] : '';
$password2 = (isset($_POST['password2']) && $_POST['password2'] != '') ? $_POST['password2'] : '';
$email = (isset($_POST['email']) && $_POST['email'] != '') ? $_POST['email'] : '';
$old_email = (isset($_POST['old_email']) && $_POST['old_email'] != '') ? $_POST['old_email'] : '';
$old_photo = (isset($_POST['old_photo']) && $_POST['old_photo'] != '') ? $_POST['old_photo'] : '';
$zipcode = (isset($_POST['zipcode']) && $_POST['zipcode'] != '') ? $_POST['zipcode'] : '';
$addr1 = (isset($_POST['addr1']) && $_POST['addr1'] != '') ? $_POST['addr1'] : '';
$addr2 = (isset($_POST['addr2']) && $_POST['addr2'] != '') ? $_POST['addr2'] : '';
$level = (isset($_POST['level']) && $_POST['level'] != '' && is_numeric($_POST['level'])) ? $_POST['level'] : '';

// 2. 디비연결, Member 클래스 로딩
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/member.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/db_connect.php";
$member = new Member($conn);

// 3. 구현할 부분
//프로필 이미지 처리
$photo = $old_photo;
if (isset($_FILES['photo']) && $_FILES['photo']['name'] != '') {
  //기존 이미지가 있는지 없는지 파악
  if ($old_photo != '') {
    unlink($_SERVER['DOCUMENT_ROOT'] . "/php_treefare/data/profile/" . $old_photo);
  }
  //첨부된 이미지 파일 확장자 구하기
  $temp_arr = explode('.', $_FILES['photo']['name']);
  $ext = end($temp_arr);
  $photo = $id . "." . $ext;
  copy($_FILES['photo']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/data/profile/" . $photo);
}

// 연관배열
$arr = [
  'idx' => $idx,
  'id' => $id,
  'name' => $name,
  'password' => $password1,
  'email' => $email,
  'zipcode' => $zipcode,
  'addr1' => $addr1,
  'addr2' => $addr2,
  'photo' => $photo,
  'level' => $level
];

$member->edit($arr);

die("<script>
      alert('수정완료했습니다.');
      self.location.href = 'http://{$_SERVER['HTTP_HOST']}/php_treefare/admin/admin_member.php'
    </script>");
