<?php
	ob_start();
	header('Content-Type: text/html; charset=utf-8');

	include_once("cumbari.php");
	include_once("header.php");
	include 'config/defines.php';
	
	$code = $_GET['code'];
	$url = 'https://connect.stripe.com/oauth/token';
	
	$token_request_body = array(
		'grant_type' => 'authorization_code',
		'client_id' => $stripe_client_id,
		'code' => $code,
		'client_secret' => $stripe_client_secret
	);
	
	$req = curl_init($url);
	curl_setopt($req, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($req, CURLOPT_POST, true );
	curl_setopt($req, CURLOPT_POSTFIELDS, http_build_query($token_request_body));

	// TODO: Additional error handling
	$respCode = curl_getinfo($req, CURLINFO_HTTP_CODE);
	$resp = json_decode(curl_exec($req), true);
	$access_token = $resp['access_token'];
	$stripe_publishable_key = $resp['stripe_publishable_key'];
	$stripe_user_id = $resp['stripe_user_id'];
	$refresh_token = $resp['refresh_token'];
	$redirect_url = 'showStore.php';
	curl_close($req);

	$storeObj = new registration();
	$storeObj->companyStripeConnect($access_token,$stripe_publishable_key,$stripe_user_id,$refresh_token,$redirect_url);
?>