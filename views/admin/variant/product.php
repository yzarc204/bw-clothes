<?php
require './views/layouts/adminlte/html_start.php';
require './views/layouts/adminlte/header.php';
?>

<div class="row g-4 py-5">
  <?php require './views/layouts/adminlte/message.php'; ?>

  <div class="col-12">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h3 class="card-title fw-bold">Danh sách biến thể</h3>
      </div>
      <div class="card-body">
        <form action="/admin/variant/bulk/create" method="POST" class="mb-3">
          <input type="hidden" name="product_id" value="<?= $productId ?>">
          <h5 class="mb-2">Thêm nhiều biến thể</h5>
          <div class="d-flex gap-3 mb-2 flex-wrap">
            <?php foreach ($colors as $color): ?>
              <label class="form-check-label me-3">
                <input type="checkbox" class="form-check-input me-1" name="colors[]" value="<?= $color['id'] ?>">
                <?= $color['name'] ?>
              </label>
            <?php endforeach; ?>
          </div>
          <div class="d-flex gap-2 flex-wrap mb-2">
            <?php foreach ($sizes as $size): ?>
              <label class="form-check-label me-3">
                <input type="checkbox" class="form-check-input me-1" name="sizes[]" value="<?= $size['id'] ?>">
                <?= $size['name'] ?>
              </label>
            <?php endforeach; ?>
          </div>
          <button class="btn btn-primary btn-sm">Thêm</button>
        </form>

        <hr class="mb-3">

        <form action="/admin/variant/create" method="POST">
          <div class="row mb-3 g-2">
            <input type="hidden" name="product_id" value="<?= $productId ?>">
            <div class="col-lg-2 col-md-6">
              <select class="form-select" name="color_id" id="">
                <option value="" disabled selected>Chọn màu sắc</option>
                <?php foreach ($colors as $color): ?>
                  <option value="<?= $color['id'] ?>"><?= $color['name'] ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-lg-2 col-md-6">
              <select class="form-select" name="size_id" id="">
                <option value="" disabled selected>Chọn size</option>
                <?php foreach ($sizes as $size): ?>
                  <option value="<?= $size['id'] ?>"><?= $size['name'] ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-lg-3 col-md-6">
              <input type="text" class="form-control" placeholder="Giá" name="price">
            </div>
            <div class="col-lg-3 col-md-6">
              <input type="text" class="form-control" placeholder="Giá khuyến mãi" name="sale_price">
            </div>
            <div class="col-lg-2 col-md-12 col-12">
              <button class="btn btn-success w-100" type="submit">Thêm</button>
            </div>
          </div>
        </form>

        <hr class="mb-3">

        <?php foreach ($variants as $variant): ?>
          <form action="/admin/variant/<?= $variant['id'] ?>/edit" method="POST">
            <div class="row mb-3 gx-3 g-2">
              <input type="hidden" name="product_id" value="<?= $productId ?>">
              <div class="col-lg-2 col-md-6">
                <select class="form-select" name="color_id" id="">
                  <option value="" disabled selected>Chọn màu sắc</option>
                  <?php foreach ($colors as $color): ?>
                    <option value="<?= $color['id'] ?>" <?= $color['id'] === $variant['color_id'] ? 'selected' : '' ?>>
                      <?= $color['name'] ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-lg-2 col-md-6">
                <select class="form-select" name="size_id" id="">
                  <option value="" disabled selected>Chọn size</option>
                  <?php foreach ($sizes as $size): ?>
                    <option value="<?= $size['id'] ?>" <?= $size['id'] === $variant['size_id'] ? 'selected' : '' ?>>
                      <?= $size['name'] ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-lg-3 col-md-6">
                <input type="text" class="form-control" placeholder="Giá" name="price" value="<?= $variant['price'] ?>">
              </div>
              <div class="col-lg-3 col-md-6">
                <input type="text" class="form-control" placeholder="Giá khuyến mãi" name="sale_price"
                  value="<?= $variant['sale_price'] ?>">
              </div>
              <div class="col-lg-1 col-6">
                <button class="btn btn-primary w-100" type="submit">Sửa</button>
              </div>
              <div class="col-lg-1 col-6">
                <button class="btn btn-danger w-100" type="button"
                  onclick="return confirm('Bạn chắc chắn muốn xóa biến thể này?')">Xóa</button>
              </div>
            </div>
          </form>
          <hr class="mb-3">
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>

<?php
require './views/layouts/adminlte/footer.php';
require './views/layouts/adminlte/html_end.php';
?>

<?php unset($_SESSION['old']); ?>