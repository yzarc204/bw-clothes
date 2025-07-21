<?php include 'layouts/boyka/html_start.php'; ?>
<?php include 'layouts/boyka/header.php'; ?>
<?php include 'views/layouts/boyka/breadcrumb.php'; ?>

<div class="container section-ptb">
    <h3><?= $breadcrumbTitle ?></h3>

    <?php if (!empty($products)): ?>
        <div class="row">
            <?php foreach ($products as $product): ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100">
                        <img src="/bw-clothes/<?= $product['image'] ?>" class="card-img-top" alt="<?= $product['name'] ?>">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?= $product['name'] ?></h5>
                            <p class="card-text text-danger"><?= number_format($product['price']) ?> đ</p>
                            <a href="/bw-clothes/product/<?= $product['id'] ?>" class="btn btn-outline-primary btn-sm">Chi tiết</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>Không tìm thấy sản phẩm nào phù hợp.</p>
    <?php endif; ?>
</div>

<?php include 'layouts/boyka/footer.php'; ?>
<?php include 'layouts/boyka/html_end.php'; ?>
