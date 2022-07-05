<?php

namespace controllers;

use libraries\Controller;

class Webhook extends Controller {

	private $w;

	function __construct() {
		$this->w = new _Webhook();
	}

	public function stripe() {
		// This is your Stripe CLI webhook secret for testing your endpoint locally.
		$endpoint_secret = 'sk_test_51JGXp4IoGl18YWC8sqlP7TeCjGpezoYpn45HwDmSUWGmNLCeKG5EfdY2ZUYCQATLhovA4HuevEdSPH1Xp0yGhqFI00tEdFGqMx';

		$payload = @file_get_contents('php://input');
		$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
		$event = null;

		try {
			$event = \Stripe\Webhook::constructEvent(
				$payload, $sig_header, $endpoint_secret
			);
		} catch(\UnexpectedValueException $e) {
			// Invalid payload
			http_response_code(400);
			exit();
		} catch(\Stripe\Exception\SignatureVerificationException $e) {
			// Invalid signature
			http_response_code(400);
			exit();
		}

		// Handle the event
		switch ($event->type) {
			case 'payment_intent.succeeded':
				$paymentIntent = $event->data->object;
				file_put_contents('a.json', $paymentIntent);
			default:
				echo 'Received unknown event type ' . $event->type;
		}

		http_response_code(200);
	}

}

?>