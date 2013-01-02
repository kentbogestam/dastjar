<?php
header('Content-Type: text/html; charset=ISO-8859-15');
//header ('Content-type: text/html; charset=utf-8');
include_once("cumbari.php");
$menu = "campaign";
$campaign = 'class="selected"';
if ($_GET['m'] == "showcampoffer")
    $outdated = 'class="selected"';
else
    $show = 'class="selected"';
$offerObj = new offer();
$regObj = new registration();
//$discount = $regObj->getCcode();

 $reseller = $_GET['from'];
//echo $_GET['campaignId'];die;
if (isset($_POST['continue'])) {
    //echo $campaignid = $_POST['campaignId'];echo "here";die;
    $offerObj->editSaveCampaignPreview($_POST['campaignId'],$reseller);
}

if($reseller == '')
{ include_once("main.php"); }
else
{ include_once("mainReseller.php"); }

$campaignid = $_GET['campaignId']; //die();
 $lang = $offerObj->getLang($campaignid);
$selectLanguage = $_GET['lang'];
if(!empty($selectLanguage))
    {
        $lang = $selectLanguage;
    }
$data = $offerObj->viewcampaignDetailById($campaignid,$lang);

//print_r($data);
if($data[0] == '')
    {
     $inoutObj = new inOut();
    $_SESSION['MESSAGE_NO_REORD'] = NO_RECORDS_LANG;
    $url = $_SERVER['HTTP_REFERER'];
     $inoutObj->reDirect($url);
      exit();
}
//echo "<pre>"; print_r($data); print "</pre>";


//echo $lang;
//if(count($data[storeDetails]))
//{
//    $inoutObj = new inOut();
//   $_SESSION['MESSAGE'] = NOT_EDIT;
//        $url = BASE_URL . 'showCampaign.php';
//
//        $inoutObj->reDirect($url);
//        exit();
//
//}

//if (isset($_SESSION['postPayment'])) {
//    //echo "here".$_SESSION['post']['lang']; die();
//    $x = ($_SESSION['postPayment']);
//    $lang = $_SESSION['post']['lang'];
//    $data[0]['campaign_id'] = $x['campaignId'];
//    $data[0]['lang'] = $x['lang'];
//    $data[0]['slogan'] = $x['titleSlogan'];
//    $data[0]['subslogen'] = $x['subSlogan'];
//    $data[0]['brand_name'] = $x['brandName'];
//    $data[0]['spons'] = $x['sponsor'];
//    $data[0]['category'] = $x['linkedCat'];
//    $data[0]['start_of_publishing'] = $x['startDate'];
//    $data[0]['end_of_publishing'] = $x['endDate'];
//    $data[0]['campaign_name'] = $x['campaignName'];
//    $data[0]['keywords'] = $x['searchKeyword'];
//    $data[0]['start_time'] = $x['startDateLimitation'];
//    $data[0]['end_time'] = $x['endDateLimitation'];
//    $data[0]['valid_day'] = $x['limitDays'];
//    $data[0]['infopage'] = $x['descriptive'];
//    $data[0]['large_image'] = $_SESSION['preview']['large_image'];
//   if(!$_REQUEST['ldacc'])
//    unset($_SESSION["postPayment"]);
//}

