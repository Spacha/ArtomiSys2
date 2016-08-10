<?php

namespace ArtomiSys\Controllers;

use ArtomiSys\Models\ProductsModel;
use ArtomiSys\Libs\Controller;

class Products extends Controller
{
	private $model;

	public function __construct()
	{
		parent::__construct();
		$this->model = new ProductsModel();
	}

	public function index()
	{
		// view product list
	}

	public function view($id)
	{
		print_r($this->model->fetchPostData($id));
	}

	public function create()
	{

	}

	public function edit($id)
	{

	}

	public function delete($id)
	{

	}
}