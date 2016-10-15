<?php

/**
*
* TODO: rewrite sql (SELECT col1, col3 FROM etc) to reduce traffic
* 
*/

namespace ArtomiSys\Libs;

use PDO;
use ArtomiSys\Libs\Log;

class Database extends PDO
{
	public function __construct($dbConfig)
	{
		$config = require($dbConfig);
		parent::__construct('mysql:host='. $config['host'] .';dbname='. $config['name'], $config['user'], $config['password']);

		$this->exec('SET NAMES utf8');
		$this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
	}

	/**
	* select
	* @param string sql statement
	* @param array array of bindable values
	* @param bool fetchAll whether you want to use fetchAll() or just fetch()
	* @return array fetched tables
	*/
	public function select($sql, $array = array(), $fetchAll = true)
	{
		$query = $this->prepare($sql);

		foreach ($array as $key => $value) {
			$query->bindValue($key, $value);
		}
		$query->execute();
		
		if ($fetchAll) {
			return $query->fetchAll();
		} else {
			return $query->fetch();
		}
	}


	public function insert($table, array $data)
	{
		ksort($data);

		$fieldNames = implode('`, `', array_keys($data));
		$fieldValues = ':'. implode(', :', array_keys($data));

		$query = $this->prepare("INSERT INTO $table (`$fieldNames`) VALUES($fieldValues)");

		foreach ($data as $key => $value) {
            $query->bindValue(":$key", $value);
        }

        $result = $query->execute();
        if ($result) Log::write('Performed DB insert ( TABLE: '.$table.')');
        
        return $result;
	}

	public function update($table, array $data, $where)
	{
		ksort($data);
        
        $fieldDetails = null;
        foreach($data as $key => $value) {
            $fieldDetails .= "`$key`=:$key,";
        }
        $fieldDetails = rtrim($fieldDetails, ',');
        
        $query = $this->prepare("UPDATE $table SET $fieldDetails WHERE $where");
        
        foreach ($data as $key => $value) {
            $query->bindValue(":$key", $value);
        }

        $result = $query->execute();
        if ($result) Log::write('Performed DB update ( TABLE: '. $table .' WHERE: '.$where.')');
        
        return $result;
	}

	public function delete($table, $where, $limit = 1)
	{
		$query = $this->prepare("DELETE FROM $table WHERE $where LIMIT $limit");
		$result = $query->execute();

		if ($result) Log::write('Performed DB deletion ( TABLE: '. $table . 'WHERE: '.$where.')');

		return $result;
	}

	public function rowCount($table)
	{
		$query = $this->prepare("SELECT COUNT(*) FROM $table");
		$query->execute();

		return $query->fetchColumn();
	}
}