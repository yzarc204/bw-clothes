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
    $productModel = new Product();
    $products = $productModel->getProductDetailPaginated();
    require './views/admin/product/index.php';
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
      $featuredImage = isset($_FILES['featured_image']) ? $_FILES['featured_image'] : null;
      $images = isset($_FILES['images']) ? $_FILES['images'] : [];

      $errors = $this->validate($name, $categoryId, $description, $featuredImage, $images);
      if (count($errors)) {
        $_SESSION['error'] = $errors[0];
        header('Location: /admin/product/create');
        exit;
      }

      $featuredImage = upload($featuredImage, 'products');
      if (count(array_filter($images['name'])) > 0) {
        $images = uploadMultipleFiles($images, 'products');
      } else {
        $images = [];
      }

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

  public function edit($productId)
  {
    $this->validateProductId($productId);

    $productModel = new Product();
    $productImageModel = new ProductImage();
    $categoryModel = new Category();

    $product = $productModel->getById($productId);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $_SESSION['old'] = $_POST;

      $name = isset($_POST['name']) ? trim($_POST['name']) : null;
      $categoryId = isset($_POST['category_id']) ? ($_POST['category_id'] ?? null) : null;
      $description = isset($_POST['description']) ? $_POST['description'] : null;
      $featuredImage = isset($_FILES['featured_image']) ? $_FILES['featured_image'] : null;
      $images = isset($_FILES['images']) ? $_FILES['images'] : [];

      $errors = $this->validate($name, $categoryId, $description, $featuredImage, $images, true);
      if (count($errors)) {
        $_SESSION['error'] = $errors[0];
        header("Location: /admin/category/{$categoryId}/edit");
        exit;
      }

      if (!empty($featuredImage['name'])) {
        $featuredImage = upload($featuredImage, 'products');
      } else {
        $featuredImage = $product['featured_image'];
      }
      if (!empty($images['name'][0])) {
        $images = uploadMultipleFiles($images, 'products');
      } else {
        $images = [];
      }

      $productModel->update($productId, $name, $categoryId, $description, $featuredImage);
      foreach ($images as $image) {
        $productImageModel->create($productId, $image);
      }

      $_SESSION['success'] = "Cập nhật sản phẩm {$product['name']} thành công";
      unset($_SESSION['error']);
      unset($_SESSION['old']);
      header("Location: /admin/product/{$productId}/edit");
      exit;
    }

    $categories = $categoryModel->getAll();
    require './views/admin/product/edit.php';
  }

  public function delete($productId)
  {
    $this->validateProductId($productId);

    $productModel = new Product();
    $product = $productModel->getById($productId);
    $productModel->delete($productId);

    $_SESSION['success'] = "Xoá sản phẩm {$product['name']} thành công";
    header('Location: /admin/product');
    exit;
  }

  private function validate($name, $categoryId, $description, $featuredImage, $images, $editMode = false)
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

    $isFeaturedImageUploaded = !empty($featuredImage['name']);
    if (!$isFeaturedImageUploaded && !$editMode) {
      $errors[] = 'Vui lòng tải lên ảnh đại diện của sản phẩm';
    } else if ($isFeaturedImageUploaded) {
      $extension = strtolower(pathinfo($featuredImage['name'], PATHINFO_EXTENSION));
      if (!in_array($extension, ALLOWED_IMAGE_EXTENSIONS)) {
        $errors[] = 'Ảnh đại diện chỉ chấp nhận các format: ' . implode(', ', ALLOWED_IMAGE_EXTENSIONS);
      }
    }

    $hasImages = !empty($images['name'][0]);
    if ($hasImages) {
      foreach ($images['name'] as $index => $imageName) {
        $extension = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
        if (!in_array($extension, ALLOWED_IMAGE_EXTENSIONS)) {
          $errors[] = 'Ảnh sản phẩm chỉ chấp nhận các format: ' . implode(', ', array: ALLOWED_IMAGE_EXTENSIONS);
        }
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
}