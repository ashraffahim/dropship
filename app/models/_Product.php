<?php

namespace models;

use libraries\Database;

class _Product {

	private $db;

	function __construct() {
		$this->db = new Database();
	}

	public function search($q) {
		$this->db->query('SELECT * FROM `product` WHERE `p_name` LIKE :q OR `p_category` LIKE :q OR `p_brand` LIKE :q OR `p_model` LIKE :q');
		$this->db->bind(':q', '%' . $q . '%', $this->db->PARAM_STR);

		return $this->db->result();
	}

	public function details($h, $n = false) {
		if ($n) {
			$this->db->query('SELECT * FROM `product` WHERE `p_handle` = :h LIMIT :nf,1');
			$this->db->bind(':h', $h, $this->db->PARAM_STR);
			$this->db->bind(':nf', $n - 1, $this->db->PARAM_INT);
		} else {
			$this->db->query('SELECT * FROM `product` WHERE `p_handle` = :h');
			$this->db->bind(':h', $h, $this->db->PARAM_STR);
		}
		return $this->db->single();
	}
}

?>