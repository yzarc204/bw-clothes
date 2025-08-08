<?php
require './views/layouts/adminlte/html_start.php';
require './views/layouts/adminlte/header.php';
?>

<div class="row g-4 py-5">
  <?php require './views/layouts/adminlte/message.php'; ?>

  <div class="col-12">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h3 class="card-title fw-bold">Quản lí đơn hàng</h3>
      </div>
      <div class="card-body">
        <a class="btn btn-primary btn-sm mb-3" href="/admin/order/create">Thêm đơn hàng</a>
        <table class="table table-hover table-bordered">
          <thead>
            <tr>
              <th>ID</th>
              <th>Ngày đặt hàng</th>
              <th>Khách hàng</th>
              <th>Số lượng</th>
              <th>Tổng tiền</th>
              <th>Trạng thái</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($orders['items'] as $order): ?>
              <tr class="align-middle">
                <td><?= $order['id'] ?></td>
                <td><?= datetimeFormat($order['order_time']) ?></td>
                <td>
                  <small>Tài khoản: <?= $order['username'] ?></small> <br>
                  <small>Tên khách hàng: <?= $order['customer_name'] ?></small> <br>
                  <small>Số điện thoại: <?= $order['phone_number'] ?></small> <br>
                  <small>Địa chỉ: <?= $order['address'] ?></small>
                </td>
                <td><?= $order['total_items'] ?></td>
                <td><?= currencyFormat($order['total_amount']) ?>đ</td>
                <td>
                  <span
                    class="badge text-bg-<?= OrderStatusEnum::getColor($order['status']) ?>"><?= OrderStatusEnum::getValue($order['status']) ?></span>
                </td>
                <td>
                  <a href="/admin/order/<?= $order['id'] ?>" class="btn btn-primary btn-sm">Chi
                    tiết</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <div class="card-footer">
        <?php adminltePagination($orders); ?>
      </div>
    </div>
  </div>
</div>

<?php
require './views/layouts/adminlte/footer.php';
require './views/layouts/adminlte/html_end.php';
?>