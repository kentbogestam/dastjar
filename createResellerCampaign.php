<?php
/* File Name   : campaignOffer.php
 *  Description : Add Campaign Offer Form
 *  Author      : Himanshu Singh  Date: 12th,Nov,2010  Creation
*/

header('Content-Type: text/html; charset=ISO-8859-15');
include_once("cumbari.php");
$regObj = new registration();
$inoutObj = new inOut();
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
//$offerObj->checkBudgetDetails();

if (isset($_POST['continue'])) {
    $offerObj->svrOfferDflt();
}
$menu = "offer";
$offer = 'class="selected"';
$show = 'checked="checked"';

include("mainReseller.php");

?>
<link rel="stylesheet" href="client/css/datePicker.css" type="text/css">
<!--<script type="text/javascript" src="lib/vtip/js/jquery.js"></script>
<script type="text/javascript" src="lib/vtip/js/vtip.js"></script>-->
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
.style6 {
	font-size: 9px
}
-->
</style>
<body>
<div class="center">
  <div>
    <div id="preview_frame"></div>
  </div>
  <!--<div id="registerform" align="center">
    <?
    if (($_SESSION['MESSAGE'])) {
        //echo "here";
        echo $_SESSION['MESSAGE'];
        $_SESSION['MESSAGE'] = '';
        echo "<br><a href='";
        echo $url = BASE_URL . 'getFinancial.php';
        echo "'>Load your Account</a>";
    }
    ?>
