<?php

namespace ArtomiSys\Libs;

abstract class Model extends Database
{
	protected $db;

	const DEFAULT_DB_CONFIG = 'database.php';

	public function __construct($dbConfig = self::DEFAULT_DB_CONFIG)
	{
		// prefer: define('APP_NAME', 'ArtomiSys')
		$this->db = parent::__construct(ROOT_PATH.'/ArtomiSys/config/'.$dbConfig);
	}
}