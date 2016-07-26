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
    $offerObj->saveNewCouponStandardDetails();
    exit();
} else if (isset($_POST['edit'])) {
    echo $url = BASE_URL . 'addCouponStandStore.php?productId='.$_GET['productId'];
    $inoutObj->reDirect($url);
}

include_once("header.php");
$startdate = $_SESSION['preview']['start_time'];
 $enddate = $_SESSION['preview']['end_time'];
  $storeId = $_SESSION['preview']['store_id'];
  $data=$offerObj->getStoreNameById($storeId);

   //print_r($storeName);
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

        <?php
        if ($_SESSION['MESSAGE']) {
            echo $_SESSION['MESSAGE'];
            $_SESSION['MESSAGE'] = "";
        }
        ?>
    </div>
    <div align="center" style="display:inline;">
        <div align="center" >
            <h3> Check how your full proposal look like.</h3>
        </div>
        <table width="200" align="center" border="0" cellpadding="0" cellspacing="0" style="background-image:url(client/images/iphone_large.png); width:270px; height:529px; background-repeat:no-repeat;">
            <tr>
                <td width="1" height="110">&nbsp;</td>
              <td colspan="3"></td>
                <td width="1">&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td width="25" height="195" ></td>
                <td style="text-align:left; vertical-align: top;" width="200">
                <img src="upload/coupon/<?=$_SESSION['preview']['large_image']
                                 ?>"  width="220" height="133"><br>
                    <span style="padding-left:15px; font-size: 24px; font-weight: bold; color:#FFFFFF;"><?=$_SESSION['preview']['offer_slogan_lang_list']
                                ?></span><br>
                    <span style="padding-left:20px;color:#FFFFFF;"><?=$_SESSION['preview']['offer_sub_slogan_lang_list']
                                ?></span>
              <!-- <br>
                    <span style="padding-left:20px;"><b>Brand Name:</b><?//=$_SESSION['post']['standOfferName']
                                ?></span><br>
                    <span style="padding-left:20px;"><b>Category:</b><?//=$_SESSION['post']['linkedCatStand']
                                ?></span><br>-->                </td>
              <td width="20"></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td height="150" ></td>
              <td style="text-align:left; vertical-align: top;"><table width="98%" border="0" cellpadding="0" cellspacing="0">
                           
    <tr>
                              <td width="7%">&nbsp;</td>
                              <td width="51%" align="left" style=" color:#FFFFFF; font-size:12px;"><b><?echo $data[store_name]; ?></b><?//=$_SESSION['preview']['product_number']
                                            ?></td>
                              <td width="42%" style=" color:#FFFFFF; font-size:12px;"><?echo $data[city]; ?></td>
    </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td style=" color:#FFFFFF; font-size:12px;"><?echo $data[street]; ?><?//=$_SESSION['preview']['product_number']
                                            ?></td>
                              <td style=" color:#FFFFFF; font-size:12px;"><?echo $startdate;?>-<?echo $enddate;?></td>
                            </tr>
                          </table></td>
              <td></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td colspan="3"></td>
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