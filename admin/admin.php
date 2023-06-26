<!DOCTYPE html>
<html lang="en">

<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/member.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/db_connect.php";

$member = new Member($conn);

// 공통적으로 처리하는 부분
$css_array = ['css/admin.css'];
$js_array = ['/js/admin_member.js'];
$title = "관리자 모드";
$menu_code = "admin";

//검색 조건(아이디, 이름, 이메일)
$sn = (isset($_GET['sn']) && $_GET['sn'] != '' && is_numeric($_GET['sn'])) ? $_GET['sn'] : '';
$sf = (isset($_GET['sf']) && $_GET['sf'] != '') ? $_GET['sf'] : '';
$paramArr = ['sn' => $sn, 'sf' => $sf];

//2. 전체게시물 조회 쿼리 : select count(*) as count from message;
$total = $member->total($paramArr);
//4. 데이터베이스 테이블로부터 전체 내용을 가져온다.(1~191)가져온다.
$memArr = $member->list($paramArr);
?>

<head>
  <!-- css 추가 필요하면 추가할것 -->
</head>

<body>
  <header>
    <?php
    include $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_admin_header.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/slide.php";
    ?>
  </header>
  <section class="p-5">
    <!-- main container -->
    <div class="container">
      <div class="fit_height admin_menu" id="manage_member">
        <h2 class="title">회원 관리</h2>
        <ul class="manage_member_list">
          <li>
            <div class="manage_member_item">
              <span>개인 회원 수</span>
              <br /><br />
              <span id="person_count" class="target" style="font-size: 30px;"></span><span>명</span>
            </div>
          </li>
        </ul>
        <div class="d-flex mb-4 gap-2 justify-content-center">
          <select class="form-select w-25" name="sn" id="sn">
            <option value="1">이름</option>
            <option value="2">아이디</option>
            <option value="3">이메일</option>
          </select>
          <input type="text" class="form-control w-25" name="sf" id="sf">
          <button type='button' class="btn btn-primary btn-sm" id="btn_search" data-bs-toggle="modal" data-bs-target="#staticBackdrop">검색</button>
          <button type='button' class="btn btn-success btn-sm" id="btn_all" data-bs-toggle="modal" data-bs-target="#staticBackdrop">전체목록</button>
        </div>

        <div class="modal" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">회원 정보</h5>
                <button type="button" class="btn-close" id="btn_close1" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <table class="table table-hover mb-5">
                  <thead>
                    <tr>
                      <th scope="col">번호</th>
                      <th scope="col">아이디</th>
                      <th scope="col">이름</th>
                      <th scope="col">이메일</th>
                      <th scope="col">등록일시</th>
                      <th scope="col">관리</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach ($memArr as $row) {
                      $row['create_at'] = substr($row['create_at'], 0, 16);
                    ?>
                      <tr>
                        <td><?= $row['idx']; ?></td>
                        <td><?= $row['id']; ?></td>
                        <td><?= $row['name']; ?></td>
                        <td><?= $row['email']; ?></td>
                        <td><?= $row['create_at']; ?></td>
                        <td>
                          <button type='button' class="btn btn-primary btn-sm btn_mem_edit" data-idx="<?= $row['idx']; ?>">수정</button>
                          <button type='button' class="btn btn-danger btn-sm btn_mem_delete" data-idx="<?= $row['idx']; ?>">삭제</button>
                        </td>
                      </tr>
                    <?php
                    }
                    ?>
                  </tbody>
                </table>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btn_close2" data-bs-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>

      </div> <!-- member end -->

    </div>
  </section>
  <footer>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_footer.php" ?>
  </footer>
</body>

</html>