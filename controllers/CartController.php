<?php
require_once 'models/Product.php';
require_once 'models/BaseModel.php';
require_once 'helpers/AuthHelper.php';
class CartController extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        checkLogin();
    }

    public function index()
    {
        $user = getCurrentUser();
        $stmt = $this->db->prepare("
            SELECT c.*, p.name, p.price, 
                   (SELECT image_url FROM product_images WHERE product_id = p.id LIMIT 1) AS image
            FROM carts c
            JOIN products p ON c.product_id = p.id
            WHERE c.user_id = ?
        ");
        $stmt->execute([$user['id']]);
        $cart = $stmt->fetchAll(PDO::FETCH_ASSOC);
        include 'views/client/Cart.php';
    }

    public function addToCart($productId)
    {
        $user = getCurrentUser();
        // Kiểm tra xem sản phẩm đã tồn tại trong giỏ chưa
        $stmt = $this->db->prepare("SELECT * FROM carts WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$user['id'], (int)$productId]);
        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($item) {
            // Nếu có rồi → cập nhật quantity
            $this->db->prepare("UPDATE carts SET quantity = quantity + 1 WHERE id = ?")
                ->execute([$item['id']]);
        } else {
            // Giả sử bạn có $userId và $productId
            $stmt = $this->db->prepare("INSERT INTO carts (user_id, product_id, quantity) VALUES (?, ?, 1)")->execute([$user['id'], $productId]);
        }

        header("Location: /cart");
        exit;
    }

    public function remove($productId)
    {
        $user = getCurrentUser();

        $stmt = $this->db->prepare("DELETE FROM carts WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$user['id'], $productId]);

        header("Location: /cart");
        exit;
    }

    public function update()
    {
        $user = getCurrentUser();
        $userId = $user['id'];
        foreach ($_POST['quantities'] as $productId => $qty) {
            $qty = max(1, (int)$qty);

            $stmt = $this->db->prepare("
                INSERT INTO carts (user_id, product_id, quantity)
                VALUES (:user_id, :product_id, :quantity)
                ON DUPLICATE KEY UPDATE quantity = :quantity
            ");
            $stmt->execute([
                ':user_id' => $userId,
                ':product_id' => $productId,
                ':quantity' => $qty
            ]);
        }

        header("Location: /cart");
        exit;
    }

    public function checkout()
    {
        $user = getCurrentUser();
        $userId = $user['id'];

        // Lấy giỏ hàng
        $stmt = $this->db->prepare("
        SELECT c.*, p.name, p.price, 
               (SELECT image_url FROM product_images WHERE product_id = p.id LIMIT 1) AS image
        FROM carts c
        JOIN products p ON c.product_id = p.id
        WHERE c.user_id = ?
    ");
        $stmt->execute([$userId]);
        $cart = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy thông tin từ form
            $customerName = $_POST['customer_name'] ?? '';
            $phone = $_POST['phone_number'] ?? '';
            $address = $_POST['address'] ?? '';

            if (empty($customerName) || empty($phone) || empty($address)) {
                die('Vui lòng điền đầy đủ thông tin.');
            }

            if (empty($cart)) {
                die('Giỏ hàng rỗng.');
            }

            // Tính tổng tiền
            $total = 0;
            foreach ($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            // 1. Thêm vào bảng orders
            $stmt = $this->db->prepare("
            INSERT INTO orders (user_id, customer_name, phone_number, address, total_amount, created_at)
            VALUES (?, ?, ?, ?, ?, NOW())
        ");
            $stmt->execute([$userId, $customerName, $phone, $address, $total]);

            $orderId = $this->db->lastInsertId();

            // 2. Thêm vào bảng order_details
            $stmt = $this->db->prepare("
            INSERT INTO order_details (order_id, product_id, product_name, product_image, quantity, price, total_amount)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
            foreach ($cart as $item) {
                $totalAmount = $item['price'] * $item['quantity'];
                $stmt->execute([
                    $orderId,
                    $item['product_id'],
                    $item['name'],
                    $item['image'],
                    $item['quantity'],
                    $item['price'],
                    $totalAmount
                ]);
            }

            // 3. Xóa giỏ hàng
            $this->db->prepare("DELETE FROM carts WHERE user_id = ?")->execute([$userId]);

            // 4. Chuyển hướng
            header("Location: /cart?success=1");
            exit;
        }

        include 'views/client/checkout.php';
    }
}
