<?php

namespace models;

use libraries\Database;

class _Home {

	private $db;

	function __construct() {
		$this->db = new Database();
	}

	public function feed() {
		$this->db->query('SELECT * FROM `product` LIMIT 0,50');
		return $this->db->result();
	}
}

?>