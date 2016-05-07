<?php
/* File Name   : editBrand.php
 *  Description : Edit Brand Form
 *  Author      : Deo  Date: 31th,march,2011  Creation
*/
header('Content-Type: text/html; charset=ISO-8859-15');

ob_start();
include_once("cumbari.php");
$menu = "brand";
$brand = 'class="selected"';
$add = 'class="selected"';
include("main.php");
if ($_SESSION['userid']) {
    $brandObj = new brandView();
    $data = $brandObj->registerBrandDetails();
//print_r($data);

} else {
    $_SESSION['MESSAGE'] = "Please Login";
    header("location:login.php");
}

if (($_POST['submit'])) {
    $brandObj->submitBrandDetails();
}


?>
<?php include 'config/defines.php'; ?>
<script type="text/javascript" src="lib/?/js/jquery.js"></script>
<link href="lib/grid/css/grid.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="client/js/jsFinancialStatus.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/jsBrand.js" type="text/javascript"></script>
<script type="text/javascript" src="lib/?/js/vtip.js"></script>
<link rel="stylesheet" type="text/css" href="lib/?/css/vtip.css" />


<style type="text/css">
    body {  }
    a { }
    img { border: 0 }
</style><br />
<br />
<body>
<div class="center">
<div style="height:93px; width:100%">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="100%" height="93" class="redwhitebutton1234">Add User Details</td>
  </tr>
	</table>
</div>

<div align="center">
    <form name="register" action="" id="registerform" method="POst" enctype="multipart/form-data">
    <input type="hidden" name="m" value="submitBrand">
            <table   BORDER=0 width="100%" style="margin-top: 20px;" cellspacing="15" >
                
          <tr>
                    
                    <td width="48%" align="left" valign="top" style="font-size:20px; font-weight:normal;"   >Brand Name<span class='mandatory'>*</span>:</td>
              <td align="left">
            <INPUT class="text_field_new" type=text name="brandName" id ="brandName" value="<? echo $data['company_name'] ?>">
                <br />
                    <div id='error_brandName' class="error"></div>                    </td>
            <td align="right" valign="top"><a  title="<?=BRAND_NAME
                                           ?>" class="vtip" ><b><small>?</small></b></a></td>
                </tr>
                <tr>
                   
                    <td align="left" valign="top" style="font-size:20px; font-weight:normal;">Icon <font size="2">(Icon must be in png format only eg. icon.png)</font><span class='mandatory'>*</span></td>
          <td align="left" >
                        <?php if ($_SESSION['preview']['icon']) {
                            ?>
                    <img src="upload/coupon/<?=$_SESSION['preview']['icon'] ?>">
                    <input type="hidden" name="icon" id="icon" value="<?=$_SESSION['preview']['icon'] ?>">
                    <br>Or&nbsp;
                            <?
                        }
                        ?>
                    <INPUT type=file name="picture" id="picture">
                    <div id='error_picture' class="error"></div></td>
                <td align="right" valign="top" ><a title="<?=BICON_TEXT
                                   ?>" class="vtip"><b><small>?</small></b></a> </td>
                </tr>
                    
                    <td align="left" valign="top" style="font-size:20px; font-weight:normal;">Amount:</td>
              <td align="left" valign="bottom" style="font-size:12px;">
                    <INPUT class="text_field_new" type=text  name="amount" id ="amount" value="<? echo $data['brand_fee'] ?>">
                    <br />
                  <div style="float:left; margin-top:5px;">
			<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="padding-right:5px;">SEK </td>
    <td><img src="images/cards_visa.jpg" width="131" height="40" /></td>
  </tr>
			</table>
</div></td>
                <td align="right" valign="bottom" style="font-size:12px;">&nbsp;</td>
                </tr>
                <tr>
                    <td align="center"> </td>
                	<td colspan="2" align="left"><input style="color:#FFFFFF" src="images/information.png" type="submit" value="Submit" class="button" name="submit" id="submit"></td>
                </tr>
            </table>
  </form>
</div>
<span style="font-size:20px; font-weight:normal;" class='mandatory'>*These Fields Are Mandatory</span><br />
<br /></div>
<? include("footer.php"); ?>

</body>
</html>

