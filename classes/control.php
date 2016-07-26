<?php

/*  File Name : control.php
 *  Description : Add Company Form
 *  Author  :Kent Bogestam  Date: 04rd,Juli,2016  Creation
 */

// Checks and sets billing status

header ('Content-type: text/html; charset=utf-8');
require('/srv/www/htdocs/config/dbConfig.php');
include_once("db.php");

function ControlStatus(){
$orgnr=getOrgNr();
$ba=getBusinessAgreement($orgnr);
if ($ba == 1){
// Business Agreement is invoicing
	$astatus=getPaidStatus($orgnr);
	echo $astatus;
	}
}


// Gets org number from Company
function getOrgNr(){
	 session_start();
	$orgnr="";
 	$db = new db();
        $db->makeConnection();
	$QUE = "select company_id from employer where u_id='" . $_SESSION['userid'] . "'";
        $res = mysql_query($QUE) or die("Get Company : " . mysql_error());
        $row = mysql_fetch_array($res);
        $companyId = $row['company_id'];
        if($companyId) {
            $nque = "SELECT company.orgnr FROM company WHERE company_id='$companyId'" ;
          $res = mysql_query($nque) or die("Get orgNr : " . mysql_error());
          $row = mysql_fetch_array($res);
          $orgnr = $row['orgnr'];
        }
        return $orgnr;
}


// Checks  for business agreement
function getBusinessAgreement($orgnr){

        $db = new db();
        $db->makeConnection();

        $ba = "select ba from company where orgnr='$orgnr'";

        $res = mysql_query($ba) or die("No ba status : " . mysql_error());
        $rs = mysql_fetch_array($res);
        $agreement = $rs['ba'];
        if ($agreement == 0 ) {
          die("Unknown agreement");
        }
	else {
	 return $agreement;
	}
	echo $agreement;

}


// Checks if service is paid 
function getPaidStatus($orgnr){
	$db = new db();
        $db->makeConnection();

	$paid = "select paid from company where orgnr='$orgnr'";

        $res = mysql_query($paid) or die("Get paid status : " . mysql_error());
	$rs = mysql_fetch_array($res);
        $status = $rs['paid'];
	if ($status == 0 or $status == 1 ) {
	return  $status;
	}
	else {
	  die("Unknown status");

	}
}


// Sets billing status
function setPaidStatus($orgnr, $value){

 	$db = new db();
        $db->makeConnection();


	$paid = "update company set paid='$value' where orgnr='$orgnr'";



	if (mysql_query($paid)) {
		echo "status updated to: " . $value;
	} else {
		// 0 is failure
    	die("Get Company : " . mysql_error());
	}

}

