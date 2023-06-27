<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="true">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="4" aria-label="Slide 5"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="5" aria-label="Slide 6"></button>
  </div>
  <div class="carousel-inner carousel-fade" data-bs-ride="carousel">
    <div class="carousel-item active" data-bs-interval="3000">
      <img src="http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/images/slide_img/slide_img1.jpg' ?>" class="d-block w-100 h-50" alt="...">
    </div>
    <div class="carousel-item" data-bs-interval="3000">
      <img src="http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/images/slide_img/slide_img2.jpg' ?>" class="d-block w-100 h-50" alt="...">
    </div>
    <div class="carousel-item" data-bs-interval="3000">
      <img src="http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/images/slide_img/slide_img3.jpg' ?>" class="d-block w-100 h-50" alt="...">
    </div>
    <div class="carousel-item" data-bs-interval="3000">
      <img src="http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/images/slide_img/slide_img4.jpg' ?>" class="d-block w-100 h-50" alt="...">
    </div>
    <div class="carousel-item" data-bs-interval="3000">
      <img src="http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/images/slide_img/slide_img5.jpg' ?>" class="d-block w-100 h-50" alt="...">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>