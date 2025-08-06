<?php require './views/layouts/adminlte/html_start.php'; ?>

<style>
  .image-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 300px;
  }

  .product-image {
    max-height: 200px;
    object-fit: cover;
  }

  .thumbnail {
    width: 80px;
    height: 80px;
    object-fit: cover;
    cursor: pointer;
    opacity: 0.6;
    transition: opacity 0.3s ease;
  }

  .thumbnail:hover,
  .thumbnail.active {
    opacity: 1;
  }
</style>

<?php require './views/layouts/adminlte/header.php'; ?>

<!-- Xây dựng trang chi tiết sản phẩm -->
<div class="row p-4">
  <div class="card card-solid">
    <div class="card-body">
      <div class="row">
        <div class="col-md-5 mb-4 text-center">
          <div class="image-wrapper">
            <img src="<?= BASE_URL . '/' . $product['featured_image'] ?>" alt="Product"
              class="img-fluid rounded mb-5 product-image" id="mainImage">
          </div>
          <div class="d-flex gap-4 flex-wrap justify-content-center">
            <img src="<?= BASE_URL . '/' . $product['featured_image'] ?>" alt="Thumbnail 1"
              class="thumbnail rounded active" onclick="changeImage(event, this.src)">
            <?php foreach ($images as $image): ?>
              <img src="<?= BASE_URL . '/' . $image['image_url'] ?>" alt="Thumbnail" class="thumbnail rounded"
                onclick="changeImage(event, this.src)">
            <?php endforeach; ?>
          </div>
        </div>
        <div class="col-md-7">
          <h2 class="mb-3"><?= $product['name'] ?></h2>
          <p class="text-muted mb-4">Danh mục: <?= $product['category_name'] ?></p>
          <div class="mb-3">
            <span class="h4 me-2" id="sale_price"></span>
            <span class="text-muted text-decoration-line-through" id="price"><s></s></span>
          </div>
          <div class="mt-4">
            <h5>Mô tả:</h5>
            <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>
          </div>
          <div class="mb-4">
            <h5>Biến thể:</h5>
            <div class="d-flex gap-2 flex-wrap">
              <?php foreach ($variants as $variant): ?>
                <input type="radio" class="btn-check" name="variant" id="variant_<?= $variant['id'] ?>"
                  data-price="<?= $variant['price'] ?>" data-sale-price="<?= $variant['sale_price'] ?>"
                  autocomplete="off">
                <label class="btn btn-outline-dark" for="variant_<?= $variant['id'] ?>"><?= $variant['color'] ?> -
                  <?= $variant['size'] ?></label>
              <?php endforeach; ?>
            </div>
          </div>
          <div class="btn-group">
            <a href="/admin/product/<?= $product['id'] ?>/edit" class="btn btn-primary">Sửa</a>
            <a href="/admin/product/<?= $product['id'] ?>/variant" class="btn btn-success">Biến thể</a>
            <a href="/admin/product/<?= $product['id'] ?>/delete"
              onclick="return confirm('Bạn có chắc chắn muốn xoá sản phẩm này?');" class="btn btn-danger">Xoá</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require './views/layouts/adminlte/footer.php'; ?>

<script>
  function changeImage(event, src) {
    document.getElementById('mainImage').src = src;
    document.querySelectorAll('.thumbnail').forEach(thumb => thumb.classList.remove('active'));
    event.target.classList.add('active');
  }

  function formatCurrency(value) {
    return new Intl.NumberFormat('vi-VN', {
      style: 'currency',
      currency: 'VND'
    }).format(value);
  }

  document.querySelectorAll('input[name="variant"]').forEach(input => {
    input.addEventListener('change', function () {
      // Giả sử mỗi variant có giá riêng, bạn cần lấy giá từ dữ liệu variant
      const price = this.dataset.price; // Ví dụ: data-price="349.99"
      const salePrice = this.dataset.salePrice; // Ví dụ: data-sale-price="299.99"

      if (salePrice) {
        document.getElementById('price').textContent = formatCurrency(price);
        document.getElementById('sale_price').textContent = formatCurrency(salePrice);
      } else {
        document.getElementById('price').textContent = '';
        document.getElementById('sale_price').textContent = formatCurrency(price);
      }
    });
  });

  // Tự động check vào variant đầu tiên
  document.querySelector('input[name="variant"]').checked = true;
  document.querySelector('input[name="variant"]').dispatchEvent(new Event('change'));
</script>

<?php require './views/layouts/adminlte/html_end.php'; ?>