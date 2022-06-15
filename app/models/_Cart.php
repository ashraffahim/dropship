<?php

namespace models;

use libraries\Database;

class _Cart {

	private $db;

	function __construct() {
		$this->db = new Database();
	}

	public function serviceCharge() {
		$this->db->query('SELECT `amount` FROM `sys_charge`');
		return $this->db->single()->amount;
	}

	public function data($ids) {
		if (!preg_match('/^[0-9,]+$/', $ids)) {
			exit;
		}
		$this->db->query('
			SELECT 
				`p`.*, 
				`s`.`s_currency` 
			FROM 
				`product` `p` JOIN `seller` `s` ON `p`.`p_sellerstamp` = `s`.`id` 
			WHERE 
				`p`.`id` IN (' . $ids . ')');

		return $this->db->result();
	}
}

?>