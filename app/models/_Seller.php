<?php

namespace models;

use libraries\Database;

class _Seller {

	private $db;

	function __construct() {
		$this->db = new Database();
	}
}

?>