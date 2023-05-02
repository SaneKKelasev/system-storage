<?php

require_once dirname(__DIR__) . '/config/init.php';
require_once CONFIG . '/routes.php';

use Route\Router;

$query = trim(urldecode($_SERVER['QUERY_STRING']), '/');
$method = $_SERVER['REQUEST_METHOD'];

$router = new Router($urlList);
$router->dispatch($query, $method);
