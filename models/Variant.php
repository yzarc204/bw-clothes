<?php
require_once './models/BaseModel.php';

class Variant extends BaseModel
{

    public function create($productId, $colorId, $sizeId, $price, $salePrice)
    {
        $sql = "INSERT INTO product_variants (product_id, color_id, size_id, price, sale_price, stock_quantity) 
                VALUES (:product_id, :color_id, :size_id, :price, :sale_price, 0)";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam('product_id', $productId, PDO::PARAM_INT);
        $stmt->bindParam('size_id', $sizeId, PDO::PARAM_INT);
        $stmt->bindParam('color_id', $colorId, PDO::PARAM_INT);
        $stmt->bindParam('price', $price, PDO::PARAM_INT);
        $stmt->bindParam('sale_price', $salePrice, !empty($salePrice) ? PDO::PARAM_INT : PDO::PARAM_NULL);
        $stmt->execute();
        return $this->db->lastInsertId();
    }

    public function update($id, $productId, $colorId, $sizeId, $price, $salePrice)
    {
        $sql = "UPDATE product_variants SET 
                product_id = :product_id, 
                color_id = :color_id, 
                size_id = :size_id, 
                price = :price, 
                sale_price = :sale_price
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam('product_id', $productId, PDO::PARAM_INT);
        $stmt->bindParam('color_id', $colorId, PDO::PARAM_INT);
        $stmt->bindParam('size_id', $sizeId, PDO::PARAM_INT);
        $stmt->bindParam('price', $price, PDO::PARAM_INT);
        $stmt->bindParam('sale_price', $salePrice, !empty($salePrice) ? PDO::PARAM_INT : PDO::PARAM_NULL);
        $stmt->bindParam('id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function delete($id)
    {
        $sql = "DELETE FROM product_variants WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam('id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getDetailById($id)
    {
        $sql = "SELECT pv.*,
                c.name as color,
                s.name as size,
                pv.id as id
                FROM product_variants pv
                INNER JOIN colors c
                ON pv.color_id = c.id
                INNER JOIN sizes s
                ON pv.size_id = s.id
                WHERE pv.id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam('id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByDetail($productId, $colorId, $sizeId)
    {
        $sql = "SELECT * FROM product_variants 
                WHERE product_id = :product_id 
                AND color_id = :color_id 
                AND size_id = :size_id
                LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam('product_id', $productId, PDO::PARAM_INT);
        $stmt->bindParam('color_id', $colorId, PDO::PARAM_INT);
        $stmt->bindParam('size_id', $sizeId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getVariantsByProductId($productId)
    {
        $sql = "SELECT pv.*,
                c.name as color,
                s.name as size
                FROM product_variants as pv
                INNER JOIN sizes s
                ON s.id = pv.size_id
                INNER JOIN colors c
                ON c.id = pv.color_id
                WHERE pv.product_id = :product_id
                ORDER BY pv.id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam('product_id', $productId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy danh sách size theo sản phẩm
    public function getSizesByProductId($productId)
    {
        $sql = "SELECT DISTINCT s.id, s.size_name 
                FROM product_variants pv
                JOIN sizes s ON pv.size_id = s.id
                WHERE pv.product_id = ?";
        $stmt = $this->db->prepare($sql);
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
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Trong ProductModel hoặc VariantModel

    public function getAllSizes()
    {
        $stmt = $this->db->query("SELECT * FROM sizes");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllColors()
    {
        $stmt = $this->db->query("SELECT * FROM colors");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function isset($id)
    {
        $sql = "SELECT COUNT(*) FROM product_variants WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam('id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public function productVariantIsset($productId, $colorId, $sizeId)
    {
        $sql = "SELECT COUNT(*) FROM product_variants WHERE product_id = :product_id AND color_id = :color_id AND size_id = :size_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam('product_id', $productId, PDO::PARAM_INT);
        $stmt->bindParam('color_id', $colorId, PDO::PARAM_INT);
        $stmt->bindParam('size_id', $sizeId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
}
