<?php
//ob_start();
header ('Content-type: text/html; charset=utf-8');
//header('Content-Type: text/html; charset=utf-8');

 include_once("cumbari.php");
 $offerObj = new offer();
 $offerObj->saveFinancialService();
 echo("\nCalculate Amount for total Click.");
 $offerObj->saveClicksCoupon();
 echo("\nCalculate Amount for total Views.");
 $offerObj->saveViewsCoupon();
?>

