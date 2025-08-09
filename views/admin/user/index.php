<?php
require './views/layouts/adminlte/html_start.php';
require './views/layouts/adminlte/header.php';
?>

<div class="row g-4 py-5">
  <?php require './views/layouts/adminlte/message.php'; ?>

  <div class="col-12">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h3 class="card-title fw-bold">Quản lí người dùng</h3>
      </div>
      <div class="card-body">
        <form action="/admin/user" method="get">
          <div class="input-group mb-3">
            <input type="text" class="form-control" name="search"
              placeholder="Tìm kiếm người dùng bằng username hoặc tên" value="<?= $search ?? '' ?>">
            <button class="btn btn-primary" type="submit">Tìm kiếm</button>
          </div>
        </form>
        <table class="table table-hover table-bordered">
          <thead>
            <tr>
              <th>ID</th>
              <th>Tài khoản</th>
              <th>Tên</th>
              <th>Quyền</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($users['items'] as $user): ?>
              <tr class="align-middle">
                <td><?= $user['id'] ?></td>
                <td><?= $user['username'] ?></td>
                <td><?= $user['name'] ?></td>
                <td>
                  <?php if ($user['is_admin']): ?>
                    <span class="badge bg-primary">Quản trị viên</span>
                  <?php else: ?>
                    <span class="badge bg-secondary">Người dùng</span>
                  <?php endif; ?>
                </td>
                <td>
                  <a href="/admin/user/<?= $user['id'] ?>/edit" class="btn btn-primary btn-sm">Sửa</a>
                  <a href="/admin/user/<?= $user['id'] ?>/delete" class="btn btn-danger btn-sm"
                    onclick="return confirm('Bạn có chắc chắn muốn xoá người dùng này?');">Xoá</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <div class="card-footer">
        <?php adminltePagination($users); ?>
      </div>
    </div>
  </div>
</div>

<?php
require './views/layouts/adminlte/footer.php';
require './views/layouts/adminlte/html_end.php';
?>