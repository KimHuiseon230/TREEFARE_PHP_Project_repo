<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0 shrink-to-fit=no">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <!-- <link rel="icon" href="http://<?= $_SERVER['HTTP_HOST']; ?>/ilhase/common/img/favicon.png" sizes="128x128"> -->
  <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
  <title>프리어쩌고</title>
  <link rel="stylesheet" href="./qna.css">
  <script type="text/javascript">
    let personal_questions = "";
    let corporate_questions = "";

    function select_personal_question(chk_box) {
      if (chk_box.checked) {
        // 개인 회원 체크가 되었을 때
        // 개인 회원 질문들을 보여줌(add visible class);

        for (var i = 0; i < personal_questions.length; i++) {
          personal_questions[i].classList.add('visible');
        }
        console.log("select_personal_question checked");

      } else {
        // 개인 회원 체크 해제했을 때
        // 개인 회원 질문들을 숨김
        for (var i = 0; i < personal_questions.length; i++) {
          personal_questions[i].classList.remove('visible');
        }
        console.log("select_personal_question not checked");
      }
    }

    function select_corporate_question(chk_box) {
      if (chk_box.checked) {
        // 기업 회원 체크가 되었을 때
        // 기업 회원 질문들을 보여줌
        for (var i = 0; i < corporate_questions.length; i++) {
          corporate_questions[i].classList.add('visible');
        }
        console.log("cor_question checked");

      } else {
        // 기업 회원 체크 해제했을 때
        // 기업 회원 질문들을 숨김
        for (var i = 0; i < corporate_questions.length; i++) {
          corporate_questions[i].classList.remove('visible');
        }
        console.log("cor_question not checked");

      }
    }

    function init() {
      personal_questions = document.body.getElementsByClassName('person_questions');
      corporate_questions = document.body.getElementsByClassName('corporate_questions');

      // 개인 회원, 기업 회원 질문을 다 보여주도록 세팅
      const check_boxes = document.body.querySelectorAll('input[type*=checkbox]');

      select_corporate_question(check_boxes[0]);
      select_personal_question(check_boxes[1]);

    }
  </script>
</head>

