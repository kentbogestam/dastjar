<?php
//
include_once("../cumbari.php");
require_once("../vendor/autoload.php");

\Stripe\Stripe::setApiKey(STRPIE_CLIENT_SECRET);

// Verifying the event
$endpoint_secret = 'whsec_D1bSEfnuaEvHv3AJez3KKU26mE2FXMoM';

// Retrieve the request's body and parse it as JSON
$payload = @file_get_contents('php://input');
$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
$event = null;

try {
	$event = \Stripe\Webhook::constructEvent(
		$payload, $sig_header, $endpoint_secret
	);
} catch(\UnexpectedValueException $e) {
	// Invalid payload
	http_response_code(400); // PHP 5.4 or greater
	exit();
} catch(\Stripe\Error\SignatureVerification $e) {
	// Invalid signature
	http_response_code(400); // PHP 5.4 or greater
	exit();
}

// Do something with $event

http_response_code(200); // PHP 5.4 or greater
?>