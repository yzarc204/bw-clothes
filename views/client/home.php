<?php
require './views/layouts/boyka/html_start.php';
require './views/layouts/boyka/header.php';
?>

<!-- Banner -->
<div class="hero-slider hero-slider-one slick-banner">
    <div class="single-slide" style="background-image: url('assets/boyka/images/slider/banner1.jpg');">
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
        <div class="row">
            <?php if (!empty($products)): ?>
                <?php foreach (array_slice($products, 0, 8) as $product): ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <div class="single-product-wrap">
                            <div class="product-image">
                                <a href="product/<?= $product['id'] ?>">
                                    <img src="<?= $product['image'] ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                                </a>
                            </div>
                            <div class="product-content text-center mt-2">
                                <h5 class="product-name">
                                    <a href="product/<?= $product['id'] ?>">
                                        <?= htmlspecialchars($product['name']) ?>
                                    </a>
                                </h5>
                                <div class="price-box">
                                    <span class="new-price"><?= number_format($product['sale_price'] ?? $product['price'], 0, ',', '.') ?>đ</span>
                                    <?php if (!empty($product['sale_price'])): ?>
                                        <span class="old-price"><?= number_format($product['price'], 0, ',', '.') ?>đ</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12"><p>Chưa có sản phẩm để hiển thị.</p></div>
            <?php endif; ?>
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
                            style="height: 350px; width: 100%; object-fit: cover;"
                        >
                        <a href="category/<?= $category['id'] ?>" class="category-inner d-block mt-2">
                            <?= htmlspecialchars($category['name']) ?>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>




<?php require 'views/layouts/boyka/footer.php'; ?>
<?php require 'views/layouts/boyka/html_end.php'; ?>