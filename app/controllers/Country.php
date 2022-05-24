<?php

namespace controllers;

use libraries\Controller;
use models\_Country;

class Country extends Controller {

	private $c;

	function __construct() {
		$this->c = new _Country();
	}

	public function customCountryList() {
		$ret = ':';

		foreach ($this->c->list() as $i => $v) {
			$ret .= ',' . $i . ':' . $v[0];
		}

		return $ret;
	}

	public function currSymbol($c, $json = false) {
		if (!is_array($c)) {
			$c = explode(',', $c);
		}
		$cs = [];
		foreach ($c as $cr) {
			$cs[$cr] = $this->c->list()[$cr][1];
		}
		
		$this->status($cs, $json);
		return $cs;
	}

}

?>