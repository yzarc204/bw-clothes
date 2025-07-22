<?php
require_once './models/BaseModel.php';

class Product extends BaseModel
{
    public function getPaginated($page = 1, $limit = 8)
    {
        $totalProducts = $this->getTotalCount();
        $totalPages = ceil($totalProducts / $limit);

        $page = $page < 1 ? 1 : $page;
        $offset = ($page - 1) * $limit;
        $sql = "SELECT p.*, 
                   (SELECT image_url FROM product_images WHERE product_id = p.id LIMIT 1) AS image
            FROM products p
            ORDER BY id DESC
            LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            'items' => $products,
            'total_pages' => $totalPages,
            'total_items' => $totalProducts,
            'limit' => $limit,
            'page' => $page
        ];
    }

    public function getTotalCount()
    {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM products");
        $total = $stmt->fetchColumn();
        return $total;
    }

    public function getAll()
    {
        $sql = "SELECT p.*, 
                       (SELECT image_url FROM product_images WHERE product_id = p.id LIMIT 1) AS image
                FROM products p";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLimit($limit)
    {
        $limit = (int) $limit; // Ép kiểu tránh injection
        $sql = "SELECT p.*, 
                    (SELECT image_url FROM product_images WHERE product_id = p.id LIMIT 1) AS image
                FROM products p
                ORDER BY id DESC
                LIMIT $limit "; // chèn trực tiếp số
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getById($id)
    {
        $stmt = $this->db->prepare("
        SELECT p.*, 
               (SELECT image_url FROM product_images WHERE product_id = p.id LIMIT 1) AS image
        FROM products p
        WHERE p.id = ?
    ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getRelatedProducts($categoryId, $excludeId)
    {
        $stmt = $this->db->prepare("
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
        $stmt = $this->db->prepare("
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
        $stmt = $this->db->query("SELECT * FROM sizes");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy danh sách tất cả màu
    public function getAllColors()
    {
        $stmt = $this->db->query("SELECT * FROM colors");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getVariants($productId)
    {
        $sql = "SELECT * FROM product_variants WHERE product_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getImagesByProductId($productId)
    {
        $sql = "SELECT * FROM product_images WHERE product_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function searchProducts($keyword)
    {
        $sql = "SELECT p.*, 
                   (SELECT image_url FROM product_images WHERE product_id = p.id LIMIT 1) AS image
            FROM products p 
            WHERE p.name LIKE :keyword OR p.description LIKE :keyword";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['keyword' => '%' . $keyword . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
