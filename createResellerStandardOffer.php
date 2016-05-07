<?php
/*  File Name  : standardOffer.php
 *  Description : Standard Offer Form
 *  Author      : Himanshu Singh  Date: 25th,Nov,2010  Creation
*/
header('Content-Type: text/html; charset=utf-8');
include_once("cumbari.php");
//echo $_SESSION['userid'];
$standardObj = new offer();
$compcont = $standardObj->companycountry();
if ($compcont == 'Sweden') {
    $lang = 'SWE';
    //echo $lang;die;
}
elseif ($compcont == 'Germany') {
    $lang = 'GER';
}
else {
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
include_once("mainReseller.php");
if (isset($_GET['reedit'])) {
    $lang = $_SESSION['post']['lang'];
}
?>
<?php include 'config/defines.php'; ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" href="client/css/datePicker.css" type="text/css">
<script language="JavaScript" src="client/js/date.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/jquery.bgiframe.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/jquery.datePicker.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/ajaxuploadStand.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/jsStandardOffer.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="lib/vtip/css/vtip.css" />

<style type="text/css">
    body { }
    a { }
    img { border: 0 }
	.center{width:900px; margin-left:auto; margin-right:auto;}

</style>
</head>
<body>
<!--<div id="msg" align="center"><br />
    <br />

    <?php
    if ($_SESSION['MESSAGE']) {
        echo $_SESSION['MESSAGE'];
        $_SESSION['MESSAGE'] = "";
        echo "<br><a href='";
        echo $url = BASE_URL . 'getFinancial.php';
        echo "'>Load your Account</a>";
    }
    ?>
</div>-->
<div class="center">
<form name="register" action="" id="registerform" method="Post" enctype="multipart/form-data">
    <input type="hidden" name="preview" value="1">
    <input type="hidden" name="m" value="saveNewStandard">
      <input type="hidden" name="reseller" value="reseller">


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

                    <td>&nbsp;</td>
                </tr>


                <tr>
                    <td class="blackbutton" style="padding-left:250px;" >Add  Standard Offer</td>
                </tr>
                <tr>

                    <td height="53" align="left"  class="redwhitebutton_small" style="padding-top:5px; text-align:center ">Add Standard Offer</td>
                </tr>

                <tr>

                    <td><table BORDER=0 width="100%"  cellspacing="15">
                            <tr>
                                <td width="515" class="inner_grid">Language:</td>
                                <td width="469">
                                    <select style="width:406px; background-color:#e4e3dd;" onchange="getLangImage(this.value);" class="text_field_new" name="lang" id="lang" >

                                        <option <? if ($lang == "GER")echo "selected='selected'"; ?> value="GER">German</option>
                                        <option <? if ($lang == "ENG")echo "selected='selected'"; ?> value="ENG">English</option>
                                        <option <? if ($lang == "SWE")echo "selected='selected'"; ?> value="SWE">Swedish</option>
                                    </select>
                                    <div id='error_langStand' class="error"></div>                                </td>
                                     <td align="right" valign="middle"><a title="<?=SLANGUAGE_TEXT?>" class="vtip"><b><small>?</small></b></a> </td>
                            </tr>
                            <tr>
                               

                                <td  class="inner_grid">Product Name<span class='mandatory'>*</span>:<br>                                </td>
                                <td >
                                    <INPUT class="text_field_new" type=text name="titleSloganStand" id="titleSloganStand" onblur="iconPreview(this.form); getTitleForProduct(this.form);standardPreview(this.form);" value="<?=$_SESSION['post']['titleSloganStand']
                                                   ?>">
                                   <br/>
                                    <div id='error_titleSloganStand' class="error"></div>                                </td>
                                     <td align="right" valign="middle" ><a title="<?=STITLE_TEXT?>" class="vtip"><b><small>?</small></b></a> </td>
                            </tr>
                            <tr style="display:none;">                                </tr>
                            <tr style="display:none;">
                               


                                <td class="inner_grid">Price(with currency):</td>
                                <td>
                                    <INPUT class="text_field_new" type=text name="price" id="price">
                                    </td>
                                   <td align="right" valign="middle"><a title="<?=PRICE_TEXT?>" class="vtip"><b><small>?</small></b></a> </td>
                            </tr>
                            <tr>
                                <td class="inner_grid">Category<span class='mandatory'>*</span>:</td>
                                <td>
                                    <div id="category_lang_div">
                                        <select  class="text_field_new" onchange="getCatImage(this.value, this.form);" style="width:406px; background-color:#e4e3dd;" tabindex="27" id="linkedCatStand" name="linkedCatStand" value="<?=$_SESSION['post']['linkedCat']
                                                         ?>">                                 <option <? if ($data[0]['category'] == ''

                                                )echo "selected='selected'"; ?> value="">Select Category</option>

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

                                <td class="inner_grid" style="line-height:25px;">Small icon:</td>
                                <td>
                                    <div id="pre_image">
                                        <?php if ($_SESSION['preview']['small_image']) {
                                            ?>
                                       <!-- <img src="upload/category/<?=$_SESSION['preview']['small_image'] ?>">-->
                                        <input class="text_field_new" type="hidden" name="smallimage" id="smallimage" value="<?=$_SESSION['preview']['small_image'] ?>">
                                        <br>
                                            <?
                                        }
                                        ?>
                                    </div>




                                    <INPUT class="text_field_new" type=file name="icon" id="icon" onblur="iconPreview(this.form);" >
                                   <br/>
                                    <div id='error_icon' class="error"></div>


                                    <div>
                                        <input class="text_field_new" type="hidden" id="selected_image" name="selected_image" value="0">
                                    </div>                                    </td>
                                 <td align="right" valign="top"><a title="<?=SICON_TEXT?>" class="vtip"><b><small>?</small></b></a> </td>
                                
                            </tr>
                            <tr style="display:none;">
                                <td colspan="4" align="center" height="20"><strong>
                                        <button onclick="ajaxUpload(this.form,'classes/ajx/ajxUpload.php?filename=icon&amp;maxW=200','upload_area'); return false;">Click here</button> to check how your short standard offer proposal looks like</strong></td>
                            </tr>
                            <!-- </form>-->
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
								<td width="787" valign="middle" class="style4" id="tslogan" style="font-size:9px; text-transform:lowercase;"></td>
								<td width="37"><font size="-3">??km</font></td>
						</tr>
						
				</table></td>
		</tr>
		<tr>
				<td>&nbsp;</td>
				</tr>
