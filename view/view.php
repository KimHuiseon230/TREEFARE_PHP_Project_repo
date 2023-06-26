<?php
// 댓글 데이터가 저장될 파일 경로 설정
$filePath = $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/data/view/comments.txt";

// HTTP POST 요청일 때, 전송된 데이터를 저장 및 응답
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // 전송된 데이터 획득
  $comment = json_decode(file_get_contents('php://input'));

  // 댓글 객체 생성 및 파일에 저장
  $newComment = new stdClass();
  $newComment->author = $comment->author;
  $newComment->content = $comment->content;
  $newComment->created_at = date('Y-m-d H:i:s');
  $newCommentjson = json_encode($newComment);
  file_put_contents($filePath, $newCommentjson . PHP_EOL, FILE_APPEND);

  // 저장된 댓글 목록 반환
  echo file_get_contents($filePath);
}
// HTTP GET 요청일 때, 저장된 댓글 목록 응답
else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  echo file_get_contents($filePath);
}
?>
<style>
  .container {
    margin-top: 2rem;
  }

  .review-box {
    display: flex;
    flex-direction: row;
    align-items: center;
    margin: 1rem;
    padding: 1rem;
    border: 1px solid #ccc;
    border-radius: 10px;
    cursor: pointer;
  }

  .review-image {
    width: 200px;
    height: 200px;
    background-size: cover;
    background-position: center;
    border-radius: 10px;
    margin-right: 1rem;
  }

  .info {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }

  .review-id {
    font-size: 1.2rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
  }

  .review-date {
    font-size: 1rem;
  }

  .rating {
    display: flex;
    flex-direction: row;
    align-items: center;
    margin-top: 1rem;
  }

  .rating>i {
    font-size: 2rem;
    color: orange;
  }

  .btn {
    margin-top: 1rem;
  }

  #comment-section {
    width: 500px;
    margin: 0 auto;
  }

  #comment-input {
    width: 70%;
    height: 40px;
    margin-right: 5px;
    padding: 10px;
    box-sizing: border-box;
    border: 1px solid #ccc;
  }

  #comment-submit {
    width: 30%;
    height: 40px;
    background-color: #4CAF50;
    color: #fff;
    border: none;
    cursor: pointer;
  }

  #comment-list {
    margin-top: 10px;
    padding: 10px;
    border: 1px solid #ccc;
  }

  .comment-item {
    margin-bottom: 5px;
    padding: 5px;
    border: 1px solid #eee;
    background-color: #f9f9f9;
  }
</style>
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/db_connect.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/fetch_star.php";

$id = (isset($_GET['id']) && !empty($_GET['id'])) ? intval($_GET['id']) : null;

// $review->reviwe2_exists($id)
if ($id) {
  try {
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = 'SELECT * FROM reviews WHERE id = :id';
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $review = $stmt->fetch(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}

if (!$review) {
  echo "Invalid review ID or review not found.";
}
?>
<?php
// 공통적으로 처리하는 부분
$js_array = ['js/view.js'];
$title = "reviews";
$menu_code = "review";
?>
<!-- 헤더부분 시작 -->
<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc/inc_header.php"
?>
<div class="container">
  <h1>쇼핑몰 구매평 상세 페이지</h1>
  <div class="review-box" onclick="window.location.href='view.php?id=<?= $review['id'] ?>'">
    <div class="review-image" style="width: 200px; height: 200px; border: 1px solid darkblue; background-image: url('../images/reviews/<?php echo $review['image']; ?>');"></div>
    <div class="info">
      <p>ID: <?= $review['user_id'] ?></p>
      <p>날짜: <?= date('Y/m/d', strtotime($review['post_date'])) ?></p>
      <p class="custom-text">내용: <?= $review['content'] ?></p>
      <div class="rating">
        <?= fetch_star($review['rating']) ?>
      </div>
    </div>
  </div>
  <div>
    <!-- 댓글 영역을 담을 div 요소 -->
    <div id="comment-section">
      <!-- 댓글 입력 폼 -->
      <form id="comment-form">
        <input type="text" id="comment-input" placeholder="댓글을 입력하세요">
        <button type="submit" id="comment-submit">전송</button>
      </form>
      <!-- 댓글 목록을 담을 div 요소 -->
      <div id="comment-list"></div>
    </div>
  </div>

</div>
<div>
  <a href="./review_list.php"> <button type="button" class="btn btn-primary">목록</button></a>
</div>
</div>

<!-- 푸터부분 시작 -->
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc/inc_footer.php"
?>