<?php
/* File Name   : editBrand.php
 *  Description : Edit Brand Form
 *  Author      : Deo  Date: 31th,march,2011  Creation
*/
header('Content-Type: text/html; charset=utf-8');
ob_start();
include_once("cumbari.php");
$menu = "brand";
$brand = 'class="selected"';
$add = 'class="selected"';
include("main.php");
if ($_SESSION['userid']) {
    $brandObj = new brandView();
    $brandid = $_GET['brandId'];
    $datas = $brandObj->getBrandViewDetailsByRows($brandid);
   // print_r($datas);
// echo count($datas);
//die;
} else {
    $_SESSION['MESSAGE'] = "Please Login";
    header("location:login.php");
}

if (($_POST['submit'])) {
    $brandObj->editBrandIconDetails();
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
<div class="center">
<div  class="register" style="  height:87px; padding-top:30px; padding-left: 50px; margin-top:10px; margin-left:10px; text-align:center; ">Update Your Brand</div>
<div align="center">
    <form name="register" action="" id="registerform" method="POst" enctype="multipart/form-data">
        <input type="hidden" name="m" value="editBrandIcon">
        <table width="100%" BORDER=0 cellpadding="0" cellspacing="15" style="margin-top:0px;" >
            
             <tr>
                            
                           <td width="50%" style="font-size:20px; font-weight:normal;" >Brand Name<span class='mandatory'>*</span>:</td>
                            <td width="50%" align="left">
                                <INPUT class="text_field_new"  type=text name="brandName" id ="brandName"  value="<?=$datas[0]['brand_name']
                                               ?>">
                                <a  title="<?=BRAND_NAME
                                           ?>" class="vtip" ><b><small>?</small></b></a><br />
                                <div id='error_brandName' class="error"></div></td>
                        </tr>
           
            <tr>
                
                <td width="289" style="font-size:20px; font-weight:normal;">Change Icon <font size="2">(Icon must be in png format only eg. icon.png)</font><span class='mandatory'>*</span></td>
                <td width="725">
                    <?php if ($_SESSION['preview']['icon']) {
                        ?>
                    <img src="upload/coupon/<?=$_SESSION['preview']['icon'] ?>">
                    <input type="hidden" name="icon" id="icon" value="<?=$_SESSION['preview']['icon'] ?>">
                    <br>Or&nbsp;
                        <?
                    }
                    ?>
                    <INPUT type=file name="picture" id="picture">
                    <a  title="<?=BRANDICON_TEXT
                                ?>" class="vtip"><b><small>?</small></b></a><br/>
                    <div id='error_picture' class="error"></div></td>
                <td><img></td>
            </tr>
           
            <tr>
                <td align="center"> </td>
            <td align="left"><input style="color:#FFFFFF"  type="submit" value="Submit" class="button" name="submit" id="submit"></td>
            <td align="center">&nbsp;</td>
            </tr>
            <tr>
                <td COLSPAN='3' align="center">&nbsp;</td>
            </tr>
        </table>
    </form>
</div>
<span style="font-size:20px; font-weight:normal;" class='mandatory'>*These Fields Are Mandatory</span><br />
<br /></div>
<? include("footer.php"); ?>

</body>
</html>

