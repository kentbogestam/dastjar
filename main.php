<?php
/*  File Name   : main.php
*   Description : Main form
*   Author      : Deo
*   Date        : 4th,Dec,2010  Creation
*/

include_once("cumbari.php");

$inoutObj = new inOut();
$inoutObj->validSteps();
//$regObj = new registration();
//$regObj->isValidRegistrationStep();
include("header.php");

unset($_SESSION["Retailers"]);

$current_tab = basename($_SERVER['SCRIPT_FILENAME'], '.php');
$selected_tab_css = ' style="background-color:#ADDFFF" ';

?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="client/css/mouseovertabs.css">
<!--<script language="javascript" src="client/js/main.js" type="text/javascript" ></script>-->
<script language="javascript" src="client/js/mouseovertabs.js" type="text/javascript" ></script>


<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
/*.center{width:900px; margin-left:auto; margin-right:auto;}
*/
</style>

</head>
<body>
<div class="center">
<div id="yourtabsmenu" class="tabsmenuclass">
<ul>
<!--<li><a class="" href="main.php">Home</a></li>-->
<!--<li><a <?=$campaign?>  href="showCampaign.php" >Campaigns</a></li>-->
<!--<li><a <?=$offer?>  href="showCampaign.php" >Offers</a></li>-->
<li><a <?=$store?> href="showStore.php" >Locations</a></li>
<li><a <?=$dishType?> href="showDishes.php" >Add Type of Dishes</a></li>
<li><a <?=$offer?>  href="showStandard.php" >Menu</a></li>
<!--<li><a <?=$standard?> href="showStandard.php" >Standard Offer</a></li>-->
<!--<li><a <?=$report?> href="getReportView.php" >Report</a></li>-->
<li><a <?=$account?> href="getFinancial.php" >Account</a></li>
<!--<li><a <?=$user?> href="viewNewUser.php" >User</a></li>-->
<!--<li><a <?=$brand?> href="getBrandView.php" >Brand</a></li>-->
<!--<li><a <?=$aboutUs?> href="aboutUs.php" >About Us</a></li>-->
</ul>
</div>
<? if($menu=="offer"){?>
<!--<div id="yoursubmenuarea" class="tabsmenucontentclass">

<div style="display:inline;" class="tabsmenucontent" id="step1">
<ul>
<li><a <?=$add?> href="createCampaign.php">Add Campaign</a></li>
<li><a <?=$show?> href="showCampaign.php">Show Campaign</a></li>
<li><a <?=$outdated?>  href="showCampaign.php?m=showcampoffer">Show Outdated Campaign</a></li>
</ul>
</div>
</div>-->
<div class="frm_cls">
<table border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
  <!--<tr>
    <td nowrap><input type="radio" <?=$show?> onClick="javascript:window.location.href='showCampaign.php'" name="deals">
Campaign Offer </td>
    <td nowrap><input type="radio" <?=$outdated?> onClick="javascript:window.location.href='showCampaign.php?m=showcampoffer'" name="deals">
      Show Outdated Campaign </td>
    <td nowrap><input type="radio" <?=$showdelete?> onClick="javascript:window.location.href='showDeleteCampaign.php'" name="deals">
      Show Deleted Campaign </td>
    
    
   
  </tr>
  <tr>
    <td nowrap><input type="radio" <?=$showadvertise?> onClick="javascript:window.location.href='showAdvertise.php'" name="deals">
      Advertise Offer </td>  
      
     <td nowrap><input type="radio" <?=$outdatedadvertise?> onClick="javascript:window.location.href='showAdvertise.php?m=showadvtoffer'" name="deals">
      Show Outdated Advertise </td>
      
     <td><input type="radio" <?=$showdeleteadvertise?> onClick="javascript:window.location.href='showDeleteAdvertise.php'" name="deals">
Show Deleted Advertise </td>
      </tr>
  <tr> -->
     
    <td><input type="radio" <?=$showstandard?> onClick="javascript:window.location.href='showStandard.php'" name="deals">
      Dish </td>
    
    <td><input type="radio" <?=$showdeletestand?> onClick="javascript:window.location.href='showDeleteStandard.php'" name="deals">
Show Deleted Dish </td>
    
  
    <td width="20">&nbsp;</td>    
  </tr>
</table>

</div>
<? } ?>
<? if($menu=="dishType"){
if (basename($_SERVER['SCRIPT_FILENAME']) == 'newCreateStore.php')
{
  $show = 'checked="checked"';
}
?>

<div class="frm_cls-2">
  <table border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td nowrap><input type="radio"  <?=$show?> onClick="javascript:window.location.href='showDishes.php?m=showDishes'" name="deals">
      Dish Type </td>
      <td width="20">&nbsp;</td>
      <td nowrap><input type="radio" <?=$deleted?> onClick="javascript:window.location.href='showDishes.php?m=showDeletedDishes'" name="deals">
      Show Deleted Dish Type</td>
    </tr>
  </table>
</div>
<? } ?>
<? if($menu=="store"){
if (basename($_SERVER['SCRIPT_FILENAME']) == 'newCreateStore.php')
{
	$show = 'checked="checked"';
}
?>

<div class="frm_cls-2">
  <table border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td nowrap><input type="radio"  <?=$show?> onClick="javascript:window.location.href='showStore.php'" name="deals">
Locations </td>
      <td width="20">&nbsp;</td>
      <td nowrap><input type="radio" <?=$deleted?> onClick="javascript:window.location.href='showStore.php?m=showOutdatedStore'" name="deals">
      Show Deleted Locations</td>
    </tr>
  </table>
</div>
<? } ?>
<? if($menu=="standard"){?>
<!--<div id="yoursubmenuarea" class="tabsmenucontentclass">
<div style="display: inline;" class="tabsmenucontent" id="step3">
<ul>
<li><a <?=$add?> href="createStandardOffer.php">Add Standard Offer</a></li>
<li><a <?=$show?> href="showStandard.php?m=showStandoffer">Show Standard</a></li>
</ul>
</div>
</div>-->
<!--<div style="color:#851B22; font-weight:bold; font-size:14px; margin-top: 10px;">
<input style="margin-left:250px;" type="radio" <?=$add?> onClick="javascript:window.location.href='createStandardOffer.php'" name="deals">Add Standard Offer
<input style="margin-left:25px;" type="radio" <?=$show?> onClick="javascript:window.location.href='showStandard.php'" name="deals">Show Standard
</div>-->
<? } ?>
<? if($menu=="report"){?>

<? } ?>
<? if($menu=="account"){?>
<!--<div id="yoursubmenuarea" class="tabsmenucontentclass">
<div style="display: inline;" class="tabsmenucontent" id="step4">
<ul>
<li><a <?=$add?> href="getFinancial.php">Financial Details</a></li>
<li><a <?=$show?> href="viewComapany.php">Company Details</a></li>
<li><a <?=$deleted?> href="viewUser.php">User Details</a></li>

</ul>
</div>
</div>-->


<div class="frm_cls">
<table border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><input type="radio" <?=$add?> onClick="javascript:window.location.href='getFinancial.php'" name="deals">
   Financial Details</td>
    <td width="20">&nbsp;</td>
    <td>
      <input type="radio" <?=$companyshow?> onClick="javascript:window.location.href='viewComapany.php'" name="deals">
    Company Details</td>
  </tr>
    <tr>
    <td align="left">
<input type="radio" <?=$deleted?> onClick="javascript:window.location.href='viewUser.php'" name="deals"> 
User Details </td>
    <td width="20">&nbsp;</td>
    <td>
      <input type="radio" <?=$usershow?> onClick="javascript:window.location.href='viewNewUser.php'" name="deals">
Users </td>
  </tr>
  <tr>
    <td><input type="radio" <?php echo isset($is_discount_show) ? $is_discount_show : ''; ?> onClick="javascript:window.location.href='list-discount.php'" name="deals">User Discount</td>
  </tr>
</table>
</div>
<? } ?>
</div>
</body>
</html>
