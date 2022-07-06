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
		$endpoint_secret = 'whsec_66fbe7b4834241a1ec5e3faebcacb3f1b8e4e4d49f1474eef8b0c46fdc02c50f';

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
			default:
				echo 'Received unknown event type ' . $event->type;
		}

		http_response_code(200);
	}

}

?>