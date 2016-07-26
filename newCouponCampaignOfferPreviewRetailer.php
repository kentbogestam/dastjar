<?php
/* File Name   : campaignOfferPreview.php
 *  Description : Preview of Campaign Offer on Iphone
 *  Author      : Sushil Singh  Date: 12th,Nov,2010  Creation
 */
header('Content-Type: text/html; charset=utf-8');
include_once("cumbari.php");
//include_once("classes/registration.php");
$offerObj = new offer();
$regObj = new registration();
//$storeObj = new store();
$inoutObj = new inOut();
$_GET['campaignId'];
if (isset($_POST['continue'])) {
    $_POST = $_SESSION['post'];
    $_POST['preview'] = 0;
    $offerObj->saveNewCouponDetails();
    exit();
} else if (isset($_POST['edit'])) {
    $url = BASE_URL . 'addCouponStore..php?campaignId='.$_GET['campaignId'];
    $inoutObj->reDirect($url);
}

if (($_SESSION['userid']) && $_SESSION['REG_STEP'] == 3) {
    $url = BASE_URL . 'showCampaign.php';
    $inoutObj->reDirectUrl($url);
}
include_once("header.php");
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
</style><div class="center">
<form name="register" action="" id="registerform" method="Post" enctype="multipart/form-data">
    <div id="message" align="center"><h2>&nbsp;

        </h2></div>
    <div id="msg" align="center">

        <?php
        if ($_SESSION['MESSAGE']) {
            echo $_SESSION['MESSAGE'];
            $_SESSION['MESSAGE'] = "";
        }
        ?>
    </div>
    <div align="center" style="display:inline;">
        <div align="center" >
            <h3> Check how your full campaign proposal look like.</h3>
        </div>
        <table width="200" align="center" border="0" cellpadding="0" cellspacing="0" style="background-image:url(client/images/iphone_large.png); width:270px; height:529px; background-repeat:no-repeat;">
            <tr>
                <td width="1">&nbsp;</td>
                <td colspan="3">&nbsp;</td>
                <td width="1">&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td width="25" height="150" >&nbsp;</td>
                <td style="text-align:left; vertical-align: top;" width="200">
                    <img src="upload/coupon/<?=$_SESSION['preview']['large_image']
        ?>" width="200" height="160"><br>
                    <span><hr /></span>
                    <span style="padding-left:20px; font-size: 24px; font-weight: bold;"><?=$_SESSION['preview']['offer_slogan_lang_list']
        ?></span><br>
                     <span style="padding-left:20px;"><?=$_SESSION['preview']['offer_sub_slogan_lang_list']
        ?></span><br>

                    <span style="padding-left:20px;"><b>Brand Name:</b><?=$_SESSION['post']['brandName']
        ?></span><br>
                    <span style="padding-left:20px;"><b>Category:</b><?=$_SESSION['post']['linkedCat']
        ?></span><br>
                </td>
                <td width="20" ></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td colspan="3">&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        </table>
    </div>
    <div align="center"><br>
        <form action="" method="post">
            <div align="center">
                <INPUT type="submit" value="Save & Continue" name="continue" id="continue" class="button" >
            </div>
        </form>
        <form action="" method="post">
            <div align="center">
                <INPUT type="submit" value="Back to edit" name="edit" id="edit" class="button" >
            </div>
        </form>
    </div>
</form></div>
</body>