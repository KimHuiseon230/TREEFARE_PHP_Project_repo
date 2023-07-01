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
        $sql = "update `product` set name=:name, kind=:kind, price=:price, sale=:sale, content=:content,  file_name=:upfile_name, 
        file_type=:upfile_type, file_copied=:copied_file_name ";
        $sql .= " where num=:num";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':num', $arr['num']);
        $stmt->bindParam(':name', $arr['name']);
        $stmt->bindParam(':kind', $arr['kind']);
        $stmt->bindParam(':price', $arr['price']);
        $stmt->bindParam(':sale', $arr['sale']);
        $stmt->bindParam(':content', $arr['content']);
        $stmt->bindParam(':upfile_name', $arr['upfile_name']);
        $stmt->bindParam(':upfile_type', $arr['upfile_type']);
        $stmt->bindParam(':copied_file_name', $arr['copied_file_name']);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function row_cnt()
    {
        $sql = "select count(*) as cnt from `product` order by num desc";
        $stmt = $this->conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function page_limit($kind)
    {
        if ($kind == 0) {
            $sql = "select * from  product order by num desc";
            $stmt = $this->conn->prepare($sql);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
        } else {
            $sql = "select * from  product where kind = {$kind} order by num desc";
            $stmt = $this->conn->prepare($sql);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
        }

        $stmt->execute();
        return  $stmt->fetchAll();
    }

    //사용자 정보 전체 가져오기
    public function list($page, $limit, $paramArr)
    {
        $start = ($page - 1) * $limit;

        $where = "";
        if ($paramArr['sn'] != '' && $paramArr['sf'] != '') {
            switch ($paramArr['sn']) {
                case 1:
                    $sn_str = 'num';
                    break;
                case 2:
                    $sn_str = 'name';
                    break;
            }
            $where = " where {$sn_str} like '%{$paramArr['sf']}%' ";
        }

        $sql = "select num, name, content, file_name, DATE_FORMAT(regist_day, '%Y-%m-%d %H:%i') as regist_day from 
    `product` {$where} order by num desc limit {$start}, {$limit}";
        $stmt = $this->conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // 전체목록(조건 : 번호, 이름)
    public function total($paramArr)
    {
        $where = "";
        if ($paramArr['sn'] != '' && $paramArr['sf'] != '') {
            switch ($paramArr['sn']) {
                case 1:
                    $sn_str = 'num';
                    break;
                case 2:
                    $sn_str = 'name';
                    break;
            }
            $where = " where {$sn_str} like '%{$paramArr['sf']}%' ";
        }
        $sql = "select count(*) as cnt from `product` " . $where;
        $stmt = $this->conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row['cnt'];
    }
}
