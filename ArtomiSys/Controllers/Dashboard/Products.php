<?php

namespace ArtomiSys\Controllers\Dashboard;

use ArtomiSys\Models\Dashboard\ProductsModel;
use ArtomiSys\Libs\Dashboard;
use ArtomiSys\Libs\Controller;
use ArtomiSys\Libs\View;

class Products extends Dashboard
{
	private $model;

	public function __construct()
	{
		$this->model = new ProductsModel();
		parent::__construct();
	}

	public function index()
	{
		$products = $this->model->fetchAllProducts();
		$productsCount = count($products);

		$data = [
			'title' => 'Products',
			'products' => $products,
			'productsCount' => $productsCount
		];

		$this->runPage('products/index', $data);
	}

	public function view($id = 0)
	{
		$product = $this->model->fetchProductData($id);

		if ($id == 0 || empty($product)) header('location: /ArtomiSys2/dashboard/products');

		$data = [
			'title' => $product['title'],
			'product' => $product   
		];

		$this->runPage('products/view', $data);
	}

	public function create($save = false)
	{
		if (!$save) {
			$data = ['title' => 'Uusi tuote'];

			$this->runPage('products/create', $data);
		} else {
			if ($this->model->saveProduct(htmlspecialchars($_POST['title']), htmlspecialchars($_POST['content']))) {
				header('location: /ArtomiSys2/dashboard/products/view/'.$this->model->lastId());
			} else {
				header('location: /ArtomiSys2/dashboard/products');
			}
		}
	}

	public function edit($id, $save = false)
	{
		if (!$save) {
			if (!isset($id)) header('location: /ArtomiSys/dashboard/products');
			$data = [
				'title' => 'Muokkaa tuotetta',
				'product' => $this->model->fetchProductData($id)
			];

			$this->runPage('products/edit', $data);
		} else {
			if ($this->model->saveProduct(htmlspecialchars($_POST['title']), htmlspecialchars($_POST['content']), $id)) {
				header('location: /ArtomiSys2/dashboard/products/view/'. $id);
			} else {
				header('location: /ArtomiSys2/dashboard/products/edit/'. $id);
			}
		}
	}

	public function delete($id, $seriously = false)
	{
		// Confirm delete
		if (!$seriously) {
			$data = [
				'title' => 'Poista tuote',
				'product' => $this->model->fetchProductData($id)
			];

			$this->runPage('products/delete', $data);
		} else {
			// Actually delete the product
			$this->model->delete($id);
		}
	}
}
