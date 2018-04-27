<?php
   /*  File Name  : standardOffer.php
    *  Description : Standard Offer Form
    *  Author      : Himanshu Singh  Date: 25th,Nov,2010  Creation
   */
   header('Content-Type: text/html; charset=utf-8');
   include_once("cumbari.php");
   $menu = "standard";
   $standard = 'class="selected"';
   $show = 'class="selected"';
   $reseller = $_REQUEST['from'];
   if($reseller == '')
   {
   include_once("main.php");
   }else {
       include_once("mainReseller.php");
   }
   $standardObj = new offer();
   $listDishes = $standardObj->listDishes();
   if (isset($_POST['continue'])) {
       $productid = $_POST['productId']; //die();
   
       $standardObj->editSaveProductPreview($productid,$reseller);
   }
   
   $productid = $_GET['productId']; //die();
   $lang = $standardObj->getLangProduct($productid);
   $selectLanguage = $_GET['lang'];
   if(!empty($selectLanguage))
       {
           $lang = $selectLanguage;
       }
   $data = $standardObj->viewStandardDetailById($productid,$lang);
   //echo "<pre>";print_r($data);echo "</pre>";
   if($data[0] == '')
       {
        $inoutObj = new inOut();
       $_SESSION['MESSAGE_NO_REORD'] = NO_RECORDS_LANG;
       $url = $_SERVER['HTTP_REFERER'];
        $inoutObj->reDirect($url);
         exit();
   }
   
   //if (isset($_SESSION['postPaymentStand'])) {
   //    $x = ($_SESSION['postPaymentStand']);
   //    $data[0]['product_id'] = $x['productId'];
   //    $data[0]['lang'] = $x['lang'];
   //    $data[0]['slogen'] = $x['titleSloganStand'];
   //    $data[0]['is_sponsored'] = $x['sponsStand'];
   //    $data[0]['category'] = $x['linkedCatStand'];
   //    $data[0]['link'] = $x['link'];
   //    $data[0]['keywords'] = $x['searchKeywordStand'];
   //    $data[0]['product_name'] = $x['productName'];
   //    $data[0]['ean_code'] = $x['eanCode'];
   //    $data[0]['product_number'] = $x['productNumber'];
   //    $data[0]['is_public'] = $x['publicProduct'];
   //    $data[0]['product_info_page'] = $x['descriptiveStand'];
   //    $data[0]['start_of_publishing'] = $x['startDateStand'];
   //    $data[0]['large_image'] = $_SESSION['preview']['large_image'];
   //    if(!$_REQUEST['ldacc'])
   //        unset($_SESSION["postPaymentStand"]);
   //}
   
   ?>
<?php include 'config/defines.php'; ?>
<link rel="stylesheet" href="client/css/datePicker.css" type="text/css">
<link rel="stylesheet" href="client/css/stylesheet123.css" type="text/css">
<script language="JavaScript" src="client/js/date.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/jquery.bgiframe.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/jquery.datePicker.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/ajaxuploadStand.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/jsStandardOffer.js" type="text/javascript"></script>
<!--<link rel="stylesheet" type="text/css" href="lib/vtip/css/vtip.css" />-->
<META http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
   a {
   }
   img {
   border: 0
   }
