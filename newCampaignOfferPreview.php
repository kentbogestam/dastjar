<?php
/* File Name   : newCampaignOfferPreview.php
 *  Description : Preview of Campaign Offer on Iphone
 *  Author      : Sushil Singh  Date: 12th,Nov,2010  Creation
 */
header('Content-Type: text/html; charset=ISO-8859-15');
include_once("cumbari.php");
include_once("main.php");
$offerObj = new offer();
$inoutObj = new inOut();
if (isset($_POST['continue'])) {
    $_POST = $_SESSION['post'];
    $_POST['preview'] = 0;
    $offerObj->saveNewCampaignOffersDetails();
    exit();
} else if (isset($_POST['edit'])) {
    $url = BASE_URL . 'createCampaign.php?reedit=1';
    $inoutObj->reDirect($url);
}
include_once("header.php");
$categoryid = $_SESSION['preview']['category'];
$startdate = $_SESSION['preview']['start_time'];

$enddate = $_SESSION['preview']['end_time'];
//echo $categoryid;die();
$catName = $offerObj->getCategoryNameById($categoryid);
?>

<link rel="stylesheet" href="client/css/datePicker.css" type="text/css">

<script language="JavaScript" src="client/js/jquery.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/date.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/jquery.bgiframe.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/jquery.datePicker.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/ajaxupload.js" type="text/javascript"></script>


<script language="JavaScript" src="client/js/jsCampaignOffer.js" type="text/javascript"></script>


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

    <div id="message" align="center"><h2>&nbsp;

        </h2></div>
    <div align="center" style="display:inline;">
        <div align="center" >
            <h3> Check how your full campaign proposal look like.</h3>
        </div>

        <table width="270" align="center" border="0" cellpadding="0" cellspacing="0">
            <tr>

                <td  valign="top" style="background-image:url(client/images/iphone_large.png); width:270px; height:529px; background-repeat:no-repeat;"  >
                    <table width="100%" border="0">
                        <tr>
                            <td width="9%" height="96" >&nbsp;</td>
                            <td width="83%">&nbsp;</td>
                            <td width="8%">&nbsp;</td>
                        </tr>
                        <tr>
                            <td width="9%">&nbsp;</td>
                            <td><table border="0"><tr><td height="203" align="center" style="text-align:left;" ><img src="upload/coupon/<?=$_SESSION['preview']['large_image']
        ?>" width="213" height="143" /><br>
                                            <span style="padding-left:20px; font-size: 24px; font-weight: bold; color:#FFFFFF;"><?=$_SESSION['preview']['offer_slogan_lang_list']
        ?></span><br>
                                                                                                                 <span style="padding-left:20px;  color:#FFFFFF;"><?=$_SESSION['preview']['offer_sub_slogan_lang_list']
        ?></span>
                                           <!--<span style="padding-left:20px;  color:#FFFFFF;"><b>Category:</b><? echo $catName['categoryName']; ?></span><br>-->
                                        </td></tr>
                                    <tr>
                                        <td align="center" ><table width="100%" border="0" cellpadding="0" cellspacing="0">

                                                <tr>
                                                    <td width="7%">&nbsp;</td>
                                                    <td width="51%" align="left" style=" color:#FFFFFF; font-size:12px;"><b>Store Name</b><? //=$_SESSION['preview']['product_number']
        ?></td>
                                                    <td width="42%" style=" color:#FFFFFF; font-size:12px;"><b>City</b></td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <td style=" color:#FFFFFF; font-size:12px;"><b>Street</b><? //=$_SESSION['preview']['product_number']
        ?></td>
                                                    <td style=" color:#FFFFFF; font-size:12px;"><? echo $startdate; ?>-<? echo $enddate; ?></td>
                                                </tr>
                                            </table></td>
                                    </tr>
                                </table></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                    </table>


                </td>

            </tr>


        </table>

    </div>
    <div align="center">
        <form action="" method="post"><br />
<br />

            <input type="submit" value="Save & Continue" name="continue" id="continue"  class="button"/>
            <input type="submit" value="Back to Edit" name="edit" id="edit" class="button" />
        <br />
		<br />
</form>
    </div>
    <? include("footer.php"); ?>
</form>
