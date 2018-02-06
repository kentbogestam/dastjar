<?php
/* File Name   : advertiseOffer.php
*  Description : Add Advertise Offer Form
*  Author      : Himanshu Singh  Date: 12th,Nov,2010  Creation
*/
header('Content-Type: text/html; charset=utf-8');
ob_start();
include_once("cumbari.php");
$regObj = new registration();
 //$discount = $regObj->getCcode();
$regObj->isValidRegistrationStep();
$offerObj = new offer();

$compcont = $offerObj->companycountry();
if ($compcont == 'Sweden') {
    //echo $compcont;die;
    $lang = 'SWE';
    //echo $lang;die;
}
elseif ($compcont == 'Germany') {
    $lang = 'GER';
}
else {
    $lang = 'ENG';
}

if (($_POST['continue'])) {
    $offerObj->saveAdvertiseOffersDetails();
}
include_once("header.php");
if (isset($_GET['reedit'])) {
    $lang = $_SESSION['post']['lang'];
}
?>
<?php
if ($_SESSION['MESSAGE']) {
    echo $_SESSION['MESSAGE'];
    $_SESSION['MESSAGE'] = "";
}
?>
<link rel="stylesheet" href="client/css/datePicker.css" type="text/css" >
<script language="JavaScript" src="client/js/date.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/jquery.bgiframe.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/jquery.datePicker.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/ajaxupload.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/jsAdvertiseOffer.js" type="text/javascript"></script>
<style type="text/css">
<!--
.style4 {
	font-size: 10px;
	font-weight: bold;
}
.style6 {
	font-size: 9px
}
.center {
	width:900px;
	margin-left:auto;
	margin-right:auto;
}
-->
</style>
<div class="center">
<div>
  <div id="preview_frame"></div>
