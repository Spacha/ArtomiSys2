<?php

namespace ArtomiSys\Models\Dashboard;

use ArtomiSys\Libs\Model;

class SettingsModel extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getSettings(array $settings = array())
	{

	}

	public function changePassword($old, $new, $repeat)
	{
		$old = md5($old);
		$new = md5($new);
		$repeat = md5($repeat);

		$userid = $_SESSION['userid'];
		$sql = "SELECT password FROM users WHERE userid = :userid";
		$correctPw = $this->db->select($sql, [':userid' => $userid], false)['password'];

		if ($old === $correctPw) {
			if ($new === $repeat) {
				// Finally we can change the password
				return $this->db->update('users', ['password' => $new], 'userid = \''.$userid.'\'');
			}
			
		}

		return false;
	}
}