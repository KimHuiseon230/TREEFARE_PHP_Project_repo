<?php
//보안부분(세션등록, 체크할내용, GET, POST)
session_start();
$ses_id = (isset($_SESSION['ses_id']) && $_SESSION['ses_id'] != '') ? $_SESSION['ses_id'] : '';
$ses_level = (isset($_SESSION['ses_level']) && $_SESSION['ses_level'] != '') ? $_SESSION['ses_level'] : '';

if ($ses_id == '') {
  die("
  <script>
    alert('로그인 후 접근이 가능한 페이지 입니다.')
    self.location.href = 'http://" . $_SERVER['HTTP_HOST'] . "/php_treefare/index.php';
  </script>");
}
// 공통적으로 처리하는 부분
$js_array = ['js/member_modify.js'];
$title = "회원수정";
$menu_code = "member";

// 회원정보 가져오기(DB연결, Member Class 로딩)
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/db_connect.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/member.php";
$member = new Member($conn);
$memArr = $member->getInfo($ses_id);
//헤더부분 시작
if ($ses_level == 10) {
  include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_admin_header.php";
} else {
  include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_header.php";
}
?>
<!-- 다음 스크립트 로딩(우편번호 찾기) -->
<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>

<!-- 메인부분 시작 -->
<div class="container p-5 ">
  <main class="w-50 p-5 border rounded-5 mx-auto" style="margin-top: 80px;">
    <h1 class="text-center">회원수정</h1>
    <form name="input_form" method="post" action="../pg/member_process.php" autocomplete="off" enctype="multipart/form-data">
      <input type="hidden" name="email_check" value="0">
      <input type="hidden" name="old_email" value="<?= $memArr['email'] ?>">
      <input type="hidden" name="old_photo" value="<?= $memArr['photo'] ?>">
      <input type="hidden" name="mode" value="edit">

      <div class="d-flex align-items-end gap-3">
        <div>
          <label for="form_id" class="form-label">아이디</label>
          <input type="text" name="id" class="form-control" id="form_id" value="<?= $memArr['id'] ?>" readonly>
        </div>
      </div>

      <div class="mt-3 gap-3">
        <div>
          <label for="form_name" class="form-label">이름</label>
          <input type="text" name="name" class="form-control" id="form_name" value="<?= $memArr['name'] ?>">
        </div>
      </div>

      <div class="mt-3 d-flex align-items-end gap-3">
        <div class="w-50">
          <label for="form_password" class="form-label">비밀번호</label>
          <input type="password" name="password" class="form-control" id="form_password" placeholder="변경을 원치 않을 시 입력">
        </div>
        <div class="w-50">
          <label for="form_password2" class="form-label">비밀번호 확인</label>
          <input type="password" name="password2" class="form-control" id="form_password2" placeholder="변경을 원치 않을 시 입력">
        </div>
      </div>

      <div class="mt-3 d-flex align-items-end gap-3">
        <div class="flex-grow-1">
          <label for="form_email" class="form-label">이메일</label>
          <input type="email" name="email" class="form-control" id="form_email" value="<?= $memArr['email'] ?>">
        </div>
        <button type="button" class="btn btn-outline-secondary" id="btn_email_check">이메일 중복확인</button>
      </div>

      <div class="mt-3 d-flex align-items-end gap-3">
        <div>
          <label for="form_zipcode" class="form-label">우편번호</label>
          <input type="text" name="zipcode" class="form-control" id="form_zipcode" value="<?= $memArr['zipcode'] ?>">
        </div>
        <button type="button" class="btn btn-outline-secondary" id="btn_zipcode">우편번호 찾기</button>
      </div>

      <div class="mt-3 d-flex align-items-end gap-3">
        <div class="w-50">
          <label for="form_addr1" class="form-label">기본주소</label>
          <input type="text" name="addr1" class="form-control" id="form_addr1" value="<?= $memArr['addr1'] ?>">
        </div>
        <div class="w-50">
          <label for="form_addr2" class="form-label">상세주소</label>
          <input type="text" name="addr2" class="form-control" id="form_addr2" value="<?= $memArr['addr2'] ?>">
        </div>
      </div>

      <div class="mt-3 d-flex gap-3">
        <div>
          <label for="form_photo" class="form-label">프로필이미지</label>
          <input type="file" name="photo" class="form-control" id="form_photo">
        </div>
        <?php if ($memArr['photo'] == '') {  ?>
          <img src="../images/person.jpg" alt="프로필이미지" id="form_preview" class="w-25 rounded-5">
        <?php } else {
          echo "<img src='../data/profile/" . $memArr['photo'] . "' alt='프로필이미지' id='form_preview' class='w-25 rounded-5'>";
        } ?>
      </div>

      <div class="mt-3 d-flex justify-content-center gap-3">
        <button type="button" class="btn btn-primary w-50" id="btn_submit">완료</button>
        <input type="reset" value="초기화" class="btn btn-secondary w-50">
      </div>

    </form>
  </main>
</div>
<!-- 메인부분 종료 -->

<!-- 푸터부분 시작 -->
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_footer.php"
?>