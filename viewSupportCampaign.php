<?php
/*  File Name  : viewCampaign.php
 *  Description : View campaign Form
 *  Author      : Himanshu Singh  Date: 22nd,dec,2010  Creation
*/
header('Content-Type: text/html; charset=utf-8');
include_once("cumbari.php");
include("mainSupport.php");
$offerObj = new offer();
$regObj = new registration();
$campaignid = $_GET['campaignId'];

$lang = $offerObj->getLang($campaignid);

$selectLanguage = $_GET['lang'];
if(!empty($selectLanguage))
    {
        $lang = $selectLanguage;
    }

$data = $offerObj->viewcampaignDetailById($campaignid,$lang);
  //echo "<pre>";print_r($data);echo "</pre>";
 $ownerName = $regObj->getOwnerName($data[0]['u_id']);
if($data[0] == '')
    {
    $inoutObj = new inOut();
    $_SESSION['MESSAGE'] = NO_RECORDS_LANG;
    $url = $_SERVER['HTTP_REFERER'];
     $inoutObj->reDirect($url);
      exit();
}
$reseller = $_GET['from'];

//echo "<pre>";print_r($data);echo "</pre>";

$uid = $_GET['backuid'];
 
?>
<?php include 'config/defines.php'; ?>

<script language="JavaScript" src="client/js/jquery.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/jsCampaignOffer.js" type="text/javascript"></script>

<script type="text/javascript" src="lib/vtip/js/jquery.js"></script>
<script type="text/javascript" src="lib/vtip/js/vtip.js"></script>
<link rel="stylesheet" type="text/css" href="lib/vtip/css/vtip.css" />


<style type="text/css">
    body { margin: 100px }
    a { }
    img { border: 0 }
</style>

<link rel="stylesheet" href="client/css/datePicker.css" type="text/css">
<link href="client/css/stylesheet123.css" rel="stylesheet" type="text/css">
<link href="lib/grid/css/grid.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="client/js/jquery.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/date.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/jquery.bgiframe.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/jquery.datePicker.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/ajaxupload.js" type="text/javascript"></script>
<META http-equiv="Content-Type" content="text/html; charset=utf-8">
<!--<script language="JavaScript" src="client/js/jsCampaignOffer.js" type="text/javascript"></script>-->
<style type="text/css">
    /*
    .style4 {
        font-size: 10px;
        font-weight: bold;
    }
    .style6 {font-size: 9px}
    */
</style>
<body>
<div class="center">

<form name="register" action="" id="registerform" method="Post" enctype="multipart/form-data">
   <div class="top_h1"> View Campaign Offers</div>
   <div style="clear:both">
    <div id="msg" align="center">  <?php
                                                            if ($_SESSION['MESSAGE']) {
                                                                echo $_SESSION['MESSAGE'];
                                                                $_SESSION['MESSAGE'] = ""; } ?> </div>
    <div class="bg_darkgray123" align="center" >
Your Campaign View</div>
    <table width="70%" BORDER=0 align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td width="50%" class="td_pad_left">View According To Your Language:</td>
          <td width="50%" class="td_pad_right"><select style="width:250px; background-color:#e4e3dd; border:#abadb3 solid 1px" onChange="langChange(this.value,'<?=$_GET['campaignId']?>','<?=$reseller?>','<?=$uid?>');" class="text_field_new" name="lang2" id="lang2" >
            <option <? if ($lang == "GER")echo "selected='selected'"; ?> value="GER">German</option>
            <option <? if ($lang == "ENG")echo "selected='selected'"; ?> value="ENG">English</option>
            <option <? if ($lang == "SWE")echo "selected='selected'"; ?> value="SWE">Swedish</option>
          </select></td>
        </tr>
        <tr>
            <td width="50%" class="td_pad_left"> <b>Title Slogan for your Campaign:</b>            </td>
            <td width="50%" class="td_pad_right">
                <?=$data[0]['slogan'] ?></td>
        </tr>
        <tr>
            <td width="50%" class="td_pad_left"><b> Sub Slogan for your Campaign:</b>            </td>

            <td width="50%" class="td_pad_right"><?=$data[0]['subslogen'] ?></td>
        </tr>
        <tr>
            <td width="50%" class="td_pad_left"><b>Icon: </b></td>
            <td width="50%" class="td_pad_right">
            <img src="<?=$data[0]['small_image'] ?>" width="50" border="0">        </tr>
    </table>
