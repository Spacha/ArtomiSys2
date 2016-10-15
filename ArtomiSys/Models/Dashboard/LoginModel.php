<?php

namespace ArtomiSys\Models\Dashboard;

use ArtomiSys\Libs\Model;

class LoginModel extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function tryLogin($username, $password)
	{
		// if already logged in
		if (isset($_SESSION['loggedin'])) {
			$this->logout();
			return false;
		}

		if ($userid = $this->checkAuth($username, $password)) {
			// $_SESSION['id'] = uniqid();
			
			$_SESSION['username'] = $username;
			$_SESSION['userid'] = $userid;
			$_SESSION['loggedin'] = true;

			return true;
		} else {
			// TODO: Return message: Invalid username or password
			header('location: '. ROOT_DIR .'/dashboard/login');
			return false;
		}
	}

	public function logout()
	{
		$_SESSION[] = [];
		session_destroy();

		return true;
	}

	private function checkAuth($username, $password)
	{
		$password = md5($password);

		$sql = "SELECT * FROM users WHERE username = :username LIMIT 1";
		$userData = $this->db->select($sql, [':username' => $username], array(), false);

		if (empty($userData)) return false;

		if ($userData['password'] == $password) {
			return $userData['userid'];
		}

		return false;
	}

}