<?php

class HomeController
{
  public function index()
  {
    echo 'Trang chủ';
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