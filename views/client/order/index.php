<?php $pageTitle = "Danh sách đơn hàng | BW-CLOZ"; ?>
<?php require './views/layouts/boyka/html_start.php'; ?>
<?php require './views/layouts/boyka/header.php'; ?>

<div class="content-wraper">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="account-dashboard mb-5">
          <div class="row">
            <div class="col-12">
              <div class="card card-solid">
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Mã đơn hàng</th>
                          <th>Ngày đặt</th>
                          <th>Trạng thái</th>
                          <th>Tổng</th>
                          <th>Hành động</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($orders['items'] as $order): ?>
                          <tr>
                            <td>#<?= $order['id'] ?></td>
                            <td><?= $order['order_time'] ?></td>
                            <td><?= OrderStatusEnum::getValue($order['status']) ?></td>
                            <td><?= currencyFormat($order['total_amount']) ?>đ / <?= $order['total_items'] ?> sản phẩm
                            </td>
                            <td><a href="/order/<?= $order['id'] ?>" class="view">Xem chi tiết</a></td>
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                  <?php boykaPagination($orders); ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require './views/layouts/boyka/footer.php'; ?>
<?php require './views/layouts/boyka/html_end.php'; ?>