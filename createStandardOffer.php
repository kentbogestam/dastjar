<?php
   /*  File Name  : standardOffer.php
    *  Description : Standard Offer Form
    *  Author      : Himanshu Singh  Date: 25th,Nov,2010  Creation
   */
   header('Content-Type: text/html; charset=utf-8');
   include_once("cumbari.php");
   //echo $_SESSION['userid'];
   $userId = $_SESSION['userid'];
   $standardObj = new offer();
   $compcont = $standardObj->companycountry();
   if ($compcont == 'Sweden') {
       $lang = 'SWE';
   }
   else {
       $lang = 'ENG';
   }
   //$standardObj->checkBudgetDetails();
   $listDishes = $standardObj->listDishes();
   // echo count($listDishes);
   // die();
   //print_r($listDishes); die();
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<link rel="stylesheet" href="client/css/stylesheet123.css" type="text/css">
    <link href="//stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet"
    href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.5.10/css/bootstrap-material-design.min.css"/>
    <link rel="stylesheet"
    href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.5.10/css/ripples.min.css"/>
    <link rel="stylesheet" href="client/css/bootstrap-material-datetimepicker.css" />
    <link href='//fonts.googleapis.com/css?family=Roboto:400,500' rel='stylesheet' type='text/css'>
    <link href="//fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	
