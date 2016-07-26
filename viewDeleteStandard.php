<?php
/*  File Name  : viewStandard.php
*  Description : To view Product created by a Particular User
*  Author      : Himanshu Singh  Date: 12th,Nov,2010  Creation
*/
header('Content-Type: text/html; charset=utf-8');
include_once("cumbari.php");
$menu = "standard";
$standard = 'class="selected"';
$show = 'class="selected"';
$reseller = $_REQUEST['from'];
if($reseller == '')
{
include("main.php");
} else {
    include("mainReseller.php");
}
//include_once("classes/registration.php");
$offerObj = new offer();
$regObj = new registration();

//$regObj->isValidRegistrationStep(3);
//$regObj->isValidRegistrationStep(1);
if(isset($_POST['continue'])) {
    //echo "In"; die();
    $offerObj->svrOfferDflt();

}
else {
    $productid = $_GET['productId']; //die();
    $data = $offerObj->viewDeleteStandardDetailById($productid);

//echo "<pre>";print_r($data);echo "</pre>";
}

?>
<?php include 'config/defines.php';  ?>
<script type="text/javascript" src="lib/see example/js/jquery.js"></script>

<script type="text/javascript" src="lib/see example/js/vtip.js"></script>
<link rel="stylesheet" type="text/css" href="lib/see example/css/vtip.css" />
<link href="lib/grid/css/grid.css" rel="stylesheet" type="text/css" />
<META http-equiv="Content-Type" content="text/html; charset=utf-8">

<style type="text/css">
    body { margin: 100px }
    a { }
    img { border: 0 }
</style>

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
<body>
<div class="center">
<form name="register" action="" id="registerform" method="Post" enctype="multipart/form-data">
    <div align="center">
<div class="top_h3">View Deleted Standard Offer</div>
<div style="clear:both"></div>
        <h4 class="bg_darkgray123">Standard Offer View</h4>
        <table BORDER=0 width="100%" >
            <tr align="left">
                <td width="29%">&nbsp;</td>
                <td width="29%"> <b>Product Name:</b>            </td>
                <td width="42%">
                    <?=$data[0]['slogen']?></td>
            </tr>

            <tr align="left">
                <td>&nbsp;</td>
                <td><b>Icon: </b></td>
                <td>
                <img src="<?=$data[0]['small_image']?>">        </tr>
            <tr>        </tr>
        </table>

    </div>
</form>


<div align="center">
    <table BORDER=0 width="100%" >

        <!--<tr align="left">
            <td width="29%">&nbsp;</td>

            <td width="29%">
                <?=$data[0]['brand_name']?></td>
			  <td width="42%">
                </td>
        </tr> -->
        <tr align="left">
            <td width="29%" >&nbsp;</td>
            <td width="29%"><b> Sponsored:</b></td>
            <td width="42%"> <?$d=$data[0]['is_sponsored']?>
                <?php if ($d==0) echo "NO";
                else echo "YES";?>        </td>
        </tr>
        <tr align="left">
            <td>
            <td><b>Category: </b>
            <td> <?=$data[0]['category']?></td>
        </tr>
      
    </table>
</div>
<div align="center">
    <h4 class="bg_darkgray123">
	Advanced Options</h4>
    <table BORDER=0 width="100%"  style="display:row-inline;" id="advancedSearch">
        <tr align="left">
            <td width="29%">&nbsp;</td>
            <td width="29%"><b> Keywords:</b>        </td>
            <td width="42%">
                <?$d=$data[0]['keyword']?>
                <?php if ($d=='') echo "Not specified";
                else echo $d; ?>
            </td>
        </tr>
        <tr align="left" >
            <td>&nbsp;</td>
            <td><b> EAN Code:</b>        </td>
            <td>
                <?=$data[0]['ean_code']?></td>
        </tr>
        <tr align="left" >
            <td>&nbsp;</td>
            <td><b> Product Number:</b>        </td>
            <td>
                <?=$data[0]['product_number']?></td>
        </tr>
        <tr>
    </table>
</div>

<div align="center">
    <h4 class="bg_darkgray123">
	Your Coupon View</h4>
    <table BORDER=0 width="100%">
        <tr align="left">
            <td width="29%">&nbsp;</td>
            <td width="29%"> <b>Picture:</b>        </td>
            <td width="43%">
                <img src="<?=$data[0]['large_image']?>">        </td>
        </tr>
       <!-- <tr align="left" >
            <td>&nbsp;</td>
            <td><b> Product Name:</b>        </td>
            <td>
                <?=$data[0]['product_name']?></td>
        </tr>-->
        
        <tr align="left" >
            <td>&nbsp;</td>
            <td><b> Public product </b>        </td>
            <td><?php $d = $data[0]['is_public'];
                if ($d==0) echo "no";
                else
                    echo "yes"; ?>            </td>
        </tr>
    </table>
</div>
<div align="center">
    <h4 class="bg_darkgray123">
	Your Info Page</h4>
    <table BORDER=0 width="100%" id="infopage" style="display:row-inline;">
        <tr align="left">
        		<td width="29%"></td>
            <td width="29%"><b>Link:</b>        </td>
            <td>
                <?$d=$data[0]['link']?>
                <?php if ($d=='') echo "Not specified";
                else echo $d; ?>
            </td>
        </tr>
    </table>
</div>
 <div align="center" class="bg_darkgray123">
 		Location Information</h3>
</div>
    <table width="100%" BORDER=0 cellpadding="2" cellspacing="2"  bordercolor="#CCCCCC" class="border"  id="store">
  <tr class="newcolor_heading">
           
            <td width="21%" align="center"><b>Location Name:</b></td>
            <td width="12%" align="center"><b>Street:</b></td>
            <td width="11%" align="center"><b>City:</b></td>
            <td width="20%" align="center"><b>Country:</b></td>
            <td width="26%" align="center"><b>Coupon Delivery type:</b></td>
             <td width="10%" align="center"><b>Sub Slogan(Price):</b></td>
        </tr>
        <tr>
<?php if (isset($data['storeDetails'])) { ?>
<?php $i = 1;
                    foreach ($data['storeDetails'] as $data1['storeDetails']) { ?>
                       
                        <td align="center"><?php echo $data1['storeDetails']['store_name']; ?> </td>
                        <td align="center"><?php echo $data1['storeDetails']['street']; ?> </td>
                        <td align="center"><?php echo $data1['storeDetails']['city']; ?> </td>
                        <td align="center"><?php echo $data1['storeDetails']['country']; ?> </td>
                            <td align="center"><?php echo $data1['storeDetails']['coupon_delivery_type']; ?></td>
                            <td align="center"><?php echo $data1['storeDetails']['text']; ?></td>
                        </tr>
        <?
                        $i++;
                    }
        ?>
        <?php } else { ?>
                        <tr><td colspan="6" ><?php echo "No Records Found";} ?></td></tr>
            </table>
 
<div align="center"><br/>
    <? if($reseller == '') {?>
   <INPUT type="button" value="Back" name="continue" id="continue" class="button" onClick="javascript:location.href='showDeleteStandard.php';" >
   <?} else {?>
   <INPUT type="button" value="Back" name="continue" id="continue" class="button" onClick="javascript:location.href='showDeleteResellerStandard.php';" >
   <?}?>
	<br />
	<br />
</div></div>
<? include("footer.php"); ?>
</boyd>
