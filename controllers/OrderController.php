<?php
require_once './models/Order.php';
require_once './models/OrderDetail.php';
require_once './enums/OrderStatusEnum.php';
require_once './helpers/ViewHelper.php';
require_once './helpers/AuthHelper.php';

class OrderController
{
  public function __construct()
  {
    checkLogin();
  }

  public function index()
  {
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

    $orderModel = new Order();
    $user = getCurrentUser();
    $orders = $orderModel->getPaginatedByUserId($user['id'], $page, 10);
    require './views/client/order/index.php';
  }

  public function detail($orderId)
  {
    $user = getCurrentUser();
    $orderModel = new Order();
    $orderDetailModel = new OrderDetail();

    if (!$orderModel->isset($orderId)) {
      header('Location: /order');
      exit;
    }

    $order = $orderModel->getById($orderId);
    $detail = $orderDetailModel->getDetailByOrderId($orderId);

    require './views/client/order/detail.php';
  }

  public function cancel($orderId)
  {
    $orderModel = new Order();
    $user = getCurrentUser();

    // Validate
    if (!$orderModel->isOwnedByUser($orderId, $user['id'])) {
      header('Location: /order');
      exit;
    }
    $order = $orderModel->getById($orderId);
    if ($order['status'] == OrderStatusEnum::CANCELED || $order['status'] == OrderStatusEnum::DELIVERING || $order['status'] == OrderStatusEnum::RECEIVED) {
      header('Location: /order');
      exit;
    }

    $orderModel->updateStatus($orderId, OrderStatusEnum::CANCELED);
    header("Location: /order/{$orderId}");
    exit;
  }
}