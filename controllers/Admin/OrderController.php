<?php
require_once './helpers/ViewHelper.php';
require_once './helpers/AuthHelper.php';
require_once './models/Order.php';

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
}