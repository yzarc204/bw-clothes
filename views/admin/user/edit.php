<?php require './views/layouts/adminlte/html_start.php'; ?>
<?php require './views/layouts/adminlte/header.php'; ?>

<div class="row g-4 py-5">
  <div class="col-12">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h3 class="card-title fw-bold">Sửa người dùng</h3>
      </div>
      <div class="card-body">
        <form action="/admin/user/<?= $user['id'] ?>/edit" method="POST" enctype="multipart/form-data">
          <div class="row gx-4 gy-3">
            <?php require './views/layouts/adminlte/message.php'; ?>

            <div class="col-md-6 col-12">
              <label for="username" class="form-label">Tài khoản</label>
              <input type="text" class="form-control" id="username" name="username"
                value="<?= $_SESSION['old']['username'] ?? $user['username'] ?? '' ?>" />
            </div>

            <div class="col-md-6 col-12">
              <label for="name" class="form-label">Tên</label>
              <input type="text" class="form-control" id="name" name="name"
                value="<?= $_SESSION['old']['name'] ?? $user['name'] ?? '' ?>" />
            </div>

            <div class="col-md-6 col-12">
              <label for="is_admin" class="form-label">Quyền</label>
              <select class="form-control" id="is_admin" name="is_admin">
                <option value="0" <?= ($_SESSION['old']['is_admin'] ?? $user['is_admin']) == 0 ? 'selected' : '' ?>>Người
                  dùng</option>
                <option value="1" <?= ($_SESSION['old']['is_admin'] ?? $user['is_admin']) == 1 ? 'selected' : '' ?>>Quản
                  trị viên</option>
              </select>
            </div>

            <div class="col-12">
              <button type="submit" class="btn btn-primary w-100">Cập nhật sản phẩm</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php require './views/layouts/adminlte/footer.php'; ?>
<?php require './views/layouts/adminlte/html_end.php'; ?>
<?php unset($_SESSION['old']); ?>