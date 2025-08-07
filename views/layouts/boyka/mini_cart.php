<div class="dropdown-menu mini-cart-wrap">
  <div class="shopping-cart-content">
    <ul class="mini-cart-content">
      <?php if ($userCart['total_variants'] == 0): ?>
        <li class="text-center">Giỏ hàng trống</li>
      <?php else: ?>
        <?php foreach ($userCart['carts'] as $item): ?>
          <!-- Mini-Cart-item start -->
          <li class="mini-cart-item">
            <div class="mini-cart-product-img">
              <a href="/product/<?= $item['product_id'] ?>">
                <img src="<?= BASE_URL . '/' . $item['featured_image'] ?>" alt="<?= $item['product_name'] ?>" />
              </a>
              <span class="product-quantity"><?= $item['quantity'] ?>x</span>
            </div>
            <div class="mini-cart-product-desc">
              <h3><a href="/product/<?= $item['product_id'] ?>"><?= $item['product_name'] ?></a></h3>
              <div class="price-box">
                <span class="new-price"><?= currencyFormat($item['sale_price'] ?? $item['price']) ?>đ</span>
              </div>
              <div class="size">Màu: <?= $item['color'] ?> | Size: <?= $item['size'] ?></div>
            </div>
            <div class="remove-from-cart">
              <a href="/cart/remove/<?= $item['id'] ?>" title="Xoá"
                onclick="return confirm('Bạn có chắc chắn muốn xoá sản phẩm này khỏi giỏ hàng?')">
                <i class="fa fa-trash"></i>
              </a>
            </div>
          </li>
          <!-- Mini-Cart-item end -->
        <?php endforeach; ?>
        <li>
          <!-- shopping-cart-total start -->
          <div class="shopping-cart-total">
            <h4>Tạm tính : <span><?= currencyFormat($userCart['total_amount']) ?>đ</span></h4>
          </div>
          <!-- shopping-cart-total end -->
        </li>

        <li>
          <!-- shopping-cart-btn start -->
          <div class="shopping-cart-btn">
            <a href="checkout.html">Thanh toán</a>
          </div>
          <!-- shopping-cart-btn end -->
        </li>
      <?php endif; ?>
    </ul>
  </div>
</div>