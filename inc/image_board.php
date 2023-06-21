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
        $sql = "select * from `image_board` where num = :num";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':num', $num);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
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
        $sql = "insert into `image_board`(id, name, subject, content, regist_day, hit,  file_name, file_type, file_copied) ";
        $sql .= "values(:userid, :username, :subject, :content, :regist_day, 0, ";
        $sql .= ":upfile_name, :upfile_type, :copied_file_name)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':userid,', $arr['userid']);
        $stmt->bindParam(':username', $arr['username']);
        $stmt->bindParam(':subject', $arr['subject']);
        $stmt->bindParam(':content', $arr['content']);
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
        $sql = "update `image_board` set subject=:subject, content=:content,  file_name=:upfile_name, file_type=:upfile_type, file_copied=:copied_file_name";
        $sql .= " where num=:num";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':num', $arr['num']);
        $stmt->bindParam(':subject', $arr['subject']);
        $stmt->bindParam(':content', $arr['content']);
        $stmt->bindParam(':upfile_name', $arr['upfile_name']);
        $stmt->bindParam(':upfile_type', $arr['upfile_type']);
        $stmt->bindParam(':copied_file_name', $arr['copied_file_name']);
        $stmt->execute();
        return $stmt->fetch();
    }
    // num  select
    public function Login_Comments($q_userid)
    {
        $sql = "select * from `member` where id =:q_userid";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':q_userid', $q_userid);
        $stmt->fetch();
        $result = $stmt->execute();
        if (!$result) {
            die('Error: ' . mysqli_error($this->conn));
        }
        return    $stmt->rowCount();
    }
    // del image_board_ripple
    public function del_image_board_ripple($num)
    {
        $sql = "DELETE FROM `image_board_ripple` WHERE num=:num";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':num', $num);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    // insert image_board_ripple
    public function insert_image_board_ripple($arr)
    {
        $sql = "INSERT INTO `image_board_ripple` VALUES (null,:q_parent,:q_userid,:q_username, :q_usernick,:q_content,:regist_day)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':q_parent', $arr['q_parent']);
        $stmt->bindParam(':q_userid', $arr['q_userid']);
        $stmt->bindParam(':q_username', $arr['q_username']);
        $stmt->bindParam(':q_usernick', $arr['q_usernick']);
        $stmt->bindParam(':q_content', $arr['q_content']);
        $stmt->bindParam(':regist_day', $arr['regist_day']);
        $result = $stmt->execute();

        if (!$result) {
            die('Error: ' . mysqli_error($this->conn));
        }
        return $stmt->fetchAll();
    }
    public function find_test($q_userid)
    {
 
     
        
        $sql = "select * from `member` where id =:q_userid";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':q_userid', $q_userid);
        $stmt->fetch();
        $result = $stmt->execute();
    
        if (!$result) {
            die('Error: ' . mysqli_error($this->conn));
        }
    
        return $stmt->rowCount();
    }
}
