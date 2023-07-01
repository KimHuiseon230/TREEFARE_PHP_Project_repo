document.addEventListener("DOMContentLoaded", () => {
  // 검색내용 보여주기
  const btn_search = document.querySelector("#btn_search");
  btn_search.addEventListener("click", () => {
    const sf = document.querySelector("#sf");
    if (sf.value == "") {
      alert("검색어를 입력해주세요.");
      sf.focus();
      return false;
    }
    const sn = document.querySelector("#sn");

    self.location.href =
      "./admin_notice_board.php?sn=" + sn.value + "&sf=" + sf.value;
  });

  // 전체목록 보여주기
  const btn_all = document.querySelector("#btn_all");
  btn_all.addEventListener("click", () => {
    self.location.href = "./admin_notice_board.php";
  });

  // 수정
  const btn_mem_edit_arr = document.querySelectorAll(".btn_mem_edit");
  btn_mem_edit_arr.forEach((value) => {
    value.addEventListener("click", () => {
      const idx = value.dataset.idx;
      self.location.href = "../notice_board/notice_modify_form.php?num=" + idx;
    });
  });

  // 삭제
  const btn_mem_delete_arr = document.querySelectorAll(".btn_mem_delete");
  btn_mem_delete_arr.forEach((value) => {
    value.addEventListener("click", () => {
      if (confirm("게시물을 삭제하시겠습니까?") == false) {
        return;
      }
      const idx = value.dataset.idx;

      // AJAX
      const xhr = new XMLHttpRequest();
      xhr.open("POST", "./pg/notice_delete.php", true);
      // 전송데이터
      const formdata = new FormData();
      formdata.append("idx", idx);
      xhr.send(formdata);
      // 핸들러 기능(비동기식)
      xhr.onload = () => {
        if (xhr.status == 200) {
          // json.parse = json객체를 javascript객체 변환
          // {'result': 'success'} => {result: 'success'}
          const data = JSON.parse(xhr.responseText);
          switch (data.result) {
            case "success":
              alert("삭제되었습니다.");
              self.location.reload();
              break;
            case "fail":
              alert("실패하였습니다.");
              break;
            case "access_denied":
              alert("관리자 권한이 없습니다.");
              break;
            case "empty_idx":
              alert("삭제할 대상이 없습니다.");
              break;
            default:
          }
        } else {
          alert("서버 통신 불가");
        }
      };
    });
  });
}); // DomContentLoaded end
