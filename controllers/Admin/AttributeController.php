<?php
require './helpers/AuthHelper.php';
require './helpers/ViewHelper.php';
require './models/Color.php';
require './models/Size.php';

class AttributeController
{
  public function __construct()
  {
    checkAdminLogin();
  }

  public function index()
  {
    $colorModel = new Color();
    $colors = $colorModel->getAll();

    $sizeModel = new Size();
    $sizes = $sizes = $sizeModel->getAll();

    require './views/admin/attribute/index.php';
  }

  public function createColor()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $color = isset($_POST['color']) ? trim($_POST['color']) : null;
      $errors = $this->validateColor($color);

      if (!empty($errors)) {
        $_SESSION['error'] = $errors[0];
        header('Location: /admin/attribute');
        exit;
      }

      $colorModel = new Color();
      $colorModel->create($color);

      $_SESSION['success'] = "Màu sắc {$color} đã được thêm thành công";
      header('Location: /admin/attribute');
      exit;
    }
  }

  public function editColor($colorId)
  {
    $this->validateColorId($colorId);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $color = isset($_POST['color']) ? trim($_POST['color']) : null;

      $errors = $this->validateColor($color);
      if (!empty($errors)) {
        $_SESSION['error'] = $errors[0];
        header('Location: /admin/attribute');
        exit;
      }

      $colorModel = new Color();
      $colorModel->update($colorId, $color);

      $_SESSION['success'] = "Màu sắc {$color} đã được cập nhật thành công";
      header('Location: /admin/attribute');
      exit;
    }
  }

  public function deleteColor($colorId)
  {
    $this->validateColorId($colorId);

    $colorModel = new Color();
    $color = $colorModel->getById($colorId);

    $colorModel->delete($colorId);
    $_SESSION['success'] = "Màu sắc {$color['name']} đã được xóa thành công";
    header('Location: /admin/attribute');
    exit;
  }

  public function createSize()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $size = isset($_POST['size']) ? trim($_POST['size']) : null;
      $errors = $this->validateSize(size: $size);

      if (!empty($errors)) {
        $_SESSION['error'] = $errors[0];
        header('Location: /admin/attribute');
        exit;
      }

      $sizeModel = new Size();
      $sizeModel->create($size);

      $_SESSION['success'] = 'Size đã được thêm thành công';
      header('Location: /admin/attribute');
      exit;
    }
  }

  public function editSize($sizeId)
  {
    $this->validateSizeId($sizeId);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $size = isset($_POST['size']) ? trim($_POST['size']) : null;
      $errors = $this->validateSize(size: $size);

      if (!empty($errors)) {
        $_SESSION['error'] = $errors[0];
        header('Location: /admin/attribute');
        exit;
      }

      $sizeModel = new Size();
      $sizeModel->update($sizeId, $size);

      $_SESSION['success'] = 'Size đã được thêm thành công';
      header('Location: /admin/attribute');
      exit;
    }
  }

  public function deleteSize($sizeId)
  {
    $this->validateSizeId($sizeId);

    $sizeModel = new Size();
    $size = $sizeModel->getById($sizeId);

    $sizeModel->delete($sizeId);
    $_SESSION['success'] = "Màu sắc {$size['name']} đã được xóa thành công";
    header('Location: /admin/attribute');
    exit;
  }


  private function validateColor($color)
  {
    $errors = [];
    if (empty($color))
      $errors[] = 'Tên màu sắc không được bỏ trống.';
    if (strlen($color) > 255) {
      $errors[] = 'Tên màu sắc không quá dài.';
    }
    return $errors;
  }

  private function validateColorId($colorId)
  {
    $colorModel = new Color();
    if (!$colorModel->isset($colorId)) {
      $_SESSION['error'] = 'Màu sắc không tồn tại';
      header('Location: /admin/attribute');
      exit;
    }
  }

  private function validateSize($size)
  {
    $errors = [];
    if (empty($size))
      $errors[] = 'Size không được bỏ trống.';
    if (strlen($size) > 255) {
      $errors[] = 'Size không quá dài.';
    }
    return $errors;
  }

  private function validateSizeId($sizeId): void
  {
    $sizeModel = new Size();
    if (!$sizeModel->isset($sizeId)) {
      $_SESSION['error'] = 'Size không tồn tại';
      header('Location: /admin/attribute');
      exit;
    }
  }
}