<body onload="init();">
  <header>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_header.php"; ?>
  </header>

  <div class="container">
    <h3 class="title">자주 묻는 질문</h3>

    <div class="question_list" action="index.html" method="post">

      <ul>
        <li>
          <input id="chk_person" type="checkbox" checked="true" onchange="select_personal_question(this);"><label for="chk_person"></label>&nbsp; 개인회원 &nbsp;&nbsp;&nbsp;
          <!-- <input id="chk_common" type="checkbox" onchange="select_common_question(this);" checked>&nbsp; 공 통  -->
          &nbsp;&nbsp;&nbsp;
          <input id="chk_corporate" type="checkbox" checked="true" onchange="select_corporate_question(this);"><label for="chk_corporate"></label>&nbsp; 기업회원
        </li>
        <br><br><br>

        <ul class="faq_list">
          <!-- 공통 질문 -->
          <li>
            <input type="radio" name="question" id="answer01">
            <label for="answer01" class="visible">아이디/비밀번호가 생각나지 않아요.<img src="./img/arrow.png" alt=""> </label>
            <div class="text">
              <p>우측 상단의 로그인 버튼을 누른 후, '아이디/비밀번호 찾기'를 통해 검색이 가능합니다.<br />아이디/비밀번호 찾기에서 문제가 있는 경우 관리자에게 1:1 문의 바랍니다.</p>
            </div>
          </li>

          <!-- 개인회원 질문 -->
          <li class="person_questions">
            <input type="radio" name="question" id="answer02">
            <label class="person_questions" for="answer02">개인 회원가입을 하면 어떤 서비스를 이용할 수 있나요? <img src="./img/arrow.png" alt=""> </label>
            <div class="text">
              <p>개인 회원은 이력서 탭에서 이력서를 추가, 수정, 삭제할 수 있습니다.<br />이 이력서들을 바탕으로 지원하고 싶은 공고에 지원할 수 있습니다.<br />또한 관심 공고에 등록하여 원하는 채용 공고를 스크랩하여 원하는 공고만 모아볼 수 있습니다. <br />물론 고객센터도 로그인 후 이용하실 수 있습니다.</p>
            </div>
          </li>
          <li class="person_questions">
            <input type="radio" name="question" id="answer03">
            <label class="person_questions" for="answer03">개인회원이 채용 공고 등록을 할 수 있나요? <img src="./img/arrow.png" alt=""> </label>
            <div class="text">
              <p>공고 등록은 개인회원으로 이용할 수 없는 서비스입니다.<br /> 개인회원은 기업회원으로 전환할 수 없으며,<br /> 사업자등록증이 있는 경우에 한해서 기업회원으로 가입을 하신 후 공고를 등록할 수 있습니다.</p>
            </div>
          </li>

          <li class="person_questions">
            <input type="radio" name="question" id="answer04">
            <label class="person_questions" for="answer04">개인 회원의 아이디를 변경할 수 있나요? <img src="./img/arrow.png" alt=""> </label>
            <div class="text">
              <p>아이디, 생년월일, 성별은 변경하실 수 없습니다.<br />정보가 잘못된 경우 관리자에게 문의하시거나, 다시 가입을 하여 이용해주시길 바랍니다.</p>
            </div>
          </li>

          <li class="corporate_questions">
            <input type="radio" name="question" id="answer05">
            <label class="corporate_questions" for="answer05">채용 공고 수정은 어디에서 어떻게 하나요?<img src="./img/arrow.png" alt=""> </label>
            <div class="text">
              <p>기업 회원으로 로그인 하신 후, '공고'탭에서 하실 수 있습니다.<br />수정하려는 공고를 클릭하여 수정을 하실 수 있습니다.</p>
            </div>
          </li>
          <!-- 기업회원 질문 -->
          <li class="corporate_questions">
            <input type="radio" name="question" id="answer06">
            <label class="corporate_questions" for="answer06">기업 회원의 상호명, 대표자명을 변경할 수 있나요? <img src="./img/arrow.png" alt=""> </label>
            <div class="text">
              <p>변경이 가능합니다.<br />기업회원 로그인 후, 우측 상단의 회사명을 클릭하여 '내 정보'에 들어가셔서 수정하실 수 있습니다. <br />다만 업종과 사업자등록번호는 변경하실 수 없습니다.</p>
            </div>
          </li>

          <li class="corporate_questions">
            <input type="radio" name="question" id="answer07">
            <label class="corporate_questions" for="answer07">채용공고는 어디서 올리나요?<img src="./img/arrow.png" alt=""> </label>
            <div class="text">
              <p>기업 회원으로 로그인 후, <br />'공고'탭에서 '신규 등록하기'를 클릭하여 등록할 수 있습니다.</p>
            </div>
          </li>

          <li class="corporate_questions">
            <input type="radio" name="question" id="answer08">
            <label class="corporate_questions" for="answer08">세금계산서를 발행할 수 있나요?<img src="./img/arrow.png" alt=""> </label>
            <div class="text">
              <p>세금계산서를 별도로 발행해드리지 않습니다. 다른 계산서가 필요하신 경우 1:1문의 바랍니다.</p>
            </div>
          </li>

          <li class="corporate_questions">
            <input type="radio" name="question" id="answer09">
            <label class="corporate_questions" for="answer09">진행중인 채용공고 마감을 하고 싶으면 어떻게 하나요?<img src="./img/arrow.png" alt=""> </label>
            <div class="text">
              <p>기업 회원으로 로그인 후, <br />'공고'탭에서 마감하려는 공고를 클릭 후 마감날짜를 수정 또는 공고를 삭제하여주시기 바랍니다.</p>
            </div>
          </li>

          <li class="corporate_questions">
            <input type="radio" name="question" id="answer10">
            <label class="corporate_questions" for="answer10">구입한 플랜을 환불하고싶어요.<img src="./img/arrow.png" alt=""> </label>
            <div class="text">
              <p>환불은 구입한 플랜을 사용하지 않은 상태에서만 가능하며, <br />1:1 문의를 통해 환불처리를 도와드리겠습니다.</p>
            </div>
          </li>
        </ul>
      </ul>
      </ul>

    </div>
  </div>

  <!-- 푸터부분 시작 -->
  <?php
  include_once $_SERVER['DOCUMENT_ROOT'] . "/php_treefare/inc/inc_footer.php"
  ?>


  <script>
    //nav active 활성화
    document.querySelectorAll('.nav-item').forEach(function(data, idx) {
      console.log(data, idx);
      data.classList.remove('active');

      if (idx === 3) {
        data.classList.add('active');
      }
    });
  </script>

</body>

</html>