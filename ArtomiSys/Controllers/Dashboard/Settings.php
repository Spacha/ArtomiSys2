<?php

/**
* Change password
* Set timezone
*/

namespace ArtomiSys\Controllers\Dashboard;

use ArtomiSys\Libs\Controller;

class Index extends Controller
{
	public function __construct()
	{
		echo "<li><b>Index controller</b>";
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