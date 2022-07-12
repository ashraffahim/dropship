<?php

namespace controllers;

use libraries\Controller;
use models\_Account;

class Account extends Controller {

	private $p;

	function __construct() {
		if (!isset($_SESSION['u'])) {
			redir('/login?redir=/account');
		}

		$this->p = new _Account();
	}

	public function transaction($id = false) {
		if ($id) {
			$d = $this->p->transaction($id);
			$this->view('account/transaction-details', [
				'title' => 'Your Transaction #' . $id . ' | Grap',
				'description' => 'Your Transaction #' . $id,
				'canonical' => '',
				'meta' => '<meta name="robots" content="noindex">',
				'schema' => '',
				'data' => $d
			], true);
		} else {
			$d = $this->p->transactionList();
			$this->view('account/transaction', [
				'title' => 'Your Transactions | Grap',
				'description' => 'Your Invoices and Payments',
				'canonical' => '',
				'meta' => '<meta name="robots" content="noindex">',
				'schema' => '',
				'data' => $d
			]);
		}
	}
}

?>