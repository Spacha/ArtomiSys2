<?php

namespace ArtomiSys\Libs;

use ArtomiSys\Libs\View;

class Dashboard extends Controller
{
	public function __construct()
	{
		$this->view = new View();
	}

	/**
	* Takes care of carrying data including title to view
	* Includes header snippet and sets active label
	*/
	public function runPage($path, array $data)
	{
		$tmp = explode('/', $path);
		$section = $tmp[0];
		$page = end($tmp);
		
		$title = !isset($data['title']) ? ucfirst($page) : $data['title'];

		foreach($data as $key => $value) {
			if ($key !== 'title') $this->view->$key = $value;
		}

		$this->view->title = APP_NAME . ' &ndash; '.$title;
		$this->view->active = $section;
		$this->view->snippets['header'] = 'dashboard/header';
		$this->view->render('dashboard/'.$path);
	}
}