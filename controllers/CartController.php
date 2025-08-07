<?php
require_once './models/Cart.php';
require_once './models/Variant.php';
require_once './models/Order.php';
require_once './models/OrderDetail.php';
require_once './helpers/AuthHelper.php';
require_once './helpers/ViewHelper.php';
class CartController
{
  public function __construct()
  {
    checkLogin();
  }

  public function index()
  {
    $userCart = getUserCart();
    include 'views/client/cart.php';
  }

  public function addToCart()
  {
    $cartModel = new Cart();
    $variantModel = new Variant();
    $user = getCurrentUser();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $variantId = isset($_POST['variant_id']) ? $_POST['variant_id'] : null;
      $quantity = isset($_POST['quantity']) ? (int) $_POST['quantity'] : 1;

      // Validate
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

      $cartModel->addToCart($user['id'], $variantId, $quantity);

      header('Location: /cart');
      exit;
    }
  }

  public function remove($cartId)
  {
    $user = getCurrentUser();
    $cartModel = new Cart();

    $error = false;
    if (empty($cartId))
      $error = true;
    if (!$cartModel->isOwnedByUser($cartId, $user['id']))
      $error = true;
    if ($error) {
      header('Location: /cart');
      exit;
    }

    $cartModel->delete($cartId);
    header('Location: /cart');
    exit;
  }

  public function update()
  {
    $cartModel = new Cart();
    $user = getCurrentUser();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : [];

      foreach ($quantity as $cartId => $qty) {
        // Validate
        if (empty($cartId) || !filter_var($cartId, FILTER_VALIDATE_INT))
          continue;
        if (!$cartModel->isOwnedByUser($cartId, $user['id']))
          continue;
        $cartModel->update($cartId, $qty);
      }

      header('Location: /cart');
      exit;
    }
  }

  public function checkout()
  {
    $userCart = getUserCart();
    if ($userCart['total_variants'] == 0) {
      header('Location: /cart');
      exit;
    }

    $orderModel = new Order();
    $orderDetailModel = new OrderDetail();
    $cartModel = new Cart();
    $user = getCurrentUser();

    $shippingFee = ($userCart['total_amount'] >= FREE_SHIPPING_THRESHOLD) ? 0 : SHIPPING_FEE;
    $vatAmount = round($userCart['total_amount'] * VAT_RATE);
    $totalAmount = $userCart['total_amount'] + $vatAmount + $shippingFee;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $customerName = isset($_POST['customer_name']) ? trim($_POST['customer_name']) : null;
      $phoneNumber = isset($_POST['phone_number']) ? trim($_POST['phone_number']) : null;
      $address = isset($_POST['address']) ? trim($_POST['address']) : null;

      // Validate
      $errors = [];
      if (empty($customerName))
        $errors[] = 'Tên khách hàng không được để trống.';
      if (strlen($customerName) < 3 || strlen($customerName) > 50)
        $errors[] = 'Tên khách hàng phải từ 3 đến 50 ký tự.';
      if (empty($phoneNumber))
        $errors[] = 'Số điện thoại không được để trống.';
      if (!preg_match('/^0[0-9]{9,10}$/', $phoneNumber))
        $errors[] = 'Số điện thoại không hợp lệ.';
      if (empty($address))
        $errors[] = 'Địa chỉ không được để trống.';
      if (strlen($address) > 255)
        $errors[] = 'Địa chỉ không được quá 255 ký tự.';

      if (!empty($errors)) {
        $_SESSION['error'] = $errors[0];
        header('Location: /checkout');
        exit;
      }

      // Tạo đơn hàng
      $orderId = $orderModel->create($user['id'], $userCart['total_amount'], $vatAmount, $shippingFee, $totalAmount, $customerName, $address, $phoneNumber);

      // Thêm chi tiết đơn hàng cho từng sản phẩm trong giỏ hàng
      foreach ($userCart['carts'] as $item) {
        $orderDetailModel->create(
          $orderId,
          $item['variant_id'],
          $item['product_name'],
          $item['size'],
          $item['color'],
          $item['price'],
          $item['featured_image'],
          $item['quantity'],
          $item['sub_total_amount']
        );
      }

      // Xoá cart
      $cartModel->deleteAllByUserId($user['id']);
    }

    require 'views/client/checkout.php';
  }
}