<table width="70%" BORDER=0  align="center" cellpadding="0" cellspacing="0">
<tr>
            <td width="50%" class="td_pad_left"><b> Sponsored:</b></td>


            <td width="50%" class="td_pad_right"> <? $d = $data[0]['spons'] ?>
                <?php if ($d == 0)
                    echo "No";
                else
                    echo "Yes"; ?>        </td>
      </tr>
        <tr>
            <td width="50%" class="td_pad_left"><b>Category: </b>
            <td width="50%" class="td_pad_right"> <?=$data[0]['categoryName'] ?></td>
        </tr>
        <tr>
            <td width="50%" class="td_pad_left"><b>Start calender:</b></td>
            <td width="50%" class="td_pad_right">  <?  $d=$data[0]['start_of_publishing'];
               $timeStamp = explode(" ",$d);
               $start_date = $timeStamp[0];?>
                <?=$start_date ?>        </td>
        </tr>
        <tr>
            <td width="50%" class="td_pad_left"><b>End calender:</b></td>
            <td width="50%" class="td_pad_right"> <?  $d=$data[0]['end_of_publishing'];
               $timeStamp = explode(" ",$d);
               $end_date = $timeStamp[0];?>
                <?=$end_date ?></td>
        </tr>
        <tr>
            <td width="50%" class="td_pad_left"><b>Campaign Name:</b></td>
            <td width="50%">
                <?=$data[0]['campaign_name'] ?></td>
        </tr>
    </table>
    <div align="center" class="bg_darkgray123">
    		Advanced Options
    </div>
<table width="70%" BORDER=0 align="center" cellpadding="0" cellspacing="0"   id="advancedSearch">
<tr >
  <td width="50%" class="td_pad_left"><b> Keywords:</b>        </td>
  <td width="50%" class="td_pad_right">
                <? $d=$data[0]['keyword'] ?>
             <?php if ($d == '')
                    echo "Not Specified";
                else
                    echo $d; ?>            </td>
      </tr>
<tr >
  <td width="50%" class="td_pad_left"><b>Campaign Value:</b>        </td>
  <td width="50%" class="td_pad_right"> <?=$data[0]['value']?> </td>
</tr>      
      
      
      <? if($reseller == '') { ?>
<tr>
  <td width="50%" class="td_pad_left"><b> Discount:</b>        </td>
  <td width="50%" class="td_pad_right">
                <?  $d=$data[0]['ccode'];
                $discountValue = $regObj->putCcode($d);
                 ?>
             <?php if ($discountValue == '')
                    echo "Not Specified";
                else
                    echo $discountValue; ?>            </td>
      </tr>
      <? } ?>
    </table>
    <table  width="70%" BORDER=0 align="center" cellpadding="0" cellspacing="0">
<tr>
            <td width="50%" height="30" class="td_pad_left"><b>Start Time for the Campaign Limitation:</b>        </td>
            <td width="50%" class="td_pad_right"><? $d=$data[0]['start_time'] ?>
             <?php if ($d == '')
                    echo "Not Specified";
                else
                    echo $d; ?>            </td>
        </tr>
        <tr>
            <td width="50%" class="td_pad_left"><b>End Time for the Limitation:</b>        </td>
            <td width="50%" class="td_pad_right"><? $d=$data[0]['end_time'] ?>
              <?php if ($d == '')
                    echo "Not Specified";
                else
                    echo $d; ?>            </td>
        </tr>
        <tr>
            <td width="50%" class="td_pad_left"><b>Limit Campaign:</b>        </td>
            <td width="50%" class="td_pad_right"><?$d=$data[0]['valid_day'] ?>
            <?php if ($d == '')
                    echo "Not Specified";
                else
                    echo $d; ?>            </td>
        </tr>

        <? if($reseller == '') { ?>
          <tr>
            <td width="50%" class="td_pad_left"><b>Owner:</b>        </td>
            <td width="50%" class="td_pad_right"><? echo $ownerName; ?>
                      </td>
        </tr>
        <? } ?>
    </table>
    <div align="center" class="bg_darkgray123">
    		Your Coupon View
    </div>
    <table width="70%" BORDER=0 align="center" cellpadding="0" cellspacing="0" >
<tr>
  <td width="50%" class="td_pad_left"> <b>Picture:</b>        </td>
  <td width="50%">
                <img src="<?=$data[0]['large_image'] ?>" width="180" height="180" class="td_pad_right">        </td>
      </tr>


    </table>

    <table width="70%" BORDER=0 align="center" cellpadding="0" cellspacing="0"  id="infopage" >

