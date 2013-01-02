<?php
/*  File Name  : viewCampaign.php
 *  Description : View campaign Form
 *  Author      : Himanshu Singh  Date: 22nd,dec,2010  Creation
*/
header('Content-Type: text/html; charset=ISO-8859-15');
include_once("cumbari.php");
$offerObj = new offer();
$regObj = new registration();

if (isset($_POST['continue'])) {
    $offerObj->svrOfferDflt();
} else {
    $campaignid = $_GET['campaignId'];
    $data = $offerObj->viewDeleteCampaignDetailById($campaignid);
}
//echo "<pre>";print_r($data);echo "</pre>";
 $ownerName = $regObj->getOwnerName($data[0]['u_id']);
$menu = "campaign";
$campaign = 'class="selected"';
if ($_GET['m'] == "showcampoffer")
    $outdated = 'class="selected"';
else
    $show = 'class="selected"';
$reseller = $_REQUEST['from'];
if($reseller == '')
{
    include_once("main.php");
}else {
     include_once("mainReseller.php");
}
?>
<?php include 'config/defines.php'; ?>
<link href="client/css/stylesheet123.css" rel="stylesheet" type="text/css" />
<!--<script type="text/javascript" src="lib/vtip/js/jquery.js"></script>
<script type="text/javascript" src="lib/vtip/js/vtip.js"></script>
<link rel="stylesheet" type="text/css" href="lib/vtip/css/vtip.css" />-->
<META http-equiv="Content-Type" content="text/html; charset=ISO-8859-15">
<link rel="stylesheet" href="client/css/datePicker.css" type="text/css">
<link href="lib/grid/css/grid.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="client/js/jquery.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/date.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/jquery.bgiframe.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/jquery.datePicker.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/ajaxupload.js" type="text/javascript"></script>
<!--<script language="JavaScript" src="client/js/jsCampaignOffer.js" type="text/javascript"></script>-->
<style type="text/css">
<!--
.style4 {
	font-size: 10px;
	font-weight: bold;
}
.style6 {
	font-size: 9px
}
-->
</style>
<body>
<div class="center">
  <form name="register" action="" id="registerform" method="Post" enctype="multipart/form-data">
    <div class="top_h1">View Deleted Campaign Offers</div>
    <div style="clear:both"></div>
    <div class="bg_darkgray123" align="center"> Your Campaign View </div>
    <table width="60%" BORDER=0 align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="50%" align="left" valign="top" class="td_pad_left_2"><b>Title Slogan for your Campaign:</b> </td>
        <td width="50%" align="left" valign="top" class="td_pad_right_2"><?=$data[0]['slogan'] ?></td>
      </tr>
      <tr>
        <td width="50%" align="left" valign="top" class="td_pad_left_2"><b> Sub Slogan for your Campaign:</b> </td>
        <td width="50%" align="left" valign="top" class="td_pad_right_2"><?=$data[0]['subslogen'] ?></td>
      </tr>
      <tr>
        <td width="50%" align="left" valign="top" class="td_pad_left_2"><b>Icon: </b></td>
        <td width="50%" align="left" valign="top" class="td_pad_right_2"><img src="<?=$data[0]['small_image'] ?>" width="50" border="0"> 
      </tr>
    </table>
    <table width="60%" BORDER=0  align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="50%" class="td_pad_left_2"><b> Sponsored:</b></td>
        <td width="50%" class="td_pad_right_2"><? $d = $data[0]['spons'] ?>
          <?php if ($d == 0)
                    echo "No";
                else
                    echo "Yes"; ?>
        </td>
      </tr>
      <tr>
        <td width="50%" class="td_pad_left_2"><b>Category: </b>
        <td width="50%" class="td_pad_right_2"><?=$data[0]['categoryName'] ?></td>
      </tr>
      <tr>
        <td width="50%" class="td_pad_left_2"><b>Start calender:</b></td>
        <td width="50%" class="td_pad_right_2"><?  $d=$data[0]['start_of_publishing'];
               $timeStamp = explode(" ",$d);
               $start_date = $timeStamp[0];?>
          <?=$start_date ?>
        </td>
      </tr>
      <tr>
        <td width="50%" class="td_pad_left_2"><b>End calender:</b></td>
        <td width="50%" class="td_pad_right_2"><?  $d=$data[0]['end_of_publishing'];
              $timeStamp = explode(" ",$d);
               $end_date = $timeStamp[0];?>
          <?=$end_date ?></td>
      </tr>
      <tr>
        <td width="50%" class="td_pad_left_2"><b>Campiagn Name:</b></td>
        <td width="50%" class="td_pad_right_2"><?=$data[0]['campaign_name'] ?></td>
      </tr>
    </table>
    <div align="center" class="bg_darkgray123"> Advanced Options </div>
    <table width="60%" BORDER=0 align="center" cellpadding="0" cellspacing="0"   id="advancedSearch">

        <tr >
           
            <td width="50%" class="td_pad_left_2"><b> Keywords:</b>        </td>
            <td width="50%" class="td_pad_right_2">
                <? $d=$data[0]['keyword'] ?>
            <?php if ($d == '')
                    echo "Not Specified";
                else
                    echo $d; ?>
            </td>
        </tr>
      <!--  <? if($reseller == '') { ?>
     <tr>
  <td width="50%" class="td_pad_left_2"><b> Discount:</b>        </td>
  <td width="50%" class="td_pad_right_2">
                <?  $d=$data[0]['ccode'];
                $discountValue = $regObj->putCcode($d);
                 ?>
             <?php if ($discountValue == '')
                    echo "Not Specified";
                else
                    echo $discountValue; ?>            </td>
      </tr>
      <? } ?>-->
    </table>
    <table  width="60%" BORDER=0 align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="50%" class="td_pad_left_2"><b> Start Time for the Campaign Limitation:</b> </td>
        <td width="50%" class="td_pad_right_2"><? $d=$data[0]['start_time'] ?>
          <?php if ($d == '')
                    echo "Not Specified";
                else
                    echo $d; ?>
        </td>
      </tr>
      <tr>
        <td width="50%" class="td_pad_left_2"><b>End Time for the Limitation:</b> </td>
        <td width="50%" class="td_pad_right_2"><? $d=$data[0]['end_time'] ?>
          <?php if ($d == '')
                    echo "Not Specified";
                else
                    echo $d; ?>
        </td>
      </tr>
      <tr>
        <td width="50%" class="td_pad_left_2"><b>Limit Campaign:</b> </td>
        <td width="50%" class="td_pad_right_2"><? $d=$data[0]['valid_day'] ?>
          <?php if ($d == '')
                    echo "Not Specified";
                else
                    echo $d; ?>
        </td>
      </tr>
        <? if($reseller == '') { ?>
          <tr>
            <td width="50%" class="td_pad_left_2"><b>Owner:</b>        </td>
            <td width="50%" class="td_pad_right_2"><? echo $ownerName[0]['fname']; ?> ( <? echo $ownerName[0]['email']; ?> )
                      </td>
        </tr>
        <? } ?>
    </table>
    <div align="center" class="bg_darkgray123"> Your Coupon View</div>
    <table width="60%" BORDER=0 align="center" cellpadding="0" cellspacing="0" >
      <tr>
        <td width="50%" valign="top" class="td_pad_left_2"><b>Picture:</b> </td>
        <td width="50%"><img src="<?=$data[0]['large_image'] ?>" width="150" border="0" class="td_pad_right_2"> </td>
      </tr>
    </table>
    <table width="60%" BORDER=0 align="center" cellpadding="0" cellspacing="0"  id="infopage" >
      <tr>
        <td width="50%" valign="bottom" class="td_pad_left_2"><b>Link:</b> </td>
        <td width="50%" class="td_pad_right_2"><? $d = $data[0]['infopage'] ?>
          <?php if ($d == '')
                    echo "Not specified";
                else
                    echo $d; ?>
        </td>
      </tr>
    </table>
    <div align="center" class="bg_darkgray123"> Location Information</div>
    <table BORDER=0  id="store" width="100%"  >
      <tr class="newcolor_heading">
        <td width="10%" align="center"><b>S.No.</b></td>
        <td width="21%" align="center"><b>Location Name:</b></td>
        <td width="12%" align="center"><b>Street:</b></td>
        <td width="11%" align="center"><b>City:</b></td>
        <td width="20%" align="center"><b>Country:</b></td>
        <td width="26%" align="center"><b>Coupon Delivery type:</b></td>
      </tr>
      <tr>
        <?php if (isset($data['storeDetails'])) { ?>
        <?php $i = 1;
                foreach ($data['storeDetails'] as $data1['storeDetails']) { ?>
        <td height="32" align="center"><?php echo $i; ?> </td>
        <td align="center"><?php echo $data1['storeDetails']['store_name']; ?> </td>
        <td align="center"><?php echo $data1['storeDetails']['street']; ?> </td>
        <td align="center"><?php echo $data1['storeDetails']['city']; ?> </td>
        <td align="center"><?php echo $data1['storeDetails']['country']; ?> </td>
        <td align="center"><?php echo $data1['storeDetails']['coupon_delivery_type']; ?></td>
      </tr>
      <?
                $i++;
            }
            ?>
      <?php } else { ?>
      <tr>
        <td  colspan="6"><?php echo "No Records Found";
    } ?></td>
      </tr>
    </table>
    <div align="center"><br />
      <br />
      <? if($reseller == '') {?>
      <INPUT type="button" value="Back" name="continue" id="continue" class="button" onClick="javascript:location.href='showDeleteCampaign.php'" >
      <?} else {?>
      <INPUT type="button" value="Back" name="continue" id="continue" class="button" onClick="javascript:location.href='showDeleteResellerCampaign.php'" >
      <?}?>
      <br />
      <br />
    </div>
  </form>
</div>
<? include("footer.php"); ?>
</body>
