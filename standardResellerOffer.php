<?php
/*  File Name  : standardOffer.php
*  Description : Standard Offer Form
*  Author      : Himanshu Singh  Date: 25th,Nov,2010  Creation
*/
header('Content-Type: text/html; charset=utf-8');
include_once("cumbari.php");
$regObj = new registration();
//$regObj->isValidRegistrationStep();
$standardObj = new offer();
$compcont = $standardObj->companycountry();
if ($compcont == 'Sweden') {
    $lang = 'SWE';
    //echo $lang;die;
}
else {
    $lang = 'ENG';
}


if (isset($_POST['continue'])) {
    $standardObj->svrOfferDflt();
}
include_once("header.php");
if (isset($_GET['reedit'])) {
    $lang = $_SESSION['post']['lang'];
}
?>
<?php include 'config/defines.php'; ?>
<link rel="stylesheet" href="client/css/datePicker.css" type="text/css">
<script language="JavaScript" src="client/js/date.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/jquery.bgiframe.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/jquery.datePicker.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/ajaxuploadStand.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/jsStandardOffer.js" type="text/javascript"></script>
<!--<link rel="stylesheet" type="text/css" href="lib/vtip/css/vtip.css" />-->


<style type="text/css">

    a { }
    img { border: 0 }
</style>
<div class="center">
<div>
    <div id="preview_frame"></div>
