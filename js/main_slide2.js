document.addEventListener("DOMContentLoaded", () => {
  const slideWrapper = document.querySelector(".slide-wrapper");
  const slides = document.querySelectorAll(".slide");
  const prevBtn = document.querySelector(".prev-btn");
  const nextBtn = document.querySelector(".next-btn");

  let currentIndex = 0;

  prevBtn.addEventListener("click", () => {
    currentIndex = currentIndex > 0 ? currentIndex - 1 : slides.length - 1;
    moveSlide(currentIndex);
  });

  nextBtn.addEventListener("click", () => {
    currentIndex = currentIndex < slides.length - 1 ? currentIndex + 1 : 0;
    moveSlide(currentIndex);
  });

  startAutoSlide(); // 자동 슬라이드 시작

  function moveSlide(index) {
    slideWrapper.style.transform =`translateX(-${
      index * (80/ slides.length)
    }%)`;
  }

  // 자동 슬라이드 함수 추가
  function startAutoSlide() {
    setInterval(() => {
      currentIndex = currentIndex < slides.length - 1 ? currentIndex + 1 : 0;
      moveSlide(currentIndex);
    }, 2000); // 1초 간격으로 다음 슬라이드로 넘어갑니다.
  }
});