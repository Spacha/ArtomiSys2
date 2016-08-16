<?php

namespace ArtomiSys\Controllers;

use ArtomiSys\Libs\Controller;
use ArtomiSys\Libs\Images;

class Test extends Controller
{
	public function index($run = false)
	{

		if (!$run) {
			require(PATH_ROOT. '/' . PATH_TO_SHEETS .'/test.phtml');
		} else {
			$images = new Images();
			$img_names = $images->upload($_FILES['images'], '1441111111');

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
		$images = new Images();
		$removed = $images->delete($removables);

		if (!empty($removed)) {
			$this->throwMsg(
				"Successfully removed ". count($removed) .' out of ' .count($removables). ' pictures.');
			header('location: /ArtomiSys2/test');
		}
	}
}