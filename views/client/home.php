<?php
require './views/layouts/boyka/html_start.php';
require './views/layouts/boyka/header.php';
?>

<!-- Banner -->
<div class="hero-slider hero-slider-one slick-banner">
    <div class="single-slide" style="background-image: url('assets/boyka/images/slider/slider-bg-1.jpg');">
        <div class="hero-content-one container text-center text-white">
            <h1>Classic Leather Accessories<br><small>Amazing For Men's</small></h1>
            <a href="shop" class="btn slider-btn uppercase"><span><i class="fa fa-plus"></i> Shop Now</span></a>
        </div>
    </div>
    <div class="single-slide" style="background-image: url('assets/boyka/images/slider/slider-bg-2.jpg');">
        <div class="hero-content-one container text-center text-white">
            <h1>Classic Leather Accessories<br><small>Amazing For Men's</small></h1>
            <a href="shop" class="btn slider-btn uppercase"><span><i class="fa fa-plus"></i> Shop Now</span></a>
        </div>
    </div>
</div>

<!-- Banner images -->
<div class="banner-area mb--30">
    <div class="container">
        <div class="row">
            <?php for ($i = 1; $i <= 3; $i++): ?>
                <div class="col-lg-4 col-md-4">
                    <div class="single-banner mt--30">
                        <a href="shop.html"><img src="assets/boyka/images/banner/<?= $i ?>.jpg" alt="Banner <?= $i ?>"></a>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
    </div>
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
                <?php foreach (array_slice($products, 0, 8) as $product): ?>
                    <div class="single-product-wrap">
                        <div class="product-image">
                            <a href="/product/<?= $product['id'] ?>"><img src="<?= $product['image'] ?>" alt=""></a>
                            <?php if ($product['sale_price']): ?>
                            <?php $discount = round(($product['price'] - $product['sale_price']) / $product['price'] * 100); ?>
                            <span class="label-product label-new">SALE</span>
                            <span class="label-product label-sale">-<?= $discount ?>%</span>
                            <?php endif; ?>
                            <div class="quick_view">
                                <a href="#" title="quick view" class="quick-view-btn" data-bs-toggle="modal" data-bs-target="#exampleModalCenter"><i class="fa fa-search"></i></a>
                            </div>
                        </div>
                        <div class="product-content">
                            <h3><a href="/product/<?= $product['id'] ?>"><?= $product['name'] ?></a></h3>
                            <div class="price-box">
                                <?php if ($product['sale_price']): ?>
                                    <span class="new-price"><?= currencyFormat($product['sale_price']) ?>đ</span>
                                <?php endif; ?>
                                <span class="old-price"><?= currencyFormat($product['price']) ?>đ</span>
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
<div class="poslistcategories-area section-ptb">
    <div class="container-fluid plr-30">
        <div class="product-categproes-active slick-slider">
            <?php foreach ($categories as $category): ?>
                <div>
                    <div class="categories-list-post-item text-center">
                        <img
                            src="<?= htmlspecialchars($category['image']) ?>"
                            alt="<?= htmlspecialchars($category['name']) ?>"
                            class="img-fluid"
                            style="height: 350px; width: 100%; object-fit: cover;">
                        <a href="/category/<?= $category['id'] ?>" class="category-inner d-block mt-2">
                            <?= htmlspecialchars($category['name']) ?>
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
                        <h3>Free Shipping</h3>
                        <p>Free shipping on all US order or order above $200</p>
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
                        <h3>Support 24/7</h3>
                        <p>Contact us 24 hours a day, 7 days a week</p>
                    </div>
                </div>
                <!-- single-service-item end -->
            </div>
            <div class="col-lg-3 col-md-6">
                <!-- single-service-item start -->
                <div class="single-service-item">
                    <div class="our-service-icon">
                        <i class="fa fa-undo"></i>
                    </div>
                    <div class="our-service-info">
                        <h3>30 Days Return</h3>
                        <p>Simply return it within 30 days for an exchange</p>
                    </div>
                </div>
                <!-- single-service-item end -->
            </div>
            <div class="col-lg-3 col-md-6">
                <!-- single-service-item start -->
                <div class="single-service-item">
                    <div class="our-service-icon">
                        <i class="fa fa-credit-card"></i>
                    </div>
                    <div class="our-service-info">
                        <h3>100% Payment Secure</h3>
                        <p>We ensure secure payment with PEV</p>
                    </div>
                </div>
                <!-- single-service-item end -->
            </div>
        </div>
    </div>
</div>


<?php require 'views/layouts/boyka/footer.php'; ?>
<?php require 'views/layouts/boyka/html_end.php'; ?>