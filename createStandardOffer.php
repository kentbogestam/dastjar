<?php
/*  File Name  : standardOffer.php
 *  Description : Standard Offer Form
 *  Author      : Himanshu Singh  Date: 25th,Nov,2010  Creation
*/
header('Content-Type: text/html; charset=ISO-8859-15');
include_once("cumbari.php");
//echo $_SESSION['userid'];
$standardObj = new offer();
$compcont = $standardObj->companycountry();
if ($compcont == 'Sweden') {
    $lang = 'SWE';
    //echo $lang;die;
}
else {
    $lang = 'ENG';
}
//$standardObj->checkBudgetDetails();

if (isset($_POST['continue'])) {
    $standardObj->saveNewStandardOffersDetails();
}
$menu = "offer";
$offer = 'class="selected"';
$showstandard = 'checked="checked"';
include_once("main.php");
if (isset($_GET['reedit'])) {
    $lang = $_SESSION['post']['lang'];
}
?>
<?php include 'config/defines.php'; ?>
<link rel="stylesheet" href="client/css/stylesheet123.css" type="text/css">
<link rel="stylesheet" href="client/css/datePicker.css" type="text/css">
<script language="JavaScript" src="client/js/date.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/jquery.bgiframe.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/jquery.datePicker.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/ajaxuploadStand.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/jsStandardOffer.js" type="text/javascript"></script>
<!--<link rel="stylesheet" type="text/css" href="lib/vtip/css/vtip.css" />-->
<style type="text/css">
body {
}
a {
}
img {
	border: 0
}
.center {
	width:900px;
	margin-left:auto;
	margin-right:auto;
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
  <form name="register" action="" id="registerform" method="Post" enctype="multipart/form-data">
    <input type="hidden" name="preview" value="1">
    <input type="hidden" name="m" value="saveNewStandard">
    <div>
      <div id="preview_frame"></div>
    </div>
    <div id="msg" align="center">
      <?php
        if ($_SESSION['MESSAGE']) {
            echo $_SESSION['MESSAGE'];
            $_SESSION['MESSAGE'] = "";
        }
        ?>
    </div>
    <div id="main">
      <div id="mainbutton">
        <table width="100%" cellspacing="0" border="0">
          <tr>
            <td align="center" class="blackbutton">Add  Standard Offer</td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td height="53" align="center"  class="redwhitebutton_small" style="padding-top:5px; text-align:center ">Add Standard Offer</td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td height="53"><table width="100%" BORDER=0 cellpadding="0"  cellspacing="15">
                <tr>
                  <td width="515" align="left" valign="top" class="inner_grid">Language:</td>
                  <td width="469" colspan="2" align="left" valign="top"><select style="width:406px; background-color:#e4e3dd;" onChange="getLangImage(this.value);" class="text_field_new" name="lang" id="lang" >
                      <option <? if ($lang == "ENG"
                                            )echo "selected='selected'"; ?> value="ENG">English</option>
                      <option <? if ($lang == "SWE"
                                            )echo "selected='selected'"; ?> value="SWE">Swedish</option>
                    </select>
                    <div id='error_langStand' class="error"></div></td>
                </tr>
                <tr>
                  <td align="left" valign="top"  class="inner_grid">Product Name<span class='mandatory'>*</span>:<br>
                  </td>
                  <td align="left" valign="top" ><INPUT class="text_field_new" type=text name="titleSloganStand" id="titleSloganStand" maxlength="19" onBlur="iconPreview(this.form); getTitleForProduct(this.form);standardPreview(this.form);" value="<?=$_SESSION['post']['titleSloganStand']
                                                   ?>">
                    <div id='error_titleSloganStand' class="error" style="display:none"></div></td>
                  <td align="right" valign="middle" ><a title="<?=STITLE_TEXT
                                               ?>" class="vtip"><b><small>?</small></b></a> </td>
                </tr>
                <tr style="display:none;"> </tr>
                <tr style="display:none;">
                  <td align="left" valign="top" class="inner_grid">Price(with currency):</td>
                  <td align="left" valign="top"><INPUT class="text_field_new" type=text name="price" id="price"></td>
                  <td align="right" valign="middle"><a title="<?=PRICE_TEXT
                                               ?>" class="vtip"><b><small>?</small></b></a> </td>
                </tr>
                <tr>
                  <td align="left" valign="top" class="inner_grid">Category<span class='mandatory'>*</span>:</td>
                  <td colspan="2" align="left" valign="top"><div id="category_lang_div">
                      <select  class="text_field_new" onChange="getCatImage(this.value, this.form);" style="width:406px; background-color:#e4e3dd;" tabindex="27" id="linkedCatStand" name="linkedCatStand" value="<?=$_SESSION['post']['linkedCat']
                                                         ?>">
                        <option <? if ($data[0]['category'] == ''

                                                )echo "selected='selected'"; ?> value="">Select Category</option>
                        <? echo $standardObj->getCategoryList($_SESSION['post']['linkedCatStand'],$lang) ?>
                      </select>
                    </div>
                    <input type="hidden" name="category_image" id="category_image" value="">
                    <div id="category_image_div" style="display:none;"></div>
                    <div id='error_linkedCatStand' class="error"></div></td>
                </tr>
                <!-- <form action="" method="post" name="standard_use" id="standard_use" enctype="multipart/form-data">-->
                <tr>
                  <td align="left" valign="top" class="inner_grid" style="line-height:25px;">Small icon <font size="2">(Icon must be in png format only e.g. icon.png.The size must be at least 45 x 60 pixels)</font></td>
                  <td align="left" valign="top"><div id="pre_image">
                      <?php if ($_SESSION['preview']['small_image']) {
                                            ?>
                      <!-- <img src="upload/category/<?=$_SESSION['preview']['small_image'] ?>">-->
                      <input class="text_field_new" type="hidden" name="smallimage" id="smallimage" value="<?=$_SESSION['preview']['small_image'] ?>">
                      <br>
                      <?
                                        }
                                        ?>
                    </div>
                    <INPUT class="text_field_new" type=file name="icon" id="icon" onBlur="iconPreview(this.form);" >
                    <div id='error_icon' class="error"></div>
                    <div>
                      <input class="text_field_new" type="hidden" id="selected_image" name="selected_image" value="0">
                    </div></td>
                  <td align="right" valign="top"><a title="<?=ICON_TEXT
                                               ?>" class="vtip"><b><small>?</small></b></a> </td>
                </tr>
                <tr style="display:none;">
                  <td colspan="5" align="center" height="20"><strong>
                    <button onClick="ajaxUpload(this.form,'classes/ajx/ajxUpload.php?filename=icon&amp;maxW=200','upload_area'); return false;">Click here</button>
                    to check how your short standard offer proposal looks like</strong></td>
                </tr>
                <!-- </form>-->
              </table>
              <table  border="0" align="center" cellpadding="0" cellspacing="0">
                <tr id="short_preview" style="display:inline;">
                  <td width="422" align="center" valign="top" style="background-image:url(client/images/iphone_large-2.png); width:270px; height:559px; background-repeat:no-repeat;"><div style="margin-top:150px; width:225px; margin-left:auto; margin-right:auto;" >
                      <table border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td width="41"  align="left" style="padding-left:5px; padding-right:5px;"><div id="upload_area" style="vertical-align:top;"><img src="" id="myCatIcon" name="myCatIcon"></div></td>
                          <td rowspan="2" valign="top"><table width="98%" border="0" cellpadding="0" cellspacing="0">
                              <tr>
                                <td class="mob_title_2" id="tslogan"></td>
                                <td width="21" align="right" nowrap style="padding-right:3px;"><div><font size="-3">??km</font></div></td>
                              </tr>
                              <!--<tr>
                                <td valign="top" colspan="2" class="mob_txt" id="sslogan"></td>
                              </tr>-->
                            </table></td>
                        </tr>
                       
                      </table>
                    </div></td>
                </tr>
              </table>
              <br>
              <div class="redwhitebutton_small123">Describe how your Standard Offer should Behave</div>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="50%" valign="top" class="td_pad_left">Sponsored Standard Offer<span class='mandatory'>*</span>:</td>
                  <td width="50%" class="td_pad_right"><select style="width:406px; background-color:#e4e3dd; border:#abadb3 solid 1px;" class="text_field_new"  tabindex="27" id="sponsStand"
                                                        name="sponsStand">
                      <option <? if ($_SESSION['post']['sponsStand'] == '0'

                                            )echo "selected='selected'"; ?> value="0">No</option>
                      <option <? if ($_SESSION['post']['sponsStand'] == '1'

                                            )echo "selected='selected'"; ?> value="1">Yes</option>
                    </select>
                    <br>
                    <span style="font-size:12px;"> (Price per view 0.01 kr)</span>
                    <div id='error_sponsStand' class="error"></div></td>
                </tr>
              </table>
              <div class="redwhitebutton_small123"><span style="cursor:pointer;" onClick="showAdvancedSearchStand();">Advanced Options-Optional</span></div>
              <table border="0" width="100%">
              </table>
              <table width="100%" BORDER=0 cellpadding="0" cellspacing="0"  >
                <tr>
                  <td width="50%" align="left" valign="top" class="td_pad_left">Keyword:</td>
                  <td width="50%" align="left" valign="top" class="td_pad_right"><table border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td><INPUT class="text_field_new" type=text name="searchKeywordStand" id="searchKeywordStand" maxlength="90"></td>
                        <td style="padding-left:10px;"><a title="<?=SKEYWORD_TEXT
                                               ?>" class="vtip"><b><small>?</small></b></a>
                          <div id='error_searchKeywordStand' class="error" style="display:none"></div></td>
                      </tr>
                    </table></td>
                </tr>
                <tr>
                  <td width="50%" align="left" valign="top" class="td_pad_left">EAN Code:</td>
                  <td width="50%" align="left" valign="top" class="td_pad_right"><INPUT class="text_field_new" type=text name="eanCode" id="eanCode" value="<?=$_SESSION['post']['eanCode']
                               ?>">
                    <div id='error_eanCode' class="error" style="display:none"></div></td>
                </tr>
                <tr>
                  <td width="50%" align="left" valign="top" class="td_pad_left">Product Number:</td>
                  <td width="50%" align="left" valign="top" class="td_pad_right"><INPUT class="text_field_new" type=text name="productNumber" value="<?=$_SESSION['post']['productNumber']
                               ?>" id="productNumber">
                    <div id='error_productNumber' class="error" style="display:none"> </div></td>
                </tr>
              </table>
        </table>
        </tr>
        <tr>
          <td ><div class="redwhitebutton_small123">Add your Coupon View</div>
            <table width="100%" border="0">
              <tr>
                <td width="100%"><table width="100%" BORDER=0 cellpadding="0" cellspacing="0" >
                    <tr>
                      <td width="50%" align="left" valign="top" class="td_pad_left">Large deal icon  <font size="2">(Image must be in jpeg or png format only e.g. image.png or image.jpg.The size must be at least 247 x 130 pixels)</font><span class='mandatory'>*</span> </td>
                      <td width="50%" align="left" valign="top" class="td_pad_right"><table border="0" align="left" cellpadding="0" cellspacing="0">
                          <tr>
                            <td align="left" valign="top"><?php if ($_SESSION['preview']['large_image']) {
                                    ?>
                              <img style="display:none;" src="upload/coupon/<?=$_SESSION['preview']['large_image'] ?>">
                              <input class="text_field_new" type="hidden" name="largeimage" id="largeimage" value="<?=$_SESSION['preview']['large_image'] ?>">
                              <br>
                              &nbsp;
                              <?
                                }
                                ?>
                              &nbsp;
                              <INPUT type=file name="picture" id="picture" onBlur="picturePreview(this.form);" class="text_field_new123"></td>
                            <td align="left" valign="middle" style="padding-left:10px;"><a title="<?=SPICTURE_TEXT
                                           ?>" class="vtip"><b><small>?</small></b></a>
                              <div id='error_picture' class="error" style="display:none"></div></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr>
                      <?php
                           $d = date("Y/m/d");
                            ?>
                      <td width="50%" align="left" valign="top" class="td_pad_left">Release date of product<span class='mandatory'>*</span>:</td>
                      <td width="50%" align="left" valign="top" class="td_pad_right"><table border="0" align="left" cellpadding="0" cellspacing="0">
                          <tr>
                            <td><input type="text" name="startDateStand" readonly="readonly" value="<? echo $d;
                                   ?>" id="startDateStand" class="startDateStand dp-applied text_field_new123" /></td>
                            <td style="padding-left:10px;"><a title="<?=START_TEXT
                               ?>" class="vtip"><b><small>?</small></b></a></td>
                          </tr>
                        </table>
                        <div id='error_startDateStand' class="error"></div></td>
                    </tr>
                    <tr>
                      <td colspan="4"><INPUT class="text_field_new" type="hidden" id="productName" name="productName" value="<?=$_SESSION['post']['productName']
                               ?>" >
                        <!-- <a title="<?=PRODUCTNAME_TEXT
                           ?>" class="vtip"><b><small>?</small></b></a></br>-->
                        <div id='error_productName' class="error"></div></td>
                    </tr>
                    <tr>
                      <td width="50%" align="left" valign="top" class="td_pad_left"><input type="checkbox" name="publicProduct" id="publicProduct"
                    <?
                    if ($_SESSION['post']['publicProduct'] == 1) {

                        echo 'checked="checked"';
                    }
                    ?>
                           value="1" >
                        Public product &nbsp; <a title="<?=PUBLIC_PRODUCT
                               ?>" class="vtip"><b><small>?</small></b></a> </td>
                      <td width="458" colspan="4" align="left" valign="top">&nbsp;</td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <div class="redwhitebutton_small123"><span style="cursor:pointer;" onClick="showAdvancedInfoPageStnad();">Add your Info Page</span></div>
        </tr>
        <tr>
          <td ><table width="100%" BORDER=0 cellpadding="0" cellspacing="0" id="infopageStand"  style="display:none;">
              <tr>
                <td width="50%" align="left" class="td_pad_left">Link:</td>
                <td width="50%" align="left" class="td_pad_right"><table border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td><input type="text" class="text_field_new" name="link" id="link" value="<?=$_SESSION['post']['link']
                                                   ?>">
                        <div id='error_link' class="error" style="display:none;"></div></td>
                      <td style="padding-left:15px;"><a title="<?=SDESCRIPTION_TEXT
                                                       ?>" class="vtip"><b><small>?</small></b></a> </td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
        </table>
      </div>
      <table width="100%" border="0">
        <tr>
          <td height="585">&nbsp;</td>
          <td align="center"><table width="200" align="center" border="0" cellpadding="0" cellspacing="0" style="background-image:url(client/images/iphone_large.png); width:270px; height:529px; background-repeat:no-repeat;">
              <tr>
                <td width="4" height="143">&nbsp;</td>
                <td colspan="3">&nbsp;</td>
                <td width="5">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td width="23"  >&nbsp;</td>
                <td valign="top" style="text-align:left; " width="225" height="114"><div id="pic_upload" height:112px;"><img id="picImg" src="upload/coupon/<?=$_SESSION['preview']['large_image']
                                                                    ?>" width="220" height="112" /></div>
                  <!-- <span style=" color:#FFFFFF;">
//                                    <span id="pictslogan" style=" font-size: 20px; font-weight: bold; color:#FFFFFF;">
//                                        <?=$_SESSION['preview']['offer_slogan_lang_list']
//                                                ?></span>
//                                    <span id="picsslogan">
//                                        <?=$_SESSION['preview']['offer_sub_slogan_lang_list']
//                                                ?>
//                                    </span>
//                                </span>-->
                  <!-- <span style="padding-left:20px; color:#FFFFFF;"><b>Category:</b><? //echo $catName['categoryName'];    ?></span><br>-->
                </td>
                <td width="10" ></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td height="21">&nbsp;</td>
                <td  >&nbsp;</td>
                <td valign="top"><div class="ttslogen" id="tSlogen" ></div></td>
                <td ><br>
                  <br></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td height="73" >&nbsp;</td>
                <td style="text-align:left; vertical-align: bottom;"><table width="104%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="33%" align="left" style=" padding-left:4px; color:#FFFFFF; font-size:10px;"><strong>Store Name</strong>
                        <? //=$_SESSION['preview']['product_number']?>
                        <br>
                        <strong>Street</strong><br>
                        <br></td>
                      <td width="19%" height="33" style=" color:#FFFFFF; font-size:10px;">&nbsp;</td>
                      <td width="48%" style=" color:#FFFFFF; font-size:10px;">&nbsp;</td>
                    </tr>
                  </table></td>
                <td ></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td height="206">&nbsp;</td>
                <td colspan="3">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table></td>
          <td>&nbsp;</td>
        </tr>
      </table>
      <div align="center"> <br />
        <br />
        <INPUT type="submit" value="Continue" name="continue" id="continue" class="button" >
        <br />
        <br />
      </div>
      <span class='mandatory'>* These Fields Are Mandatory</span> </div>
  </form>
</div>
<? include("footer.php"); ?>
</body>
<script language="JavaScript" src="client/js/jsImagePreview.js" type="text/javascript"></script>
