<?php

/**
*	Helper Class
*	
*	A collection of static methods which are helpful in various situations
*/

namespace ArtomiSys\Libs;

class Helper
{
	/**
	* Trims extra spaces after and before string, useful with input fields
	* @param {string} str validatable string
	* @return {string} validated string 
	*/
	public static function validateInput(string $str)
	{
		return trim(htmlspecialchars($str));
	}

	/**
	* Explodes a string into image names
	* @param {string} containing image names (separated by ',')
	* @return {array} image names
	*/
	public static function extractImgsStr(string $str)
	{
		if (strlen($str) <= 0) {
			return array();
		}
		
		$imgs = explode(',', $str);
		$imgs = array_map(
			function($a){ return trim($a, ', '); },
			$imgs);

		return $imgs;
	}
}