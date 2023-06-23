document.addEventListener(`DOMContentLoaded`, () => {
  // 아이디 변경 시 중복확인 체크 해제
  const form_id = document.querySelector("#form_id");
  form_id.addEventListener("input", () => {
    document.input_form.id_check.value = "0";
  });

  // 이메일 변경 시 중복확인 체크 해제
  const form_email = document.querySelector("#form_email");
  form_email.addEventListener("input", () => {
    document.input_form.email_check.value = "0"
  })
  // 아이디 중복체크
  const btn_id_check = document.querySelector(`#btn_id_check`);
  btn_id_check.addEventListener(`click`, () => {
    if (document.input_form.id.value == "") {
      alert("아이디를 입력해주세요");
      document.input_form.id.focus();
      return false;
    }
    // 아이디 패턴검색
    let id_regx = /^[a-z]{1}[a-z0-9A-Z_]{5,9}$/g;
    if (form_id.value.match(id_regx) == null) {
      alert(
        "첫자 영문자 소문자,숫자,_,대소문자입력 가능. 최소 6자이상 10자이하"
      );
      document.input_form.id.value = "";
      document.input_form.id.focus();
      return false;
    }
    //ajax 점검
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "../pg/member_process.php", true);
    // 전송 데이터 생성
    const formdata = new FormData();
    formdata.append("id", document.input_form.id.value);
    formdata.append("mode", "id_check");
    xhr.send(formdata);
    // 핸들러기능(비동기식처리)
    xhr.onload = () => {
      if (xhr.status == 200) {
        // json.parse = json객체를 javascript객체 변환
        // {'result': 'success'} => {result: 'success'}
        const data = JSON.parse(xhr.responseText);
        switch (data.result) {
          case "fail":
            alert("사용 불가능한 아이디입니다.");
            document.input_form.id.value = "";
            document.input_form.id_check.value = "0";
            document.input_form.id.focus();
            break;
          case "success":
            alert("사용 가능한 아이디입니다.");
            document.input_form.id_check.value = "1";
            break;
          case "empty_id":
            alert("아이디를 입력해주세요.");
            document.input_form.id_check.value = "0";
            document.input_form.id.focus();
            break;
          case "empty_mode":
            alert("모드를 입력해주세요.");
            document.input_form.id_check.value = "0";
            document.input_form.id.focus();
            break;
          default:
        }
      } else {
        alert("서버 통신 불가");
      }
    };
  });

  // 이메일 중복체크
  const btn_email_check = document.querySelector(`#btn_email_check`);
  btn_email_check.addEventListener(`click`, () => {
    if (document.input_form.email.value == "") {
      alert("이메일을 입력해주세요");
      document.input_form.email.focus();
      return false;
    }

    // 이메일 패턴검색
    let email_regx =
      /^[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*\.[a-zA-Z]{2,3}$/i;
    if (form_email.value.match(email_regx) == null) {
      alert("이메일 폼을 맞춰주십시오.");
      document.input_form.email.value = "";
      document.input_form.email.focus();
      return false;
    }

    //ajax 점검
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "../pg/member_process.php", true);
    // 전송 데이터 생성
    const formdata = new FormData();
    formdata.append("email", document.input_form.email.value);
    formdata.append("mode", "email_check");
    xhr.send(formdata);
    // 핸들러기능(비동기식처리)
    xhr.onload = () => {
      if (xhr.status == 200) {
        // json.parse = json객체를 javascript객체 변환
        // {'result': 'success'} => {result: 'success'}
        const data = JSON.parse(xhr.responseText);
        switch (data.result) {
          case "fail":
            alert("이미 사용중인 이메일입니다.");
            document.input_form.email.value = "";
            document.input_form.email_check.value = "0";
            document.input_form.email.focus();
            break;
          case "success":
            alert("사용 가능한 이메일입니다.");
            document.input_form.email_check.value = "1";
            break;
          case "empty_id":
            alert("이메일를 입력해주세요.");
            document.input_form.email_check.value = "0";
            document.input_form.email.focus();
            break;
          case "empty_mode":
            alert("모드를 입력해주세요.");
            document.input_form.email_check.value = "0";
            document.input_form.email.focus();
            break;
          case "form_error_email":
            alert("이메일 폼을 맞춰주십시오.(서버)");
            document.input_form.email.value = "";
            document.input_form.email_check.value = "0";
            document.input_form.email.focus();
            break;
          default:
        }
      } else {
        alert("서버 통신 불가");
      }
    };
  });

  // 주소 찾기
  const btn_zipcode = document.querySelector(`#btn_zipcode`);
  btn_zipcode.addEventListener("click", () => {
    new daum.Postcode({
      oncomplete: function (data) {
        let addr = "";
        let extra_addr = "";
        //지번, 도로명 선택
        if (data.userSelectedType == "J") {
          addr = data.jibunAddress;
        } else if (data.userSelectedType == "R") {
          addr = data.roadAddress;
        }
        //동이름 점검
        if (data.bname != "") {
          extra_addr = data.bname;
        }
        //빌딩명 점검
        if (data.buildingName != "") {
          if (extra_addr != "") {
            extra_addr += "," + data.buildingName;
          } else {
            extra_addr = data.buildingName;
          }
          extra_addr =
            extra_addr != "" ? "," + data.buildingName : data.buildingName;
        }
        if (extra_addr != "") {
          extra_addr = "(" + extra_addr + ")";
        }
        addr = addr + extra_addr;

        document.input_form.zipcode.value = data.zonecode;
        document.input_form.addr1.value = addr;
      },
    }).open();
  });

  // 프로필 이미지 로딩
  const form_photo = document.querySelector(`#form_photo`);
  form_photo.addEventListener("change", (e) => {
    const fr = new FileReader();
    // 선택된 이미지 로딩
    fr.readAsDataURL(e.target.files[0]);
    fr.onload = function (event) {
      const form_preview = document.querySelector(`#form_preview`);
      form_preview.setAttribute("src", event.target.result);
    };
  });

  // 가입전송(폼 전송 체크)
  const btn_submit = document.querySelector(`#btn_submit`);
  btn_submit.addEventListener("click", () => {
    const f = document.input_form;
    if (f.id.value == "") {
      alert("아이디를 입력해주세요.");
      f.id.focus();
      return false;
    }
    if (f.id_check.value == 0) {
      alert("아이디 중복확인을 해주세요.");
      return false;
    }
    if (f.name.value == "") {
      alert("이름을 입력해주세요.");
      f.name.focus();
      return false;
    }
    // 이름패턴검색 영역
    if (f.password.value == "") {
      alert("비밀번호를 입력해주세요.");
      f.password.focus();
      return false;
    }
    if (f.password2.value == "") {
      alert("비밀번호 확인을 입력해주세요.");
      f.password2.focus();
      return false;
    }
    if (f.password.value != f.password2.value) {
      alert("비밀번호가 일치하지 않습니다.\n다시 입력해주세요.");
      f.password.value = "";
      f.password2.value = "";
      f.password2.focus();
      return false;
    }
    if (f.email.value == "") {
      alert("이메일을 입력해주세요.");
      f.email.focus();
      return false;
    }
    if (f.email_check.value == 0) {
      alert("이메일 중복확인을 해주세요.");
      return false;
    }
    // if (f.zipcode.value == "") {
    //   alert("우편번호를 입력해주세요.");
    //   f.zipcode.focus();
    //   return false;
    // }
    // if (f.addr1.value == "") {
    //   alert("기본주소를 입력해주세요.");
    //   f.addr1.focus();
    //   return false;
    // }
    f.submit();
  });
}); // DOM 끝
