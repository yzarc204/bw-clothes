<?php

require_once 'models/Database.php';

class ProductModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = (new DBConnect())->getConnection();
    }

    // Lấy giới hạn sản phẩm kèm ảnh đầu tiên
    public function getLimit($limit)
    {
        $limit = (int) $limit; // Ép kiểu tránh injection
        $sql = "SELECT p.*, 
                    (SELECT image_url FROM product_images WHERE product_id = p.id LIMIT 1) AS image
                FROM products p
                LIMIT $limit"; // chèn trực tiếp số
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy tất cả sản phẩm kèm ảnh đầu tiên
    public function getAll()
    {
        $sql = "SELECT p.*, 
                       (SELECT image_url FROM product_images WHERE product_id = p.id LIMIT 1) AS image
                FROM products p";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy chi tiết 1 sản phẩm
public function getById($id)
{
    $stmt = $this->conn->prepare("
        SELECT p.*, 
               (SELECT image_url FROM product_images WHERE product_id = p.id LIMIT 1) AS image
        FROM products p
        WHERE p.id = ?
    ");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


public function getPaginated($limit, $offset)
{
    $sql = "SELECT p.*, 
                   (SELECT image_url FROM product_images WHERE product_id = p.id LIMIT 1) AS image
            FROM products p
            ORDER BY id DESC
            LIMIT :limit OFFSET :offset";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getTotalCount()
{
    $stmt = $this->conn->query("SELECT COUNT(*) as total FROM products");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row['total'];
}

public function getRelatedProducts($categoryId, $excludeId)
{
    $stmt = $this->conn->prepare("
        SELECT p.*, 
               (SELECT image_url FROM product_images WHERE product_id = p.id LIMIT 1) AS image
        FROM products p
        WHERE p.category_id = ? AND p.id != ?
        LIMIT 4
    ");
    $stmt->execute([$categoryId, $excludeId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



    public function getVariantsByProductId($productId)
{
    $stmt = $this->conn->prepare("
        SELECT pv.*, s.name AS size_name, c.name AS color_name
        FROM product_variants pv
        JOIN sizes s ON pv.size_id = s.id
        JOIN colors c ON pv.color_id = c.id
        WHERE pv.product_id = ?
    ");
    $stmt->execute([$productId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Lấy danh sách tất cả size
public function getAllSizes()
{
    $stmt = $this->conn->query("SELECT * FROM sizes");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Lấy danh sách tất cả màu
public function getAllColors()
{
    $stmt = $this->conn->query("SELECT * FROM colors");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function getVariants($productId) {
    $sql = "SELECT * FROM product_variants WHERE product_id = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$productId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function getImagesByProductId($productId)
{
    $sql = "SELECT * FROM product_images WHERE product_id = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$productId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function getByCategoryId($categoryId)
{
    $stmt = $this->conn->prepare("
        SELECT p.*, 
               (SELECT image_url FROM product_images WHERE product_id = p.id LIMIT 1) AS image
        FROM products p
        WHERE p.category_id = ?
    ");
    $stmt->execute([$categoryId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function searchProducts($keyword)
{
    $sql = "SELECT p.*, 
                   (SELECT image_url FROM product_images WHERE product_id = p.id LIMIT 1) AS image
            FROM products p 
            WHERE p.name LIKE :keyword OR p.description LIKE :keyword";
    
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['keyword' => '%' . $keyword . '%']);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}