////echo "<pre>"; print_r($data[0]); print "</pre>";
///if($_SESSION['post']){
//    $data= $_SESSION['post'];
//    echo "<pre>"; print_r($data[0]); print "</pre>"; die();
//}
?>
<link rel="stylesheet" href="client/css/datePicker.css" type="text/css">
<script language="JavaScript" src="client/js/jquery.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/date.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/jquery.bgiframe.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/jquery.datePicker.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/ajaxupload.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/jsCampaignOffer.js" type="text/javascript"></script>
<META http-equiv="Content-Type" content="text/html; charset=ISO-8859-15">
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
<body>
<div class="center">
  <form name="registerform" action="" id="registerform" method="Post" target="_self" enctype="multipart/form-data">
    <input type="hidden" name="campaignId" value="<?=$_GET['campaignId']
                   ?>">
    <input type="hidden" name="preview" value="1">
    <input type="hidden" name="m" value="editSaveCampaign">
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
    <div class="blackbutton" style="padding-top: 50px;">Edit Campaign Offer</div>
    <div class="redwhitebutton_small123">Basic Campaign Information</div>
    <table border="0" width="100%" cellspacing="15" >
      <tr>
        <td  class="inner_grid">Edit According To Your Language:</td>
        <td colspan="2" ><select style="width:406px; background-color:#e4e3dd;" onChange="getLangImage(this.value),langChange(this.value,'<?=$_GET['campaignId']?>','<?=$reseller?>');" class="text_field_new" name="lang" id="lang" value="<?=$data[0]['lang']?>">
            <option <? if ($lang == "ENG"
                        )echo "selected='selected'"; ?> value="ENG">English</option>
            <option <? if ($lang == "SWE"
                        )echo "selected='selected'"; ?> value="SWE">Swedish</option>
          </select></td>
      </tr>
      <tr>
        <td  class="inner_grid">Campaign Title. Max. 19 characters<span class='mandatory'>*</span>:</td>
        <td colspan="2" ><INPUT class="text_field_new" type=text name="titleSlogan" id="titleSlogan" maxlength="19" onBlur="iconPreview(this.form);limitPreview(this.form);" value="<?=$data[0]['slogan'] ?>">
          <div id='error_titleSlogan' class="error"></div></td>
      </tr>
      <tr>
        <td class="inner_grid">Campaign Description. Max. 50 characters<span class='mandatory'>*</span>:</td>
        <td><INPUT class="text_field_new" type=text name="subSlogan" id="subSlogan" maxlength="50" onBlur="iconPreview(this.form);limitPreview(this.form);" value="<?=$data[0]['subslogen']
                           ?>">
          <div id='error_subSlogan' class="error"></div></td>
        <td align="right" valign="middle"><a title="<?=DESCRIPTION_TEXT
                       ?>" class="vtip"><b><small>?</small></b></a> </td>
      </tr>
      <!--<?php /* ?>
                         <form action="" method="post" name="standard_use" id="standard_use" enctype="multipart/form-data"><?php */ ?>-->
      <tr>
        <td class="inner_grid">Category<span class='mandatory'>*</span>:</td>
        <td colspan="2"><div id="category_lang_div">
            <select style="width:406px; background-color:#e4e3dd;" class="text_field_new" onChange="getCatImage(this.value, this.form);"  tabindex="27" id="linkedCat" name="linkedCat" >
              <option <? if ($data[0]['category'] == ''

                            )echo "selected='selected'"; ?> value="">Select Category</option>
              <? echo $offerObj->getCategoryList($data[0]['category'],$lang); ?>
            </select>
          </div>
          <input type="hidden" name="category_image" id="category_image" value="">
          <div id="category_image_div" style="display:none;"></div>
          <div id='error_linkedCat' class="error"></div></td>
      </tr>
      <tr>
        <td class="inner_grid">Small icon <font size="2">(Icon must be in png format only e.g. icon.png.The size must be at least 45 x 60 pixels)</font></td>
        <td><?php 
		if ($data[0]['small_image'] <> '') 
		{
 
 			$simage = $data[0]['small_image'];
 		?>
          <!--<img src="upload/category/<?=$_SESSION['preview']['small_image'] ?>">  -->
          <input type="hidden" name="smallimage" id="smallimage" value="<?=$simage;?>">
          <br>
          <? 
                } else {
                ?>
				<script language="JavaScript">getCatImage('<?=$data[0]['category'] ?>');</script>
				<? } ?>
          <INPUT class="text_field_new" type=file name="icon" id="icon" onBlur="iconPreview(this.form);">
          <div id='error_icon' class="error"></div>
          <div>
            <input class="text_field_new" type="hidden" id="selected_image" name="selected_image" value="0">
          </div></td>
        <td align="right" valign="middle"><a title="<?=ICON_TEXT
                           ?>" class="vtip"><b><small>?</small></b></a></td>
      </tr>
      <!-- <tr>
            <td colspan="4" align="center" height="20"><strong><button onclick="ajaxUpload(this.form,'classes/ajx/ajxUpload.php?filename=icon&amp;maxW=200','upload_area'); return false;">Click here</button> to check how your short campaign proposal looks like</strong></td>
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
    <div class="redwhitebutton_small123">Campaign Behaviour</div>
    <table BORDER=0   id="advancedSearch" width="100%" cellspacing="15" >
      <tr >
        <td width="515" class="inner_grid">Sponsored
          Campaign<span class='mandatory'>*</span>: </td>
        <td width="227"><select style="width:406px; background-color:#e4e3dd;" class="text_field_new"  id="sponsor" name="sponsor">
            <option <?=$data[0]['spons'] <> 1 ? 'selected' : ''
                                ?> value="0">No</option>
            <option <?=$data[0]['spons'] <> 0 ? 'selected' : ''
                                ?> value="1">Yes</option>
                </select>
              <span style="font-size:12px;"> (Price per view 0.01 kr)</span>
                <div id='error_sponsor' class="error"></div></td>
            <td align="right"><a title="<?=SPONSOR_TEXT ?>" class="vtip"><b><small>?</small></b></a> </td>
        </tr>
        <tr >
          <td class="inner_grid">Start date of Campaign<span class='mandatory'>*</span>:</td>
          <td><?  $d=$data[0]['start_of_publishing'];
            $timeStamp = explode(" ",$d);
            $start_date = trim($timeStamp[0]);?>

          <? $classVarStart1 = 'startDate dp-applied text_field_new';
           $classVarStart2 = 'dp-applied text_field_new';
           $classVarEnd1 = 'endDate dp-applied text_field_new';
           $classVarEnd2 = 'dp-applied text_field_new';
         $currDate = date('Y-m-d');
           if(($start_date <= $currDate) && $reseller != 'reseller') {
             $finClassVarStart = $classVarStart2;
             $finClassVarEnd = $classVarEnd2;
           }else {
                $finClassVarStart = $classVarStart1;
               $finClassVarEnd = $classVarEnd1;
           }

         ?>
          <input style="width:380px;" type="Text" name="startDate" readonly="readonly" value="<?=$start_date?>" id="startDate" class="<? echo $finClassVarStart;?>">
          <div id='error_startDate' class="error"></div></td>
        <td align="right"><a title="<?=START_TEXT ?>" class="vtip"><b><small>?</small></b></a></td>
      </tr>
      <tr >
        <td class="inner_grid">End date of Campaign<span class='mandatory'>*</span>:</td>
        <td><?  $d=$data[0]['end_of_publishing'];
                $timeStamp = explode(" ",$d);
                $end_date = trim($timeStamp[0]);?>
          <input style="width:380px;" type="Text" name="endDate" readonly="readonly" value="<?=$end_date
                               ?>" id="endDate" class="<? echo $finClassVarEnd; ?>">
          <div id='error_endDate' class="error"></div></td>
        <td align="right"><a title="<?=END_TEXT ?>" class="vtip"><b><small>?</small></b></a></td>
      </tr>
      <tr >
        <td class="inner_grid">Campaign Name.Not displayed to end user.Only for internal use<span class='mandatory'>*</span>:</td>
        <td><INPUT class="text_field_new" type=text name="campaignName" value="<?=$data[0]['campaign_name']
                           ?>" id="campaignName">
          <div id='error_campaignName' class="error"></div></td>
        <td align="right"><a title="<?=CAMPAIGNNAME_TEXT ?>" class="vtip"><b><small>?</small></b></a></td>
      </tr>
    </table>
    <table BORDER=0   id="advancedSearch" width="100%" cellspacing="15" >
      <tr >
        <td width="515" class="inner_grid"> Keywords: </td>
        <td width="227"><INPUT class="text_field_new" type=text name="searchKeyword" maxlength="90" value="<?=$data[0]['keyword']
                               ?>" id="searchKeyword">
          <div id='error_searchKeyword' class="error" ></div></td>
        <td align="right"><a title="<?=KEYWORD_TEXT ?>" class="vtip"><b><small>?</small></b></a> </td>
      </tr>
      <!--   <? if($reseller == '') { ?>
        <tr >
          <td width="515" class="inner_grid"> Discount:            </td>
            <td width="227">
              
                <select class="text_field_new"  name="ccode" id="ccode" >
                      <option value="">Select</option>
   <? foreach($discount as $discount1) { ?>
<? if($discount1['ccode'] == $data[0]['ccode'])
{ $selected = 'selected';}
else $selected = '';
?>

                        <option <? echo $selected ?> value="<? echo $discount1['ccode'] ;?> "> <? echo $discount1['value'];?></option>
                           <? } ?>
                    </select></td>
            <td align="right"><a title="<?=CCODE_TEXTCODE
                       ?>" class="vtip"><b><small>?</small></b></a> </td>
        </tr>
        <? } ?>-->
    </table>
    <table BORDER=0 width="100%" cellspacing="15" >
      <tr>
        <td width="515" class="inner_grid">Deal is only valid from start time during a day:</td>
        <td width="227"><select style="width:406px; background-color:#e4e3dd;" class="text_field_new" name="startDateLimitation" id="startDateLimitation" onBlur="limitPreview(this.form);" >
            <option <?=$data[0]['start_time'] == '' ? 'selected' : ''
                                ?> value=""> Select Start Date</option>
            <option <?=$data[0]['start_time'] == "00" ? 'selected' : ''
                                ?> value="00">00</option>
            <option <?=$data[0]['start_time'] == "01" ? 'selected' : ''
                                ?> value="01">01</option>
            <option <?=$data[0]['start_time'] == "02" ? 'selected' : ''
                                ?> value="02">02</option>
            <option <?=$data[0]['start_time'] == "03" ? 'selected' : ''
                                ?> value="03">03</option>
            <option <?=$data[0]['start_time'] == "04" ? 'selected' : ''
                                ?> value="04">04</option>
            <option <?=$data[0]['start_time'] == "05" ? 'selected' : ''
                                ?> value="05">05</option>
            <option <?=$data[0]['start_time'] == "06" ? 'selected' : ''
                                ?> value="06">06</option>
            <option <?=$data[0]['start_time'] == "07" ? 'selected' : ''
                                ?> value="07">07</option>
            <option <?=$data[0]['start_time'] == "08" ? 'selected' : ''
                                ?> value="08">08</option>
            <option <?=$data[0]['start_time'] == "09" ? 'selected' : ''
                                ?> value="09">09</option>
            <option <?=$data[0]['start_time'] == "10" ? 'selected' : ''
                                ?> value="10">10</option>
            <option <?=$data[0]['start_time'] == "11" ? 'selected' : ''
                                ?> value="11">11</option>
            <option <?=$data[0]['start_time'] == "12" ? 'selected' : ''
                                ?> value="12">12</option>
            <option <?=$data[0]['start_time'] == "13" ? 'selected' : ''
                                ?> value="13">13</option>
            <option <?=$data[0]['start_time'] == "14" ? 'selected' : ''
                                ?> value="14">14</option>
            <option <?=$data[0]['start_time'] == "15" ? 'selected' : ''
                                ?> value="15">15</option>
            <option <?=$data[0]['start_time'] == "16" ? 'selected' : ''
                                ?> value="16">16</option>
            <option <?=$data[0]['start_time'] == "17" ? 'selected' : ''
                                ?> value="17">17</option>
            <option <?=$data[0]['start_time'] == "18" ? 'selected' : ''
                                ?> value="18">18</option>
            <option <?=$data[0]['start_time'] == "19" ? 'selected' : ''
                                ?> value="19">19</option>
            <option <?=$data[0]['start_time'] == "20" ? 'selected' : ''
                                ?> value="20">20</option>
            <option <?=$data[0]['start_time'] == "21" ? 'selected' : ''
                                ?> value="21">21</option>
            <option <?=$data[0]['start_time'] == "22" ? 'selected' : ''
                                ?> value="22">22</option>
            <option <?=$data[0]['start_time'] == "23" ? 'selected' : ''
                                ?> value="23">23</option>
          </select>
          <div id='error_startDateLimitation'></div></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td class="inner_grid">Deal is only valid to an end time during a day:</td>
        <td><select style="width:406px; background-color:#e4e3dd;" class="text_field_new" name="endDateLimitation" id="endDateLimitation" onBlur="limitPreview(this.form);" >
            <option <?=$data[0]['end_time'] == '' ? 'selected' : ''
                                ?> value=""> Select End Date</option>
            <option <?=$data[0]['end_time'] == '00' ? 'selected' : ''
                                ?> value="00">00</option>
            <option <?=$data[0]['end_time'] == '01' ? 'selected' : ''
                                ?> value="01">01</option>
            <option <?=$data[0]['end_time'] == '02' ? 'selected' : ''
                                ?> value="02">02</option>
            <option <?=$data[0]['end_time'] == '03' ? 'selected' : ''
                                ?> value="03">03</option>
            <option <?=$data[0]['end_time'] == '04' ? 'selected' : ''
                                ?> value="04">04</option>
            <option <?=$data[0]['end_time'] == '05' ? 'selected' : ''
                                ?> value="05">05</option>
            <option <?=$data[0]['end_time'] == '06' ? 'selected' : ''
                                ?> value="06">06</option>
            <option <?=$data[0]['end_time'] == '07' ? 'selected' : ''
                                ?> value="07">07</option>
            <option <?=$data[0]['end_time'] == '08' ? 'selected' : ''
                                ?> value="08">08</option>
            <option <?=$data[0]['end_time'] == '09' ? 'selected' : ''
                                ?> value="09">09</option>
            <option <?=$data[0]['end_time'] == '10' ? 'selected' : ''
                                ?> value="10">10</option>
            <option <?=$data[0]['end_time'] == '11' ? 'selected' : ''
                                ?> value="11">11</option>
            <option <?=$data[0]['end_time'] == '12' ? 'selected' : ''
                                ?> value="12">12</option>
            <option <?=$data[0]['end_time'] == '13' ? 'selected' : ''
                                ?> value="13">13</option>
            <option <?=$data[0]['end_time'] == '14' ? 'selected' : ''
                                ?> value="14">14</option>
            <option <?=$data[0]['end_time'] == '15' ? 'selected' : ''
                                ?> value="15">15</option>
            <option <?=$data[0]['end_time'] == '16' ? 'selected' : ''
                                ?> value="16">16</option>
            <option <?=$data[0]['end_time'] == '17' ? 'selected' : ''
                                ?> value="17">17</option>
            <option <?=$data[0]['end_time'] == '18' ? 'selected' : ''
                                ?> value="18">18</option>
            <option <?=$data[0]['end_time'] == '19' ? 'selected' : ''
                                ?> value="19">19</option>
            <option <?=$data[0]['end_time'] == '20' ? 'selected' : ''
                                ?> value="20">20</option>
            <option <?=$data[0]['end_time'] == '21' ? 'selected' : ''
                                ?> value="21">21</option>
            <option <?=$data[0]['end_time'] == '22' ? 'selected' : ''
                                ?> value="22">22</option>
            <option <?=$data[0]['end_time'] == '23' ? 'selected' : ''
                                ?> value="23">23</option>
          </select>
          <div id='error_endDateLimitation'></div></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td class="inner_grid">Deal is only valid to a limited set of days during the week:</td>
        <td><!--<INPUT type=text name="limitDays" id="limitDays" value="<?=$_SESSION['post']['limitDays']
                        ?>">-->
          <select style="width:406px; background-color:#e4e3dd;" class="text_field_new" name="limitDays" id="limitDays" onBlur="limitPreview(this.form);">
            <option <?=$data[0]['valid_day'] == '' ? 'selected' : ''
                                ?> value="">Select Limit Days</option>
            <option <?=$data[0]['valid_day'] == "MON" ? 'selected' : ''
                                ?> value="MON">MON</option>
            <option <?=$data[0]['valid_day'] == "TUE" ? 'selected' : ''
                                ?> value="TUE">TUE</option>
            <option <?=$data[0]['valid_day'] == "WED" ? 'selected' : ''
                                ?>  value="WED">WED</option>
            <option <?=$data[0]['valid_day'] == "THU" ? 'selected' : ''
                                ?> value="THU">THU</option>
            <option <?=$data[0]['valid_day'] == "FRI" ? 'selected' : ''
                                ?> value="FRI">FRI</option>
            <option <?=$data[0]['valid_day'] == "SAT" ? 'selected' : ''
                                ?> value="SAT">SAT</option>
            <option <?=$data[0]['valid_day'] == "SUN" ? 'selected' : ''
                                ?> value="SUN">SUN</option>
            <option <?=$data[0]['valid_day'] == "MON_TO_FRI" ? 'selected' : ''
                                ?> value="MON_TO_FRI">MON TO FRI</option>
            <option <?=$data[0]['valid_day'] == "ALL_WEEK" ? 'selected' : ''
                                ?> value="ALL_WEEK">ALL WEEK</option>
          </select>
          <div id='error_limitDays'></div></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td  class="inner_grid"> Code:</td>
        <td valign="top" ><select class="text_field_new" name="codes" id="codes"  onChange="changeIntoText(this.value);">
            <?  ?>
            <option <? if($data[0]['code_type'] == '') {
                                echo "selected = 'selected'";
                            }?> value="">Select</option>
            <option <? if($data[0]['code_type'] == 'GTIN13') {
                                echo "selected = 'selected'";
                            }?> value="GTIN13">EAN-13</option>
             <option <? if($data[0]['code_type'] == 'PINCODE') {
                                echo "selected = 'selected'";
                            }?> value="CUSTOM">PINCODE</option>
          </select>
        </td>
        <td valign="top" >&nbsp;</td>
      </tr>
      <?php
                $code_type = $data[0]['code_type'];
                if($code_type=='')
                {
                    $display = "display:none";
                    $displaypin = "display:none";
                }
                else if($code_type=='GTIN13')
                {  
                    $display = "display:inline";
                    $displaypin = "display:none";
                }
                else if($code_type=='CUSTOM')
                {
                    $display = "display:none";
                    $displaypin = "display:inline";
                }
                ?>
      <tr>
        <td class="inner_grid" colspan="4">
          <table border="0" cellspacing="0" cellpadding="0" id="ean_table" style="<?=$display?>">
           

              <td class="inner_grid" id="ean_name" style="width:422px;" >Enter EAN-13 code: </td>
              <td class="inner_grid" id="ean_text" >
                <input class="text_field_new" type="text" name="etanCode" id="etntext" value="<?=$data[0]['code']?>" maxlength="13" onBlur="checkEan(this.value);" />
                <div id='error_codes' class="error"></div></td>
          </table>
        <table border="0" id="pincode_table" style="<?=$displaypin?>">
           

              <td class="inner_grid" id="ean_name" style="width:414px;">Enter PINCODE code: </td>
              <td class="inner_grid" id="ean_text" >
                <input class="text_field_new" type="text" name="pinCode" id="pintext" value="<?=$data[0]['code']?>" />
                <div id='error_codes' class="error"></div></td>
          </table>
        </td>
      </tr>
    </table>
    <div class="redwhitebutton_small123">Extended Campaign Behaviour</div>
    <table BORDER=0 width="100%" id="ExtendedCampaign" cellspacing="15" >
        <tr>
          <td width="515" class="inner_grid">Large deal icon <font size="2">(Image must be in jpeg or png format only e.g. image.png or image.jpg.The size must be at least 247 x 130 pixels)</font>
            		<span class='mandatory'>*</span></td>
        <td width="227">
            <?php
