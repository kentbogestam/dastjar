<?php

    //ob_start();
    header ('Content-type: text/html; charset=utf-8');    
    //header('Content-Type: text/html; charset=utf-8');
    
    include_once("cumbari.php");
    $createCouponObj = new offer();
    $createCouponObj->createCoupons();
?>

