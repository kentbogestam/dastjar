<?php
//ob_start();
header ('Content-type: text/html; charset=utf-8');
//header('Content-Type: text/html; charset=ISO-8859-15');
$service = new SoapClient('http://www.kupong.se/services/couponapi18.asmx?wsdl',array('trace'=>1));

$authvalues = array('UserName' => 'Cumbari','Password' => 'Hynell');

$header = new SoapHeader('http://www.kupong.se/services/','Authenticator', $authvalues, false);

$campaignCode = 'IAYJPLW7ANVU';

$params = array('strPartnerCampaignCode'=>$campaignCode);

try
{
  $service->__setSoapHeaders(array($header));
 
 
  //$result = $service->ListCoupons(array('parameters'=>$params));

  $result = $service->__call('ListCoupons',array('parameters' =>  $params));


 // echo "<pre>";
 // print_r($result);
}
catch (Exception $error)
{
  print_r($error);
  print_r($service->__getLastRequest());
}

 include_once("cumbari.php");
 $offerObj = new offer();
 $offerObj->saveMobilabCampaign($result);
   
?>

 