<?php

namespace ArtomiSys\Models\Dashboard;

use ArtomiSys\Libs\Model;

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
	public function fetchProductData($id)
	{
		$sql = "SELECT * FROM products WHERE id = :id LIMIT 1";
		$product = $this->db->select($sql, [':id' => $id], array(), false);
		if (isset($product['date'])) $product['date'] = date(DATE_FORM, $product['date']);

		return $product;
	}

	public function saveProduct($title, $content, array $images = [] , $id = 0)
	{
		$imagesStr = implode(', ', $images);

		if ($id == 0) {
			$data = array(
				'title' => $title,
				'content' => $content,
				'images' => $imagesStr,
				'date' => date("U"));

			return $this->db->insert('products', $data);
		} else {
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

	/**
	* Get the id which inserted latest to the database
	* @param return last inserted id
	*/
	public function lastId()
	{
		return $this->db->lastInsertId();
	}
}