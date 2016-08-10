<?php

/**
*
* TODO: Think about this. Which would be the best method?
*/

namespace ArtomiSys\Libs;

use PDO;

class Database extends PDO
{
	public function __construct($dbConfig)
	{
		$config = require($dbConfig);

		try {
			parent::__construct('mysql:host='. $config['host'] .';dbname='. $config['name'], $config['user'], $config['password']);

			$this->exec('SET NAMES utf8');
			$this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		} catch(PDOException $e) {
			die('Error! '. $e->getMessage());
		}
	}

	/**
	* select
	* @param string sql statement
	* @param array array of bindable values
	* @return array fetched tables
	*/
	public function select($sql, $array = array())
	{
		$query = $this->prepare($sql);

		foreach ($array as $key => $value) {
			$query->bindValue($key, $value);
		}
		$query->execute();
		
		return $query->fetchAll();
	}


	public function insert($table, array $data)
	{
		
	}

	public function update($table, array $data, $where)
	{

	}

	public function delete($table, $where, $limit = 1)
	{

	}
}