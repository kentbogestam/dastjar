<?php
//
// include_once("../cumbari.php");
require_once("../vendor/autoload.php");

\Stripe\Stripe::setApiKey('sk_test_EypGXzv2qqngDIPIkuK6aXNi');

// Verifying the event
$endpoint_secret = 'whsec_94cnyHVQm6XN5nXVeOjfaDELKd2OOSWq';

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