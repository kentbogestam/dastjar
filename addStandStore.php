<?php
header('Content-Type: text/html; charset=utf-8');
include_once("cumbari.php");
$menu = "standard";
$standard = 'class="selected"';
$show = 'class="selected"';
//echo $_SESSION['userid'];
//exit;
include("main.php");
$regObj = new registration();
$storeObj = new store();

//$regObj->isValidRegistrationStep();
$offerObj = new offer();
  
$_GET['productId'];
$productid = $_GET['productId']; //die();
 $data = $offerObj->viewStandardDetailById($productid);
// Total Location
$stores = $storeObj->totalStoreDetails();
if (isset($_POST['continue'])) {
    $offerObj->saveNewCouponStandardDetails();
}
include_once("header.php");
?>
<?php include 'config/defines.php'; ?>

<script language="JavaScript" src="client/js/ajaxuploadStand.js" type="text/javascript"></script>


<style type="text/css">

    a { }
    img { border: 0 }.center{width:900px; margin-left:auto; margin-right:auto;}
</style>
<script language="JavaScript" src="client/js/jsAddStandCoupon.js" type="text/javascript"></script>
<body>
<div class="center">
<div>
    <div id="preview_frame"></div>
</div>
<form name="register" action="" id="registerform" method="Post" enctype="multipart/form-data">
<input type="hidden" name="preview" value="1">
<input type="hidden" name="m" value="saveNewCouponStandard">
<input type="hidden" name="productId" value="<?=$_GET['productId']; ?>">
<div id="msg" align="center">
    <?php
    if ($_SESSION['MESSAGE']) {
        echo $_SESSION['MESSAGE'];
        $_SESSION['MESSAGE'] = "";
    }
    ?>
</div>
<div class="redwhitebutton_small123" style="margin-top:20px; margin-bottom:5px;">Add the Offer <?=$data[0]['product_name']?> to a Location</div>
<table width="100%" border="0" cellspacing="15">
<div align="right"  ><a href="newCreateStore.php" >ADD LOCATION</a></div>
		<tr>
		  <td width="50%" align="left" >Select Location<span class='mandatory'>*</span>:</td>
<td align="left" ><div align="center" class="normalfont">
        

                    <select style="background-color:#e4e3dd; width:406px; border: 1px solid #99999b;" class="text_field_new" name="selectStore" id="selectStore">
                         <option <? if ($stores1['store_name'] == ''

            )echo "selected='selected'"; ?> value="">Select Location</option>
                        <?php foreach ($stores as $stores1) {
                            // print_r($stores1);  ?>
                            <option  value="<?=$stores1['store_id'] ?>"><? echo $stores1['store_name']; ?></option>

<? } ?>
                    </select>
                    <div id='error_selectStore' class="error123"></div>
    </div></td>
	  </tr>
		<tr>
		  <td width="50%" align="left">Price<span class='mandatory'>*</span>:</td>
		  <td align="left"><div align="center" class="normalfont" >
    
        <input class="text_field_new" type="text" name="price" id="price" value="">
         <div id='error_price' class="error123"></div>

</div></td>
		</tr>
</table>




  <div align="center"><br />
<br />

            <INPUT  style="margin-left:115px;"type="submit" value="Submit" name="continue" id="continue" class="button" ><br />
<br />

        </div>

 <span class='mandatory'>* These Fields Are Mandatory</span>
</form>
</div>
    <? include("footer.php"); ?>
</body>
</html>