<?php

namespace controllers;

use libraries\Controller;
use models\_Cart;
use models\_Country;

class Cart extends Controller {

	private $c;

	function __construct() {
		$this->c = new _Cart();
	}

	public function index() {
		$c = new _Country();
		
		$this->view('cart/index', [
			'title' => '',
			'description' => '',
			'canonical' => '',
			'meta' => '<meta name="robots" content="noindex">',
			'schema' => '',
			'data' => [
				'sc' => $this->c->serviceCharge(),
				'c' => $c->codeNameList()
			]
		]);
	}

	public function data() {
		if ($this->RMisPost()) {
			$this->sanitizeInputPost();
			$data = $this->c->data($_POST['ids']);
			$this->status($data);
		}
	}
}

?>