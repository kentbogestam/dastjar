<?php
header('Content-Type: text/html; charset=utf-8');
//header ('Content-type: text/html; charset=utf-8');
include_once("cumbari.php");
$menu = "advertise";
$advertise = 'class="selected"';
if ($_GET['m'] == "showadvtoffer")
    $outdatedadvertise = 'class="selected"';
else
    $showadvertise = 'class="selected"';
$offerObj = new offer();
$regObj = new registration();

$reseller = $_GET['from'];
if (isset($_POST['continue'])) {
    $offerObj->editSaveAdvertisePreview($_POST['advertiseId'], $reseller);
}

if ($reseller == '') {
    include_once("main.php");
} else {
    include_once("mainReseller.php");
}

$advertiseid = $_GET['advertiseId']; //die();
$lang = $offerObj->getAdvertiseLang($advertiseid);
$selectLanguage = $_GET['lang'];
if (!empty($selectLanguage)) {
    $lang = $selectLanguage;
}
$data = $offerObj->viewadvertiseDetailById($advertiseid, $lang);

//print_R($data);die();

if ($data[0] == '') {
    $inoutObj = new inOut();
    $_SESSION['MESSAGE_NO_REORD'] = NO_RECORDS_LANG;
    $url = $_SERVER['HTTP_REFERER'];
    $inoutObj->reDirect($url);
    exit();
}
//echo "<pre>"; print_r($data); print "</pre>";
?>
<link rel="stylesheet" href="client/css/datePicker.css" type="text/css">
<script language="JavaScript" src="client/js/jquery.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/date.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/jquery.bgiframe.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/jquery.datePicker.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/ajaxupload.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/jsAdvertiseOffer.js" type="text/javascript"></script>
<META http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
    /*
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
    */
</style>
<body>
    <div class="center">
        <form name="registerform" action="" id="registerform" method="Post" target="_self" enctype="multipart/form-data">
            <input type="hidden" name="advertiseId" value="<?= $_GET['advertiseId']
