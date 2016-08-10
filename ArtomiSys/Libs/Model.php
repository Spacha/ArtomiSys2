<?php

namespace ArtomiSys\Libs;

abstract class Model
{
	protected $db;

	const DEFAULT_DB_CONFIG = 'database.php';

	public function __construct($dbConfig = self::DEFAULT_DB_CONFIG)
	{
		// prefer: define('APP_NAME', 'ArtomiSys')
		$this->db = new Database(ROOT_PATH.'/ArtomiSys/config/'.$dbConfig);
	}
}