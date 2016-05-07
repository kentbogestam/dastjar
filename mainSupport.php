<?php
/*  File Name   : main.php
*   Description : Main form
*   Author      : Deo
*   Date        : 4th,Dec,2010  Creation
*/

include_once("cumbari.php");
 include("headersupport.php");
$inoutObj = new inOut();

//$regObj = new registration();
//$regObj->isValidRegistrationStep();




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


<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><style type="text/css">
<!--
.center{width:900px; margin-left:auto; margin-right:auto;}

-->
</style></head>
<body>
<div class="center">
<div id="yourtabsmenu" class="tabsmenuclass">
<ul>

<li><a <?=$user?> href="userActivity.php" >User Activity</a></li>
<li><a <?=$cat?> href="showCategory.php" > Category</a></li>
<li><a <?=$partner?> href="showPartner.php" > Partner</a></li>
<li><a <?=$ccode?> href="showCcode.php">CCode</a></li>
<li><a <?=$import?> href="import.php">Import</a>
<li><a <?=$delete?> href="showPermntDeleteCampaign.php">Delete</a>
<li><a <?=$location?> href="locationSupport.php">Add Location</a>


</ul>
</div>

    <? if($menu == "delete"){?>
    <div class="frm_cls">
<table border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td nowrap><input type="radio" <?=$dcamp?> onClick="javascript:window.location.href='showPermntDeleteCampaign.php'" name="deals">
Delete Campaign  </td>
    <td width="20">&nbsp;</td>
   
  </tr>
  <tr>
    <td><input type="radio" <?=$dstand?> onClick="javascript:window.location.href='showPermntDeleteStandard.php'" name="deals">
     Delete Standard  </td>
    <td width="20">&nbsp;</td>
   
  </tr>
  <tr>
    <td nowrap><input type="radio" <?=$dstore?> onClick="javascript:window.location.href='showPermanentDeleteStore.php'" name="deals">
       Delete Store </td>
    <td width="20">&nbsp;</td>
   
  </tr>
</table>
    </div>
    <? } ?>

</div>

    

</body>
</html>
