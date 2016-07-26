<?php
/* File Name   : campaignOfferPreview.php
 *  Description : Preview of Campaign Offer on Iphone
 *  Author      : Sushil Singh  Date: 12th,Nov,2010  Creation
*/
header('Content-Type: text/html; charset=utf-8');
include_once("cumbari.php");
include_once("main.php");


//include_once("classes/registration.php");
$offerObj = new offer();
$regObj = new registration();

$inoutObj = new inOut();
if ($_POST['continue'] == "Save & Continue") {
    $productid = $_POST['productId'];
    $offerObj->editSaveDeleteProduct($productid);
} else if (isset($_POST['edit'])) {
    $productid = $_POST['productId'];
    $url = BASE_URL . 'editDeleteStandard.php?productId=' . $productid . '&reedit=1';
    $inoutObj->reDirect($url);
}
include_once("header.php");
$categoryid = $_SESSION['preview']['linkedCatStand'];
//echo $categoryid;die();
$catName=$offerObj->getCategoryNameById($categoryid);
//print_r($catName);
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
    <input type="hidden" name="productId" value="<?=$_GET['productId']?>">
    <div id="msg" align="center">


    </div>
    <div align="center"  style="display:inline; color:#7d161c; font-size:18px;"">
        <div align="center">
            <h3> Check how your full campaign proposal look like.</h3>
        </div>
        <table width="290" align="center" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td width="0">&nbsp;</td>
                <td valign="top" align="center" style="background-image:url(client/images/iphone_large.png); width:290px; height:529px; background-repeat:no-repeat;" >
                    <table border="0">
                        <tr>
                            <td height="102" valign="top" style="text-align:left; vertical-align: top;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td valign="top" align="left" style="vertical-align: top; " width="237">
                           <img src="upload/coupon/<?=$_SESSION['preview']['large_image']
                                             ?>" width="221" height="147"><br>
                               <span style="padding-left:20px; font-size: 24px; font-weight: bold; color:#FFFFFF;"><b></b><?=$_SESSION['preview']['offer_slogan_lang_list']
//                                            ?></span>
                               <!--<span style="padding-left:20px; color:#FFFFFF; "><b>Product Name:</b><?//=$_SESSION['preview']['product_name']
//                                        ?></span><br>
                                <span style="padding-left:20px; color:#FFFFFF;"><b>Brand Name:</b><?//=$_SESSION['preview']['brand_name']
                                            ?></span><br>
                                <span style="padding-left:20px; color:#FFFFFF;"><b>Product Number:</b><?//=$_SESSION['preview']['product_number']
                                            ?></span><br>
                                <span style="padding-left:20px; color:#FFFFFF; "><b>Category:</b><?//echo $catName['categoryName'];
                                    ?></span><br>-->
                            <!-- <span style="padding-left:20px; color:#FFFFFF;"><b>Store Name:</b><?//=$_SESSION['preview']['product_number']
                                            ?></span><br>
                                            <span style="padding-left:20px; color:#FFFFFF;"><b>Product Number:</b><?//=$_SESSION['preview']['product_number']
                                            ?></span>-->                            </td></tr>
                        <tr>
                          <td valign="top" align="center" style="vertical-align: top;"><table width="89%" border="0" cellpadding="0" cellspacing="0">

                              <td width="7%">&nbsp;</td>
                              <td width="44%" align="left" style=" color:#FFFFFF; font-size:12px;"><b>Store Name</b><?//=$_SESSION['preview']['product_number']
                                            ?></td>
                              <td width="49%" style=" color:#FFFFFF; font-size:12px;"><b>City</b></td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td style=" color:#FFFFFF; font-size:12px;"><b>Street</b><?//=$_SESSION['preview']['product_number']
                                            ?></td>
                              <td style=" color:#FFFFFF; font-size:12px;"><b>Limit Period </b></td>
                            </tr>
                          </table></td>
                        </tr>
							</table>
                </td>
                <td width="1">&nbsp;</td>
            </tr>
        </table>
    </div>
    <div align="center"><br>

        <INPUT type="submit" value="Save & Continue" name="continue" id="continue" class="button" >


        <INPUT type="submit" value="Back to edit" name="edit" id="edit" class="button" >

    <br />
    <br />
    </div>
    <div><? include("footer.php"); ?></div>

</form>
</body>