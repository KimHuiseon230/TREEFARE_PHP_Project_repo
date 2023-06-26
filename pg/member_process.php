<?php
// 1. 보안부분(세션등록, 체크할내용, GET, POST)
$mode = (isset($_POST['mode']) && $_POST['mode'] != '') ? $_POST['mode'] : '';
$id = (isset($_POST['id']) && $_POST['id'] != '') ? $_POST['id'] : '';
$name = (isset($_POST['name']) && $_POST['name'] != '') ? $_POST['name'] : '';
$password1 = (isset($_POST['password']) && $_POST['password'] != '') ? $_POST['password'] : '';
$password2 = (isset($_POST['password2']) && $_POST['password2'] != '') ? $_POST['password2'] : '';
$email = (isset($_POST['email']) && $_POST['email'] != '') ? $_POST['email'] : '';
$old_email = (isset($_POST['old_email']) && $_POST['old_email'] != '') ? $_POST['old_email'] : '';
$old_photo = (isset($_POST['old_photo']) && $_POST['old_photo'] != '') ? $_POST['old_photo'] : '';
$zipcode = (isset($_POST['zipcode']) && $_POST['zipcode'] != '') ? $_POST['zipcode'] : '';
$addr1 = (isset($_POST['addr1']) && $_POST['addr1'] != '') ? $_POST['addr1'] : '';
$addr2 = (isset($_POST['addr2']) && $_POST['addr2'] != '') ? $_POST['addr2'] : '';

if ($mode == '') {
  die(json_encode(['result' => 'empty_mode']));
}

// 2. DB연결, Member Class 로딩
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/db_connect.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/member.php";
$member = new Member($conn);

// 3. 구현할부분
switch ($mode) {
  case 'id_check': {
      if ($id == '') {
        die(json_encode(['result' => 'empty_id']));
      }
      //아이디 패턴 검색체크
      if ($member->id_exists($id)) {
        die(json_encode(['result' => 'fail']));
      } else {
        die(json_encode(['result' => 'success']));
      }
      break;
    }
  case 'email_check': {
      if ($email == '') {
        die(json_encode(['result' => 'empty_email']));
      }
      //이메일 패턴 검색체크
      if ($member->email_form_check($email) == false) {
        die(json_encode(['result' => 'form_error_email']));
      }

      if ($member->email_exists($email)) {
        die(json_encode(['result' => 'fail']));
      } else {
        die(json_encode(['result' => 'success']));
      }
      break;
    }
  case 'input': {
      $photo = "";
      if (isset($_FILES['photo']) && $_FILES['photo']['name'] != '') {
        $temp_arr = explode('.', $_FILES['photo']['name']);
        $ext = end($temp_arr);
        $photo = $id . "." . $ext;
        copy($_FILES['photo']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/data/profile/" . $photo);
      }
      if ($password1 != $password2) {
        die("<script>
          alert('패스워드가 맞지 않습니다');
          self.location.href = 'http://{$_SERVER['HTTP_HOST']}/php_treefare/member/member_input.php'
        </script>");
      }

      // 연관배열
      $arr = [
        'id' => $id,
        'name' => $name,
        'password' => $password1,
        'email' => $email,
        'zipcode' => $zipcode,
        'addr1' => $addr1,
        'addr2' => $addr2,
        'photo' => $photo
      ];

      $member->input($arr);

      die("<script>
        self.location.href = 'http://{$_SERVER['HTTP_HOST']}/php_treefare/index.php'
        </script>");
    }
  case 'login': {
      if ($id == '') {
        die(json_encode(['result' => 'empty_id']));
      }
      if ($password1 == '') {
        die(json_encode(['result' => 'empty_pw']));
      }
      //아이디와 패스워드 검색체크
      $result = $member->login($id, $password1);
      switch ($result) {
        case 'login_success':
          $userInfo = $member->getInfo($id);
          // 세션등록
          session_start();
          $_SESSION['ses_id'] = $id;
          $_SESSION['ses_name'] = $userInfo['name'];
          $_SESSION['ses_level'] = $userInfo['level'];
          $ses_level = (isset($_SESSION['ses_level']) && $_SESSION['ses_level'] != '') ? $_SESSION['ses_level'] : '';
          if ($ses_level == 10) {
            die(json_encode(['result' => 'admin_login_success']));
          } else {
            die(json_encode(['result' => 'login_success']));
          }
          break;
        case 'pw_fail':
          die(json_encode(['result' => 'pw_fail']));
          break;
        case 'id_fail':
          die(json_encode(['result' => 'id_fail']));
          break;
      }

      break;
    }
  case 'edit': {
      // 프로필 이미지 처리
      $photo = $old_photo;
      if (isset($_FILES['photo']) && $_FILES['photo']['name'] != '') {

        // 기존의 이미지가 있는지 없는지 파악
        if ($old_photo != '') {
          unlink($_SERVER['DOCUMENT_ROOT'] . "/php_treefare/data/profile/" . $old_photo);
        }
        // 첨부된 이미지 파일 확장자 구하기
        $temp_arr = explode('.', $_FILES['photo']['name']);
        $ext = end($temp_arr);
        $photo = $id . "." . $ext;
        copy($_FILES['photo']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/data/profile/" . $photo);
      }
      session_start();

      // 연관배열
      $arr = [
        'id' => $_SESSION['ses_id'],
        'name' => $name,
        'password' => $password1,
        'email' => $email,
        'zipcode' => $zipcode,
        'addr1' => $addr1,
        'addr2' => $addr2,
        'photo' => $photo
      ];
      $member->edit($arr);
      $_SESSION['ses_name'] = $name;
      die("<script>
          alert('수정완료했습니다.');
          self.location.href = 'http://{$_SERVER['HTTP_HOST']}/php_treefare/index.php'
        </script>");
      break;
    }
}