//                    if (isset($_SESSION['preview']['large_image']))
//                    {
//                          $_SESSION['preview']['large_image'] = $data[0]['large_image'];
//                    }
//                    else
//                    {
//                          $_SESSION['preview']['large_image'] = $data[0]['large_image'];
//                    }
#if ($data[0]['large_image'] <> '' && !isset($_SESSION['preview']['large_image']))

    //echo $data[0]['large_image']."----".$_SESSION['preview']['large_image'];
            if ($data[0]['large_image']) {
                 $icon_new = explode("/",$data[0]['large_image']);
                $iconlngth = count($icon_new);
                ?>
          <!--<img src="upload/coupon/<?=$icon_new[$iconlngth-1]
                             ?>">-->
          <input class="text_field_new" type="hidden" name="largeimage" id="largeimage" value="<?=$data[0]['large_image']
                               ?>">
          <?
            }
            ?>
          <INPUT  type=file name="picture" class="text_field_new"  id="picture" onBlur="picturePreview(this.form);">
          <div id='error_picture' class="error"></div></td>
        <td align="right" valign="middle"><a title="<?=SICON_TEXT
                       ?>" class="vtip"><b><small>?</small></b></a> </td>
      </tr>
    </table>
    <table BORDER=0  id="infopage" width="100%" cellspacing="15">
      <tr>
        <td width="515" class="inner_grid">Link:</td>
        <td width="227"><TEXTAREA class="text_field_new" NAME="descriptive" id="descriptive" COLS=30 ROWS=4><?=$data[0]['infopage']
                            ?>
