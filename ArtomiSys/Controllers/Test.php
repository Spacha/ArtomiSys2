<?php

namespace ArtomiSys\Controllers;

use ArtomiSys\Libs\Controller;
use ArtomiSys\Libs\Images;
use ArtomiSys\Libs\Statistics;

class Test extends Controller
{
	public function index($run = false)
	{

		if (!$run) {
			/*
			$free = round(disk_free_space(PATH_ROOT)/1000000, 1);
			$total = round(disk_total_space(PATH_ROOT)/1000000, 1);

			echo '<li>FREE: '.$free.' MB';
			echo '<li>TOTAL: '.$total.' MB';
			echo '<li>USED: '. round($total/$free, 1) .'%';
			*/
			$statsC = new Statistics();
			$stats = $statsC->get(['diskSpaceUsedPercent', 'diskSpaceFree']);
			echo $stats['diskSpaceUsedPercent'].'<br>';
			echo $stats['diskSpaceFree'];
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