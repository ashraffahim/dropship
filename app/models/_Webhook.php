<?php

namespace models;

use libraries\Database;

class _Checkout {

	private $db;

	function __construct() {
		$this->db = new Database();
	}

	public function confirmPayment($id) {
		$this->db->query('
			SELECT 
				`id`, 
				`name`, 
				`code` 
			FROM 
				`sys_payment_method`
		');

		return $this->db->result();
	}

}

?>