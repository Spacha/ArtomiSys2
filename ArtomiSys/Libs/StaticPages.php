<?php

namespace ArtomiSys\Libs;

use ArtomiSys\Libs\View;

class StaticPages extends Controller
{
	public function __construct($template = 'default')
	{	
		$this->view = new View($template);
	}

	/**
	* Takes care of carrying data including title to view
	* Includes header snippet and sets active label
	*/
	public function runPage($path, array $data = [], $header = true)
	{
		$tmp = explode('/', $path);
		$section = $tmp[0];
		$page = end($tmp);
		
		$title = !isset($data['title']) ? ucfirst($page) : $data['title'];

		foreach($data as $key => $value) {
			if ($key !== 'title') $this->view->$key = $value;
		}

		// include header snippet
		if ($header) {
			$this->view->active = $section;
			$this->view->snippets['header'] = 'header';
		}
		
		$this->view->snippets['footer'] = 'footer';

		// Load correct css file
		$this->view->css = 'main.css';

		$this->view->title = 'Artomi Oy' . ' &ndash; '.$title;
		$this->view->render('_static/'.$path);
	}
}