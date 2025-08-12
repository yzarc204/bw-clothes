<?php
require_once './helpers/AuthHelper.php';
require_once './helpers/ViewHelper.php';
require_once './models/Statistics.php';

class DashboardController
{
  public function __construct()
  {
    checkAdminLogin();
  }

  public function index()
  {
    $statistics = new Statistics();

    $totalProduct = $statistics->getTotalProduct();
    $totalVariant = $statistics->getTotalVariant();
    $totalOrder = $statistics->getTotalOrder();
    $totalUser = $statistics->getTotalUser();

    $totalRevenue = $statistics->getTotalRevenue();
    $totalPurchasedProduct = $statistics->getTotalPurchasedProduct();
    $totalSuccessOrder = $statistics->getTotalSuccessOrder();
    $totalCancelOrder = $statistics->getTotalCancelOrder();

    require './views/admin/dashboard.php';
  }
}