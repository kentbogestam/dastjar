<?php
/*  File Name    : ViewsCoupon.php
 *   Description : Calculate deduction amount for total views
 *   Author      : Prashant kr. Awasthi
 *   Date        : 20th,Feb,2013  Creation
 */
//ob_start();
header ('Content-type: text/html; charset=utf-8');
//header('Content-Type: text/html; charset=utf-8');

 include_once("cumbari.php");
 $offerObj = new offer();
 $offerObj->saveViewsCoupon();
?>