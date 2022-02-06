<?php

namespace controllers;

use libraries\Controller;
use models\_Home;
use models\_Country;

class Home extends Controller {

	private $h;

	function __construct() {
		$this->h = new _Home();
	}

	public function index()	{
		$f = $this->h->feed();
		$c = new _Country();
		$this->view('home'.DS.'feed', [
			'title' => '',
			'description' => '',
			'canonical' => DOMAIN,
			'meta' => '',
			'schema' => '',
			'data' => $f,
			'curr' => $c->list()
		]);
	}
}

?>