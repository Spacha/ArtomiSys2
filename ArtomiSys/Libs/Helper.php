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
	public static function validateInput($str)
	{
		return trim(htmlspecialchars($str));
	}

	/**
	* Explodes a string into image names
	* @param {string} containing image names (separated by commas)
	* @return {array} image names
	*/
	public static function extractImgsStr($str)
	{
		if (strlen($str) <= 0) {
			return array();
		}
		
		$imgs = explode(',', $str);
		$imgs = array_map(
			function($a){ return trim($a, ', '); },
			$imgs
		);

		return $imgs;
	}

	/**
	* Sets first image of the product as a preview image.
	* If images doesn't exist, set default
	* @param (string) imgs containing image names (separated by commas)
	* @return (string) image with full path
	*/
	public static function previewImgs($imgs)
	{
		$previewImg = DEFAULT_PREVIEW_IMG;

		// if product as no images, set default
		if (strlen($imgs) <= 0) return $previewImg;
		
		$imgs = self::extractImgsStr($imgs);

		// if first image exists, set it
		if (file_exists(UPLOAD_DESTINATION . "/" . $imgs[0])) {
			$previewImg = ROOT_DIR . "/uploads/products/" . $imgs[0];
		}

		return $previewImg;
	}
}