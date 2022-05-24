<?php

namespace controllers;

use libraries\Controller;
use models\_User;

class Signup extends Controller {

	private $u;

	function __construct() {
		$this->u = new _User();
	}

	public function index() {

		$data = [];

		if ($this->RMisPost()) {
			$this->sanitizeInputPost();
			
			// Temp info collector
			if (isset($_POST['email'])) {
				$data = $this->u->setTmp($_POST);
				if ($data['status']) {
					$VCode = $this->u->createVCode();
					$this->u->emailVCode($VCode);
				}
			}

			// Verify email
			if (isset($_POST['vcode'])) {
				$data = $this->u->verifyEmail($_POST['vcode']);

				if ($data['status'] == 1) {

					$auth = $this->u->login($_SESSION['tmp_em'], $_SESSION['tmp_pw']);

					if (isset($auth['data']->id)) {
						$_SESSION['u'] = $auth['data'];
					}

					$this->clearTmp();
				}
			}
		}

		// Load country list csv
		$country = new Country();

		$data['country'] = $country->customCountryList();

		$this->view('user/signup', $data, false);
	}

	public function clearTmp() {
		unset($_SESSION['tmp_fn']);
		unset($_SESSION['tmp_ln']);
		unset($_SESSION['tmp_em']);
		unset($_SESSION['tmp_pw']);
		unset($_SESSION['tmp_c']);
		unset($_SESSION['atmp']);
		unset($_SESSION['vcode']);
		
		redir('/signup');
	}

}

?>