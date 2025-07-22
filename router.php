<?php

$routes = [
  '^$' => ['Home', 'index'],
  '^login$' => ['Auth', 'login'],
  '^register$' => ['Auth', 'register'],
  '^shop$' => ['Home', 'shop'],
  'product/(\d+)' => ['Home', 'product'],
  'cart' => ['Cart', 'index'],
  'cart/add/(\d+)' => ['Cart', 'addToCart'],
  'cart/remove/(\d+)' => ['Cart', 'remove'],
  'cart/update' => ['Cart', 'update'],
  'search' => ['Home', 'search'],
];

$adminRoutes = [
  '^admin$' => ['Admin/Dashboard', 'index'],
];