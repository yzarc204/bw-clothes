<?php $pageTitle = $category['name'] . ' | BW-CLOZ'; ?>
<?php require './views/layouts/boyka/html_start.php'; ?>
<?php require './views/layouts/boyka/header.php'; ?>

<div class="content-wraper">
  <div class="container">
    <div class="row mt-5">
      <div class="col-lg-12">
        <div class="section-title section-bg-2">
          <h2><?= $category['name'] ?></h2>
          <p>Danh sách sản phẩm <?= strtolower($category['name']) ?> mới nhất</p>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <!-- shop-products-wrapper start -->
        <div class="shop-products-wrapper">
          <div class="shop-product-area">
            <div class="row">
              <?php foreach ($products['items'] as $product): ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mt-30">
                  <!-- single-product-wrap start -->
                  <div class="single-product-wrap">
                    <div class="product-image">
                      <a href="/product/<?= $product['id'] ?>">
                        <img src="<?= BASE_URL . '/' . $product['featured_image'] ?>" alt="<?= $product['name'] ?>">
                      </a>
                      <span class="label-product label-new">new</span>
                    </div>
                    <div class="product-content">
                      <h3><a href="/product/<?= $product['id'] ?>"><?= $product['name'] ?></a></h3>
                      <div class="price-box">
                        <span class="new-price"><?= currencyFormat($product['min_price'] ?? 0) ?>đ</span>
                        <span>-</span>
                        <span class="new-price"><?= currencyFormat($product['max_price'] ?? 0) ?>đ</span>
                      </div>
                      <div class="product-action">
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
                  <!-- single-product-wrap end -->
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
        <?php boykaPagination($products); ?>
      </div>
    </div>
    <!-- shop-products-wrapper end -->
  </div>
</div>

<?php require 'views/layouts/boyka/footer.php'; ?>
<?php require 'views/layouts/boyka/html_end.php'; ?>