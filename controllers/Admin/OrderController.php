<?php
require_once './helpers/ViewHelper.php';
require_once './helpers/AuthHelper.php';
require_once './models/Order.php';
require_once './models/OrderDetail.php';
require_once './enums/OrderStatusEnum.php';

class OrderController
{
  public function __construct()
  {
    checkAdminLogin();
  }

  public function index()
  {
    $orderModel = new Order();
    $orders = $orderModel->getDetailPaginated();
    require './views/admin/order/index.php';
  }

  public function detail($orderId)
  {
    $this->validateOrderId($orderId);

    $orderModel = new Order();
    $orderDetailModel = new OrderDetail();

    $order = $orderModel->getDetailById($orderId);
    $detail = $orderDetailModel->getDetailByOrderId($orderId);

    require './views/admin/order/detail.php';
  }

  public function status($orderId)
  {
    $this->validateOrderId($orderId);

    $orderModel = new Order();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $status = isset($_POST['status']) ? $_POST['status'] : null;

      // Validate
      $errors = $this->validateOrderStatus($orderId, $status);
      if (!empty($errors)) {
        $_SESSION['error'] = $errors[0];
        header("Location: /admin/order/{$orderId}");
        exit;
      }

      // Update status
      $order = $orderModel->getById($orderId);
      if ($order['status'] != $status) {
        $orderModel->updateStatus($orderId, $status);
      }

      $_SESSION['success'] = 'Cập nhật trạng thái thành công';
      header("Location: /admin/order/{$orderId}");
      exit;
    }
  }

  private function validateOrderId($orderId)
  {
    $orderModel = new Order();
    if (!$orderModel->isset($orderId)) {
      $_SESSION['error'] = 'Đơn hàng không tồn tại';
      header('Location: /admin/order');
      exit;
    }
  }

  private function validateOrderStatus($orderId, $status)
  {
    $orderModel = new Order();
    $order = $orderModel->getById($orderId);

    $errors = [];
    // Kiểm tra status đầu vào
    if (empty($status) || !in_array($status, OrderStatusEnum::keys()))
      $errors[] = 'Trạng thái không hợp lệ';
    // Không cho phép đổi trang thái nếu đã giao hàng thành công
    if ($order['status'] == OrderStatusEnum::RECEIVED)
      $errors[] = 'Không thể đổi trạng thái nếu đã giao hàng thành công';
    // Không cho phép đổi trang thái nếu đã huỷ
    if ($order['status'] == OrderStatusEnum::CANCELED)
      $errors[] = 'Không thể đổi trạng thái nếu đã huỷ';
    // Không cho phép quay lại trạng thái trước
    $statuses = OrderStatusEnum::keys();
    $orderStatusIdx = array_search($order['status'], $statuses);
    $newStatusIdx = array_search($status, $statuses);
    if ($newStatusIdx < $orderStatusIdx) {
      $errors[] = 'Không thể quay lại trạng thái trước';
    }

    return $errors;
  }
}