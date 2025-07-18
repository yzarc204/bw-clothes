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

  public function setRoutes($routes)
  {
    $this->routes = $routes;
  }

  public function resolveRouter()
  {
    foreach ($this->routes as $pattern => $controller) {
      $pattern = '/^' . str_replace('/', '\/', $pattern) . '$/';
      if (preg_match($pattern, $this->url, $matches)) {
        $controllerName = $controller[0];
        $this->action = $controller[1];
        $this->params = array_slice($matches, 1);
        break;
      }
    }

    if (!$controllerName)
      die('404');

    $controllerName .= 'Controller';
    $controllerPath = './controllers/' . $controllerName . '.php';

    // Kiểm tra file có tồn tại hay không
    if (!file_exists($controllerPath)) {
      die('404');
    }
    require_once $controllerPath;

    if (!class_exists($controllerName))
      die('404');

    $this->controller = new $controllerName;

    if (!method_exists($this->controller, $this->action))
      die('404');
    call_user_func_array([$this->controller, $this->action], $this->params);
  }
}