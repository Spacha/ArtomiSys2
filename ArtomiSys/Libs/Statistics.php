<?php

namespace ArtomiSys\Libs;

use ArtomiSys\Libs\Database;

class Statistics extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get(array $stats = array())
	{
		// if $stats not defined, fetch all
		if (empty($stats)) {
			$stats = [
				'pagesCount',
				'productsCount',
				'passwordChanged',
				'diskSpaceFree',
				'diskSpaceUsed',
				'diskSpaceTotal',
				'diskSpaceUsedPercent'
			];
		}

		$results = array();

		foreach($stats as $stat) {
			switch($stat) {
				case "productsCount":
					$results[$stat] = $this->db->rowCount('products');
					break;
				case "passwordChanged":
					$userid = $_SESSION['userid'];
					$passwordChanged = (date("U") - $this->db->select("
						SELECT passwordChanged
						FROM users
						WHERE userid = '".$userid."' LIMIT 1", array(), false)['passwordChanged']) / 86400;

					$duration = round($passwordChanged);
					switch($duration) {
						case (0):
							$results[$stat] = 'tänään';
							break;
						case (1):
							$results[$stat] = 'eilen';
							break;
						default:
							$results[$stat] = $duration." päivää sitten";
							break;
					}

					break;
				case 'diskSpaceFree':
					$results[$stat] = round(disk_free_space(PATH_FILE_ROOT)/1000000, 1).' Mt';
					break;
				case 'diskSpaceTotal':
					$results[$stat] = round(disk_total_space(PATH_FILE_ROOT)/1000000, 1).' Mt';
					break;
				case 'diskSpaceUsed':
					$results[$stat] = round(
										(disk_total_space(PATH_FILE_ROOT)-
										disk_free_space(PATH_FILE_ROOT))/1000000, 1).' Mt';
					break;
				case 'diskSpaceUsedPercent':
					$results[$stat] = round(
										disk_total_space(PATH_FILE_ROOT)/
										(disk_total_space(PATH_FILE_ROOT)-
										disk_free_space(PATH_FILE_ROOT)), 1).'%';
					break;
				default:
					$results[$stat] = "tuntematon";
					break;
			}
		}

		return $results;
	}

	public function set(array $data)
	{
		// some of these might be generalized?
		foreach($data as $tag => $value) {
			switch($tag) {
				case 'passwordChanged':
					$userid = $_SESSION['userid'];
					$this->db->update('users', ['passwordChanged' => $value], 'userid = \''.$userid.'\'');
					break;
			}
		}
	}
}