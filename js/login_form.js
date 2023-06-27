document.addEventListener(`DOMContentLoaded`, () => {
  const btn_login = document.querySelector(`#btn_login`);
  btn_login.addEventListener("click", () => {
    const form_id = document.querySelector(`#form_id`);
    if (form_id.value == "") {
      alert("아이디를 입력해주세요");
      form_id.focus();
      return false;
    }
    const form_pw = document.querySelector(`#form_pw`);
    if (form_pw.value == "") {
      alert("비밀번호를 입력해주세요");
      form_pw.focus();
      return false;
    }
    //ajax 점검
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "../pg/member_process.php", true);
    // 전송 데이터 생성
    const formdata = new FormData();
    formdata.append("id", form_id.value);
    formdata.append("password", form_pw.value);
    formdata.append("mode", "login");
    xhr.send(formdata);
    // 핸들러기능(비동기식처리)
    xhr.onload = () => {
      if (xhr.status == 200) {
        // json.parse = json객체를 javascript객체 변환
        // {'result': 'success'} => {result: 'success'}
        const data = JSON.parse(xhr.responseText);
        switch (data.result) {
          case "empty_id":
            alert("아이디가 없습니다");
            // form_id.value = "";
            // form_pw.value = "";
            form_id.focus();
            break;
          case "id_fail":
            alert("입력하신 아이디 또는 비밀번호가 존재하지 않습니다.");
            form_id.value = "";
            // form_pw.value = "";
            form_id.focus();
            break;
          case "empty_pw":
            alert("입력하신 아이디 또는 비밀번호가 존재하지 않습니다.");
            // form_id.value = "";
            // form_pw.value = "";
            form_pw.focus();
            break;
          case "pw_fail":
            alert("입력하신 아이디 또는 비밀번호가 존재하지 않습니다.");
            // form_id.value = "";
            form_pw.value = "";
            form_pw.focus();
            break;
          case "empty_mode":
            alert("모드를 설정해주세요.");
            break;
          case "admin_login_success":
            alert("환영합니다.");
            self.location.href = "../index.php";
            break;
          case "login_success":
            alert("환영합니다.");
            self.location.href = "../index.php";
            break;
          default:
        }
      } else {
        alert("서버 통신 불가");
      }
    }; // end of onload
  });
}); // DOM 끝
