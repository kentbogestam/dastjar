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
//print_r($_POST);
//$regObj->isValidRegistrationStep(3);
//$regObj->isValidRegistrationStep(1);
//print_r($_SESSION);
//echo $_SESSION['preview']['large_image'];
$inoutObj = new inOut();
if (isset($_POST['continue'])) {
    $_POST = $_SESSION['post'];
    $_POST['preview'] = 0;
    $offerObj->saveCampaignOffersDetails();
    exit();
} else if (isset($_POST['edit'])) {
    $url = BASE_URL . 'campaignOffer.php?reedit=1';
    $inoutObj->reDirect($url);
}

if (($_SESSION['userid']) && $_SESSION['REG_STEP'] == 3) {
    $url = BASE_URL . 'registrationStep.php';
    $inoutObj->reDirectUrl($url);
}
include_once("header.php");
$categoryid = $_SESSION['preview']['category'];
$startdate = $_SESSION['preview']['start_time'];

$enddate = $_SESSION['preview']['end_time'];
//echo $categoryid;
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
    /*
    .style4 {
        font-size: 10px;
        font-weight: bold;
    }
    .style6 {font-size: 9px}.center{width:900px; margin-left:auto; margin-right:auto;}
    */
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
                <td width="4" height="86">&nbsp;</td>
                <td colspan="3">&nbsp;</td>
                <td width="5">&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td width="26" height="199" >&nbsp;</td>
                <td valign="top" style="text-align:left; " width="225"><br>
                        <img src="upload/coupon/<?=$_SESSION['preview']['large_image']
                                     ?>" width="212" height="142" /><br>
                        <span style=" color:#FFFFFF;">
                            <span style=" font-size: 20px; font-weight: bold; color:#FFFFFF;">
                                <?=$_SESSION['preview']['offer_slogan_lang_list']
                                        ?><br /></span>

                            <?=$_SESSION['preview']['offer_sub_slogan_lang_list']
                                    ?>
                        </span>


             <!-- <span style="padding-left:20px; color:#FFFFFF;"><b>Category:</b><? //echo $catName['categoryName'];    ?></span><br>-->
                    </td>
                <td width="10" ></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td height="73" >&nbsp;</td>
                <td style="text-align:left; vertical-align: top;"><table width="104%" border="0" cellpadding="0" cellspacing="0">

                        <tr>
                          
                            <td width="51%" align="left" style=" color:#FFFFFF; font-size:12px;"><strong>Store Name</strong><? //=$_SESSION['preview']['product_number']
                                ?></td>
                            <td width="42%" style=" color:#FFFFFF; font-size:12px;"> <strong>City</strong></td>
                        </tr>
                        <tr>
                           
                            <td height="20" style=" color:#FFFFFF; font-size:12px;"><strong>Street</strong><? //=$_SESSION['preview']['product_number']
                                ?></td>
                            <td style=" color:#FFFFFF; font-size:12px;"><? echo $startdate; ?>-<? echo $enddate; ?></td>
                        </tr>
                    </table></td>
                <td ></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td colspan="3">&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        </table>
    </div>
    <div align="center">
        <form action="" method="post">
<br /><br />
            <INPUT type="submit" value="Save&Continue" name="continue" id="continue" class="button" >
            <INPUT type="submit" value="Back to Edit" name="edit" id="edit" class="button" >
<br /><br />
        </form>
        <!--<form action="" method="post">
            <div align="center">
                <INPUT type="submit" value="Back to edit" name="edit" id="edit" class="button" >
            </div>
        </form>-->
    </div>
 
</form>
</div>
<? include("footer.php"); ?>
</body>