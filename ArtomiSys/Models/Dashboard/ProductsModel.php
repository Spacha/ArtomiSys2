<?php

namespace ArtomiSys\Models\Dashboard;

use ArtomiSys\Libs\Model;
use ArtomiSys\Libs\Images;
use ArtomiSys\Libs\Helper;

class ProductsModel extends Model
{
	public function __construct()
	{
		parent::__construct();
	}


	/**
	* Fetches all products from database
	* @param order defines in which order products are by date (ascending/descending)
	* @return associative array of products
	*/
	public function fetchAllProducts($order = "DESC")
	{
		$sql = "SELECT * FROM products ORDER BY date $order";

		$products = $this->db->select($sql);

		foreach($products as &$product) {
			$product['date'] = date(DATE_FORM, $product['date']);
		}

		return $products;
	}

	/**
	* Fetches a single product's data
	* @param id of the product
	* @param return true on success, false on failure
	*/
	public function fetchProductData($id, $fields = '*')
	{
		$sql = "SELECT ".$fields." FROM products WHERE id = :id LIMIT 1";
		$product = $this->db->select($sql, [':id' => $id], false);
		if (isset($product['date'])) $product['date'] = date(DATE_FORM, $product['date']);
		
		// explode string into image names
		if (strlen($product['images']) > 0) {
			$imgs = Helper::extractImgsStr($product['images']);
			$product['images'] = $imgs;
		} else {
			unset($product['images']);
		}

		return $product;
	}

	// is images[] really necessary?
	public function saveProduct(
		$title,
		$content,
		$visible,
		array $images = [] ,
		$oldImgs = [],
		$id = 0,
		$uniqid = 0)
	{
		$imagesStr = '';

		if ($id == 0) {
			/**
			*   ---------------------
			*	SAVE NEW PRODUCT
			*	---------------------
			*/
			$uniqid = uniqid();

			// If there's images, save their names to database as a string
			if (!empty($images = Images::upload($images))) {
				sort($images);

				// Make a string of image names for database
				$imagesStr = implode(', ', $images);
			}

			$title = Helper::validateInput($title);
			$content = Helper::validateInput($content);

			$data = array(
				'title' => $title,
				'content' => $content,
				'visible' => $visible,
				'images' => $imagesStr,
				'date' => date("U"));

			return $this->db->insert('products', $data);
		} else {
			/**
			*   ---------------------
			*	UPDATE EDITED PRODUCT
			*	---------------------
			*/

			$newImgs = Images::upload($_FILES['images']);

			// If there's images, save their names to database as a string
			if (!empty($images = array_merge($oldImgs, $newImgs))) {
				sort($images);
				$imagesStr = implode(', ', $images);
			}

			$title = Helper::validateInput($title);
			$content = Helper::validateInput($content);

			$data = [
				'title' => $title,
				'content' => $content,
				'visible' => $visible,
				'images' => $imagesStr,
			];

			return $this->db->update('products', $data, 'id = '.$id);
		}
	}

	/**
	*	TODO: Consider a more describing name!
	*/
	public function deleteRemovedImgs(string $all, array $removed)
	{
		$all = Helper::extractImgsStr($all);
		return array_diff($all, $removed);
	}

	/**
	* Deletes a product from database
	* @param id of the product
	*/
	public function delete($id)
	{
		// TODO: remove related images too!
		if ($this->db->delete('products', 'id = '.$id) > 0) {
			header('location: /ArtomiSys2/dashboard/products');
		} else {
			// set an error here!
			header('location: /ArtomiSys2/dashboard/products/view/'.$id);
		}
	}

	public function deleteProductImgs($id)
	{
		// $sql = "SELECT images FROM products WHERE id = :id";
		// $this->db->select($sql, [':id' => $id], false);
		$images = $this->fetchProductData($id, 'images');
		//$images = $images['images'];

		if (is_array($images['images'])) {
			return $this->deleteImgs($images['images']);
		}

		return false;
	}

	public function deleteImgs(array $images)
	{
		return Images::delete($images);
	}

	/**
	* Get the id which inserted latest to the database
	* @param return last inserted id
	*/
	public function lastId()
	{
		return $this->db->lastInsertId();
	}
}