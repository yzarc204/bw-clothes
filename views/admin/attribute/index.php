<?php
require './views/layouts/adminlte/html_start.php';
require './views/layouts/adminlte/header.php';
?>

<div class="row g-4 py-5">
  <?php require './views/layouts/adminlte/message.php'; ?>

  <div class="col-md-6 col-sm-12">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h3 class="card-title fw-bold">Danh sách màu sắc</h3>
      </div>
      <div class="card-body">
        <?php require './views/layouts/adminlte/message.php'; ?>

        <div class="form-group mb-3">
          <form action="/admin/color/create" method="POST" class="d-flex align-items-center gap-3">
            <input type="text" class="form-control" placeholder="Màu sắc" name="color">
            <button class="btn btn-success" type="submit">Thêm</button>
          </form>
        </div>
        <?php foreach ($colors as $color): ?>
          <div class="form-group mb-3">
            <form action="/admin/color/<?= $color['id'] ?>/edit" method="POST" class="d-flex align-items-center gap-3">
              <input type="text" class="form-control" placeholder="Màu sắc" name="color" value="<?= $color['name'] ?>">
              <button class="btn btn-primary" type="submit">Sửa</button>
              <a href="/admin/color/<?= $color['id'] ?>/delete"
                onclick="return confirm('Bạn chắc chắn muốn xóa màu sắc này?')" class="btn btn-danger">Xóa</a>
            </form>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
  <div class="col-md-6 col-sm-12">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h3 class="card-title fw-bold">Danh sách size</h3>
      </div>
      <div class="card-body">
        <div class="form-group mb-3">
          <form action="/admin/size/create" method="POST" class="d-flex align-items-center gap-3">
            <input type="text" class="form-control" placeholder="Size" name="size">
            <button class="btn btn-success" type="submit">Thêm</button>
          </form>
        </div>
        <?php foreach ($sizes as $size): ?>
          <div class="form-group mb-3">
            <form action="/admin/size/<?= $size['id'] ?>/edit" method="POST" class="d-flex align-items-center gap-3">
              <input type="text" class="form-control" placeholder="Size" name="size" value="<?= $size['name'] ?>">
              <button class="btn btn-primary" type="submit">Sửa</button>
              <a href="/admin/size/<?= $size['id'] ?>/delete" onclick="return confirm('Bạn chắc chắn muốn xóa size này?')"
                class="btn btn-danger">Xóa</a>
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