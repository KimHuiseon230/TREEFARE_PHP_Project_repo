<?php

class Cart
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // num  select
    public function find_of_num($id)
    {
        $sql = "select * from cart where s_id=:id order by s_num desc";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    // num del
    public function del_of_num($s_num)
    {
        $sql = "delete from cart where s_num = :s_num";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':s_num', $s_num);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    // num insert
    public function insert_of_num($arr)
    {
        $sql = "insert into cart (s_id, s_name, s_sale,  s_count, s_regist_day, s_file_name, s_file_type, s_file_copied ) ";
        $sql .= "values( :id, :name,  :sale, :count, :regist_day ,:file_name, :file_type, :file_copied)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $arr['id']);
        $stmt->bindParam(':name', $arr['name']);
        $stmt->bindParam(':sale', $arr['sale']);
        $stmt->bindParam(':count', $arr['count']);
        $stmt->bindParam(':regist_day', $arr['regist_day']);
        $stmt->bindParam(':file_name', $arr['file_name']);
        $stmt->bindParam(':file_type', $arr['file_type']);
        $stmt->bindParam(':file_copied', $arr['file_copied']);
        $stmt->execute();
    }
    // num update
    public function calculate($s_num)
    {
        $sql = "select * from cart where s_num = :s_num";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':s_num', $s_num);
        $stmt->execute();
        return $stmt->fetch();
    }
}
