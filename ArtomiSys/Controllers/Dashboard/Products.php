<?php

namespace ArtomiSys\Controllers\Dashboard;

use ArtomiSys\Models\Dashboard\ProductsModel;
use ArtomiSys\Libs\Dashboard;
use ArtomiSys\Libs\View;
use ArtomiSys\Libs\Images;

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
			'title' => 'Tuotteet',
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
			$data = [
				'title' => 'Uusi tuote'
			];

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
			// upload related images
			$images = new Images();
			$img_names = $images->upload($_FILES['images'], $id);

			if ($this->model->saveProduct(htmlspecialchars($_POST['title']), htmlspecialchars($_POST['content']), $img_names, $id)) {
				header('location: /ArtomiSys2/dashboard/products/view/'. $id);
			} else {
				// TODO: Remove images we just uploaded!
				header('location: /ArtomiSys2/dashboard/products');
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
