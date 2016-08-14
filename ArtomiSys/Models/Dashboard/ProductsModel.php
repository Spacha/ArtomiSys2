<?php

namespace ArtomiSys\Models\Dashboard;

use ArtomiSys\Libs\Model;

class ProductsModel extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function fetchAllProducts($order = "DESC")
	{
		$sql = "SELECT * FROM products ORDER BY date $order";

		$products = $this->db->select($sql);

		foreach($products as &$product) {
			$product['date'] = date(DATE_FORM, $product['date']);
		}

		return $products;
	}

	public function fetchProductData($id)
	{
		$sql = "SELECT * FROM products WHERE id = :id LIMIT 1";
		$product = $this->db->select($sql, [':id' => $id], array(), false);
		if (isset($product['date'])) $product['date'] = date(DATE_FORM, $product['date']);

		return $product;
	}

	public function saveProduct($title, $content, $id = 0)
	{
		if ($id == 0) {
			$data = array(
				'title' => $title,
				'content' => $content,
				'date' => date("U"));

			return $this->db->insert('products', $data);
		}
	}

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

	public function lastId()
	{
		return $this->db->lastInsertId();
	}
}