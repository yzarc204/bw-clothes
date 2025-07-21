<?php include 'views/layouts/boyka/html_start.php'; ?>
<?php include 'views/layouts/boyka/header.php'; ?>
<?php
$breadcrumbTitle = 'shop';
include 'views/layouts/boyka/breadcrumb.php';
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
            <?php foreach ($products as $product): ?>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="single-product-wrap">
                        <div class="product-image">
                            <a href="#">
                                <img src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
                            </a>
                        </div>
                        <div class="product-content">
                            <h3><?= $product['name'] ?></h3>
                            <div class="price-box">
                                <span><?= number_format($product['price']) ?>₫</span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <!-- <div class="paginatoin-area">
    <div class="row">
        <div class="col-lg-6 col-md-6">
            <p>Showing <?= ($page - 1) * $limit + 1 ?> - <?= min($page * $limit, $totalProducts) ?> of <?= $totalProducts ?> item(s)</p>
        </div>
        <div class="col-lg-6 col-md-6">
            <ul class="pagination-box justify-content-end">
                <?php if ($page > 1): ?>
                    <li>
                        <a href="?url=shop&page=<?= $page - 1 ?>" class="Previous">
                            <i class="fa fa-chevron-left"></i> Previous
                        </a>
                    </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="<?= ($i == $page) ? 'active' : '' ?>">
                        <a href="?url=shop&page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($page < $totalPages): ?>
                    <li>
                        <a href="?url=shop&page=<?= $page + 1 ?>" class="Next">
                            Next <i class="fa fa-chevron-right"></i>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div> -->
    </div>
</div>
    </div>
    
</div>

</div> <!-- end row -->






<?php include 'views/layouts/boyka/footer.php'; ?>
<?php include 'views/layouts/boyka/html_end.php'; ?>
