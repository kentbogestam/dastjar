<?php
/*
*   File Name   : createAdvertise.php
*   Description : Create Advertise offer
*   Author      : Sudhanshu Sharma
*   Date        : 1/13/2013  Creation
*/

header('Content-Type: text/html; charset=utf-8');
include_once("cumbari.php");

$regObj = new registration();
$inoutObj = new inOut();
$offerObj = new offer();
$compcont = $offerObj->companycountry();
if ($compcont == 'Sweden') {
    $lang = 'SWE';
}
elseif ($compcont == 'Germany') {
    $lang = 'GER';
}
else {
    $lang = 'ENG';
}

if (isset($_POST['continue'])) {
    
   // print_R($_POST);die();
    
    $offerObj->svrOfferDflt();
}

$menu = "offer";
$offer = 'class="selected"';
$showadvertise = 'checked="checked"';

include("main.php");

?>
<link rel="stylesheet" href="client/css/datePicker.css" type="text/css">
<script language="JavaScript" src="client/js/jquery.js" type="text/javascript"></script>
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
-->
</style>
<body>
<div class="center">
  <div>
    <div id="preview_frame"></div>
  </div>
  <div id="registerform" align="center">
    <?
    if (($_SESSION['MESSAGE'])) {
        echo $_SESSION['MESSAGE'];
        $_SESSION['MESSAGE'] = '';
            }
     if (($_SESSION['MESSAGE2'])) {
         echo "<br><a href='";
        echo $url = BASE_URL . 'getFinancial.php';
        echo "'>Load your Account</a>";
        $_SESSION['MESSAGE2'] = '';
    }
    ?>
  </div>
  <div id="main"  >
    <form  name="registerform" action="" id="registerform" method="Post" target="_self" enctype="multipart/form-data">
      <input type="hidden" name="preview" value="1">
      <input type="hidden" name="m" value="saveNewAdvertise">
      <div id="mainbutton">
        <table width="100%" cellspacing="0" border="0">
          <tr>
            <td width="3%" class="blackbutton">Add Advertise Offer</td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td class="redwhitebutton_small"><a href="#"  >Enter Basic Advertise Information</a></td>
                </tr>
              </table></td>
          </tr>
        </table>
        <table  width="100%">
          <tr>
            <td width="90%" align="center"><table BORDER=0  width="100%" class="inner_grid" cellspacing="15">
                <tr>
                  <td width="531" align="left" >Language:</td>
                  <td width="216" align="left" ><select style="width:406px; background-color:#e4e3dd; border:#abadb3 1px solid" onChange="getLangImage(this.value);" class="text_field_new" name="lang" id="lang" >
                      <option <? if ($lang == "GER") echo "selected='selected'"; ?> value="GER">German</option>
                      <option <? if ($lang == "ENG") echo "selected='selected'"; ?> value="ENG">English</option>
                      <option <? if ($lang == "SWE") echo "selected='selected'"; ?> value="SWE">Swedish</option>
                    </select>
                    <div id='error_langStand' class="error"></div></td>
                  <td align="right"><a title="<?=CLANGUAGE_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
                </tr>
                <tr>
                  <td width="531" align="left" class="inner_grid"> Advertise Title. Max. 19
                    characters <span class='mandatory'>*</span>:</td>
                  <td align="left"><INPUT class="text_field_new" type=text name="titleSlogan" id="titleSlogan" maxlength="19" onBlur="iconPreview(this.form);limitPreview(this.form);" value="<?=$_SESSION['post']['titleSlogan']
                                                   ?>">
                    <div id='error_titleSlogan' class="error"></div></td>
                   <td align="right"><a title="<?=ATITEL_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
                </tr>
                <tr>
                  <td align="left" class="inner_grid"> Advertise Description. Max. 50 characters<span class='mandatory'>*</span>:</td>
                  <td align="left"><INPUT class="text_field_new" type=text name="subSlogan" id="subSlogan" maxlength="50" onBlur="iconPreview(this.form);limitPreview(this.form);" value="<?=$_SESSION['post']['subSlogan']
                                                   ?>">
                    <div id='error_subSlogan' class="error" style="display:none"></div></td>
                  <td align="right"><a title="<?=ADESCRIPTION_TEXT
                                               ?>" class="vtip"><b><small>?</small></b></a> </td>
                </tr>
                <tr>
                  <td align="left" class="inner_grid">Category<span class='mandatory'>*</span>:</td>
                  <td align="left"><div id="category_lang_div">
                      <select style="width:406px; background-color:#e4e3dd; border:#abadb3 1px solid" onChange="getCatImage(this.value, this.form);" class="text_field_new" tabindex="27" id="linkedCat" name="linkedCat" value="<?=$_SESSION['post']['linkedCat']
                                                        ?>">
                        <option <? if ($data[0]['category'] == ''

                                                )echo "selected='selected'"; ?> value="">Select Category</option>
                        <? echo $offerObj->getCategoryList($_SESSION['post']['linkedCat'],$lang); ?>
                      </select>
                    </div>
                    <input type="hidden" name="category_image" id="category_image" value="">
                    <div id="category_image_div" style="display:none;"></div>
                    <div id='error_linkedCat' class="error"></div></td>
                 <td align="right"><a title="<?=CCATEGORY_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
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
                    <div id='error_icon' class="error" style="display:none"></div>
                    <div>
                      <input type="hidden" id="selected_image" name="selected_image" value="0">
                    </div></td>
                  <td align="right"><a title="<?=ICON_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
                </tr>
                <tr></tr>
                <tr style="display:none;">
                  <td colspan="5" align="center" height="20"><strong>
                    <button onClick="ajaxUpload(this.form,'classes/ajx/ajxUpload.php?filename=icon&amp;maxW=200','upload_area'); return false;">Click here</button>
                    to check how your short advertise proposal looks like</strong></td>
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
                    <td rowspan="2" valign="top"><table width="98%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td width="60" class="mob_title" id="tslogan"></td>
                          <td width="21" align="right" nowrap style="padding-right:3px;"><div style="float:right"><font size="-3">??km</font></div></td>
                        </tr>
                        <tr>
                          <td colspan="2" valign="top"><div class="mob_txt" id="sslogan"></div></td>
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
        <br>
        <table width="100%" border="0">
          <tr>
            <td align="left"><div class="redwhitebutton_small123" onClick="showAdvertiseBehavior();">Enter Advertise Behaviour</div></td>
          </tr>
          <tr>
            <td colspan="0"><table width="100%" border="0" cellspacing="10"   style="display:inline;" id="AdvertiseBehavior">
                <tr>
                  <td width="515" class="inner_grid">Sponsored
                    Advertise<span class='mandatory'>*</span>: </td>
                  <td width="229"><select style="width:406px; background-color:#e4e3dd; border:#abadb3 1px solid" class="text_field_new" id="sponsor" name="sponsor">
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
                  <td class="inner_grid">Start date of Advertise<span class='mandatory'>*</span>:</td>
                  <td><input style="width: 380px;" type="text" name="startDate" readonly="readonly" value="<?=$_SESSION['post']['startDate'] ?>" id="startDate" class="startDate text_field_new" />
                    <div id='error_startDate' class="error" style="display:none"></div></td>
                  <td align="right"><a title="<?=ASTART_TEXT ?>" class="vtip"><b><small>?</small></b></a> </td>
                </tr>
                <tr>
                  <td class="inner_grid">End date of Advertise<span class='mandatory'>*</span>:</td>
                  <td><input style="width: 380px;" type="text" name="endDate" readonly="readonly" value="<?=$_SESSION['post']['endDate'] ?>" id="endDate" class="endDate dp-applied text_field_new" />
                    <div id='error_endDate' class="error" style="display:none"></div></td>
                  <td align="right"><a title="<?=AEND_TEXT ?>" class="vtip"><b><small>?</small></b></a> </td>
                </tr>
                <tr>
                  <td class="inner_grid">Advertise Name.Not displayed to end user.Only for internal use.<span class='mandatory'>*</span>:</td>
                  <td><input class="text_field_new" type="text" name="advertiseName" value="<?=$_SESSION['post']['advertiseName'] ?>" id="advertiseName" />
                    <div id='error_advertiseName' class="error" style="display:none"></div></td>
                  <td align="right"><a title="<?=ADVERTISENAME_TEXT ?>" class="vtip"><b><small>?</small></b></a> </td>
                </tr>
                <tr>
                  <td class="inner_grid">Keyword<span class='mandatory'>*</span>:</td>
                  <td><input class="text_field_new" type="text" name="searchKeyword" maxlength="90" value="<?=$_SESSION['post']['searchKeyword'] ?>" id="searchKeyword" />
                    <div id='error_searchKeyword' class="error"  style="display:none" ></div></td>
                  <td align="right"><a title="<?=AKEYWORD_TEXT ?>" class="vtip"><b><small>?</small></b></a> </td>
                </tr>                          
