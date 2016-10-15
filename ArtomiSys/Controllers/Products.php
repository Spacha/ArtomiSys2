<?php

namespace ArtomiSys\Controllers;

use ArtomiSys\Libs\StaticPages;
use ArtomiSys\Libs\Statistics;
use ArtomiSys\Libs\View;

use ArtomiSys\Models\Dashboard\ProductsModel;

class Products extends StaticPages
{	
	public function __construct()
	{
		$this->statistics = new Statistics();
		$this->model = new ProductsModel();

		parent::__construct();
	}

	public function index($id = 0)
	{
		if ($id > 0) {
			$this->view($id);
			return;
		}

		// $this->statistics->set();
		$this->runPage('products', [
			'title' => 'Tuotekatalogi',
			'products' => $this->model->fetchAllProducts(true)
		]);
	}

	public function view($id)
	{
		$product = $this->model->fetchProductData($id, true);

		if ($id == 0 || empty($product)) header('location: '. ROOT_DIR .'/products');

		// $this->statistics->set();
		$this->runPage('products_view', [
			'title' => 'Katsele tuotetta :D',
			'product' => $product
		]);
	}
}