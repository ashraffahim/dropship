<?php

namespace Libraries;

class Controller {

	public function view($view, $data = [], $wrap = true) {

		if (isset($_SERVER['HTTP_SEC_FETCH_MODE']) && $_SERVER['HTTP_SEC_FETCH_MODE'] == 'cors') {
			$wrap = false;
		}

		if (file_exists('../app/views/' . $view . '.php')) {
			
			if ($wrap) {
			
				include '../app/views/inc/header.php';
				require_once '../app/views/' . $view . '.php';
				include '../app/views/inc/footer.php';
			
			} else {
			
				require_once '../app/views/' . $view . '.php';
			
			}

		} else {

			if ($view != '') {
				header('Location: ' . BASEDIR);
			}

		}

	}

	public function status($data = [], $ajax = false) {

		if (isset($_SERVER['HTTP_SEC_FETCH_MODE']) && $_SERVER['HTTP_SEC_FETCH_MODE'] == 'cors') {
			$ajax = true;
		}

		if ($ajax) {

			require_once '../app/views/api/json.php';
			exit;
		
		}

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