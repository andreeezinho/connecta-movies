<?php

namespace App\Config;

use App\Request\Request;
use App\Config\Auth;
use App\Config\Admin;

class Router {

    protected $routers = [];
    protected $auth = null;
    protected $admin = null;

    public function create(string $method, string $path, callable $callback, Auth $auth = null, Admin $admin = null){
        $normalizedPath = $this->normalizePath($path);

        $this->routers[$method][$normalizedPath] = [
            'callback' => $callback,
            'auth' => $auth,
            'admin' => $admin
        ];
    }

    public function init(){
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = $_SERVER['REQUEST_URI'];
        $request = new Request();

        $normalizedRequestUri = $this->normalizePath($requestUri);
        $normalizedRequestUri = rtrim($normalizedRequestUri, '/');

        if(isset($this->routers[$httpMethod])){
            foreach($this->routers[$httpMethod] as $path => $route){
                $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([^/]+)', $path);
                $pattern = '/^' . str_replace('/', '\/', $pattern) . '\/?$/';

                if(preg_match($pattern, $normalizedRequestUri, $matches)){
                    if(!is_null($route['auth']) && !$route['auth']->check()){
                        $_SESSION['attempted_uri'] = ltrim($normalizedRequestUri, '/');

                        return $this->view('login/login', [
                            'erro' => 'Faça login para continuar'
                        ]);
                    }

                    if(!is_null($route['admin']) && !$route['admin']->check()){
                        return $this->redirect('404');
                    }

                    array_shift($matches);
                    return call_user_func_array($route['callback'], array_merge([$request], $matches));
                }
            }
        }

        http_response_code(404);
        $this->redirect('404');
    }

    private function normalizePath($path){
        return rtrim(parse_url($path, PHP_URL_PATH), '/');
    }

    public function view(string $viewName, array $data = []){
        extract($data);
        require_once __DIR__ . '/../Resources/Views/' . $viewName . '.php';
    }

    public function redirect(string $page){
        $url = URL_SITE . '/' . $page;
        header("Location: $url");
        exit();
    }
}