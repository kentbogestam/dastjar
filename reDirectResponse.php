<?php

 header('Content-Type: text/html; charset=utf-8');
   include("cumbari.php");
   $menu = "store";
   $$menu = 'class="selected"';
   if ($_GET['m'] == "showOutdatedStore")
       $deleted = 'checked="checked"';
   else
       $show = 'checked="checked"';
   
   include("main.php");
   include("Paging.php");

include_once "classes/store.php";

$code = $_GET['code'];

$scope = $_GET['scope'];

$url = 'https://connect.stripe.com/oauth/token';

    $token_request_body = array(
		'grant_type' => 'authorization_code',
		'client_id' => 'ca_CMxVrJvf7xIwsdSRPa5IFdwmLoQTq1ZP',
		'code' => $code,
		'client_secret' => 'sk_test_EypGXzv2qqngDIPIkuK6aXNi'
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
	curl_close($req);

	$storeObj = new store();

	$storeObj->saveStripDetail($access_token,$stripe_publishable_key,$stripe_user_id,$refresh_token);
	
?> 

