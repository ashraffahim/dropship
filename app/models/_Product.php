<?php

namespace models;

use libraries\Database;

class _Product {

	private $db;

	function __construct() {
		$this->db = new Database();
	}

	public function search($q) {
		$this->db->query('SELECT `p`.*, `s_country` FROM `product` `p` JOIN `seller` `s` ON (`p`.`p_sellerstamp` = `s`.`id`) WHERE `p_name` LIKE :q OR `p_category` LIKE :q OR `p_brand` LIKE :q OR `p_model` LIKE :q');
		$this->db->bind(':q', '%' . $q . '%', $this->db->PARAM_STR);

		return $this->db->result();
	}

	public function details($id) {
		$this->db->query('SELECT `p`.*, `s_country`, `s_currency` FROM `product` `p` JOIN `seller` `s` ON (`p`.`p_sellerstamp` = `s`.`id`) WHERE `p`.`id` = :id');
		$this->db->bind(':id', $id, $this->db->PARAM_INT);
		return $this->db->single();
	}
}

?>