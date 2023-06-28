<style>
  #img {
    width: 150px;
    height: auto;
    margin-left: 15px;
  }
</style>

<div class="container" style="margin-bottom: 30px; margin-top: 30px;">
  <h3 class="mb-3">다양한 Treefare 서비스</h3>
  <div class="row d-flex justify-content-around" style=" height: 300px; width: auto;">
    <div class="col-sm-3 text-center" style="width: 16rem;">
      <div class="card justify-content-center">
        <div class="card-body   bg-light text-dark text-center" style="height: 300px;">
          <i class="fas fa-sharp fa-truck me-2 card-img-top mt-5 mb-4 " id="icon" style="font-size: 6rem; " id="img"></i>
          <a href="http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/as/shipping_service.php' ?>" class="btn btn-secondary text-white ">배송 서비스</a>
        </div>
      </div>
    </div>
    <div class="col-sm-3 text-center" style="width: 16rem;">
      <div class="card justify-content-center">
        <div class="card-body   bg-light text-dark " style="height: 300px;">
          <i class=" fas fa-solid fa-cart-flatbed me-2 card-img-top mt-5 mb-4 " id="icon" style="font-size: 6rem; " id="img"></i>
          <a href="http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/as/click_pickup_service.php' ?>" class="btn btn-secondary text-white ">클릭 앤 픽업 서비스</a>
        </div>
      </div>
    </div>
    <div class="col-sm-3 text-center" style="width: 16rem;">
      <div class="card justify-content-center">
        <div class="card-body   bg-light text-dark" style="height: 300px;">

          <i class=" fas fa-solid fa-toolbox me-2 card-img-top mt-5 mb-4 " id="icon" style="font-size: 6rem; " id="img"></i>
          <a href="http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/as/assembly_service.php' ?>" class="btn btn-secondary text-white">조립 서비스</a>
        </div>
      </div>
    </div>
    <div class="col-sm-3 text-center" style="width: 16rem;">
      <div class="card justify-content-center">
        <div class="card-body   bg-light text-dark" style="height: 300px;">
          <i class="fas fa-solid fa-screwdriver-wrench  me-2 card-img-top mt-5 mb-4 " id="icon" style="font-size: 6rem; " id="img"></i>
          <a href="http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/as/installation_service.php' ?>" class="btn btn-secondary text-white">설치 서비스</a>
        </div>
      </div>
    </div>
    <div class="col-sm-3 text-center" style="width: 16rem;">
      <div class="card justify-content-center">
        <div class="card-body   bg-light text-dark" style="height: 300px;">
          <i class="fas fa-solid fa-kitchen-set me-2 card-img-top mt-5 mb-4 " id="icon" style="font-size: 6rem; " id="img"></i>
          <a href="http://<?= $_SERVER['HTTP_HOST'] . '/php_treefare/as/kitchen_service.php' ?>" class="btn btn-secondary text-white">주방 서비스</a>
        </div>
      </div>
    </div>
  </div>
</div> <!-- div : container 종료 -->