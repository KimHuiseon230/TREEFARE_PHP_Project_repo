<?php

class ImageBoard
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // num  select
    public function find_of_num($num)
    {
        $sql = "select * from `image_board` where num = :num";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':num', $num);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    // num  select(one)
    public function find_of_num2($num)
    {
        $sql = "select * from image_board where num = :num";
        $stmt = $this->conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->bindParam(':num', $num);
        $stmt->execute();
        return $stmt->fetch();
    }
    // num del
    public function del_of_num($num)
    {
        $sql = "delete from `image_board` where num = :num";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':num', $num);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    // num insert
    public function insert_of_num($arr)
    {
        $sql = "insert into `image_board`(id, name, subject, content, rating, regist_day,  file_name, file_type, file_copied) ";
        $sql .= "values(:ses_id, :ses_name, :subject, :content, :rating, :regist_day, ";
        $sql .= ":upfile_name, :upfile_type, :copied_file_name)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':ses_id', $arr['ses_id']);
        $stmt->bindParam(':ses_name', $arr['ses_name']);
        $stmt->bindParam(':subject', $arr['subject']);
        $stmt->bindParam(':content', $arr['content']);
        $stmt->bindParam(':rating', $arr['rating']);
        $stmt->bindParam(':regist_day', $arr['regist_day']);
        $stmt->bindParam(':upfile_name', $arr['upfile_name']);
        $stmt->bindParam(':upfile_type', $arr['upfile_type']);
        $stmt->bindParam(':copied_file_name', $arr['copied_file_name']);
        $stmt->execute();
        return $stmt->fetch();
    }
    // num update
    public function update_of_num($arr)
    {
        $sql = "update `image_board` set subject=:subject, content=:content, rating=:rating,   file_name=:upfile_name, file_type=:upfile_type, file_copied=:copied_file_name";
        $sql .= " where num=:num";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':num', $arr['num']);
        $stmt->bindParam(':subject', $arr['subject']);
        $stmt->bindParam(':content', $arr['content']);
        $stmt->bindParam(':rating', $arr['rating']);
        $stmt->bindParam(':upfile_name', $arr['upfile_name']);
        $stmt->bindParam(':upfile_type', $arr['upfile_type']);
        $stmt->bindParam(':copied_file_name', $arr['copied_file_name']);
        $stmt->execute();
        return $stmt->fetch();
    }
    public function find_test($q_ses_id)
    {
        $sql = "select * from `member` where id = :q_ses_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':q_ses_id', $q_ses_id);
        $result = $stmt->execute();

        if (!$result) {
            die('Error: ' . mysqli_error($stmt));
        }
        return $stmt->rowCount();
    }

    // 별점주기
    function fetch_star($rating)
    {
        $output = "";
        $emoji_star = "⭐";
        $emoji_gray_star = "☆";

        for ($i = 1; $i <= 5; ++$i) {
            if ($i <= $rating) {
                $output .= $emoji_star;
            } else {
                $output .= $emoji_gray_star;
            }
        }

        return $output;
    }

    public function row_cnt()
    {
        $sql = "select count(*) as cnt from image_board order by num desc";
        $stmt = $this->conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function row_limit($start, $scale)
    {
        $sql = "select * from  image_board order by num desc limit {$start}, {$scale}";
        $stmt = $this->conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function total($paramArr)
    {
        $where = "";
        if ($paramArr['sn'] != '' && $paramArr['sf'] != '') {
            switch ($paramArr['sn']) {
                case 1:
                    $sn_str = 'subject';
                    break;
                case 2:
                    $sn_str = 'name';
                    break;
            }
            $where = " where {$sn_str} like '%{$paramArr['sf']}%' ";
        }
        $sql = "select count(*) as cnt from image_board " . $where;
        $stmt = $this->conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row['cnt'];
    }

    //사용자 정보 전체 가져오기
    public function list($page, $limit, $paramArr)
    {
        $start = ($page - 1) * $limit;

        $where = "";
        if ($paramArr['sn'] != '' && $paramArr['sf'] != '') {
            switch ($paramArr['sn']) {
                case 1:
                    $sn_str = 'subject';
                    break;
                case 2:
                    $sn_str = 'name';
                    break;
            }
            $where = " where {$sn_str} like '%{$paramArr['sf']}%' ";
        }

        $sql = "select num, name, subject, file_name, DATE_FORMAT(regist_day, '%Y-%m-%d %H:%i') as regist_day from 
    image_board {$where} order by num desc limit {$start}, {$limit}";
        $stmt = $this->conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // 댓글부분 시작
    public function find_of_ripple_num($num)
    {
        $sql = "select * from `image_board_ripple` where parent=:num";
        $stmt = $this->conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->bindParam(':num', $num);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    // del image_board_ripple
    public function del_image_board_ripple($num)
    {
        $sql = "DELETE FROM `image_board_ripple` WHERE num=:num";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':num', $num);
        $result = $stmt->execute();
        $stmt->fetch();
        if (!$result) {
            die('Error: ' . mysqli_error($stmt));
        }
    }
    // insert image_board_ripple
    public function insert_image_board_ripple($arr)
    {
        $sql = "INSERT INTO `image_board_ripple` VALUES (null, :q_parent, :q_ses_id , :q_username, :q_content, :regist_day)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':q_parent', $arr['q_parent']);
        $stmt->bindParam(':q_ses_id', $arr['q_ses_id']);
        $stmt->bindParam(':q_username', $arr['q_username']);
        $stmt->bindParam(':q_content', $arr['q_content']);
        $stmt->bindParam(':regist_day', $arr['regist_day']);
        $stmt->fetch();
        $result = $stmt->execute();

        if (!$result) {
            die('Error: ' . mysqli_error($stmt));
        }
    }
}
