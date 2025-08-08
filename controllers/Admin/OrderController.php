<?php
require_once './helpers/AuthHelper.php';

class OrderController
{
  public function __construct()
  {
    checkAdminLogin();
  }
}