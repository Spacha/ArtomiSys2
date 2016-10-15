<?php

namespace ArtomiSys\Controllers;

use ArtomiSys\Libs\StaticPages;
use ArtomiSys\Libs\Statistics;
use ArtomiSys\Libs\View;

class Index extends StaticPages
{
	
	public function __construct()
	{
		$this->statistics = new Statistics();
		parent::__construct();
	}

	public function index()
	{
		// $this->statistics->set();
		$this->runPage('index', ['title' => 'Tervetuloa']);
	}
}