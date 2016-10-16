<?php

namespace ArtomiSys\Controllers\Dashboard;

use ArtomiSys\Models\Dashboard\SettingsModel;
use ArtomiSys\Libs\Dashboard;
use ArtomiSys\Libs\Statistics;

class Settings extends Dashboard
{
	private $model;

	public function __construct()
	{
		$this->model = new SettingsModel();
		$this->statistics = new Statistics();
		parent::__construct();
	}

	// this is a custom index (defined in 'config/routes.php')
	public function index()
	{
		$data = [
			'title' => 'Asetukset',
			'settings' => $this->model->getSettings(),
			'userdata' => [
					'name' => $_SESSION['username'],
					'id' => $_SESSION['userid']
				]
		];

		$this->runPage('settings/index', $data);
	}

	public function changePassword()
	{
		if ($this->model->changePassword(
				$_POST['oldPassword'],
				$_POST['newPassword'],
				$_POST['repeatNewPassword'])) {
			$this->statistics->set(['passwordChanged' => date("U")]);
			$this->view->setNotification('Salasanan vaihto onnistui!', 'success');
			header('location: '. ROOT_DIR .'/dashboard/settings');
		} else {
			// Error!
			$this->view->setNotification('Salasanan vaihto epäonnistui! Yritä uudelleen.', 'error');
			header('location: '. ROOT_DIR .'/dashboard/settings');
		}
	}
}