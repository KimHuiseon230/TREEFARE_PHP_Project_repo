<?php
// 1. 보안부분(세션등록, 체크할내용, GET, POST)

// 2. DB연결, Member Class 로딩

// 3. 구현할부분
session_start();
session_destroy();
die("
  <script>
    self.location.href = 'http://" . $_SERVER['HTTP_HOST'] . "/php_treefare/index.php';
  </script>
");
