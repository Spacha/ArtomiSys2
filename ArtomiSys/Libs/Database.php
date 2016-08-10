<?php

namespace ArtomiSys\Libs;

use PDO;

class Database extends PDO
{
	public function __construct($dbConfig)
	{
		echo "<li>Database constructed.";
		$config = file($dbConfig);
		print_r($config);
	}
}