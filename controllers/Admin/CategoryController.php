<?php
require_once './helpers/AuthHelper.php';
require_once './helpers/ViewHelper.php';
require_once './models/Category.php';

class CategoryController
{
  public function __construct()
  {
    checkAdminLogin(); // Kiểm tra đăng nhập admin
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
      $name = isset($_POST['name']) ? trim($_POST['name']) : null;

      $errors = $this->validate($name);
      if (count($errors) > 0) {
        $_SESSION['error'] = $errors[0];
        header('Location: /admin/category/create');
        exit;
      }

      $categoryModel = new Category();
      $categoryModel->create($name);

      $_SESSION['success'] = 'Thêm thành công danh mục ' . $name;
      unset($_SESSION['old']);
      unset($_SESSION['error']);
      header('Location: /admin/category/create');
      exit;
    }

    require './views/admin/category/create.php';
  }

  public function edit($categoryId)
  {
    $this->validateCategoryId($categoryId);
    $categoryModel = new Category();
    $category = $categoryModel->getById($categoryId);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $_SESSION['old'] = $_POST;
      $name = isset($_POST['name']) ? trim($_POST['name']) : null;

      $errors = $this->validate($name);
      if (count($errors) > 0) {
        $_SESSION['error'] = $errors[0];
        header("Location: /admin/category/{$categoryId}/edit");
        exit;
      }

      $categoryModel->update($categoryId, $name);

      $_SESSION['success'] = "Cập nhật danh mục {$name} thành công";
      unset($_SESSION['old']);
      unset($_SESSION['error']); // Làm sạch error cũ nếu có
      header("Location: /admin/category/{$categoryId}/edit");
      exit;
    }

    require './views/admin/category/edit.php';
  }

  public function delete($categoryId)
  {
    $this->validateCategoryId($categoryId);
    $categoryModel = new Category();
    $category = $categoryModel->getById($categoryId);
    $categoryModel->delete($categoryId);

    $_SESSION['success'] = "Xoá danh mục {$category['name']} thành công";
    header('Location: /admin/category');
    exit;
  }

  private function validate($name)
  {
    $errors = [];
    if (empty($name)) {
      $errors[] = 'Vui lòng nhập tên danh mục';
    }
    if (strlen($name) > 255) {
      $errors[] = 'Tên danh mục không được vượt quá 255 kí tự';
    }
    return $errors;
  }

  private function validateCategoryId($categoryId)
  {
    $categoryModel = new Category();
    $category = $categoryModel->getById($categoryId);
    if (!$category) {
      $_SESSION['error'] = 'Danh mục không tồn tại';
      header('Location: /admin/category');
      exit;
    }
  }
}