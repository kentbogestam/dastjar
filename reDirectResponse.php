<?php

ob_start();
   //$_SESSION['REG_STEP'] = 2;
   header('Content-Type: text/html; charset=utf-8');


   include_once("cumbari.php");

   $inoutObj = new inOut();
   //$inoutObj->validSteps();
   // $regObj = new registration();
   // $regObj->isValidRegistrationStep();
  
   include_once("header.php");
   ?>
<?php include 'config/defines.php';
$code = $_GET['code'];

$scope = $_GET['scope'];

$url = 'https://connect.stripe.com/oauth/token';

    $token_request_body = array(
		'grant_type' => 'authorization_code',
		'client_id' => $stripe_client_id,
		'code' => $code,
<<<<<<< HEAD
		'client_secret' => $stripe_client_secret
=======
<<<<<<< HEAD
		'client_secret' => $stripe_client_secret
=======
		// test 'client_secret' => 'sk_test_EypGXzv2qqngDIPIkuK6aXNi'
		// live 'client_secret' => 'sk_live_INm31rvosK6bnFT48xjipoBP'
		'client_secret' => 'sk_test_EypGXzv2qqngDIPIkuK6aXNi'
>>>>>>> a50a492f89880d95bf2eddabaa2bddbd3eff0f03
>>>>>>> 5cc0b9d863b050c75ae40bf9926604635487b3e7
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
	
	$storeObj = new registration();
<<<<<<< HEAD

	echo "123";
	die();

=======
>>>>>>> 5cc0b9d863b050c75ae40bf9926604635487b3e7
	$storeObj->saveStripDetail($access_token,$stripe_publishable_key,$stripe_user_id,$refresh_token);
?> 

