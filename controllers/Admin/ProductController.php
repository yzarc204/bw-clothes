<?php
require './helpers/AuthHelper.php';
require './models/Category.php';

class ProductController
{
  public function __construct()
  {
    checkAdminLogin();
  }

  public function create()
  {
    $categoryModel = new Category();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $_SESSION['old'] = $_POST;

      $name = isset($_POST['name']) ? trim($_POST['name']) : null;
    }

    $categories = $categoryModel->getAll();
    require './views/admin/product/create.php';
  }
}