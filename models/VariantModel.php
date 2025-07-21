<?php
require_once 'BaseModel.php';

class VariantModel extends BaseModel
{
    // Lấy danh sách variant (màu + size) theo sản phẩm
    public function getVariantsByProductId($productId)
    {
        $sql = "SELECT pv.*, 
                       s.size_name AS size_name, 
                       c.color_name AS color_name 
                FROM product_variants pv
                INNER JOIN sizes s ON pv.size_id = s.id
                INNER JOIN colors c ON pv.color_id = c.id
                WHERE pv.product_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy danh sách size theo sản phẩm
    public function getSizesByProductId($productId)
    {
        $sql = "SELECT DISTINCT s.id, s.size_name 
                FROM product_variants pv
                JOIN sizes s ON pv.size_id = s.id
                WHERE pv.product_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy danh sách màu theo sản phẩm
    public function getColorsByProductId($productId)
    {
        $sql = "SELECT DISTINCT c.id, c.color_name 
                FROM product_variants pv
                JOIN colors c ON pv.color_id = c.id
                WHERE pv.product_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Trong ProductModel hoặc VariantModel

public function getAllSizes()
{
    $stmt = $this->conn->query("SELECT * FROM sizes");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getAllColors()
{
    $stmt = $this->conn->query("SELECT * FROM colors");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}