</div>
<form name="register" action="" id="registerform" method="Post" enctype="multipart/form-data">
    <input type="hidden" name="preview" value="1">
    <input type="hidden" name="m" value="saveStandard">
    <input type="hidden" name="reseller" value="reseller">
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
            <table width="100%" cellspacing="10" border="0">
                <tr>

                    <td>&nbsp;</td>

                </tr>
                <tr>

                    <td width="51%" class="redwhitebutton">1 Register</td>

                </tr>
              
                <tr>

                    <td class="blackbutton">2 Add Offer</td>

                </tr>
                <tr>

                    <td  class="blackbutton_small" style="padding-top: 5px; padding-left:350px;">Add Standard Offer</td>

                </tr>
                <tr>

                    <td >&nbsp;</td>

                </tr>
                <tr>

                    <td>
                        <table BORDER=0 width="100%" cellspacing="10" >
                            <tr>
                               
                                <td width="515">Language:  </td>
                    <td width="469">
                        <select style="width:406px; background-color:#e4e3dd;" onchange="getLangImage(this.value);" class="text_field_new" name="lang" id="lang" >

                            <option <? if ($lang == 'GER')echo "selected='selected'"; ?> value="GER">German</option>
                            <option <? if ($lang == 'ENG')echo "selected='selected'"; ?> value="ENG">English</option>
                            <option <? if ($lang == 'SWE')echo "selected='selected'"; ?> value="SWE">Swedish</option>
                        </select>
                        <div id='error_langStand' class="error"></div>                                </td>
                     <td align="right" valign="middle"><a title="<?=SLANGUAGE_TEXT?>" class="vtip"><b><small>?</small></b></a> </td>
                </tr>
                <tr>
                   
                    <td width="515">Product Name
                <span class='mandatory'>*</span>:                           </td>
                <td>
                    <INPUT class="text_field_new" type=text name="titleSloganStand" id="titleSloganStand" onblur="iconPreview(this.form); getTitleForProduct(this.form);standardPreview(this.form);" value="<?=$_SESSION['post']['titleSloganStand']
                                   ?>">
                   
                    <div id='error_titleSloganStand' class="error"></div>                                    </td>
                 <td align="right" valign="middle" ><a title="<?=STITLE_TEXT?>" class="vtip"><b><small>?</small></b></a> </td>
                </tr>
                <tr style="display:none;">
                    <td>Price(with currency):</td>
                    <td>
                        <INPUT class="text_field_new" type=text name="price" id="price">
                        </td>
                    <td align="right" valign="middle"><a title="<?=PRICE_TEXT?>" class="vtip"><b><small>?</small></b></a> </td>
                </tr>
                <tr>
                    <td>Category<span class='mandatory'>*</span>:</td>
                <td> <div id="category_lang_div">
                        <select  class="text_field_new" onchange="getCatImage(this.value, this.form);" style="width:406px; background-color:#e4e3dd;" tabindex="27" id="linkedCatStand" name="linkedCatStand" value="<?=$_SESSION['post']['linkedCat']
                                         ?>">                                 <option value="">Select  Category</option>

                            <? echo $standardObj->getCategoryList($_SESSION['post']['linkedCatStand'],$lang) ?>
                        </select>
                    </div>
                    <input type="hidden" name="category_image" id="category_image" value="">
                    <div id="category_image_div" style="display:none;"></div>
                    <div id='error_linkedCatStand' class="error"></div></td>
                    <td align="right" valign="middle"><a title="<?=SCATEGORY_TEXT?>" class="vtip"><b><small>?</small></b></a> </td>
                </tr>
               <!-- <form action="" method="post" name="standard_use" id="standard_use" enctype="multipart/form-data">-->
                    <tr>
                       
                        <td>Small icon:</td>
                        <td>
                            <div id="pre_image">
                                <?php if ($_SESSION['preview']['small_image']) { ?>
                                <img src="upload/category/<?=$_SESSION['preview']['small_image'] ?>">
                                <input class="text_field_new" type="hidden" name="smallimage" id="smallimage" value="<?=$_SESSION['preview']['small_image'] ?>">
                                <br>
                                    <?
                                }
                                ?>
                            </div>
                            <INPUT class="text_field_new" type=file name="icon" id="icon" onblur="iconPreview(this.form);">
                           <br/>
                            <div id='error_icon' class="error"></div>
                            <div>
                                <input type="hidden" id="selected_image" name="selected_image" value="0">
                            </div>                        </td>
                         <td align="right" valign="top"><a title="<?=SICON_TEXT?>" class="vtip"><b><small>?</small></b></a> </td>
                        
                    </tr>
                    <tr style="display:none">
                        <td colspan="3" align="center" height="20"><strong><button onClick="ajaxUpload(this.form,'classes/ajx/ajxUpload.php?filename=icon&amp;maxW=200','upload_area'); return false;">Click here</button> to check how your short standard offer proposal looks like</strong></td>
                    </tr>
              <!--  </form>-->
            </table>

            <table border="0" width="100%">
                <tr id="short_preview" style="display:inline;">
                    <td width="300">&nbsp;</td>
                    <td width="220" align="center" valign="top" style="background-image:url(client/images/iphone.png); width:220px; height:430px; background-repeat:no-repeat; background-position:center;">

                        <div style="margin-top:120px; width:190px; margin-left:8px;" >
                           <table width="100%" border="0">
		<tr>
				<td width="41"  align="right"><div id="upload_area" style="vertical-align:top;"></div></td>
				<td width="79%" rowspan="2" valign="top"><table width="100%" border="0">
						<tr>
								<td width="108" valign="middle" class="style6" id="tslogan" style="font-size:9px; text-transform:lowercase;"></td>
								<td width="26"><font size="-3">??km</font></td>
						</tr>
						
						
				</table></td>
		</tr>
		<tr>
				<td>&nbsp;</td>
				</tr>
</table>
                        </div>                                    </td>
                    <td>&nbsp;</td>

                </tr>
            </table>

            </td>

            </tr>
            <tr>

                <td>

            </td>

            </tr>
            </table>
		  <table BORDER=0  width="100%" cellspacing="15" >
                        <tr>
                            <td width="4">&nbsp;</td>
                            <td width="515"> Sponsored
                                Standard Offer <span class='mandatory'>*</span>:</td>
                            <td width="469">

                                <select style="width:406px; background-color:#e4e3dd;" class="text_field_new"  tabindex="27" id="sponsStand"
                                        name="sponsStand">

                                    <option <? if ($_SESSION['post']['sponsStand'] == '0'

                                        )echo "selected='selected'"; ?> value="0">No</option>

                                    <option <? if ($_SESSION['post']['sponsStand'] == '1'

                                        )echo "selected='selected'"; ?> value="1">Yes</option>
                                </select>
                                <a title="<?=SSPONSOR_TEXT ?>" class="vtip"><b><small>?</small></b></a><br>
                                 <span style="font-size:12px;"> (Price per click 3,5 kr)</span>


                                <div id='error_sponsStand' class="error"></div></td>
                        </tr>
            </table>
      <table border="0" width="100%">
                <tr>

                    <td width="51%" class="blackbutton_small"  style="padding-top: 5px; padding-left: 300px;"> <span style="cursor:pointer;" onclick="showAdvancedSearchStand();">Advanced Options-Optional</span></td>

                </tr>
            </table>

