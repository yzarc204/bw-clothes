<?php
require_once './models/User.php';

/**
 * Kiểm tra tài khoản và mật khẩu có trùng khớp với tài khoản nào không
 * Nếu đúng thì đẩy user_id vào $_SESSIOn để đăng nhập
 * @return bool
 */
function login(string $username, string $password): bool
{
  $userModel = new User();
  $user = $userModel->getByUserAndPass($username, $password);
  if (!$user)
    return false;

  $_SESSION['user_id'] = $user['id'];
  return true;
}

/**
 * Đăng xuất: xoá $_SESSION['user_id']
 * @return void
 */
function logout()
{
  unset($_SESSION['user_id']);
}

/**
 * Lấy data của user đang được đăng nhập
 * @return array|null Trả về mảng user nếu đã đăng nhập, trả về null nếu không đăng nhập
 */
function getCurrentUser(): ?array
{
  $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
  if (!$userId)
    return null;
  $userModel = new User();
  $user = $userModel->getById($userId);
  return $user;
}

/**
 * Kiểm tra đăng nhập, nếu chưa đăng nhập thì redirect về trang login
 * @return void
 */
function checkLogin(): void
{
  $user = getCurrentUser();
  if (!$user) {
    header('Location: /login');
    exit;
  }
}

/**
 * Kiểm tra đăng nhập và người đăng nhập có quyền admin hay không. Redirect về trang chủ nếu không phải admin
 * @return void
 */
function checkAdminLogin(): void
{
  checkLogin();
  $user = getCurrentUser();
  if (!$user['is_admin']) {
    header('Location: /');
    exit;
  }
}