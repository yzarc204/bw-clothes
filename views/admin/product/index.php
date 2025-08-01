<?php
require './views/layouts/adminlte/html_start.php';
require './views/layouts/adminlte/header.php';
?>

<div class="row g-4 py-5">
  <?php require './views/layouts/adminlte/message.php'; ?>

  <div class="col-12">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h3 class="card-title fw-bold">Quản lí sản phẩm</h3>
      </div>
      <div class="card-body">
        <a class="btn btn-primary btn-sm mb-3" href="/admin/product/create">Thêm sản phẩm</a>

        <table class="table table-hover table-bordered">
          <thead>
            <tr>
              <th>ID</th>
              <th>Ảnh</th>
              <th>Tên</th>
              <th>Danh mục</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($products['items'] as $product): ?>
              <tr class="align-middle">
                <td><?= $product['product_id'] ?></td>
                <td><img src="<?= $product['featured_image'] ?>" height="100" /></td>
                <td><?= $product['product_name'] ?></td>
                <td><?= $product['category_name'] ?></td>
                <td>
                  <a href="/admin/product/<?= $product['id'] ?>/edit" class="btn btn-primary btn-sm">Sửa</a>
                  <a href="/admin/product/<?= $product['id'] ?>/delete" class="btn btn-danger btn-sm"
                    onclick="return confirm('Bạn có chắc chắn muốn xoá danh mục này?');">Xoá</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <div class="card-footer">
        <?php adminltePagination($products); ?>
      </div>
    </div>
  </div>
</div>
</div>

<?php
require './views/layouts/adminlte/footer.php';
require './views/layouts/adminlte/html_end.php';
?>