<table width="100%" BORDER=0  id="advancedSearchStand" style="display:inline;"  cellspacing="15">
                            <tr width="100%">
                                <td width="4"></td>

                                <td width="515">Keywords separated by commas
                                    :</td>
                                <td width="469">
                                    <INPUT class="text_field_new" type=text name="searchKeywordStand" id="searchKeywordStand">
                                    <a title="<?=SKEYWORD_TEXT
                                               ?>" class="vtip"><b><small>?</small></b></a>
                                    <div id='error_searchKeywordStand' class="error"></div></td>
                            </tr>
							<tr>
                   
                    <td>EAN Code:<br>            </td>
                <td>
                    <INPUT class="text_field_new" type=text name="eanCode" id="eanCode" value="<?=$_SESSION['post']['eanCode']
                                   ?>"><div id='error_eanCode' class="error"></div></td>
                <td align="right" valign="middle"><a title="<?=SEAN_TEXT?>" class="vtip"><b><small>?</small></b></a> </td>
                </tr>
                <tr>
                   
                    <td>Product Number:<br>            </td>
                <td>
                    <INPUT class="text_field_new" type=text name="productNumber" value="<?=$_SESSION['post']['productNumber']
                                   ?>" id="productNumber"><div id='error_productNumber' class="error">
                    </div></td>
                     <td align="right" valign="middle"><a title="<?=PRODUCTNUMBER_TEXT?>" class="vtip"><b><small>?</small></b></a> </td>
                </tr>
                        </table>

            <table width="100%">
                <tr>

                    <td width="50%" class="blackbutton_small"  style="padding-top: 5px; padding-left: 320px;">Add your Coupon View</td>

                </tr>
            </table>

            <table BORDER=0 width="100%" cellspacing="15" >

                <tr>
                    <td width="4"  >&nbsp;</td>
                    <td width="515"  >Large deal icon
                <span class='mandatory'>*</span>:</td>
                <td width="469"  >
                    <?php if ($_SESSION['preview']['large_image']) { ?>
                    <img src="upload/coupon/<?=$_SESSION['preview']['large_image'] ?>">
                    <input class="text_field_new" type="hidden" name="largeimage" id="largeimage" value="<?=$_SESSION['preview']['large_image'] ?>">
                    <br>&nbsp;
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
                    <?php
                           $d = date("Y/m/d");
                            ?>
                    <td>Release date of product<span class='mandatory'>*</span>:</td>
                <td><input style="width:380px;"  type="text" name="startDateStand" readonly="readonly" value="<? echo $d;
                                   ?>" id="startDateStand" class="startDateStand dp-applied text_field_new" />
                    <a title="<?=RELEASE_DATE_OF_PRODUCT
                               ?>" class="vtip"><b><small>?</small></b></a><br/>
                    <div id='error_startDateStand' class="error"></div></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>            </td>
                <td>
                    <INPUT class="text_field_new" type="hidden" name="productName" value="<?=$_SESSION['post']['productName']
                                   ?>" id="productName">
                    <!--<a title="<?=PRODUCTNAME_TEXT
                               ?>" class="vtip"><b><small>?</small></b></a><br/>-->
                    <div id='error_productName' class="error"></div>                </td>
                </tr>

                <tr>
                    <td>&nbsp;</td>
                    <td>
                        <input type="checkbox" name="publicProduct" id="publicProduct"
                        <?
                        if ($_SESSION['post']['publicProduct'] == 1) {

                            echo 'checked="checked"';
                        }
                        ?>
                               value="1" >
                        Public product  &nbsp;    <a title="<?=PUBLIC_PRODUCT
                               ?>" class="vtip"><b><small>?</small></b></a>                    </td>
                    <td>&nbsp;</td>
                </tr>
            </table>


            </td>

            </tr>


            <tr>
            <table width="100%">
                <tr>

                    <td width="51%" class="blackbutton_small"  style="padding-top: 5px; padding-left: 340px;"> <span style="cursor:pointer;" onclick="showAdvancedInfoPageStnad();">Add your Info Page</span></td>

                </tr>
            </table>
            </tr>

            <tr>

                <td width="100%">



                    <table width="100%" BORDER=0 cellspacing="15"  id="infopageStand" style="display:none;">
                        <tr>
                            <td width="4">&nbsp;</td>
                            <td width="515">Link<spam class='mandatory'>*</spam>:  </td>
                            <td width="469" valign="middle">
                                <TEXTAREA class="text_field_new"name="link" id="link" value="<?=$_SESSION['post']['link']
                                   ?>" ></TEXTAREA>
                                <a title="<?=SDESCRIPTION_TEXT
                                           ?>" class="vtip"><b><small>?</small></b></a><br/>
                                <div id='error_link' class="error"></div></td>
                        </tr>
                    </table>

                </td>

            </tr>
            </table>
        </div>
        <table width="100%" border="0">
            <tr>
                <td>&nbsp;</td>
                <td align="center">
                    <table width="200" align="center" border="0" cellpadding="0" cellspacing="0" style="background-image:url(client/images/iphone_large.png); width:270px; height:529px; background-repeat:no-repeat;">
                        <tr>
                            <td width="4" height="143">&nbsp;</td>
                            <td colspan="3">&nbsp;</td>
                            <td width="5">&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td width="23" height="120" >&nbsp;</td>
                            <td valign="top" style="text-align:center; " width="228">
                                <div id="pic_upload" style="width:220px; height:112px;"><img id="picImg" src="upload/coupon/<?=$_SESSION['preview']['large_image']
                                             ?>" width="220" height="112" /></div>
                                <!--<span style=" color:#FFFFFF;">
                                    <span id="pictslogan" style=" font-size: 15px; font-weight: bold; color:#FFFFFF;">
                                        <?=$_SESSION['preview']['offer_slogan_lang_list']
                                                ?></span><br />
                                    <span id="picsslogan" style=" font-size: 12px; font-weight: bold; color:#FFFFFF;">
                                        <?=$_SESSION['preview']['offer_sub_slogan_lang_list']
                                                ?>
                                    </span>
                                </span> -->


<!-- <span style="padding-left:20px; color:#FFFFFF;"><b>Category:</b><? //echo $catName['categoryName'];    ?></span><br>-->
                            </td>
                            <td width="10" ></td>
                            <td>&nbsp;</td>
                        </tr>
				    <tr>
                            		<td height="32">&nbsp;</td>
                            		<td  >&nbsp;</td>
                            		<td valign="top" style="text-align:left; color:#FFFFFF; font-weight:bold; font-size:18px; "  id="tSlogen" >&nbsp;</td>
                            		<td ><br></td>
                            		<td>&nbsp;</td>
                            		</tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td height="73" >&nbsp;</td>
                            <td style="text-align:left; vertical-align: bottom;"><table width="104%" border="0" cellpadding="0" cellspacing="0">

                                        <tr>

                                        <td width="33%" align="left" style=" padding-left:4px; color:#FFFFFF; font-size:10px;"><strong>Store Name</strong><? //=$_SESSION['preview']['product_number']?><br>
                                      <strong>Street</strong></td>
                                          <td width="19%" height="33" style=" color:#FFFFFF; font-size:10px;">&nbsp;</td>
                                      <td width="48%" style=" color:#FFFFFF; font-size:10px;">&nbsp;</td>
								
                              </tr>
                                 
                                </table></td>
                            <td ></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td height="205">&nbsp;</td>
                            <td colspan="3">&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                    </table>
                </td>
                <td>&nbsp;</td>
            </tr>

        </table>
        <div align="center"><br />
            <br />

            <INPUT type="submit" value="Submit" name="continue" id="continue" class="button" >
        </div>
        <table border="0" width="100%">

            <tr>
                <td >&nbsp;</td>
            </tr>
            <tr>

                <td width="51%"class="redgraybutton">3 Activate</td>
            </tr>
            <tr>
                <td >&nbsp;</td>
            </tr>
        </table>

        <span class='mandatory'>* These Fields Are Mandatory</span>

       
    </div>
</form>
</div>
 <? include("footer.php"); ?>
</body>
</html>
<script language="JavaScript" src="client/js/jsImagePreview.js" type="text/javascript"></script>
