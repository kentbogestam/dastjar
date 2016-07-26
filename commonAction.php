<?php
/*  File Name   : CommonAction.php
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
        $regObj->emailVarification($_GET['vcode']);
        break;
    case 'logout':
        $inOutObj = new inOut();
        $inOutObj->usrLogout();
        break;

     case 'supportlogout':
        $inOutObj = new inOut();
        $inOutObj->supportLogout();
        break;

    case 'createCoupon':
        //echo "Inside"; die();
        $offerObj = new offer();
        $offerObj->createCoupons();
        break;

  

    case 'deleteCoupon':
         //echo "Inside"; die();
        $offerObj = new offer();
        $offerObj->deleteCoupons();
        break;

      case 'showCoupon':
         //echo "Inside"; die();
        $offerObj = new offer();
        $offerObj->showCoupons();
        break;

    case 'deleteViewStore':
         
        $offerObj = new offer();
        $offerObj->deleteViewStore();
        break;

    case 'deleteViewAdvertiseStore':
        $offerObj = new offer();
        $offerObj->deleteViewAdvertiseStore();
        break;

    case 'deleteViewstandStore':
  
       $standardObj = new offer();
        $standardObj->deleteViewstandStore();
        break;

    case 'ccodeIdActive':
        $supportObj = new support();
        $cid = $_REQUEST['cId'];
        $supportObj->changeStatusActive($cid);
        break;

     case 'ccodeIdDeactive':
        $supportObj = new support();
        $cid = $_REQUEST['cId'];
        $supportObj->changeStatusDeactive($cid);
        break;


}
?>