</div>
<body>
<div id="main" >
  <div id="mainbutton">
    <form name="registerform" action="advertiseOffer.php" id="registerform" method="Post" target="_self" enctype="multipart/form-data">
      <input type="hidden" name="preview" value="1">
      <input type="hidden" name="m" value="saveoffer">
      <table width="100%" cellspacing="0" border="0">
        <tr>
          <td height="15">&nbsp;</td>
        </tr>
        <tr>
          <td  class="redwhitebutton">1 Register</td>
        </tr>
        <tr>
          <td height="15"  >&nbsp;</td>
        </tr>
        <tr>
          <td class="redwhitebutton" >2 Add Company</td>
        </tr>
        <tr>
          <td height="15" >&nbsp;</td>
        </tr>
        <tr>
          <td class="blackbutton">3 Add Offer</td>
        </tr>
        <tr>
          <td ><img src="images/spacer.gif" height="10" />&nbsp;</td>
        </tr>
        <tr>
          <td  class="blackbutton_small_2">Add Advertise Offer</td>
        </tr>
        <tr>
          <td><img src="images/spacer.gif" width="1" height="5" /><img src="images/spacer.gif" width="1" height="10" /></td>
        </tr>
        <tr>
          <td  class="blackbutton_small_2">Enter Basic Advertise Information</td>
        </tr>
        <tr>
          <td  height="15" ><img src="images/spacer.gif" width="1" height="15" /></td>
        </tr>
        <tr>
          <td align="left"><!-- <form action="" method="post" name="standard_use" id="standard_use" enctype="multipart/form-data">-->
            <table   width="100%"  border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="50%" align="left" valign="top" class="td_pad_left">Language: </td>
                <td width="50%" align="left" valign="top" class="td_pad_right"><select  onchange="getLangImage(this.value);" style="width:406px; background-color:#e4e3dd;" class="text_field_new" name="lang" id="lang" >
                    <option <? if ($lang == "GER")echo "selected='selected'"; ?> value="GER">German</option>
                    <option <? if ($lang == "ENG")echo "selected='selected'"; ?> value="ENG">English</option>
                    <option <? if ($lang == "SWE")echo "selected='selected'"; ?> value="SWE">Swedish</option>
                  </select>
                  <div id='error_langStand' class="error"></div></td>
                <td align="right"><a title="<?=CLANGUAGE_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
              </tr>
              <tr>
                
                <td width="50%"  align="left" valign="top" class="td_pad_left"> Advertise Title. Max. 19 characters<span class='mandatory'>*</span>:</td>
                <td width="50%"  align="left" valign="top" class="td_pad_right"><INPUT class="text_field_new" type=text name="titleSlogan" id="titleSlogan" maxlength="19" onBlur="iconPreview(this.form);;limitPreview(this.form);" value="<?=$_SESSION['post']['titleSlogan']
                                                       ?>">
                  <div id='error_titleSlogan' class="error"></div></td>
                 <td align="right"><a title="<?=ATITEL_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
              </tr>
              <tr>
                <td width="50%" align="left" valign="top" class="td_pad_left"> Advertise Description. Max. 50 characters <span class='mandatory'>*</span>:</td>
                <td width="50%" align="left" valign="top" class="td_pad_right"><INPUT class="text_field_new" type=text name="subSlogan" id="subSlogan" maxlength="50" onBlur="iconPreview(this.form);;limitPreview(this.form);" value="<?=$_SESSION['post']['subSlogan']
                                                       ?>">
                  <div id='error_subSlogan' class="error"></div></td>
                   <td align="right"><a title="<?=ADESCRIPTION_TEXT?>" class="vtip"><b><small>?</small></b></a> </td>
              </tr>
              <tr>
                <td width="50%" align="left" valign="top" class="td_pad_left">Category<span class='mandatory'>*</span>:</td>
                <td width="50%" align="left" valign="top" class="td_pad_right"><div id="category_lang_div">
                    <select class="text_field_new" style="width:406px;  background-color:#e4e3dd; " onChange="getCatImage(this.value, this.form);"  tabindex="27" id="linkedCat" name="linkedCat" value="<?=$_SESSION['post']['linkedCat']
                                                                     ?>">
                      <option <? if ($data[0]['category'] == ''

                                                )echo "selected='selected'"; ?> value="">Select a Category</option>
                      <? echo $offerObj->getCategoryList($_SESSION['post']['linkedCat'],$lang); ?>
                    </select>
                  </div>
                  <input type="hidden" name="category_image" id="category_image" value="">
                  <div id="category_image_div" style="display:none;"></div>
                  <div id='error_linkedCat' class="error"></div></td>
                  <td align="right"><a title="<?=CCATEGORY_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
              </tr>
              <tr>
              
                <td width="50%" align="left" valign="top" class="td_pad_left">Small icon <font size="2">(Icon must be in png format only e.g. icon.png.The size must be at least 45 x 60 pixels)</font></td>
                <td width="50%" align="left" valign="top" class="td_pad_right"><?php if ($_SESSION['preview']['small_image']) { ?>
                  <img style="display:none;" src="upload/category/<?=$_SESSION['preview']['small_image'] ?>">
                  <input  class="text_field_new" type="hidden" name="smallimage" id="smallimage" value="<?=$_SESSION['preview']['small_image'] ?>">
                  <br>
                  <?
                                        }
                                        ?>
                  <INPUT class="text_field_new" type="file" name="icon" id="icon" onBlur="iconPreview(this.form);">
                  <div id='error_icon' class="error"></div>
                  <div>
                    <input type="hidden" id="selected_image" name="selected_image" value="0">
                  </div></td>
                  <td align="right"><a title="<?=ICON_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
              </tr>
              <tr style="display:none;">
                <td colspan="4" align="right" height="20"><strong>
                  <button onClick="ajaxUpload(this.form,'classes/ajx/ajxUpload.php?filename=icon&amp;maxW=200','upload_area'); return false;">Click here</button>
                  to check how your short advertise proposal looks like</strong></td>
              </tr>
            </table>
            <!-- </form>-->
            <!-------------------------------------------------------------------->
            <table border="0" align="center" cellpadding="0" cellspacing="0">
              <tr id="short_preview" style="display:inline;">
                <td width="442" align="center" valign="top" style="background-image:url(client/images/iphone_large-2.png); background-position:center; width:442; height:559px; background-repeat:no-repeat;"><div style="margin-top:150px; width:225px; margin-left:auto; margin-right:auto; overflow:hidden;" >
                    <table border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td align="left" valign="top" style="padding-left:5px; padding-right:5px;"><div id="upload_area" style="vertical-align:top;"></div></td>
                        <td  rowspan="2" valign="top"><table  border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td colspan="2"><div class="mob_title_2" id="tslogan"></div><div style="float:right"><font size="-3">??km</font></div></td>
                           
                            </tr>
                            <tr>
                              <td colspan="2" valign="top" class="mob_txt" id="sslogan"></td>
                            </tr>
                          </table></td>
                      </tr>
                     
                    </table>
                  </div></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td><img src="images/spacer.gif" width="1" height="10" /></td>
        </tr>
        <tr>
          <td class="redwhitebutton_small" style="padding-top:5px; text-align:center; margin-bottom:10px;"><a href="#"  onclick="showAdvertiseBehavior();">Enter Advertise Behaviour</a></td>
        </tr>
        <td><img src="images/spacer.gif" height="5" /></td>
      </table>
      <table  width="100%" border="0" cellpadding="0" cellspacing="0" id="AdvertiseBehavior"   style="display:inline-table;">
        <tr>
          <td width="50%" align="left" valign="top" class="td_pad_left">Sponsored
            Advertise <span class='mandatory'>*</span>:</td>
          <td  width="50%" align="left" valign="top" class="td_pad_right"><select style="width:406px; background-color:#e4e3dd; height:36px; border: 1px solid #abadb3;" class="text_field_new"  id="sponsor" name="sponsor">
              <option <? if ($_SESSION['post']['sponsor'] == '0'

                                )echo "selected='selected'"; ?> value="0">No</option>
              <option <? if ($_SESSION['post']['sponsor'] == '1'

                                )echo "selected='selected'"; ?> value="1">Yes</option>
            </select>
          
            <span style="font-size:12px;"> (Price per view 0.01 kr)</span>
            <div id='error_sponsor' class="error"></div></td>
           <td align="right" valign="top"><a title="<?=ASPONSOR_TEXT ?>" class="vtip"><b><small>?</small></b></a></td>
        </tr>
        <tr>
          <td width="50%" align="left" valign="top" class="td_pad_left">Start date of Advertise<span class='mandatory'>*</span> :</td>
          <td colspan="2" align="left" valign="top" class="td_pad_right"  ><input  type="text" style="width:382px;" name="startDate" readonly="readonly" value="<?=$_SESSION['post']['startDate'] ?>" id="startDate" class="startDate dp-applied text_field_new" />
            <div id='error_startDate' class="error"></div></td>
           <td align="right"><a title="<?=ASTART_TEXT ?>" class="vtip"><b><small>?</small></b></a> </td>
        </tr>
        <tr>
        
          <td width="50%" align="left" valign="top" class="td_pad_left" >End date of Advertise<span class='mandatory'>*</span> :</td>
          <td colspan="2" align="left" valign="top" class="td_pad_right"><input style="width:382px;"  type="text" name="endDate" readonly="readonly" value="<?=$_SESSION['post']['endDate'] ?>" id="endDate" class="endDate dp-applied text_field_new" />
            <div id='error_endDate' class="error"></div></td>
            <td align="right"><a title="<?=AEND_TEXT ?>" class="vtip"><b><small>?</small></b></a> </td>
        </tr>
        <tr>
         
          <td width="50%" align="left" valign="top" class="td_pad_left">Advertise Name.Not displayed to end user.Only for internal use.<span class='mandatory'>*</span>:</td>
          <td colspan="2" align="left" valign="top" class="td_pad_right"><input class="text_field_new" type="text" name="advertiseName" value="<?=$_SESSION['post']['advertiseName'] ?>" id="advertiseName" />
            <div id='error_advertiseName' class="error"></div></td>
           <td align="right"><a title="<?=ADVERTISENAME_TEXT ?>" class="vtip"><b><small>?</small></b></a> </td>
        </tr>
        <tr>
          <td width="50%" align="left" valign="top" class="td_pad_left">Keyword:</td>
          <td colspan="2" align="left" valign="top" class="td_pad_right"><input class="text_field_new" type="text" name="searchKeyword" maxlength="90" value="<?=$_SESSION['post']['searchKeyword'] ?>" id="searchKeyword" />
            <div id='error_searchKeyword' class="error" ></div></td>
            <td align="right"><a title="<?=AKEYWORD_TEXT ?>" class="vtip"><b><small>?</small></b></a> </td>
        </tr>
      </table>
      <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
          <td  colspan="2" align="left" class="redwhitebutton_small" style="padding-top:5px;" onclick="showExtendedAdvertise();">Enter Extended Advertise Offer</td>
        </tr>
        <tr>
      </table>
      <table width="100%" BORDER=0 cellpadding="0" cellspacing="0" id="ExtendedAdvertise" style="display:inline;">
        <tr>
         
          <td width="50%" align="left" valign="top" class="td_pad_left">Large deal icon <font size="2">(Image must be in jpeg or png format only e.g. image.png or image.jpg.The size must be at least 247 x 130 pixels)</font> <span class='mandatory'>*</span></td>
          <td width="50%" align="left" valign="top" class="td_pad_right"><?php if ($_SESSION['preview']['large_image']) { ?>
            <img style="display:none;" src="upload/coupon/<?=$_SESSION['preview']['large_image'] ?>">
            <input class="text_field_new" type="hidden" name="largeimage" id="largeimage" value="<?=$_SESSION['preview']['large_image'] ?>">
            <br>
            Or&nbsp;
            <?
                    }
                    ?>
            <INPUT class="text_field_new" type=file name="picture" id="picture" onBlur="picturePreview(this.form);">
            <div id='error_picture' class="error"></div></td>
            <td align="right"><a title="<?=CPICTURE_TEXT?>" class="vtip"><b><small>?</small></b></a> </td>
        </tr>
        <tr>
          
          <td width="50%" align="left" valign="top" class="td_pad_left">Link:</td>
          <td width="50%" align="left" valign="top" class="td_pad_right"><input type="text" class="text_field_new" NAME="descriptive" id="descriptive" value="">
            <?=$_SESSION['post']['descriptive']
                                ?>
            </input>
           
            <div id='error_descriptive' class="error"></div></td>
          <td align="right" ><a title="<?=ALINK_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
        </tr>
      </table>
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="571">&nbsp;</td>
          <td align="center"><table width="200" height="592" border="0" align="center" cellpadding="0" cellspacing="0" style="background-image:url(client/images/iphone_large.png); width:270px; height:529px; background-repeat:no-repeat;">
              <tr>
                <td width="4" height="133">&nbsp;</td>
                <td colspan="3">&nbsp;</td>
                <td width="5">&nbsp;</td>
              </tr>
              <tr>
                <td height="111" >&nbsp;</td>
                <td width="22"  ></td>
                <td valign="top" style="text-align:left; " width="229" ><div id="pic_upload"  style="width:220px; height:112px; margin-top:10px;"><img id="picImg" src="upload/coupon/<?=$_SESSION['preview']['large_image']
                                                 ?>" width="220" height="112" /></div>
              
                  <!-- <span style="padding-left:20px; color:#FFFFFF;"><b>Category:</b><? //echo $catName['categoryName'];    ?></span><br>-->
                </td>
                <td width="10" ></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td height="19"></td>
                <td  ></td>
                <td valign="top"><div class="ttslogen" id="ttSlogen"></div></td>
                <td ></td>
                <td></td>
              </tr>
              <tr>
                <td height="19"></td>
                <td ></td>
                <td valign="top"><div class="ssslogen" id="ssSlogen"></div></td>
                <td ></td>
                <td></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td height="73" >&nbsp;</td>
                <td style="text-align:left; vertical-align: bottom;"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="41%" align="left" valign="top" style=" padding-left:4px; color:#FFFFFF; font-size:10px;"><strong>Store Name</strong>
                        <? //=$_SESSION['preview']['product_number']?>
                        <br>
                        <strong>Street</strong></td>
                      <td width="8%" height="20" align="left" style=" color:#FFFFFF; font-size:10px;">&nbsp;</td>
                      <td width="51%" height="20" align="left" valign="top" style=" color:#FFFFFF; font-size:10px;" id="limitPreview"></td>
                    </tr>
                  </table></td>
                <td ></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td height="225">&nbsp;</td>
                <td colspan="3">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><div align="center">
              <INPUT type="submit" value="Continue" name="continue" id="continue" class="button">
            </div></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><img src="images/spacer.gif" width="1" height="8" /></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
      <table border="0" width="100%">
        <tr>
          <td width="100%" align="left" class="redgraybutton">3 Activate</td>
        </tr>
        <tr>
          <td align="left" ></td>
        </tr>
        <tr>
          <td height="15">&nbsp;</td>
        </tr>
      </table>
    </form>
  </div>
  <span class='mandatory'>* These Fields Are Mandatory</span> </div>
<? include("footer.php"); ?>
</body>
</html>
<? if ($_SESSION['preview']) {
    ?>
<script>
    showAdvertiseBehavior();
    showExtendedAdvertise();
</script>
<?
}
?>
<script language="JavaScript" src="client/js/jsImagePreview.js" type="text/javascript"></script>
