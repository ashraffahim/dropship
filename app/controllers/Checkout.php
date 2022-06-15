<?php

namespace controllers;

use libraries\Controller;
use models\_Checkout;

class Checkout extends Controller {
	
	private $c;
	
	function __construct() {
		$this->c = new _Checkout();
	}

	public function index() {
		$this->view('checkout/index', [
			'title' => '',
			'description' => '',
			'canonical' => '',
			'meta' => '<meta name="robots" content="noindex">',
			'schema' => ''
		]);
	}

	public function pay($m = false, $id = false) {
		$am = $this->availMethod();

		if (!in_array($m, $am)) {
			$this->view('checkout/method', [
				'title' => '',
				'description' => '',
				'canonical' => '',
				'meta' => '<meta name="robots" content="noindex">',
				'schema' => ''
			]);
			return;
		}

		
		if ($id == false) {
			$po = $this->c->pendingOrder();
			if (isset($po->id)) {
				redir('/checkout/pay/' . $m . '/' . $po->id);
			} else {
				redir('/cart');
			}

			return;
		}

		// id = $id
		$cur = $this->c->orderCurrency($id);
		$a = $this->c->orderPayable($id);
		
		switch ($m) {
			case 'stripe':

				if ($this->RMisPost()) {
					$this->stripe($id, $cur, number_format($a, 2, '', ''));
				}
				
				$this->view('checkout/stripe', [
					'title' => '',
					'description' => '',
					'canonical' => '',
					'meta' => '<meta name="robots" content="noindex">',
					'schema' => ''
				]);

				break;
			
			case 'bkash':

				$this->view('checkout/bkash', [
					'title' => '',
					'description' => '',
					'canonical' => '',
					'meta' => '<meta name="robots" content="noindex">',
					'schema' => ''
				]);

				break;
		}
	}

	public function availMethod() {
		$ms = $this->c->availMethod();
		$a = [];
		foreach ($ms as $m) {
			$a[$m->id] = $m->code;
		}

		return $a;
	}

	public function order() {
		if ($this->RMisPost()) {
			$this->sanitizeInputPost();
			$data = $this->c->order($_POST);
			$this->status($data);
		}
	}

	private function amount($id) {
		// Replace this constant with a calculation of the order's amount
		// Calculate the order total on the server to prevent
		// people from directly manipulating the amount on the client
		
		return $this->c->orderPayable($id);
	}

	private function stripe($id, $c, $a) {

		require '../app/libraries/stripe-php/init.php';

		// This is your test secret API key.
		\Stripe\Stripe::setApiKey('sk_test_51JGXp4IoGl18YWC8sqlP7TeCjGpezoYpn45HwDmSUWGmNLCeKG5EfdY2ZUYCQATLhovA4HuevEdSPH1Xp0yGhqFI00tEdFGqMx');
		
		header('Content-Type: application/json');
		
		try {
			// retrieve JSON from POST body
			// $jsonStr = file_get_contents('php://input');
			// $jsonObj = json_decode($jsonStr);
		
			// Create a PaymentIntent with amount and currency
			$paymentIntent = \Stripe\PaymentIntent::create([
				'amount' => $a,
				'currency' => $c,
				'automatic_payment_methods' => [
					'enabled' => true,
				],
			]);
		
			$output = [
				'clientSecret' => $paymentIntent->client_secret,
			];
		
			echo json_encode($output);
		} catch (Error $e) {
			http_response_code(500);
			echo json_encode(['error' => $e->getMessage()]);
		}

		exit;
	}
}

?>