<?php

/**
* MAKE a cron job or sth which removes paths from database if file does not exist!
* CRON: deleteLooseImgs() & deleteInexistent image names from database
* TODO: style image upload field!
*/

namespace Artomisys\Libs;

class Images
{
	const UPLOAD_DESTINATION = PATH_ROOT . '/' . UPLOAD_DESTINATION;

	protected $allowed_exts = ['jpg','jpeg','png','gif'];

	/**
	* Upload images to destination and return array containing image names
	* @param array images you want to upload
	* @param uniqid you want to name your image by
	* @return array containing names of successfully uploaded images
	*/
	public function upload(array $images, $uniqid)
	{
		$uploaded = [];

		// print_r($_FILES['images']);

		// go through uploadable images
		for($i = 0; $i < count($images['name']); $i++) {

			// check if image is real or does it even exist
			if (!isset($images['name']) || !getImageSize($images['tmp_name'][$i])) {
				// $this->throwMessage('Something went wrong while uploading the image :(', 2);
				// die('Oops!');
				continue;
			}
			if ($images['size'][$i] > UPLOAD_MAX_SIZE) {
		    	// die('Image too large');
		    	continue;
			}

			// $tmp = explode('.', $images['name'][$i]);
			// $ext = end($tmp);
			$ext = pathinfo($images['name'][$i])['extension'];

			// create uniqid with prefix $uniqid
			$basename = uniqid($uniqid.'_').'.'.$ext;
			$new_name = PATH_ROOT .'/'. UPLOAD_DESTINATION .'/'. $basename;

			// upload the image
			if (!in_array(strtolower($ext), $this->allowed_exts)) {
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
	public function delete(array $images, $path = self::UPLOAD_DESTINATION)
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