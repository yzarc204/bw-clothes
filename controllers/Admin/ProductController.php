<?php
require './helpers/AuthHelper.php';

class ProductController
{
  public function __construct()
  {
    checkAdminLogin();
  }

  public function create()
  {
    require './views/admin/product/create.php';
  }
}