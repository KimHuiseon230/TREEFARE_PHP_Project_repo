<?php

function create_table($conn, $table_name)
{
  $createTableFlag = false;
  $sql = "show tables from treefare where tables_in_treefare = :table_name";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(":table_name", $table_name);
  $result = $stmt->execute();
  $stmt->setFetchMode(PDO::FETCH_NUM);
  $count = $stmt->rowCount();


  //테이블이 있는지 없는지 확인
  $createTableFlag = ($count > 0) ? true : false;

  if ($createTableFlag == false) {
    switch ($table_name) {
      case 'member':
        $sql = "CREATE TABLE `member` (
          `idx` int(10) unsigned NOT NULL AUTO_INCREMENT,
          `id` varchar(100) NOT NULL COMMENT '사용자 아이디',
          `name` varchar(100) NOT NULL COMMENT '사용자 이름',
          `email` varchar(100) NOT NULL COMMENT '사용자 이메일',
          `password` varchar(100) NOT NULL COMMENT '사용자 비밀번호',
          `zipcode` char(5) DEFAULT '' COMMENT '사용자 우편번호',
          `addr1` varchar(100) DEFAULT '' COMMENT '사용자 기본주소',
          `addr2` varchar(100) DEFAULT '' COMMENT '사용자 상세주소',
          `photo` varchar(100) DEFAULT '' COMMENT '사용자 사진파일명',
          `ip` varchar(40) DEFAULT '' COMMENT '사용자 아이피주소',
          `level` tinyint(3) unsigned DEFAULT '1' COMMENT '회원등급: 관리자는 10',
          `create_at` datetime DEFAULT NULL COMMENT '가입 년월일시분초',
          `login_at` datetime DEFAULT NULL COMMENT '로그인 년월일시분초',
          PRIMARY KEY (`idx`),
          UNIQUE KEY `idx_id` (`id`) USING BTREE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        break;

      case 'board':
        $sql = "CREATE TABLE `board` (
          `num` int(11) NOT NULL AUTO_INCREMENT,
          `id` char(15) NOT NULL,
          `name` char(10) NOT NULL,
          `subject` char(200) NOT NULL,
          `content` text NOT NULL,
          `regist_day` char(20) NOT NULL,
          `hit` int(11) NOT NULL,
          `file_name` char(40) DEFAULT NULL,
          `file_type` char(40) DEFAULT NULL,
          `file_copied` char(40) DEFAULT NULL,
          PRIMARY KEY (`num`)
        ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4";
        break;
      case 'event':
        $sql = "CREATE TABLE `event` (
          `num` int(11) NOT NULL AUTO_INCREMENT,
          `id` char(15) NOT NULL,
          `name` char(10) NOT NULL,
          `subject` char(200) NOT NULL,
          `content` text NOT NULL,
          `regist_day` char(20) NOT NULL,
          `hit` int(11) NOT NULL,
          `file_name` char(40) DEFAULT NULL,
          `file_type` char(40) DEFAULT NULL,
          `file_copied` char(40) DEFAULT NULL,
          PRIMARY KEY (`num`)
        ) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;";
        break;
      case 'message':
        $sql = "CREATE TABLE `message` (
            `num` int(11) NOT NULL AUTO_INCREMENT,
            `send_id` char(20) NOT NULL,
            `rv_id` char(20) NOT NULL,
            `subject` char(200) NOT NULL,
            `content` text NOT NULL,
            `regist_day` char(20) DEFAULT NULL,
            PRIMARY KEY (`num`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        break;
        // id, name, subject, content, regist_day, hit,  file_name, file_type, file_copied
      case 'image_board':
        $sql = "CREATE TABLE `image_board` (
            `num` int(11) NOT NULL AUTO_INCREMENT,
            `id` char(15) NOT NULL,
            `name` char(10) NOT NULL,
            `subject` char(200) NOT NULL,
            `content` text NOT NULL,
            `rating` INT(1),
            `regist_day` char(20) NOT NULL,
            `file_name` char(40) DEFAULT NULL,
            `file_type` char(40) DEFAULT NULL,
            `file_copied` char(40) DEFAULT NULL,
            PRIMARY KEY (`num`)
          ) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci";
        break;
      case 'image_board_ripple':
        $sql = "CREATE TABLE image_board_ripple (
          `num` int(11) NOT NULL AUTO_INCREMENT,
          `parent` int(11) NOT NULL,
          `id` char(15) NOT NULL,
          `name` char(10) NOT NULL,
          `content` varchar(255) NOT NULL,
          `regist_day` char(20) DEFAULT NULL,
          PRIMARY KEY (num)
        ) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
          ";
        break;
      case 'reviews':
        $sql = "CREATE TABLE `reviews` (
       `id` INT(11) NOT NULL AUTO_INCREMENT,
        `image` TEXT,
        `user_id` VARCHAR(50),
        `post_date` DATE,
        `rating` INT(1),
        `content` TEXT, 
        PRIMARY KEY (`id`)
      );";
        break;

      case 'product':
        $sql = "CREATE TABLE `product` (
        `num` int(11) NOT NULL AUTO_INCREMENT,
        `name` char(45) NOT NULL,
        `kind` char(1) NOT NULL,
        `price` char(15) NOT NULL,
        `sale` char(15) NOT NULL,
        `content` varchar(255) NOT NULL,
        `file_name` char(255) NOT NULL,
        `file_type` varchar(255) DEFAULT NULL,
        `file_copied` varchar(255) DEFAULT NULL,
        `regist_day` char(20) DEFAULT NULL,
        PRIMARY KEY (`num`)
      ) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;";
        break;

      case 'cart':
        $sql = "CREATE TABLE `cart` (
              `s_num` int(11) NOT NULL AUTO_INCREMENT,
              `s_id` char(15) NOT NULL,
              `s_name` char(45) NOT NULL,
              `s_sale` char(15) NOT NULL,
              `s_count` char(15) NOT NULL,
              `s_file_name` char(40) NOT NULL,
              `s_file_type` varchar(255) DEFAULT NULL,
              `s_file_copied` varchar(255) DEFAULT NULL,
              `s_regist_day` char(20) DEFAULT NULL,
              PRIMARY KEY (`s_num`)
            ) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;";
        break;

      case 'qna':
        $sql = "CREATE TABLE `qna` (
              `num` int(11) NOT NULL AUTO_INCREMENT,
              `group_num` int(10) unsigned NOT NULL,
              `depth` int(10) unsigned NOT NULL,
              `order` int(10) unsigned NOT NULL,
              `id` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
              `name` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
              `subject` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
              `content` text COLLATE utf8mb4_general_ci NOT NULL,
              `hit` int(10) unsigned NOT NULL DEFAULT '0',
              `regist_date` char(20) COLLATE utf8mb4_general_ci NOT NULL,
              PRIMARY KEY (`num`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
        break;
      case 'notice':
        $sql = "CREATE TABLE notice (
                num int(11) NOT NULL AUTO_INCREMENT,
                subject varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
                content text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
                file_name varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
                file_type varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
                file_copied varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
                hit int(10) unsigned NOT NULL DEFAULT '0',
                regist_date char(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
                PRIMARY KEY (num)
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
        break;

      default:
        $sql = "";
        print "<script>
          alert('해당 $table_name 이 없습니다.')
        </script>";
        break;
    } // end of switch
    if ($sql != "") {
      $stmt = $conn->prepare($sql);
      $result = $stmt->execute();
      if ($result) {
        print "<script>
          alert('해당 $table_name 테이블 이 생성되었습니다.')
        </script>";
      } else {
        print "<script>
        alert('해당 $table_name 테이블이 생성 실패 되었습니다.')
      </script>";
      }
    }
  } // end of if
} // end of function
