<?php
/*
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
*/

require_once('../lib/captcha/recaptchalib.php');

/*if($_SERVER["REQUEST_METHOD"] === "POST")
{
	//verify captcha
	$recaptcha_secret = '6LeDA0kUAAAAALDRS2EZYnsprwDqOayFuSELyFbX';
	$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$recaptcha_secret."&response=".$_POST['g-recaptcha-response']);
	$response = json_decode($response, true);

	echo '<pre>'; print_r($response);
}*/
if($_SERVER["REQUEST_METHOD"] === "POST")
{
	//verify captcha
	$secret = '6LeDA0kUAAAAALDRS2EZYnsprwDqOayFuSELyFbX';
	$captcha = trim($_POST['g-recaptcha-response']);
	$ip = $_SERVER['REMOTE_ADDR'];
	$url = "https://www.google.com/recaptcha/api/siteverify?secret={$secret}&response={$captcha}&remoteip={$ip}";

	$options=array(
		'ssl'=>array(
			// 'cafile'            => '/etc/pki/tls/certs/dastjar.crt',
			'verify_peer'       => false,
			'verify_peer_name'  => false,
		),
	);
	$context = stream_context_create( $options );
	// $response = file_get_contents();
	$response = file_get_contents( $url, false, $context );
	$response = json_decode($response, true);

	echo '<pre>'; print_r($response);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>
	<form method="post" action="">
		<div class="g-recaptcha" data-sitekey="6LeDA0kUAAAAANgrH6YdoQmix-_OawzmczkQr094"></div>
		<input type="submit">
	</form>
</body>
</html>