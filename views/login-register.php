<?php require 'views/layouts/boyka/html_start.php'; ?>
<?php require 'views/layouts/boyka/header.php'; ?>
<?php
$breadcrumbTitle = 'Đăng ký - Đăng nhập';
include 'views/layouts/boyka/breadcrumb.php';
?>

<div class="content-wraper">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-12 m-auto">
                <div class="login-register-wrapper">
                    <div class="login-register-tab-list nav" role="tablist">
                        <a class="active" data-bs-toggle="tab" href="#lg1">
                            <h4>Đăng nhập</h4>
                        </a>
                        <a data-bs-toggle="tab" href="#lg2">
                            <h4>Đăng ký</h4>
                        </a>
                    </div>
                    <div class="tab-content">
                        <!-- Đăng nhập -->
                        <div id="lg1" class="tab-pane active">
                            <div class="login-form-container">
                                <div class="login-register-form">
                                    <?php if (!empty($error) && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'], $_POST['password'])): ?>
                                        <p style="color:red"><?= htmlspecialchars($error) ?></p>
                                    <?php endif; ?>
                                    <form action="login" method="post">
                                        <div class="login-input-box">
                                            <input type="text" name="username" placeholder="User Name" required>
                                            <input type="password" name="password" placeholder="Password" required>
                                        </div>
                                        <div class="button-box">
                                            <button class="login-btn btn" name="login" type="submit"><span>Login</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Đăng ký -->
                        <div id="lg2" class="tab-pane">
                            <div class="login-form-container">
                                <div class="login-register-form">
                                        <?php
                                        if (session_status() === PHP_SESSION_NONE) session_start();
                                        if (!empty($_SESSION['register_success'])) {
                                            echo "<script>alert('" . $_SESSION['register_success'] . "');</script>";
                                            unset($_SESSION['register_success']);
                                        }
                                        ?>
                                    <form action="register" method="post">
                                        <div class="login-input-box">
                                            <input type="text" name="username" placeholder="User Name" required>
                                            <input type="text" name="name" placeholder="Họ và tên" required>
                                            <input type="email" name="email" placeholder="Email" required>
                                            <input type="password" name="password" placeholder="Password" required>
                                        </div>
                                        <div class="button-box">
                                            <button class="register-btn btn" type="submit" name="register"><span>Register</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div> <!-- .tab-content -->
                </div>
            </div>
        </div>
    </div>
</div>

<?php require 'views/layouts/boyka/footer.php'; ?>
<?php require 'views/layouts/boyka/html_end.php'; ?>
