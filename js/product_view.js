document.addEventListener("DOMContentLoaded", () => {
  const btn_buy = document.querySelector("#btn_buy");
  btn_buy.addEventListener("click", () => {
    const f = document.cart_form2;
    const count = document.querySelector("#select_count");
    f.count.value = count.value;
    f.submit();
  });
});