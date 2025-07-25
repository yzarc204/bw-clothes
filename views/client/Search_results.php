<?php
require './views/layouts/boyka/html_start.php';
require './views/layouts/boyka/header.php';
?>
<?php
$breadcrumbTitle = 'shop';
include './views/layouts/boyka/breadcrumb.php';
?>


<div class="product-area section-ptb">
    <div class="container">
        <?php if (!empty($products)): ?>
            <div class="row">
                <?php foreach ($products as $product): ?>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-4">
                        <div class="single-product-wrap">
                            <div class="product-image">
                                <a href="/product/<?= $product['id'] ?>">
                                    <img src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
                                </a>
                            </div>
                            <div class="product-content text-center">
                                <h6><a href="/product/<?= $product['id'] ?>"><?= $product['name'] ?></a></h6>
                                <div class="price text-danger">
                                    <?= number_format($product['price']) ?> đ
                                </div>
                                <div class="mt-2">
                                    <a href="/product/<?= $product['id'] ?>" class="btn btn-outline-primary btn-sm">Chi tiết</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-warning text-center">
                Không tìm thấy sản phẩm nào phù hợp.
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
require 'views/layouts/boyka/footer.php';
require 'views/layouts/boyka/html_end.php';
?>
