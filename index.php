<?php

$url = isset($_GET['url']) ? trim($_GET['url'], '/') : '';

// Định nghĩa các route, hỗ trợ regex
$routes = [
  '^$' => ['Home', 'index'], // Route gốc: /
  '^product$' => ['Home', 'products'], // Route: /product
  '^search$' => ['Home', 'search'], // Route: /search
  '^product/(\d+)$' => ['Home', 'product'], // Route: /product/123
  '^category/([a-zA-Z0-9-]+)$' => ['Home', 'category'], // Route: /category/abc
];

$controllerName = null;
$action = null;
$params = [];

foreach ($routes as $pattern => $controller) {
  $pattern = '/^' . str_replace('/', '\/', $pattern) . '$/';
  if (preg_match($pattern, $url, $matches)) {
    $controllerName = $controller[0];
    $action = $controller[1];
    $params = array_slice($matches, 1);
    break;
  }
}

if (!$controllerName)
  die('404');
$controllerName .= 'Controller';
$controllerPath = './controllers/' . $controllerName . '.php';
if (!file_exists($controllerPath)) {
  die('404');
}
require_once $controllerPath;
if (!class_exists($controllerName))
  die('404');
$controller = new $controllerName;
if (!method_exists($controller, $action))
  die('404');
call_user_func_array([$controller, $action], $params);