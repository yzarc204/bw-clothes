<?php

class HomeController
{
  public function index()
  {
    $products = [
      [
        'id' => 1,
        'name' => 'Quần đùi',
        'price' => 100,
        'sale_price' => 50,
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ2sK-vCdQkyU7aXl7BE9FMrBuJfBCSNyAh0A&s'
      ],
      [
        'id' => 1,
        'name' => 'Quần đùi',
        'price' => 100,
        'sale_price' => 50,
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ2sK-vCdQkyU7aXl7BE9FMrBuJfBCSNyAh0A&s'
      ],
      [
        'id' => 1,
        'name' => 'Quần đùi',
        'price' => 100,
        'sale_price' => 50,
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ2sK-vCdQkyU7aXl7BE9FMrBuJfBCSNyAh0A&s'
      ]
    ];

    require './views/client/home.php';
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