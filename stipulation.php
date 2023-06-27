<?php
session_start();
$ses_level = (isset($_SESSION['ses_level']) && $_SESSION['ses_level'] != '') ? $_SESSION['ses_level'] : '';
// 보안부분 (세션등록, 체크할 내용, GET, POST)

// 공통적으로 처리하는 부분
$js_array = ['js/stipulation.js'];
$title = "회원가입조건";
$menu_code = "member";

if ($ses_level == 10) {
  include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_admin_header.php";
} else {
  include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_header.php";
}
?>

<!-- 메인 시작 -->
<div class="container">
  <main class="p-5 border rounded-5">
    <h1 class="text-center">회원약관 및 개인정보 취급방침 동의</h1>
    <h4 class="mt-5">회원약관</h4>
    <textarea name="stipulation_1" cols="30" rows="10" class="form-control">
        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ratione, ullam cupiditate? Natus mollitia voluptas dolorem accusantium, 
        cumque est amet repellendus fugit iure sint officiis culpa beatae. Quisquam deserunt excepturi sed possimus nulla aspernatur minus neque vel. 
        Illum fugiat ratione corporis deserunt voluptate laborum tenetur laudantium est beatae, expedita accusamus perspiciatis obcaecati amet rem quia, 
        quis enim modi quidem incidunt saepe recusandae minus, architecto fuga. Architecto dolor eum, a quam quae doloribus explicabo voluptate 
        soluta et accusantium nisi adipisci maxime iusto, tempora amet laboriosam sapiente corrupti est dolorem veniam. Maxime non sint tempora 
        voluptas eligendi ut recusandae, odio architecto esse ipsa? Tempora deleniti et voluptate cupiditate architecto, officiis eum explicabo possimus 
        culpa nam aperiam quae voluptates perferendis natus quam enim esse veritatis eius illum rem omnis. Ad unde ut ipsam laboriosam illo labore maxime 
        modi quam doloribus esse, asperiores excepturi recusandae velit corrupti quisquam, nesciunt, odit quibusdam tempore cum libero dicta rem quae amet. 
        Veritatis quisquam magni cumque ducimus doloremque? Neque enim odit dolor adipisci optio iste officiis asperiores cupiditate exercitationem, vitae ab 
        corrupti cumque modi? Debitis, fuga! Commodi saepe ex, nam fuga aspernatur ipsum laboriosam beatae possimus sequi doloremque iste tenetur molestias quae, 
        eligendi totam excepturi sed, fugiat architecto recusandae animi autem eaque velit! Eligendi nemo enim deserunt non facilis animi, mollitia, sunt possimus, 
        dolorum fuga ad autem eius ea aliquam a accusantium incidunt aliquid dolor recusandae labore facere? Vel, modi a exercitationem aliquid sunt cupiditate quis 
        corrupti voluptatibus quam, commodi saepe? Animi corporis non quos consequatur possimus, quae ratione autem consequuntur! Omnis, laborum quibusdam molestiae 
        aliquam quaerat cumque obcaecati deleniti modi tempore architecto ipsam beatae natus minus eum vitae iste repellat fugiat fuga a enim reprehenderit minima 
        assumenda nihil veniam. Esse, laboriosam hic! Sed qui corrupti pariatur nobis numquam quibusdam molestiae placeat cum necessitatibus eligendi, optio 
        perferendis beatae culpa.
      </textarea>
    <div class="form-check mt-3 d-flex justify-content-end">
      <input class="form-check-input" type="checkbox" value="" id="chk_member1">
      <label class="form-check-label" for="chk_member1">
        위 약관에 동의합니다.
      </label>
    </div>

    <h4 class="mt-5 ">개인정보 취급방침</h4>
    <textarea name="stipulation_2" cols="30" rows="10" class="form-control">
        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ratione, ullam cupiditate? Natus mollitia voluptas dolorem accusantium, 
        cumque est amet repellendus fugit iure sint officiis culpa beatae. Quisquam deserunt excepturi sed possimus nulla aspernatur minus neque vel. 
        Illum fugiat ratione corporis deserunt voluptate laborum tenetur laudantium est beatae, expedita accusamus perspiciatis obcaecati amet rem quia, 
        quis enim modi quidem incidunt saepe recusandae minus, architecto fuga. Architecto dolor eum, a quam quae doloribus explicabo voluptate 
        soluta et accusantium nisi adipisci maxime iusto, tempora amet laboriosam sapiente corrupti est dolorem veniam. Maxime non sint tempora 
        voluptas eligendi ut recusandae, odio architecto esse ipsa? Tempora deleniti et voluptate cupiditate architecto, officiis eum explicabo possimus 
        culpa nam aperiam quae voluptates perferendis natus quam enim esse veritatis eius illum rem omnis. Ad unde ut ipsam laboriosam illo labore maxime 
        modi quam doloribus esse, asperiores excepturi recusandae velit corrupti quisquam, nesciunt, odit quibusdam tempore cum libero dicta rem quae amet. 
        Veritatis quisquam magni cumque ducimus doloremque? Neque enim odit dolor adipisci optio iste officiis asperiores cupiditate exercitationem, vitae ab 
        corrupti cumque modi? Debitis, fuga! Commodi saepe ex, nam fuga aspernatur ipsum laboriosam beatae possimus sequi doloremque iste tenetur molestias quae, 
        eligendi totam excepturi sed, fugiat architecto recusandae animi autem eaque velit! Eligendi nemo enim deserunt non facilis animi, mollitia, sunt possimus, 
        dolorum fuga ad autem eius ea aliquam a accusantium incidunt aliquid dolor recusandae labore facere? Vel, modi a exercitationem aliquid sunt cupiditate quis 
        corrupti voluptatibus quam, commodi saepe? Animi corporis non quos consequatur possimus, quae ratione autem consequuntur! Omnis, laborum quibusdam molestiae
         aliquam quaerat cumque obcaecati deleniti modi tempore architecto ipsam beatae natus minus eum vitae iste repellat fugiat fuga a enim reprehenderit 
         minima assumenda nihil veniam. Esse, laboriosam hic! Sed qui corrupti pariatur nobis numquam quibusdam molestiae placeat cum necessitatibus eligendi, 
         optio perferendis beatae culpa.
      </textarea>
    <div class="form-check mt-3 d-flex justify-content-end">
      <input class="form-check-input" type="checkbox" value="" id="chk_member2">
      <label class="form-check-label" for="chk_member2">
        위 약관에 동의합니다.
      </label>
    </div>
    <div class="mt-4 d-flex justify-content-end gap-3">
      <button type="button" class="btn btn-primary w-50" id="btn_member">다음</button>
      <button type="button" class="btn btn-secondary w-50" id="btn_cancel">취소</button>
    </div>
    <form name="member_form" action="./member/member_input.php" method="post" style="display: none;">
      <input type="hidden" name="chk" value="0">
    </form>
  </main>
</div> <!-- container div end -->
<!-- 메인 종료 -->

<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_footer.php"
?>