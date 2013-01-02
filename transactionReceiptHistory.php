<?php
//ob_start();
header ('Content-type: text/html; charset=utf-8');
//header('Content-Type: text/html; charset=ISO-8859-15');

 include_once("cumbari.php");
 $offerObj = new offer();
 $offerObj->saveTransactionHistory();

?>