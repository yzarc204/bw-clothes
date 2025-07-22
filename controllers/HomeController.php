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

    $products = $productModel->getLimit(8);
    $categories = $categoryModel->getAll();

    include 'views/client/home.php';
  }
  public function shop()
  {
    $productModel = new Product();
    $categoryModel = new Category();

    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $limit = 8;
    $paginationHref = '/shop?page=';

    $products = $productModel->getPaginated($page, $limit); // hoặc phân trang giống như index()
    $categories = $categoryModel->getAll();

    include 'views/client/shop.php';
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