<tr>
  <td width="50%" valign="bottom" class="td_pad_left"><b>Link:</b>        </td>
  <td width="50%" class="td_pad_right">
                <? $d =$data[0]['infopage'] ?>
                <?php if ($d == '')
                    echo "Not specified";
                else
                    echo $d; ?>        </td>

      </tr>
      <? if($data[0]['accept_by']) { ?>
      <tr>
  <td width="50%" valign="bottom" class="td_pad_left"><b>Accepted By:</b>        </td>
  <td width="50%" class="td_pad_right">
                <?  $acceptId = $data[0]['accept_by'] ?>
                <? echo $acceptname = $offerObj->getUserAcceptName($acceptId); ?>        </td>

      </tr>
      <? } ?>
    </table>
    <div align="center" class="bg_darkgray123">
    		Location Information
    </div>
    <table width="100%" BORDER=0 cellspacing="2"  id="store" >
  <tr class="newcolor_heading" >

            <td width="21%" align="center"><b>Location Name</b></td>
            <td width="12%" align="center"><b>Street</b></td>
            <td width="11%" align="center"><b>City</b></td>
            <td width="20%" align="center"><b>Country</b></td>
            <td width="26%" align="center"><b>Coupon Delivery type</b></td>

            <?$current_date = date('Y-m-d');
             //echo $current_date;
            if($data[0]['end_of_publishing'] >$current_date ){ ?>
             <? if($reseller == '') { ?>
	    <td width="10%" align="center"><b>Action</b></td>
            <? } ?>
            <?}?>
      </tr>

        <tr>
            <?php if (isset($data['storeDetails'])) { ?>
                <?php $i = 1;
                foreach ($data['storeDetails'] as $data1['storeDetails']) {
                   $storeid = $data1['storeDetails']['store_id'];
                   $storeObj = new store();
                    $barcode = $storeObj->getCouponDeliveryById($storeid);
                     $dps = $storeObj->getCouponDeliveryByIdDPS($storeid);
                    if($barcode == 'BARCODE')
                    {
                        $coupon_dil = $barcode;
                    }else {
                        $coupon_dil = 'PINCODE';
                    }
                    
                    if($dps == "DPS")
                    {
                        
                        $coupon_dil = ($coupon_dil == ""?$dps:$coupon_dil.",".$dps);
                    }
                    ?>


            <td align="center"><?php echo $data1['storeDetails']['store_name']; ?> </td>
            <td align="center"><?php echo $data1['storeDetails']['street']; ?> </td>
            <td align="center"><?php echo $data1['storeDetails']['city']; ?> </td>
            <td align="center"><?php echo $data1['storeDetails']['country']; ?> </td>
            <td align="center"><?php echo $coupon_dil; ?></td>
            <? if($data[0]['end_of_publishing'] >$current_date ){ ?>
             <? if($reseller == '') { ?>
             <td height="32" align="center"><a href="javascript:delete_campStore('storeId=<?=$data1['storeDetails']['store_id']?>&campaignId=<?=$data[0]['campaign_id']?>' )" onClick="" class="a2" title="Delete">
                                                                <img src="lib/grid/images/delete.gif"></a> </td>
                                                                <? } ?>
                                                                <?}?>
        </tr>

                <?
                $i++;
            }
            ?>
            <?php } else { ?>
    </table>


        <?php echo "No Records Found";
    } ?>


 <table width="100%" border="0" >
 		<tr>
 				<td>&nbsp;</td>
	  </tr>
 		<tr><td><div align="center" >
               
        <INPUT type="button" value="Back" name="continue" id="continue" class="button" onClick="javascript:location.href='showPermntDeleteCampaign.php?uId=<? echo $uid ; ?>'">
       
         
    <br />
          <br />
          </div></td></tr></table>
</form></div>
<? include("footer.php"); ?>
</body>
<script>
    function langChange(lang,campId,reseller,uId)
{
    if(reseller!='')
        {
    javascript:location.href = "viewSupportCampaign.php?lang="+lang+"&campaignId="+campId+"&from="+reseller;
        }
        else
            {
         javascript:location.href = "viewSupportCampaign.php?lang="+lang+"&campaignId="+campId+"&backuid="+uId;
            }
}
</script>
