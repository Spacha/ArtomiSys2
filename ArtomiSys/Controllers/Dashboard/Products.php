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
		$this->view->products = $this->model->fetchAllProducts();

		$this->view->productsCount = count($this->view->products);

		// TODO: Move these to the master (extended) controller!
		$this->view->title = APP_NAME . ' &ndash; Products';
		$this->view->active = 'products';
		$this->view->snippets['header'] = 'dashboard/header';
		$this->view->render('dashboard/products/index');
	}

	public function view($id = 0)
	{
		$this->view->product = $this->model->fetchProductData($id);

		if ($id == 0 || empty($this->view->product)) {
			header('location: /ArtomiSys2/dashboard/products');
		}
		
		$this->view->title = APP_NAME . ' &ndash; Edit product';
		$this->view->active = 'products';
		$this->view->snippets['header'] = 'dashboard/header';
		$this->view->render('dashboard/products/view');
	}

	public function create($save = false)
	{
		if (!$save) {
			$this->view->title = APP_NAME . ' &ndash; Uusi tuote';
			$this->view->active = 'products';
			$this->view->snippets['header'] = 'dashboard/header';
			$this->view->render('dashboard/products/create');
		} else {
			if ($this->model->saveProduct(htmlspecialchars($_POST['title']), htmlspecialchars($_POST['content']))) {
				header('location: /ArtomiSys2/dashboard/products/view/'.$this->model->lastId());
			} else {
				header('location: /ArtomiSys2/dashboard/products');
			}
		}
	}

	public function edit($id)
	{

	}

	public function delete($id, $seriously = false)
	{

		// Confirmation
		if (!$seriously) {
			$this->view->product = $this->model->fetchProductData($id);

			$this->view->title = APP_NAME . ' &ndash; Delete product';
			$this->view->active = 'products';
			$this->view->snippets['header'] = 'dashboard/header';
			$this->view->render('dashboard/products/delete');
		} else {
			// Actually delete the product
			$this->model->delete($id);
		}
	}
}
