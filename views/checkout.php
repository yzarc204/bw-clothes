<?php include 'layouts/boyka/html_start.php'; ?>
<?php include 'layouts/boyka/header.php'; ?>
<?php
$breadcrumbTitle = 'Thanh toán';
include 'views/layouts/boyka/breadcrumb.php';
?>

<div class="container section-ptb">
    <h3>Thanh toán</h3>

    <?php if (!empty($cart)): ?>
    <form method="POST" action="">
        <div class="row">
            <div class="col-md-6">
                <h5>Thông tin nhận hàng</h5>
                <div class="form-group">
                    <label>Họ tên</label>
                    <input type="text" name="customer_name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Địa chỉ</label>
                    <input type="text" name="address" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Số điện thoại</label>
                    <input type="text" name="phone_number" class="form-control" required>
                </div>
            </div>
            <div class="col-md-6">
                <h5>Đơn hàng của bạn</h5>
                <ul class="list-group">
                    <?php $total = 0; foreach ($cart as $item): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?= $item['name'] ?> (x<?= $item['quantity'] ?>)
                        <span><?= number_format($item['price'] * $item['quantity']) ?> đ</span>
                    </li>
                    <?php $total += $item['price'] * $item['quantity']; endforeach; ?>
                    <li class="list-group-item d-flex justify-content-between">
                        <strong>Tổng cộng</strong>
                        <strong><?= number_format($total) ?> đ</strong>
                    </li>
                </ul>
                <button type="submit" class="btn btn-success mt-3">Xác nhận đặt hàng</button>
            </div>
        </div>
    </form>
    <?php else: ?>
        <p>Giỏ hàng trống. <a href="/bw-clothes/shop">Quay lại mua hàng</a></p>
    <?php endif; ?>
</div>

<?php include 'layouts/boyka/footer.php'; ?>
<?php include 'layouts/boyka/html_end.php'; ?>
        