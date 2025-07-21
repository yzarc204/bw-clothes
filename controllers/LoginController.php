<?php
require_once './helpers/AuthHelper.php';

class LoginController
{
  public function login()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $username = isset($_POST['username']) ? $_POST['username'] : null;
      $password = isset($_POST['password']) ? $_POST['password'] : null;

      if (!$username || !$password || strlen($username) == 0 || strlen($password) == 0) {
        $_SESSION['error'] = 'Vui lòng nhập tài khoản hoặc mật khẩu';
        header('Location: /login');
      }
      if (!login($username, $password)) {
        $_SESSION['error'] = 'Tài khoản hoặc mật khẩu không đúng';
        header('Location: /login');
      }
      die('Đăng nhập thành công');
    }

    require './views/client/login.php';
  }
}