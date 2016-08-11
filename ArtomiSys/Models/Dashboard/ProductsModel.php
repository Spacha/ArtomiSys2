<?php

namespace ArtomiSys\Models\Dashboard;

use ArtomiSys\Libs\Model;

class ProductsModel extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function fetchAllPosts()
	{

	}

	public function fetchPostData($id)
	{
		$sql = "SELECT * FROM posts WHERE id = :id";
		return $this->db->select($sql, [':id' => $id]);
	}
}