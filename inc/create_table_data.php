<?php

function insert_table_data($conn, $table_name)
{
  $createTableFlag = false;
  $sql = "select * from `$table_name`";
  $stmt = $conn->prepare($sql);
  // $stmt->bindParam(":table_name", $table_name);
  $result = $stmt->execute();
  $stmt->setFetchMode(PDO::FETCH_NUM);
  $count = $stmt->rowCount();

  //테이블이 있는지 없는지 확인
  $createTableFlag = ($count > 0) ? true : false;
  if ($createTableFlag == false) {
    switch ($table_name) {
      case 'member':
        $sql = "INSERT INTO `member` VALUES (null, 'ffffff', 'ffffff', 'ffff@fff.fff', 'ffff', '12345', '서울 성동구 왕십리로 315(,한동타워)', '행당동', 'fff.png', '::1', '1', '2023-06-25 18:20:30', '2023-06-27 21:15:14')";
        break;

      case 'message':
        $sql = "INSERT INTO `message` VALUES (null, 'aaaaaa', 'admin1', '테스트1', '테스트', '2023-06-27 (22:08)')";
        break;

        // case 'image_board':
        //     $sql = "INSERT INTO `message` VALUES (null, 'aaaaaa', 'admin1', '테스트1', '테스트', '2023-06-27 (22:08)')";
        //     break;

        // case 'image_board_ripple':
        //     $sql = "CREATE TABLE image_board_ripple (
        //               `num` int(11) NOT NULL AUTO_INCREMENT,
        //               `parent` int(11) NOT NULL,
        //               `id` char(15) NOT NULL,
        //               `name` char(10) NOT NULL,
        //               `content` varchar(255) NOT NULL,
        //               `regist_day` char(20) DEFAULT NULL,
        //               PRIMARY KEY (num)
        //             ) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
        //               ";
        //     break;

      case 'product':
        $sql = "insert into product values (null,'소피아 골든 쇼파', '2', '150,000', '120,000','푹신푹신한 쇼파입니다','sofa.png','image/jpeg','2023_06_23_00_27_26_sofa.png','2023-06-01 10:20:30')";
        break;

        // case 'cart':
        //     $sql = "CREATE TABLE `cart` (
        //                   `s_num` int(11) NOT NULL AUTO_INCREMENT,
        //                   `s_id` char(15) NOT NULL,
        //                   `s_name` char(45) NOT NULL,
        //                   `s_sale` char(15) NOT NULL,
        //                   `s_count` char(15) NOT NULL,
        //                   `s_file_name` char(40) NOT NULL,
        //                   `s_file_type` varchar(255) DEFAULT NULL,
        //                   `s_file_copied` varchar(255) DEFAULT NULL,
        //                   `s_regist_day` char(20) DEFAULT NULL,
        //                   PRIMARY KEY (`s_num`)
        //                 ) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;";
        //     break;

      case 'notice':
        $sql = "insert into notice values (null, '홈페이지 오픈', '드디어 홈페이지가 오픈하였습니다!!!', 'aaa.png', 'image/png','2023_06_27_15_27_06.png','0','2023-06-27 (15:27)')";
        break;

      default:
        //     $sql = "";
        //     print "<script>
        //   alert('해당 $table_name 이 없습니다.')
        // </script>";
        break;
    } // end of switch
    if ($sql != "") {
      $stmt = $conn->prepare($sql);
      $result = $stmt->execute();
      if ($result) {
        print "<script>
              alert('해당 $table_name 테이블에 데이터추가 완료')
            </script>";
      } else {
        print "<script>
            alert('해당 $table_name 테이블이 생성 실패 되었습니다.')
          </script>";
      }
    }
  } // end of if
}