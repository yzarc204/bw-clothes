<?php
require './views/layouts/boyka/html_start.php';
require './views/layouts/boyka/header.php';
$breadcrumbTitle = 'Danh mục => ' . htmlspecialchars($category['name']);
include './views/layouts/boyka/breadcrumb.php';
?>
<div class="container section-ptb">
    <h3>Sản phẩm thuộc danh mục: <?= htmlspecialchars($category['name']) ?></h3>
    <div class="row">
        <?php foreach ($products as $product): ?>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card h-100">
                    <img src="<?= $product['image'] ?>" class="card-img-top" alt="<?= $product['name'] ?>">
                    <div class="card-body text-center">
                        <h5 class="card-title"><?= $product['name'] ?></h5>
                        <p class="card-text text-danger"><?= number_format($product['price']) ?> đ</p>
                        <a href=/product/<?= $product['id'] ?> class="btn btn-outline-primary btn-sm">Chi tiết</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php
require 'views/layouts/boyka/footer.php';
require 'views/layouts/boyka/html_end.php';
?>