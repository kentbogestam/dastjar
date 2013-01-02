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
$storeObj = new store();
 $_GET['campaignId'];

$stores = $storeObj->totalStoreDetails();
//echo "<pre>";print_r($stores); echo "</pre>";
if (isset($_POST['continue'])) {
    $offerObj->svrOfferDflt();
}
$menu = "campaign";
$campaign = 'class="selected"';
if ($_GET['m'] == "showcampoffer")
    $outdated = 'class="selected"';
else
    $show = 'class="selected"';
include("main.php");
?>

<link rel="stylesheet" href="client/css/datePicker.css" type="text/css">
<script type="text/javascript" src="lib/vtip/js/jquery.js"></script>
<script type="text/javascript" src="lib/vtip/js/vtip.js"></script>
<link rel="stylesheet" type="text/css" href="lib/vtip/css/vtip.css" />
<script language="JavaScript" src="client/js/jquery.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/date.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/jquery.bgiframe.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/jquery.datePicker.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/ajaxupload.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/jsCouponCamp.js" type="text/javascript"></script>
<style type="text/css">
    <!--
    .style4 {
        font-size: 10px;
        font-weight: bold;
    }
    .style6 {font-size: 9px}
    -->
</style>
<div>
    <div id="preview_frame"></div>
</div>
<div id="registerform" align="center">
    <?
    if (isset($_SESSION['MESSAGE'])) {
        echo $_SESSION['MESSAGE'];
        $_SESSION['MESSAGE'] = '';
    }
    ?>
