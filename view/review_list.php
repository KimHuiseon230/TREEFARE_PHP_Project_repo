<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/db_connect.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/fetch_star.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/test.php";
// $review = new Review($conn);
// $review->reviwe_exists()
try {
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $query = 'SELECT * FROM reviews ORDER BY id DESC LIMIT 9';
  $stmt = $conn->prepare($query);
  $stmt->execute();
  $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}

?>
<style>
  .container {
    display: flex;
    flex-wrap: wrap;
    justify-content: flex-start;
    max-width: 1200px;
    margin: 0 auto;
  }

  .review-box {
    width: calc(25% - 20px);
    margin-left: 20px;
    margin-right: 0;
    margin-top: 20px;
    padding: 10px;
    border: 1px solid #eaeaea;
    box-sizing: border-box;
  }

  .review-box:nth-child(4n+1) {
    margin-left: 0;
  }

  .review-image {
    width: 100%;
    height: 200px;
    background-size: cover;
    background-position: center;
  }

  .info {
    padding: 10px 0;
  }

  .rating {
    font-size: 24px;
    /* 더 큰 크기로 수정 */
  }
</style>

<?php
// 공통적으로 처리하는 부분
// $js_array = ['js/member_input.js'];
$title = "reviews";
$menu_code = "review";
//헤더부분 시작
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_header.php"
?>

<?php //헤더부분 시작
// include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc/inc_header.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/db_connect.php";
include $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/create_table.php";
// include $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/page_lib.php";
create_table($conn, "reviews");
?>
<!-- 메인부분 시작 -->
<div class="container">
  <?php foreach ($reviews as $review) : ?>
    <div class="review-box" onclick="window.location.href='./view.php?id=<?= $review['id'] ?>'">
      <div class="review-image" style="background-image: url('../images/reviews/<?php echo $review['image']; ?>');"></div>
      <div class="info">
        <p>ID: <?php echo $review['user_id']; ?></p>
        <p>날짜: <?php echo date('Y/m/d', strtotime($review['post_date'])); ?></p>
        <div class="rating">
          <?php echo fetch_star($review['rating']); ?>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>
<!-- 메인부분 종료 -->

<!-- 푸터부분 시작 -->
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_footer.php"
?>