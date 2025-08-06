<?php
require './views/layouts/adminlte/html_start.php';
require './views/layouts/adminlte/header.php';
?>

<div class="row g-4 py-5">
  <?php require './views/layouts/adminlte/message.php'; ?>

  <div class="col-12">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h3 class="card-title fw-bold">Quản lí danh mục</h3>
      </div>
      <div class="card-body">
        <a class="btn btn-primary btn-sm mb-3" href="/admin/category/create">Thêm danh mục</a>

        <table class="table table-hover table-bordered">
          <thead>
            <tr>
              <th>ID</th>
              <th>Tên danh mục</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($categories['items'] as $category): ?>
              <tr class="align-middle">
                <td><?= $category['id'] ?></td>
                <td><?= $category['name'] ?></td>
                <td>
                  <a href="/admin/category/<?= $category['id'] ?>/edit" class="btn btn-primary btn-sm">Sửa</a>
                  <a href="/admin/category/<?= $category['id'] ?>/delete" class="btn btn-danger btn-sm"
                    onclick="return confirm('Bạn có chắc chắn muốn xoá danh mục này?');">Xoá</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <div class="card-footer">
        <?php adminltePagination($categories); ?>
      </div>
    </div>
  </div>
</div>

<?php
require './views/layouts/adminlte/footer.php';
require './views/layouts/adminlte/html_end.php';
?>