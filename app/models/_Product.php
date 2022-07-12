<?php

namespace models;

use libraries\Database;

class _Product {

	private $db;

	function __construct() {
		$this->db = new Database();
	}

	public function search($q) {
		$this->db->query('SELECT * FROM (
			SELECT `p`.*, `s_country`, `currency_symbol` FROM `product` `p` JOIN `seller` `s` JOIN `sys_country` `c` ON (`p`.`p_sellerstamp` = `s`.`id` AND `s`.`s_country` = `c`.`code`) WHERE `p_name` = :q
			 UNION 
			SELECT `p`.*, `s_country`, `currency_symbol` FROM `product` `p` JOIN `seller` `s` JOIN `sys_country` `c` ON (`p`.`p_sellerstamp` = `s`.`id` AND `s`.`s_country` = `c`.`code`) WHERE `p_name` LIKE :w
			 UNION 
			SELECT `p`.*, `s_country`, `currency_symbol` FROM `product` `p` JOIN `seller` `s` JOIN `sys_country` `c` ON (`p`.`p_sellerstamp` = `s`.`id` AND `s`.`s_country` = `c`.`code`) WHERE `p_category` = :q
			 UNION 
			SELECT `p`.*, `s_country`, `currency_symbol` FROM `product` `p` JOIN `seller` `s` JOIN `sys_country` `c` ON (`p`.`p_sellerstamp` = `s`.`id` AND `s`.`s_country` = `c`.`code`) WHERE `p_category` LIKE :w
			 UNION 
			SELECT `p`.*, `s_country`, `currency_symbol` FROM `product` `p` JOIN `seller` `s` JOIN `sys_country` `c` ON (`p`.`p_sellerstamp` = `s`.`id` AND `s`.`s_country` = `c`.`code`) WHERE `p_brand` = :q
			 UNION 
			SELECT `p`.*, `s_country`, `currency_symbol` FROM `product` `p` JOIN `seller` `s` JOIN `sys_country` `c` ON (`p`.`p_sellerstamp` = `s`.`id` AND `s`.`s_country` = `c`.`code`) WHERE `p_brand` LIKE :w
			 UNION 
			SELECT `p`.*, `s_country`, `currency_symbol` FROM `product` `p` JOIN `seller` `s` JOIN `sys_country` `c` ON (`p`.`p_sellerstamp` = `s`.`id` AND `s`.`s_country` = `c`.`code`) WHERE `p_model` = :q
			 UNION 
			SELECT `p`.*, `s_country`, `currency_symbol` FROM `product` `p` JOIN `seller` `s` JOIN `sys_country` `c` ON (`p`.`p_sellerstamp` = `s`.`id` AND `s`.`s_country` = `c`.`code`) WHERE `p_model` LIKE :w
		) `sr`');
		$this->db->bind(':q', $q, $this->db->PARAM_STR);
		$this->db->bind(':w', "%$q%", $this->db->PARAM_STR);

		return $this->db->result();
	}

	public function details($id) {
		$this->db->query('SELECT `p`.*, `s_country`, `s_currency` FROM `product` `p` JOIN `seller` `s` ON (`p`.`p_sellerstamp` = `s`.`id`) WHERE `p`.`id` = :id');
		$this->db->bind(':id', $id, $this->db->PARAM_INT);
		return $this->db->single();
	}
}

?>