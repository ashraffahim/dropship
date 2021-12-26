<?php

namespace models;

use libraries\Database;

class _Product {

	private $db;

	function __construct() {
		$this->db = new Database();
	}

	public function details($h, $n = false) {
		if ($n) {
			$this->db->query('SELECT * FROM `product` WHERE `p_handle` = :h LIMIT :nf,1');
			$this->db->bind(':h', $h);
			$this->db->bind(':nf', $n - 1);
		} else {
			$this->db->query('SELECT * FROM `product` WHERE `p_handle` = :h');
			$this->db->bind(':h', $h);
		}
		return $this->db->single();
	}
}

?>