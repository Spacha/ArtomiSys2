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
	
	private $request = array(
		'controller' => '',
		'action' => '',
		'paramArr' => []);

	// private $urlRoutes = ROOT_PATH . '/config/routes.php';


	public function __construct($url)
	{
		$this->setRoute($url ? $url : null);
	}
	
	/*
	private function routeUrl($url)
	{
		$routes = require($this->urlRoutes);

		foreach($routes as $route) {
			if () {

			}
		}
	}
	*/

	private function setRoute($url = null)
	{
		$urlParts = array();
		
		if (isset($url)) {
			$url = rtrim($url, "/");
			$urlParts = explode("/", $url);
		}
		
		// Set given controller if exists, otherwise set default controller
		$this->request['controller'] = isset($urlParts[0])
			? self::CONTROLLER_NS.ucfirst($urlParts[0])
			: self::CONTROLLER_NS.self::DEFAULT_CONTROLLER;
		$this->request['action'] = isset($urlParts[1])
			? $urlParts[1]
			: self::DEFAULT_ACTION;
		
		// Push arguments into an array
		for($i = 2; $i < count($urlParts); $i++) {
			array_push($this->request['paramArr'], $urlParts[$i]);
		}
	}
	
	public function getRoute()
	{
		return $this->request;
	}
}
