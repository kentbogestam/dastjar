<?php

$arr = explode("?",$_SERVER['REQUEST_URI']);
parse_str($arr[1]);

// Some data need to be retyped as they lost there type
$sequence_id = (int) $sequence_id;
$rt_time = (float) $rt_time;
$long = (float) $long; 
$lat = (float) $lat;

// Set the time the date should remain in the cache
$expire=20;


// set up memcache
$memcache = new Memcache;
$memcache->connect('localhost', 11211) or die ("Could not connect");


// get the the POST body that is a json object
$data = file_get_contents('php://input');
$rdclient=json_decode($data);
//$responskey=$rdclient->client->clientId;


if ($device == "rd"){
  // create the dpsobject and add data
  $dps_rdobject = new stdClass;
  $dps_rdobject->acc=$acc;
  $dps_rdobject->device=$device;
  $dps_rdobject->service=$service;
  $dps_rdobject->long=$long;
  $dps_rdobject->lat=$lat;
  $dps_rdobject->target_id=$target_id;
  $dps_rdobject->rt_time=$rt_time;
  $dps_rdobject->detection_mode=$detection_mode;
  $dps_rdobject->sequence_id=$sequence_id;
  $dps_rdobject->message=$data;
}

    // If target is known
    if ($target_id || $sharedSecret){
    // Find out what type of device it is e.g. rd or td and create u unuqe search key. What do we do if it is two rd???
    // Set the key to find the target a rd want a td and a td wants a rd
    // This methode if only valid to coupons, value checks etc where you know the target and for id based dps services

      if ($sharedSecret){
        $target_id=$sharedSecret;
      }

        $key="rd" . $target_id;
        $targetkey="td" . $target_id;
  // intert the obect into the cache and set search key
  $memcache->set($key, $dps_rdobject, false, $expire) or die ("Failed to save data at the server");
  }
  else
  {
  // Check for detection mode 
  //if detection mode is based on postion and where device is oposit to this and secquence_id == 1
	// Check for postion and service within 2000 meter
	// consider rt_time, acc  and do only take hits within 2 seconds into consideration
	// if more then one hit send error 
  //if detection mode is based on id and where device is oposit to this and secquence_id == 1
	// use id as key and targetkey
  }
