<?php

namespace ArtomiSys\Libs;

use PDO;

class Model extends PDO
{
	public function __construct()
	{
		echo "<li>Main Model constructed.";
	}
}