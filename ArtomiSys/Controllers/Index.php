<?php

/**
* TODO: add ExtendedController to handle logins etc
*/

namespace ArtomiSys\Controllers;

use ArtomiSys\Libs\Controller;
use ArtomiSys\Libs\Model;
use ArtomiSys\Models\IndexModel;

class Index extends Controller
{
	private $model;

	public function __construct()
	{
		$this->model = new IndexModel();
	}

	public function index()
	{
		echo "<li>Index";
	}

	public function guide()
	{
		echo "<li>We are in the guide";
	}
}