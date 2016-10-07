<?php

namespace ArtomiSys\Controllers\Dashboard;

use ArtomiSys\Libs\Dashboard;
use ArtomiSys\Models\Dashboard\GalleryModel;

class Gallery extends Dashboard
{
	public function __construct()
	{
		$this->model = new GalleryModel();
		parent::__construct();
	}

	/**
	* Show a compact list of all images in the gallery with captions
	*/
	public function index()
	{
		$data = ['title' => 'Galleria'];
		$this->runPage('gallery/index', $data);
	}

	/**
	* Add a single image or multiple images with captions
	*/
	public function upload($save = false)
	{

	}

	/**
	* Edit image caption or replace image with another(?)
	* Or remove it
	* @param id id of the image
	*/
	public function edit($id, $save = false)
	{

	}

	/**
	* 
	*/
	public function delete($id, $seriously = false)
	{

	}
}