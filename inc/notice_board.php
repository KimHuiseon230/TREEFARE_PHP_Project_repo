<?php

class NoticeBoard
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // num  select(one)
    public function find_of_num2($num)
    {
        $sql = "select * from notice where num = :num";
        $stmt = $this->conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->bindParam(':num', $num);
        $stmt->execute();
        return $stmt->fetch();
    }
    // num del
    public function del_of_num($num)
    {
        $sql = "delete from notice where num = :num";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':num', $num);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function update_of_hit($new_hit, $num)
    {
        $sql = "update notice set hit=:new_hit where num=:num";
        $stmt = $this->conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->bindParam(':new_hit', $new_hit);
        $stmt->bindParam(':num', $num);
        return  $stmt->execute();
    }
    // num insert
    public function insert_of_num($arr)
    {
        $sql = "insert into notice (num, subject, content, file_name, file_type, file_copied, hit, regist_date) ";
        $sql .= "values(:num, :subject, :content, :upfile_name, :upfile_type, :copied_file_name, 0, :regist_date)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':num', $arr['num']);
        $stmt->bindParam(':subject', $arr['subject']);
        $stmt->bindParam(':content', $arr['content']);
        $stmt->bindParam(':upfile_name', $arr['upfile_name']);
        $stmt->bindParam(':upfile_type', $arr['upfile_type']);
        $stmt->bindParam(':copied_file_name', $arr['copied_file_name']);
        $stmt->bindParam(':regist_date', $arr['regist_date']);
        $stmt->execute();
        return $stmt->fetch();
    }
    // num update
    public function update_of_num($arr)
    {
        $sql = "update notice set subject=:subject, content=:content ";
        $sql .= " where num=:num";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':num', $arr['num']);
        $stmt->bindParam(':subject', $arr['subject']);
        $stmt->bindParam(':content', $arr['content']);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function row_cnt()
    {
        $sql = "select count(*) as cnt from notice order by num desc";
        $stmt = $this->conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function row_limit($start, $scale)
    {
        $sql = "select * from  notice order by num desc limit {$start}, {$scale}";
        $stmt = $this->conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        return $stmt->fetchAll();
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
                    $sn_str = 'subject';
                    break;
                case 3:
                    $sn_str = 'content';
                    break;

                default:
                    break;
            }
            $where = " where {$sn_str} like '%{$paramArr['sf']}%' ";
        }

        $sql = "select num, subject, content, file_name, DATE_FORMAT(regist_date,'%Y-%m-%d %H:%i') AS `regist_date` from `notice` {$where} order by `num` desc limit {$start}, {$limit}";
        $stmt = $this->conn->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // 전체목록(조건 : 이름, 아이디, 이메일 목록)
    public function total($paramArr)
    {
        $where = "";
        if ($paramArr['sn'] != '' && $paramArr['sf'] != '') {
            switch ($paramArr['sn']) {
                case 1:
                    $sn_str = 'num';
                    break;
                case 2:
                    $sn_str = 'subject';
                    break;
                case 3:
                    $sn_str = 'content';
                    break;
            }
            $where = " where {$sn_str} like '%{$paramArr['sf']}%' ";
        }
        $sql = "select count(*) as cnt from `notice` " . $where;
        $stmt = $this->conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row['cnt'];
    }
}
