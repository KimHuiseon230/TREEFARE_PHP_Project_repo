document.addEventListener(`DOMContentLoaded`, () => {
  const btn_login = document.querySelector(`#btn_login`);
  btn_login.addEventListener("click", () => {
    self.location.href = "./login/login_form.php";
  });
}); // DOM 끝
