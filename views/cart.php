<?php include 'layouts/boyka/html_start.php'; ?>
<?php include 'layouts/boyka/header.php'; ?>
<?php
$breadcrumbTitle = 'Giỏ hàng';
include 'views/layouts/boyka/breadcrumb.php';
?>
<style>
.quantity-group {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 120px;
    height: 45px;
    border: 1px solid #ccc;
    border-radius: 5px;
    overflow: hidden;
    background-color: #fff;
}

.qty-btn {
    width: 40px;
    height: 45px;
    border: none;
    background-color: #f0f0f0;
    color: #333;
    font-size: 20px;
    cursor: pointer;
    transition: background-color 0.2s;
}

.qty-btn:hover {
    background-color: #ddd;
}

.qty-input {
    width: 40px;
    height: 45px;
    border: none;
    text-align: center;
    font-size: 16px;
    outline: none;
}
</style>

<div class="content-wraper section-ptb">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php if (!empty($cart)): ?>
                    <form action="/bw-clothes/cart/update" method="post" class="cart-table">
                        <div class="table-content table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Hình ảnh</th>
                                        <th>Sản phẩm</th>
                                        <th>Đơn giá</th>
                                        <th>Số lượng</th>
                                        <th>Tổng</th>
                                        <th>Xóa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $total = 0; foreach ($cart as $item): ?>
                                        <tr>
                                            <td>
                                                <img src="<?= $item['image'] ?>" width="80" alt="<?= $item['name'] ?>">
                                            </td>
                                            <td><?= $item['name'] ?></td>
                                            <td><?= number_format($item['price']) ?> đ</td>
                                            <td>
                                                <div class="quantity-group ms-5">
                                                    <button type="button" class="qty-btn" onclick="changeQuantity(-1, <?= $item['id'] ?>)">−</button>
                                                    <input type="text" id="quantity-<?= $item['id'] ?>" name="quantities[<?= $item['id'] ?>]" value="<?= $item['quantity'] ?>" min="1" class="qty-input">
                                                    <button type="button" class="qty-btn" onclick="changeQuantity(1, <?= $item['id'] ?>)">+</button>
                                                </div>
                                            </td>
                                            <td><?= number_format($item['price'] * $item['quantity']) ?> đ</td>
                                            <td>
<a href="/bw-clothes/cart/remove/<?= $item['product_id'] ?>" class="btn btn-danger btn-sm">
    <i class="fa fa-close"></i>
</a>
                                            </td>
                                        </tr>
                                        <?php $total += $item['price'] * $item['quantity']; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-8">
                                <div class="coupon-all d-flex justify-content-between flex-wrap">
                                    <div class="coupon">
                                        <h5>Coupon</h5>
                                        <input type="text" name="coupon_code" placeholder="Nhập mã giảm giá" class="form-control mb-2">
                                        <button class="btn btn-secondary">Áp dụng mã</button>
                                    </div>
                                    <div class="coupon2">
                                        <button type="submit" class="btn btn-primary">Cập nhật giỏ hàng</button>
                                        <a href="/bw-clothes/shop" class="btn btn-outline-dark">Tiếp tục mua hàng</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 ml-auto">
                                <div class="cart-page-total">
                                    <h4>Tổng giỏ hàng</h4>
                                    <ul>
                                        <li>Tạm tính <span><?= number_format($total) ?> đ</span></li>
                                        <li>Tổng cộng <span><?= number_format($total) ?> đ</span></li>
                                    </ul>
                                    <a href="checkout" class="btn btn-success btn-block">Tiến hành thanh toán</a>
                                </div>
                            </div>
                        </div>
                    </form>
                <?php else: ?>
                    <p>Giỏ hàng trống. <a href="/bw-clothes/cart/checkout/">Quay lại cửa hàng</a></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<script>
function changeQuantity(delta, id) {
    const input = document.getElementById("quantity-" + id);
    let value = parseInt(input.value);
    if (isNaN(value)) value = 1;
    value += delta;
    if (value < 1) value = 1;
    input.value = value;
}
</script>
<?php include 'layouts/boyka/footer.php'; ?>
<?php include 'layouts/boyka/html_end.php'; ?>
