<?php

namespace ArtomiSys\Models\Dashboard;

use ArtomiSys\Libs\Model;

class IndexModel extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getStats(array $stats = array())
	{
		// if $stats not defined, fetch all
		if (empty($stats)) {
			$stats = array('pagesCount', 'productsCount', 'passwordChanged');
		}

		$results = array();

		foreach($stats as $stat) {
			switch($stat) {
				case "productsCount":
					$results[$stat] = $this->db->rowCount('products');
					break;
				case "passwordChanged":
					$passwordChanged = (date("U") - $this->db->select("SELECT value FROM statistics WHERE tag = 'passwordChanged' LIMIT 1", array(), false)['value']) / 86400;

					$results[$stat] = round($passwordChanged)." päivää sitten";
					break;
				default:
					$results[$stat] = "tuntematon";
					break;
			}
		}

		return $results;
	}

}