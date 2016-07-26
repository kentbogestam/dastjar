<?php
/* File Name   : campaignOfferPreview.php
 *  Description : Preview of Campaign Offer on Iphone
 *  Author      : Sushil Singh  Date: 12th,Nov,2010  Creation
 */
header('Content-Type: text/html; charset=utf-8');
include_once("cumbari.php");
$offerObj = new offer();
$regObj = new registration();
$inoutObj = new inOut();
if (isset($_POST['continue'])) {
    $_POST = $_SESSION['post'];
    $_POST['preview'] = 0;
    $offerObj->saveNewStandardOffersDetails();
    exit();
} else if (isset($_POST['edit'])) {
    $url = BASE_URL . 'createStandardOffer.php?reedit=1';
    $inoutObj->reDirect($url);
}
include_once("header.php");
$categoryid = $_SESSION['preview']['category'];
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
<div class="center">
<form name="register" action="" id="registerform" method="Post" enctype="multipart/form-data">

    <div id="message" align="center"><h2>&nbsp;

        </h2></div>
    <div id="msg" align="center">

       
    </div>
    <div align="center" style="display:inline;">
        <div align="center" >
            <h3> Check how your full proposal look like.</h3>
        </div>
        <table width="294" align="center" border="0" cellpadding="0" cellspacing="0">
            <tr>

                <td width="290" align="center"  valign="top" style="background-image:url(client/images/iphone_large.png); width:290px; height:529px; background-repeat:no-repeat;">
                    <table width="84%" border="0">
                        <tr>
                            <td height="107" style="text-align:left; vertical-align: top;">&nbsp;</td>
                        </tr>
                        <tr><td align="left"  style=" vertical-align: top;" width="236">
                                <img src="upload/coupon/<?=$_SESSION['preview']['large_image']
        ?>" width="222" height="142"><br>
                                <span style="padding-left:20px; font-size: 24px; font-weight: bold; color:#FFFFFF;"><?=$_SESSION['preview']['offer_slogan_lang_list']
        ?></span><br>
                                 <span style="padding-left:20px; color:#FFFFFF;"><?=$_SESSION['preview']['offer_sub_slogan_lang_list']
        ?></span>
                                <!--<br>
                                <span style="padding-left:20px; color:#FFFFFF;"><b>Brand Name:</b><? //=$_SESSION['post']['standOfferName']
        ?></span><br>
                                    <span style="padding-left:20px; color:#FFFFFF;"><b>Category:</b><? echo $catName['categoryName']; ?></span><br>-->
                                </td></tr>
                            <tr>
                                <td align="left"  style=" vertical-align: top;"><table width="100%" border="0" cellpadding="0" cellspacing="0">

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
                                        <td style=" color:#FFFFFF; font-size:12px;"><b>Limit Period </b></td>
                                    </tr>
                                </table></td>
                        </tr>
                    </table>

                </td>

            </tr>
        </table>
    </div>
    <div align="center" ><br />
<br />

        <form action="" method="post">
            <INPUT type="submit" value="Save&Continue" class="button" name="continue" id="continue"  >
            <INPUT type="submit" value="Back to Edit" class="button" name="edit" id="edit" >
        <br />
		<br />
</form>
    </div>
    <!--<form action="" method="post">
    <INPUT type="submit" value="Back to edit" class="button" name="edit" id="edit" >
    </form>-->

</form></div>
<? include("footer.php"); ?>