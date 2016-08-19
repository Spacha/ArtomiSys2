<?php

/**
* TODO: Add images
* TODO: Statistics: when static page loaded: $this->views->add();
* TODO: Restrict access to ArtomiSys/ folder directly
* TODO: Add working version info (login screen and others)
* TODO: Scale too big icons down
* TODO: Return button on view page
* TODO: Style some buttons
* TODO: Errors! and messages
* TODO: Some kind of system for internal routing maybe?
* TODO: Sitemap.xml
*
* password_verify(), password_salt()
* http://www.wikihow.com/Create-a-Secure-Login-Script-in-PHP-and-MySQL
*/

namespace ArtomiSys\Controllers\Dashboard;

use ArtomiSys\Models\Dashboard\IndexModel;
use ArtomiSys\Libs\Dashboard;

class Index extends Dashboard
{
	private $model;
	//private $view;

	public function __construct()
	{
		$this->model = new IndexModel();
		parent::__construct();
		//$this->view = new View();
	}

	// this is a custom index (defined in 'config/routes.php')
	public function home()
	{
		$data = [
			'title' => 'Hallintapaneeli',
			'username' => $_SESSION['username'],
			'stats' => $this->model->getStats()
		];

		$this->runPage('index/index', $data);
	}

	public function guide($a = 1, $b = 2, $c = 3)
	{
		$data = ['title' => 'Opas'];

		$this->runPage('index/guide', $data);
	}
}