<script language="JavaScript" src="client/js/jquery.bgiframe.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/ajaxuploadStand.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/jsStandardOffer.js" type="text/javascript"></script>
<!--<link rel="stylesheet" type="text/css" href="lib/vtip/css/vtip.css" />-->
<style type="text/css">
   img {
       border: 0
   }
   .center {
       width:900px;
    margin-left:auto;
    margin-right:auto;
   }
   
   tr{
	   margin-bottom: 10px;
   }
   
   	.dtp > .dtp-content > .dtp-date-view > header.dtp-header{
		background: #821015;
	}

	.dtp div.dtp-date, .dtp div.dtp-time {
		background: #a72626;
	}

  body{
    background-color: #fff; 
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
                     <td align="center" class="blackbutton">Add  Dish</td>
                  </tr>
                  <tr>
                     <td>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                           <tr>
                              <td>&nbsp;</td>
                           </tr>
                           <tr>
                              <td height="53" align="center"  class="redwhitebutton_small" style="padding-top:5px; text-align:center ">Add Dish</td>
                           </tr>
                        </table>
                     </td>
                  </tr>
                  <tr>
                     <td height="53">
                        <table width="100%" BORDER=0 cellpadding="0"  cellspacing="15">
                           <tr>
                              <td width="515" align="left" valign="top" class="inner_grid">Language:</td>
                              <td width="469"  align="left" valign="top">
                                 <select style="width:406px; background-color:#e4e3dd;" onChange="getLangImage(this.value);" class="text_field_new" name="lang" id="lang" >
                                    <option <? if ($lang == "SWE")echo "selected='selected'"; ?> value="SWE">Swedish</option>
                                    <option <? if ($lang == "ENG")echo "selected='selected'"; ?> value="ENG">English</option>
                                 </select>
                                 <div id='error_langStand' class="error"></div>
                              </td>
                              <td align="right" valign="middle"><a title="<?=SLANGUAGE_TEXT?>" class="vtip"><b><small>?</small></b></a> </td>
                           </tr>
                           <tr>
                              <td align="left" valign="top"  class="inner_grid">Dish Name<span class='mandatory'>*</span>:<br>
                              </td>
                              <td align="left" valign="top" >
                                 <INPUT class="text_field_new" type=text name="titleSloganStand" id="titleSloganStand" maxlength="50" onBlur="iconPreview(this.form); getTitleForProduct(this.form);standardPreview(this.form);" value="<?=isset($_SESSION['post']['titleSloganStand']) ? $_SESSION['post']['titleSloganStand'] : ''
                                    ?>">
                                 <div id='error_titleSloganStand' class="error" ></div>
                              </td>
                              <td align="right" valign="middle" ><a title="<?=STITLE_TEXT?>" class="vtip"><b><small>?</small></b></a> </td>
                           </tr>

                           <tr>
                              <td align="left" valign="top"  class="inner_grid">Description. Max. 50 characters<span class='mandatory'>*</span>:<br>
                              </td>
                              <td align="left" valign="top" >
                                 <INPUT class="text_field_new" type=text name="productDescription" id="productDescription" maxlength="150" onBlur="iconPreview(this.form);" value="<?=isset($_SESSION['post']['productDescription']) ? $_SESSION['post']['productDescription'] : ''
                                    ?>">
                                 <div id='error_productDescription' class="error" ></div>
                              </td>
                              <td align="right" valign="middle" ><a title="<?=STITLE_TEXT?>" class="vtip"><b><small>?</small></b></a> </td>
                           </tr>

                           <tr>
                              <td height="42" align="left">Dish Preparation Time<span class='mandatory'>*</span>:</td>
                              <td>
                                 <select class="text_field_new" style="background-color:#e4e3dd; width:406px; height:36px;border: 1px solid #abadb3;" tabindex="27" id="preparationTime" name="preparationTime">
                                    <option value="00:05:00">5 Minutes</option>
                                    <option value="00:10:00">10 Minutes</option>
                                    <option value="00:15:00">15 Minutes</option>
                                    <option value="00:20:00">20 Minutes</option>
                                    <option value="00:25:00">25 Minutes</option>
                                    <option value="00:30:00">30 Minutes</option>
                                    <option value="00:35:00">35 Minutes</option>
                                    <option value="00:40:00">40 Minutes</option>
                                    <option value="00:45:00">45 Minutes</option>
                                    <option value="00:50:00">50 Minutes</option>
                                    <option value="00:55:00">55 Minutes</option>
                                    <option value="00:59:00">59 Minutes</option>
                                 </select>
                              </td>
                           </tr>

                           <!-- <tr>
                              <td align="left" valign="top"  class="inner_grid">Dish Preparation Time<span class='mandatory'>*</span>:<br>
                              </td>
                              <td align="left" valign="top" >
                                 <INPUT class="text_field_new" type=time name="preparationTime" id="preparationTime" maxlength="19" onBlur="iconPreview(this.form);" value="<?=isset($_SESSION['post']['preparationTime']) ? $_SESSION['post']['preparationTime'] : ''
                                    ?>">
                                 <div id='error_preparationTime' class="error" ></div>
                              </td>
                              <td align="right" valign="middle" ><a title="<?=STITLE_TEXT?>" class="vtip"><b><small>?</small></b></a> </td>
                           </tr> -->
                           <tr style="display:none;"> </tr>
                           <tr style="display:none;">
                              <td align="left" valign="top" class="inner_grid">Price(with currency):</td>
                              <td align="left" valign="top"><INPUT class="text_field_new" type=text name="price" id="price"></td>
                              <td align="right" valign="middle"><a title="<?=PRICE_TEXT?>" class="vtip"><b><small>?</small></b></a> </td>
                           </tr>
                           <!-- <tr>
                              <td align="left" valign="top" class="inner_grid">Category<span class='mandatory'>*</span>:</td>
                              <td  align="left" valign="top">
                                 <div id="category_lang_div">
                                    <select  class="text_field_new" onChange="getCatImage(this.value, this.form);" style="width:406px; background-color:#e4e3dd;" tabindex="27" id="linkedCatStand" name="linkedCatStand" value="<?=$_SESSION['post']['linkedCat']
                                       ?>">
                                       <option <? if ($data[0]['category'] == ''
                                          )echo "selected='selected'"; ?> value="">Select Category</option>
                                       <? echo $standardObj->getCategoryList($_SESSION['post']['linkedCatStand'],$lang) ?>
                                    </select>
                                 </div>
                                 <input type="hidden" name="category_image" id="category_image" value="">
                                 <div id="category_image_div" style="display:none;"></div>
                                 <div id='error_linkedCatStand' class="error"></div>
                              </td>
                              <td align="right" valign="middle"><a title="<?=SCATEGORY_TEXT?>" class="vtip"><b><small>?</small></b></a> </td>
                           </tr> -->
                           <!-- <form action="" method="post" name="standard_use" id="standard_use" enctype="multipart/form-data">-->
                           <tr>
                              <td align="left" valign="top" class="inner_grid" style="line-height:25px;">Small icon <font size="2">(Icon must be in png or jpg format only e.g. icon.png.The size must be at least 45 x 60 pixels)</font></td>
                              <td align="left" valign="top">
                                 <div id="pre_image">
                                    <?php if (isset($_SESSION['preview']['small_image'])) {
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
                                 </div>
                              </td>
                              <td align="right" valign="top"><a title="<?=SICON_TEXT?>" class="vtip"><b><small>?</small></b></a> </td>
                           </tr>
                           <tr style="display:none;">
                              <td colspan="5" align="center" height="20"><strong>
                                 <button onClick="ajaxUpload(this.form,'classes/ajx/ajxUpload.php?filename=icon&amp;maxW=200','upload_area'); return false;">Click here</button>
                                 to check how your short standard offer proposal looks like</strong>
                              </td>
                           </tr>
                           <!-- </form>-->
                        </table>
                        <table  border="0" align="center" cellpadding="0" cellspacing="0">
                           <tr id="short_preview" style="display:inline;">
                              <td width="422" align="center" valign="top" style="background-image:url(client/images/iphone_large-3.png); width:270px; height:559px; background-repeat:no-repeat;">
                                 <div style="margin-top:100px; width:225px; margin-left:-50px; margin-right:auto;" >
                                    <table border="0" cellpadding="0" cellspacing="0">
                                       <tr>
                                          <td width="41"  align="left" style="padding-left:5px; padding-right:5px;">
                                             <div id="upload_area" style="vertical-align:top;"><img src="images/placeholder-image.png"  height = 30 width = 50 id="myCatIcon" name="myCatIcon"></div>
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
                        <br>
                        <div class="redwhitebutton_small123" style="display:none;">Describe how your Standard Offer should Behave</div>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="display:none;">
                           <tr>
                              <td width="50%" valign="top" class="td_pad_left">Sponsored Standard Offer<span class='mandatory'>*</span>:</td>
                              <td width="50%" class="td_pad_right">
                                 <select style="width:406px; background-color:#e4e3dd; border:#abadb3 solid 1px;" class="text_field_new"  tabindex="27" id="sponsStand"
                                    name="sponsStand">
                                    <option <? if (isset($_SESSION['post']['sponsStand']) == '0'
                                       )echo "selected='selected'"; ?> value="0">No</option>
                                    <option <? if (isset($_SESSION['post']['sponsStand']) == '1'
                                       )echo "selected='selected'"; ?> value="1">Yes</option>
                                 </select>
                                 <br>
                                 <span style="font-size:12px;"> (Price per view 0.01 kr)</span>
                                 <div id='error_sponsStand' class="error"></div>
                              </td>
                           </tr>
                        </table>
                        <div class="redwhitebutton_small123"><span style="cursor:pointer;" onClick="showAdvancedSearchStand();">Advanced Options-Optional</span></div>
                        <table border="0" width="100%">
                        </table>
                        <table width="100%" BORDER=0 cellpadding="0" cellspacing="0"  >
                           <tr>
                              <td width="50%" align="left" valign="top" class="td_pad_left">Keyword<span class='mandatory'>*</span></td>
                              <td width="50%" align="left" valign="top" class="td_pad_right">
                                 <table border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                       <td>
                                          <INPUT class="text_field_new" type=text name="searchKeywordStand" id="searchKeywordStand" maxlength="90">                             
                                          <div id='error_searchKeywordStand' class="error" ></div>
                                       </td>
                                    </tr>
                                 </table>
                              </td>
                              <td align="right" valign="middle"><a title="<?=SKEYWORD_TEXT?>" class="vtip"><b><small>?</small></b></a> </td>
                           </tr>
                           <!-- <tr>
                              <td width="50%" align="left" valign="top" class="td_pad_left">EAN Code:</td>
                              <td width="40%" align="left" valign="top" class="td_pad_right">
                                 <INPUT class="text_field_new" type=text name="eanCode" id="eanCode" value="<?=isset($_SESSION['post']['eanCode']) ? $_SESSION['post']['eanCode'] : ''
                                    ?>">
                                 <div id='error_eanCode' class="error" style="display:none"></div>
                              </td>
                              <td align="right" valign="middle"><a title="<?=SEAN_TEXT?>" class="vtip"><b><small>?</small></b></a> </td>
                           </tr> -->
                          <!--  <tr>
                              <td width="50%" align="left" valign="top" class="td_pad_left">Product Number:</td>
                              <td width="40%" align="left" valign="top" class="td_pad_right">
                                 <INPUT class="text_field_new" type=text name="productNumber" value="<?= isset($_SESSION['post']['productNumber']) ? $_SESSION['post']['productNumber'] : ''
                                    ?>" id="productNumber">
                                 <div id='error_productNumber' class="error" style="display:none"> </div>
                              </td>
                              <td align="right" valign="middle"><a title="<?=PRODUCTNUMBER_TEXT?>" class="vtip"><b><small>?</small></b></a> </td>
                           </tr> -->
                        </table>
               </table>
               </tr>
               <tr>
                  <td >
                     <div class="redwhitebutton_small123">Add your Coupon View</div>
                     <table width="100%" border="0">
                        <tr>
                           <td width="100%">
                              <table width="100%" BORDER=0 cellpadding="0" cellspacing="0" >
                                 <!-- <tr>
                                    <td width="50%" align="left" valign="top" class="td_pad_left">Large deal icon  <font size="2">(Image must be in jpeg or png format only e.g. image.png or image.jpg.The size must be at least 247 x 130 pixels)</font><span class='mandatory'>*</span> </td>
                                    <td width="50%" align="left" valign="top" class="td_pad_right">
                                       <table border="0" align="left" cellpadding="0" cellspacing="0">
                                          <tr>
                                             <td align="left" valign="top"><?php if (isset($_SESSION['preview']['large_image'])) {
                                                ?>
                                                <img style="display:none;" src="upload/coupon/<?=$_SESSION['preview']['large_image'] ?>">
                                                <input class="text_field_new" type="hidden" name="largeimage" id="largeimage" value="<?=$_SESSION['preview']['large_image'] ?>">
                                                <br>
                                                &nbsp;
                                                <?
                                                   }
                                                   ?>
                                                &nbsp;
                                                <INPUT type=file name="picture" id="picture" onBlur="picturePreview(this.form);" class="text_field_new123">
                                             </td>
                                             <td align="left" valign="middle" style="padding-left:10px;">
                                                <a title="<?=SPICTURE_TEXT
                                                   ?>" class="vtip"><b><small>?</small></b></a>
                                                <div id='error_picture' class="error" ></div>
                                             </td>
                                          </tr>
                                       </table>
                                    </td>
                                 </tr> -->
                                 <!--
                                    <tr>
                                    <td width="50%" align="left" valign="top" class="td_pad_left">Product Link:</td>
                                    <td width="50%" align="left" valign="top" class="td_pad_right"><table border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td><INPUT class="text_field_new" type=text name="descriptiveStand" id="descriptiveStand" maxlength="90"></td>
                                      <td style="padding-left:10px;"><a title="<?=SLINK_TEXT
                                       ?>" class="vtip"><b><small>?</small></b></a>
                                        <div id='error_descriptive' class="error" style="display:none"></div></td>
                                    </tr>
                                    </table></td>
                                    </tr>
                                    -->
                                 <tr>
                                    <?php
                                       $d = date("d/m/Y H:m");
                                        ?>
                                    <td width="50%" align="left" valign="top" class="td_pad_left">Release date of product<span class='mandatory'>*</span>:</td>
                                    <td width="50%" align="left" valign="top" class="td_pad_right">
                                       <table border="0" align="left" cellpadding="0" cellspacing="0">
                                          <tr>
                                             <td><input type="text" name="startDateStand" readonly="readonly" value="<? echo $d;
                                                ?>" id="startDateStand" class="startDateStand dp-applied text_field_new123" required/></td>
                                             <td style="padding-left:10px;"><a title="<?=RELEASE_DATE_OF_PRODUCT
                                                ?>" class="vtip"><b><small>?</small></b></a></td>
                                          </tr>
                                       </table>
                                       <div id='error_startDateStand' class="error"></div>
                                    </td>
                                 </tr>
                                  <tr>
                                    <td width="50%" align="left" valign="top" class="td_pad_left"><p>Type of Dish<span class='mandatory'>*</span></p><a style="font-size: 15px;vertical-align: top; cursor:pointer; text-decoration: underline;" id="add_tpye_of_dish">Add New Tpye Of Dish</a>:</td>
                                    <td width="50%" align="left" valign="top" class="td_pad_right">
                                      <?php $value = 0; ?>
                                      <div class="adddishes">
                                          <select id= "xx" name="select2" style="width:406px; background-color:#e4e3dd; border:#abadb3 solid 1px;" class="text_field_new" >
                                              <?php foreach($listDishes as $key =>$value) { ?>
                                                      <option value = <?php echo $value['dish_id']?> ><?php echo $value['dish_name']?></option>
                                              <?php } ?>
                                          </select>
                                          <div id='error_startDateStand' class="error"></div>
                                      </div>
                                    </td>
                                 </tr>
                                 <tr>
                                    <td colspan="4">
                                       <INPUT class="text_field_new" type="hidden" id="productName" name="productName" value="<?=$_SESSION['post']['productName']
                                          ?>" >
                                       <!-- <a title="<?=PRODUCTNAME_TEXT
                                          ?>" class="vtip"><b><small>?</small></b></a><br/>-->
                                       <div id='error_productName' class="error"></div>
                                    </td>
                                 </tr>
                                 <!-- <tr>
                                    <td width="50%" align="left" valign="top" class="td_pad_left"><input type="checkbox" name="publicProduct" id="publicProduct"
                                       <?
                                          if (isset($_SESSION['post']['publicProduct']) == 1) {
                                          
                                              echo 'checked="checked"';
                                          }
                                          ?>
                                       value="1" >
                                       Public product &nbsp; <a title="<?=PUBLIC_PRODUCT
                                          ?>" class="vtip"><b><small>?</small></b></a> 
                                    </td>
                                    <td width="458" colspan="4" align="left" valign="top">&nbsp;</td>
                                 </tr> -->
                              </table>
                           </td>
                        </tr>
                     </table>
                  </td>
               </tr>
               <tr>
                  <td>&nbsp;</td>
               </tr>
               <!-- <tr>
                  <div class="redwhitebutton_small123"><span style="cursor:pointer;" onClick="showAdvancedInfoPageStnad();">Add your Info Page</span></div>
               </tr> -->
               <!-- <tr>
                  <td >
                     <table width="100%" BORDER=0 cellpadding="0" cellspacing="0" id="infopageStand"  style="display:inline;">
                        <tr>
                           <td width="50%" align="left" class="td_pad_left">Link:</td>
                           <td width="50%" align="left" class="td_pad_right">
                              <table border="0" cellspacing="0" cellpadding="0">
                                 <tr>
                                    <td>
                                       <input type="text" class="text_field_new" name="link" id="link" value="<?=isset($_SESSION['post']['link']) ? $_SESSION['post']['link'] : ''
                                          ?>">
                                       <div id='error_link' class="error" ></div>
                                    </td>
                                    <td style="padding-left:15px;"><a title="<?=SLINK_TEXT?>" class="vtip"><b><small>?</small></b></a> </td>
                                 </tr>
                              </table>
                           </td>
                        </tr>
                     </table>
                  </td>
               </tr> -->
               </table>
            </div>
            <div align="center"> <br />
               <br />
               <INPUT type="submit" value="Continue" name="continue" id="continue" class="button" >
               <br />
               <br />
            </div>
            <span class='mandatory'>* These Fields Are Mandatory</span> 
         </div>
      </form>
   </div>
   <div id="addDishType-popup" style="display: none;" class="login-popup" data-theme="a">
     <div class="inner-popup">
           <div id = "cancel-popup" class="cross">
              <img src="client/images/cross.png" />
           </div>
           <div class="pop-body">
              <div class="form-group">
                 <label>Language :</label>
                 <select id = "txtDishLanguage">
                     <option value="ENG">English</option>
                     <option value="SWE">Swedish</option>
                 </select>
              </div>
              <div style="display: none;">
                   <select id = "Userdetail">
                     <option value = <?php echo $userId ?> ></option>
                 </select>
              </div>

               <div class="form-group">
                 <label>Type Of Dish :</label>
                 <input id="txtDishType" type="text" />
              </div>
              <div class="form-group">
                 <input type="submit" value="Continue" name="continue" id="submit-btn" class="form-submit-btn">
               </div>
           </div>
     </div>
   </div>
   <? include("footer.php"); ?>
</body>

    <script src="//stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.5.10/js/ripples.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.5.10/js/material.min.js"></script>
<script type="text/javascript" src="//rawgit.com/FezVrasta/bootstrap-material-design/master/dist/js/material.min.js"></script>
<script type="text/javascript" src="//momentjs.com/downloads/moment-with-locales.min.js"></script>
<script type="text/javascript" src="client/js/bootstrap-material-datetimepicker.js"></script>

<script type="text/javascript">
        $(document).ready(function(){
            $('#startDateStand').bootstrapMaterialDatePicker
            ({
                weekStart: 0, format: 'DD/MM/YYYY HH:mm',  shortTime : true, clearButton: true
            });

            $.material.init();
        });
		
   $("#icon").change(function() {
     readURL(this);
   });

   function readURL(input) {

   if (input.files && input.files[0]) {
       var reader = new FileReader();

       reader.onload = function(e) {
         $('#myCatIcon').attr('src', e.target.result);
       }

       reader.readAsDataURL(input.files[0]);
     }
   }

   $('#add_tpye_of_dish').click(function(){
      $('#addDishType-popup').show();
   });

   $("#cancel-popup").click(function () {
       $('#addDishType-popup').hide();
     });

   $(function(){
      $('[id*=submit-btn]').click(function(){
         var dataString = 'Languang='+$('[id*=txtDishLanguage]').val()+'&DishType='+$('[id*=txtDishType]').val()+'&userId='+$('[id*=Userdetail]').val();
         console.log(dataString);
         $.ajax({
            type: "POST",
            url: "saveAction.php?",
            data: dataString,
            success: function (response) {
               $data = JSON.parse(response);
               //console.log($data);

               var str = ""

               for(var i =0;i<$data.length;i++){
                  console.log($data[i]["dish_name"]);
               str += "<option value="+$data[i]["dish_id"]+">"+$data[i]["dish_name"]+"</option>";
               }

               str += "<option value='addNewDishTpye'> Add Type Of Dish </option>";

               $("#xx").html(str);

               $('#addDishType-popup').hide();

            },
            failure: function (response) {
               alert(response.responseText);
            },
            error: function (response) {
               alert(response.responseText);
            }
         });
      });
   });
      
</script>
<script language="JavaScript" src="client/js/jsImagePreview.js" type="text/javascript"></script>

<style type="text/css">
   .login-popup {
    background: rgba(0, 0, 0, 0.25);
    position: fixed;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
}
.login-popup .inner-popup {
    width: 500px;
    background: #fff;
    top: 30%;
    position: absolute;
    left: 50%;
    transform: translate(-50% , -50%);
    border-radius: 10px;
    padding: 15px;
}
.cross {
    position: absolute;
    top: -5px;
    right: -5px;
}
.cross img {
    width: 18px
}

.login-popup .inner-popup p {
    margin: 0;
    padding: 0;
}
.login-popup .inner-popup .form-group{
   margin-bottom: 10px;
}
.login-popup .inner-popup label{
   display: inline-block; width: 40%; font-size: 14px; 
}
.login-popup .inner-popup select, .login-popup .inner-popup input[type="text"]{
   width: 40%;
   background: #efefefc4;
   height: 30px;
    border: 1px solid #ccc;
}
.login-popup .inner-popup input{
   padding-left: 5px; box-sizing: border-box;
}
.login-popup  .pop-body{
   margin-top: 10px;
}
input.form-submit-btn{
   color: #FFFFFF;
    border: none;
    font-size: 18px;
    background:#721a1e;
    width: 151px;
    height: 41px;
    background-repeat: no-repeat;
    font-weight: bold;
    cursor: pointer;
    display: block;
    margin: 25px auto 0;
    border-radius: 10px;
}
</style>
