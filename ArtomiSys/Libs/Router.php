<?php

/**
* 
* TODO:	
* Translate url if it's localized
* Validate url
* 
*/

namespace ArtomiSys\Libs;

class Router
{
	// Defines controllers' namespace
	const CONTROLLER_NS = 'ArtomiSys\Controllers\\';
	const DEFAULT_CONTROLLER = 'Index';
	const DEFAULT_ACTION = 'index';
	
	private $customIndex;
	private $subControllers = array();

	private  $request = array(
		'controller' => '',
		'action' => '',
		'paramArr' => []);

	// private $urlRoutes = ROOT_PATH . '/config/routes.php';


	public function __construct($url)
	{
		$this->subControllers = $this->findSubControllers();
		$this->setRoute($url ? $url : null);
	}

	private function setRoute($url = null)
	{
		$urlParts = array();

		if (isset($url)) {
			$url = rtrim($url, "/");
			$urlParts = explode("/", $url);
		}
		
		$i = 0;

		// maybe this should be clearified a bit?
		if (isset($urlParts[$i]) && in_array(ucfirst($urlParts[$i]), $this->subControllers)) {
			$this->request['controller'] = isset($urlParts[$i]) && isset($urlParts[$i+1])
				? self::CONTROLLER_NS.ucfirst($urlParts[$i]).'\\'.ucfirst($urlParts[$i+1])
				: self::CONTROLLER_NS.ucfirst($urlParts[$i]).'\\'.self::DEFAULT_CONTROLLER;
			$i++;
		} else {
			$this->request['controller'] = isset($urlParts[$i])
				? self::CONTROLLER_NS.ucfirst($urlParts[$i])
				: self::CONTROLLER_NS.self::DEFAULT_CONTROLLER;
		}

		$i++;

		// defining action (method)
		$this->request['action'] = isset($urlParts[$i])
			? $urlParts[$i]
			: $this->getDefaultIndex($this->request['controller']);
		
		// Push the rest into an array as arguments
		for($j = ++$i; $j < count($urlParts); $j++) {
			array_push($this->request['paramArr'], $urlParts[$j]);
		}
	}
	
	public function getRoute()
	{
		return $this->request;
	}

	private function getDefaultIndex($controller)
	{
		$routes = require(PATH_ROOT .'/'. APP_NAME .'/config/routes.php');
		$controller = str_replace(self::CONTROLLER_NS, '', $controller);

		if (isset($routes['customIndexes'][$controller])) {
			return $routes['customIndexes'][$controller];
		} else {
			return self::DEFAULT_ACTION;
		}
	}

	private function findSubControllers()
	{
		$path = PATH_ROOT .'/'. APP_NAME .'/Controllers/';
		$scanResults = scandir($path);
		$results = array();

		foreach($scanResults as $scanResult) {
			// dismiss fake directories and add real ones to an array
			if ($scanResult === '.' || $scanResult === '..') continue; 
			if (is_dir($path .'/'. $scanResult)) array_push($results, ucfirst($scanResult));
		}

		return $results;
	}
}
