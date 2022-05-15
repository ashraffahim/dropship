<?php

namespace models;

use libraries\Database;

class _Cart {

	private $db;

	function __construct() {
		$this->db = new Database();
	}

	public function data($ids) {
		if (!preg_match('/^[0-9,]+$/', $ids)) {
			exit;
		}
		$this->db->query('SELECT * FROM `product` WHERE `id` IN (' . $ids . ')');

		return $this->db->result();
	}
}

?>