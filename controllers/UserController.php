<?php
require_once 'models/UserModel.php'; // Đảm bảo có gọi model nếu cần

class UserController
{
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $userModel = new UserModel();
            $user = $userModel->checkLogin($username, $password);

            if ($user) {
                if (session_status() === PHP_SESSION_NONE) session_start();
                $_SESSION['user'] = $user;

                // ✅ Redirect tới trang account sau khi đăng nhập thành công
                header('Location: account');
                exit;
            } else {
                $error = 'Sai tài khoản hoặc mật khẩu';
                require 'views/login-register.php';
            }
        } else {
            require 'views/login-register.php';
        }
    }

    public function register()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            $userModel = new UserModel();
            $existingUser = $userModel->getUserByUsername($username);

            if ($existingUser) {
                $error = "Tên đăng nhập đã tồn tại.";
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $userModel->createUser($username, $hashedPassword, $name, $email);

                $_SESSION['register_success'] = "Đăng ký thành công. Vui lòng đăng nhập.";
                header('Location: index.php?url=login');
                exit;
            }
        }

        include 'views/login-register.php';
    }

     public function account()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['user'])) {
            header('Location: login');
            exit;
        }

        $user = $_SESSION['user'];
        require 'views/account.php';
    }

    public function logout()
    {
        $this->requireLogin();

        session_destroy();
        header('Location: index.php?url=login');
        exit;
    }

    public function requireLogin()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?url=login');
            exit;
        }
    }
}