</div>-->
  <div id="main"  >
    <form  name="registerform" action="" id="registerform" method="Post" target="_self" enctype="multipart/form-data" >
      <input type="hidden" name="preview" value="1">
      <input type="hidden" name="m" value="saveNewOffer">
      <input type="hidden" name="reseller" value="reseller">
      <div id="mainbutton">
        <table width="100%" cellspacing="0" border="0">
          <tr>
            <td class="blackbutton">Add  Campaign Offer</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td class="redwhitebutton_small123"><a href="#"  >Enter Basic Campaign Information</a></td>
          </tr>
        </table>
        <!-- <form action="" method="post" name="standard_use" id="standard_use" enctype="multipart/form-data">-->
        <table  width="100%">
          <tr>
            <td width="90%" align="center"><table BORDER=0  width="100%" class="inner_grid" cellspacing="15">
                <tr>
                  <td width="531" align="left" >Language:</td>
                  <td width="447" colspan="2" align="left" ><select style="width:406px; background-color:#e4e3dd;" onChange="getLangImage(this.value);" class="text_field_new" name="lang" id="lang" >
                      <option <? if ($lang == "ENG") echo "selected='selected'"; ?> value="ENG">English</option>
                      <option <? if ($lang == "SWE") echo "selected='selected'"; ?> value="SWE">Swedish</option>
                    </select>
                    <div id='error_langStand' class="error"></div></td>
                </tr>
                <tr>
                  <td width="531" align="left" class="inner_grid"> Campaign Title. Max. 19 <br />
                    characters <span class='mandatory'>*</span>:</td>
                  <td colspan="2" align="left"><INPUT class="text_field_new" type=text name="titleSlogan" id="titleSlogan" maxlength="19" onBlur="iconPreview(this.form);limitPreview(this.form);" value="<?=$_SESSION['post']['titleSlogan']
                                                   ?>">
                    <div id='error_titleSlogan' class="error"></div></td>
                </tr>
                <tr>
                  <td align="left" class="inner_grid"> Campaign Description. Max. 50 characters<span class='mandatory'>*</span>:</td>
                  <td align="left"><INPUT class="text_field_new" type=text name="subSlogan" id="subSlogan" maxlength="50" onBlur="iconPreview(this.form);limitPreview(this.form);" value="<?=$_SESSION['post']['subSlogan']
                                                   ?>">
                    <div id='error_subSlogan' class="error"></div></td>
                  <td align="right" valign="top"><a title="<?=DESCRIPTION_TEXT
                                               ?>" class="vtip"><b><small>?</small></b></a> </td>
                </tr>
                <tr>
                  <td align="left" class="inner_grid">Category<span class='mandatory'>*</span>:</td>
                  <td colspan="2" align="left"><div id="category_lang_div">
                      <select style="width:406px; background-color:#e4e3dd;" onChange="getCatImage(this.value, this.form);" class="text_field_new" tabindex="27" id="linkedCat" name="linkedCat" value="<?=$_SESSION['post']['linkedCat']
                                                        ?>">
                        <option <? if ($data[0]['category'] == ''

                                                )echo "selected='selected'"; ?> value="">Select Category</option>
                        <? echo $offerObj->getCategoryList($_SESSION['post']['linkedCat'],$lang); ?>
                      </select>
                    </div>
                    <input type="hidden" name="category_image" id="category_image" value="">
                    <div id="category_image_div" style="display:none;"></div>
                    <div id='error_linkedCat' class="error"></div></td>
                </tr>
                <tr>
                  <td align="left" valign="top" class="inner_grid">Small icon <font size="2">(Icon must be in png format only e.g. icon.png.The size must be at least 45 x 60 pixels)</font></td>
                  <td align="left"><?php if ($_SESSION['preview']['small_image']) {
                                        ?>
                    <!--  <img src="upload/category/<?=$_SESSION['preview']['small_image'] ?>">-->
                    <input class="text_field_new" type="hidden" name="smallimage" id="smallimage" value="<?=$_SESSION['preview']['small_image'] ?>">
                    <?
                                    }
                                    ?>
                    <INPUT class="text_field_new" type="file" name="icon" id="icon" onBlur="iconPreview(this.form);">
                    <div id='error_icon' class="error"></div>
                    <div>
                      <input type="hidden" id="selected_image" name="selected_image" value="0">
                    </div></td>
                  <td align="right" valign="top"><a title="<?=ICON_TEXT
                                               ?>" class="vtip"><b><small>?</small></b></a> </td>
                </tr>
                <tr>
                  <td colspan="5" align="center" height="20">&nbsp;</td>
                </tr>
                <tr style="display:none;">
                  <td colspan="5" align="center" height="20"><strong>
                    <button onClick="ajaxUpload(this.form,'classes/ajx/ajxUpload.php?filename=icon&amp;maxW=200','upload_area'); return false;">Click here</button>
                    to check how your short campaign proposal looks like</strong></td>
                </tr>
              </table></td>
          </tr>
        </table>
        <!-- </form>-->
        <table  border="0" align="center" cellpadding="0" cellspacing="0">
          <tr id="short_preview" style="display:inline;">
            <td width="422" align="center" valign="top" style="background-image:url(client/images/iphone_large-2.png); width:270px; height:559px; background-repeat:no-repeat;"><div style="margin-top:150px; width:225px; margin-left:auto; margin-right:auto;" >
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="41"  align="left" style="padding-left:5px; padding-right:5px;"><div id="upload_area" style="vertical-align:top;"><img src="" id="myCatIcon" name="myCatIcon"></div></td>
                    <td width="79%" rowspan="2" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td colspan="2"><div class="mob_title_2" id="tslogan"></div><div style="float:right"><font size="-3">??km</font></div></td>
                        </tr>
                        <tr>
                          <td colspan="2" valign="top" id="sslogan" class="mob_txt"></td>
                        </tr>
                      </table></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                </table>
              </div></td>
          </tr>
        </table>
        <table width="100%" border="0">
          <tr>
            <td align="left"><div class="redwhitebutton_small123" onClick="showCampaignBehavior();">Enter Campaign Behaviour</div></td>
          </tr>
          <tr>
            <td colspan="0"><table width="100%" border="0" cellspacing="10"   style="display:inline;" id="CampaignBehavior">
                <tr>
                  <td width="515" class="inner_grid">Sponsored
                    Campaign<span class='mandatory'>*</span>: </td>
                  <td width="229"><select style="width:406px; background-color:#e4e3dd;" class="text_field_new" id="sponsor" name="sponsor">
                      <option <? if ($_SESSION['post']['sponsor'] == '0'

                                            )echo "selected='selected'"; ?> value="0">No</option>
                      <option <? if ($_SESSION['post']['sponsor'] == '1'

                                            )echo "selected='selected'"; ?> value="1">Yes</option>
                  </select>
                  <span style="font-size:12px;"> (Price per view 0.01 kr)</span>
                  <div id='error_sponsor' class="error"></div></td>
                <td align="right" valign="top"><a title="<?=SPONSOR_TEXT ?>" class="vtip"><b><small>?</small></b></a></td>
              </tr>
              <tr>
                <td class="inner_grid">Start date of Campaign<span class='mandatory'>*</span>:</td>
                <td><input style="width: 380px;" type="text" name="startDate" readonly="readonly" value="<?=$_SESSION['post']['startDate'] ?>" id="startDate" class="startDate text_field_new" />
                  <div id='error_startDate' class="error"></div></td>
                <td align="right" valign="top"><a title="<?=START_TEXT ?>" class="vtip"><b><small>?</small></b></a> </td>
              </tr>
              <tr>
                <td class="inner_grid">End date of Campaign<span class='mandatory'>*</span>:</td>
                <td><input style="width: 380px;" type="text" name="endDate" readonly="readonly" value="<?=$_SESSION['post']['endDate'] ?>" id="endDate" class="endDate dp-applied text_field_new" />
                  <div id='error_endDate' class="error"></div></td>
                <td align="right" valign="top"><a title="<?=END_TEXT ?>" class="vtip"><b><small>?</small></b></a> </td>
              </tr>
              <tr>
                <td class="inner_grid">Campaign Name.Not displayed to end user.Only for internal use.<span class='mandatory'>*</span>:</td>
                <td><input class="text_field_new" type="text" name="campaignName" value="<?=$_SESSION['post']['campaignName'] ?>" id="campaignName" />
                  <div id='error_campaignName' class="error"></div></td>
                <td align="right" valign="top"><a title="<?=CAMPAIGNNAME_TEXT ?>" class="vtip"><b><small>?</small></b></a> </td>
              </tr>
              <tr>
                <td class="inner_grid">Keyword:</td>
                <td><input class="text_field_new" type="text" name="searchKeyword" maxlength="90" value="<?=$_SESSION['post']['searchKeyword'] ?>" id="searchKeyword" />
                  <div id='error_searchKeyword' class="error" ></div></td>
                <td align="right" valign="top"><a title="<?=KEYWORD_TEXT ?>" class="vtip"><b><small>?</small></b></a> </td>
              </tr>
              <tr>
                <td class="inner_grid">Deal is only valid from start time during a day:</td>
                <td colspan="2"><select style="width:406px; background-color:#e4e3dd;" class="text_field_new" name="startDateLimitation" id="startDateLimitation" onBlur="limitPreview(this.form);" value="<?=$_SESSION['post']['startDateLimitation'] ?>">
                    <option <? if ($_SESSION['post']['startDateLimitation'] == ''

                                            )echo "selected='selected'"; ?> value="">Select Start Time</option>
                      <option <? if ($_SESSION['post']['startDateLimitation'] == '00'

                                            )echo "selected='selected'"; ?> value="00">00</option>
                      <option <? if ($_SESSION['post']['startDateLimitation'] == '01'

                                            )echo "selected='selected'"; ?> value="01">01</option>
                      <option <? if ($_SESSION['post']['startDateLimitation'] == '02'

                                            )echo "selected='selected'"; ?> value="02">02</option>
                      <option <? if ($_SESSION['post']['startDateLimitation'] == '03'

                                            )echo "selected='selected'"; ?> value="03">03</option>
                      <option <? if ($_SESSION['post']['startDateLimitation'] == '04'

                                            )echo "selected='selected'"; ?> value="04">04</option>
                      <option <? if ($_SESSION['post']['startDateLimitation'] == '05'

                                            )echo "selected='selected'"; ?> value="05">05</option>
                      <option <? if ($_SESSION['post']['startDateLimitation'] == '06'

                                            )echo "selected='selected'"; ?> value="06">06</option>
                      <option <? if ($_SESSION['post']['startDateLimitation'] == '07'

                                            )echo "selected='selected'"; ?> value="07">07</option>
                      <option <? if ($_SESSION['post']['startDateLimitation'] == '08'

                                            )echo "selected='selected'"; ?> value="08">08</option>
                      <option <? if ($_SESSION['post']['startDateLimitation'] == '09'

                                            )echo "selected='selected'"; ?> value="09">09</option>
                      <option <? if ($_SESSION['post']['startDateLimitation'] == '10'

                                            )echo "selected='selected'"; ?> value="10">10</option>
                      <option <? if ($_SESSION['post']['startDateLimitation'] == '11'

                                            )echo "selected='selected'"; ?> value="11">11</option>
                      <option <? if ($_SESSION['post']['startDateLimitation'] == '12'

                                            )echo "selected='selected'"; ?> value="12">12</option>
                      <option <? if ($_SESSION['post']['startDateLimitation'] == '13'

                                            )echo "selected='selected'"; ?> value="13">13</option>
                      <option <? if ($_SESSION['post']['startDateLimitation'] == '14'

                                            )echo "selected='selected'"; ?> value="14">14</option>
                      <option <? if ($_SESSION['post']['startDateLimitation'] == '15'

                                            )echo "selected='selected'"; ?> value="15">15</option>
                      <option <? if ($_SESSION['post']['startDateLimitation'] == '16'

                                            )echo "selected='selected'"; ?> value="16">16</option>
                      <option <? if ($_SESSION['post']['startDateLimitation'] == '17'

                                            )echo "selected='selected'"; ?> value="17">17</option>
                      <option <? if ($_SESSION['post']['startDateLimitation'] == '18'

                                            )echo "selected='selected'"; ?> value="18">18</option>
                      <option <? if ($_SESSION['post']['startDateLimitation'] == '19'

                                            )echo "selected='selected'"; ?> value="19">19</option>
                      <option <? if ($_SESSION['post']['startDateLimitation'] == '20'

                                            )echo "selected='selected'"; ?> value="20">20</option>
                      <option <? if ($_SESSION['post']['startDateLimitation'] == '21'

                                            )echo "selected='selected'"; ?> value="21">21</option>
                      <option <? if ($_SESSION['post']['startDateLimitation'] == '22'

                                            )echo "selected='selected'"; ?> value="22">22</option>
                      <option <? if ($_SESSION['post']['startDateLimitation'] == '23'

                                            )echo "selected='selected'"; ?>   value="23">23</option>
                    </select>
                    <div id='error_startDateLimitation'></div></td>
                </tr>
                <tr>
                  <td class="inner_grid">Deal is only valid to an end time during a day:</td>
                  <td colspan="2"><!--<INPUT type=text name="endDateLimitation" id="endDateLimitation">-->
                    <select style="width:406px; background-color:#e4e3dd;" class="text_field_new" name="endDateLimitation" id="endDateLimitation" onBlur="limitPreview(this.form);" value="<?=$_SESSION['post']['endDateLimitation'] ?>">
                      <option <? if ($_SESSION['post']['endDateLimitation'] == ''

                                            )echo "selected='selected'"; ?> value="">Select End Time</option>
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
                  <td class="inner_grid">Deal is only valid to a limited set of days during the week:</td>
                  <td colspan="2"><!--<INPUT type=text name="limitDays" id="limitDays">-->
                    <select style="width:406px; background-color:#e4e3dd;" class="text_field_new" name="limitDays" id="limitDays" onBlur="limitPreview(this.form);">
                      <option <? if ($_SESSION['post']['valid_day'] == ''

                                            )echo "selected='selected'"; ?> value="">Select Limit Days</option>
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
                  <td  class="inner_grid"> Code:</td>
                  <td valign="top" ><select class="text_field_new" name="codes" id="codes"  onChange="changeIntoText(this.value);">
                      <option value="">Select</option>
                      <option value="GTIN13">EAN-13</option>
                      <option value="CUSTOM">PINCODE</option>
                    </select>
                  </td>
                  <td align="right" valign="top" >&nbsp;</td>
                </tr>
                <tr  > <td colspan="2">
                  <table width="100%" border="0" align="left" id="ean_table" style="display:none">

                          <td  align="left" class="inner_grid" id="ean_name" style="width:440px;" >Enter EAN-13 code: </td>
                        <td  class="inner_grid" id="ean_text" ><input class="text_field_new" type="text" name="etanCode" id="etntext" value="" maxlength="13" onBlur="checkEan(this.value);">
                          <div id='error_codes' class="error"></div></td>

                        </table>
                  <table width="100%" border="0" align="left" id="pincode_table" style="display:none">

                        <td align="left" class="inner_grid" id="ean_name" style="width:440px;" >Enter PINCODE code: </td>
                        <td  class="inner_grid" id="ean_text" ><input class="text_field_new" type="text" name="pinCode" id="pintext" value="" >
                          <div id='error_codes' class="error"></div></td>
                    </table>
                  
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="3">&nbsp;</td>
              </tr>
            </table>
        </tr>
      </table>
      <table width="100%">
        <tr>
          <td align="center"><div class="redwhitebutton_small123" onClick="showExtendedCampaign();">Enter Extended Campaign Offer</div></td>
        </tr>
      </table>
      <table width="100%" BORDER=0 cellspacing="15"  style="display:inline;" id="ExtendedCampaign">
        <tr>
          <td width="515" valign="top" class="inner_grid">Large deal icon <font size="2">(Image must be in jpeg or png format only e.g. image.png or image.jpg.The size must be at least 247 x 130 pixels)</font><span class='mandatory'>*</span></td>
          <td width="227"><?php if ($_SESSION['preview']['large_image']) {
                            ?>
              <img src="upload/coupon/<?=$_SESSION['preview']['large_image'] ?>">
              <input class="text_field_new" type="hidden" name="largeimage" id="largeimage" value="<?=$_SESSION['preview']['large_image'] ?>">
              <br>
              Or&nbsp;
              <?
                        }
                        ?>
              <INPUT class="text_field_new" type="file" name="picture" id="picture">
              <div id='error_picture' class="error"></div></td>
            <td align="right"><a title="<?=SICON_TEXT
                                   ?>" class="vtip"><b><small>?</small></b></a> </td>
          </tr>
          <tr>
            <td  class="inner_grid"> Link:</td>
            <td valign="top" ><TEXTAREA class="text_field_new" NAME="descriptive" id="descriptive" COLS=30 ROWS=4><?=$_SESSION['post']['descriptive']
                                    ?>
