<?php

namespace controllers;

use libraries\Controller;
use models\_Webhook;

class Webhook extends Controller {

	private $w;

	function __construct() {
		$this->w = new _Webhook();
	}

	public function stripe() {

		require '../app/libraries/stripe-php/init.php';

		// This is your Stripe CLI webhook secret for testing your endpoint locally.
		$endpoint_secret = ENDPOINT_SECRET;

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
				$ps = $this->w->confirmPayment($event->data->object->client_secret);
				echo $ps;
				// file_put_contents('a.json', $event->data->object);
		}

		http_response_code(200);
	}

}

?>