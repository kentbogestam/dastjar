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

function get_execution_time()
{
    static $microtime_start = null;
    if($microtime_start === null)
    {
        $microtime_start = microtime(true);
        return 0.0;
    }   
    return microtime(true) - $microtime_start; 
 }
// echo $device . " " .  get_execution_time();

// set up memcache
$memcache = new Memcache;
$memcache->connect('localhost', 11211) or die ("Could not connect");


// get the the POST body that is a json object
$data = file_get_contents('php://input');
$rdclient=json_decode($data);
$responskey=$rdclient->client->clientId;

// Check if request is respons from POS (td)
if ($sequence_id==3 and $accept=="yes"){
  // set a new expire time
  $expire=40;

  // create the dpsobject and add data
  $dps_robject = new stdClass;
  $dps_robject->acc=$acc;
  $dps_robject->device=$device;
  $dps_robject->clientId=$clientId;
  $dps_robject->sequence_id=$sequence_id;
  $dps_robject->message=$data;
  // intert the obect into the cache and set search key
  $memcache->set($clientId, $dps_robject, false, $expire) or die ("Failed to save data at the server");
}else {

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

if ($devicei == "td"){
  // create the dpsobject and add data
  $dps_tdobject = new stdClass;
  $dps_tdobject->acc=$acc;
  $dps_tdobject->device=$device;
  $dps_tdobject->service=$service;
  $dps_tdobject->long=$long;
  $dps_tdobject->lat=$lat;
  $dps_tdobject->target_id=$target_id;
  $dps_tdobject->rt_time=$rt_time;
  $dps_tdobject->detection_mode=$detection_mode;
  $dps_tdobject->sequence_id=$sequence_id;
  $dps_tdobject->message=$data;
}
    // If target is known
    if ($target_id || $sharedSecret){
    // Find out what type of device it is e.g. rd or td and create u unuqe search key. What do we do if it is two rd???
    // Set the key to find the target a rd want a td and a td wants a rd
    // This methode if only valid to coupons, value checks etc where you know the target and for id based dps services

      if ($sharedSecret){
        $target_id=$sharedSecret;
      }

      if ($device == "rd"){
        $key="rd" . $target_id;
        $targetkey="td" . $target_id;
  // intert the obect into the cache and set search key
  $memcache->set($key, $dps_rdobject, false, $expire) or die ("Failed to save data at the server");
      }
      else{
        $key="td" . $target_id;
        $targetkey="rd" . $target_id;
  // intert the obect into the cache and set search key
  $memcache->set($key, $dps_tdobject, false, $expire) or die ("Failed to save data at the server");
      }

if ($device == "td"){
  // Check if we have any hits in the cache before the cache expire
  $i=1;
  while ($i<=$expire)
  {
    if ($get_result = $memcache->get($targetkey))
    {
    // If more then one hit // consider rt_time and do only take hits within 2 seconds into consideration
        // if more then one hit send error
    // url parmaters
    // the message
      $message = $get_result->message;

    $i=$expire;
    if ($device == "td"){
    //echo "Store data in the cache (data will expire in " .$expire . " seconds)<br/>";
    //echo "Data from the cache:<br/>";
    echo $message;
    }
    // Enter here with what we should do with the respons message to the rd from the td
    }
      sleep(1);
      $i++;
   }
   }
   if ($device == "rd"){
      // check for a respons message in cache responkey is clientid
      $memcache->close();
      // set up memcache
$memcache = new Memcache;
$memcache->connect('localhost', 11211) or die ("Could not connect");
      $i=1;
        while ($i<=$expire)
        {
          if ($get_result = $memcache->get($responskey))
          {
           $message = $get_result->message;
           echo $message;
    	   $i=$expire;
          }
sleep(1);
      $i++;
      }
   }
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
}
