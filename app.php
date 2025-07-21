<?php

class App
{
  private $url;
  private $controller = null;
  private $action = null;
  private $params = [];
  private $routes = [];

  public function __construct()
  {
    $this->url = isset($_GET['url']) ? trim($_GET['url'], '/') : '';
  }

  public function addRoutes($routes)
  {
    $this->routes = array_merge($this->routes, $routes);
  }

  public function resolveRouter()
  {
    $controllerName = null;

    foreach ($this->routes as $pattern => $controller) {
      $pattern = '/^' . str_replace('/', '\/', $pattern) . '$/';
      if (preg_match($pattern, $this->url, $matches)) {
        [$controllerName, $this->action] = $controller;
        $this->params = array_slice($matches, 1);
        break;
      }
    }

    if (!$controllerName)
      die('404');

    $controllerName .= 'Controller';
    $controllerPath = './controllers/' . $controllerName . '.php';
    if (!file_exists($controllerPath)) {
      die('404! Controller file not found');
    }
    require_once $controllerPath;

    $controllerNameParts = explode('/', $controllerName);
    $controllerName = array_pop($controllerNameParts);
    if (!class_exists($controllerName))
      die('404! Controller not existed');
    $this->controller = new $controllerName;

    if (!method_exists($this->controller, $this->action))
      die('404! Action not existed');
    call_user_func_array([$this->controller, $this->action], $this->params);
  }
}