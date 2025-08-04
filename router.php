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
  'category/(\d+)' => ['Home', 'category'],
  'checkout' => ['Cart', 'checkout'],
  'about' => ['Home', 'about'],
  'contact' => ['Home', 'contact'],
];

$adminRoutes = [
  '^admin$' => ['Admin/Dashboard', 'index'],
  '^admin/category$' => ['Admin/Category', 'index'],
  '^admin/category/create$' => ['Admin/Category', 'create'],
  '^admin/category/(\d+)/edit$' => ['Admin/Category', 'edit'],
  '^admin/category/(\d+)/delete$' => ['Admin/Category', 'delete'],
  '^admin/product$' => ['Admin/Product', 'index'],
  '^admin/product/create$' => ['Admin/Product', 'create'],
  '^admin/product/(\d+)/edit$' => ['Admin/Product', 'edit'],
  '^admin/product/(\d+)/delete$' => ['Admin/Product', 'delete'],
  '^admin/product-image/(\d+)/delete$' => ['Admin/Product', 'deleteProductImage'],
  '^admin/attribute$' => ['Admin/Attribute', 'index'],
  '^admin/color/create$' => ['Admin/Attribute', 'createColor'],
  '^admin/color/(\d+)/edit$' => ['Admin/Attribute', 'editColor'],
  '^admin/color/(\d+)/delete$' => ['Admin/Attribute', 'deleteColor'],
  '^admin/size/create$' => ['Admin/Attribute', 'createSize'],
  '^admin/size/(\d+)/edit$' => ['Admin/Attribute', 'editSize'],
  '^admin/size/(\d+)/delete$' => ['Admin/Attribute', 'deleteSize'],
];
