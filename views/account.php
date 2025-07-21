<?php include 'views/layouts/boyka/html_start.php'; ?>
<?php include 'views/layouts/boyka/header.php'; ?>
<?php
$breadcrumbTitle = 'Đăng ký - Đăng nhập';
include 'views/layouts/boyka/breadcrumb.php';
?>

<div class="content-wraper">
    <div class="container">
        <h2>Thông tin tài khoản</h2>

        <?php if (isset($_SESSION['user'])): 
            $user = $_SESSION['user']; ?>
            <p><strong>Tên đăng nhập:</strong> <?= htmlspecialchars($user['username']) ?></p>
            <p><strong>Họ tên:</strong> <?= htmlspecialchars($user['name']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
            <a href="logout">Đăng xuất</a>
        <?php else: ?>
            <p>Bạn chưa đăng nhập. <a href="login">Đăng nhập tại đây</a>.</p>
        <?php endif; ?>
    </div>
</div>

<?php include 'views/layouts/boyka/footer.php'; ?>
<?php include 'views/layouts/boyka/html_end.php'; ?>
