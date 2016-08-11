<?php

use ArtomiSys\Libs\Router;

// Define root path
define('PATH_ROOT', dirname(__DIR__));

// include main config file
require(PATH_ROOT . '/ArtomiSys/config/config.php');

// Autoload classes
spl_autoload_register(function($className) {
	$className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
	if (is_file(PATH_ROOT . '/' . $className . '.php')) {
        require(PATH_ROOT . '/' . $className . '.php');
    }
});

// Exceptions

/*
set_exception_handler(function($e) {
	die('<p><b>Error! </b>' . $e->getMessage() . '</p>' .
		'<p>Please contact support.</p>');
});
*/

// Url handling
$url = !empty($_GET["url"]) ? $_GET["url"] : null;
$router = new Router($url);
$route = $router->getRoute();

// Finally call a proper method
if (class_exists($route['controller'])) {
	$controller = new $route['controller']();

	// TODO: if method doesn't exist, call default
	if (!method_exists($controller, $route['action'])) {
		throw new \Exception('Tried to call inexisting method \''. $route['action'] .'\'.');
	}

	call_user_func_array([$controller, $route['action']], $route['paramArr']);
} else {
	throw new \Exception('Tried to call inexisting controller \''. $route['controller'] .'\'.');
}