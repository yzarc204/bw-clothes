<?php require './views/layouts/boyka/html_start.php'; ?>
<?php require './views/layouts/boyka/header.php'; ?>

<div class="content-wraper">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="cart-table">
          <div class="table-content table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th class="plantmore-product-thumbnail">Hình ảnh</th>
                  <th class="cart-product-name">Tên</th>
                  <th class="plantmore-product-price">Giá</th>
                  <th class="plantmore-product-quantity">Số lượng</th>
                  <th class="plantmore-product-subtotal">Thành tiền</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($detail as $item): ?>
                  <tr>
                    <td class="plantmore-product-thumbnail">
                      <img src="<?= BASE_URL . '/' . $item['product_image'] ?>" alt="<?= $item['product_name'] ?>"
                        style="height: 75px;">
                    </td>
                    <td class="plantmore-product-name">
                      <?= $item['product_name'] ?> (<?= $item['color_name'] ?> - <?= $item['size_name'] ?>)
                    </td>
                    <td class="plantmore-product-price">
                      <span class="amount"><?= currencyFormat($item['price']) ?>đ</span>
                    </td>
                    <td class="plantmore-product-quantity"><?= $item['quantity'] ?></td>
                    <td class="product-subtotal">
                      <span class="amount"><?= currencyFormat($item['total_amount']) ?>đ</span>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          <div class="row">
            <div class="col-lg-4 col-md-6 col-12 mb-5">
              <div class="cart-page-total">
                <h2></h2>
                <ul>
                  <li>Trạng thái <span><?= ucfirst(OrderStatusEnum::getValue($order['status'])) ?></span></li>
                  <li>Ngày đặt hàng <span><?= datetimeFormat($order['order_time']) ?></span></li>
                  <li>Ngày giao hàng <span><?= datetimeFormat($order['shipping_time']) ?></span></li>
                  <li>Ngày nhận hàng <span><?= datetimeFormat($order['delivered_time']) ?></span></li>
                  <?php if (!in_array($order['status'], [OrderStatusEnum::CANCELED, OrderStatusEnum::DELIVERING, OrderStatusEnum::RECEIVED])): ?>
                    <li>
                      <a href="/order/<?= $order['id'] ?>/cancel" class="btn continue-btn"
                        onclick="return confirm('Bạn có chắc chắn muốn huỷ đơn hàng này?')">Huỷ đơn hàng?</a>
                    </li>
                  <?php endif; ?>
                </ul>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12 ms-auto mb-5">
              <div class="cart-page-total">
                <h2></h2>
                <ul>
                  <li>Giá trị đơn hàng <span><?= currencyFormat($order['subtotal']) ?>đ</span></li>
                  <li>VAT <span><?= currencyFormat($order['vat_amount']) ?>đ</span></li>
                  <li>Phí ship <span><?= currencyFormat($order['shipping_fee']) ?>đ</span></li>
                  <li>Thành tiền <span><?= currencyFormat($order['total_amount']) ?>đ</span></li>
                </ul>
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