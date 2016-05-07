<?php
/* File Name   : advertiseOffer.php
*  Description : Add Advertise Offer Form
*  Author      : Himanshu Singh  Date: 12th,Nov,2010  Creation
*/
header('Content-Type: text/html; charset=ISO-8859-15');
ob_start();

include_once("cumbari.php");
$regObj = new registration();
//$regObj->isValidRegistrationStep();
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
$reseller = "reseller";
if (($_POST['continue'])) {
     $offerObj->saveAdvertiseOffersDetails($reseller);
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
    .style6 {font-size: 9px} .center{width:900px; margin-left:auto; margin-right:auto;}

    -->
</style>
<div class="center">
  <div>
    <div id="preview_frame"></div>
  </div>
  <div id="main" >
    <div id="mainbutton">
      <form name="registerform" action="" id="registerform" method="Post" target="_self" enctype="multipart/form-data">
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
            <td height="15" >&nbsp;</td>
          </tr>
          <tr>
            <td class="blackbutton">2 Add Offer</td>
          </tr>
          <tr>
            <td height="15"  >&nbsp;</td>
          </tr>
          <tr>
            <td  class="blackbutton_small">Add Advertise Offer</td>
          </tr>
          <tr>
            <td height="15" >&nbsp;</td>
          </tr>
          <tr>
            <td  class="blackbutton_small" style=" padding-top:0px;" >Enter Basic Advertise Information</td>
          </tr>
          <tr>
            <td  height="15" >&nbsp;</td>
          </tr>
          <tr>
            <td align="left"><!-- <form action="" method="post" name="standard_use" id="standard_use" enctype="multipart/form-data">-->
              <table  border="0"   width="100%" cellspacing="15">
                <tr>
                  <td width="4">&nbsp;</td>
                  <td width="515">Language: </td>
                  <td width="469"><select  onchange="getLangImage(this.value);" style="width:406px; background-color:#e4e3dd;" class="text_field_new" name="lang" id="lang" >
                      <option <? if ($lang == "GER")echo "selected='selected'"; ?> value="GER">German</option>
                      <option <? if ($lang == "ENG")echo "selected='selected'"; ?> value="ENG">English</option>
                      <option <? if ($lang == "SWE")echo "selected='selected'"; ?> value="SWE">Swedish</option>
                    </select>
                      <a title="<?=CLANGUAGE_TEXT
                                                   ?>" class="vtip"><b><small>?</small></b></a><br/>
                    <div id='error_langStand' class="error"></div></td>
                </tr>
                <tr>
                  <td  align="left">&nbsp;</td>
                  <td  align="left"> Advertise Title. Max. 19 characters<span class='mandatory'>*</span>:</td>
                  <td  align="left"><INPUT class="text_field_new" type=text name="titleSlogan" id="titleSlogan" maxlength="19" onblur="iconPreview(this.form);" value="<?=$_SESSION['post']['titleSlogan']
                                                       ?>">
                       <a title="<?=ATITEL_TEXT
                                                   ?>" class="vtip"><b><small>?</small></b></a><br/>
                    <div id='error_titleSlogan' class="error"></div></td>
                </tr>
                <tr>
                  <td align="left">&nbsp;</td>
                  <td align="left"> Advertise Description. Max. 50 characters <span class='mandatory'>*</span>:</td>
                  <td align="left"><INPUT class="text_field_new" type=text name="subSlogan" id="subSlogan" maxlength="50" onblur="iconPreview(this.form);" value="<?=$_SESSION['post']['subSlogan']
                                                       ?>">
                    <a title="<?=ADESCRIPTION_TEXT
                                                   ?>" class="vtip"><b><small>?</small></b></a><br/>
                    <div id='error_subSlogan' class="error"></div></td>
                </tr>
                <tr>
                  <td align="left">&nbsp;</td>
                  <td align="left">Category<span class='mandatory'>*</span>:</td>
                  <td align="left"><div id="category_lang_div">
                      <select class="text_field_new" style="width:406px;  background-color:#e4e3dd; " onchange="getCatImage(this.value, this.form);"  tabindex="27" id="linkedCat" name="linkedCat" value="<?=$_SESSION['post']['linkedCat']
                                                                     ?>">
                        <option <? if ($data[0]['category'] == ''

                                                )echo "selected='selected'"; ?> value="">Select a Category</option>
                        <? echo $offerObj->getCategoryList($_SESSION['post']['linkedCat'],$lang); ?>
                      </select>
                    </div>
                    <input type="hidden" name="category_image" id="category_image" value="">
                    <div id="category_image_div" style="display:none;"></div>
                    <div id='error_linkedCat' class="error"></div></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>Small icon <font size="2">(Icon must be in png format only e.g. icon.png.The size must be at least 45 x 60 pixels)</font></td>
                  <td><?php if ($_SESSION['preview']['small_image']) { ?>
                    <img src="upload/category/<?=$_SESSION['preview']['small_image'] ?>">
                    <input  class="text_field_new" type="hidden" name="smallimage" id="smallimage" value="<?=$_SESSION['preview']['small_image'] ?>">
                    <br>
                    <?
                                        }
                                        ?>
                    <INPUT class="text_field_new" type="file" name="icon" id="icon" onblur="iconPreview(this.form);">
                    <a title="<?=ICON_TEXT
                                                   ?>" class="vtip"><b><small>?</small></b></a><br/>
                    <div id='error_icon' class="error"></div>
                    <div>
                      <input type="hidden" id="selected_image" name="selected_image" value="0">
                    </div></td>
                </tr>
                <tr style="display:none;">
                  <td colspan="4" align="right" height="20"><strong>
                    <button onClick="ajaxUpload(this.form,'classes/ajx/ajxUpload.php?filename=icon&amp;maxW=200','upload_area'); return false;">Click here</button>
                    to check how your short advertise proposal looks like</strong></td>
                </tr>
              </table>
              <!-- </form>-->
              <!-------------------------------------------------------------------->
              <table  border="0" align="center" cellpadding="0" cellspacing="0">
                <tr id="short_preview" style="display:inline;">
                  <td width="422" align="center" valign="top" style="background-image:url(client/images/iphone_large-2.png); width:270px; height:559px; background-repeat:no-repeat;"><div style="margin-top:150px; width:225px; margin-left:auto; margin-right:auto;" >
                      <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td  width="41"  align="left" style="padding-left:5px; padding-right:5px;"><div id="upload_area"  ></div></td>
                          <td width="79%" rowspan="2" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                              <tr>
                                <td colspan="2"><div class="mob_title_2" id="tslogan"></div><div style="float:right"><font size="-3">??km</font></div></td>
                               
                              </tr>
                              <tr>
                                <td colspan="2" style="float:left; width:173px; height:27px; word-wrap: break-word; overflow:hidden; font-size: 11px; text-transform: lowercase;" id="sslogan"></td>
                              </tr>
                            </table></td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                        </tr>
                      </table>
                    </div></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td class="redwhitebutton_small" style="padding-top:5px;  "><a href="#"  onclick="showAdvertiseBehavior();">Enter Advertise Behaviour</a></td>
          </tr>
        </table>
        <table border="0"  width="100%" cellspacing="15"   style="display:inline-table;" id="AdvertiseBehavior">
          <tr>
           
            <td width="515">Sponsored
              Advertise <span class='mandatory'>*</span>:</td>
            <td  width="469"><select style="width:406px; background-color:#e4e3dd;" class="text_field_new"  id="sponsor" name="sponsor">
                <option <? if ($_SESSION['post']['sponsor'] == '0'

                                )echo "selected='selected'"; ?> value="0">No</option>
                <option <? if ($_SESSION['post']['sponsor'] == '1'

                                )echo "selected='selected'"; ?> value="1">Yes</option>
                        </select>
                        <a title="<?=ASPONSOR_TEXT ?>" class="vtip"><b><small>?</small></b></a><br/>
                        <span style="font-size:12px;"> (Price per view 0.01 kr)</span>
                        <div id='error_sponsor' class="error"></div> </td>
                </tr>
              
            </table>
		  <table width="100%"> <tr>
                    <td  colspan="2" width="870" align="left"class="redwhitebutton_small" style="padding-top:5px; " onclick="showExtendedAdvertise();">Enter Extended Advertise Offer</td>
                </tr>
                <tr></table>
            <table BORDER=0 style="display:inline;" cellspacing="15" width="100%" id="ExtendedAdvertise">

               

                    <tr>
                    		<td width="1">&nbsp;</td>
                    		<td width="515">Large deal icon <font size="2">(Image must be in jpeg or png format only e.g. image.png or image.jpg.The size must be at least 247 x 130 pixels)</font>
                <span class='mandatory'>*</span></td>
                <td width="469">
                    <?php if ($_SESSION['preview']['large_image']) { ?><img src="upload/coupon/<?=$_SESSION['preview']['large_image'] ?>">
                    <input class="text_field_new" type="hidden" name="largeimage" id="largeimage" value="<?=$_SESSION['preview']['large_image'] ?>">
                    <br>Or&nbsp;
                        <?
                    }
                    ?>
              <INPUT class="text_field_new" type=file name="picture" id="picture" onblur="picturePreview(this.form);">
              <a title="<?=SPICTURE_TEXT
                               ?>" class="vtip"><b><small>?</small></b></a><br/>
              <div id='error_picture' class="error"></div></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Link:</td>
            <td><input type="text" class="text_field_new" NAME="descriptive" id="descriptive" value="">
              <?=$_SESSION['post']['descriptive']
                                ?>
              </input>
              <a title="<?=ALINK_TEXT
                                   ?>" class="vtip"><b><small>?</small></b></a>
              <div id='error_descriptive' class="error"></div></td>
          </tr>
        </table>
        <table width="100%" border="0">
          <tr>
            <td height="571">&nbsp;</td>
            <td align="center"><table width="200" height="592" border="0" align="center" cellpadding="0" cellspacing="0" style="background-image:url(client/images/iphone_large.png); width:270px; height:529px; background-repeat:no-repeat;">
                <tr>
                  <td width="4" height="143">&nbsp;</td>
                  <td colspan="3">&nbsp;</td>
                  <td width="5">&nbsp;</td>
                </tr>
                <tr>
                  <td height="111" >&nbsp;</td>
                  <td width="22"  ></td>
                  <td valign="top" style="text-align:left; " width="229" ><div id="pic_upload"  style="width:220px; height:112px;"><img id="picImg" src="upload/coupon/<?=$_SESSION['preview']['large_image']
                                                 ?>" width="220" height="112" /></div>
                   
                   
                  </td>
                  <td width="10" ></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td height="19"></td>
                  <td  ></td>
                  <td valign="top" style="text-align:left; color:#FFFFFF; font-weight:bold; font-size:18px;"  id="ttSlogen" >&nbsp;</td>
                  <td ></td>
                  <td></td>
                </tr>
                <tr>
                  <td height="19"></td>
                  <td ></td>
                  <td valign="top" style="text-align:left; font-size:12px; color:#FFFFFF; "  id="ssSlogen" ></td>
                  <td ></td>
                  <td></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td height="73" >&nbsp;</td>
                  <td style="text-align:left; vertical-align: bottom;"><table width="104%" border="0" cellpadding="0" cellspacing="0">
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
            <td><div align="center"><br />
                <br />
                <INPUT type="submit" value="Continue" name="continue" id="continue" class="button">
                <br />
                <br />
              </div></td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <table border="0" width="100%">
          <tr>
            <td align="left" >&nbsp;</td>
          </tr>
          <tr>
            <td align="left" height="15" >&nbsp;</td>
          </tr>
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
</div>
<? include("footer.php"); ?>
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
