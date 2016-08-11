<?php

namespace ArtomiSys\Controllers\Dashboard;

use ArtomiSys\Models\Dashboard\ProductsModel;
use ArtomiSys\Libs\Controller;
use ArtomiSys\Libs\View;

class Products extends Controller
{
	private $model;
	private $view;

	public function __construct()
	{
		parent::__construct();
		$this->model = new ProductsModel();
		$this->view = new View();
	}

	public function index()
	{
		// view product list
		$this->view->title = APP_NAME . ' &ndash; Products';
		$this->view->active = 'products';
		$this->view->snippets['header'] = 'dashboard/header';
		$this->view->render('dashboard/products/index');
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
