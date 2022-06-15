<?php

namespace controllers;

use libraries\Controller;
use models\_Country;

class Country extends Controller {

	private $c;

	function __construct() {
		$this->c = new _Country();
	}

	public function codeNameList() {
		return $this->c->codeNameList();
	}

	public function currSymbolList() {
		$cs = [];
		$c = $this->c->currSymbolList();
		foreach ($c as $cr) {
			$cs[$cr->currency] = $cr->currency_symbol;
		}
		return $cs;
	}

}

?>