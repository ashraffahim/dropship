<?php

namespace controllers;

use libraries\Controller;
use models\_User;

class Login extends Controller {

	private $u;

	function __construct() {
		$this->u = new _User();
	}

	public function index() {
		$data = ['status' => null];
		if ($this->RMisPost()) {
			$this->sanitizeInputPost();

			$data = $this->u->login($_POST['email'], $_POST['password']);

			if (isset($data['data']->id)) {
				
				$_SESSION['u'] = $data['data'];
				
				$redir = isset($_GET['redir']) ? $_GET['redir'] : '/';
				redir($redir);
			}
		}

		$this->view('user/login', $data, false);
	}

}

?>