<?php ?>
<?php include 'layouts/boyka/html_start.php'; ?>
<?php include 'layouts/boyka/header.php'; ?>

<?php
$breadcrumbTitle = 'Chi tiết sản phẩm';
include 'views/layouts/boyka/breadcrumb.php';
?>

<style>
/* Chỉnh sửa để 3 ảnh nhỏ chiếm đều chiều ngang của ảnh lớn */
.product-dec-slider {
  /* display: flex;
  justify-content: space-between; hoặc flex-start */
  gap: 10px; /* Khoảng cách giữa các ảnh nhỏ */
  margin-top: 15px;
  margin-left: -50px;
  padding: 0;
  width: 450px; /* Bằng chiều rộng của ảnh lớn */
  overflow: hidden;
  flex-wrap: nowrap;
  box-sizing: border-box;
  float: left;
}

.product-dec-small {
  flex: 1 1 calc(33.333% - 6.66px); /* 3 ảnh nhỏ đều nhau, trừ khoảng cách */
  cursor: pointer;
  box-sizing: border-box;
  /* border-radius: 6px; */
  overflow: hidden;
  border: 2px solid transparent;
  transition: border-color 0.3s ease;
}

.product-dec-small img {
  width: 100%;
  height: 100px;
  /* object-fit: cover;
  display: block; */
  /* border-radius: 6px; */
}

</style>

<div class="product-details-area section-ptb">
    <div class="container">
        <div class="row">
            <!-- Hình ảnh -->
            <div class="col-lg-6 col-md-6">
                <div class="product-details-images">
                    <div class="pro-dec-big-img-slider easyzoom easyzoom--overlay">
                        <?php foreach ($images as $img): ?>
                            <div class="easyzoom-style">
                                <a href="/bw-clothes/<?php echo $img['image_url']; ?>">
                                    <img src="/bw-clothes/<?php echo $img['image_url']; ?>" alt="">
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Thumbnail ảnh nhỏ -->
                    <div class="product-dec-slider">
                        <?php foreach ($images as $img): ?>
                            <div class="product-dec-small">
                                <img src="/bw-clothes/<?php echo $img['image_url']; ?>" alt="">
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Thông tin sản phẩm -->
            <div class="col-lg-6 col-md-6">
                <div class="product-details-content">
                    <h2><?php echo $product['name']; ?></h2>

                    <?php
                        $price = (float)($product['price'] ?? 0);
                        $sale = (float)($product['sale_price'] ?? 0);
                        $discount = ($sale < $price && $sale > 0) ? round((($price - $sale) / $price) * 100) : 0;
                    ?>
                    <div class="product-price">
                        <?php if ($sale > 0 && $sale < $price): ?>
                            <span class="new"><?php echo number_format($sale, 0, ',', '.'); ?>đ</span>
                            <span class="old"><?php echo number_format($price, 0, ',', '.'); ?>đ</span>
                            <span class="discount">(-<?php echo $discount; ?>%)</span>
                        <?php else: ?>
                            <span class="new"><?php echo number_format($price, 0, ',', '.'); ?>đ</span>
                        <?php endif; ?>
                    </div>

                    <p><?php echo $product['description']; ?></p>

                    <form action="/bw-clothes/cart/add" method="POST">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">

                        <div class="product-variants">
                            <div class="produt-variants-size mb-3">
                                <label>Size</label>
                                <select name="size_id" class="form-control-select" required>
                                    <?php foreach ($sizes as $size): ?>
                                        <option value="<?= $size['id']; ?>"><?= $size['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="produt-variants-color mb-3">
                                <label>Color</label>
                                <ul class="color-list">
                                    <?php foreach ($colors as $index => $color): ?>
                                        <label class="color-radio">
                                            <input type="radio" name="color_id" value="<?= $color['id']; ?>" <?= $index === 0 ? 'checked' : ''; ?>>
                                            <span class="color-swatch <?= strtolower($color['name']); ?>"></span>
                                            <?= htmlspecialchars($color['name']); ?>
                                        </label>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>

<div class="form-group">
    <label for="quantity">Số lượng:</label>
    <div class="input-group" style="width: 130px;">
        <div class="input-group-prepend">
            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="changeQuantity(-1)">-</button>
        </div>
        <input type="text" id="quantity" name="quantity" value="1" min="1" class="form-control text-center" required>
        <div class="input-group-append">
            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="changeQuantity(1)">+</button>
        </div>
    </div>
</div>

                        <a href="/bw-clothes/cart/add/<?= $product['id'] ?>">Thêm vào giỏ</a>

                    </form>
                </div>
            </div>
        </div>

        <!-- Sản phẩm liên quan -->
        <div class="row mt-5">
            <div class="col-12">
                <h4>Sản phẩm liên quan</h4>
                <div class="row">
                    <?php foreach ($relatedProducts as $rp): ?>
                        <div class="col-md-3 col-sm-6">
                            <div class="single-product-wrap">
                                <div class="product-image">
                                    <a href="/bw-clothes/product/<?php echo $rp['id']; ?>">
                                        <img src="/bw-clothes/<?php echo $rp['image']; ?>" alt="">
                                    </a>
                                </div>
                                <div class="product-content">
                                    <h3>
                                        <a href="/bw-clothes/product/<?php echo $rp['id']; ?>">
                                            <?php echo $rp['name']; ?>
                                        </a>
                                    </h3>
                                    <div class="price">
                                        <?php echo number_format($rp['price']); ?>đ
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'layouts/boyka/footer.php'; ?>
<?php include 'layouts/boyka/html_end.php'; ?>
