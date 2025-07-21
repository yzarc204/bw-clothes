<?php

$routes = [
'' => ['Home', 'index'],
'index' => ['Home', 'index'],
'home' => ['Home', 'index'],
'product' => ['Home', 'products'],
'product/(\d+)' => ['Home', 'product'],
'category/(\d+)' => ['Category', 'index'],
'search' => ['Home', 'search'],
'shop' => ['Home', 'shop'],
'login' => ['User', 'login'],
'register' => ['User', 'register'],
'account' => ['User', 'account'],
'logout' => ['User', 'logout'],
'cart' => ['Cart', 'index'],
'cart/add/(\d+)' => ['Cart', 'addToCart'],
'cart/remove/(\d+)' => ['Cart', 'remove'],
'cart/update' => ['Cart', 'update'],
'about' => ['Home', 'about'],
'contact' => ['Home', 'contact'],
'checkout' => ['Cart', 'checkout'],



];

