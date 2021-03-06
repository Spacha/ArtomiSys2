<?php

/**
* DONE: Image upload on create
* DONE: View images on 'View Product' section
* DONE: Remove old images on edit
* DONE: Upload new images on edit
*
* TODO: Validation! IMPORTANT
* TODO: Upload destination to ArtomiSys/ folder!
* TODO: More clear and easier upload field (js)!
*
* OPTIONAL: Timed product visibility (remove/hide after certain time)
* OPTIONAL: Bound captions to images
*/

namespace ArtomiSys\Controllers\Dashboard;

use ArtomiSys\Libs\Dashboard;
use ArtomiSys\Models\Dashboard\ProductsModel;

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

		if ($id == 0 || empty($product)) header('location: '. ROOT_DIR .'/dashboard/products');

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
			$visible = !empty($_POST['visible']) ? $_POST['visible'] : false;

			// TODO: use an array!
			if ($this->model->saveProduct(
					$_POST['title'],
					$_POST['content'],
					$visible,
					$_FILES['images'])) {

				$this->view->setNotification('Tuotteen lisäys onnistui!', 'success');
				header('location: '. ROOT_DIR .'/dashboard/products/view/'.$this->model->lastId());
			} else {
				$this->view->setNotification('Tuotteen lisäys epäonnistui!', 'error');
				header('location: '. ROOT_DIR .'/dashboard/products');
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
			if (!isset($id)) header('location: '. ROOT_DIR .'/dashboard/products');
			$data = [
				'title' => 'Muokkaa tuotetta',
				'product' => $this->model->fetchProductData($id)
			];

			$this->runPage('products/edit', $data);
		} else {
			$removables = isset($_POST['removables'])
				? $_POST['removables']
				: array();

			// Delete images from database too!
			$this->model->deleteImgs($removables);
			$oldImgs = $this->model->deleteRemovedImgs($_POST['oldImgs'], $removables);
			$visible = !empty($_POST['visible']) ? $_POST['visible'] : false;

			if ($this->model->saveProduct(
									$_POST['title'], 
									$_POST['content'],
									$visible,
									$_FILES['images'],
									$oldImgs,
									$id)) {

				$this->view->setNotification('Tuote tallennettu.', 'success');
				header('location: '. ROOT_DIR .'/dashboard/products/view/'. $id);
			} else {
				// Error!
				$this->view->setNotification('Tuotteen tallennus epäonnistui!', 'error');
				header('location: '. ROOT_DIR .'/dashboard/products');
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

			if ($this->model->delete($id)) {
				// Success!
				$this->view->setNotification('Tuotteen poistaminen onnistui!', 'success');
				header('location: '. ROOT_DIR .'/dashboard/products/');
			} else {
				// Error!
				$this->view->setNotification('Tuotteen poistaminen epäonnistui!', 'error');
				header('location: '. ROOT_DIR .'/dashboard/products/view/'.$id);
			}
		}
	}
}
