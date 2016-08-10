<?php

namespace ArtomiSys\Controllers;

use ArtomiSys\Libs\Controller;
use ArtomiSys\Libs\Model;
use ArtomiSys\Models\IndexModel;

class Index extends Controller
{
	private $model;

	public function __construct()
	{
		echo "<li><b>Index controller</b>";
		// TODO: inpermanent solution
		$this->model = new IndexModel();
	}

	public function index()
	{
		echo "<li>Index page";
	}

	public function guide()
	{
		echo "<li>We are in guide";
	}
}