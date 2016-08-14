<?php

/**
* TODO: add ExtendedController to handle logins etc.
* TODO: Maybe we should have DashboardController which would take care of things like
* automatic snippets, title skeleton etc.
* TODO: Add images
* TODO: Some kind of system for internal routing maybe?
*/

namespace ArtomiSys\Controllers\Dashboard;

use ArtomiSys\Models\Dashboard\IndexModel;
use ArtomiSys\Libs\Controller;
use ArtomiSys\Libs\View;

class Index extends Controller
{
	private $model;
	private $view;

	public function __construct()
	{
		$this->model = new IndexModel();
		$this->view = new View();
	}

	// this is a custom index (defined in 'config/routes.php')
	public function home()
	{
		$this->view->stats = $this->model->getStats();

		$this->view->title = APP_NAME . ' &ndash; Dashboard';
		$this->view->active = 'index';
		$this->view->snippets['header'] = 'dashboard/header';
		$this->view->render('dashboard/index/index');
	}

	public function guide($a = 1, $b = 2, $c = 3)
	{
		echo "<li>We are in the guide";
		echo '<br>'.$a.$b.$c;
	}
}