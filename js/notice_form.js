document.addEventListener("DOMContentLoaded", () => {
    const complete = document.querySelector("#complete");
    complete.addEventListener("click", () => {
      if (!document.notice_form.subject.value) {
        alert("제목을 입력하세요!");
        document.notice_form.subject.focus();
        return;
      }
      if (!document.notice_form.content.value) {
        alert("내용을 입력하세요!");
        document.notice_form.content.focus();
        return;
      }
      document.notice_form.submit();
    });
    const btn_back = document.querySelector("#btn_back");
    btn_back.addEventListener("click", ()=>{
      history.go(-1);
    });
  });
  