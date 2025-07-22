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
}
