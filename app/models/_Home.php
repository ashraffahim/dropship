<?php

namespace models;

use libraries\Database;

class _Home {

	private $db;

	function __construct() {
		$this->db = new Database();
	}

	public function feed() {
		$this->db->query('SELECT `p`.*, `s_country` FROM `product` `p` JOIN `seller` `s` ON (`p`.`p_sellerstamp` = `s`.`id`) LIMIT 0,50');
		return $this->db->result();
	}
}

?>