?>">
            <input type="hidden" name="preview" value="1">
            <input type="hidden" name="m" value="editSaveAdvertise">
            <div>
                <div id="preview_frame"></div>
            </div>
            <div id="msg" align="center">
                <?
                if (($_SESSION['MESSAGE_NO_REORD'])) {
                    //echo "here";
                    echo $_SESSION['MESSAGE_NO_REORD'];
                    $_SESSION['MESSAGE_NO_REORD'] = '';
                }
                if (($_SESSION['MESSAGE'])) {
                    //echo "here";
                    // $_SESSION['postPayment'] = $x ;
                    echo $_SESSION['MESSAGE'];
                    $_SESSION['MESSAGE'] = '';
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
            <div class="blackbutton" style="padding-top: 50px;">Edit Advertise Offer</div>
            <div class="redwhitebutton_small123">Basic Advertise Information</div>
            <table border="0" width="100%" cellspacing="15" >
                <tr>
                    <td  class="inner_grid">Edit According To Your Language:</td>
                    <td  ><select style="width:406px; background-color:#e4e3dd;" onChange="getLangImage(this.value),langChange(this.value,'<?= $_GET['advertiseId'] ?>','<?= $reseller ?>');" class="text_field_new" name="lang" id="lang" value="<?= $data[0]['lang'] ?>">
                            <option <? if ($lang == "GER") echo "selected='selected'"; ?> value="GER">German</option> 
                            <option <? if ($lang == "ENG") echo "selected='selected'"; ?> value="ENG">English</option> 
			    <option <? if ($lang == "SWE") echo "selected='selected'"; ?> value="SWE">Swedish</option>
                        </select></td>
                         <td align="right"><a title="<?=CLANGUAGE_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
                </tr>
                <tr>
                    <td  class="inner_grid">Advertise Title. Max. 19 characters<span class='mandatory'>*</span>:</td>
                    <td  ><INPUT class="text_field_new" type=text name="titleSlogan" id="titleSlogan" maxlength="19" onBlur="iconPreview(this.form);limitPreview(this.form);" value="<?= $data[0]['slogan'] ?>">
                        <div id='error_titleSlogan' class="error"></div></td>
                     <td align="right"><a title="<?=ATITEL_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
                </tr>
                <tr>
                    <td class="inner_grid">Advertise Description. Max. 50 characters<span class='mandatory'>*</span>:</td>
                    <td><INPUT class="text_field_new" type=text name="subSlogan" id="subSlogan" maxlength="50" onBlur="iconPreview(this.form);limitPreview(this.form);" value="<?= $data[0]['subslogen']?>">
                        <div id='error_subSlogan' class="error"></div></td>
                    <td align="right" valign="middle"><a title="<?=ADESCRIPTION_TEXT?>" class="vtip"><b><small>?</small></b></a> </td>
                </tr>
                <!--<?php /* ?>
                  <form action="" method="post" name="standard_use" id="standard_use" enctype="multipart/form-data"><?php */ ?>-->
                <tr>
                    <td class="inner_grid">Category<span class='mandatory'>*</span>:</td>
                    <td ><div id="category_lang_div">
                            <select style="width:406px; background-color:#e4e3dd;" class="text_field_new" onChange="getCatImage(this.value, this.form);"  tabindex="27" id="linkedCat" name="linkedCat" >
                                <option <? if ($data[0]['category'] == ''
                )
                    echo "selected='selected'";
                ?> value="">Select Category</option>
<? echo $offerObj->getCategoryList($data[0]['category'], $lang); ?>
                            </select>
                        </div>
                        <input type="hidden" name="category_image" id="category_image" value="">
                        <div id="category_image_div" style="display:none;"></div>
                        <div id='error_linkedCat' class="error"></div></td>
                     <td align="right"><a title="<?=CCATEGORY_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
                </tr>
                <tr>
                    <td class="inner_grid">Small icon <font size="2">(Icon must be in png format only e.g. icon.png.The size must be at least 45 x 60 pixels)</font></td>
                    <td><?php
if ($data[0]['small_image'] <> '') {

    $simage = $data[0]['small_image'];
    ?>
                          <!--<img src="upload/category/<?= $_SESSION['preview']['small_image'] ?>">  -->
                            <input type="hidden" name="smallimage" id="smallimage" value="<?= $simage; ?>">
                            <br>
                            <?
                        } else {
                            ?>
                            <script language="JavaScript">getCatImage('<?= $data[0]['category'] ?>');</script>
<? } ?>
                        <INPUT class="text_field_new" type=file name="icon" id="icon" onBlur="iconPreview(this.form);">
                        <div id='error_icon' class="error"></div>
                        <div>
                            <input class="text_field_new" type="hidden" id="selected_image" name="selected_image" value="0">
                        </div></td>
                    <td align="right" valign="middle"><a title="<?= ICON_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
                </tr>
                <!-- <tr>
                      <td colspan="4" align="center" height="20"><strong><button onclick="ajaxUpload(this.form,'classes/ajx/ajxUpload.php?filename=icon&amp;maxW=200','upload_area'); return false;">Click here</button> to check how your short advertise proposal looks like</strong></td>
                  </tr> -->
            </table>
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr id="short_preview" style="display:inline;">
                    <td align="center" width="407" >&nbsp;</td>
                    <td width="442" align="center" valign="top" style="background-image:url(client/images/iphone_large-2.png); background-position:center; width:442; height:559px; background-repeat:no-repeat;"><div style="margin-top:150px; width:225px; margin-left:auto; margin-right:auto;" >
                            <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                                <tr>
                                    <td colspan="3"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td width="41"  align="left" valign="top" style="padding-left:5px; padding-right:5px;"><div id="upload_area" style="vertical-align:top;"></div></td>
                                                <td width="79%" rowspan="2" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td width="526"><span class="mob_title" id="tslogan"></span></td>
                                                            <td width="21" align="right" nowrap style="padding-right:3px;"><div style="float:right"><font size="-3">??km</font></div></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="526" colspan="2" style="vertical-align:top;"><span class="mob_txt"id="sslogan"></span></td>
                                                        </tr>
                                                    </table></td>
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
            <div class="redwhitebutton_small123">Advertise Behaviour</div>
            <table BORDER=0   id="advancedSearch" width="100%" cellspacing="15" >
                <tr >
                    <td width="515" class="inner_grid">Sponsored
                        Advertise<span class='mandatory'>*</span>: </td>
                    <td width="227"><select style="width:406px; background-color:#e4e3dd;" class="text_field_new"  id="sponsor" name="sponsor">
                            <option <?= $data[0]['spons'] <> 1 ? 'selected' : ''
?> value="0">No</option>
                            <option <?= $data[0]['spons'] <> 0 ? 'selected' : ''
?> value="1">Yes</option>
                        </select>
                        <span style="font-size:12px;"> (Price per view 0.01 kr)</span>
                        <div id='error_sponsor' class="error"></div></td>
                    <td align="right"><a title="<?=ASPONSOR_TEXT ?>" class="vtip"><b><small>?</small></b></a> </td>
                </tr>
                <tr >
                    <td class="inner_grid">Start date of Advertise<span class='mandatory'>*</span>:</td>
                    <td><?
                                $d = $data[0]['start_of_publishing'];
                                $timeStamp = explode(" ", $d);
                                $start_date = trim($timeStamp[0]);
?>

                        <?
                        $classVarStart1 = 'startDate dp-applied text_field_new';
                        $classVarStart2 = 'dp-applied text_field_new';
                        $classVarEnd1 = 'endDate dp-applied text_field_new';
                        $classVarEnd2 = 'dp-applied text_field_new';
                        $currDate = date('Y-m-d');
                        if (($start_date <= $currDate) && $reseller != 'reseller') {
                            $finClassVarStart = $classVarStart2;
                            $finClassVarEnd = $classVarEnd2;
                        } else {
                            $finClassVarStart = $classVarStart1;
                            $finClassVarEnd = $classVarEnd1;
                        }
                        ?>
                        <input style="width:380px;" type="Text" name="startDate" readonly="readonly" value="<?= $start_date ?>" id="startDate" class="<? echo $finClassVarStart; ?>">
                        <div id='error_startDate' class="error"></div></td>
                    <td align="right"><a title="<?= ASTART_TEXT ?>" class="vtip"><b><small>?</small></b></a></td>
                </tr>
                <tr >
                    <td class="inner_grid">End date of Advertise<span class='mandatory'>*</span>:</td>
                    <td><?
                        $d = $data[0]['end_of_publishing'];
                        $timeStamp = explode(" ", $d);
                        $end_date = trim($timeStamp[0]);
                        ?>
                        <input style="width:380px;" type="Text" name="endDate" readonly="readonly" value="<?= $end_date
                        ?>" id="endDate" class="<? echo $finClassVarEnd; ?>">
                        <div id='error_endDate' class="error"></div></td>
                    <td align="right"><a title="<?= AEND_TEXT ?>" class="vtip"><b><small>?</small></b></a></td>
                </tr>
                <tr >
                    <td class="inner_grid">Advertise Name.Not displayed to end user.Only for internal use<span class='mandatory'>*</span>:</td>
                    <td><INPUT class="text_field_new" type=text name="advertiseName" value="<?= $data[0]['advertise_name']
                        ?>" id="advertiseName">
                        <div id='error_advertiseName' class="error"></div></td>
                    <td align="right"><a title="<?=ADVERTISENAME_TEXT ?>" class="vtip"><b><small>?</small></b></a></td>
                </tr>
            </table>
            <table BORDER=0   id="advancedSearch" width="100%" cellspacing="15" >
                <tr >
                    <td width="515" class="inner_grid"> Keywords<span class='mandatory'>*</span>: </td>
                    <td width="227"><INPUT class="text_field_new" type=text name="searchKeyword" maxlength="90" value="<?= $data[0]['keyword']
                        ?>" id="searchKeyword">
                        <div id='error_searchKeyword' class="error" ></div></td>
                    <td align="right"><a title="<?=AKEYWORD_TEXT ?>" class="vtip"><b><small>?</small></b></a> </td>
                </tr>

            </table>          
            <div class="redwhitebutton_small123">Extended Advertise Behaviour</div>
            <table BORDER=0 width="100%" id="ExtendedAdvertise" cellspacing="15" >
                <tr>
                    <td width="515" class="inner_grid">Large deal icon <font size="2">(Image must be in jpeg or png format only e.g. image.png or image.jpg.The size must be at least 247 x 130 pixels)</font>
                        <span class='mandatory'>*</span></td>
                    <td width="227">
                               <?php
                               if ($data[0]['large_image']) {
                                   $icon_new = explode("/", $data[0]['large_image']);
                                   $iconlngth = count($icon_new);
                                   ?>
                            <input class="text_field_new" type="hidden" name="largeimage" id="largeimage" value="<?= $data[0]['large_image']
                                   ?>">
    <?
}
?>
                        <INPUT  type=file name="picture" class="text_field_new"  id="picture" onBlur="picturePreview(this.form);">
                        <div id='error_picture' class="error"></div></td>
                    <td align="right" valign="middle"><a title="<?=SPICTURE_TEXT?>" class="vtip"><b><small>?</small></b></a> </td>
                </tr>
            </table>
            <table BORDER=0  id="infopage" width="100%" cellspacing="15">
                <tr>
                    <td width="515" class="inner_grid">Link:</td>
                    <td width="227"><TEXTAREA class="text_field_new" NAME="descriptive" id="descriptive" COLS=30 ROWS=4><?= $data[0]['infopage']
?>
                        </TEXTAREA>
                        <div id='error_descriptive' class="error"></div></td>
                    <td align="right" valign="middle"><a title="<?= ALINK_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
                </tr>
            </table>
            <table width="100%" border="0">
                <tr>
                    <td height="559">&nbsp;</td>
                    <td align="center"><table width="200" align="center" border="0" cellpadding="0" cellspacing="0" style="background-image:url(client/images/iphone_large.png); width:270px; height:529px; background-repeat:no-repeat;">
                            <tr>
                                <td width="9" height="143"   >&nbsp;</td>
                                <td width="17"   ></td>
                                <td valign="top" >&nbsp;</td>
                                <td ></td>
                                <td width="12">&nbsp;</td>
                            </tr>
                            <tr>
                                <td height="116"    >&nbsp;</td>
                                <td   ></td>
                                <td valign="top" style="text-align:center; " width="226"><div id="pic_upload" style="width:220px; height:112px;"><img id="picImg" src="upload/coupon/<?= $icon_new[$iconlngth - 1]
?>" width="220" height="112" /></div>
<?php
if ($data[0]['large_image']) {
    $icon_new = explode("/", $data[0]['large_image']);
    $iconlngth = count($icon_new);
}
?>                
                                </td>
                                <td width="6" ></td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td height="10" ></td>
                                <td  ></td>
                                <td valign="top"><div class="ttslogen" id="ttSlogen"><?= $data[0]['slogan'] ?></div></td>
                                <td ></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td height="2" ></td>
                                <td ></td>
                                <td valign="top"><div class="ssslogen" id="ssslogen"><?= $data[0]['subslogen']
?></div></td>
                                <td ></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td height="73" >&nbsp;</td>
                                <td style="text-align:left; vertical-align: bottom;"><table width="104%" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td width="35%" align="left" valign="top" style=" padding-left:4px; color:#FFFFFF; font-size:10px;"><strong>Store Name</strong>
<? //=$_SESSION['preview']['product_number'] ?>
                                                <br>
                                                <strong>Street</strong><br></td>
                                            <td width="9%" height="15" valign="top" style=" color:#FFFFFF; font-size:10px;">&nbsp;</td>
                                            
                                        </tr>
                                    </table></td>
                                <td ></td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td height="232">&nbsp;</td>
                                <td colspan="3">&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                        </table></td>
                    <td>&nbsp;</td>
                </tr>
            </table>
            <div align="center">
<? if ($reseller == '') { ?>
                    <INPUT type="submit" value="Update" name="continue" id="continue" class="button" >
                    <INPUT type="button" value="Back" name="continue" id="continue" class="button" onClick="javascript:location.href='showAdvertise.php';" >
<? } else { ?>
                    <INPUT type="submit" value="Update" name="continue" id="continue" class="button">
                    <INPUT type="button" value="Back" name="continue" id="continue" class="button" onClick="javascript:location.href='showResellerAdvertise.php';" >
<? } ?>
            </div>
        </form>
        <div style="display:none;">
            <div align="center" >
                <h3> Check how your full advertise proposal look like.</h3>
            </div>
            <table width="200" align="center" border="1" cellpadding="0" cellspacing="0">
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
        <span class='mandatory'>* These Fields Are Mandatory</span></div>
<? include("footer.php"); ?>
</body>
<script language="JavaScript">
    //Load small png img
    //getCatImage('<?= $data[0]['category'] ?>');
    getCatImageDefault();
</script>
<script>
    function langChange(lang,advtId,reseller)
    {
        if(reseller!='')
        {
            javascript:location.href = "editAdvertise.php?lang="+lang+"&advertiseId="+advtId+"&from="+reseller;
        }else
        {
            javascript:location.href = "editAdvertise.php?lang="+lang+"&advertiseId="+advtId;

        }
    
    }
</script>
<script language="JavaScript" src="client/js/jsImagePreview.js" type="text/javascript"></script>

