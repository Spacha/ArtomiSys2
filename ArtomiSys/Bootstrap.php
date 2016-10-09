<?php

use ArtomiSys\Libs\Router;
use ArtomiSys\Libs\Log;
use ArtomiSys\Libs\UserError;



/*****************
*   INITIALIZE   *
*****************/


// Define root path
define('PATH_FILE_ROOT', dirname(__DIR__));
define('APP_ENV', 'development');

// include main config file
require(PATH_FILE_ROOT . '/ArtomiSys/config/config.php');

// set the timezone
date_default_timezone_set(DATE_DEFAULT_TIMEZONE);

// Autoload classes
spl_autoload_register(function($className) {
	$className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
	if (is_file(PATH_FILE_ROOT . '/' . $className . '.php')) {
        require(PATH_FILE_ROOT . '/' . $className . '.php');
    }
});



/************************
*   Handle Exceptions   *
************************/


set_exception_handler(function(Throwable $e) {
	die(var_dump($e));
	$message = false;
    
    if (get_class($e) == 'ArtomiSys\Exceptions\DatabaseException') {
        $message = $e->getMessage();
    }

    $error = new UserError($message);
    $error->show();
    Log::write(get_class($e) . ': ' . $e->getMessage() . ' in file ' . $e->getFile() . ' on line ' . $e->getLine(), 'ERROR');
    
    die();
});



/**************************
*   HANDLE URL REQUESTS   *
**************************/


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
	// throw new \Exception('Tried to call inexisting controller \''. $route['controller'] .'\'.');
	throw new UserError("Sivua ei löydy!", 404);
}