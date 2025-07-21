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
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        $controllerName = null;

        foreach ($this->routes as $pattern => $controller) {
            $regex = '/^' . str_replace('/', '\/', $pattern) . '$/';
            if (preg_match($regex, $this->url, $matches)) {
                $controllerName = $controller[0];
                $this->action = $controller[1];
                $this->params = array_slice($matches, 1);
                break;
            }
        }

        if (!$controllerName) {
            die('404 - Không tìm thấy route phù hợp');
        }

        $controllerFile = './controllers/' . $controllerName . 'Controller.php';
        $controllerClass = $controllerName . 'Controller';

        if (!file_exists($controllerFile)) {
            die('404 - File controller không tồn tại');
        }

        require_once $controllerFile;

        if (!class_exists($controllerClass)) {
            die('404 - Class controller không tồn tại');
        }

        $this->controller = new $controllerClass();

        if (!method_exists($this->controller, $this->action)) {
            die('404 - Method trong controller không tồn tại');
        }

        call_user_func_array([$this->controller, $this->action], $this->params);
    }
}
