document.addEventListener("DOMContentLoaded", () => {
    const btn_purchase = document.querySelector("#btn_purchase");
    btn_purchase.addEventListener("click", () => {
      const price = document.querySelector("#p_price");
      if (price.innerHTML == "0&nbsp;원") {
        alert("구매할 품목이 없습니다.");
      } else {
        self.location.href = "../pay/pay.php";
      }
    });
  });