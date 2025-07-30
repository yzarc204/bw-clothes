<?php
require_once './helpers/AuthHelper.php';
require_once './helpers/UploadHelper.php';
require_once './helpers/ViewHelper.php';
require_once './models/Product.php';
require_once './models/Category.php';
require_once './models/ProductImage.php';

class ProductController
{
  public function __construct()
  {
    checkAdminLogin();
  }

  public function index()
  {

  }

  public function create()
  {
    $categoryModel = new Category();
    $productModel = new Product();
    $productImageModel = new ProductImage();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $_SESSION['old'] = $_POST;

      $name = isset($_POST['name']) ? trim($_POST['name']) : null;
      $categoryId = isset($_POST['category_id']) ? ($_POST['category_id'] ?? null) : null;
      $description = isset($_POST['description']) ? $_POST['description'] : null;
      $images = isset($_FILES['images']) ? $_FILES['images'] : [];

      $errors = $this->validate($name, $categoryId, $description, $images);
      if (count($errors)) {
        $_SESSION['error'] = $errors[0];
        header('Location: /admin/product/create');
        exit;
      }

      $images = $this->uploadImages($images);
      $featuredImage = array_shift($images);

      $productId = $productModel->create($name, $categoryId, $description, $featuredImage);
      foreach ($images as $image) {
        $productImageModel->create($productId, $image);
      }

      $_SESSION['success'] = "Thêm sản phẩm {$name} thành công!";
      unset($_SESSION['error']);
      unset($_SESSION['old']);
      header('Location: /admin/product/create');
      exit;
    }

    $categories = $categoryModel->getAll();
    require './views/admin/product/create.php';
  }

  public function edit($categoryId)
  {
    $this->validateProductId($categoryId);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    }

    // require './views/admin/product/index.php'
  }

  private function validate($name, $categoryId, $description, $images)
  {
    $errors = [];

    if (!$name) {
      $errors[] = 'Vui lòng nhập tên sản phẩm';
    }
    if (strlen($name) > 255) {
      $errors[] = 'Tên sản phẩm không được vượt quá 255 kí tự';
    }

    $categoryModel = new Category();
    if ($categoryId && !$categoryModel->isset($categoryId)) {
      $errors[] = 'Danh mục không tồn tại';
    }

    if (!isset($images['name']) || empty($images['name'][0])) {
      $errors[] = 'Vui lòng đính kèm ít nhất một ảnh';
    } else {
      $hasValidFile = false;
      foreach ($images['error'] as $error) {
        if ($error === UPLOAD_ERR_OK) {
          $hasValidFile = true;
          break;
        }
      }
      if (!$hasValidFile) {
        $errors[] = 'Không có ảnh hợp lệ được đính kèm';
      }
    }

    return $errors;
  }

  private function validateProductId($productId)
  {
    $productModel = new Product();
    if (!$productModel->isset($productId)) {
      $_SESSION['error'] = 'Sản phẩm không tồn tại';
      header('Location: /admin/product');
      exit;
    }
  }

  private function uploadImages($images)
  {
    $uploads = uploadMultipleFiles($images, '');
    return $uploads;
  }
}