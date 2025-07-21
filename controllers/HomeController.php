<?php
require_once 'models/ProductModel.php';
require_once 'models/CategoryModel.php';
require_once 'models/UserModel.php';
require_once 'models/VariantModel.php';


class HomeController
{
    public function index() {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();

        $limit = 8;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;
        $offset = ($page - 1) * $limit;

        $products = $productModel->getPaginated($limit, $offset);
        $totalProducts = $productModel->getTotalCount();
        $totalPages = ceil($totalProducts / $limit);
        $categories = $categoryModel->getAll();


        include 'views/home.php';
        
    }
    public function product($id)
    {
        $productModel = new ProductModel();
        $variantModel = new VariantModel();
        $categoryModel = new CategoryModel();

        $product = $productModel->getById($id);
        $variants = $variantModel->getVariantsByProductId($id);
        $images = $productModel->getImagesByProductId($id);
        
        // ✅ THÊM DÒNG NÀY ĐỂ LẤY SẢN PHẨM LIÊN QUAN
        $relatedProducts = $productModel->getRelatedProducts($product['category_id'], $id);

        // Tách size và màu
        $sizes = [];
        $colors = [];
        foreach ($variants as $variant) {
            if (!isset($sizes[$variant['size_id']])) {
                $sizes[$variant['size_id']] = [
                    'id' => $variant['size_id'],
                    'name' => $variant['size_name']
                ];
            }
            if (!isset($colors[$variant['color_id']])) {
                $colors[$variant['color_id']] = [
                    'id' => $variant['color_id'],
                    'name' => $variant['color_name']
                ];
            }
        }

        include 'views/product-detail.php';
    }

    public function shop()
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();

        $products = $productModel->getAll(); // hoặc phân trang giống như index()
        $categories = $categoryModel->getAll();

        include 'views/shop.php';
    }
    public function category($slug)
{
    require_once 'models/CategoryModel.php';
    require_once 'models/ProductModel.php';

    $categoryModel = new CategoryModel();
    $productModel = new ProductModel();

    // Lấy danh mục theo slug
    $category = $categoryModel->getBySlug($slug);

    if (!$category) {
        die("404 - Không tìm thấy danh mục");
    }

    // Lấy sản phẩm theo category_id
    $products = $productModel->getByCategoryId($category['id']);

    $breadcrumbTitle = $category['name'];
    include 'views/category.php';
}

    public function about(){
        include 'views/about.php';
    }
    public function search()
{
    $keyword = $_GET['keyword'] ?? '';

    $productModel = new ProductModel();
    $products = $productModel->searchProducts($keyword);

    $breadcrumbTitle = "Kết quả tìm kiếm cho: " . htmlspecialchars($keyword);
    include 'views/search_results.php';
}

    public function contact(){
        include 'views/conctact.php';
    }
    public function cart(){
        include 'views/cart.php';
    }
}
