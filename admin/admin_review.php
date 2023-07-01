<!DOCTYPE html>
<html lang="en">

<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/image_board.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/db_connect.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/page_lib.php"; // 페이징 처리
$imageboard = new ImageBoard($conn);

// 공통적으로 처리하는 부분
$css_array = ['css/admin.css'];
$js_array = ['admin/js/admin_review.js'];
$title = "관리자 모드";
$menu_code = "admin";

//검색 조건(아이디, 이름, 이메일)
$sn = (isset($_GET['sn']) && $_GET['sn'] != '' && is_numeric($_GET['sn'])) ? $_GET['sn'] : '';
$sf = (isset($_GET['sf']) && $_GET['sf'] != '') ? $_GET['sf'] : '';
$paramArr = ['sn' => $sn, 'sf' => $sf];

//1. 현재페이지 요청을 받는다.
$page = (isset($_GET['page']) && $_GET['page'] != '' && is_numeric($_GET['page'])) ? $_GET['page'] : 1;
//2. 전체게시물 조회 쿼리
$total = $imageboard->total($paramArr);
//3. 화면에 보여줄 개수
$limit = 5;
//4. 데이터베이스 테이블로부터 전체 내용을 가져온다.(만약 1page : 0, 5 :: 2page : 5, 5 :: 3page 10, 5)가져온다.
$reviewArr = $imageboard->list($page, $limit, $paramArr);

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

  <?php
  if ($ses_id == '' || $ses_level == '' || $ses_level != 10) {
    die("
    <script>
      alert('관리자 접근 페이지입니다.');
      self.location.href = history.go(-1);
    </script>");
  }
  ?>

  <section>
    <div class="container p-5">
      <main class="p-5 border rounded-5">
        <h1 class="text-center">리뷰게시판</h1>
        <table class="table table-hover mb-5">
          <thead>
            <tr>
              <th scope="col">번호</th>
              <th scope="col">작성자</th>
              <th scope="col">제목</th>
              <th scope="col">파일 이름</th>
              <th scope="col">등록일시</th>
              <th scope="col">관리</th>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach ($reviewArr as $row) {
              $row['regist_day'] = substr($row['regist_day'], 0, 16)
            ?>
              <tr>
                <td><?= $row['num'] ?></td>
                <td><?= $row['name'] ?></td>
                <td><?= $row['subject'] ?></td>
                <td><?= $row['file_name'] ?></td>
                <td><?= $row['regist_day'] ?></td>
                <td>
                  <button type='button' class="btn btn-primary btn-sm btn_mem_edit" data-idx="<?= $row['num'] ?>">수정</button>
                  <button type='button' class="btn btn-danger btn-sm btn_mem_delete" data-idx="<?= $row['num'] ?>">삭제</button>
                </td>
              </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
        <!-- 관리자 검색기능 부여 -->
        <div class="d-flex mb-4 gap-2 justify-content-center">
          <select class="form-select w-25" name="sn" id="sn">
            <option value="1">제목</option>
            <option value="2">이름</option>
          </select>
          <input type="text" class="form-control w-25" name="sf" id="sf">
          <button type='button' class="btn btn-primary btn-sm w-10" id="btn_search">검색</button>
          <button type='button' class="btn btn-success btn-sm w-10" id="btn_all">전체목록</button>
        </div>

        <!-- 페이지네이션 -->
        <div class="container d-flex justify-content-center align-items-start gap-2 mb-3">
          <?php
          $page_limit = 5;
          echo pagination($total, $limit, $page_limit, $page, $paramArr)
          ?>
        </div>
      </main>

    </div>
  </section>
  <footer>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_footer.php" ?>
  </footer>
</body>

</html>