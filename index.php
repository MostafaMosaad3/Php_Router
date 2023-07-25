<?php

require 'vendor/autoload.php';

use Core\Router;
use Core\Request;

$router = Router::load('app/routes.php');

try {
    $uri = Request::uri();
    $requestType = Request::method();
    $router->direct($uri, $requestType);
} catch (Exception $e) {
    echo $e->getMessage();
}