<?php
/*  File Name  : standardOffer.php
 *  Description : Standard Offer Form
 *  Author      : Himanshu Singh  Date: 25th,Nov,2010  Creation
*/
header('Content-Type: text/html; charset=ISO-8859-15');
include_once("cumbari.php");
$menu = "standard";
$standard = 'class="selected"';
$show = 'class="selected"';
$reseller =$_REQUEST['from'];
if($reseller == '')
{
include_once("main.php");
} else {
    include_once("mainReseller.php");
}
$standardObj = new offer();


if (isset($_POST['continue'])) {
    $productid = $_POST['productId']; //die();

    $standardObj->editDeleteStandardPreview($productid,$reseller);
}

$productid = $_GET['productId']; //die();
$data = $standardObj->getProductDetailById($productid);
//print_r($data);
//echo $data[0]['is_public'];
$lang = $standardObj->getLangProduct($productid);
$data[0]['lang'] = $lang;

//if (isset($_GET['reedit'])) {
//    $x = unserialize($_SESSION['product_for_edit']);
//    $data[0]['product_id'] = $x['productId'];
//    $data[0]['lang'] = $x['lang'];
//    $data[0]['slogen'] = $x['titleSloganStand'];
//    $data[0]['is_sponsored'] = $x['sponsStand'];
//    $data[0]['category'] = $x['linkedCatStand'];
//    $data[0]['link'] = $x['link'];
//    $data[0]['keywords'] = $x['searchKeywordStand'];
//    $data[0]['product_name'] = $x['productName'];
//    $data[0]['ean_code'] = $x['eanCode'];
//    $data[0]['product_number'] = $x['productNumber'];
//    $data[0]['is_public'] = $x['publicProduct'];
//    $data[0]['product_info_page'] = $x['descriptiveStand'];
//    $data[0]['start_of_publishing'] = $x['startDateStand'];
//    $data[0]['large_image'] = $_SESSION['preview']['large_image'];
//}
?>
<?php include 'config/defines.php'; ?>
<link rel="stylesheet" href="client/css/datePicker.css" type="text/css">
<script language="JavaScript" src="client/js/date.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/jquery.bgiframe.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/jquery.datePicker.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/ajaxuploadStand.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/jsStandardOffer.js" type="text/javascript"></script>
<!--<link rel="stylesheet" type="text/css" href="lib/vtip/css/vtip.css" />-->
<META http-equiv="Content-Type" content="text/html; charset=ISO-8859-15">
<style type="text/css">
a {
}
img {
	border: 0
}
</style>
<body>
<div class="center">
    <div id="msg" align="center">
    <?php
    if ($_SESSION['MESSAGE']) {
        echo $_SESSION['MESSAGE'];
        $_SESSION['MESSAGE'] = "";

    }
     if (($_SESSION['MESSAGE2'])) {
        //echo "here";
         echo "<br><a href='";
        echo $url = BASE_URL . 'getFinancial.php';
        echo "'>Load your Account</a>";
        $_SESSION['MESSAGE2'] = '';
    }
    ?>
  </div>
  <div>
    <div id="preview_frame"></div>
  </div>
  <form name="register" action="" id="registerform" method="Post" enctype="multipart/form-data">
    <input type="hidden" name="preview" value="1">
    <input type="hidden" name="productId" value="$_GET['productId']">
    <div class="blackbutton" style="padding-top: 45px;   ">Show Deleted Standard Offer</div>
    <div id="msg" align="center">
      <?php
        if ($_SESSION['MESSAGE']) {
            echo $_SESSION['MESSAGE'];
            $_SESSION['MESSAGE'] = "";
        }
        ?>
    </div>
    <div class="redwhitebutton_small123">Edit Data List View  For Standard Offer</div>
    <input type="hidden" name="m" value="saveNewStandard">
    <input type="hidden" name="productId" value="<?=$_GET['productId']
                   ?>">
    <table border="0"   width="100%" cellspacing="20"   >
      <tr >
        <td width="515"  >Language: </td>
        <td width="224"><select style="background-color:#e4e3dd; width:406px;" onChange="getLangImage(this.value);" class="text_field_new" name="lang" id="lang" >
            <option <? if ($data[0]['lang'] == "ENG"
                        )echo "selected='selected'"; ?> value="ENG">English</option>
            <option <? if ($data[0]['lang'] == "SWE"
                        )echo "selected='selected'"; ?> value="SWE">Swedish</option>
          </select>
          <div id='error_langStand' class="error"></div></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td >Product Name<span class='mandatory'>*</span>:</td>
        <td ><INPUT class="text_field_new" type=text name="titleSloganStand" id="titleSloganStand" maxlength="19" onBlur="iconPreview(this.form); getTitleForProduct(this.form);" value="<?=$data[0]['slogen']
                               ?>">
          <div id='error_titleSloganStand' class="error"></div></td>
        <td align="right" ><a title="<?=STITLE_TEXT
                           ?>" class="vtip"><b><small>?</small></b></a> </td>
      </tr>
      <tr>
        <td>Category<span class='mandatory'>*</span>:</td>
        <td colspan="2"><div id="category_lang_div">
            <select class="text_field_new" onChange="getCatImage(this.value, this.form);" style="background-color:#e4e3dd; width:406px;" tabindex="27" id="linkedCatStand" name="linkedCatStand" value="<?=$_SESSION['post']['linkedCatStand']
                                    ?>">
              <option <? if ($data[0]['category'] == ''

                            )echo "selected='selected'"; ?> value="">Select Category</option>
              <? echo $standardObj->getCategoryList($data[0]['category'],$lang); ?>
            </select>
          </div>
          <input type="hidden" name="category_image" id="category_image" value="">
          <div id="category_image_div" style="display:none;"></div>
          <div id='error_linkedCat' class="error"></div></td>
      </tr>
      <tr>
        <td>Small icon <font size="2">(Icon must be in png format only e.g. icon.png.The size must be at least 45 x 60 pixels)</font></td>
        <td><?php if ($_SESSION['preview']['small_image']) {
                    ?>
          <!-- <img src="upload/category/<?=$_SESSION['preview']['small_image'] ?>">-->
          <input class="text_field_new" type="hidden" name="smallimage" id="smallimage" value="<?=$_SESSION['preview']['small_image'] ?>">
          <br>
          <?
                }
                ?>
          <INPUT class="text_field_new" type=file name="icon" id="icon" onBlur="iconPreview(this.form);">
          <div id='error_icon' class="error"></div>
          <div>
            <input type="hidden" id="selected_image" name="selected_image" value="0">
          </div></td>
        <td align="right" valign="middle"><a title="<?=ICON_TEXT
                           ?>" class="vtip"><b><small>?</small></b></a> </td>
      </tr>
      <tr style="display:none;">
        <td colspan="5" align="center" height="20"><strong>
          <button onClick="ajaxUpload(this.form,'classes/ajx/ajxUpload.php?filename=icon&amp;maxW=200','upload_area'); return false;">Click here</button>
          to check how your short standard offer proposal looks like</strong></td>
      </tr>
    </table>
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr id="short_preview" style="display:inline;">
        <td align="center" width="407" >&nbsp;</td>
        <td width="442" align="center" valign="top" style="background-image:url(client/images/iphone_large-2.png); background-position:center; width:442; height:559px; background-repeat:no-repeat;"><div style="margin-top:150px; width:225px; margin-left:auto; margin-right:auto;" >
            <table width="100%" border="0" cellpadding="0" cellspacing="0" >
              <tr>
                <td colspan="3"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td  width="41"  align="left" style="padding-left:5px; padding-right:5px;"><div id="upload_area" style="vertical-align:top;"></div></td>
                      <td width="79%" rowspan="2" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="526"><span class="mob_title" id="tslogan"></span> </td>
                            <td width="21" align="right" nowrap style="padding-right:3px;"><div style="float:right"><font size="-3">??km</font></div></td>
                          </tr>
                          <tr>
                            <td colspan="2" valign="top"><span class="mob_txt" id="sslogan"></span></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                  </table></td>
              </tr>
              <tr>
                <td width="61">&nbsp;</td>
                <td width="79" valign="top"><span class="style6" id="sslogan" style="text-transform:lowercase;"></span></td>
                <td width="50" style="vertical-align:top;">&nbsp;</td>
              </tr>
            </table>
          </div></td>
        <td width="407">&nbsp;</td>
      </tr>
      <tr style="display:inline;">
        <td align="center" >&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
    <div class="redwhitebutton_small123">Describe how your Standard Offer should Behave</div>
    <table  width="100%" border="0" cellspacing="15">
      <tr>
        <td width="515">Sponsored Standard Offer<span class='mandatory'>*</span>:</td>
        <td width="227"><select class="text_field_new" style="background-color:#e4e3dd; width:406px;" tabindex="27" id="sponsStand" name="sponsStand">
            <option <?=$data[0]['is_sponsored'] <> 1 ? 'selected' : ''
                                ?> value="0">No</option>
            <option <?=$data[0]['is_sponsored'] <> 0 ? 'selected' : ''
                                ?> value="1">Yes</option>
          </select>
          <div id='error_sponsStand' class="error"></div></td>
        <td>&nbsp;</td>
      </tr>
    </table>
    <div class="redwhitebutton_small123">Advanced Options-Optional</div>
    <table   style="display:inline_row;" cellspacing="15" id="advancedSearchStand" width="100%">
      <tr>
        <td width="515">Keywords:</td>
        <td width="227"><INPUT class="text_field_new" type=text name="searchKeywordStand" id="searchKeywordStand" maxlength="90" value="<?=$data[0]['keyword']
                               ?>">
          <div id='error_searchKeywordStand' class="error"></div></td>
        <td align="right" valign="middle"><a title="<?=SKEYWORD_TEXT
                           ?>" class="vtip"><b><small>?</small></b></a> </td>
      </tr>
      <tr>
        <td>EAN Code:</td>
        <td><INPUT class="text_field_new" type=text name="eanCode" id="eanCode" value="<?=$data[0]['ean_code']
                               ?>">
          <div id='error_eanCode' class="error"></div></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Product Number:</td>
        <td><INPUT class="text_field_new" type=text name="productNumber" value="<?=$data[0]['product_number']
                               ?>" id="productNumber">
          <div id='error_productNumber' class="error"> </div></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
    </table>
    <div class="redwhitebutton_small123">Add your Coupon View</div>
    <table  width="100%" border="0" cellspacing="15">
      <tr>
        <td width="515">Large deal icon<span class='mandatory'>*</span><font size="2">(Image must be in jpeg or png format only e.g. image.png or image.jpg.The size must be at least 45 x 60 pixels)</font></td>
        <td width="227">

            
                <?php

                if (($data[0]['large_image'])) {


                    $icon_new = explode("/",$data[0]['large_image']);
                    $iconlngth = count($icon_new);
                    ?>
          <!-- <img src="upload/coupon/<?=$icon_new[$iconlngth-1]
                            ?>">-->
          <input class="text_field_new" type="hidden" name="largeimage" id="largeimage" value="<?=$data[0]['large_image']
              ?>">
          <?
                }
                ?>
          <INPUT  type=file name="picture" id="picture" onBlur="picturePreview(this.form);" class="text_field_new" >
          <div id='error_picture' class="error"></div></td>
        <td align="right" valign="middle"><a title="<?=SPICTURE_TEXT
                           ?>" class="vtip"><b><small>?</small></b></a></td>
      </tr>
      <tr>
        <td>Release date of product<span class='mandatory'>*</span>:</td>
        <td align="left"><?  $d=$data[0]['start_of_publishing'];
                $timeStamp = explode(" ",$d);
                $start_date = $timeStamp[0];?>
          <input  type="text" style="width:380px;" name="startDateStand" readonly="readonly" value="<?=$start_date
                                ?>" id="startDateStand" class="startDateStand dp-applied text_field_new" />
          <div id='error_startDateStand' class="error"></div></td>
        <td align="right"><a title="<?=START_TEXT
                           ?>" class="vtip"><b><small>?</small></b></a> </td>
      </tr>
      <tr>
        <td colspan="2"><INPUT class="text_field_new" type="hidden" name="productName" value="<?=$data[0]['product_name']
                               ?>" id="productName">
          <!--  <a title="<?=PRODUCTNAME_TEXT
                           ?>" class="vtip"><b><small>?</small></b></a></br>-->
          <div id='error_productName' class="error"></div></td>
      </tr>
      <tr>
        <td><?php if ($data[0]['is_public']) { ?>
          <input type="checkbox" name="publicProduct"  checked="checked" value="1">
          Public product
          <?php } else {
                    ?>
          <input type="checkbox" name="publicProduct" value="1">
          Public product
          <?php } ?>
          &nbsp; <a title="<?=PUBLIC_PRODUCT
                               ?>" class="vtip"><b><small>?</small></b></a> </td>
        <td colspan="2">&nbsp;</td>
      </tr>
      <div id='error_publicProduct' class="error"></div>
    </table>
    <div class="redwhitebutton_small123">Add your Info Page</div>
    <table  width="100%" style="display: inline_row;" id="infopageStand" cellspacing="15">
      <tr>
        <td width="515">Link:</td>
        <td width="227" valign="middle"><INPUT class="text_field_new" type=text name="link" id="link" value="<?=$data[0]['link']
                                           ?>">
          <div id='error_link' class="error"></div></td>
        <td align="right" valign="middle"><a title="<?=SDESCRIPTION_TEXT ?>" class="vtip"><b><small>?</small></b></a> </td>
      </tr>
    </table>
    <table width="100%" border="0">
      <tr>
        <td>&nbsp;</td>
        <td align="center"><table width="200" align="center" border="0" cellpadding="0" cellspacing="0" style="background-image:url(client/images/iphone_large.png); width:270px; height:529px; background-repeat:no-repeat;">
            <tr>
              <td width="4" height="143">&nbsp;</td>
              <td colspan="3">&nbsp;</td>
              <td width="5">&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td width="23" height="149" >&nbsp;</td>
              <td valign="top" style="text-align:left; " width="228"><?php
                            if ($data[0]['large_image']) {
                                $icon_new = explode("/",$data[0]['large_image']);
                                $iconlngth = count($icon_new);
                                ?>
                <div id="pic_upload" style="width:220px; height:112px;"><img id="picImg" src="upload/coupon/<?=$icon_new[$iconlngth-1]
                                             ?>" width="220" height="112" /></div>
                <?
                          }
                            ?>
                <span style=" color:#FFFFFF;"> <span id="pictslogan" style=" font-size: 18px; font-weight: bold; color:#FFFFFF;">
                <?=$data[0]['slogen']
                                            ?>
                </span> </span> <br>
                <br>
                <!-- <span style="padding-left:20px; color:#FFFFFF;"><b>Category:</b><? //echo $catName['categoryName'];    ?></span><br>-->
              </td>
              <td width="10" ></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td height="73" >&nbsp;</td>
              <td style="text-align:left; vertical-align: bottom;"><table width="104%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="50%" align="left" style=" padding-left:4px; color:#FFFFFF; font-size:10px;"><span style=" color:#FFFFFF; font-size:10px;"><strong>Store Name</strong>
                      <? //=$_SESSION['preview']['product_number']?>
                      <br />
                      <strong>Street</strong><br />
                      <br />
                      </span></td>
                    <td width="17%" height="20" style=" color:#FFFFFF; font-size:10px;">&nbsp;</td>
                    <td width="33%" style=" color:#FFFFFF; font-size:10px;"></td>
                  </tr>
                </table></td>
              <td ></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td height="252">&nbsp;</td>
              <td colspan="3">&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
          </table></td>
        <td>&nbsp;</td>
      </tr>
    </table>
    <div align="center">
      <?if($reseller == '') {?>
      <INPUT type="submit" align="center" value="Update" name="continue" class="button" id="continue" >
      <INPUT type="button" value="Back" name="continue" id="continue" class="button" onClick="javascript:location.href='showDeleteStandard.php';" >
      <?} else {?>
      <INPUT type="submit" align="center" value="Update" name="continue" class="button" id="continue" >
      <INPUT type="button" value="Back" name="continue" id="continue" class="button" onClick="javascript:location.href='showDeleteResellerStandard.php';" >
      <?}?>
    </div>
  </form>
  <div style="display:none;">
    <div align="center" >
      <h3> Check how your full Standard Offer proposal look like.</h3>
    </div>
    <table width="200" align="center" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="1">&nbsp;</td>
        <td colspan="3"><img src="client/images/top.png" width="281" height="114"></td>
        <td width="1">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td width="25" style="background-image: url(client/images/left_border.png); height: 270px;"></td>
        <td style="text-align:left; vertical-align: top;" width="235">Manjot Singh</td>
        <td width="20" style="background-image: url(client/images/right_border.png);"></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="3"><img src="client/images/bottom.png" width="277" height="128"></td>
        <td>&nbsp;</td>
      </tr>
    </table>
  </div>
  <span class='mandatory'>* These Fields Are Mandatory</span> </div>
<? include("footer.php"); ?>
</body>
<script language="JavaScript">
    //alert("sdfsfs");
    getCatImage('<?=$data[0]['category']?>');
</script>
<script language="JavaScript" src="client/js/jsImagePreview.js" type="text/javascript"></script>