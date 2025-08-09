<?php $pageTitle = 'Sản phẩm mới nhất | BW-CLOZ'; ?>
<?php include 'views/layouts/boyka/html_start.php'; ?>
<?php include 'views/layouts/boyka/header.php'; ?>

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
        <!-- single-product-wrap end -->
      </div>
    <?php endforeach; ?>
  </div>
</div>
</div>
<?php require './views/layouts/boyka/pagination.php'; ?>
</div>
</div>


<?php include 'views/layouts/boyka/footer.php'; ?>
<?php include 'views/layouts/boyka/html_end.php'; ?>