</style>
<div class="center">
   <div>
      <div id="preview_frame"></div>
   </div>
   <form name="register" action="" id="registerform" method="Post" enctype="multipart/form-data">
      <input type="hidden" name="preview" value="1">
      <input type="hidden" name="productId" value="$_GET['productId']">
      <div class="blackbutton123">Show Standard Offer</div>
      <div id="msg" align="center">
         <?
            if (($_SESSION['MESSAGE_NO_REORD'])) {
               //echo "here";
               echo $_SESSION['MESSAGE_NO_REORD'];
               $_SESSION['MESSAGE_NO_REORD'] = '';
              
            }
            if (($_SESSION['MESSAGE'])) {
               //echo "here";
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
      <div class="redwhitebutton_small123">Edit Data List View  For Standard Offer</div>
      <input type="hidden" name="m" value="saveNewStandard">
      <input type="hidden" name="productId" value="<?=$_GET['productId']
         ?>">
      <table border="0"   width="100%" cellspacing="15">
         <tr>
            <td width="515" align="left" valign="top" class="inner_grid">Edit According To Your Language: </td>
            <td width="469" align="left" valign="top">
               <select style="width:406px; background-color:#e4e3dd;" onChange="getLangImage(this.value),langChange(this.value,'<?=$_GET['productId']?>','<?=$reseller?>');" class="text_field_new" name="lang" id="lang" value="<?=$data[0]['lang']?>">
                  <option <? if ($lang == "GER")echo "selected='selected'"; ?> value="GER">German</option>
                  <option <? if ($lang == "ENG")echo "selected='selected'"; ?> value="ENG">English</option>
                  <option <? if ($lang == "SWE")echo "selected='selected'"; ?> value="SWE">Swedish</option>
               </select>
               <div id='error_langStand' class="error"></div>
            </td>
            <td align="right" valign="middle"><a title="<?=SLANGUAGE_TEXT?>" class="vtip"><b><small>?</small></b></a> </td>
         </tr>
         <tr>
            <td align="left" valign="top"  class="inner_grid">Dish Name<span class='mandatory'>*</span>:</td>
            <td align="left" valign="top" >
               <INPUT class="text_field_new" style="height:21px; border: 1px solid #99999b; padding-top:4px;" type=text name="titleSloganStand" id="titleSloganStand" maxlength="50" onBlur="iconPreview(this.form); getTitleForProduct(this.form);" value="<?=$data[0]['slogen']
                  ?>">
               <div id='error_titleSloganStand' class="error"></div>
            </td>
            <td align="right" valign="top" ><a title="<?=STITLE_TEXT
               ?>" class="vtip"><b><small>?</small></b></a> </td>
         </tr>
         <tr>
            <td align="left" valign="top"  class="inner_grid">Description. Max. 50 characters<span class='mandatory'>*</span>:<br>
            </td>
            <td align="left" valign="top" >
               <INPUT class="text_field_new" type=text name="productDescription" id="productDescription" maxlength="150" onBlur="iconPreview(this.form);" value="<?=isset($data[0]['product_description']) ? $data[0]['product_description'] : ''
                  ?>">
               <div id='error_productDescription' class="error" ></div>
            </td>
            <td align="right" valign="middle" ><a title="<?=STITLE_TEXT?>" class="vtip"><b><small>?</small></b></a> </td>
         </tr>
        <tr>
          <td height="42" align="left">Dish Preparation Time<span class='mandatory'>*</span>:</td>
          <td>
             <select class="text_field_new" style="background-color:#e4e3dd; width:406px; height:36px;border: 1px solid #abadb3;" tabindex="27" id="preparationTime" name="preparationTime">
                <option <? if ($data[0]['preparation_Time'] == '00:05:00')echo "selected='selected'"; ?> value="00:05:00">5 Minutes</option>
                <option <? if ($data[0]['preparation_Time'] == '00:10:00')echo "selected='selected'"; ?>  value="00:10:00">10 Minutes</option>
                <option <? if ($data[0]['preparation_Time'] == '00:15:00')echo "selected='selected'"; ?>  value="00:15:00">15 Minutes</option>
                <option <? if ($data[0]['preparation_Time'] == '00:20:00')echo "selected='selected'"; ?>  value="00:20:00">20 Minutes</option>
                <option <? if ($data[0]['preparation_Time'] == '00:25:00')echo "selected='selected'"; ?>  value="00:25:00">25 Minutes</option>
                <option <? if ($data[0]['preparation_Time'] == '00:30:00')echo "selected='selected'"; ?> value="00:30:00">30 Minutes</option>
                <option <? if ($data[0]['preparation_Time'] == '00:35:00')echo "selected='selected'"; ?>  value="00:35:00">35 Minutes</option>
                <option <? if ($data[0]['preparation_Time'] == '00:40:00')echo "selected='selected'"; ?>  value="00:40:00">40 Minutes</option>
                <option <? if ($data[0]['preparation_Time'] == '00:45:00')echo "selected='selected'"; ?>  value="00:45:00">45 Minutes</option>
                <option <? if ($data[0]['preparation_Time'] == '00:50:00')echo "selected='selected'"; ?>  value="00:50:00">50 Minutes</option>
                <option <? if ($data[0]['preparation_Time'] == '00:55:00')echo "selected='selected'"; ?>  value="00:55:00">55 Minutes</option>
                <option <? if ($data[0]['preparation_Time'] == '00:59:00')echo "selected='selected'"; ?>  value="00:59:00">59 Minutes</option>
             </select>
          </td>
       </tr> 
        <!--  <tr>
            <td align="left" valign="top"  class="inner_grid">Dish Preparation Time<span class='mandatory'>*</span>:<br>
            </td>
            <td align="left" valign="top" >
               <INPUT class="text_field_new" type=time name="preparationTime" id="preparationTime" maxlength="19" onBlur="iconPreview(this.form);" value="<?=isset($data[0]['preparation_Time']) ? $data[0]['preparation_Time'] : ''
                  ?>">
               <div id='error_preparationTime' class="error" ></div>
            </td>
            <td align="right" valign="middle" ><a title="<?=STITLE_TEXT?>" class="vtip"><b><smal --><!-- l>?</small></b></a> </td>
         </tr> -->
         <!-- <tr>
            <td align="left" valign="top" class="inner_grid">Category<span class='mandatory'>*</span>:</td>
            <td  align="left" valign="top"><div id="category_lang_div">
                <select class="text_field_new" onChange="getCatImage(this.value, this.form);" style="width:406px; background-color:#e4e3dd; " tabindex="27" id="linkedCatStand" name="linkedCatStand" value="<?=$_SESSION['post']['linkedCatStand']
               ?>">
                  <option <? if ($data[0]['category'] == ''
               )echo "selected='selected'"; ?> value="">Select Category</option>
                  <? echo $standardObj->getCategoryList($data[0]['category'],$lang); ?>
                </select>
              </div>
              <input type="hidden" name="category_image" id="category_image" value="">
              <div id="category_image_div" style="display:none;"></div>
              <div id='error_linkedCatStand' class="error"></div></td>
            <td align="right" valign="middle"><a title="<?=SCATEGORY_TEXT?>" class="vtip"><b><small>?</small></b></a> </td>
            </tr> -->
         <tr>
            <td align="left" valign="top" class="inner_grid">Small icon <font size="2">(Icon must be in png format only e.g. icon.png.The size must be at least 45 x 60 pixels)</font></td>
            <td align="left" valign="top">
               <?php if ($_SESSION['preview']['small_image']) {
                  ?>
               <!-- <img src="<?=$data[0]['small_image']?>"> -->
               <input class="text_field_new" type="hidden" name="smallimage" id="smallimage" value="<?=$_SESSION['preview']['small_image'] ?>">
               <br>
               <?
                  }
                  ?>
              <!--  <INPUT class="text_field_new" type=file name="icon" id="icon" onBlur="iconPreview(this.form);"> -->
               <div id='error_icon' class="error"></div>
               <div>
                  <input class="text_field_new" type="hidden" id="selected_image" name="selected_image" value="0">
               </div>
            </td>
            <td align="right" valign="top"><a title="<?=ICON_TEXT
               ?>" class="vtip"><b><small>?</small></b></a> </td>
         </tr>
         <tr style="display:none;">
            <td colspan="5" align="center" height="20"><strong>
               <button onClick="ajaxUpload(this.form,'classes/ajx/ajxUpload.php?filename=icon&amp;maxW=200','upload_area'); return false;">Click here</button>
               to check how your short standard offer proposal looks like</strong>
            </td>
         </tr>
      </table>
      <table  border="0" align="center" cellpadding="0" cellspacing="0">
         <tr id="short_preview" style="display:inline;">
            <td width="422" align="center" valign="top" style="background-image:url(client/images/iphone_large-3.png); width:270px; height:559px; background-repeat:no-repeat;">
               <div style="margin-top:80px; width:225px; margin-left:5px; margin-right:auto;" >
                  <table border="0" cellpadding="0" cellspacing="0">
                     <tr>
                        <td width="41"  align="left" style="padding-left:5px; padding-right:5px;">
                           <div id="upload_area" style="vertical-align:top;"><img src="<?=$data[0]['small_image']?>"  height = 30 width = 50 id="myCatIcon" name="myCatIcon"></div>
                        </td>
                        <td rowspan="2" valign="top">
                           <table width="98%" border="0" cellpadding="0" cellspacing="0">
                              <tr>
                                 <td class="mob_title_2" id="tslogan"></td>
                                 <td width="21" align="right" nowrap style="padding-right:3px;">
                                    <div><font size="-3"></font></div>
                                 </td>
                              </tr>
                              <!--<tr>
                                 <td valign="top" colspan="2" class="mob_txt" id="sslogan"></td>
                                 </tr>-->
                           </table>
                        </td>
                     </tr>
                  </table>
               </div>
            </td>
         </tr>
      </table>
      <br />
      <div class="redwhitebutton_small123" style="display:none;">Describe how your Standard Offer should Behave</div>
      <table  width="100%" border="0" cellspacing="14" style="display:none;">
         <tr>
            <td width="515" align="left" valign="top" class="inner_grid">Sponsored Standard Offer<span class='mandatory'>*</span>:</td>
            <td width="469" align="left" valign="top">
               <select class="text_field_new" style="width:406px; background-color:#e4e3dd;" tabindex="27" id="sponsStand" name="sponsStand">
                  <div id='error_sponsStand' class="error"></div>
                  <option <?=$data[0]['is_sponsored'] <> 1 ? 'selected' : ''
                     ?> value="0">No</option>
                  <option <?=$data[0]['is_sponsored'] <> 0 ? 'selected' : ''
                     ?> value="1">Yes</option>
               </select>
               <br> <span style="font-size:12px;"> (Price per view 0.01 kr)</span>          
            </td>
         </tr>
         <!--   <tr>
            <td  class="inner_grid">&nbsp;</td>
            
              <td  class="inner_grid">Product information link<span class='mandatory'>*</span>:</td>
            <td ><INPUT class="text_field_new" type=text name="link" id="link" value="<?=$data[0]['link']
               ?>">
              <a title="<?=SLINK_TEXT
               ?>" class="vtip"><b><small>?</small></b></a><br/>
              <div id='error_link' class="error"></div></td>
            </tr>-->
      </table>
      <div class="redwhitebutton_small123">Advanced Options-Optional</div>
      <table cellspacing="15"   style="display:inline_row;" id="advancedSearchStand" width="100%">
         <tr>
            <td width="515" align="left" valign="top" class="inner_grid">Keywords<span class='mandatory'>*</span>:</td>
            <td width="227" align="left" valign="top">
               <INPUT class="text_field_new" type=text name="searchKeywordStand" id="searchKeywordStand" maxlength="90" value="<?=$data[0]['keyword']
                  ?>">
               <div id='error_searchKeywordStand' class="error"></div>
            </td>
            <td align="right" valign="top"><a title="<?=SKEYWORD_TEXT
               ?>" class="vtip"><b><small>?</small></b></a></td>
         </tr>
         <!-- <tr>
            <td align="left" valign="top" class="inner_grid">EAN Code:<br></td>
            <td  align="left" valign="top"><INPUT class="text_field_new" type=text name="eanCode" id="eanCode" value="<?=$data[0]['ean_code']
               ?>">
              <div id='error_eanCode' class="error"></div></td>
             <td align="right" valign="middle"><a title="<?=SEAN_TEXT?>" class="vtip"><b><small>?</small></b></a> </td>
            </tr> -->
         <!-- <tr>
            <td align="left" valign="top" class="inner_grid">Product Number:<br></td>
            <td  align="left" valign="top"><INPUT class="text_field_new" type=text name="productNumber" value="<?=$data[0]['product_number']
               ?>" id="productNumber">
              <div id='error_productNumber' class="error"> </div></td>
             <td align="right" valign="middle"><a title="<?=PRODUCTNUMBER_TEXT?>" class="vtip"><b><small>?</small></b></a> </td>
            </tr> -->
         <tr>
      </table>
      <div class="redwhitebutton_small123">Add your Coupon View</div>
      <table  width="100%" border="0" cellspacing="15">
         <!--  <tr>
            <td width="505" align="left" valign="top" class="inner_grid">Large deal icon <font size="2">(Image must be in jpeg or png format only e.g. image.png or image.jpg.The size must be at least 247 x 130 pixels)</font>
                  <span class='mandatory'>*</span></td>
            <td width="233" align="left" valign="top">
              <?php
               if (($data[0]['large_image'])) {
               
               
                   $icon_new = explode("/",$data[0]['large_image']);
                   $iconlngth = count($icon_new);
                   ?> -->
         <!-- <img src="upload/coupon/<?=$icon_new[$iconlngth-1]
            ?>">-->
         <!-- <input class="text_field_new" type="hidden" name="largeimage" id="largeimage" value="<?=$data[0]['large_image']
            ?>">
            <?
               }
               ?>
            <INPUT  type=file name="picture" id="picture" onBlur="picturePreview(this.form);">
            <div id='error_picture' class="error"></div></td>
            <td align="right" valign="top"><a title="<?=SPICTURE_TEXT
               ?>" class="vtip"><b><small>?</small></b></a> </td>
            </tr> -->
         <tr>
            <td class="inner_grid">Release date of product<span class='mandatory'>*</span>:</td>
            <td align="left" valign="top">
               <?  $d=$data[0]['start_of_publishing'];
                  $timeStamp = explode(" ",$d);
                  $start_date = $timeStamp[0];?>
               <input type="text"  style="width:380px;" name="startDateStand" readonly="readonly" value="<?=$start_date
                  ?>" id="startDateStand" class="startDateStand dp-applied text_field_new" />
               <div id='error_startDateStand' class="error"></div>
            </td>
            <td align="right" valign="top"><a title="<?=RELEASE_DATE_OF_PRODUCT?>" class="vtip"><b><small>?</small></b></a> </td>
         </tr>
         <tr>
            <td width="50%" align="left" valign="top" class="td_pad_left">Type of Dish<span class='mandatory'>*</span>:</td>
            <td width="50%" align="left" valign="top" class="td_pad_right">
               <?php $value = 0; ?>
               <div class="adddishes">
                  <select id= "xx" selected="<?=isset($data[0]['dish_type']) ? $data[0]['dish_type'] : ''?>" name="select2" style="width:406px; background-color:#e4e3dd; border:#abadb3 solid 1px;" class="text_field_new" >
                     <?php foreach($listDishes as $key =>$value) { ?>
                     <option value = <?php echo $value['dish_id']?> <?php if($data[0]['dish_type'] == $value['dish_id']) echo "selected"; ?> ><?php echo $value['dish_name']?></option>
                     <?php } ?>
                  </select>
                  <div id='error_startDateStand' class="error"></div>
               </div>
            </td>
         </tr>
         <tr>
            <td colspan="2">
               <INPUT class="text_field_new" type="hidden" name="productName" value="<?=$data[0]['product_name']
                  ?>" id="productName">
               <!--<a title="<?=PRODUCTNAME_TEXT
                  ?>" class="vtip"><b><small>?</small></b></a><br/>-->
               <div id='error_productName' class="error"></div>
            </td>
         </tr>
         <!-- <tr>
            <td><?php if ($data[0]['is_public']) { ?>
              <input type="checkbox" name="publicProduct"  checked="checked" value="1">
              Public product
              <?php } else {
               ?>
              <input type="checkbox" name="publicProduct" value="1">
              Public product
              <?php } ?>
              &nbsp; <a title="<?=PUBLIC_PRODUCT
               ?>" class="vtip"><b><small>?</small></b></a> </td>
            <td colspan="2">&nbsp;</td>
            </tr> -->
         <div id='error_publicProduct' class="error"></div>
      </table>
      <!-- <div class="redwhitebutton_small123">Add your Info Page</div>
         <table  width="100%" style="display: inline_row;" id="infopageStand" cellspacing="15">
           <tr>
             <td width="515" class="inner_grid">Link:</td>
             <td width="227"><INPUT class="text_field_new"  name="link" id="link" value="<?=$data[0]['link']
            ?>">
               <div id='error_link' class="error"></div></td>
             <td align="right"><a title="<?=SDESCRIPTION_TEXT ?>" class="vtip"><b><small>?</small></b></a> </td>
           </tr>
         </table> -->
      <!-- <table width="100%" border="0">
         <tr>
           <td>&nbsp;</td>
           <td align="center"><table width="200" align="center" border="0" cellpadding="0" cellspacing="0" style="background-image:url(client/images/iphone_large.png); width:270px; height:529px; background-repeat:no-repeat;">
               <tr>
                 <td width="4" height="143">&nbsp;</td>
                 <td colspan="3">&nbsp;</td>
                 <td width="5">&nbsp;</td>
               </tr>
               <tr>
                 <td>&nbsp;</td>
                 <td width="23" height="151" >&nbsp;</td>
                 <td valign="top" style="text-align:left; " width="228"><?php
            if ($data[0]['large_image']) {
                $icon_new = explode("/",$data[0]['large_image']);
                $iconlngth = count($icon_new);
                ?>
                   <div id="pic_upload" style="width:220px; height:115px;"><img id="picImg" src="upload/coupon/<?=$icon_new[$iconlngth-1]
            ?>" width="220" height="112" /></div>
                   <?
            }
            ?>
                   <span> <span class="ssslogen" id="pictslogan">
                   <?=$data[0]['slogen']
            ?>
                   </span> </span> <br>
                   <br> -->
      <!-- <span style="padding-left:20px; color:#FFFFFF;"><b>Category:</b><? //echo $catName['categoryName'];    ?></span><br>-->
      <!-- </td>
         <td width="10" ></td>
         <td>&nbsp;</td>
         </tr>
         <tr>
         <td>&nbsp;</td>
         <td height="73" >&nbsp;</td>
         <td style="text-align:left; vertical-align: bottom;"><table width="104%" border="0" cellpadding="0" cellspacing="0">
             <tr>
               <td width="39%" align="left" style=" padding-left:4px; color:#FFFFFF; font-size:10px;"><strong>Store Name</strong>
                 <? //=$_SESSION['preview']['product_number']?>
                 <br>
                 <strong>Street</strong><br>
                 <br></td>
               <td width="17%" height="20" style=" color:#FFFFFF; font-size:10px;">&nbsp;</td>
               <td width="44%" style=" color:#FFFFFF; font-size:10px;">&nbsp;</td>
             </tr>
           </table></td>
         <td ><br>
           <br></td>
         <td>&nbsp;</td>
         </tr>
         <tr>
         <td height="249">&nbsp;</td>
         <td colspan="3">&nbsp;</td>
         <td>&nbsp;</td>
         </tr>
         </table></td>
         <td>&nbsp;</td>
         </tr>
         </table> -->
      <div align="center">
         <?if($reseller == '') {?>
         <INPUT type="submit" align="center" value="Update" name="continue" class="button" id="continue" >
         <INPUT type="button" value="Back" name="continue" id="continue" class="button" onClick="javascript:location.href='showStandard.php'" >
         <?} else {?>
         <INPUT type="submit" align="center" value="Update" name="continue" class="button" id="continue" >
         <INPUT type="button" value="Back" name="continue" id="continue" class="button" onClick="javascript:location.href='showResellerStandard.php'" >
         <?}?>
      </div>
   </form>
   <div style="display:none;">
      <div align="center" >
         <h3> Check how your full Standard Offer proposal look like.</h3>
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
   <span class='mandatory'>* These Fields Are Mandatory </span>
</div>
<? include("footer.php"); ?>
<script language="JavaScript">
   //alert("sdfsfs");
   getCatImage('<?=$data[0]['category'
      ]?>');
</script>
<script language="JavaScript" src="client/js/jsImagePreview.js" type="text/javascript"></script>
<script>
   function langChange(lang,prodId,reseller)
   {
   if(reseller =='')
       {
   javascript:location.href = "editStandard.php?lang="+lang+"&productId="+prodId;
       } else {
           javascript:location.href = "editStandard.php?lang="+lang+"&productId="+prodId+"&from="+reseller;
       }
   }
</script>