<?php

namespace ArtomiSys\Controllers\Dashboard;

use ArtomiSys\Libs\Dashboard;
use ArtomiSys\Models\Dashboard\LoginModel;

class Login extends Dashboard
{
	private $model;

	public function __construct()
	{
		$this->model = new LoginModel();

		// login is not required on login page (obviously)
		// note that we don't use default template!
		$this->requireLogin = false;
		parent::__construct('login');
	}

	public function login($run = false)
	{
		if ($run) {
			// try logging in
			$username = htmlspecialchars($_POST['username']);
			$password = htmlspecialchars($_POST['password']);

			if ($this->model->tryLogin($username, $password)) {
				header('location: /ArtomiSys2/dashboard');
				return true;
			} else {
				header('location: /ArtomiSys2/dashboard/login');
				return false;
			}
		} else {
			if (isset($_SESSION['loggedin'])) {
				$this->model->logout();
				header('location: /ArtomiSys2/dashboard/login');
			}

			// show login form
			$data = [
				'title' => 'Kirjaudu sisään',
			];

			$this->runPage('login', $data, false);
		}
	}

	public function logout()
	{
		$this->model->logout();
		header('location: /ArtomiSys2/dashboard/login');
	}
}