<?php

$arr = explode("?",$_SERVER['REQUEST_URI']);
parse_str($arr[1]);

// Some data need to be retyped as they lost there type
$sequence_id = (int) $sequence_id;
//

// Set the time the date should remain in the cache
$expire=10;

$responskey=$clientId;

      // check for a respons message in cache responkey is clientid
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
?>
