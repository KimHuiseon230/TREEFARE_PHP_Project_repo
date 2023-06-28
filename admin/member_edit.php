<?php
// 보안부분(세션등록, 체크할내용, GET, POST)
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

$idx = (isset($_GET['idx']) && $_GET['idx'] != '' && is_numeric($_GET['idx'])) ? $_GET['idx'] : '';

if ($idx == '') {
  die("
    <script>
      alert('idx 값이 없습니다.');
      history.go(-1);
    </script>
  ");
}

// 공통적으로 처리하는 부분
$js_array = ['admin/js/member_edit.js'];
$title = "관리자회원수정";
$menu_code = "admin_member";

// 회원정보 가져오기 (디비연결, Member 클래스 로딩)
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/db_connect.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/member.php";
$member = new Member($conn);
$mem = $member->getInfoFromIdx($idx);

if ($ses_level == 10) {
  include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_admin_header.php";
} else {
  include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_header.php";
}
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/slide.php";
?>
<!-- 우편번호 찾기 -->
<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>

<!-- 메인부분 시작 -->
<div class="container p-5 ">
  <main class="w-50 mx-auto p-5 border rounded-5">
    <h1 class="text-center">관리자 회원수정</h1>
    <form name="input_form" method="post" action="edit_process.php" autocomplete="off" enctype="multipart/form-data">
      <input type="hidden" name="email_chk" value="0">
      <input type="hidden" name="idx" value="<?= $mem['idx'] ?>">
      <input type="hidden" name="old_email" value="<?= $mem['email'] ?>">
      <input type="hidden" name="old_photo" value="<?= $mem['photo'] ?>">

      <div class="gap-2 w-50">
        <div>
          <label for="form_id" class="form-label">아이디</label>
          <input type="text" name="id" class="form-control" id="form_id" value="<?= $mem['id'] ?>" readonly>
        </div>
      </div>

      <div class="mt-3 d-flex gap-2">
        <div class="w-50">
          <label for="form_name" class="form-label">이름</label>
          <input name="name" type="text" class="form-control" id="form_name" value="<?= $mem['name'] ?>">
        </div>

      </div>

      <div class="mt-3 d-flex align-items-end gap-2">
        <div class="flex-grow-1">
          <label for="form_password" class="form-label">비밀번호</label>
          <input name="password1" type="password" class="form-control" id="form_password" placeholder="수정희망하면 입력할것">
        </div>

        <div class="flex-grow-1">
          <label for="form_password2" class="form-label">비밀번호 확인</label>
          <input name="password2" type="password" class="form-control" id="form_password2" placeholder="수정희망하면 입력할것">
        </div>
      </div>

      <div class="mt-3 d-flex align-items-end gap-2">
        <div class="flex-grow-1">
          <label for="form_email" class="form-label">이메일</label>
          <input type="email" name="email" class="form-control" id="form_email" value="<?= $mem['email'] ?>">
        </div>
        <button type="button" class="btn btn-secondary" id="btn_email_check">이메일 중복확인</button>
      </div>

      <div class="mt-3 d-flex align-items-end gap-2">
        <div>
          <label for="form_zipcode" class="form-label">우편번호</label>
          <input type="text" name="zipcode" class="form-control" id="form_zipcode" value="<?= $mem['zipcode'] ?>">
        </div>
        <button type="button" class="btn btn-secondary" id="btn_zipcode">우편번호 번호찾기</button>
      </div>

      <div class="mt-3 d-flex align-items-end gap-2">
        <div class="flex-grow-1">
          <label for="form_addr1" class="form-label">기본주소</label>
          <input name="addr1" type="text" class="form-control" id="form_addr1" value="<?= $mem['addr1'] ?>">
        </div>

        <div class="flex-grow-1">
          <label for="form_addr2" class="form-label">상세주소</label>
          <input name="addr2" type="text" class="form-control" id="form_addr2" value="<?= $mem['addr2'] ?>">
        </div>
      </div>

      <div class="mt-3 d-flex gap-2">
        <div class="flex-grow-1">
          <label for="form_photo" class="form-label">프로필이미지</label>
          <input type="file" name="photo" class="form-control" id="form_photo">
        </div>
        <?php if ($mem['photo'] == '') {  ?>
          <img src="../images/person.jpg" alt="프로필이미지" id="form_preview" class="w-25 rounded-5">
        <?php } else {
          echo "<img src='../data/profile/" . $mem['photo'] . "' alt='프로필이미지' id='form_preview' class='w-25 rounded-5'>";
        } ?>
      </div>

      <div class="mt-5 d-flex justify-content-center gap-2">
        <button type="button" class="btn btn-primary w-50" id="btn_submit">수정완료</button>
        <!-- <button type="button" class="btn btn-secondary w-50" id="btn_cancel">가입취소</button> -->
        <input type="reset" value="초기화" class="btn btn-secondary w-50">
      </div>

    </form>

  </main>
</div>
<!-- 메인부분 끝 -->
<?php
// 푸터
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_footer.php"
?>