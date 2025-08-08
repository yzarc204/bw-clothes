<?php
require './views/layouts/boyka/html_start.php';
require './views/layouts/boyka/header.php';
$breadcrumbTitle = 'Danh mục => ' . htmlspecialchars($category['name']);
include './views/layouts/boyka/breadcrumb.php';
?>

<div class="content-wraper">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <!-- shop-products-wrapper start -->
        <div class="shop-products-wrapper">
          <div class="tab-content">
            <div id="grid-view" class="tab-pane active">
              <div class="shop-product-area">
                <div class="row">
                  <?php foreach ($products['items'] as $product): ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 mt-30">
                      <!-- single-product-wrap start -->
                      <div class="single-product-wrap">
                        <div class="product-image">
                          <a href="/product/<?= $product['id'] ?>"><img src="<?= BASE_URL . '/' . $product['featured_image'] ?>"
                              alt=""></a>
                          <span class="label-product label-new">new</span>
                          <div class="quick_view">
                            <a href="#" title="quick view" class="quick-view-btn" data-bs-toggle="modal"
                              data-bs-target="#exampleModalCenter"><i class="fa fa-search"></i></a>
                          </div>
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
                                <li><a class="star" href="#"><i class="fa fa-star"></i></a>
                                </li>
                                <li><a class="star" href="#"><i class="fa fa-star"></i></a>
                                </li>
                                <li><a class="star" href="#"><i class="fa fa-star"></i></a>
                                </li>
                                <li><a class="star" href="#"><i class="fa fa-star"></i></a>
                                </li>
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
          </div>
        </div>
        <!-- shop-products-wrapper end -->
      </div>
    </div>
  </div>
</div>

<?php
require 'views/layouts/boyka/footer.php';
require 'views/layouts/boyka/html_end.php';
?>