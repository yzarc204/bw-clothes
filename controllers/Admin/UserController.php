<?php
require_once './helpers/AuthHelper.php';
require_once './helpers/ViewHelper.php';
require_once './models/User.php';

class UserController
{
  public function __construct()
  {
    checkAdminLogin();
  }

  public function index()
  {
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $search = isset($_GET['search']) ? $_GET['search'] : null;

    $userModel = new User();
    $users = $userModel->getPaginated($page, 10, $search);

    require_once './views/admin/user/index.php';
  }

  public function edit($userId)
  {
    $this->validateUserId($userId);

    $userModel = new User();
    $user = $userModel->getById($userId);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $_SESSION['old'] = $_POST;

      $username = isset($_POST['username']) ? trim($_POST['username']) : null;
      $name = isset($_POST['name']) ? trim($_POST['name']) : null;
      $isAdmin = isset($_POST['is_admin']) ? $_POST['is_admin'] : 0;

      $errors = $this->validate($username, $name, $isAdmin, $userId);
      if (count($errors) > 0) {
        $_SESSION['error'] = $errors[0];
        header("Location: /admin/user/{$userId}/edit");
        exit;
      }

      $userModel->update($userId, $username, $name, $isAdmin);

      $_SESSION['success'] = 'Cập nhật người dùng thành công';
      header("Location: /admin/user/{$userId}/edit");
      exit;
    }

    require_once './views/admin/user/edit.php';
  }

  private function validateUserId($userId)
  {
    $userModel = new User();
    if (!$userModel->isset($userId)) {
      $_SESSION['error'] = 'Người dùng không tồn tại';
      header("Location: /admin/user/{$userId}");
      exit;
    }
    return true;
  }

  private function validate($username, $name, $isAdmin, $userId)
  {
    $userModel = new User();
    $user = $userModel->getByUsername($username);
    $loginedUser = getCurrentUser();

    $errors = [];
    if (empty($username))
      $errors[] = 'Vui lòng nhập tài khoản';
    if (strlen($username) < 5)
      $errors[] = 'Tài khoản phải có ít nhất 6 kí tự';
    if ($user && $user['id'] != $userId)
      $errors[] = "Tài khoản {$username} đã tồn tại";
    if (empty($name))
      $errors[] = 'Vui lòng nhập tên';
    if (!preg_match('/^[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚÝàáâãèéêìíòóôõùúýĂăĐđĨĩŨũƠơƯưẠ-ỹ\s]+$/', $name))
      $errors[] = 'Tên không hợp lệ. Tên chỉ bao gồm chữ cái và khoảng trắng';
    if ($isAdmin !== '0' && $isAdmin !== '1')
      $errors[] = 'Quyền không hợp lệ';
    if ($userId == $loginedUser['id'] && $isAdmin == 0)
      $errors[] = 'Không thể cập nhật quyền quản trị viên trên tài khoản đang được đăng nhập';
    return $errors;
  }
}