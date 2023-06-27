document.addEventListener("DOMContentLoaded", () => {
    // 이메일 중복체크
    const btn_email_check = document.querySelector("#btn_email_check");
    btn_email_check.addEventListener("click", () => {
      if (document.input_form.email.value == "") {
        alert("이메일을 입력해주세요.");
        document.input_form.email.focus();
        return false;
      }
      if (
        document.input_form.email.value == document.input_form.old_email.value
      ) {
        alert("이메일을 변경하지 않았습니다.");
        document.input_form.email.focus();
        return false;
      }
  
      // 이메일 패턴검색
      var email_regx =
        /^[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*\.[a-zA-Z]{2,3}$/i;
      if (document.input_form.email.value.match(email_regx) == null) {
        alert("이메일 폼을 지켜주세요.");
        document.input_form.email.value = "";
        document.input_form.email.focus();
        return false;
      }
  
      // AJAX
      const xhr = new XMLHttpRequest();
      xhr.open("POST", "../pg/member_process.php", true);
      // 전송데이터
      const formdata = new FormData();
      formdata.append("email", document.input_form.email.value);
      formdata.append("mode", "email_check");
      xhr.send(formdata);
      // 핸들러 기능(비동기식)
      xhr.onload = () => {
        if (xhr.readyState == 4 && xhr.status == 200) {
          // json.parse = json객체를 javascript객체 변환
          // {'result': 'success'} => {result: 'success'}
          const data = JSON.parse(xhr.responseText);
          switch (data.result) {
            case "fail":
              alert("이메일 형식이 올바르지 않습니다.");
              document.input_form.email.value = "";
              document.input_form.email_chk.value = "0";
              document.input_form.email.focus();
              break;
            case "success":
              alert("사용 가능한 이메일입니다.");
              document.input_form.email_chk.value = "1";
              break;
            case "empty_email":
              alert("이메일을 입력해주세요.");
              document.input_form.email_chk.value = "0";
              document.input_form.email.focus();
              break;
            case "empty_mode":
              alert("모드를 입력해주세요.");
              document.input_form.email_chk.value = "0";
              document.input_form.email.focus();
              break;
            case "form_error_email":
              alert("이메일 형식이 올바르지 않습니다.");
              document.input_form.email_chk.value = "0";
              document.input_form.email.focus();
              break;
            default:
          }
        } else {
          alert("서버 통신 불가");
        }
      };
    });
  
    // 우편번호 찾기
    const btn_zipcode = document.querySelector("#btn_zipcode");
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
  
    // 프로필이미지 로딩
    const form_photo = document.querySelector("#form_photo");
    form_photo.addEventListener("change", (e) => {
      const fr = new FileReader();
      // 이미지 파일 선택해서 로딩
      fr.readAsDataURL(e.target.files[0]);
      fr.onload = function (event) {
        const form_preview = document.querySelector("#form_preview");
        form_preview.setAttribute("src", event.target.result);
      };
    });
  
    // 가입전송(폼 전송 체크)
    const btn_submit = document.querySelector("#btn_submit");
    btn_submit.addEventListener("click", () => {
      const f = document.input_form;
  
      if (f.name.value == "") {
        alert("이름을 입력해주세요.");
        f.name.focus();
        return false;
      }
  
      if (f.password1.value != "" && f.password2.value == "") {
        alert("비밀번호 확인을 입력해주세요.");
        f.password2.focus();
        return false;
      }
      if (f.password2.value != "" && f.password1.value == "") {
        alert("변경하실 비밀번호를 입력해주세요.");
        f.password1.focus();
        f.password2.value = "";
        return false;
      }
  
      if (f.password1.value != f.password2.value) {
        alert("비밀번호가 일치하지 않습니다.");
        f.password1.value = "";
        f.password2.value = "";
        f.password1.focus();
        return false;
      }
      if (f.email.value == "") {
        alert("이메일을 입력해주세요.");
        f.email.focus();
        return false;
      }
      if (f.email.value != f.old_email.value) {
        if (f.email_chk.value == 0) {
          alert("이메일 중복확인을 해주세요.");
          return false;
        }
      }
      f.submit();
    });
  
    // 가입취소
  }); // DomContentLoaded end
  