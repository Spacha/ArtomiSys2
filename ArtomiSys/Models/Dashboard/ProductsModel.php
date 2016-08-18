<?php

namespace ArtomiSys\Models\Dashboard;

use ArtomiSys\Libs\Model;
use ArtomiSys\Libs\Images;

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
	* Fetches single products data
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
			$imgs = explode(',', $product['images']);
			$imgs = array_map(
				function($a){ return trim($a, ', '); },
				$imgs);

			$product['images'] = $imgs;
		}

		return $product;
	}

	public function saveProduct($title, $content, array $images = [] , $id = 0, $uniqid = 0)
	{
		if ($id == 0) {
			$uniqid = uniqid();

			// Upload images
			if (empty($images = Images::upload($_FILES['images'], $uniqid))) {
				return false;
			}
			sort($images);

			// Make a string of image names for database
			$imagesStr = implode(', ', $images);

			$data = array(
				'title' => $title,
				'content' => $content,
				'images' => $imagesStr,
				'date' => date("U"));

			return $this->db->insert('products', $data);
		} else {
			$newImgs = Images::upload($_FILES['images'], $id);
			$images = array_merge($oldImages, $newImgs);
			sort($images);

			$imagesStr = implode(', ', $images);

			$data = [
				'title' => $title,
				'content' => $content,
				'images' => $imagesStr,
			];

			return $this->db->update('products', $data, 'id = '.$id);
		}
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
		
		return Images::delete($images['images']);
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