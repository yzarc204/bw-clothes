<?php
require_once './helpers/AuthHelper.php';
require_once './models/Product.php';
require_once './models/Category.php';

class HomeController
{
  public function __construct()
  {
    checkLogin();
  }

  public function index()
  {
    $productModel = new Product();
    $categoryModel = new Category();

    $limit = 8;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    if ($page < 1) $page = 1;
    $offset = ($page - 1) * $limit;

    $products = $productModel->getPaginated($limit, $offset);
    $totalProducts = $productModel->getTotalCount();
    $totalPages = ceil($totalProducts / $limit);
    $categories = $categoryModel->getAll();


    include 'views/client/home.php';
  }

  public function product($id)
  {
    echo 'Trang sản phẩm ' . $id;
  }


  public function search()
  {
    echo 'Trang search';
  }
}
