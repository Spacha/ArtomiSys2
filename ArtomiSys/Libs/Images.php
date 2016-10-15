<?php

/**
* MAKE a cron job or sth which removes paths from database if file does not exist!
* CRON: deleteLooseImgs() & deleteInexistent image names from database
* TODO: style image upload field!
*/

namespace Artomisys\Libs;

class Images
{
	protected static $allowed_exts = ['jpg','jpeg','png','gif'];

	/**
	* Upload images to destination and return array containing image names
	* @param array images you want to upload
	* @return array containing names of successfully uploaded images
	*/
	public static function upload(array $images)
	{
		$uploaded = [];

		// print_r($_FILES['images']);

		// go through uploadable images
		for($i = 0; $i < count($images['name']); $i++) {

			// check if image is real or does it even exist
			if (!isset($images['name'][$i]) || strlen($images['name'][$i]) <= 0) {
				// $this->throwMessage('Something went wrong while uploading the image :(', 2);
				continue;
			}

			// if image is fake
			if (!getImageSize($images['tmp_name'][$i])) {
				continue;
			}

			if ($images['size'][$i] > UPLOAD_MAX_SIZE) {
		    	continue;
			}

			// $tmp = explode('.', $images['name'][$i]);
			// $ext = end($tmp);
			$ext = pathinfo($images['name'][$i])['extension'];

			$basename = 'img_'. date("Y-m-d") .'-'. uniqid() .'.'.$ext;
			$new_name = UPLOAD_DESTINATION .'/'. $basename;

			// upload the image
			if (!in_array(strtolower($ext), self::$allowed_exts)) {
				// message, type[1 = neutral, 2 = critical]
				// $this->throwMessage('Image type not supported!', 2);
				// die('Image type not supported');
				continue;
			}

			if (!move_uploaded_file($images['tmp_name'][$i], $new_name)) continue;

			$uploaded[] = $basename;
		}

		return $uploaded;
	}

	/**
	* Delete images from destination and return array containing image names
	* @param array images you want to delete
	* @param string path you want the images to remove from
	* @return array containing names of successfully removed images
	*/
	public static function delete(array $images, $path = UPLOAD_DESTINATION)
	{
		$removed = [];

		foreach($images as $image) {
			$image = $path .'/'. $image;

			if (!file_exists($image)) continue;
			if (unlink($image)) $removed[] = $image;
		}

		return $removed;
	}
}