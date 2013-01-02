<?php
/*  File Name  : viewPublicProduct.php
*  Description : To view Product created by a Particular User
*  Author      : Himanshu Singh  Date: 12th,Nov,2010  Creation
*/
header('Content-Type: text/html; charset=ISO-8859-15');
include_once("cumbari.php");
$menu = "standard";
$standard = 'class="selected"';
$show = 'class="selected"';
include("main.php");
//include_once("classes/registration.php");
$offerObj = new offer();
$regObj = new registration();

//$regObj->isValidRegistrationStep(3);
//$regObj->isValidRegistrationStep(1);
$productid = $_GET['productId'];
if(isset($_POST['continue'])) {
    //echo "In"; die();
    $offerObj->svrOfferDflt();

}
    $lang = $offerObj->getLangProduct($productid);

 $selectLanguage = $_GET['lang'];
if(!empty($selectLanguage))
    {
        $lang = $selectLanguage;
    }
     //die();
    $data = $offerObj->viewPublicProductStandardDetailById($productid,$lang);

//echo "<pre>";print_r($data);echo "</pre>";
if($data[0] == '')
    {
    $inoutObj = new inOut();
    $_SESSION['MESSAGE'] = NO_RECORDS_LANG;
    $url = $_SERVER['HTTP_REFERER'];
     $inoutObj->reDirect($url);
      exit();
}

?>
<?php include 'config/defines.php';  ?>
<script type="text/javascript" src="lib/see example/js/jquery.js"></script>

<script type="text/javascript" src="lib/see example/js/vtip.js"></script>
<link rel="stylesheet" type="text/css" href="lib/see example/css/vtip.css" />
<link href="lib/grid/css/grid.css" rel="stylesheet" type="text/css" />


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

<script language="JavaScript" src="client/js/jsStandardOffer.js" type="text/javascript"></script>
<META http-equiv="Content-Type" content="text/html; charset=ISO-8859-15">

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
<table border="0" width="100%" cellspacing="5">
   <tr>
        		<td width="4" class="inner_grid">&nbsp;</td>

            <td width="515" class="inner_grid"><br>            </td>
<td width="469" align="left" ><div id='error_langStand' class="error"></div>            </td>
        </tr>
  </table>
<form name="register" action="" id="registerform" method="Post" enctype="multipart/form-data">
    <div align="center">
        <h1 align="left"  ><b >View Public Product</b></h1>
        <br/>
        <div id="msg" align="center">  <?php
                                                            if ($_SESSION['MESSAGE']) {
                                                                echo $_SESSION['MESSAGE'];
                                                                $_SESSION['MESSAGE'] = ""; } ?> </div>
        <h4 class="bg_darkgray1"><b><br />
        		Standard Offer View</b></h4>
        <table BORDER=0 width="100%" >
            <tr align="left">
              <td>&nbsp;</td>
              <td>View According To Your Language:</td>
              <td><select style="width:250px; background-color:#e4e3dd;" onchange="langChange(this.value,'<?=$_GET['productId']?>');" class="text_field_new" name="lang" id="lang" >
                    <option <? if ($lang == "ENG"
                        )echo "selected='selected'"; ?> value="ENG">English</option>
                    <option <? if ($lang == "SWE"
                        )echo "selected='selected'"; ?> value="SWE">Swedish</option>
                </select></td>
            </tr>
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
            <td width="29%"></td>

            <td width="29%">
                <?=$data[0]['brand_name']?></td>
			 <td width="43%">&nbsp;</td>
        </tr> -->
        <tr align="left">
            <td width="29%">&nbsp;</td>
            <td width="29%"><b> Sponsored:</b></td>
            <td width="42%"> <?$d=$data[0]['is_sponsored']?>
                <?php if ($d==0) echo "NO";
                else echo "YES";?>        </td>
        </tr>
        <tr align="left">
            <td>
            <td><b>Category: </b>
            <td> <?=$data[0]['categoryName']?></td>
        </tr>

    </table>