</TEXTAREA>
          <div id='error_descriptive' class="error"></div></td>
        <td align="right" valign="middle"><a title="<?=SLINK_TEXT
                           ?>" class="vtip"><b><small>?</small></b></a></td>
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
              <td valign="top" style="text-align:center; " width="226"><div id="pic_upload" style="width:220px; height:112px;"><img id="picImg" src="upload/coupon/<?=$icon_new[$iconlngth-1]
                                         ?>" width="220" height="112" /></div>
                <?php
                          if ($data[0]['large_image']) {
                          $icon_new = explode("/",$data[0]['large_image']);
                          $iconlngth = count($icon_new);
                        ?>
                <?
                          }
                            ?>
                <!-- <span style=" color:#FFFFFF;">
                                <span id="pictslogan" style=" font-size: 20px; font-weight: bold; color:#FFFFFF;">
                                    <?=$_SESSION['preview']['offer_slogan_lang_list']
                                            ?></span>
                                <span id="picsslogan">
                                    <?=$_SESSION['preview']['offer_sub_slogan_lang_list']
                                            ?>
                                </span>                            </span> -->
                <!-- <span style="padding-left:20px; color:#FFFFFF;"><b>Category:</b><? //echo $catName['categoryName'];    ?></span><br>-->
              </td>
              <td width="6" ></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td height="10" ></td>
              <td  ></td>
              <td valign="top"><div class="ttslogen" id="ttSlogen"><?=$data[0]['slogan'] ?></div></td>
              <td ></td>
              <td></td>
            </tr>
            <tr>
              <td height="2" ></td>
              <td ></td>
              <td valign="top"><div class="ssslogen" id="ssslogen"><?=$data[0]['subslogen']
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
                      <? //=$_SESSION['preview']['product_number']?>
                      <br>
                      <strong>Street</strong><br></td>
                    <td width="9%" height="15" valign="top" style=" color:#FFFFFF; font-size:10px;">&nbsp;</td>
                    <td width="51%" height="20" align="left" valign="top" style=" color:#FFFFFF; font-size:10px;" id="limitPreview"><?php if($data[0]['valid_day']){?>
                      <strong>Valid: </strong><span id="limitValid">
                      <?=$data[0]['valid_day']?>
                      </span><br>
                      <span id="startLimit">
                      <?=$data[0]['start_time']?>
                      </span>-<span id="endLimit">
                      <?=$data[0]['end_time']?>
                      </span>
                      <?php } ?>
                    </td>
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
      <?if($reseller == '') {?>
      <INPUT type="submit" value="Update" name="continue" id="continue" class="button" onClick="return checkBarCode();" >
      <INPUT type="button" value="Back" name="continue" id="continue" class="button" onClick="javascript:location.href='showCampaign.php';" >
      <?} else {?>
      <INPUT type="submit" value="Update" name="continue" id="continue" class="button" onClick="return checkBarCode();">
      <INPUT type="button" value="Back" name="continue" id="continue" class="button" onClick="javascript:location.href='showResellerCampaign.php';" >
      <?}?>
    </div>
  </form>
  <div style="display:none;">
    <div align="center" >
      <h3> Check how your full campaign proposal look like.</h3>
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
    //getCatImage('<?=$data[0]['category'] ?>');
	getCatImageDefault();
</script>
<script>
    function langChange(lang,campId,reseller)
{
    if(reseller!='')
        {
            javascript:location.href = "editCampaign.php?lang="+lang+"&campaignId="+campId+"&from="+reseller;
        }else
            {
              javascript:location.href = "editCampaign.php?lang="+lang+"&campaignId="+campId;

            }
    
}
</script>
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