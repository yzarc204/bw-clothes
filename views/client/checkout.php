<?php require './views/layouts/boyka/html_start.php'; ?>
<?php require './views/layouts/boyka/header.php'; ?>

<div class="content-wraper">
  <div class="container">
    <!-- checkout-details-wrapper start -->
    <div class="checkout-details-wrapper">
      <div class="row">
        <div class="col-lg-6 col-md-6">
          <!-- billing-details-wrap start -->
          <div class="billing-details-wrap">
            <form action="/checkout" method="POST">
              <h3 class="shoping-checkboxt-title">Chi tiết đơn hàng</h3>
              <div class="row">
                <div class="col-lg-12">
                  <p class="single-form-row">
                    <label>Tên khách hàng</label>
                    <input type="text" placeholder="Nhập tên khách hàng" name="customer_name">
                  </p>
                </div>
                <div class="col-lg-12">
                  <p class="single-form-row">
                    <label>Số điện thoại</label>
                    <input type="text" placeholder="Nhập số điện thoại" name="phone_number">
                  </p>
                </div>
                <div class="col-lg-12">
                  <p class="single-form-row">
                    <label>Địa chỉ</label>
                    <input type="text" placeholder="Nhập địa chỉ giao hàng" name="address">
                  </p>
                </div>
                <div class="col-12">
                  <button type="submit" class="btn w-100 py-2">ĐẶT HÀNG</button>
                </div>
              </div>
            </form>
          </div>
          <!-- billing-details-wrap end -->
        </div>
        <div class="col-lg-6 col-md-6">
          <!-- your-order-wrapper start -->
          <div class="your-order-wrapper">
            <h3 class="shoping-checkboxt-title">Đơn hàng của bạn</h3>
            <!-- your-order-wrap start-->
            <div class="your-order-wrap">
              <!-- your-order-table start -->
              <div class="your-order-table table-responsive">
                <table>
                  <thead>
                    <tr>
                      <th class="product-name">Sản phẩm</th>
                      <th class="product-total">Thành tiền</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($userCart['carts'] as $item): ?>
                      <tr class="cart_item">
                        <td class="product-name">
                          <?= $item['product_name'] ?> (<?= $item['color'] ?> - <?= $item['size'] ?>)
                          <strong class="product-quantity"> × <?= $item['quantity'] ?></strong>
                        </td>
                        <td class="product-total">
                          <span class="amount"><?= currencyFormat($item['sub_total_amount']) ?>đ</span>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                    <tr class="sub-total">
                      <td>GIÁ TRỊ ĐƠN HÀNG</td>
                      <td><?= currencyFormat($userCart['total_amount']) ?>đ</td>
                    </tr>
                    <tr class="vat">
                      <td>VAT (<?= VAT_PERCENTAGE ?>%)</td>
                      <td><?= currencyFormat($vatAmount) ?>đ</td>
                    </tr>
                    <tr class="shipping">
                      <td>PHÍ VẬN CHUYỂN</td>
                      <td><?= currencyFormat($shippingFee) ?>đ</td>
                    </tr>
                    <tr class="order-total">
                      <th>TỔNG CỘNG</th>
                      <td><strong><span class="amount"><?= currencyFormat($totalAmount) ?>đ</span></strong>
                      </td>
                    </tr>
                    </tfoot>
                </table>
              </div>
              <!-- your-order-table end -->
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- checkout-details-wrapper end -->
  </div>
</div>

<?php require 'views/layouts/boyka/footer.php'; ?>

<?php if (isset($_SESSION['error'])): ?>
  <script>
    alert("<?= $_SESSION['error'] ?>");
  </script>
  <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<?php require 'views/layouts/boyka/html_end.php'; ?>