document.addEventListener(`DOMContentLoaded`, () => {
  const btn_member = document.querySelector(`#btn_member`);
  const btn_cancel = document.querySelector(`#btn_cancel`);

  //회원가입
  btn_member.addEventListener(`click`, () => {
    const chk_member1 = document.querySelector(`#chk_member1`);
    const chk_member2 = document.querySelector(`#chk_member2`);

    if (chk_member1.checked != true) {
      alert(`회원약관에 동의해주세요.`);
      return false;
    }
    if (chk_member2.checked != true) {
      alert(`개인정보 방침에 동의해주세요.`);
      return false;
    }

    // self.location.href = `./member_input.php`;
    const f = document.member_form;
    f.chk.value = 1;
    f.submit();
  });

  //회원취소
  btn_cancel.addEventListener(`click`, () => {
    const chk_member1 = document.querySelector(`#chk_member1`);
    chk_member1.checked = false;
    const chk_member2 = document.querySelector(`#chk_member2`);
    chk_member2.checked = false;
  });
});
