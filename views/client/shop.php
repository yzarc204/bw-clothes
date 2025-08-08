<?php include 'views/layouts/boyka/html_start.php'; ?>
<?php include 'views/layouts/boyka/header.php'; ?>
<?php
$breadcrumbTitle = 'shop';
include './views/layouts/boyka/breadcrumb.php';
?>

<!-- Banner, slider,... -->

<div class="product-area section-ptb">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title section-bg-2">
                    <h2>Sản phẩm mới nhất</h2>
                    <p>Danh sách sản phẩm được cập nhật</p>
                </div>
            </div>
        </div>

        <div class="row">
            <?php foreach ($products['items'] as $product): ?>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="single-product-wrap">
                        <div class="product-image">
                            <a href="#">
                                <img src="<?= BASE_URL . '/' . $product['featured_image'] ?>" alt="<?= $product['name'] ?>">
                            </a>
                        </div>
                        <div class="product-content">
                            <h3><?= $product['name'] ?></h3>
                            <div class="price-box">
                                <span class="new-price"><?= currencyFormat($product['min_price'] ?? 0) ?>đ</span>
                                <span>-</span>
                                <span class="new-price"><?= currencyFormat($product['max_price'] ?? 0) ?>đ</span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php boykaPagination($products) ?>
    </div>
</div>

</div> <!-- end row -->






<?php include 'views/layouts/boyka/footer.php'; ?>
<?php include 'views/layouts/boyka/html_end.php'; ?>