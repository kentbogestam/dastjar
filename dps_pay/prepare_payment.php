<?php

$arr = explode("?",$_SERVER['REQUEST_URI']);
parse_str($arr[1]);

// Some data need to be retyped as they lost there type
$sequence_id = (int) $sequence_id;
$rt_time = (float) $rt_time;

// Set the time the date should remain in the cache
$expire=19;


// set up memcache
$memcache = new Memcache;
$memcache->connect('localhost', 11211) or die ("Could not connect");


// get the the POST body that is a json object
$data = file_get_contents('php://input');
$posPayment=json_decode($data);

$key="payment" . $session_id;
// Check if request is respons from POS (td)
//if ($sequence_id==3 and $accept=="yes"){

  // create the dpsobject and add data
  $dps_payment = new stdClass;
  $dps_payment->amount=$amount;
  // intert the obect into the cache and set search key
  $memcache->set($key, $dps_payment, false, $expire) or die ("Failed to save data at the server");
//}
?>