<?php

/**
* TODO: Add Request class
* TODO: Some kind of system for internal routing maybe (Request)?
* TODO: Statistics: when static page loaded: $this->views->add();
* TODO: Restrict access to ArtomiSys/ folder directly
* TODO: Style some buttons
* TODO: Errors! and messages
* TODO: Sitemap.xml
*
* TODO: Consider using Font awesome to replace icons!
*
* password_verify(), password_salt()
* http://www.wikihow.com/Create-a-Secure-Login-Script-in-PHP-and-MySQL
*/

namespace ArtomiSys\Controllers\Dashboard;

use ArtomiSys\Models\Dashboard\IndexModel;
use ArtomiSys\Libs\Dashboard;
use ArtomiSys\Libs\Statistics;

class Index extends Dashboard
{
	private $model;

	public function __construct()
	{
		$this->model = new IndexModel();
		$this->statistics = new Statistics();
		parent::__construct();
	}

	// this is a custom index (defined in 'config/routes.php')
	public function home()
	{
		$data = [
			'title' => 'Hallintapaneeli',
			'username' => $_SESSION['username'],
			'stats' => $this->statistics->get()
		];

		$this->runPage('index/index', $data);
	}

	public function guide($page = 'guide')
	{
		$data = [
			'title' => 'Opas',
			'version' => $this->getData()['app']['version']
		];

		$this->runPage('index/guide/'.$page, $data);
	}
}