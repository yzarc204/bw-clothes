<?php
require_once './helpers/AuthHelper.php';

class DashboardController
{
  public function __construct()
  {
    checkAdminLogin();
  }

  public function index()
  {
    require './views/layouts/adminlte/html_start.php';
    require './views/layouts/adminlte/header.php';
    require './views/layouts/adminlte/footer.php';
    require './views/layouts/adminlte/html_end.php';
  }
}