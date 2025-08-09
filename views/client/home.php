<?php $pageTitle = 'BW-CLOZ - Thế giới thời trang'; ?>
<?php require './views/layouts/boyka/html_start.php'; ?>
<?php require './views/layouts/boyka/header.php'; ?>

<!-- Banner -->
<div class="hero-slider hero-slider-one slick-banner">
  <?php for ($i = 1; $i <= 11; $i++): ?>
    <div class="single-slide"
      style="background-image: url('<?= BASE_URL ?>/assets/boyka/images/banner/bg<?= $i ?>.jpg');">
      <div class="hero-content-one container text-center text-white">
        <h1>BW-CLOZ - Thế giới thời trang</h1>
        <a href="/shop" class="btn slider-btn uppercase"><span><i class="fa fa-plus"></i> Xem ngay</span></a>
      </div>
    </div>
  <?php endfor; ?>
</div>

<!-- Featured Products -->
<div class="product-area section-ptb">
  <div class="container">
    <div class="row mb-4">
      <div class="col d-flex justify-content-between align-items-center">
        <div>
          <h2>Sản phẩm nổi bật</h2>
          <p>Khám phá các sản phẩm mới và bán chạy</p>
        </div>
        <a href="shop" class="btn btn-dark">Xem thêm</a>
      </div>
    </div>
    <div class="product-wrapper">
      <div class="product-slider">
        <?php foreach ($products as $product): ?>
          <div class="single-product-wrap">
            <div class="product-image">
              <a href="/product/<?= $product['id'] ?>"><img src="<?= BASE_URL . '/' . $product['featured_image'] ?>"
                  alt=""></a>
              <span class="label-product label-new">SALE</span>
              <!-- <span class="label-product label-sale">5%</span> -->
            </div>
            <div class="product-content">
              <h3><a href="/product/<?= $product['id'] ?>"><?= $product['name'] ?></a></h3>
              <div class="price-box">
                <span class="new-price"><?= currencyFormat($product['min_price'] ?? 0) ?>đ</span>
                <span>-</span>
                <span class="new-price"><?= currencyFormat($product['max_price'] ?? 0) ?>đ</span>
              </div>
              <div class="product-action">
                <!-- <button class="add-to-cart" title="Add to cart"><i class="fa fa-plus"></i> Add to cart</button> -->
                <div class="star_content">
                  <ul class="d-flex">
                    <li><a class="star" href="#"><i class="fa fa-star"></i></a></li>
                    <li><a class="star" href="#"><i class="fa fa-star"></i></a></li>
                    <li><a class="star" href="#"><i class="fa fa-star"></i></a></li>
                    <li><a class="star" href="#"><i class="fa fa-star"></i></a></li>
                    <li><a class="star-o" href="#"><i class="fa fa-star-o"></i></a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>

<div class="section-title">
  <h2>Danh mục sản phẩm</h2>
  <p>Khám phá các danh mục sản phẩm</p>
</div>

<div class="poslistcategories-area section-ptb">
  <div class="container-fluid plr-30">
    <div class="product-categproes-active slick-slider">
      <?php foreach ($categories as $category): ?>
        <div>
          <div class="categories-list-post-item text-center">
            <img src="<?= BASE_URL . '/' . $category['image'] ?>" alt="<?= $category['name'] ?>" class="img-fluid"
              style="height: 350px; width: 100%; object-fit: cover;">
            <a href="/category/<?= $category['id'] ?>" class="category-inner d-block mt-2">
              <?= $category['name'] ?>
            </a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
<div class="our-services-area section-pb-70">
  <div class="container">
    <div class="row">
      <div class="col-lg-3 col-md-6">
        <!-- single-service-item start -->
        <div class="single-service-item">
          <div class="our-service-icon">
            <i class="fa fa-truck"></i>
          </div>
          <div class="our-service-info">
            <h3>Miễn phí ship</h3>
            <p>Miễn phí vận chuyển toàn quốc với đơn hàng trên 500.000đ</p>
          </div>
        </div>
        <!-- single-service-item end -->
      </div>
      <div class="col-lg-3 col-md-6">
        <!-- single-service-item start -->
        <div class="single-service-item">
          <div class="our-service-icon">
            <i class="fa fa-truck"></i>
          </div>
          <div class="our-service-info">
            <h3>Vận chuyển thần tốc</h3>
            <p>Hợp tác với 5 đơn vị logistics giúp giao hàng nhanh chóng</p>
          </div>
        </div>
        <!-- single-service-item end -->
      </div>
      <div class="col-lg-3 col-md-6">
        <!-- single-service-item start -->
        <div class="single-service-item">
          <div class="our-service-icon">
            <i class="fa fa-support"></i>
          </div>
          <div class="our-service-info">
            <h3>Hỗ trợ 24/7</h3>
            <p>Đội ngũ chăm sóc khách hàng hoạt động 24/7</p>
          </div>
        </div>
        <!-- single-service-item end -->
      </div>
      <div class="col-lg-3 col-md-6">
        <!-- single-service-item start -->
        <div class="single-service-item">
          <div class="our-service-icon">
            <i class="fa fa-star"></i>
          </div>
          <div class="our-service-info">
            <h3>Chất lượng</h3>
            <p>Khẳng định chất lượng với hơn 1.000 lượt phục vụ khách hàng</p>
          </div>
        </div>
        <!-- single-service-item end -->
      </div>
    </div>
  </div>
</div>


<?php require 'views/layouts/boyka/footer.php'; ?>
<?php require 'views/layouts/boyka/html_end.php'; ?>