<?php
require_once 'models/BaseModel.php';

class CartModel extends BaseModel
{
    public function getCartByUser($userId)
    {
        $sql = "SELECT c.*, p.name, p.price, p.sale_price,
               (SELECT image_url FROM product_images WHERE product_id = c.product_id LIMIT 1) AS image
        FROM carts c
        JOIN products p ON c.product_id = p.id
        WHERE c.user_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addToCart($userId, $productId, $quantity = 1)
    {
        // Kiểm tra đã có sản phẩm chưa
        $stmt = $this->db->prepare("SELECT * FROM carts WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$userId, $productId]);
        $existing = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existing) {
            // Cập nhật số lượng
            $stmt = $this->db->prepare("UPDATE carts SET quantity = quantity + ? WHERE user_id = ? AND product_id = ?");
            return $stmt->execute([$quantity, $userId, $productId]);
        } else {
            // Thêm mới
            $stmt = $this->db->prepare("INSERT INTO carts (user_id, product_id, quantity) VALUES (?, ?, ?)");
            return $stmt->execute([$userId, $productId, $quantity]);
        }
    }

    public function remove($userId, $productId)
    {
        $stmt = $this->db->prepare("DELETE FROM carts WHERE user_id = ? AND product_id = ?");
        return $stmt->execute([$userId, $productId]);
    }
}
