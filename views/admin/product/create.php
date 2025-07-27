<?php
require './views/layouts/adminlte/html_start.php';
require './views/layouts/adminlte/header.php';
?>

<div class="row g-4 py-5">
  <div class="col-12">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h3 class="card-title fw-bold">Thêm sản phẩm</h3>
      </div>
      <div class="card-body">
        <form action="/admin/category/create" method="POST" enctype="multipart/form-data">
          <div class="row gx-4 gy-3">
            <?php require './views/layouts/adminlte/message.php'; ?>

            <div class="col-12">
              <label for="name" class="form-label">Tên danh mục</label>
              <input type="text" class="form-control" id="name" name="name"
                value="<?= $_SESSION['old']['name'] ?? '' ?>" />
            </div>
            <div class="col-12">
              <button type="submit" class="btn btn-primary w-100">Thêm danh mục</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</div>

<?php
require './views/layouts/adminlte/footer.php';
require './views/layouts/adminlte/html_end.php';
?>