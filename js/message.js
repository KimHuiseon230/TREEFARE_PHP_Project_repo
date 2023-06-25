document.addEventListener("DOMContentLoaded", () => {
  const message_send = document.querySelector("#message_send");
  const response_message = document.querySelector("#response_message");
  const message_delete = document.querySelector("#message_delete");

  message_send.addEventListener("click", () => {
    if (!document.message_form.rv_id.value) {
      alert("수신 아이디를 입력하세요!");
      document.message_form.rv_id.focus();
      return;
    }
    if (!document.message_form.subject.value) {
      alert("제목을 입력하세요!");
      document.message_form.subject.focus();
      return;
    }
    if (!document.message_form.content.value) {
      alert("내용을 입력하세요!");
      document.message_form.content.focus();
      return;
    }
    document.message_form.submit();
  });


response_message.addEventListener("click", () => {
  if (!document.message_form.subject.value == '')
  {
      alert("제목을 입력하세요!");
      document.message_form.subject.focus();
      return;
  }
  if (!document.message_form.content.value == '')
  {
      alert("내용을 입력하세요!");    
      document.message_form.content.focus();
      return;
  }
      alert("모두 입력완료했습니다.")
  document.message_form.submit();
 });
 
message_delete.addEventListener("click", () => {
alert("삭제하시겠어요?");
   });
});