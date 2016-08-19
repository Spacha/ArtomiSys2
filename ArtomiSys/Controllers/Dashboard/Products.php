<?php

/**
* DONE: Image upload on create
* DONE: View images on 'View Product' section
* DONE: Remove old images on edit
*
* TODO: Upload new images on edit
* TODO: More clear and easier upload field (js)!
*
* OPTIONAL: Bound captions to images
*/

namespace ArtomiSys\Controllers\Dashboard;

use ArtomiSys\Models\Dashboard\ProductsModel;
use ArtomiSys\Libs\Dashboard;
use ArtomiSys\Libs\View;
// use ArtomiSys\Libs\Images;

class Products extends Dashboard
{
	private $model;

	public function __construct()
	{
		$this->model = new ProductsModel();
		parent::__construct();
	}

	/**
	* Index page shows a list of all created products 
	* and count of products in the database
	*/
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

	/**
	* View is used to show specific info about specified product
	* @param id integer id of the product
	*/
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

	/**
	* Shows a product creation form if save equals false
	* @param save boolean defines whether to show the form or save the product
	*/
	public function create($save = false)
	{
		if (!$save) {
			$data = [
				'title' => 'Uusi tuote'
			];

			$this->runPage('products/create', $data);
		} else {
			if ($this->model->saveProduct(
					$_POST['title'],
					$_POST['content'],
					$_POST['visible'],
					$_FILES['images'])) {

				header('location: /ArtomiSys2/dashboard/products/view/'.$this->model->lastId());
			} else {
				header('location: /ArtomiSys2/dashboard/products');
			}
		}
	}

	/**
	* Shows an edit form when save is false. Otherwise save changes
	* @param id integer id of the product
	* @param save boolean whether to save or show the form
	*/
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
			if ($this->model->saveProduct(
									$_POST['title'], 
									$_POST['content'],
									$_POST['visible'],
									$_FILES['images'], $id)) {

				// Delete images from database too!
				// $this->model->deleteImgs($removables);

				header('location: /ArtomiSys2/dashboard/products/view/'. $id);
			} else {
				// Error!
				header('location: /ArtomiSys2/dashboard/products');
			}
		}
	}

	/**
	* Asks if user really wants to delete that particular product
	* if seriously is false. If it's true, delete product and it's images
	* @param id integer id of the product
	* @param seriously boolean defines whether to show confirm or
	* delete the product
	*/
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
			// Actually delete the product and images related to it
			$this->model->deleteProductImgs($id);

			if ($this->model->delete($id)) {
				header('location: /ArtomiSys2/dashboard/products/');
			} else {
				// Error!
				header('location: /ArtomiSys2/dashboard/products/view/'.$id);
			}
		}
	}
}
