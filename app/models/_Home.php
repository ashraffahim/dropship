<?php

namespace models;

use libraries\Database;

class _Home {

	private $db;

	function __construct() {
		$this->db = new Database();
	}

	public function feed() {
		$this->db->query('SELECT `p`.*, `currency_symbol` FROM `product` `p` JOIN `seller` `s` JOIN `sys_country` `c` ON (`p`.`p_sellerstamp` = `s`.`id` AND `s`.`s_country` = `c`.`code`) LIMIT 0,50');
		return $this->db->result();
	}
}

?>