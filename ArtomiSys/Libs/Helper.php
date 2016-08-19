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
	* @param string str validatable string
	* @return string validated string 
	*/
	public static function validateInput(string $str)
	{
		return trim(htmlspecialchars($str));
	}
}