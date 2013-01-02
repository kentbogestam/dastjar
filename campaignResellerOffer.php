<?php
/* File Name   : campaignOffer.php
*  Description : Add Campaign Offer Form
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
else {
    $lang = 'ENG';
}
$reseller = "reseller";
if (($_POST['continue'])) {
     $offerObj->saveCampaignOffersDetails($reseller);
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
<script language="JavaScript" src="client/js/jsCampaignOffer.js" type="text/javascript"></script>
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
            <td  class="blackbutton_small">Add Campaign Offer</td>
          </tr>
          <tr>
            <td height="15" >&nbsp;</td>
          </tr>
          <tr>
            <td  class="blackbutton_small" style=" padding-top:0px;" >Enter Basic Campaign Information</td>
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
                      <option <? if ($lang == "ENG"
                                                )echo "selected='selected'"; ?> value="ENG">English</option>
                      <option <? if ($lang == "SWE"
                                                )echo "selected='selected'"; ?> value="SWE">Swedish</option>
                    </select>
                    <div id='error_langStand' class="error"></div></td>
                </tr>
                <tr>
                  <td  align="left">&nbsp;</td>
                  <td  align="left"> Campaign Title. Max. 19 characters<span class='mandatory'>*</span>:</td>
                  <td  align="left"><INPUT class="text_field_new" type=text name="titleSlogan" id="titleSlogan" maxlength="19" onblur="iconPreview(this.form);" value="<?=$_SESSION['post']['titleSlogan']
                                                       ?>">
                    <div id='error_titleSlogan' class="error"></div></td>
                </tr>
                <tr>
                  <td align="left">&nbsp;</td>
                  <td align="left"> Campaign Description. Max. 50 characters <span class='mandatory'>*</span>:</td>
                  <td align="left"><INPUT class="text_field_new" type=text name="subSlogan" id="subSlogan" maxlength="50" onblur="iconPreview(this.form);" value="<?=$_SESSION['post']['subSlogan']
                                                       ?>">
                    <a title="<?=DESCRIPTION_TEXT
                                                   ?>" class="vtip"><b><small>?</small></b></a></br>
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
                                                   ?>" class="vtip"><b><small>?</small></b></a></br>
                    <div id='error_icon' class="error"></div>
                    <div>
                      <input type="hidden" id="selected_image" name="selected_image" value="0">
                    </div></td>
                </tr>
                <tr style="display:none;">
                  <td colspan="4" align="right" height="20"><strong>
                    <button onClick="ajaxUpload(this.form,'classes/ajx/ajxUpload.php?filename=icon&amp;maxW=200','upload_area'); return false;">Click here</button>
                    to check how your short campaign proposal looks like</strong></td>
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
            <td class="redwhitebutton_small" style="padding-top:5px;  "><a href="#"  onclick="showCampaignBehavior();">Enter Campaign Behaviour</a></td>
          </tr>
        </table>
        <table border="0"  width="100%" cellspacing="15"   style="display:inline-table;" id="CampaignBehavior">
          <tr>
           
            <td width="515">Sponsored
              Campaign <span class='mandatory'>*</span>:</td>
            <td  width="469"><select style="width:406px; background-color:#e4e3dd;" class="text_field_new"  id="sponsor" name="sponsor">
                <option <? if ($_SESSION['post']['sponsor'] == '0'

                                )echo "selected='selected'"; ?> value="0">No</option>
                <option <? if ($_SESSION['post']['sponsor'] == '1'

                                )echo "selected='selected'"; ?> value="1">Yes</option>
                        </select>
                        <a title="<?=SPONSOR_TEXT ?>" class="vtip"><b><small>?</small></b></a></br>
                        <span style="font-size:12px;"> (Price per view 0.01 kr)</span>
                        <div id='error_sponsor' class="error"></div> </td>
                </tr>
               <tr>
          <td width="50%" align="left" valign="top">Deal is only valid to an end time during a day:</td>
          <td colspan="2" align="left" valign="top" class="td_pad_right"><!--<INPUT type=text name="endDateLimitation" id="endDateLimitation">-->
            <select style="width:406px; background-color:#e4e3dd; height:36px; border: 1px solid #abadb3;" class="text_field_new" name="endDateLimitation" id="endDateLimitation" onBlur="limitPreview(this.form);" value="<?=$_SESSION['post']['endDateLimitation'] ?>">
              <option <? if ($_SESSION['post']['endDateLimitation'] == ''

                                )echo "selected='selected'"; ?> value="">Select an End Time</option>
              <option <? if ($_SESSION['post']['endDateLimitation'] == '00'

                                )echo "selected='selected'"; ?> value="00">00</option>
              <option <? if ($_SESSION['post']['endDateLimitation'] == '01'

                                )echo "selected='selected'"; ?> value="01">01</option>
              <option <? if ($_SESSION['post']['endDateLimitation'] == '02'

                                )echo "selected='selected'"; ?> value="02">02</option>
              <option <? if ($_SESSION['post']['endDateLimitation'] == '03'

                                )echo "selected='selected'"; ?> value="03">03</option>
              <option <? if ($_SESSION['post']['endDateLimitation'] == '04'

                                )echo "selected='selected'"; ?> value="04">04</option>
              <option <? if ($_SESSION['post']['endDateLimitation'] == '05'

                                )echo "selected='selected'"; ?> value="05">05</option>
              <option <? if ($_SESSION['post']['endDateLimitation'] == '06'

                                )echo "selected='selected'"; ?> value="06">06</option>
              <option <? if ($_SESSION['post']['endDateLimitation'] == '07'

                                )echo "selected='selected'"; ?> value="07">07</option>
              <option <? if ($_SESSION['post']['endDateLimitation'] == '08'

                                )echo "selected='selected'"; ?> value="08">08</option>
              <option <? if ($_SESSION['post']['endDateLimitation'] == '09'

                                )echo "selected='selected'"; ?> value="09">09</option>
              <option <? if ($_SESSION['post']['endDateLimitation'] == '10'

                                )echo "selected='selected'"; ?> value="10">10</option>
              <option <? if ($_SESSION['post']['endDateLimitation'] == '11'

                                )echo "selected='selected'"; ?> value="11">11</option>
              <option <? if ($_SESSION['post']['endDateLimitation'] == '12'

                                )echo "selected='selected'"; ?> value="12">12</option>
              <option <? if ($_SESSION['post']['endDateLimitation'] == '13'

                                )echo "selected='selected'"; ?> value="13">13</option>
              <option <? if ($_SESSION['post']['endDateLimitation'] == '14'

                                )echo "selected='selected'"; ?> value="14">14</option>
              <option <? if ($_SESSION['post']['endDateLimitation'] == '15'

                                )echo "selected='selected'"; ?> value="15">15</option>
              <option <? if ($_SESSION['post']['endDateLimitation'] == '16'

                                )echo "selected='selected'"; ?> value="16">16</option>
              <option <? if ($_SESSION['post']['endDateLimitation'] == '17'

                                )echo "selected='selected'"; ?> value="17">17</option>
              <option <? if ($_SESSION['post']['endDateLimitation'] == '18'

                                )echo "selected='selected'"; ?> value="18">18</option>
              <option <? if ($_SESSION['post']['endDateLimitation'] == '19'

                                )echo "selected='selected'"; ?> value="19">19</option>
              <option <? if ($_SESSION['post']['endDateLimitation'] == '20'

                                )echo "selected='selected'"; ?> value="20">20</option>
              <option <? if ($_SESSION['post']['endDateLimitation'] == '21'

                                )echo "selected='selected'"; ?> value="21">21</option>
              <option <? if ($_SESSION['post']['endDateLimitation'] == '22'

                                )echo "selected='selected'"; ?> value="22">22</option>
              <option <? if ($_SESSION['post']['endDateLimitation'] == '23'

                                )echo "selected='selected'"; ?> value="23">23</option>
            </select>

                              
              <div id='error_startDateLimitation'></div></td>
          </tr>
          <tr>
            
            <td>Deal is only valid to an end time during a day:</td>
            <td colspan="2"><!--<INPUT type=text name="endDateLimitation" id="endDateLimitation">-->
              <select style="width:406px; background-color:#e4e3dd;" class="text_field_new" name="endDateLimitation" id="endDateLimitation" onBlur="limitPreview(this.form);" value="<?=$_SESSION['post']['endDateLimitation'] ?>">
                <option <? if ($_SESSION['post']['endDateLimitation'] == ''

                                )echo "selected='selected'"; ?> value="">Select an End Time</option>
                <option <? if ($_SESSION['post']['endDateLimitation'] == '00'

                                )echo "selected='selected'"; ?> value="00">00</option>
                <option <? if ($_SESSION['post']['endDateLimitation'] == '01'

                                )echo "selected='selected'"; ?> value="01">01</option>
                <option <? if ($_SESSION['post']['endDateLimitation'] == '02'

                                )echo "selected='selected'"; ?> value="02">02</option>
                <option <? if ($_SESSION['post']['endDateLimitation'] == '03'

                                )echo "selected='selected'"; ?> value="03">03</option>
                <option <? if ($_SESSION['post']['endDateLimitation'] == '04'

                                )echo "selected='selected'"; ?> value="04">04</option>
                <option <? if ($_SESSION['post']['endDateLimitation'] == '05'

                                )echo "selected='selected'"; ?> value="05">05</option>
                <option <? if ($_SESSION['post']['endDateLimitation'] == '06'

                                )echo "selected='selected'"; ?> value="06">06</option>
                <option <? if ($_SESSION['post']['endDateLimitation'] == '07'

                                )echo "selected='selected'"; ?> value="07">07</option>
                <option <? if ($_SESSION['post']['endDateLimitation'] == '08'

                                )echo "selected='selected'"; ?> value="08">08</option>
                <option <? if ($_SESSION['post']['endDateLimitation'] == '09'

                                )echo "selected='selected'"; ?> value="09">09</option>
                <option <? if ($_SESSION['post']['endDateLimitation'] == '10'

                                )echo "selected='selected'"; ?> value="10">10</option>
                <option <? if ($_SESSION['post']['endDateLimitation'] == '11'

                                )echo "selected='selected'"; ?> value="11">11</option>
                <option <? if ($_SESSION['post']['endDateLimitation'] == '12'

                                )echo "selected='selected'"; ?> value="12">12</option>
                <option <? if ($_SESSION['post']['endDateLimitation'] == '13'

                                )echo "selected='selected'"; ?> value="13">13</option>
                <option <? if ($_SESSION['post']['endDateLimitation'] == '14'

                                )echo "selected='selected'"; ?> value="14">14</option>
                <option <? if ($_SESSION['post']['endDateLimitation'] == '15'

                                )echo "selected='selected'"; ?> value="15">15</option>
                <option <? if ($_SESSION['post']['endDateLimitation'] == '16'

                                )echo "selected='selected'"; ?> value="16">16</option>
                <option <? if ($_SESSION['post']['endDateLimitation'] == '17'

                                )echo "selected='selected'"; ?> value="17">17</option>
                <option <? if ($_SESSION['post']['endDateLimitation'] == '18'

                                )echo "selected='selected'"; ?> value="18">18</option>
                <option <? if ($_SESSION['post']['endDateLimitation'] == '19'

                                )echo "selected='selected'"; ?> value="19">19</option>
                <option <? if ($_SESSION['post']['endDateLimitation'] == '20'

                                )echo "selected='selected'"; ?> value="20">20</option>
                <option <? if ($_SESSION['post']['endDateLimitation'] == '21'

                                )echo "selected='selected'"; ?> value="21">21</option>
                <option <? if ($_SESSION['post']['endDateLimitation'] == '22'

                                )echo "selected='selected'"; ?> value="22">22</option>
                <option <? if ($_SESSION['post']['endDateLimitation'] == '23'

                                )echo "selected='selected'"; ?> value="23">23</option>
              </select>
              <div id='error_endDateLimitation'></div></td>
          </tr>
          <tr>
            
            <td>Deal is only valid to a limited set of days during the week:</td>
            <td colspan="2"><!--<INPUT type=text name="limitDays" id="limitDays">-->
              <select style="width:406px; background-color:#e4e3dd;" class="text_field_new" name="limitDays" id="limitDays" onBlur="limitPreview(this.form);">
                <option <? if ($_SESSION['post']['valid_day'] == ''

                                )echo "selected='selected'"; ?> value="">Select a Set of Days</option>
                            <option value="MON">MON</option>
                            <option value="TUE">TUE</option>
                            <option value="WED">WED</option>
                            <option value="THU">THU</option>
                            <option value="FRI">FRI</option>
                            <option value="SAT">SAT</option>
                            <option value="SUN">SUN</option>
                            <option value="MON_TO_FRI">MON TO FRI</option>
                            <option value="ALL_WEEK">ALL WEEK</option>
                        </select>
                        <div id='error_limitDays'></div></td>
                </tr>
                 <tr>
          
          <td width="50%" align="left"> Code:</td>
          <td width="50%" align="left" valign="top" class="td_pad_right" ><select class="text_field_new" name="codes" id="codes"  onChange="changeIntoText(this.value);">
              <option value="">Select</option>
              <option value="GTIN13">EAN-13</option>
               <option value="CUSTOM">PINCODE</option>
            </select>
          </td>
        </tr>
        <tr>
          <td class="inner_grid" colspan="3">
            <table border="0" id="ean_table" style="display:none">
             
                <td class="inner_grid" id="ean_name" style="width:271px;">Enter EAN-13 code: </td>
                <td class="inner_grid" id="ean_text" >&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <input class="text_field_new" type="text" name="etanCode" id="etntext" value="" maxlength="13" onBlur="checkEan(this.value);" />
                  <div id='error_codes' class="error"></div></td>
            </table>
          <table border="0" id="pincode_table" style="display:none">
              
                <td class="inner_grid" id="ean_name" style="width:271px;">Enter PINCODE code: </td>
                <td class="inner_grid" id="ean_text" >&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <input class="text_field_new" type="text" name="pinCode" id="pintext" value=""  />
                  <div id='error_codes' class="error"></div></td>
            </table>
          </td>
        </tr>
       
            </table>
		  <table width="100%"> <tr>
                    <td  colspan="2" width="870" align="left"class="redwhitebutton_small" style="padding-top:5px; " onclick="showExtendedCampaign();">Enter Extended Campaign Offer</td>
                </tr>
                <tr></table>
            <table BORDER=0 style="display:inline;" cellspacing="15" width="100%" id="ExtendedCampaign">

               

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
              <a title="<?=SICON_TEXT
                               ?>" class="vtip"><b><small>?</small></b></a></br>
              <div id='error_picture' class="error"></div></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Link:</td>
            <td><input type="text" class="text_field_new" NAME="descriptive" id="descriptive" value="">
              <?=$_SESSION['post']['descriptive']
                                ?>
              </input>
              <a title="<?=SLINK_TEXT
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
                    <!--<span style=" color:#FFFFFF;">
                                        <span id="pictslogan" style=" font-size: 15px; font-weight: bold; color:#FFFFFF;">
                                            <?=$_SESSION['preview']['offer_slogan_lang_list']
                                                    ?></span>
                                        <span id="picsslogan" style=" font-size: 12px; font-weight: bold; color:#FFFFFF;">
                                            <?=$_SESSION['preview']['offer_sub_slogan_lang_list']
                                                    ?>
                                        </span> 
                                    </span>-->
                    <!-- <span style="padding-left:20px; color:#FFFFFF;"><b>Category:</b><? //echo $catName['categoryName'];    ?></span><br>-->
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
                <INPUT type="submit" value="Continue" name="continue" onClick="return checkBarCode();" id="continue" class="button">
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
    showCampaignBehavior();
    showExtendedCampaign();
</script>
<?
}
?>
<script language="JavaScript" src="client/js/jsImagePreview.js" type="text/javascript"></script>
<script>
function changeIntoText(val)
{

   if(val=='')
        {
            document.getElementById('ean_table').style.display='none';
             document.getElementById('pincode_table').style.display='none';
        }
        else
        {
            if(val=='CUSTOM')
                {
                 document.getElementById('ean_table').style.display='none';
                 document.getElementById('pincode_table').style.display='inline';
                }else if(val=='GTIN13'){
                 document.getElementById('pincode_table').style.display='none';
            document.getElementById('ean_table').style.display='inline';
                }
        }

    }


</script>
<script>

		function checkEan(eanCode) {

	// Check if only digits
	var ValidChars = "0123456789";
	for (i = 0; i < eanCode.length; i++) {
		digit = eanCode.charAt(i);
		if (ValidChars.indexOf(digit) == -1) {

			alert('Enter valid EAN-13 code.');
			//document.getElementById('barcodevalue').value='false';
			document.getElementById('etntext').value='';
			//document.getElementById('etntext').focus();
			return false;
		}
	}

	if (eanCode.length != 13) {
		alert('Enter valid EAN-13 code.');
		//document.getElementById('barcodevalue').value='false';
		document.getElementById('etntext').value='';
		//document.getElementById('etntext').focus();
		return false;
	}

	// Get the check number
	originalCheck = eanCode.substring(eanCode.length - 1);
	eanCode = eanCode.substring(0, eanCode.length - 1);

	// Add even numbers together
	even = Number(eanCode.charAt(1)) +
	       Number(eanCode.charAt(3)) +
	       Number(eanCode.charAt(5)) +
	       Number(eanCode.charAt(7)) +
	       Number(eanCode.charAt(9)) +
	       Number(eanCode.charAt(11));
	// Multiply this result by 3
	even *= 3;

	// Add odd numbers together
	odd = Number(eanCode.charAt(0)) +
	      Number(eanCode.charAt(2)) +
	      Number(eanCode.charAt(4)) +
	      Number(eanCode.charAt(6)) +
	      Number(eanCode.charAt(8)) +
	      Number(eanCode.charAt(10));

	// Add two totals together
	total = even + odd;

	// Calculate the checksum
    // Divide total by 10 and store the remainder
    checksum = total % 10;
    // If result is not 0 then take away 10
    if (checksum != 0) {
        checksum = 10 - checksum;
    }

	// Return the result
	if (checksum != originalCheck) {
		alert('Enter valid EAN-13 code.');
		//document.getElementById('barcodevalue').value='false';
		document.getElementById('etntext').value='';
		//document.getElementById('etntext').focus();
		return false;
	}

    return true;
}


function checkBarCode()
{
	var codchk = document.getElementById('codes').value;

	if(codchk!='')
	{
		if(codchk=='GTIN13')
		{
                    if(document.getElementById('etntext').value=='')
                        {
			alert('Enter EAN-13 code.');
			return false;
                        }

		}else if(codchk=='CUSTOM')
                    {
                 if(document.getElementById('pintext').value=='')
                     {
                         alert('Enter PINCODE code.');
			return false;
                     }
	}
        }
	else
	{

		return true;
	}
}

</script>