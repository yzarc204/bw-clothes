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
    $limit = 12;
    $paginationHref = '/shop?page=';

    $products = $productModel->getDetailPaginated($page, $limit); // hoặc phân trang giống như index()
    $categories = $categoryModel->getAllDetail();

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
  public function search()
  {
    $keyword = $_GET['keyword'] ?? '';

    $productModel = new Product();
    $products = $productModel->searchProducts($keyword);

    $breadcrumbTitle = "Kết quả tìm kiếm cho: " . htmlspecialchars($keyword);
    include 'views/client/Search_results.php';
  }
  public function category($id)
  {
    $categoryModel = new Category();
    $productModel = new Product();

    // Lấy danh mục theo ID
    $category = $categoryModel->getById($id);
    if (!$category) {
      include 'views/errors/404.php'; // tạo file 404 nếu cần
      return;
    }

    // Lấy sản phẩm theo category_id
    $products = $productModel->getDetailPaginatedByCategoryId($category['id']);
    $breadcrumbTitle = "Danh mục: " . htmlspecialchars($category['name']);

    include 'views/client/Category.php';
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
