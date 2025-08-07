<?php
require_once './models/Product.php';
require_once './models/Cart.php';
require_once './models/Variant.php';
require_once './models/BaseModel.php';
require_once './helpers/AuthHelper.php';
require_once './helpers/ViewHelper.php';
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
        SELECT c.*, p.name, p.price, p.sale_price,
            (SELECT image_url FROM product_images WHERE product_id = p.id LIMIT 1) AS image
        FROM carts c
        JOIN products p ON c.product_id = p.id
        WHERE c.user_id = ?
        ");
    $stmt->execute([$user['id']]);
    $cart = $stmt->fetchAll(PDO::FETCH_ASSOC);
    include 'views/client/Cart.php';
  }

  public function addToCart()
  {
    $cartModel = new Cart();
    $user = getCurrentUser();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $variantId = isset($_POST['variant_id']) ? $_POST['variant_id'] : null;
      $quantity = isset($_POST['quantity']) ? (int) $_POST['quantity'] : 1;

      $this->redirectIfValidationFailed($variantId, $quantity);
      $cartModel->addToCart($user['id'], $variantId, $quantity);

      header('Location: /cart');
      exit;
    }
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
      $qty = max(1, (int) $qty);

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
        SELECT c.*, p.name, p.price, p.sale_price,
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

  private function redirectIfValidationFailed($variantId, $quantity)
  {
    $variantModel = new Variant();

    $error = false;
    if (empty($variantId))
      $error = true;
    if (!$variantModel->isset($variantId))
      $error = true;
    if (!$quantity || !is_numeric($quantity) || $quantity <= 0)
      $error = true;

    if ($error) {
      header("Location: " . $_SERVER['HTTP_REFERER']);
      exit;
    }
  }
}
