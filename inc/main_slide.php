<div class="container w-auto mt-5">
  <h2>상품</h2>
  <!-- <div class="d-flex justify-content-between mb-3">
    <form class="d-flex" role="search">
      <input class="form-control me-2" type="search" placeholder="상품명 검색" aria-label="Search">
      <i class="fas fa-search btn"></i>
    </form>
  </div> -->
  <!-- <div class="filter row row-cols-1 row-cols-lg-5 mb-5" style="background-color: light;">
      <span>
        <input type="radio" class="btn-check fs-1" name="all" value="all" autocomplete="off" checked>
        <label for="all" class="btn btn-secondary">#전체</label>
      </span>
      <span>
        <input type="radio" class="btn-check fs-1" name="option1" value="option1">
        <label for="option1" class="btn btn-secondary">#얼리스테이지</label>
      </span>
      <span>
        <input type="radio" class="btn-check fs-1" name="all" value="all">
        <label for="all" class="btn btn-secondary">#Window</label>
      </span>
      <span>
        <input type="radio" class="btn-check fs-1" name="all" value="all">
        <label for="all" class="btn btn-secondary">#macOS</label>
      </span>
      <span>
        <input type="radio" class="btn-check fs-1" name="all" value="all">
        <label for="all" class="btn btn-secondary">#Steam</label>
      </span>
      <span>
        <input type="radio" class="btn-check fs-1" name="all" value="all">
        <label for="all" class="btn btn-secondary">#Android</label>
      </span>
      <span>
        <input type="radio" class="btn-check fs-1" name="all" value="all">
        <label for="all" class="btn btn-secondary">#iOS</label>
      </span>
    </div> -->
  <div class="allGames">
    <div class="row row-cols-1 row-cols-md-4 g-4">
      <div class="col">
        <div class="card h-100">
          <a class="navbar-brand" href="http://<?= $_SERVER['HTTP_HOST'] . '/project/game_info/info.php' ?>">
            <img src="http://<?= $_SERVER['HTTP_HOST'] . '/project/common/card_img/img1.png' ?>" class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title">던전앤파이터</h5>
              <p class="card-text"><small class="text-muted">ACTION RPG</small></p>
            </div>
          </a>
        </div>
      </div>
      <div class="col">
        <div class="card h-100">
          <a class="navbar-brand" href="http://<?= $_SERVER['HTTP_HOST'] . '/project/game_info/info.php' ?>">
            <img src="http://<?= $_SERVER['HTTP_HOST'] . '/project/common/card_img/img2.png' ?>" class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title">메이플스토리</h5>
              <p class="card-text"><small class="text-muted">RPG</small></p>
            </div>
          </a>
        </div>
      </div>
      <div class="col">
        <div class="card h-100">
          <a class="navbar-brand" href="http://<?= $_SERVER['HTTP_HOST'] . '/project/game_info/info.php' ?>">
            <img src="http://<?= $_SERVER['HTTP_HOST'] . '/project/common/card_img/img3.png' ?>" class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title">FIFA 온라인4</h5>
              <p class="card-text"><small class="text-muted">스포츠</small></p>
            </div>
          </a>
        </div>
      </div>
      <div class="col">
        <div class="card h-100">
          <a class="navbar-brand" href="http://<?= $_SERVER['HTTP_HOST'] . '/project/game_info/info.php' ?>">
            <img src="http://<?= $_SERVER['HTTP_HOST'] . '/project/common/card_img/img5.png' ?>" class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title">블루 아카이브</h5>
              <p class="card-text"><small class="text-muted">수집형RPG</small></p>
            </div>
          </a>
        </div>
      </div>
    </div>
  </div>
</div> <!-- end of container -->
</div>