<?php

$routes = [
  // Auth router
  '^$' => ['Home', 'index'],
  '^login$' => ['Auth', 'login'],
  '^register$' => ['Auth', 'register'],
  '^logout$' => ['Auth', 'logout'],
  // Shop router
  '^shop$' => ['Home', 'shop'],
  '^category/(\d+)$' => ['Home', 'category'],
  '^search$' => ['Home', 'search'],
  // Other pages router
  '^about$' => ['Home', 'about'],
  '^contact$' => ['Home', 'contact'],
  '^product/(\d+)$' => ['Home', 'product'],
  // Cart router
  '^cart$' => ['Cart', 'index'],
  '^cart/add$' => ['Cart', 'addToCart'],
  '^cart/remove/(\d+)$' => ['Cart', 'remove'],
  '^cart/update$' => ['Cart', 'update'],
  // Checkout router
  '^checkout$' => ['Cart', 'checkout'],
  // Order router
  '^order$' => ['Order', 'index'],
  '^order/(\d+)$' => ['Order', 'detail'],
  '^order/(\d+)/cancel$' => ['Order', 'cancel'],
];

$adminRoutes = [
  // Dashboard router
  '^admin$' => ['Admin/Dashboard', 'index'],
  // Category router
  '^admin/category$' => ['Admin/Category', 'index'],
  '^admin/category/create$' => ['Admin/Category', 'create'],
  '^admin/category/(\d+)/edit$' => ['Admin/Category', 'edit'],
  '^admin/category/(\d+)/delete$' => ['Admin/Category', 'delete'],
  // Product router
  '^admin/product$' => ['Admin/Product', 'index'],
  '^admin/product/(\d+)$' => ['Admin/Product', 'detail'],
  '^admin/product/create$' => ['Admin/Product', 'create'],
  '^admin/product/(\d+)/edit$' => ['Admin/Product', 'edit'],
  '^admin/product/(\d+)/delete$' => ['Admin/Product', 'delete'],
  // Product image router
  '^admin/product-image/(\d+)/delete$' => ['Admin/Product', 'deleteProductImage'],
  // Variant router
  '^admin/product/(\d+)/variant' => ['Admin/Variant', 'product'],
  '^admin/variant/create$' => ['Admin/Variant', 'create'],
  '^admin/variant/bulk/create$' => ['Admin/Variant', 'bulkCreate'],
  '^admin/variant/(\d+)/edit$' => ['Admin/Variant', 'edit'],
  '^admin/variant/(\d+)/delete$' => ['Admin/Variant', 'delete'],
  // Attribute router
  '^admin/attribute$' => ['Admin/Attribute', 'index'],
  '^admin/color/create$' => ['Admin/Attribute', 'createColor'],
  '^admin/color/(\d+)/edit$' => ['Admin/Attribute', 'editColor'],
  '^admin/color/(\d+)/delete$' => ['Admin/Attribute', 'deleteColor'],
  '^admin/size/create$' => ['Admin/Attribute', 'createSize'],
  '^admin/size/(\d+)/edit$' => ['Admin/Attribute', 'editSize'],
  '^admin/size/(\d+)/delete$' => ['Admin/Attribute', 'deleteSize'],
  // Order router
  '^admin/order$' => ['Admin/Order', 'index'],
];
