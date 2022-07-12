<?php

namespace controllers;

use libraries\Controller;
use models\_Home;

class Home extends Controller {

	private $h;

	function __construct() {
		$this->h = new _Home();
	}

	public function index()	{
		$f = $this->h->feed();
		$this->view('home'.DS.'feed', [
			'title' => 'Shop Everything Online | Grap',
			'description' => 'Online store for electrical, sanitary, plumbing and AC maintenance',
			'canonical' => DOMAIN,
			'meta' => '',
			'schema' => '',
			'data' => $f
		]);
	}
}

?>