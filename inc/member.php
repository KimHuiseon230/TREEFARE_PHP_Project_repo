<?php

class Member
{
  private $conn;

  public function __construct($db)
  {
    $this->conn = $db;
  }
  //아이디 검사
  public function id_exists($id)
  {
    $sql = "select * from `member` where id=:id";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    // (0,null,'',false) : false 나머지는 : true
    return $stmt->rowCount() ? true : false;
  }
  //이메일 패턴검사
  public function email_form_check($email)
  {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
  }
  //이메일 검사
  public function email_exists($email)
  {
    $sql = "select * from `member` where email=:email";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    // (0,null,'',false) : false          나머지는 : true
    return $stmt->rowCount() ? true : false;
  }
  //데이터 입력
  public function input($arr)
  {
    // 단방향 암호화 처리 방법
    $pass_hash = password_hash($arr['password'], PASSWORD_DEFAULT);
    $sql = "INSERT INTO `member`(`id`,`name`,`email`,`password`,`zipcode`,`addr1`,`addr2`,`photo`,`ip`,`create_at`,`login_at`)
    VALUES(:id,:name,:email,:password,:zipcode,:addr1,:addr2,:photo,:ip,now(),now());";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':id', $arr['id']);
    $stmt->bindParam(':name', $arr['name']);
    $stmt->bindParam(':email', $arr['email']);
    $stmt->bindParam(':password', $pass_hash);
    $stmt->bindParam(':zipcode', $arr['zipcode']);
    $stmt->bindParam(':addr1', $arr['addr1']);
    $stmt->bindParam(':addr2', $arr['addr2']);
    $stmt->bindParam(':photo', $arr['photo']);
    $stmt->bindParam(':ip', $_SERVER['REMOTE_ADDR']);
    $stmt->execute();
  }
  // 아이디와 패스워드 검사
  public function login($id, $pw)
  {
    $sql = "select * from `member` where `id`=:id";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $info = $stmt->rowCount() ? true : false;
    if ($info == true) {
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      if (password_verify($pw, $row['password'])) {
        // 로그인 성공 시 로그인 시간 등록
        $sql = "update `member` set `login_at` = now() where `id` = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return "login_success";
      } else {
        // 패스워드가 맞지 않는 경우
        return "pw_fail";
      }
    } else {
      // 아이디가 없는 경우
      return "id_fail";
    }
  }
  // 사용자 정보
  public function getInfo($id)
  {
    $sql = "select * from `member` where `id`=:id";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->execute();
    return $stmt->fetch();
  }
  // 사용자 수정
  public function edit($arr)
  {
    $sql = "UPDATE `member` SET `name` = :name, `email` = :email, 
    `zipcode` = :zipcode, `addr1` = :addr1, `addr2` = :addr2, `photo`= :photo ";

    $params = [
      ':name' => $arr['name'],
      ':email' => $arr['email'],
      ':zipcode' => $arr['zipcode'],
      ':addr1' => $arr['addr1'],
      ':addr2' => $arr['addr2'],
      ':photo' => $arr['photo']
    ];

    if ($arr['password'] != '') {
      $pass_hash = password_hash($arr['password'], PASSWORD_DEFAULT);
      $sql .= ", `password` = :password ";
      $params[':password'] = $pass_hash;
    }

    $sql .= " WHERE `id` = :id";
    $params[':id'] = $arr['id'];

    $stmt = $this->conn->prepare($sql);
    $stmt->execute($params);
  }
  //회원 삭제
  public function member_del($idx)
  {
    $sql = "delete from `member` where `idx` = :idx";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':idx', $idx);
    $stmt->execute();
  }
  //사용자 정보 전체 가져오기
  public function list($page, $limit, $paramArr)
  {
    $start = ($page - 1) * $limit;

    $where = "";
    if ($paramArr['sn'] != '' && $paramArr['sf'] != '') {
      switch ($paramArr['sn']) {
        case 1:
          $sn_str = 'name';
          break;
        case 2:
          $sn_str = 'id';
          break;
        case 3:
          $sn_str = 'email';
          break;

        default:
          break;
      }
      $where = " where {$sn_str} like '%{$paramArr['sf']}%' ";
    }

    $sql = "select idx, id, name, email,  DATE_FORMAT(create_at,'%Y-%m-%d %H:%i') AS `create_at` from `member` {$where}  order by `idx` desc limit {$start}, {$limit}";
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
          $sn_str = 'name';
          break;
        case 2:
          $sn_str = 'id';
          break;
        case 3:
          $sn_str = 'email';
          break;
      }
      $where = " where {$sn_str} like '%{$paramArr['sf']}%' ";
    }
    $sql = "select count(*) as cnt from `member` " . $where;
    $stmt = $this->conn->prepare($sql);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->execute();
    $row = $stmt->fetch();
    return $row['cnt'];
  }
  // 회원삭제
  public function memberDelete($idx)
  {
    $sql = "delete from `member` where idx=:idx";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':idx', $idx);
    $stmt->execute();
  }
  // 사용자 정보(idx를 통해서 가져옴)
  public function getInfoFromIdx($idx)
  {
    $sql = "select * from `member` where idx=:idx";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':idx', $idx);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->execute();
    return $stmt->fetch();
  }
  public function getData()
  {
    $sql = "select * from `member` order by idx asc";
    $stmt = $this->conn->prepare($sql);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->execute();
    return $stmt->fetchAll();
  }
}
