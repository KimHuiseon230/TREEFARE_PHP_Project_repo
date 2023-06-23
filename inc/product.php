<?php

class Product
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // num  select
    public function find_of_num($num)
    {
        $sql = "select * from `product` where num = :num";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':num', $num);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    // num  select(one)
    public function find_of_num2($num)
    {
        $sql = "select * from `product` where num = :num";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':num', $num);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        return $stmt->fetch();
    }
    // num del
    public function del_of_num($num)
    {
        $sql = "delete from `product` where num = :num";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':num', $num);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    // num insert
    public function insert_of_num($arr)
    {
        $sql = "insert into `product`(name, kind, price, sale, content, file_name, file_type, file_copied,  regist_day) ";
        $sql .= "values(:name, :kind, :price, :sale, :content,  ";
        $sql .= ":upfile_name, :upfile_type, :copied_file_name, :regist_day)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':name', $arr['name']);
        $stmt->bindParam(':kind', $arr['kind']);
        $stmt->bindParam(':price', $arr['price']);
        $stmt->bindParam(':sale', $arr['sale']);
        $stmt->bindParam(':content', $arr['content']);
        $stmt->bindParam(':upfile_name', $arr['upfile_name']);
        $stmt->bindParam(':upfile_type', $arr['upfile_type']);
        $stmt->bindParam(':copied_file_name', $arr['copied_file_name']);
        $stmt->bindParam(':regist_day', $arr['regist_day']);
        $stmt->execute();
    }
    // num update
    public function update_of_num($arr)
    {
        $sql = "update `product` set name=:name, price=:price, sale=:sale, content=:content,  file_name=:upfile_name, 
        file_type=:upfile_type, file_copied=:copied_file_name ";
        $sql .= " where num=:num";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':num', $arr['num']);
        $stmt->bindParam(':name', $arr['name']);
        $stmt->bindParam(':price', $arr['price']);
        $stmt->bindParam(':sale', $arr['sale']);
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
        $sql = "select * from `product` where id =:q_userid";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':q_userid', $q_userid);
        $stmt->fetch();
        $result = $stmt->execute();
        if (!$result) {
            die('Error: ' . mysqli_error($this->conn));
        }
        return    $stmt->rowCount();
    }

    public function find_test($q_userid)
    {

        $sql = "select * from `product` where id =:q_userid";
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
