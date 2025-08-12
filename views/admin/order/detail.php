<?php
require './views/layouts/adminlte/html_start.php';
require './views/layouts/adminlte/header.php';
?>

<div class="row g-4 py-5">
  <?php require './views/layouts/adminlte/message.php'; ?>

  <div class="col-12">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h3 class="card-title fw-bold">Chi tiết đơn hàng #<?= $order['id'] ?></h3>
      </div>
      <div class="card-body">
        <div class="row gx-5">
          <div class="col-md-6">
            <h4>Thông tin đơn hàng</h4>
            <form action="/admin/order/<?= $order['id'] ?>/status" method="POST">
              <div class="input-group mb-3 w-50">
                <span class="input-group-text">Trạng thái</span>
                <select class="form-select" name="status">
                  <?php foreach (OrderStatusEnum::all() as $key => $value): ?>
                    <option value="<?= $key ?>" <?= $order['status'] == $key ? 'selected' : '' ?>><?= $value ?></option>
                  <?php endforeach; ?>
                </select>
                <button class="btn btn-primary" type="submit"
                  onclick="return confirm('Bạn có chắc chắn muốn cập nhật trạng thái đơn hàng này?')">Cập nhật</button>
              </div>
            </form>
            <p>Ngày đặt hàng: <?= datetimeFormat($order['order_time']) ?></p>
            <p>Ngày giao hàng: <?= datetimeFormat($order['shipping_time']) ?></p>
            <p>Ngày nhận hàng: <?= datetimeFormat($order['delivered_time']) ?></p>
          </div>
          <div class="col-md-6">
            <h4>Thông tin khách hàng</h4>
            <p>Tài khoản: <?= $order['username'] ?></p>
            <p>Tên khách hàng: <?= $order['customer_name'] ?></p>
            <p>Số điện thoại: <?= $order['phone_number'] ?></p>
            <p>Địa chỉ: <?= $order['address'] ?></p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="card card-primary card-outline">
    <div class="card-body">
      <table class="table table-hover table-bordered">
        <thead>
          <tr>
            <th>Hình ảnh</th>
            <th>Tên sản phẩm</th>
            <th class="text-end">Giá</th>
            <th class="text-end">Số lượng</th>
            <th class="text-end">Thành tiền</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($detail as $item): ?>
            <tr class="align-middle">
              <td>
                <img src="<?= BASE_URL . '/' . $item['product_image'] ?>" alt="<?= $item['product_name'] ?>"
                  style="height: 75px;">
              </td>
              <td><?= $item['product_name'] ?> (<?= $item['color_name'] ?> - <?= $item['size_name'] ?>)</td>
              <td class="text-end"><?= currencyFormat($item['price']) ?>đ</td>
              <td class="text-end"><?= $item['quantity'] ?></td>
              <td class="text-end"><?= currencyFormat($item['total_amount']) ?>đ</td>
            </tr>
          <?php endforeach; ?>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="4" class="fw-bold">Tạm tính</td>
            <td class="text-end"><?= currencyFormat($order['subtotal']) ?>đ</td>
          </tr>
          <tr>
            <td colspan="4" class="fw-bold">VAT</td>
            <td class="text-end"><?= currencyFormat($order['vat_amount']) ?>đ</td>
          </tr>
          <tr>
            <td colspan="4" class="fw-bold">Phí ship</td>
            <td class="text-end"><?= currencyFormat($order['shipping_fee']) ?>đ</td>
          </tr>
          <tr>
            <td colspan="4" class="fw-bold">Tổng tiền</td>
            <td class="text-bg-primary text-end"><?= currencyFormat($order['total_amount']) ?>đ</td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>

<?php
require './views/layouts/adminlte/footer.php';
require './views/layouts/adminlte/html_end.php';
?>