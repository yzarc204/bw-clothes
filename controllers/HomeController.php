<?php
require_once './helpers/AuthHelper.php';
require_once './helpers/ViewHelper.php';
require_once './models/Product.php';
require_once './models/Category.php';
require_once './models/Variant.php';
require_once './models/ProductImage.php';

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

    $products = $productModel->getDetailLimit(8);
    $categories = $categoryModel->getAllDetail();

    include 'views/client/home.php';
  }
  public function shop()
  {
    $productModel = new Product();
    $categoryModel = new Category();

    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $keyword = isset($_GET['s']) ? $_GET['s'] : null;

    $products = $productModel->getDetailPaginated($page, 12, $keyword);
    $categories = $categoryModel->getAll();

    include 'views/client/shop.php';
  }
  public function product($id)
  {
    $productModel = new Product();
    $productImageModel = new ProductImage();
    $variantModel = new Variant();

    $product = $productModel->getDetailById($id);
    $images = $productImageModel->getByProductId($id);
    $variants = $variantModel->getVariantsByProductId($id);

    include 'views/client/product_details.php';
  }

  public function category($categoryId)
  {
    $categoryModel = new Category();
    $productModel = new Product();

    $page = isset($_GET['page']) ? $_GET['page'] : 1;

    $category = $categoryModel->getById($categoryId);
    $products = $productModel->getDetailPaginatedByCategoryId($categoryId, $page, 12);

    if (!$category || empty($products['items'])) {
      header('Location: /');
      exit;
    }

    include 'views/client/category.php';
  }
  public function about()
  {
    include 'views/client/about.php';
  }
  public function contact()
  {
    include 'views/client/contact.php';
  }


}
