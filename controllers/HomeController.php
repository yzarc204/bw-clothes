<?php

class HomeController
{
  public function index()
  {
    require './views/layouts/boyka/html_start.php';
    require './views/layouts/boyka/header.php';
    require './views/layouts/boyka/footer.php';
    require './views/layouts/boyka/html_end.php';
  }

  public function product($id)
  {
    echo 'Trang sản phẩm ' . $id;
  }


  public function search()
  {
    echo 'Trang search';
  }
}