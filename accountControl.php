<?php

include_once("classes/control.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // collect value of input field
   $orgnr = $_POST['orgnr'];
   $service = $_POST['service'];
   $value = $_POST['value'];
	
// Get info about service is paid
	if ($service=="get") {
    		if (empty($orgnr)) {
		   die("Missing organisation number");
 		} 
	  $status=getPaidStatus($orgnr);
	  echo $status;
	} 

// Set service status to paid or unpaid 
	if ($service=="set") {
    		if (empty($orgnr)) {
		   die("Missing organisation number");
 		} 
          $status=setPaidStatus($orgnr, $value);
          echo $status;
        }

// Check if service is available according to business agreement 
	if ($service=="check") {
	  $status=controlStatus();
	  echo $status;
	} 

}


?>
