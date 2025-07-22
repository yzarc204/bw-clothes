<?php

$routes = [
  '^$' => ['Home', 'index'],
  '^login$' => ['Auth', 'login'],
  '^register$' => ['Auth', 'register'],
  '^shop$' => ['Home', 'shop'],
];

$adminRoutes = [
  '^admin$' => ['Admin/Dashboard', 'index'],
];

$categoryRoutes = [
  '^admin/category/create$' => ['Admin/Category', 'create'],
];