</table>
                                    </div>                                    </td>
                                <td >&nbsp;</td>
                            </tr>
                        </table>
                         <div class="redwhitebutton_small" style="  text-align:center; ">Describe how your Standard Offer should Behave</div>
                        <table BORDER=0 width="100%" cellspacing="15"  >
                            <tr>
                                <td class="inner_grid" width="1">&nbsp;</td>

                                <td class="inner_grid" width="510">Sponsored Standard Offer<span class='mandatory'>*</span>:</td>
                                <td width="471"><select style="width:406px; background-color:#e4e3dd;" class="text_field_new"  tabindex="27" id="sponsStand"
                                                        name="sponsStand">

                                        <option <? if ($_SESSION['post']['sponsStand'] == '0'

                                            )echo "selected='selected'"; ?> value="0">No</option>

                                        <option <? if ($_SESSION['post']['sponsStand'] == '1'

                                            )echo "selected='selected'"; ?> value="1">Yes</option>
                                    </select><br>
                                     <span style="font-size:12px;"> (Price per click 3,5 kr)</span>
                                    <div id='error_sponsStand' class="error"></div></td>
                            </tr>
                        </table>
                        <table border="0" width="100%">
                            <tr>

                                <td width="100%" class="redwhitebutton_small"  style="padding-top:5px; text-align:center" > <span style="cursor:pointer;" onclick="showAdvancedSearchStand();">Advanced Options-Optional</span></td>
                            </tr>
                        </table>


                        <table width="100%" BORDER=0 cellspacing="18"  id="advancedSearchStand" style="display:inline;">
                            <tr width="100%">
                                <td width="4" class="inner_grid"></td>
                                <td width="515" align="left" class="inner_grid">Keyword:</td>
                                <td width="469">
                                    <INPUT class="text_field_new" type=text name="searchKeywordStand" id="searchKeywordStand">
                                    <a title="<?=SKEYWORD_TEXT
                                               ?>" class="vtip"><b><small>?</small></b></a>
                                    <div id='error_searchKeywordStand' class="error"></div></td>
                            </tr>
                             <tr>
                <td class="inner_grid">EAN Code:<br>            </td>
            <td>
                <INPUT class="text_field_new" type=text name="eanCode" id="eanCode" value="<?=$_SESSION['post']['eanCode']
                               ?>"><div id='error_eanCode' class="error"></div></td>
                 <td align="right" valign="middle"><a title="<?=SEAN_TEXT?>" class="vtip"><b><small>?</small></b></a> </td>               
            </tr>
            <tr>
               
                <td class="inner_grid">Product Number:<br>            </td>
            <td>
                <INPUT class="text_field_new" type=text name="productNumber" value="<?=$_SESSION['post']['productNumber']
                               ?>" id="productNumber"><div id='error_productNumber' class="error">
                </div></td>
                 <td align="right" valign="middle"><a title="<?=PRODUCTNUMBER_TEXT?>" class="vtip"><b><small>?</small></b></a> </td>
            </tr>
                        </table>
            </table> 
            </td>

            </tr>
            <tr>
            <table width="100%" border="0">
                <tr>

                    <td width="52%"  style="padding-top:5px; text-align:center" class="redwhitebutton_small">Add your Coupon View</td>

                </tr>
            </table>
            </tr>
            <tr>

                <td >
                    <table width="100%" border="0">
                        <tr>

                            <td width="100%"><table BORDER=0 width="100%" cellspacing="15" >

                                    <tr>
                                        <td width="4" class="inner_grid">&nbsp;</td>
                                        <td width="515" class="inner_grid">Large deal icon
                                    <span class='mandatory'>*</span>:            </td>
                            <td width="469">
                                <?php if ($_SESSION['preview']['large_image']) {
                                    ?>
                                <img src="upload/coupon/<?=$_SESSION['preview']['large_image'] ?>">
                                <input class="text_field_new" type="hidden" name="largeimage" id="largeimage" value="<?=$_SESSION['preview']['large_image'] ?>">
                                <br>&nbsp;
                                    <?
                                }
                                ?>
                                <INPUT type=file name="picture" id="picture" onblur="picturePreview(this.form);">
                                <a title="<?=SPICTURE_TEXT
                                           ?>" class="vtip"><b><small>?</small></b></a><br/>
                                <div id='error_picture' class="error"></div></td>
                        </tr>
                        <tr>
                            <td class="inner_grid">&nbsp;</td>  <?php
                           $d = date("Y/m/d");
                            ?>
                           
                            <td class="inner_grid">Release date of product<span class='mandatory'>*</span>:</td>
                <td><input style="width:380px; "  type="text" name="startDateStand" readonly="readonly" value="<? echo $d;
                                   ?>" id="startDateStand" class="startDateStand dp-applied text_field_new" />
                    <a title="<?=RELEASE_DATE_OF_PRODUCT
                               ?>" class="vtip"><b><small>?</small></b></a><br/>
                    <div id='error_startDateStand' class="error"></div></td>
            </tr>
            <tr>
            		<td class="inner_grid">&nbsp;</td>
                <td class="inner_grid"></td>
            <td>
                <INPUT class="text_field_new" type="hidden" id="productName" name="productName" value="<?=$_SESSION['post']['productName']
                               ?>" >
               <!-- <a title="<?=PRODUCTNAME_TEXT
                           ?>" class="vtip"><b><small>?</small></b></a><br/>-->
                <div id='error_productName' class="error"></div>            </td>
            </tr>
           
            <tr>
                <td class="inner_grid">&nbsp;</td>
                <td class="inner_grid">
                    <input type="checkbox" name="publicProduct" id="publicProduct"
                    <?
                    if ($_SESSION['post']['publicProduct'] == 1) {

                        echo 'checked="checked"';
                    }
                    ?>
                           value="1" > Public product &nbsp;    <a title="<?=PUBLIC_PRODUCT
                               ?>" class="vtip"><b><small>?</small></b></a>           </td>
                <td width="458">&nbsp;</td>
            </tr>
            </table></td>

            </tr>
            </table>
            </td>

            </tr>

            <tr>

                <td>&nbsp;</td>
            </tr>
            <tr>
            <table width="100%">
                <tr>

                    <td width="51%"  style="padding-top:5px; text-align:center" class="redwhitebutton_small"> <span style="cursor:pointer;" onclick="showAdvancedInfoPageStnad();">Add your Info Page</span></td>

                </tr>
            </table>

            </tr>

            <tr>

                <td >


                    <table width="100%" border="0" >
                        <tr>

                            <td width="100%" >
                                <table BORDER=0 width="100%" cellspacing="15"  style="display:none;" id="infopageStand">
                                    <tr>
                                        <td width="4"></td>
                                        <td width="515" align="left">Link<spam class='mandatory'>*</spam>:</td>

                                        <td width="469">
                                            <input type="text" class="text_field_new" name="link" id="link" value="<?=$_SESSION['post']['link']
                                                   ?>"></input>
                                            <a title="<?=SDESCRIPTION_TEXT
                                                       ?>" class="vtip"><b><small>?</small></b></a><br/>
                                            <div id='error_link' class="error"></div></td>
                                    </tr>
                                </table></td>

                        </tr>
                    </table>

                </td>

            </tr>


            </table>

        </div>
        <table width="100%" border="0">
            <tr>
                <td height="580">&nbsp;</td>
                <td align="center">
                    <table width="200" align="center" border="0" cellpadding="0" cellspacing="0" style="background-image:url(client/images/iphone_large.png); width:270px; height:529px; background-repeat:no-repeat;">
                        <tr>
                            <td width="4" height="143">&nbsp;</td>
                            <td colspan="3">&nbsp;</td>
                            <td width="5">&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td width="23"  >&nbsp;</td>
                            <td valign="top" style="text-align:left; " width="228" height="114">
                                <div id="pic_upload" style="width:220px; height:112px;">  <img id="picImg" src="upload/coupon/<?=$_SESSION['preview']['large_image']
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
                            		<td valign="top" style="text-align:left; color:#FFFFFF; font-size: 18px; font-weight:bold " id="tSlogen" >&nbsp;</td>
                            		<td ><br><br></td>
                            		<td>&nbsp;</td>
                            		</tr>
                            
                        <tr>
                            <td>&nbsp;</td>
                            <td height="73" >&nbsp;</td>
                            <td style="text-align:left; vertical-align: bottom;"><table width="104%" border="0" cellpadding="0" cellspacing="0">

                                    <tr>

                                        <td width="33%" align="left" style=" padding-left:4px; color:#FFFFFF; font-size:10px;"><strong>Store Name</strong><? //=$_SESSION['preview']['product_number']?><br>
                                      <strong>Street</strong><br><br></td>
                                          <td width="19%" height="33" style=" color:#FFFFFF; font-size:10px;">&nbsp;</td>
                                      <td width="48%" style=" color:#FFFFFF; font-size:10px;">&nbsp;</td>
								
                              </tr>
                                   
                                </table></td>
                            <td ></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td height="215">&nbsp;</td>
                            <td colspan="3">&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                    </table>
                </td>
                <td>&nbsp;</td>
            </tr>

        </table>
        <div align="center">
            <br />
            <br />
            <INPUT type="submit" value="Continue" name="continue" id="continue" class="button" >
            <br />
            <br />
        </div>
        <span class='mandatory'>* These Fields Are Mandatory</span>
       
    </div>

</form> 
</div>
<? include("footer.php"); ?>
</body>
<script language="JavaScript" src="client/js/jsImagePreview.js" type="text/javascript"></script>
