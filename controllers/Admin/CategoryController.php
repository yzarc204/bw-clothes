<?php
require_once './helpers/AuthHelper.php';
require_once './models/Category.php';

class CategoryController
{
  public function __construct()
  {
    checkAdminLogin();
  }

  public function create()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_SESSION['old'] = $_POST;
      $name = isset($_POST['name']) ? $_POST['name'] : null;

      // Validate
      $errors = [];
      if (empty($name))
        $errors[] = 'Vui lòng nhập tên danh mục';
      if (strlen($name) > 255)
        $errors[] = 'Tên danh mục không được vượt quá 255 kí tự';
      if (count($errors) > 0) {
        $_SESSION['error'] = $errors[0];
        header('Location: /admin/category/create');
        exit;
      }

      $categoryModel = new Category();
      $categoryModel->create($name);

      $_SESSION['success'] = 'Thêm thành công danh mục ' . $name;
      unset($_SESSION['old']);
      header('Location: /admin/category/create');
      exit;
    }

    require './views/admin/category/create.php';
  }
}