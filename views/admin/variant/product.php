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
          <h5 class="mb-1">Thêm nhiều biến thể</h5>
          <table>
            <tr>
              <?php foreach ($colors as $color): ?>
                <td>
                  <label class="form-check-label me-3">
                    <input type="checkbox" class="form-check-input me-1" name="colors[]" value="<?= $color['id'] ?>">
                    <?= $color['name'] ?>
                  </label>
                </td>
              <?php endforeach; ?>
            </tr>
            <tr>
              <?php foreach ($sizes as $size): ?>
                <td>
                  <label class="form-check-label me-3">
                    <input type="checkbox" class="form-check-input me-1" name="sizes[]" value="<?= $size['id'] ?>">
                    <?= $size['name'] ?>
                  </label>
                </td>
              <?php endforeach; ?>
            </tr>
          </table>
          <button class="btn btn-primary btn-sm">Thêm</button>
        </form>

        <hr class="mb-3">

        <div class="form-group mb-3">
          <form action="/admin/variant/create" method="POST" class="d-flex align-items-center gap-3">
            <input type="hidden" name="product_id" value="<?= $productId ?>">
            <select class="form-select" name="color_id" id="">
              <option value="" disabled selected>Chọn màu sắc</option>
              <?php foreach ($colors as $color): ?>
                <option value="<?= $color['id'] ?>"><?= $color['name'] ?></option>
              <?php endforeach; ?>
            </select>
            <select class="form-select" name="size_id" id="">
              <option value="" disabled selected>Chọn size</option>
              <?php foreach ($sizes as $size): ?>
                <option value="<?= $size['id'] ?>"><?= $size['name'] ?></option>
              <?php endforeach; ?>
            </select>
            <input type="text" class="form-control" placeholder="Giá" name="price">
            <input type="text" class="form-control" placeholder="Giá khuyến mãi" name="sale_price">

            <button class="btn btn-success" type="submit">Thêm</button>
          </form>
        </div>
        <hr class="mb-3">
        <?php foreach ($variants as $variant): ?>
          <div class="form-group mb-3">
            <form action="/admin/variant/<?= $variant['id'] ?>/edit" method="POST"
              class="d-flex align-items-center gap-3">
              <input type="hidden" name="product_id" value="<?= $productId ?>">
              <select class="form-select" name="color_id" id="">
                <option value="" disabled selected>Chọn màu sắc</option>
                <?php foreach ($colors as $color): ?>
                  <option value="<?= $color['id'] ?>" <?= $color['id'] === $variant['color_id'] ? 'selected' : '' ?>>
                    <?= $color['name'] ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <select class="form-select" name="size_id" id="">
                <option value="" disabled selected>Chọn size</option>
                <?php foreach ($sizes as $size): ?>
                  <option value="<?= $size['id'] ?>" <?= $size['id'] === $variant['size_id'] ? 'selected' : '' ?>>
                    <?= $size['name'] ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <input type="text" class="form-control" placeholder="Giá" name="price" value="<?= $variant['price'] ?>">
              <input type="text" class="form-control" placeholder="Giá khuyến mãi" name="sale_price"
                value="<?= $variant['sale_price'] ?>">

              <button class="btn btn-primary" type="submit">Sửa</button>
              <a href="/admin/variant/<?= $variant['id'] ?>/delete"
                onclick="return confirm('Bạn chắc chắn muốn xóa biến thể này?')" class="btn btn-danger">Xóa</a>
            </form>
          </div>
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