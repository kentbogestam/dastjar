<?php 
/*  File Name : payment.php
*  Description : redirect all requests for the payment on DIBS.
*  Author  : Sushil Singh  Date: 16th,Feb,2011  Added Header
*/
header('Content-Type: text/html; charset=ISO-8859-15');
require_once("cumbari.php");
require_once('payment.class.php');
//print_r($_POST); //die();

$key2='h&+iye[5GwmSPaD+#9Ca$A*bf&#vKnHS';
$key1='Kaf(U9}kNzYWM2A.t^r~qF1rh1dQcZ3h';
$merchant = "90053980";
$currency = "752";
//print_r($_GET); die();

//$MYKEY=md5($key2 . md5($key1 . "merchant=".$merchant."&orderid=".$orderid."&currency=".$currency."&amount=".$amount));

if (empty($_REQUEST['action'])) $_REQUEST['action'] ='process';  
		
		$p = new payment_class;             								// initiate an instance of the class
		$p->action_url = 'https://payment.architrade.com/paymentweb/start.action';   // DIBS url		
//echo $_REQUEST['action'];
switch ($_REQUEST['action']) {

case 'loadAccount':
	
	
	$amount = $_REQUEST['loadaccount'].'00';
	$orderid = $_REQUEST['userId']."_".substr(md5(time()),4,10);
	
	$accepturl = BASE_URL."payment.php";
	
	$MYKEY=md5($key2 . md5($key1 . "merchant=".$merchant."&orderid=".$orderid."&currency=".$currency."&amount=".$amount));
	
	$p->add_field('merchant', $merchant);
	$p->add_field('amount', $amount);
	$p->add_field('accepturl', $accepturl);
	$p->add_field('orderid', $orderid);
	$p->add_field('currency', $currency);
	$p->add_field('test', 'yes');
	$p->add_field('lang', 'se');
	$p->add_field('md5key', $MYKEY);
	$p->add_field('action', 'loadAccountResp');
	
	$p->submit_payment_post();
	//submit_post();
	break; 

case 'loadAccountResp':	
//echo "saasadsddad";  die();
	
	$_POST['loadaccount'] = substr($_POST['amount'],0,-2);
	$_POST['m'] = $_POST['loadAccount'];
	$accountObj = new accountView();
	$accountObj->loadCompanyAccount();
	break; 

case 'registerBrand':
	
	
	$amount = $_REQUEST['amount'].'00';
        $brandId = $_REQUEST['brandId'];
        $orderid = $_REQUEST['userId']."_".$brandId."_".substr(md5(time()),4,10);
	
	$accepturl = BASE_URL."payment.php";
	
	$MYKEY=md5($key2 . md5($key1 . "merchant=".$merchant."&orderid=".$orderid."&currency=".$currency."&amount=".$amount));
	
	$p->add_field('merchant', $merchant);
	$p->add_field('amount', $amount);
	$p->add_field('accepturl', $accepturl);
	$p->add_field('orderid', $orderid);
	$p->add_field('currency', $currency);
	$p->add_field('test', 'yes');
	$p->add_field('lang', 'se');
	$p->add_field('md5key', $MYKEY);
	$p->add_field('action', 'registerBrandResp');
	
	
	$p->submit_payment_post();
	//submit_post();
	break; 

case 'registerBrandResp':	
	$mrchntOrder = explode("_",$_REQUEST['orderid']);
	$brandId = $mrchntOrder[1];
        //echo $brandId; die();
        $brandObj = new brandView();
	$data = $brandObj->registeredBrandUpdate($brandId);
	break; 

case 'loadAccountAct':
	//echo "IN case";
	$amount = $_REQUEST['loadaccount'].'00';
	$orderid = $_REQUEST['userId']."_".substr(md5(time()),4,10);
	$maxcost = $_REQUEST['maxcost'];
	$m = $_REQUEST['m'];
	$accepturl = BASE_URL."payment.php";
	
	$MYKEY=md5($key2 . md5($key1 . "merchant=".$merchant."&orderid=".$orderid."&currency=".$currency."&amount=".$amount));
	
	$p->add_field('merchant', $merchant);
	$p->add_field('amount', $amount);
	$p->add_field('accepturl', $accepturl);
	$p->add_field('orderid', $orderid);
	$p->add_field('currency', $currency);
	$p->add_field('test', 'yes');
	$p->add_field('lang', 'se');
	$p->add_field('md5key', $MYKEY);
	$p->add_field('action', 'loadAccountActResp');
	$p->add_field('m', $m);
	$p->add_field('maxcost', $maxcost);
	//die();
	
	$p->submit_payment_post();
	//submit_post();
	break; 

case 'loadAccountActResp':	
//echo "saasadsddad";  die();
	//print_r($_POST); die();
	$_POST['loadaccount'] = substr($_POST['amount'],0,-2);
	//$_POST['m'] = $_POST['m'];
	$afterActivationObj = new afterActivation();
	$afterActivationObj->svrActivationDflt();
	$accountObj->loadCompanyAccount();
	break; 


default:
	echo "in default"; 
	break;	

}


?>
