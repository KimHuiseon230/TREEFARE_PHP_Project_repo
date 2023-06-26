document.addEventListener("DOMContentLoaded", () => {
  const btn_search = document.querySelector("#btn_search")
  const btn_excel = document.querySelector("#btn_excel")
  const btn_mem_delete_arr = document.querySelectorAll(".btn_mem_delete")
  const btn_mem_edit_arr = document.querySelectorAll(".btn_mem_edit")
  const btn_close1 = document.querySelectorAll("#btn_close1")
  const btn_close2 = document.querySelectorAll("#btn_close2")
  const modal= document.querySelector(".modal")

  //검색결과 보여주기
  btn_search.addEventListener('click', () => {
    const sf = document.querySelector("#sf")
    const sn = document.querySelector("#sn")
    if (sf.value == "") {
      alert("검색어를 입력해주세요");
      sf.focus();
      return false;
    }
    // modal.style.display = 'block';
    // self.location.href = './admin.php?sn=' + sn.value + '&sf=' + sf.value;
  });
  //엑셀로 저장
  btn_excel.addEventListener('click', () => {
    self.location.href = './pg/member_to_excel.php';
  })
  //수정기능
  btn_mem_edit_arr.forEach((value) => {
    value.addEventListener("click", () => {
      const idx = value.dataset.idx
      self.location.href = './member_edit.php?idx=' + idx;
    })
  })
  //삭제
  btn_mem_delete_arr.forEach((value) => {
    value.addEventListener('click', () => {
      if(confirm('회원을 삭제하시겠습니까?') === false) {
        return
      }
      const idx = value.dataset.idx

      //ajax 점검
      const xhr = new XMLHttpRequest();
      xhr.open("POST", "./pg/member_delete.php", true);
      // 전송 데이터 생성
      const formdata = new FormData();
      formdata.append("idx", idx);
      xhr.send(formdata);
      // 핸들러기능(비동기식처리)
      xhr.onload = () => {
        if (xhr.status == 200) {
          // json.parse = json객체를 javascript객체 변환
          // {'result': 'success'} => {result: 'success'}
          const data = JSON.parse(xhr.responseText);
          switch (data.result) {
            case "success":
              alert("삭제 완료 하였습니다");
              self.location.reload();
              break;
            case "fail":
              alert("삭제를 실패하였습니다");
              break;
            case "access_denied":
              alert("관리자 권한이 없습니다");
              break;
            case "empty_idx":
              alert("인덱스값이 없습니다");
              break;
            default:
          }
        } else {
          alert("서버 통신 불가");
        }
      }
    })
  })

  btn_close1.addEventListener('click', () => {
   
  })
  btn_close2.addEventListener('click', () => {
    modal.style.display = 'none';
  })
})