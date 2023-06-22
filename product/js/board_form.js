document.addEventListener("DOMContentLoaded", () => {
  const check_input = document.querySelector("#check_input");
  check_input.addEventListener("click", ()=>{

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

  const kind_1 = document.querySelector("#kind_1");
  kind_1.addEventListener("click", ()=>{
    alert("dddddddddd");
  });
});