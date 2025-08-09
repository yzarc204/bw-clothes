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

        <form action="/admin/product" method="get">
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Tìm kiếm sản phẩm" name="search"
              value="<?= $search ?>">
            <button class="btn btn-primary" type="submit">Tìm kiếm</button>
          </div>
        </form>

        <table class="table table-hover table-bordered">
          <thead>
            <tr>
              <th>ID</th>
              <th>Ảnh</th>
              <th>Tên</th>
              <th>Giá</th>
              <th>Danh mục</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($products['items'] as $product): ?>
              <tr class="align-middle">
                <td><?= $product['id'] ?></td>
                <td><img src="<?= BASE_URL . '/' . $product['featured_image'] ?>" height="100" /></td>
                <td><?= $product['name'] ?></td>
                <td>
                  <span><?= currencyFormat($product['min_price'] ?? 0) ?>đ</span>
                  <span>-</span>
                  <span><?= currencyFormat($product['max_price'] ?? 0) ?>đ</span>
                </td>
                <td><?= $product['category_name'] ?></td>
                <td>
                  <a href="/admin/product/<?= $product['id'] ?>" class="btn btn-secondary btn-sm">Chi
                    tiết</a>
                  <a href="/admin/product/<?= $product['id'] ?>/edit" class="btn btn-primary btn-sm">Sửa</a>
                  <a href="/admin/product/<?= $product['id'] ?>/variant" class="btn btn-success btn-sm">Biến
                    thể</a>
                  <a href="/admin/product/<?= $product['id'] ?>/delete" class="btn btn-danger btn-sm"
                    onclick="return confirm('Bạn có chắc chắn muốn xoá sản phẩm này?');">Xoá</a>
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

<?php
require './views/layouts/adminlte/footer.php';
require './views/layouts/adminlte/html_end.php';
?>