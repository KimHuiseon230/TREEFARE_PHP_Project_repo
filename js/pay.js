document.addEventListener(`DOMContentLoaded`, () => {
  const btn_member = document.querySelector(`#btn_member`);
  const btn_cancel = document.querySelector(`#btn_cancel`);

  btn_member.addEventListener(`click`, () => {
    const chk_member1 = document.querySelector(`#chk_member1`);
    const chk_member2 = document.querySelector(`#chk_member2`);

    if (chk_member1.checked != true) {
      alert(`이용약관에 동의해주세요.`);
      return false;
    }
    if (chk_member2.checked != true) {
      alert(`전자금융거래약관에 동의해주세요.`);
      return false;
    }
    alert("주문이 완료되었습니다.");
    self.location.href = `../index.php`;
  });

  //회원취소
  btn_cancel.addEventListener(`click`, () => {
    const chk_member1 = document.querySelector(`#chk_member1`);
    chk_member1.checked = false;
    const chk_member2 = document.querySelector(`#chk_member2`);
    chk_member2.checked = false;
  });
});