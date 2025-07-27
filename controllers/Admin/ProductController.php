<?php
require './helpers/AuthHelper.php';

class ProductController
{
  public function __construct()
  {
    checkAdminLogin();
  }
}