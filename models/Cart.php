<?php
require_once 'models/BaseModel.php';

class Cart extends BaseModel
{
    public function addToCart($userId, $variantId, $quantity)
    {
        $sql = "INSERT INTO carts (user_id, variant_id, quantity)
                VALUES (:user_id, :variant_id, :quantity)
                ON DUPLICATE KEY UPDATE quantity = quantity + :quantity";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam('user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam('variant_id', $variantId, PDO::PARAM_INT);
        $stmt->bindParam('quantity', $quantity, PDO::PARAM_INT);
        return $stmt->execute();
    }

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

    public function remove($userId, $productId)
    {
        $stmt = $this->db->prepare("DELETE FROM carts WHERE user_id = ? AND product_id = ?");
        return $stmt->execute([$userId, $productId]);
    }
}
