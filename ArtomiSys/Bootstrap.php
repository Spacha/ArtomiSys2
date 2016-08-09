<?php

use ArtomiSys\Libs\Router;

// Define root path
define('ROOT_PATH', dirname(__DIR__));

// Autoload classes
spl_autoload_register(function($className) {
	$className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
	if (is_file(ROOT_PATH . '/' . $className . '.php')) {
        require(ROOT_PATH . '/' . $className . '.php');
    }
});

// Exceptions
set_exception_handler(function(Exception $e) {
	die('<b>Error! </b>' . $e->getMessage());
});

// Url handling
$url = !empty($_GET["url"]) ? $_GET["url"] : null;
$router = new Router($url);
$route = $router->getRoute();

// Finally call a proper method
if (class_exists($route['controller'])) {
	$controller = new $route['controller']();
	call_user_func_array([$controller, $route['action']], $route['paramArr']);
}

if (!isset($controller)) {
	throw new \Exception("Error Processing Request", 1);
}