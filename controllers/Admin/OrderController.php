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
      $statuses = OrderStatusEnum::keys();
      if (!in_array($status, $statuses)) {
        $_SESSION['error'] = 'Trạng thái không hợp lệ';
        header("Location: /admin/order/{$orderId}");
        exit;
      }

      // Update status
      $orderModel->updateStatus($orderId, $status);

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
}