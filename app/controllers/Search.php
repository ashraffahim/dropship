<?php

namespace controllers;

use libraries\Controller;
use models\_Product;
use models\_Country;

class Search extends Controller {

	private $h;

	function __construct() {
		$this->h = new _Product();
	}

	public function index($q = false)	{
		$q = $q ? $q : $this->get('q');
		$r = $this->h->search($q);
		$c = new _Country();
		if (!$r) {
			$this->error('npf');
			return;
		}
		$this->view('search'.DS.'index', [
			'title' => '',
			'description' => '',
			'canonical' => DOMAIN,
			'meta' => '<meta name="robots" content="noindex">',
			'schema' => '',
			'data' => $r,
			'curr' => $c->list()
		]);
	}
}

?>