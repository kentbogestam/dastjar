<?php
/* File Name   : advertiseOfferPreview.php
 *  Description : Preview of Advertise Offer on Iphone
 *  Author      : Sushil Singh  Date: 12th,Nov,2010  Creation
 */
header('Content-Type: text/html; charset=utf-8');
include_once("cumbari.php");
include_once("main.php");
$offerObj = new offer();
$regObj = new registration();
$inoutObj = new inOut();
if ($_POST['continue'] == "Save & Continue") {
    $advertiseid = $_POST['advertiseId'];
    $offerObj->editSaveAdvertise($advertiseid);
} else if (isset($_POST['edit'])) {
    $url = BASE_URL . 'editAdvertise.php?advertiseId=' . $_POST['advertiseId'] . '&reedit=1';
    $inoutObj->reDirect($url);
}
include_once("header.php");
 $categoryid = $_SESSION['preview']['linkedCat'];
 $startdate = $_SESSION['preview']['startDateLimitation'];
 
 $enddate = $_SESSION['preview']['endDateLimitation'];
 $catName=$offerObj->getCategoryNameById($categoryid);
 //print_r($catName);
  // echo $_SESSION['preview']['large_image']; die();
// die();
//print_r($_SESSION['preview']);

$enddate = $_SESSION['preview']['endDateLimitation'];
$catName = $offerObj->getCategoryNameById($categoryid);
?>

<link rel="stylesheet" href="client/css/datePicker.css" type="text/css">

<script language="JavaScript" src="client/js/jquery.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/date.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/jquery.bgiframe.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/jquery.datePicker.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/ajaxupload.js" type="text/javascript"></script>


<script language="JavaScript" src="client/js/jsAdvertiseOffer.js" type="text/javascript"></script>



<style type="text/css">
    <!--
    .style4 {
        font-size: 10px;
        font-weight: bold;
    }
    .style6 {font-size: 9px}
    -->
</style>
<form name="register" action="" id="registerform" method="Post" enctype="multipart/form-data">
    <input type="hidden" name="advertiseId" value="<?=$_GET['advertiseId']
?>">
    <div id="msg" align="center">


    </div>
    <div align="center" style="display:inline; color:#7d161c; font-size:18px;">
        <div align="center" >
            <h3> Check how your full advertise proposal look like.</h3>
        </div>
        <table width="290" align="center" border="0" cellpadding="0" cellspacing="0">


            <tr>
                <td>&nbsp;</td>
                <td align="center" width="290" valign="top"  style="background-image:url(client/images/iphone_large.png); width:290px; height:529px; background-repeat:no-repeat;">
                    <table border="0" width="80%">
                        <tr>
                            <td height="106" style="text-align:left; vertical-align: top;">&nbsp;</td>
                        </tr>
                        <tr><td width="223" height="200" align="center" style="text-align:left; vertical-align: top;">
                                <img src="upload/coupon/<?
                                
								$icon_new = explode("/",$_SESSION['preview']['large_image']);
								$iconlngth = count($icon_new);
								echo $icon_new[$iconlngth-1]; 
								?>" width="213" height="141"><br>
                                <span style="padding-left:20px; font-size: 24px; font-weight: bold; color:#FFFFFF;"><?=$_SESSION['preview']['offer_slogan_lang_list']
?></span><br>
                                <span style="padding-left:20px; font-weight: bold; color:#FFFFFF;"><?=$_SESSION['preview']['offer_sub_slogan_lang_list']
?></span><br>


                            </td></tr>
                        <tr>
                            <td align="center" style="text-align:left; vertical-align: top;"><table width="100%" border="0" cellpadding="0" cellspacing="0">

                                    <tr>
                                        <td width="7%">&nbsp;</td>
                                        <td width="51%" align="left" style=" color:#FFFFFF; font-size:12px;"><b>Store Name</b><? //=$_SESSION['preview']['product_number']  ?></td>
                                        <td width="42%" style=" color:#FFFFFF; font-size:12px;"><b>City</b></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td style=" color:#FFFFFF; font-size:12px;"><b>Street</b><? //=$_SESSION['preview']['product_number']  ?></td>
                                        <td style=" color:#FFFFFF; font-size:12px;"><? echo $startdate; ?>-<? echo $enddate; ?></td>
                                    </tr>
                                </table></td>
                        </tr>
                    </table>


                </td>
                <td>&nbsp;</td>
            </tr>
        </table>
    </div>
    <div align="center"><br />
<br />


        <INPUT type="submit" value="Save & Continue" name="continue" id="continue" class="button" >


        <INPUT type="submit" value="Back to Edit" name="edit" id="edit" class="button" >

    <br />
    <br />
    </div>
    <div><? include("footer.php"); ?></div>

</form>
</body>