</div>
<div align="center">
    <h4 class="bg_darkgray1"><b><br />
    		Advanced Options</b></h4>
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
            <td> <?$d=$data[0]['ean_code']?>
                <?php if ($d=='') echo "Not specified";
                else echo $d; ?>
                </td>
        </tr>
        <tr align="left" >
            <td>&nbsp;</td>
            <td><b> Product Number:</b>        </td>
            <td><?$d=$data[0]['product_number']?>
                <?php if ($d=='') echo "Not specified";
                else echo $d; ?>
               </td>
        </tr>
        <tr>
    </table>
</div>

<div align="center">
    <h4 class="bg_darkgray1"><b><br />
    		Your Coupon View</b></h4>
    <table BORDER=0 width="100%">
        <tr align="left">
            <td width="29%">&nbsp;</td>
            <td width="29%"> <b>Picture:</b>        </td>
            <td width="42%">
                <img src="<?=$data[0]['large_image']?>" width="180" height="180">        </td>
        </tr>
      <!--  <tr align="left" >
            <td>&nbsp;</td>
            <td><b> Product Name:</b>        </td>
            <td>
                <?=$data[0]['product_name']?></td>
        </tr>-->

        <tr align="left" >
            <td>&nbsp;</td>
            <td><b> Public product </b>        </td>
            <td><?php $d = $data[0]['is_public'];
                if ($d==0) echo "No";
                else
                    echo "Yes"; ?>            </td>
        </tr>
    </table>
</div>
<div align="center">
    <h4 class="bg_darkgray1"><b><br />
    		Your Info Page</b></h4>
    <table BORDER=0 width="100%" id="infopage" style="display:row-inline;">
        <tr align="center">
        		<td width="29%">&nbsp;</td>
            <td width="29%" align="left"><b>Link:</b>        </td>
            <td align="left">
                <?$d=$data[0]['link']?>
                <?php if ($d=='') echo "Not specified";
                else echo $d; ?>            </td>
        </tr>
    </table>
</div>
 <div align="center" class="bg_darkgray1"><h3><b>
Location Information</b></h3></div>
    <table BORDER=0  id="store" width="100%" >
        <tr class="newcolor_heading" >

            <td width="21%" align="center"><b>Location Name</b></td>
            <td width="12%" align="center"><b>Street</b></td>
            <td width="11%" align="center"><b>City</b></td>
            <td width="20%" align="center"><b>Country</b></td>
            <td width="26%" align="center"><b>Coupon Delivery type</b></td>
            <td width="10%" align="center"><b>Sub Slogan(Price)</b></td>
            <td width="10%" align="center"><b>Action</b></td>
        </tr>
        <tr>
<?php if (isset($data['storeDetails'])) { ?>
<?php $i = 1;
                    foreach ($data['storeDetails'] as $data1['storeDetails']) {

                        $storeid = $data1['storeDetails']['store_id'];
                   $storeObj = new store();
                    $barcode = $storeObj->getCouponDeliveryById($storeid);
                    if($barcode == 'BARCODE')
                    {
                        $coupon_dil = $barcode;
                    }else {
                        $coupon_dil = 'PINCODE';
                    }
                        ?>

                        <td align="center"><?php echo $data1['storeDetails']['store_name']; ?> </td>
                        <td align="center"><?php echo $data1['storeDetails']['street']; ?> </td>
                        <td align="center"><?php echo $data1['storeDetails']['city']; ?> </td>
                        <td align="center"><?php echo $data1['storeDetails']['country']; ?> </td>
                            <td align="center"><?php echo $coupon_dil; ?></td>
                            <td align="center"><?php echo $data1['storeDetails']['text']; ?></td>
                          <td height="32" align="center"><a href="javascript:delete_standStore('storeId=<?=$data1['storeDetails']['store_id']?>&productId=<?=$data[0]['product_id']?>' )" onClick="" class="a2" title="Delete">
                                                                <img src="lib/grid/images/delete.gif"></a> </td>
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
 		<tr><td><div align="center"><br/>
    <INPUT type="button" value="Back" name="continue" class="button" id="continue" onClick="javascript:location.href='<?=$_SERVER[HTTP_REFERER]?>';" >
	<br />
	<br />
</div></td></tr></table>
</div>
<? include("footer.php"); ?>
<script>
    function langChange(lang,prodId)
{
    javascript:location.href = "viewPublicProduct.php?lang="+lang+"&productId="+prodId;
}
</script>