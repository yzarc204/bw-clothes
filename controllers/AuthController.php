<?php
require_once './helpers/AuthHelper.php';

class AuthController
{
  public function login()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $username = isset($_POST['username']) ? $_POST['username'] : null;
      $password = isset($_POST['password']) ? $_POST['password'] : null;

      if (empty($username) || empty($password)) {
        $_SESSION['error'] = 'Vui lòng nhập tài khoản hoặc mật khẩu';
        header('Location: /login');
        exit;
      }
      if (!login($username, $password)) {
        $_SESSION['error'] = 'Tài khoản hoặc mật khẩu không đúng';
        header('Location: /login');
        exit;
      }

      header('Location: /');
      exit;
    }

    require './views/client/login.php';
  }

  public function register()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $userModel = new User();
      $_SESSION['old'] = $_POST;

      $username = isset($_POST['username']) ? $_POST['username'] : null;
      $password = isset($_POST['password']) ? $_POST['password'] : null;
      $confirmPassword = isset($_POST['confirmPassword']) ? $_POST['confirmPassword'] : null;
      $name = isset($_POST['name']) ? $_POST['name'] : null;

      // Validate
      $errors = [];
      if (empty($username))
        $errors[] = 'Vui lòng nhập tài khoản';
      if (strlen($username) < 5)
        $errors[] = 'Tài khoản phải có ít nhất 6 kí tự';
      if ($userModel->isUsernameExisted($username))
        $errors[] = "Tài khoản {$username} đã tồn tại";
      if (empty($password))
        $errors[] = 'Vui lòng nhập mật khẩu';
      if (strlen($password) < 8)
        $errors[] = 'Mật khẩu phải có ít nhất 8 kí tự';
      if ($password !== $confirmPassword)
        $errors[] = 'Vui lòng xác nhận mật khẩu';
      if (empty($name))
        $errors[] = 'Vui lòng nhập tên';
      if (!preg_match('/^[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚÝàáâãèéêìíòóôõùúýĂăĐđĨĩŨũƠơƯưẠ-ỹ\s]+$/', $name))
        $errors[] = 'Tên không hợp lệ. Tên chỉ bao gồm chữ cái và khoảng trắng';
      if (count($errors) > 0) {
        $_SESSION['error'] = $errors[0];
        header('Location: /register');
        exit;
      }

      $userModel->create($username, $password, $name);
      $_SESSION['success'] = 'Đăng ký thành công';
      unset($_SESSION['old']);
      header('Location: /register');
      exit;
    }

    require './views/client/register.php';
  }

  public function logout()
  {
    session_destroy();
    header('Location: /login');
    exit;
  }
}