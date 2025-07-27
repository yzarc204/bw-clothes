<?php
require_once './helpers/AuthHelper.php';
require_once './helpers/ViewHelper.php';
require_once './models/Category.php';

class CategoryController
{
  public function __construct()
  {
    checkAdminLogin();
  }

  public function index()
  {
    $page = $_GET['page'] ?? 1;

    $categoryModel = new Category();
    $categories = $categoryModel->getPaginated($page, 10);
    require './views/admin/category/index.php';
  }

  public function create()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_SESSION['old'] = $_POST;
      $name = isset($_POST['name']) ? $_POST['name'] : null;

      $this->validate($name);

      $categoryModel = new Category();
      $categoryModel->create($name);

      $_SESSION['success'] = 'Thêm thành công danh mục ' . $name;
      unset($_SESSION['old']);
      header('Location: /admin/category/create');
      exit;
    }

    require './views/admin/category/create.php';
  }

  public function edit($categoryId)
  {
    $_SESSION['old'] = $_POST;

    $categoryModel = new Category();

    $category = $categoryModel->getById($categoryId);
    if (!$category) {
      $_SESSION['error'] = 'Danh mục không tồn tại';
      header('Location: /admin/category');
      exit;
    }

    require './views/admin/category/edit.php';
  }

  private function validate($name)
  {
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
  }
}