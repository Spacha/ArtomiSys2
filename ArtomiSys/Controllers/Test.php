<?php

namespace ArtomiSys\Controllers;

use ArtomiSys\Libs\Controller;
use ArtomiSys\Libs\Images;

class Test extends Controller
{
	public function index($run = false)
	{

		if (!$run) {
			//require(PATH_ROOT. '/' . PATH_TO_SHEETS .'/test.phtml');

			echo round(disk_free_space(PATH_ROOT)/1000000, 1).' MB';
		} else {
			$img_names = Images::upload($_FILES['images']);

			if (!empty($img_names)) {
				foreach($img_names as $img) {
					$img = '/ArtomiSys2/'. UPLOAD_DESTINATION .'/'. $img;
					echo '<img style="height: 100px;" src="'.$img.'"/>';
				}
			} else {
				echo "It's completely empty :(";
			}
			echo "<p><a href='/ArtomiSys2/test'>Return</a></p>";
		}
	}

	public function deleteSingleImg(string $image)
	{
		return $this->delete([$image]);
	}

	public function delete(array $removables)
	{
		$removed = Images::delete($removables);

		if (!empty($removed)) {
			$this->throwMsg(
				"Successfully removed ". count($removed) .' out of ' .count($removables). ' pictures.');
			header('location: /ArtomiSys2/test');
		}
	}
}