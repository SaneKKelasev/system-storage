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
        $url = $params[0];

        if (
            array_key_exists($url ,self::$routes) &&
            array_key_exists($method, self::$routes[$url])
        ) {
            $controller = 'App\Controller\\' . self::$routes[$url][$method];

            if ($url === '') {
                $url = 'HomePage';
            }

            if (str_contains($url, '/')) {
                $url = implode('\\', array_map(fn($url) => ucwords($url), explode('/', $url)));
            }

            $className = ucwords($url) . 'Controller';

            if (
                $url === 'login' ||
                $url === 'logout' ||
                $url === 'reset_password'
            ) {
                $className = 'UserController';
            }

            if (class_exists('App\Controller\\' . $className)) {
                $controller();
            } else {
                require_once WWW . '/404.php';
            }
        } else {
            require_once WWW . '/404.php';
        }

    }

}