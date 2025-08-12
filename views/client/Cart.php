<?php $pageTitle = 'Giỏ hàng | BW-CLOZ'; ?>
<?php require './views/layouts/boyka/html_start.php'; ?>
<?php require './views/layouts/boyka/header.php'; ?>

<div class="content-wraper">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <?php if ($userCart['total_variants'] == 0): ?>
          <div class="card p-5 my-5 text-center">
            <h2 class="mb-3">Giỏ hàng của bạn hiện đang trống</h2>
            <p class="mb-3">Hãy thêm sản phẩm vào giỏ hàng để tiếp tục mua sắm.</p>
            <p class="mb-3"><i class="fa fa-cart-arrow-down" style="font-size: 10rem;"></i></p>
            <a href="/" class="btn">Tiếp tục mua sắm</a>
          </div>
        <?php else: ?>
          <form action="/cart/update" method="POST" class="cart-table">
            <div class="table-content table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th class="plantmore-product-thumbnail">Hình ảnh</th>
                    <th class="cart-product-name">Tên</th>
                    <th class="plantmore-product-price">Giá</th>
                    <th class="plantmore-product-quantity">Số lượng</th>
                    <th class="plantmore-product-subtotal">Thành tiền</th>
                    <th class="plantmore-product-remove">Xoá</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($userCart['carts'] as $item): ?>
                    <tr>
                      <td class="plantmore-product-thumbnail">
                        <a href="/product/<?= $item['product_id'] ?>">
                          <img src="<?= $item['featured_image'] ?>" alt="<?= $item['product_name'] ?>"
                            style="height: 75px;">
                        </a>
                      </td>
                      <td class="plantmore-product-name">
                        <a href="/product/<?= $item['product_id'] ?>">
                          <?= $item['product_name'] ?> (<?= $item['color'] ?> - <?= $item['size'] ?>)
                        </a>
                      </td>
                      <td class="plantmore-product-price">
                        <?php if ($item['sale_price']): ?>
                          <span class="amount text-decoration-line-through"><?= currencyFormat($item['price']) ?>đ</span>
                          <span>|</span>
                          <span class="amount"><?= currencyFormat($item['sale_price']) ?>đ</span>
                        <?php else: ?>
                          <span class="amount"><?= currencyFormat($item['price']) ?>đ</span>
                        <?php endif; ?>
                      </td>
                      <td class="plantmore-product-quantity">
                        <input value="<?= $item['quantity'] ?>" type="number" name="quantity[<?= $item['id'] ?>]" min="1">
                      </td>
                      <td class="product-subtotal">
                        <span class="amount"><?= currencyFormat($item['sub_total_amount']) ?>đ</span>
                      </td>
                      <td class="plantmore-product-remove">
                        <a href="/cart/remove/<?= $item['id'] ?>"
                          onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?');"><i
                            class="fa fa-close"></i></a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
            <div class="row">
              <div class="col-md-8">
                <div class="coupon-all">
                  <div class="coupon2">
                    <button type="submit" class="btn continue-btn">Cập nhật giỏ hàng</button>
                    <a href="/" class="btn continue-btn">Tiếp tục mua sắm</a>
                  </div>
                </div>
              </div>
              <div class="col-md-4 ml-auto">
                <div class="cart-page-total">
                  <h2>Giá trị giỏ hàng</h2>
                  <ul>
                    <li>Tạm tính <span><?= currencyFormat($userCart['total_amount']) ?>đ</span></li>
                  </ul>
                  <a href="checkout" class="proceed-checkout-btn mb-3">Tiến hành thanh toán</a>
                </div>
              </div>
            </div>
          </form>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<?php require 'views/layouts/boyka/footer.php'; ?>
<?php require 'views/layouts/boyka/html_end.php'; ?>