</div>
<form name="registerform" action="" id="registerform" method="Post" target="_self" enctype="multipart/form-data">
    <input type="hidden" name="preview" value="1">
    <input type="hidden" name="campaignId" value="<?=$_GET['campaignId'];?>">
    <input type="hidden" name="m" value="saveNewCouponRetailer">
    <div class="redwhitebutton" style="width:452px; margin-left:200px; margin-top: 10px; padding-top: 10px; padding-left: 20px; ">Enter basic Coupon Information</div>
    <table BORDER=0  width="100%">
        <tr>
            <td width="22%">&nbsp;</td>
            <td width="28%"> Coupon Title:</td>
            <td width="50%">
                <INPUT type=text name="titleSlogan" id="titleSlogan" value="<?=$_SESSION['post']['titleSlogan']
    ?>">
                <a title="<?=TITEL_TEXT
    ?>" class="vtip"><b><small>see example</small></b></a></br>
                    <div id='error_titleSlogan' class="error"></div></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td> Coupon Description:</td>
                <td>
                    <INPUT type=text name="subSlogan" id="subSlogan" value="<?=$_SESSION['post']['subSlogan']
    ?>">
                <a title="<?=DESCRIPTION_TEXT
    ?>" class="vtip"><b><small>see example</small></b></a></br>
                    <div id='error_subSlogan' class="error"></div></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>Category:</td>
                <td><select onchange="getCatImage(this.value);" style="width:200px;" tabindex="27" id="linkedCat" name="linkedCat" value="<?=$_SESSION['post']['linkedCat']
    ?>">
                        <option <? if ($data[0]['category'] == ''

                                                )echo "selected='selected'"; ?> value="">Select Category</option>
                   <?=$offerObj->getCategoryList($_SESSION['post']['linkedCat']) ?>
                </select>
                <input type="hidden" name="category_image" id="category_image" value="">
                <div id="category_image_div" style="display:none;"></div>
                <div id='error_linkedCat' class="error"></div></td>
        </tr>
        <form action="" method="post" name="standard_use" id="standard_use" enctype="multipart/form-data">
            <tr>
                <td>&nbsp;</td>
                <td>Add a icon to represent your coupon:</td>
                <td>
                    <?php if ($_SESSION['preview']['small_image']) {
                    ?>
                            <img src="upload/category/<?=$_SESSION['preview']['small_image'] ?>">
                    <input type="hidden" name="smallimage" id="smallimage" value="<?=$_SESSION['preview']['small_image'] ?>">
                    <br>
                    <?
                }
                    ?>




                    <INPUT type=file name="icon" id="icon">
                    <a title="<?=ICON_TEXT
                    ?>" class="vtip"><b><small>see example</small></b></a></br>
                    <div id='error_icon' class="error"></div>

                    <div>
                        <input type="hidden" id="selected_image" name="selected_image" value="0">
                    </div>                </td>
            </tr>
            <tr>
                <td colspan="3" align="center" height="20"><strong><button onClick="ajaxUpload(this.form,'classes/ajx/ajxUpload.php?filename=icon&amp;maxW=200','upload_area'); return false;">Click here</button> to check how your short campaign proposal looks like</strong></td>
            </tr>
        </form>
    </table>
    <table width="100%">
        <tr id="short_preview" style="display:none;">
            <td width="300">&nbsp;</td>
            <td align="center" valign="top" style="background-image:url(client/images/iphone.png); width:220px; height:430px; background-repeat:no-repeat;">


                <table width="189" >
                    <tr>
                        <td height="108">&nbsp;</td>
                        <td>&nbsp;</td>
                        <td style="vertical-align:top;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width="39">
                            <div id="upload_area" style="vertical-align:top;">                                </div>                            </td>
                        <td width="103"><span class="style4" id="tslogan"></span>
                            <br>
                            <span class="style6" id="sslogan"></span> </td>
                        <td width="31" style="vertical-align:top;"><font size="-3">??km</font></td>
                    </tr>
                </table>

            </td>
            <td>&nbsp;</td>

        </tr>
    </table>

    <div  class="redwhitebutton" style= " width:452px; margin-left:200px; margin-top: 10px; padding-top: 10px; padding-left: 80px; " onclick="showCampaignBehavior()">Enter Coupon Behavior</div>
    <div  style="display:none;" id="CampaignBehavior">
        <table BORDER=0 width="100%">
                <tr>
                    <td>&nbsp;</td>
                    <td>Do you want to sponsor your Coupon:</td>
                    <td><select style="width: 200px;" id="sponsor" name="sponsor"><div id='error_sponsor' class="error"></div>
                            <option <? if ($_SESSION['post']['sponsor'] == 0

                               )echo "selected='selected'"; ?> value="0">No</option>

                        <option <? if ($_SESSION['post']['sponsor'] == 1

                                )echo "selected='selected'"; ?> value="1">Yes</option>
                    </select> <a title="<?=SPONSOR_TEXT ?>" class="vtip"><b><small>see example</small></b></a></br></td>
            </tr>

            <tr>
                <td>&nbsp;</td>
                <td>Start date of your Coupon :</td>
                <td>
                    <input type="Text" name="startDate" readonly="readonly" value="<?=$_SESSION['post']['startDate'] ?>" id="startDate" class="startDate dp-applied">
                    <a title="<?=START_TEXT ?>" class="vtip"><b><small>see example</small></b></a></br>
                    <div id='error_startDate' class="error"></div></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>End date of your Coupon :</td>
                <td>
                    <input type="Text" name="endDate" readonly="readonly" value="<?=$_SESSION['post']['endDate'] ?>" id="endDate" class="endDate dp-applied">
                    <a title="<?=END_TEXT ?>" class="vtip"><b><small>see example</small></b></a></br>
                    <div id='error_endDate' class="error"></div></td>
            </tr>
            <tr>
            <tr>
                <td>&nbsp;</td>
                <td>Start Time for the Coupon Limitation:</td>
                <td>
                    <select name="startDateLimitation" id="startDateLimitation" value="<?=$_SESSION['post']['startDateLimitation'] ?>">
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
                    <div id='error_startDateLimitation'></div>                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>End Time for the Coupon Limitation:</td>
                <td>
                    <!--<INPUT type=text name="endDateLimitation" id="endDateLimitation">-->
                    <select name="endDateLimitation" id="endDateLimitation" value="<?=$_SESSION['post']['endDateLimitation'] ?>">
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
                <td>&nbsp;</td>
                <td>Limit the Campaign to following days                </td>
                <td>
                    <select name="limitDays" id="limitDays">
                        <option <? if ($_SESSION['post']['limitDays'] == 'MON'

                                )echo "selected='selected'"; ?> value="MON">MON</option>
                        <option <? if ($_SESSION['post']['limitDays'] == 'TUE'

                                )echo "selected='selected'"; ?> value="TUE">TUE</option>
                        <option <? if ($_SESSION['post']['limitDays'] == 'WED'

                                )echo "selected='selected'"; ?> value="WED">WED</option>
                        <option <? if ($_SESSION['post']['limitDays'] == 'THU'

                                )echo "selected='selected'"; ?> value="THU">THU</option>
                        <option <? if ($_SESSION['post']['limitDays'] == 'FRI'

                                )echo "selected='selected'"; ?> value="FRI">FRI</option>
                        <option <? if ($_SESSION['post']['limitDays'] == 'SAT'

                                )echo "selected='selected'"; ?> value="SAT">SAT</option>
                        <option <? if ($_SESSION['post']['limitDays'] == 'SUN'

                                )echo "selected='selected'"; ?> value="SUN">SUN</option>
                        <option <? if ($_SESSION['post']['limitDays'] == 'MON_TO_FRI'

                                )echo "selected='selected'"; ?> value="MON_TO_FRI">MON TO FRI</option>
                        <option <? if ($_SESSION['post']['limitDays'] == 'ALL_WEEK'

                                )echo "selected='selected'"; ?> value="ALL_WEEK">ALL WEEK</option>
                    </select>
                    <div id='error_limitDays'></div></td>
            </tr>
            <tr></tr>
        </table>
    </div>
    <div class="redwhitebutton" style="width:452px; margin-left:200px; margin-top: 10px; padding-top: 10px; padding-left:50px; " onclick="showExtendedCampaign()"> Extended Coupon information</div>
    <div  style="display:none;" id="ExtendedCampaign">
        <table BORDER=0 width="100%">
            <tr>
                <td width="24%">&nbsp;</td>
                <td width="24%">And Select a picture as your Coupon                </td>
                <td width="52%"><input type="hidden" name="largeimage" id="largeimage" value="<?=$_SESSION['preview']['large_image'] ?>">
                    <?php if ($_SESSION['preview']['large_image']) {
                    ?>
                                <img src="upload/coupon/<?=$_SESSION['preview']['large_image'] ?>">
                    <br>Or&nbsp;
                    <?
                }
                    ?>
                    <INPUT type=file name="picture" id="picture"><div id='error_picture' class="error"></div></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>Select a Store</td>
                <td>
                    <select name="selectStore" id="selectStore">
                        <?php foreach ($stores as $stores1) {
                            // print_r($stores1);  ?>
                            <option  value="<?=$stores1['store_id'] ?>"><? echo $stores1['store_name']; ?></option>

                        <? } ?>
                    </select>
                    <div id='error_selectStore' class="error"></div>                </td>
            </tr>
        </table>

    </div>
    <div align="center">
        <INPUT type="submit" value="continue" name="continue" id="continue" class="button" >
    </div>
</form>
<div style="display:none;">
    <div align="center" >
        <h3> Check how your full campaign proposal look like.</h3>
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
</body>

<? if ($_SESSION['preview']) {
?>
                        <script>
                            showCampaignBehavior();
                            showExtendedCampaign();
                        </script>
<?
                    }
?>