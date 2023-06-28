document.addEventListener("DOMContentLoaded", () => {
  const btn_input = document.querySelector("#btn_input");
  btn_input.addEventListener("click", () => {
    if (!document.board_form.name.value) {
      alert("상품명을 입력하세요!");
      document.board_form.name.focus();
      return;
    }
    if (!document.board_form.price.value) {
      alert("원가를 입력하세요!");
      document.board_form.price.focus();
      return;
    }
    if (!document.board_form.sale.value) {
      alert("세일가를 입력하세요!");
      document.board_form.sale.focus();
      return;
    }
    if (!document.board_form.content.value) {
      alert("상품설명을 입력하세요!");
      document.board_form.content.focus();
      return;
    }
    document.board_form.submit();
  });
  const btn_back = document.querySelector("#btn_back");
  btn_back.addEventListener("click", () => {
    history.go(-1);
  });
});
