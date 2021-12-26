<?php

namespace controllers;

use libraries\Controller;
use models\_Seller;

class Seller extends Controller {

	private $s;

	function __construct() {
		$this->s = new _Seller();
	}

	public function index() {
		// Dashboard
	}

	public function product($c) {
		switch ($c) {
			case 'add' :
				$this->productAdd();
			break;
		}
	}

	public function productAdd() {
		$this->view('seller/product-add');
	}

	public function productList() {
		// Product List
		$pl = $this->s->productList();
		$this->view('seller/product-list', ['data' => $pl]);
	}
}

?>