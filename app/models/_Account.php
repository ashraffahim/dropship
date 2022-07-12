<?php

namespace models;

use libraries\Database;

class _Account {

	private $db;

	function __construct() {
		$this->db = new Database();
	}

	public function transactionList($f = false, $t = false) {
		$this->db->query('
			SELECT 
				`o`.`id` `oid`, 
				`p`.`id` `pid`, 
				`o`.`o_currency` `cur`, 
				`o`.`o_latimestamp` `otimestamp`, 
				`p`.`p_latimestamp` `ptimestamp`, 
				(
					(
						SELECT SUM(`oi_price` * `oi_qty`) FROM `order_item` WHERE `oi_invoice` = `o`.`id`
					) 
					+ `o_service_charge` 
					+ `o_ship_cost` 
					- `o_discount`
				) `amount`, 
				`o`.`o_status` `os`, 
				`p`.`p_status` `ps` 
			FROM 
				`order` `o` 
				 LEFT JOIN 
				`payment` `p` 
				 ON (`o`.`id` = `p`.`p_order`) 
			WHERE 
				`o_buyer` = ' . $_SESSION['u']->id
		);

		return $this->db->result();
	}

	public function transaction($id) {
		$this->db->query('
			SELECT 
				`id`, 
				`o_service_charge`, 
				`o_ship_cost`, 
				`o_discount`, 
				(SELECT `currency_symbol` FROM `sys_country` WHERE `currency` = `o`.`o_currency`) `cur`, 
				(SELECT SUM(`oi_price` * `oi_qty`) FROM `order_item` WHERE `oi_invoice` = `o`.`id`) `stotal` 
			FROM 
				`order` `o` 
			WHERE 
				`id` = :id AND 
				`o_buyer` = ' . $_SESSION['u']->id
		);

		$this->db->bind(':id', $id, $this->db->PARAM_INT);

		return $this->db->single();
	}

}

?>