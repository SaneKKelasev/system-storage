<?php

namespace Route;

class Router
{
    protected static array $routes = [];
    protected static array $route = [];

    public function __construct($routes)
    {
        foreach ($routes as $route)
        {
            $this->add($route);
        }
    }

    /**
     * добавляем роуты
     * @param array $route
     * @return void
     */
    public function add(array $urlList)
    {
        foreach ($urlList as $url => $method) {
            self::$routes[$url] = $method;
        }
    }

    public function getRoutes(): array
    {
        return self::$routes;
    }

    public function getRoute(): array
    {
        return self::$route;
    }

    public function dispatch($url, $method)
    {
        $params = explode('&', $url);
        $id = null;
        $url = $params[0];

        foreach ($params as $param) {
            if (str_contains($param, 'id')) {
                $id = explode('=', $param)[1];
            }
        }

        if (
            array_key_exists($url ,self::$routes) &&
            array_key_exists($method, self::$routes[$url])
        ) {
            $controller = 'App\Controller\\' . self::$routes[$url][$method];

            if ($url === '') {
                $url = 'HomePage';
            }

            $className = ucwords($url) . 'Controller';

            if (
                $url === 'login' ||
                $url === 'logout' ||
                $url === 'reset_password'
            ) {
                $className = 'UserController';
            }

            if ($id && is_numeric($id)) {
                $controller($id);
            } elseif (class_exists('App\Controller\\' . $className)) {
                $controller();
            } else {
                require_once WWW . '/404.php';
            }
        } else {
            require_once WWW . '/404.php';
        }

    }

}