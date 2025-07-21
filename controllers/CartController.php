<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once 'models/ProductModel.php';

require_once 'models/Database.php';
require_once 'models/ProductModel.php';

class CartController
{
    private $conn;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $this->conn = (new DBConnect())->getConnection();
    }

    public function index()
    {
        $userId = $_SESSION['user']['id'] ?? null;
        if (!$userId) die('Bạn cần đăng nhập để xem giỏ hàng.');

        $stmt = $this->conn->prepare("
            SELECT c.*, p.name, p.price, 
                   (SELECT image_url FROM product_images WHERE product_id = p.id LIMIT 1) AS image
            FROM carts c
            JOIN products p ON c.product_id = p.id
            WHERE c.user_id = ?
        ");
        $stmt->execute([$userId]);
        $cart = $stmt->fetchAll(PDO::FETCH_ASSOC);

        include 'views/cart.php';
    }

    public function addToCart($productId)
    {
        $userId = $_SESSION['user']['id'] ?? null;
        if (!$userId) {
                header("Location: /bw-clothes/index.php?url=login");
        }

        // Kiểm tra xem sản phẩm đã tồn tại trong giỏ chưa
        $stmt = $this->conn->prepare("SELECT * FROM carts WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$userId, $productId]);
        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($item) {
            // Nếu có rồi → cập nhật quantity
            $this->conn->prepare("UPDATE carts SET quantity = quantity + 1 WHERE id = ?")
                       ->execute([$item['id']]);
        } else {
           // Giả sử bạn có $userId và $productId
$stmt = $this->conn->prepare("INSERT INTO carts (user_id, product_id, quantity) VALUES (?, ?, ?)");
$stmt->execute([$userId, $productId, 1]);


        }

        header("Location: /bw-clothes/cart");
        exit;
    }

public function remove($productId)
{
    $userId = $_SESSION['user']['id'] ?? null;
    if (!$userId) die('Bạn cần đăng nhập.');

    $stmt = $this->conn->prepare("DELETE FROM carts WHERE user_id = ? AND product_id = ?");
    $stmt->execute([$userId, $productId]);

    header("Location: /bw-clothes/index.php?url=cart");
    exit;
}

    public function update()
{
    foreach ($_POST['quantities'] as $productId => $qty) {
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['quantity'] = max(1, (int)$qty);
        }
    }
    header("Location: /bw-clothes/cart");
    exit;
}
public function checkout()
{
    $userId = $_SESSION['user']['id'] ?? null;
    if (!$userId) die('Bạn cần đăng nhập để thanh toán.');

    // Lấy giỏ hàng
    $stmt = $this->conn->prepare("
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
$customerName = $_POST['customer_name'] ?? null;
$phone = $_POST['phone_number'] ?? null;
$address = $_POST['address'] ?? null;

if (!$customerName || !$phone || !$address) {
    die('Vui lòng điền đầy đủ thông tin.');
}



        // Tính tổng tiền
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // 1. Thêm vào bảng orders (phù hợp với cấu trúc bạn gửi)
        $stmt = $this->conn->prepare("
            INSERT INTO orders (user_id, customer_name, phone_number, address, total_amount, created_at)
            VALUES (?, ?, ?, ?, ?, NOW())
        ");
        $stmt->execute([$userId, $customerName, $phone, $address, $total]);

        $orderId = $this->conn->lastInsertId();

        // 2. Thêm vào bảng order_details
        foreach ($cart as $item) {
            $totalAmount = $item['price'] * $item['quantity'];
            $stmt = $this->conn->prepare("
                INSERT INTO order_details (order_id, product_id, product_name, product_image, quantity, price, total_amount)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $orderId,
                $item['product_id'],
                $item['name'],                          // ← tên sản phẩm
                $item['image'],                         // ← ảnh sản phẩm
                $item['quantity'],
                $item['price'],
                $totalAmount
            ]);
        }
        // 3. Xóa giỏ hàng
        $this->conn->prepare("DELETE FROM carts WHERE user_id = ?")->execute([$userId]);

        // 4. Chuyển trang hoặc thông báo thành công
        header("Location: /bw-clothes/");
        exit;
    }

    include 'views/checkout.php';
}


}
