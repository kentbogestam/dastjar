<?php
//ob_start();
header ('Content-type: text/html; charset=utf-8');
//header('Content-Type: text/html; charset=utf-8');

//echo "<pre>";echo(" -PPPP- "); echo "</pre>";

 include_once("cumbari.php");
 $offerObj = new offer();
 $offerObj->saveCouponUsageHistory();

?>