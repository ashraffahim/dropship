<?php

namespace libraries;

class Controller {

	public function view($view, $data = [], $wrap = true) {

		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
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

	public function error($err) {
		$this->view('error/' . $err, [
			'title' => '',
			'description' => '',
			'canonical' => '',
			'meta' => '<meta name="robots" content="noindex">',
			'schema' => ''
		]);
	}

	public function status($data = [], $ajax = false) {

		if ((isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') || $ajax) {
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