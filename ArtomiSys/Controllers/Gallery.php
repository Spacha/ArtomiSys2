<?php

namespace ArtomiSys\Controllers;

use ArtomiSys\Libs\StaticPages;
use ArtomiSys\Libs\Statistics;
use ArtomiSys\Libs\View;

class Gallery extends StaticPages
{
	
	public function __construct()
	{
		$this->statistics = new Statistics();
		parent::__construct();
	}

	public function index()
	{
		// $this->statistics->set();
		$this->runPage('gallery', ['title' => 'Galleria']);
	}
}