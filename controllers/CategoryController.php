<?php
require_once 'models/ProductModel.php';
require_once 'models/CategoryModel.php';

class CategoryController
{
    public function index($id)  // ✅ phải có tham số $id
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();

        $category = $categoryModel->getById($id);
        $products = $productModel->getByCategoryId($id);

        if (!$category) {
            die('404 - Không tìm thấy danh mục');
        }

        include 'views/category.php';
    }
}
