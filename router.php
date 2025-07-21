<?php

$routes = [
  '^$' => ['Home', 'index'],
  '^login$' => ['Auth', 'login'],
  '^register$' => ['Auth', 'register']
];

$adminRoutes = [
  '^admin$' => ['Admin/Dashboard', 'index'],
];