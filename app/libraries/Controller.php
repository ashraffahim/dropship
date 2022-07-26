<?php

namespace libraries;

class Controller {

	public function dispense($data = []) {
		header('Content-type: text/json');
		echo json_encode($data);
	}

	public function RMisPost() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') :
			return true;
		else :
			return false;
		endif;
	}

	public function get($in, $def = false) {
		return isset($_GET[$in]) ? $_GET[$in] : $def;
	}

	public function sanitizeInputPost() {
		$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
	}

	public function sanitizeInputGet() {
		$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
	}

}
?>