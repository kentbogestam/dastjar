<?php
/*  File Name   : registrationaction.php
*   Description : To access a class externally
*   Author      : Sushil singh
*   Date        : 4th,Dec,2010  Creation
*/
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/
header('Content-Type: text/html; charset=utf-8');
include_once("cumbari.php");
if(isset($_REQUEST['act']) && $_REQUEST['act']!='') {
    $mode=$_REQUEST['act'];
}else {
    $mode='';
}
switch($mode) {

    case 'emailVar':
    //echo $_GET['varcode'];
    //echo base64_decode($_GET['varcode']);
    //die();
        $regObj = new registration();
        //$regObj->emailVarification($_GET);
        $regObj->smsVarification($_GET);
        break;
    
	 case 'emailVarReseller':
        $regObj = new registration();
        $regObj->emailVarificationReseller($_GET);
        break;
	
	case 'savecomp':
        $this->saveCompanyDetails();
        break;
}
?>