<!-- New View Option Kent  --> 
                <tr>
                  <td width="515" class="inner_grid">Select View Option 
                  <td width="229"><select style="width:406px; background-color:#e4e3dd; border:#abadb3 1px solid" class="text_field_new" id="viewopt" name="viewopt">
                      <option <? if ($_SESSION['post']['viewopt'] == 'ST' )echo "selected='selected'"; ?> value="ST">Standard</option>
                      <option <? if ($_SESSION['post']['viewopt'] == 'CD' )echo "selected='selected'"; ?> value="CD">Count down</option>
                      <option <? if ($_SESSION['post']['viewopt'] == 'SC' )echo "selected='selected'"; ?> value="SC">Scratch Cards</option>
                    </select>
                    <div id='error_viewopt' class="error"></div></td>
                  <td align="right" valign="top"><a title="<?=VIEWOPT_TEXT ?>" class="vtip"><b><small>?</small></b></a></td>
                </tr>
<!-- End new function -->
              
              </table>
          </tr>
        </table>
        <table width="100%">
          <tr>
            <td><div class="redwhitebutton_small123" onClick="showExtendedAdvertise();">Enter Extended Advertise Offer</div></td>
          </tr>
        </table>
        <table width="100%" BORDER=0 cellspacing="10"  style="display:inline;" id="ExtendedAdvertise">
          <tr>
            <td width="515" valign="top" class="inner_grid">Large deal icon <font size="2">(Image must be in jpeg or png format only e.g. image.png or image.jpg.The size must be at least 247 x 130 pixels)</font><span class='mandatory'>*</span></td>
            <td><?php if ($_SESSION['preview']['large_image']) {
                            ?>
              <img style="display:none;" src="upload/coupon/<?=$_SESSION['preview']['large_image'] ?>">
              <input class="text_field_new" type="hidden" name="largeimage" id="largeimage" value="<?=$_SESSION['preview']['large_image'] ?>">
              <br>
              <?
                        }
                        ?>
              <INPUT class="text_field_new" type="file" name="picture" id="picture">
              <div id='error_picture' class="error" style="display:none"></div></td>
            <td align="right"><a title="<?=CPICTURE_TEXT?>" class="vtip"><b><small>?</small></b></a> </td>
          </tr>
          <tr>
            <td width="515"  class="inner_grid"> Link:</td>
            <td valign="middle" ><TEXTAREA class="text_field_new" NAME="descriptive" id="descriptive" COLS=30 ROWS=4><?=$_SESSION['post']['~']
                                    ?>
</TEXTAREA>
              <div id='error_descriptive' class="error" style="display:none"></div></td>
            <td align="right" ><a title="<?=ALINK_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
          </tr>
        </table>
        <table width="100%" border="0">
          <tr>
            <td height="573">&nbsp;</td>
            <td align="center" valign="top"><table width="200" height="543" border="0" align="center" cellpadding="0" cellspacing="0" style="background-image:url(client/images/iphone_large.png); width:270px; height:559px; background-repeat:no-repeat;">
                <tr>
                  <td width="4" height="143">&nbsp;</td>
                  <td colspan="3">&nbsp;</td>
                  <td width="5">&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td width="21"  >&nbsp;</td>
                  <td valign="top" align="center" style=" text-align:center;" height="112"><div id="pic_upload" style="padding-right:8px;"><img id="picImg"  width="220" height="112" /></div></td>
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
                  <td height="73" >&nbsp;</td>
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
                  <td height="176">&nbsp;</td>
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
                <br />
                <br />
              </div></td>
            <td>&nbsp;</td>
          </tr>
        </table>       
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
    showAdvertiseBehavior();
    showExtendedAdvertise();
</script>
<?
}
?>

<script language="JavaScript" src="client/js/jsImagePreview.js" type="text/javascript"></script>

