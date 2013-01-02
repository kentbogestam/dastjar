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

//$inoutObj = new inOut();
//if(!isset($_SESSION['userid'])) {
//    $url = BASE_URL.'login.php';
//    $inoutObj->reDirect($url);
//    exit();
//}

$current_tab = basename($_SERVER['SCRIPT_FILENAME'], '.php');
$selected_tab_css = ' style="background-color:#ADDFFF" ';

?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="client/css/mouseovertabs.css">
<!--<script language="javascript" src="client/js/main.js" type="text/javascript" ></script>-->
<script language="javascript" src="client/js/mouseovertabs.js" type="text/javascript" ></script>


<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
.center{width:900px; margin-left:auto; margin-right:auto;}
-->
</style></head>
<body>
<div class="center">
<div id="yourtabsmenu" class="tabsmenuclass">
<ul>
<!--<li><a class="" href="main.php">Home</a></li>-->
<!--<li><a <?=$campaign?>  href="showCampaign.php" >Campaigns</a></li>-->
<li><a <?=$offer?>  href="showResellerCampaign.php" >Offers</a></li>

<!--<li><a <?=$standard?> href="showStandard.php" >Standard Offer</a></li>-->
<li><a <?=$report?> href="getResellerReportView.php" >Report</a></li>
<li><!--<a <?=$account?> href="getResellerFinancial.php" >Account</a>--></li>
<!--<li><a <?=$user?> href="viewNewUser.php" >User</a></li>-->

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
    <td><input type="radio" <?=$show?> onClick="javascript:window.location.href='showResellerCampaign.php'" name="deals">
      Campaign Offer </td>
    <td width="20">&nbsp;</td>
    <td><input type="radio" <?=$outdated?> onClick="javascript:window.location.href='showResellerCampaign.php?m=showcampoffer'" name="deals">
      Show Outdated Campaign </td>
  </tr>
  <tr>
    <td><input type="radio" <?=$showdelete?> onClick="javascript:window.location.href='showDeleteResellerCampaign.php'" name="deals">
      Show Deleted Campaign </td>
    <td width="20">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<!--<input style="margin-left:130px; margin-top:20px;"  type="radio" <?=$showstandard?> onClick="javascript:window.location.href='showResellerStandard.php'" name="deals">Standard Offer-->

<!--<input style="margin-left:130px; margin-top:20px;"  type="radio" <?=$showdeletestand?> onClick="javascript:window.location.href='showDeleteResellerStandard.php'" name="deals">Show Deleted Standard-->
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
    <td><input type="radio" <?=$add?> onClick="javascript:window.location.href='getResellerFinancial.php'" name="deals">
      Financial Details</td>
    <td width="20">&nbsp;</td>
    <td><input type="radio" <?=$deleted?> onClick="javascript:window.location.href='viewResellerUser.php'" name="deals">
      User Details </td>
  </tr>
</table>

<!--<input type="radio" <?=$companyshow?> onClick="javascript:window.location.href='viewComapany.php'" name="deals">Company Details<br>--><!--<input style=" padding-left:48px !ie ; margin-left:47px ;  "type="radio" <?=$usershow?> onClick="javascript:window.location.href='viewNewUser.php'" name="deals">
Users-->
</div>
<? } ?>
</div>
</body>
</html>