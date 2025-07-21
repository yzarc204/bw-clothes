<?php
require './views/layouts/boyka/html_start.php';
require './views/layouts/boyka/header.php';
?>

<div class="product-area section-ptb">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <!-- section-title start -->
        <div class="section-title section-bg-2">
          <h2>Bestseller Products</h2>
          <p>Most Trendy 2023 Clother</p>
        </div>
        <!-- section-title end -->
      </div>
    </div>
    <!-- product-wrapper start -->
    <div class="product-wrapper">
      <div class="product-slider">
        <!-- single-product-wrap start -->
        <?php foreach ($products as $product): ?>
          <div class="single-product-wrap">
            <div class="product-image">
              <a href="product-details.html"><img src="<?= $product['image'] ?>" alt="" /></a>
              <span class="label-product label-new">new</span>
              <span class="label-product label-sale">-9%</span>
              <div class="quick_view">
                <a href="#" title="quick view" class="quick-view-btn" data-bs-toggle="modal"
                  data-bs-target="#exampleModalCenter"><i class="fa fa-search"></i></a>
              </div>
            </div>
            <div class="product-content">
              <h3><a href="product-details.html"><?= $product['name'] ?></a></h3>
              <div class="price-box">
                <span class="new-price"><?= $product['sale_price'] ?></span>
                <span class="old-price"><?= $product['price'] ?></span>
              </div>
              <div class="product-action">
                <button class="add-to-cart" title="Add to cart">
                  <i class="fa fa-plus"></i> Add to cart
                </button>
                <div class="star_content">
                  <ul class="d-flex">
                    <li>
                      <a class="star" href="#"><i class="fa fa-star"></i></a>
                    </li>
                    <li>
                      <a class="star" href="#"><i class="fa fa-star"></i></a>
                    </li>
                    <li>
                      <a class="star" href="#"><i class="fa fa-star"></i></a>
                    </li>
                    <li>
                      <a class="star" href="#"><i class="fa fa-star"></i></a>
                    </li>
                    <li>
                      <a class="star-o" href="#"><i class="fa fa-star-o"></i></a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
    <!-- product-wrapper end -->
  </div>
</div>

<?php
require './views/layouts/boyka/footer.php';
require './views/layouts/boyka/html_end.php';