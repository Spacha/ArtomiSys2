<?php

namespace ArtomiSys\Libs;

use ArtomiSys\Libs\View;

class Dashboard extends Controller
{
	protected $requireLogin = true;

	public function __construct($template = 'default')
	{
		$this->checkAuth();
		
		$this->view = new View($template);
	}

	/**
	* Takes care of carrying data including title to view
	* Includes header snippet and sets active label
	*/
	public function runPage($path, array $data, $header = true)
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
			$this->view->snippets['header'] = 'dashboard/header';
		}

		// Load correct css file
		$this->view->css = 'dashboard.css';

		$this->view->title = APP_NAME . ' &ndash; '.$title;
		$this->view->render('dashboard/'.$path);
	}

	// rethink about naming and move to Statistics!
	public function getData(array $data = [])
	{
		// DON'T HARDCODE
		return require(PATH_FILE_ROOT .'/ArtomiSys/data/artomisys.php');
	}

	// for login
	private function checkAuth()
	{
		$this->startSession();

		if ($this->requireLogin) {
			if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
				header('location: '. ROOT_DIR .'/dashboard/login');
				return false;
			}
		}

		return true;
	}

	private function startSession(array $options = [])
	{
		session_set_cookie_params(0);
		session_start($options);
	}
}