<?php
require_once './helpers/ViewHelper.php';
require_once './helpers/AuthHelper.php';
require_once './models/Product.php';
require_once './models/Variant.php';
require_once './models/Color.php';
require_once './models/Size.php';

class VariantController
{
  public function __construct()
  {
    checkAdminLogin();
  }

  public function product($productId)
  {
    $this->validateProductId($productId);

    $productModel = new Product();
    $variantModel = new Variant();
    $colorModel = new Color();
    $sizeModel = new Size();

    $product = $productModel->getById($productId);
    $variants = $variantModel->getVariantsByProductId($productId);
    $colors = $colorModel->getAll();
    $sizes = $sizeModel->getAll();

    require './views/admin/variant/product.php';
  }

  public function create()
  {
    $variantModel = new Variant();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $_SESSION['old'] = $_POST;

      $productId = isset($_POST['product_id']) ? $_POST['product_id'] : null;
      $colorId = isset($_POST['color_id']) ? $_POST['color_id'] : null;
      $sizeId = isset($_POST['size_id']) ? $_POST['size_id'] : null;
      $price = isset($_POST['price']) ? $_POST['price'] : null;
      $salePrice = isset($_POST['sale_price']) ? $_POST['sale_price'] : null;

      $errors = $this->validate($productId, $colorId, $sizeId, $price, $salePrice);
      if (!empty($errors)) {
        $_SESSION['error'] = $errors[0];
        header("Location: /admin/product/{$productId}/variant");
        exit;
      }

      $variantId = $variantModel->create($productId, $colorId, $sizeId, $price, $salePrice);
      $variant = $variantModel->getDetailById($variantId);

      $_SESSION['success'] = "Biến thể {$variant['color']} - {$variant['size']} đã được thêm thành công";
      header("Location: /admin/product/{$productId}/variant");
      exit;
    }
  }

  public function edit($variantId)
  {
    $this->validateVariantId($variantId);

    $variantModel = new Variant();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $_SESSION['old'] = $_POST;

      $productId = isset($_POST['product_id']) ? $_POST['product_id'] : null;
      $colorId = isset($_POST['color_id']) ? $_POST['color_id'] : null;
      $sizeId = isset($_POST['size_id']) ? $_POST['size_id'] : null;
      $price = isset($_POST['price']) ? $_POST['price'] : null;
      $salePrice = isset($_POST['sale_price']) ? $_POST['sale_price'] : null;

      $errors = $this->validate($productId, $colorId, $sizeId, $price, $salePrice, $variantId, true);
      if (!empty($errors)) {
        $_SESSION['error'] = $errors[0];
        header("Location: /admin/product/{$productId}/variant");
        exit;
      }

      $variantModel->update($variantId, $productId, $colorId, $sizeId, $price, $salePrice);
      $variant = $variantModel->getDetailById($variantId);

      $_SESSION['success'] = "Biến thể {$variant['color']} - {$variant['size']} đã được cập nhật thành công";
      header("Location: /admin/product/{$productId}/variant");
      exit;
    }
  }

  public function delete($variantId)
  {
    $this->validateVariantId($variantId);

    $variantModel = new Variant();
    $variant = $variantModel->getDetailById($variantId);
    $variantModel->delete($variantId);

    $_SESSION['success'] = "Biến thể {$variant['color']} - {$variant['size']} đã được xóa thành công";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
  }

  public function bulkCreate()
  {
    $productModel = new Product();
    $variantModel = new Variant();
    $colorModel = new Color();
    $sizeModel = new Size();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $productId = isset($_POST['product_id']) ? $_POST['product_id'] : null;
      $colorIds = isset($_POST['colors']) ? $_POST['colors'] : [];
      $sizeIds = isset($_POST['sizes']) ? $_POST['sizes'] : [];

      if (empty($productId) || !$productModel->isset($productId)) {
        $_SESSION['error'] = 'Sản phẩm không tồn tại';
        header('Location: /admin/product');
        exit;
      }
      if (empty($colorIds)) {
        $_SESSION['error'] = 'Chưa chọn thuộc tính màu sắc';
        header("Location: /admin/product/{$productId}/variant");
        exit;
      }
      if (empty($sizeIds)) {
        $_SESSION['error'] = 'Chưa chọn thuộc tính kích thước';
        header("Location: /admin/product/{$productId}/variant");
        exit;
      }

      $totalCreatedVariants = 0;
      foreach ($colorIds as $colorId) {
        foreach ($sizeIds as $sizeId) {
          if (!$variantModel->productVariantIsset($productId, $colorId, $sizeId)) {
            $variantModel->create($productId, $colorId, $sizeId, 0, null);
            $totalCreatedVariants++;
          }
        }
      }

      $_SESSION['success'] = "Đã tạo thành công {$totalCreatedVariants} biến thể cho sản phẩm";
      header("Location: /admin/product/{$productId}/variant");
      exit;
    }
  }

  private function validate($productId, $colorId, $sizeId, $price, $salePrice, $variantId = null, $editMode = false)
  {
    $colorModel = new Color();
    $sizeModel = new Size();
    $productModel = new Product();
    $variantModel = new Variant();

    $variant = $variantModel->getByDetail($productId, $colorId, $sizeId);

    $errors = [];
    if (empty($productId) || !$productModel->isset($productId))
      $errors[] = 'Sản phẩm không tồn tại';
    if (empty($colorId))
      $errors[] = 'Chưa chọn thuộc tính màu sắc';
    if (!$colorModel->isset($colorId))
      $errors[] = 'Thuộc tính màu sắc không tồn tại';
    if (empty($sizeId))
      $errors[] = 'Chưa chọn thuộc tính size';
    if (!$sizeModel->isset($sizeId))
      $errors[] = 'Thuộc tính size không tồn tại';
    if ($editMode && $variant['id'] != $variantId)
      $errors[] = 'Biến thể đã tồn tại';
    if (!$editMode && $variant)
      $errors[] = 'Biến thể đã tồn tại';
    if (empty($price))
      $errors[] = 'Chưa nhập giá';
    if (!filter_var($price, FILTER_VALIDATE_INT))
      $errors[] = 'Giá của sản phẩm phải là số nguyên';
    if ($price <= 0)
      $errors[] = 'Giá sản phẩm phải lớn hơn 0';
    if (!empty($salePrice) && !filter_var($salePrice, FILTER_VALIDATE_INT))
      $errors[] = 'Giá khuyến mãi phải là số nguyên';
    if (!empty($salePrice) && $salePrice < 0)
      $errors[] = 'Giá khuyến mãi phải lớn hơn hoặc bằng 0';
    if (!empty($salePrice) && $salePrice >= $price)
      $errors[] = 'Giá khuyến mãi phải thấp hơn giá gốc';
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

  private function validateVariantId($variantId)
  {
    $variantModel = new Variant();
    if (!$variantModel->isset($variantId)) {
      $_SESSION['error'] = "Biến thể không tồn tại";
      header('Location: ' . $_SERVER['HTTP_REFERER']);
      exit;
    }
  }
}