<?php
require_once './helpers/AuthHelper.php';
require_once './helpers/UploadHelper.php';
require_once './helpers/ViewHelper.php';
require_once './models/Product.php';
require_once './models/Category.php';
require_once './models/Variant.php';
require_once './models/ProductImage.php';

class ProductController
{
  public function __construct()
  {
    checkAdminLogin();
  }

  public function index()
  {
    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    $search = isset($_GET['search']) ? trim($_GET['search']) : null;

    $productModel = new Product();
    $products = $productModel->getDetailPaginated($page, 10, $search);
    require './views/admin/product/index.php';
  }

  public function detail($productId)
  {
    $this->validateProductId($productId);

    $productModel = new Product();
    $productImageModel = new ProductImage();
    $variantModel = new Variant();

    $product = $productModel->getDetailById($productId);
    $images = $productImageModel->getByProductId($productId);
    $variants = $variantModel->getVariantsByProductId($productId);

    require './views/admin/product/detail.php';
  }

  public function create()
  {
    $categoryModel = new Category();
    $productModel = new Product();
    $productImageModel = new ProductImage();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $_SESSION['old'] = $_POST;

      $name = trim($_POST['name'] ?? '');
      $categoryId = $_POST['category_id'] ?? null;
      $description = $_POST['description'] ?? null;
      $featuredImage = $_FILES['featured_image'] ?? null;
      $images = $_FILES['images'] ?? [];

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
      header("Location: /admin/product/{$productId}");
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

      $name = trim($_POST['name'] ?? '');
      $categoryId = $_POST['category_id'] ?? null;
      $description = $_POST['description'] ?? null;
      $featuredImage = $_FILES['featured_image'] ?? null;
      $images = $_FILES['images'] ?? [];

      $errors = $this->validate($name, $categoryId, $description, $featuredImage, $images, true);
      if (count($errors)) {
        $_SESSION['error'] = $errors[0];
        header("Location: /admin/product/{$productId}/edit");
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
    $images = $productImageModel->getByProductId($productId);
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

  public function deleteProductImage($imageId)
  {
    $productImageModel = new ProductImage();
    $productImage = $productImageModel->getById($imageId);
    $productImageModel->delete($imageId);
    header("Location: /admin/product/{$productImage['product_id']}/edit");
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
          $errors[] = 'Ảnh sản phẩm chỉ chấp nhận các format: ' . implode(', ', ALLOWED_IMAGE_EXTENSIONS);
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