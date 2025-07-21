<?php
require_once 'models/Database.php';

class CartModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = (new DBConnect())->getConnection();
    }

    public function getCartByUser($userId)
    {
        $sql = "SELECT c.*, p.name, p.price, 
                       (SELECT image_url FROM product_images WHERE product_id = c.product_id LIMIT 1) AS image
                FROM carts c
                JOIN products p ON c.product_id = p.id
                WHERE c.user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addToCart($userId, $productId, $quantity = 1)
    {
        // Kiểm tra đã có sản phẩm chưa
        $stmt = $this->conn->prepare("SELECT * FROM carts WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$userId, $productId]);
        $existing = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existing) {
            // Cập nhật số lượng
            $stmt = $this->conn->prepare("UPDATE carts SET quantity = quantity + ? WHERE user_id = ? AND product_id = ?");
            return $stmt->execute([$quantity, $userId, $productId]);
        } else {
            // Thêm mới
            $stmt = $this->conn->prepare("INSERT INTO carts (user_id, product_id, quantity) VALUES (?, ?, ?)");
            return $stmt->execute([$userId, $productId, $quantity]);
        }
    }

    public function remove($userId, $productId)
    {
        $stmt = $this->conn->prepare("DELETE FROM carts WHERE user_id = ? AND product_id = ?");
        return $stmt->execute([$userId, $productId]);
    }
}
