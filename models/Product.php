<?php
require_once './models/BaseModel.php';

class Product extends BaseModel
{
    public function getPaginated($limit, $offset)
    {
        $sql = "SELECT p.*, 
                   (SELECT image_url FROM product_images WHERE product_id = p.id LIMIT 1) AS image
            FROM products p
            ORDER BY id DESC
            LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalCount()
    {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM products");
        $total = $stmt->fetchColumn();
        return $total;
    }
}