</TEXTAREA>
              <div id='error_descriptive' class="error"></div></td>
            <td align="right" valign="top" ><a title="<?=SLINK_TEXT
                                   ?>" class="vtip"><b><small>?</small></b></a></td>
          </tr>
        </table>
        <table width="100%" border="0">
          <tr>
            <td height="617">&nbsp;</td>
            <td align="center"><table width="200" height="543" border="0" align="center" cellpadding="0" cellspacing="0" style="background-image:url(client/images/iphone_large.png); width:270px; height:529px; background-repeat:no-repeat;">
                <tr>
                  <td width="4" height="143">&nbsp;</td>
                  <td colspan="3">&nbsp;</td>
                  <td width="5">&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td width="21"  >&nbsp;</td>
                  <td valign="top" align="center" style=" text-align:center;"   width="230" height="112"><div id="pic_upload" style="width:220px; height:112px;  "><img id="picImg"  width="220" height="112" /></div></td>
                  <td width="10" ></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td >&nbsp;</td>
                  <td  >&nbsp;</td>
                  <td valign="top"><div class="ttslogen" id="ttSlogen"></div></td>
                  <td ></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td >&nbsp;</td>
                 <td valign="top"><div class="ssslogen" id="ssSlogen"></div></td>
                  <td ></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td height="53" >&nbsp;</td>
                  <td style="text-align:left; vertical-align: bottom;"><table width="104%" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="41%" align="left" valign="top" style=" padding-left:4px; color:#FFFFFF; font-size:10px;"><strong>Store Name</strong>
                          <? //=$_SESSION['preview']['product_number']?>
                          <br>
                          <strong>Street</strong><br>
                          <br></td>
                        <td width="8%" height="20" align="left" style=" color:#FFFFFF; font-size:10px;">&nbsp;</td>
                        <td width="51%" height="20" align="left" valign="top" style=" color:#FFFFFF; font-size:10px;" id="limitPreview"></td>
                      </tr>
                    </table></td>
                  <td ></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td height="196">&nbsp;</td>
                  <td colspan="3">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
              </table></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><div align="center">
                <INPUT type="submit" value="Continue" name="continue" onClick="return checkBarCode();" id="continue" class="button">
                <br />
                <br />
              </div></td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <!--<table border="0" width="100%">
<tr>
<td width="24%">&nbsp;</td>
<td width="77%" align="left" class="redgraybutton">4.Activate</td>
<td width="5%">&nbsp;</td>
</tr>
<tr>
<td width="18%">&nbsp;</td>
<td width="77%">&nbsp;</td>
<td width="5%">&nbsp;</td>

</tr>

</table>-->
      </div>
      <span class='mandatory'>* These Fields Are Mandatory</span>
    </form>
  </div>
</div>
<? include("footer.php"); ?>
</body>
</html>
<? if ($_SESSION['preview']) { ?>
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
<script language="JavaScript" src="client/js/jsImagePreview.js" type="text/javascript"></script>
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
{ var codchk = document.getElementById('codes').value;

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