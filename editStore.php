<?php
   /*  File Name  : editStore.php
    *  Description : Edit Store Form
    *  Author      : Deo  Date: 17th,Dec,2010  Creation
    */
   header('Content-Type: text/html; charset=utf-8');
   include_once("cumbari.php");
   $inoutObj = new inOut();
   $storeObj = new store();
   $regObj = new registration();
   $countryList = $regObj->getCountryList();
   $openCloseingTime = $storeObj->listTimeing();
   if (isset($_POST['continue'])) {
       //echo "In"; die();
       $storeObj->svrStoreDflt();
   } else {
       $storeid = $_GET['storeId']; //die();
       $data = $storeObj->getStoreDetailById($storeid);
   //echo "<pre>";print_r($data);echo "</pre>";
   }
   $openCloseList = explode(",",$data[0]['store_open_close_day_time']);
   foreach ($openCloseList as $key => $value) {
      $getDay = explode("::",$value);
      if(strcmp($getDay[0],ALL)==1){
        $getTime = explode("to",$getDay[1]);
        $allDayOpen = $getTime[0];
        $allDayClose = $getTime[1];
      }
      if(strcmp($getDay[0],MON)==1){
        $getTime = explode("to",$getDay[1]);
        $monDayOpen = $getTime[0];
        $monDayClose = $getTime[1];
      }
      if(strcmp($getDay[0],TUE)==1){
        $getTime = explode("to",$getDay[1]);
        $tueDayOpen = $getTime[0];
        $tueDayClose = $getTime[1];
      }
      if(strcmp($getDay[0],WED)==1){
        $getTime = explode("to",$getDay[1]);
        $wedDayOpen = $getTime[0];
        $wedDayClose = $getTime[1];
      }
      if(strcmp($getDay[0],THU)==1){
        $getTime = explode("to",$getDay[1]);
        $thuDayOpen = $getTime[0];
        $thuDayClose = $getTime[1];
      }
      if(strcmp($getDay[0],FRI)==1){
        $getTime = explode("to",$getDay[1]);
        $friDayOpen = $getTime[0];
        $friDayClose = $getTime[1];
      }
      if(strcmp($getDay[0],SAT)==1){
        $getTime = explode("to",$getDay[1]);
        $satDayOpen = $getTime[0];
        $satDayClose = $getTime[1];
      }
      if(str_replace(' ', '', $getDay[0]) == SUN){
        $getTime = explode("to",$getDay[1]);
        $sunDayOpen = $getTime[0];
        $sunDayClose = $getTime[1];
      }
   }
    // "<pre>";print_r($allDayOpen);echo "</pre>";
    // "<pre>";print_r($allDayClose);echo "</pre>";
    // "<pre>";print_r($monDayOpen);echo "</pre>";
    // "<pre>";print_r($monDayClose);echo "</pre>";
    // "<pre>";print_r($tueDayOpen);echo "</pre>";
    // "<pre>";print_r($tueDayClose);echo "</pre>";
    // "<pre>";print_r($wedDayOpen);echo "</pre>";
    // "<pre>";print_r($wedDayClose);echo "</pre>";
    // "<pre>";print_r($thuDayOpen);echo "</pre>";
    // "<pre>";print_r($thuDayClose);echo "</pre>";
    // "<pre>";print_r($friDayOpen);echo "</pre>";
    // "<pre>";print_r($friDayClose);echo "</pre>";
    // "<pre>";print_r($satDayOpen);echo "</pre>";
    // "<pre>";print_r($satDayClose);echo "</pre>";
    // "<pre>";print_r($sunDayOpen);echo "</pre>";
    // "<pre>";print_r($sunDayClose);echo "</pre>";
   //die();
   //echo "<pre>";print_r($data);echo "</pre>";die();
   if ($data[0]['latitude'] && $data[0]['longitude']) {
       $latitude = $data[0]['latitude'];
       $longitude = $data[0]['longitude'];
   } else {
       $latitude = "64.396938";
       $longitude = "16.699219";
   }
   $zoom = "18";
   $menu = "store";
   $menu = 'class="selected"';
   if ($_GET['m'] == "showOutdatedStore")
       $deleted = 'class="selected"';
   else
       $show = 'class="selected"';
   include_once("main.php");
   ?>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyByLiizP2XW9JUAiD92x57u7lFvU3pS630&sensor=false"></script>
<script language="JavaScript" src="client/js/jsStoreEdit.js" type="text/javascript"></script>

<script type="text/javascript" src="client/js/newJs/jquery-1.11.1.js"></script>
<link rel="stylesheet" type="text/css" href="client/js/newJs/mdp.css">
 
<script type="text/javascript" src="client/js/newJs/jquery-ui.min.js"></script>
<script type="text/javascript" src="client/js/newJs/jquery-ui.multidatespicker.js"></script>

<style type="text/css">
   <!--
      .center{width:900px; margin-left:auto; margin-right:auto;}
      -->
</style>
<body>
   <div class="center">
      <form name="registerform" action="" id="registerform" method="Post">
        <input type="hidden" name="opencloseTimeing" value="" id="opencloseTimeing">
         <input type="hidden" name="m" value="editSaveStore">
         <input type="hidden" name="storeId" value="<?=$storeId
            ?>">
         <input type="hidden" name="s" value="<?=$_REQUEST['s']?>">
         <div class="redwhitebutton123">Edit Location</div>
         <table BORDER=0 width="100%" cellspacing="18">
            <tr>
               <td width="592" class="inner_grid">Name of location 
                  <span class='mandatory'>*</span>:
               </td>
               <td width="415" >
                  <INPUT class="text_field_new"  type=text name="storeName" id ="storeName" value="<?=$data[0]['store_name']
                     ?>">
                  <div id='error_storeName' class="error"></div>
               </td>
               <td align="right"><a title="<?=NAME_OF_LOCATION_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
            </tr>
            <tr>
               <td class="inner_grid">E-mail<span class='mandatory'>*</span>:</td>
               <td>
                  <INPUT class="text_field_new" type=text name="email" value="<?=$data[0]['email']
                     ?>" id ="email">
                  <div id='error_email' class="error"></div>
               </td>
               <td align="right"><a title="<?=STORE_EMAIL_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
            </tr>
            <tr>
               <td class="inner_grid">Phone Number<span class='mandatory'>*</span>:</td>
               <td>
                  <INPUT class="text_field_new" type=text name="phoneNo"  value="<?=$data[0]['phone']
                     ?>" id ="phoneNo">
                  <div id='error_phoneNo' class="error"></div>
               </td>
               <td align="right"><a title="<?=PHONE_NUMBER_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
            </tr>
            <tr>
               <td class="inner_grid">Street Address<span class='mandatory'>*</span>:</td>
               <td>
                  <INPUT class="text_field_new" type=text name="streetaddStore" id ="streetaddStore" value="<?=$data[0]['street']
                     ?>" onChange="initialize()">
                  <div id='error_streetaddStore' class="error" ></div>
               </td>
               <td align="right"><a title="<?=STREET_ADDRESS_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
            </tr>
            <tr>
               <td class="inner_grid">City<span class='mandatory'>*</span>:</td>
               <td>
                  <INPUT class="text_field_new" type=text name="cityStore" id ="cityStore" value="<?=$data[0]['city']
                     ?>" onChange="initialize()">
                  <div id='error_cityStore' class="error" ></div>
               </td>
               <td align="right"><a title="<?=CITY_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
            </tr>
            <tr>
               <td class="inner_grid">Country<span class='mandatory'>*</span>:</td>
               <td>
                  <select class="text_field_new" style="width:406px; background-color:#e4e3dd;"  tabindex="27"   name="countryStore" id ="countryStore" value="<?=$data[0]['country']
                     ?>" onChange="initialize()" >
                     <option value="">Select</option>
                     <?php
                        $countryCode = $data[0]['country'];
                        if(empty($countryCode))
                        {
                          $countryCode='SE';
                        }
                        
                        foreach($countryList as $key=>$value)
                        {
                        
                        ?>
                     <option value="<?=$value?>" <?php if($countryCode==$value){ echo 'selected=selected'; } ?>><?=$value?></option>
                     <?php
                        }
                        ?>
                  </select>
                  <div id='error_countryStore' class="error" ></div>
               </td>
               <td align="right"><a title="<?=COUNTRY_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
            </tr>
            <tr>
               <td class="inner_grid">Chain:</td>
               <td>
                  <INPUT class="text_field_new" type=text name="chain" id ="chain" value="<?=$data[0]['chain']
                     ?>" >
                  <div id='error_chain' class="error" ></div>
               </td>
               <td align="right"><a title="<?=CHAIN_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
            </tr>
            <tr>
               <td class="inner_grid">Block:</td>
               <td>
                  <INPUT class="text_field_new" type=text name="block" id ="block" value="<?=$data[0]['block']
                     ?>" >
                  <div id='error_block' class="error" ></div>
               </td>
               <td align="right"><a title="<?=BLOCK_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
            </tr>
            <tr>
               <td class="inner_grid">Zip:</td>
               <td>
                  <INPUT class="text_field_new" type=text name="zip" id ="zip" value="<?=$data[0]['zip']
                     ?>" >
                  <div id='error_zip' class="error" ></div>
               </td>
               <td align="right"><a title="<?=ZIP_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
            </tr>
            <!-- <tr>
               <td class="inner_grid"> Select a method for receiving <br />
                  Coupon data<span class='mandatory'>*</span>:
               </td>
               <?  $barcode = $storeObj->getCouponDeliveryById($storeid);
                  $dps = $storeObj->getCouponDeliveryByIdDPS($storeid); 
                  if( $barcode == 'BARCODE')
                    {
                        $check = 'checked';
                    }else
                    {
                        $check = '';
                    } 
                  ?>
               <td>
                  <table border="0" cellspacing="0" cellpadding="0">
                     <tr>
                        <td><input type="checkbox" name="BARCODE" value="BARCODE"  <? echo $check; ?> />BARCODE</td>
                        <td><input type="checkbox" name="DPS" value="DPS" <?=($dps == "DPS"?"checked":"")?> />DPS</td>
                        <td><input type="checkbox" name="PINCODE" value="PINCODE" disabled  checked />PINCODE</td>
                     </tr>
                     <tr>
                        <td nowrap="nowrap"><input type="checkbox" name="MANUAL_SWIPE" value="MANUAL_SWIPE" disabled checked />MANUAL SWIPE</td>
                        <td nowrap="nowrap"><input type="checkbox" name="TIME_LIMIT" value="TIME_LIMIT" disabled checked />TIME LIMIT</td>
                        <td >&nbsp;</td>
                     </tr>
                  </table>
               </td>
               <td align="right"><a title="<?=METHOD_FOR_RECEIVING_COUPON_DATA_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
            </tr> -->
            <tr>
               <td height="42" align="left">Opening hours of the Location </td>
                <td>
                  <table class="days_div" border="0" cellspacing="0" cellpadding="0">
                    <label><a style="font-size: 15px;vertical-align: top; cursor:pointer; text-decoration: underline;" id="add_tpye_of_dish">Location is open following days of the week</a></label></label>
                    <!--  <tr>
                        <td><input type="checkbox" name="Monday" <? if (explode(",",$data[0]['store_open_days'])[0] == 'Mon')echo "checked"; ?> value="Mon"/>Monday</td>
                        <td><input type="checkbox" name="Tuesday"  <? if (explode(",",$data[0]['store_open_days'])[1] == 'Tue')echo "checked"; ?> value="Tue" />Tuesday</td>
                        <td><input type="checkbox" name="Wednesday"  <? if (explode(",",$data[0]['store_open_days'])[2] == 'Wed')echo "checked"; ?> value="Wed" />Wednesday</td>
                     </tr>
                     <tr>
                        <td ><input type="checkbox" name="Thursday"  <? if (explode(",",$data[0]['store_open_days'])[3] == 'Thu')echo "checked"; ?> value="Thu" />Thursday</td>
                        <td><input type="checkbox" name="Friday"  <? if (explode(",",$data[0]['store_open_days'])[4] == 'Fri')echo "checked"; ?> value="Fri"/>Friday</td>
                        <td><input type="checkbox" name="Saturday"  <? if (explode(",",$data[0]['store_open_days'])[5] == 'Sat')echo "checked"; ?> value="Sat"/>Saturday</td>
                        <td >&nbsp;</td>
                     </tr>
                      <tr>
                        <td><input type="checkbox" name="Sunday"  <? if (explode(",",$data[0]['store_open_days'])[6] == 'Sun')echo "checked"; ?> value="Sun"/>Sunday</td>
                     </tr> -->
                  </table>
               </td>
               <!-- <td><label>Location opens at</label>
                  <select class="text_field_new" style="background-color:#e4e3dd; width:406px; height:36px;border: 1px solid #abadb3;" tabindex="27" id="storeOpenTime" name="storeOpenTime">
                    <?php foreach($openCloseingTime as $key =>$value) { ?>
                            <option <? if ($data[0]['store_open'] == $value['close_time'])echo "selected='selected'"; ?>   value=<?php echo $value['close_time']?> ><?php echo $value['close_time']?></option>
                    <?php } ?>
                  </select>
               </td> -->
            </tr>
            <!-- <tr>
               <td></td>
                <td><label>Location closes at</label>
                  <select class="text_field_new" style="background-color:#e4e3dd; width:406px; height:36px;border: 1px solid #abadb3;" tabindex="27" id="storeCloseTime" name="storeCloseTime">
                     <?php foreach($openCloseingTime as $key =>$value) { ?>
                              <option <? if ($data[0]['store_close'] == $value['close_time'])echo "selected='selected'"; ?>   value=<?php echo $value['close_time']?> ><?php echo $value['close_time']?></option>
                      <?php } ?>
                  </select>
               </td> 
            </tr> -->
            <!--  <tr>
               <td class="inner_grid">
               </td>
               <td>
                  <table class="days_div" border="0" cellspacing="0" cellpadding="0">
                    <label><a style="font-size: 15px;vertical-align: top; cursor:pointer; text-decoration: underline;" id="add_tpye_of_dish">Location is open following days of the week</a></label></label>
                     <tr>
                        <td><input type="checkbox" name="Monday" <? if (explode(",",$data[0]['store_open_days'])[0] == 'Mon')echo "checked"; ?> value="Mon"/>Monday</td>
                        <td><input type="checkbox" name="Tuesday"  <? if (explode(",",$data[0]['store_open_days'])[1] == 'Tue')echo "checked"; ?> value="Tue" />Tuesday</td>
                        <td><input type="checkbox" name="Wednesday"  <? if (explode(",",$data[0]['store_open_days'])[2] == 'Wed')echo "checked"; ?> value="Wed" />Wednesday</td>
                     </tr>
                     <tr>
                        <td ><input type="checkbox" name="Thursday"  <? if (explode(",",$data[0]['store_open_days'])[3] == 'Thu')echo "checked"; ?> value="Thu" />Thursday</td>
                        <td><input type="checkbox" name="Friday"  <? if (explode(",",$data[0]['store_open_days'])[4] == 'Fri')echo "checked"; ?> value="Fri"/>Friday</td>
                        <td><input type="checkbox" name="Saturday"  <? if (explode(",",$data[0]['store_open_days'])[5] == 'Sat')echo "checked"; ?> value="Sat"/>Saturday</td>
                        <td >&nbsp;</td>
                     </tr>
                      <tr>
                        <td><input type="checkbox" name="Sunday"  <? if (explode(",",$data[0]['store_open_days'])[6] == 'Sun')echo "checked"; ?> value="Sun"/>Sunday</td>
                     </tr>
                  </table>
               </td>
               <td align="right"><a title="<?=METHOD_FOR_RECEIVING_COUPON_DATA_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
            </tr> -->
            <tr>
              <td>Location is close following dates</td>
               <td style="position: relative;">
                  <div id="with-altField1"><span class="cross"><img src="client/js/newJs/images/error.png"></span></div>
                 <div id="with-altField1"></div>
                  <div id="withAltField1" class="box">
                   <img class="cal_icon" id="cal_icon" src="client/js/newJs/images/calendar.gif">   <input class="text_field_new" type="text" id="altField1" name="altField1" value="<?=$data[0]['store_close_dates']?>">
                   <label><?=$data[0]['store_close_dates']?></label>
                  </div>
               </td>
            </tr>
            <tr>
               <td class="inner_grid">Link to the location home<span class='mandatory'>*</span>:</td>
               <td>
                  <INPUT class="text_field_new" type=text name="link"  value="<?=$data[0]['store_link']
                     ?>" id ="link" >
                  <div id='error_link' class="error"></div>
               </td>
               <td align="right"><a title="<?=LINK_TO_THE_LOCATION_HOME_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
            </tr>
            <tr>
               <td height="42" align="left">Type of Restaurant                </td>
               <td>
                  <select class="text_field_new" style="background-color:#e4e3dd; width:406px; height:36px;border: 1px solid #abadb3;" tabindex="27" id="typeofrestrurant" name="typeofrestrurant">
                     <option <? if ($data[0]['store_type'] == '1')echo "selected='selected'"; ?>   value="1">Eat Now</option>
                     <option <? if ($data[0]['store_type'] == '2')echo "selected='selected'"; ?>   value="2">Eat Later</option>
                     <option <? if ($data[0]['store_type'] == '3')echo "selected='selected'"; ?>   value="3">Both</option>
                  </select>
               </td>
            </tr>
            <tr>
               <td class="inner_grid"></td>
               <td>
                  <input class="text_field_new" type="hidden" name="latitude" id="latitude" value="<?=$data[0]['latitude']
                     ?>"/><input class="text_field_new" type="hidden" name="longitude" id="longitude" value="<?=$data[0]['longitude']
                     ?>" />
                  <input class="text_field_new" name="zoom" id="zoom" value="<?=$zoom
                     ?>" type="hidden" style="width:150px;" />
                  <div id='error_coordinate' class="error"></div>
               </td>
            </tr>
            <tr>
               <td width="592" valign="top">Map
                  <span class='mandatory'>*</span>:
               </td>
               <td>
                  <div id="map_canvas" style="height:320px; width:400px; border: 1px solid #99999b;"></div>
               </td>
               <td align="right" valign="top"><a title="<?=MAP_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
            </tr>
            <tr>
               <td></td>
               <td>You can set your location on map by click or drag</td>
            </tr>
           <!--  <tr>
               <td>Uplod Image For Restaurent<span class='mandatory'>*</span>:</td>
               <td>
                  <div class="file-upload">
                     <button class="file-upload-btn" type="button" onclick="$('.file-upload-input').trigger( 'click' )">Add Image</button>
                     <div class="image-upload-wrap">
                        <input class="file-upload-input" type='file' id="imageStore" name="imageStore" onBlur="iconPreview(this.form);"  onchange="readURL(this);" accept="image/" />
                        <div class="drag-text">
                           <h3>Drag and drop a file or select add Image</h3>
                           <samp>Please uplode only png Image</samp>
                        </div>
                     </div>
                     <div class="file-upload-content">
                        <img class="file-upload-image" src="#" alt="your image" />
                        <div class="image-title-wrap">
                           <button type="button" onclick="removeUpload()" class="remove-image">Remove <span class="image-title">Uploaded Image</span></button>
                        </div>
                     </div>
                  </div>
                  <div id='error_storeImage' class="error"></div>
               </td>
            </tr> -->
         </table>
         <div align="center"><br />
            <br />
            <INPUT type="submit" value="Update" name="continue" class="button" id="continue" >
            <INPUT type="button" value="Back" name="" class="button"  id="continue" onClick="javascript:location.href='<?=$_SERVER[HTTP_REFERER]
               ?>';" >
            <br />
            <br />
         </div>
      </form>
      <span class='mandatory'>* These Fields Are Mandatory </span>
   </div>
    <div id="addDishType-popup" style="display: none;" class="login-popup" data-theme="a">
     <div class="inner-popup">
           <div id = "cancel-popup" class="cross1">
              <img src="client/images/cross.png" />
           </div>
           <div class="pop-body">
            <div>
               <input type="radio" name="openingDays" checked value="1"> All Days<br>
               <input type="radio" name="openingDays" value="2"> Week Days<br>
            </div>

            <div class="all1">
              <div class="label_space">
                  <label for="working_hours" class="control-label">
                      Allday:
                  </label>
              </div>
              <div class="row_half">
                  <div class=" mobile_margin">
                      <label for="working_hours" class=" control-label">
                          Opening Time: 
                      </label>
                      <div class="select_time">
                          <div class='input-group date' id='datetimepicker3'>
                             <select id = "allOpen">

                                <?php foreach($openCloseingTime as $key =>$value) { ?>
                                        <option <? if (str_replace(':', '', str_replace(' ', '', $allDayOpen)) == str_replace(':', '', $value['close_time']))echo "selected='selected'"; ?> value = <?php echo $value['close_time']?> ><?php echo $value['close_time']?></option>
                                <?php } ?>
                             </select>
                          </div>
                      </div>
                  </div>
                  <div class=" mobile_margin">
                      <label for="working_hours" class=" control-label">
                          Closing Time: 
                      </label>
                      <div class="select_time">
                          <div class='input-group date' id='datetimepicker3'>
                               <select id = "allClose">
                                <?php foreach($openCloseingTime as $key =>$value) { ?>
                                        <option <? if (str_replace(':', '', $allDayClose) == str_replace(':', '', $value['close_time']))echo "selected='selected'"; ?> value = <?php echo $value['close_time']?> ><?php echo $value['close_time']?></option>
                                <?php } ?>
                             </select>
                          </div>
                      </div>
                  </div>
              </div>
            </div>

            <div class="all2" style="display: none;">
              <div class="label_space">
                  <label for="working_hours" class="control-label">
                      Monday:
                  </label>
              </div>
                <div class="row_half">
                    <div class=" mobile_margin">
                        <label for="working_hours" class=" control-label">
                            Opening Time: 
                        </label>
                        <div class="select_time">
                            <div class='input-group date' id='datetimepicker3'>
                               <select id = "monOpen">
                                  <?php foreach($openCloseingTime as $key =>$value) { ?>
                                          <option <? if (str_replace(':', '', str_replace(' ', '', $monDayOpen)) == str_replace(':', '', $value['close_time']))echo "selected='selected'"; ?> value = <?php echo $value['close_time']?> ><?php echo $value['close_time']?></option>
                                  <?php } ?>
                               </select>
                            </div>
                        </div>
                    </div>
                    <div class=" mobile_margin">
                        <label for="working_hours" class=" control-label">
                            Closing Time: 
                        </label>
                        <div class="select_time">
                            <div class='input-group date' id='datetimepicker3'>
                                 <select id = "monClose">
                                  <?php foreach($openCloseingTime as $key =>$value) { ?>
                                          <option <? if (str_replace(':', '', $monDayClose) == str_replace(':', '', $value['close_time']))echo "selected='selected'"; ?> value = <?php echo $value['close_time']?> ><?php echo $value['close_time']?></option>
                                  <?php } ?>
                               </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="label_space">
                  <label for="working_hours" class="control-label">
                      Tuesday:
                  </label>
                  </div>
                    <div class="row_half">
                        <div class=" mobile_margin">
                            <label for="working_hours" class=" control-label">
                                Opening Time: 
                            </label>
                            <div class="select_time">
                                <div class='input-group date' id='datetimepicker3'>
                                   <select id = "tueOpen">
                                      <?php foreach($openCloseingTime as $key =>$value) { ?>
                                              <option <? if (str_replace(':', '', str_replace(' ', '', $tueDayOpen)) == str_replace(':', '', $value['close_time']))echo "selected='selected'"; ?> value = <?php echo $value['close_time']?> ><?php echo $value['close_time']?></option>
                                      <?php } ?>
                                   </select>
                                </div>
                            </div>
                        </div>
                        <div class=" mobile_margin">
                            <label for="working_hours" class=" control-label">
                                Closing Time: 
                            </label>
                            <div class="select_time">
                                <div class='input-group date' id='datetimepicker3'>
                                     <select id = "tueClose">
                                      <?php foreach($openCloseingTime as $key =>$value) { ?>
                                              <option <? if (str_replace(':', '', $tueDayClose) == str_replace(':', '', $value['close_time']))echo "selected='selected'"; ?> value = <?php echo $value['close_time']?> ><?php echo $value['close_time']?></option>
                                      <?php } ?>
                                   </select>
                                </div>
                            </div>
                        </div>
                    </div>
                 <div class="label_space">
                  <label for="working_hours" class="control-label">
                      Wednesday:
                  </label>
              </div>
                <div class="row_half">
                    <div class=" mobile_margin">
                        <label for="working_hours" class=" control-label">
                            Opening Time: 
                        </label>
                        <div class="select_time">
                            <div class='input-group date' id='datetimepicker3'>
                               <select id = "wedOpen">
                                  <?php foreach($openCloseingTime as $key =>$value) { ?>
                                          <option <? if (str_replace(':', '', str_replace(' ', '', $wedDayOpen)) == str_replace(':', '', $value['close_time']))echo "selected='selected'"; ?> value = <?php echo $value['close_time']?> ><?php echo $value['close_time']?></option>
                                  <?php } ?>
                               </select>
                            </div>
                        </div>
                    </div>
                    <div class=" mobile_margin">
                        <label for="working_hours" class=" control-label">
                            Closing Time: 
                        </label>
                        <div class="select_time">
                            <div class='input-group date' id='datetimepicker3'>
                                 <select id = "wedClose">
                                  <?php foreach($openCloseingTime as $key =>$value) { ?>
                                          <option <? if (str_replace(':', '', $wedDayClose) == str_replace(':', '', $value['close_time']))echo "selected='selected'"; ?> value = <?php echo $value['close_time']?> ><?php echo $value['close_time']?></option>
                                  <?php } ?>
                               </select>
                            </div>
                        </div>
                    </div>
                </div>
                 <div class="label_space">
                  <label for="working_hours" class="control-label">
                      Thursday:
                  </label>
              </div>
                <div class="row_half">
                    <div class=" mobile_margin">
                        <label for="working_hours" class=" control-label">
                            Opening Time: 
                        </label>
                        <div class="select_time">
                            <div class='input-group date' id='datetimepicker3'>
                               <select id = "thuOpen">
                                  <?php foreach($openCloseingTime as $key =>$value) { ?>
                                          <option <? if (str_replace(':', '', str_replace(' ', '', $thuDayOpen)) == str_replace(':', '', $value['close_time']))echo "selected='selected'"; ?> value = <?php echo $value['close_time']?> ><?php echo $value['close_time']?></option>
                                  <?php } ?>
                               </select>
                            </div>
                        </div>
                    </div>
                    <div class=" mobile_margin">
                        <label for="working_hours" class=" control-label">
                            Closing Time: 
                        </label>
                        <div class="select_time">
                            <div class='input-group date' id='datetimepicker3'>
                                 <select id = "thuClose">
                                  <?php foreach($openCloseingTime as $key =>$value) { ?>
                                          <option <? if (str_replace(':', '', $thuDayClose) == str_replace(':', '', $value['close_time']))echo "selected='selected'"; ?> value = <?php echo $value['close_time']?> ><?php echo $value['close_time']?></option>
                                  <?php } ?>
                               </select>
                            </div>
                        </div>
                    </div>
                </div>
                 <div class="label_space">
                  <label for="working_hours" class="control-label">
                      Friday:
                  </label>
              </div>
                <div class="row_half">
                    <div class=" mobile_margin">
                        <label for="working_hours" class=" control-label">
                            Opening Time: 
                        </label>
                        <div class="select_time">
                            <div class='input-group date' id='datetimepicker3'>
                               <select id = "friOpen">
                                  <?php foreach($openCloseingTime as $key =>$value) { ?>
                                          <option <? if (str_replace(':', '', str_replace(' ', '', $friDayOpen)) == str_replace(':', '', $value['close_time']))echo "selected='selected'"; ?> value = <?php echo $value['close_time']?> ><?php echo $value['close_time']?></option>
                                  <?php } ?>
                               </select>
                            </div>
                        </div>
                    </div>
                    <div class=" mobile_margin">
                        <label for="working_hours" class=" control-label">
                            Closing Time: 
                        </label>
                        <div class="select_time">
                            <div class='input-group date' id='datetimepicker3'>
                                 <select id = "friClose">
                                  <?php foreach($openCloseingTime as $key =>$value) { ?>
                                          <option <? if (str_replace(':', '', $friDayClose) == str_replace(':', '', $value['close_time']))echo "selected='selected'"; ?> value = <?php echo $value['close_time']?> ><?php echo $value['close_time']?></option>
                                  <?php } ?>
                               </select>
                            </div>
                        </div>
                    </div>
                </div>
                 <div class="label_space">
                  <label for="working_hours" class="control-label">
                      Saturday:
                  </label>
              </div>
                <div class="row_half">
                    <div class=" mobile_margin">
                        <label for="working_hours" class=" control-label">
                            Opening Time: 
                        </label>
                        <div class="select_time">
                            <div class='input-group date' id='datetimepicker3'>
                               <select id = "satOpen">
                                  <?php foreach($openCloseingTime as $key =>$value) { ?>
                                          <option <? if (str_replace(':', '', str_replace(' ', '', $satDayOpen)) == str_replace(':', '', $value['close_time']))echo "selected='selected'"; ?> value = <?php echo $value['close_time']?> ><?php echo $value['close_time']?></option>
                                  <?php } ?>
                               </select>
                            </div>
                        </div>
                    </div>
                    <div class=" mobile_margin">
                        <label for="working_hours" class=" control-label">
                            Closing Time: 
                        </label>
                        <div class="select_time">
                            <div class='input-group date' id='datetimepicker3'>
                                 <select id = "satClose">
                                  <?php foreach($openCloseingTime as $key =>$value) { ?>
                                          <option <? if (str_replace(':', '', $satDayClose) == str_replace(':', '', $value['close_time']))echo "selected='selected'"; ?> value = <?php echo $value['close_time']?> ><?php echo $value['close_time']?></option>
                                  <?php } ?>
                               </select>
                            </div>
                        </div>
                    </div>
                </div>
                 <div class="label_space">
                  <label for="working_hours" class="control-label">
                      Sunday:
                  </label>
              </div>
                <div class="row_half">
                    <div class=" mobile_margin">
                        <label for="working_hours" class=" control-label">
                            Opening Time: 
                        </label>
                        <div class="select_time">
                            <div class='input-group date' id='datetimepicker3'>
                               <select id = "sunOpen">
                                  <?php foreach($openCloseingTime as $key =>$value) { ?>
                                          <option <? if (str_replace(':', '', str_replace(' ', '', $sunDayOpen)) == str_replace(':', '', $value['close_time']))echo "selected='selected'"; ?> value = <?php echo $value['close_time']?> ><?php echo $value['close_time']?></option>
                                  <?php } ?>
                               </select>
                            </div>
                        </div>
                    </div>
                    <div class=" mobile_margin">
                        <label for="working_hours" class=" control-label">
                            Closing Time: 
                        </label>
                        <div class="select_time">
                            <div class='input-group date' id='datetimepicker3'>
                                 <select id = "sunClose">
                                  <?php foreach($openCloseingTime as $key =>$value) { ?>
                                          <option <? if (str_replace(':', '', $sunDayClose) == str_replace(':', '', $value['close_time']))echo "selected='selected'"; ?> value = <?php echo $value['close_time']?> ><?php echo $value['close_time']?></option>
                                  <?php } ?>
                               </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </div>
              <div class="form-group">
                 <input type="submit" value="Continue" name="continue" id="submit-btn" class="form-submit-btn">
               </div>
           </div>
     </div>
   </div>
   <? include("footer.php"); ?>
</body>
</html>
<script type="text/javascript">
      $(document).ready(function(){
         $("input[name = openingDays]").click(function(){
            var vals = $(this).val();
            vals = 'all'+vals;
            if(vals=='all1'){
               $('.all1').show();
               $('.all2').hide();
            }else{
             $('.all2').show();
             $('.all1').hide();
            }
         });
      });
     $('#add_tpye_of_dish').click(function(){
        $('#addDishType-popup').show();
     });

     $("#cancel-popup").click(function () {
       $('#addDishType-popup').hide();
     });

     $(function(){
      $('[id*=submit-btn]').click(function(){
        var dataString = new Array();
        var i = 0;
        if($('[id*=allOpen]').val() != '00:00:00'){
          dataString = 'All :: '+$('[id*=allOpen]').val()+' to '+$('[id*=allClose]').val();
        }else{
          if($('[id*=monOpen]').val() != '00:00:00'){
            dataString[i] = 'Mon :: '+$('[id*=monOpen]').val()+' to '+$('[id*=monClose]').val();
            i = i+1;
          }
          if($('[id*=tueOpen]').val() != '00:00:00'){
            dataString[i] = ['Tue :: '+$('[id*=tueOpen]').val()+' to '+$('[id*=tueClose]').val()];
            i = i+1;
          }
          if($('[id*=wedOpen]').val() != '00:00:00'){
            dataString[i] = ['Wed :: '+$('[id*=wedOpen]').val()+' to '+$('[id*=wedClose]').val()];
            i = i+1;
          }
          if($('[id*=thuOpen]').val() != '00:00:00'){
            dataString[i] = ['Thu :: '+$('[id*=thuOpen]').val()+' to '+$('[id*=thuClose]').val()];
            i = i+1;
          }
          if($('[id*=friOpen]').val() != '00:00:00'){
            dataString[i] = ['Fri :: '+$('[id*=friOpen]').val()+' to '+$('[id*=friClose]').val()];
            i = i+1;
          }
          if($('[id*=satOpen]').val() != '00:00:00'){
            dataString[i] = ['Sat :: '+$('[id*=satOpen]').val()+' to '+$('[id*=satClose]').val()];
            i = i+1;
          }
          if($('[id*=sunOpen]').val() != '00:00:00'){
            dataString[i] = ['Sun :: '+$('[id*=sunOpen]').val()+' to '+$('[id*=sunClose]').val()];
            i = i+1;
          }

        }
         console.log(dataString);
         document.getElementById('opencloseTimeing').value=dataString;
         $.ajax({
            type: "POST",
            url: "storeOpenCloseTime.php?",
            data: dataString,
            success: function (response) {
               $data = JSON.parse(response);
               console.log($data);


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
<script type="text/javascript">
   var loadCount = 1;
          var map;
          var marker = null;
          function initialize() {
   
              var address =document.forms.registerform.elements.streetaddStore.value+" "+document.forms.registerform.elements.cityStore.value+" "+document.forms.registerform.elements.countryStore.value;
              //alert(address);
              geocoder = new google.maps.Geocoder();
   
              var myLatlng = new google.maps.LatLng(<?=$latitude?>,<?=$longitude?>);
      var myOptions = {
          zoom: <?=$zoom
      ?>,
          center: myLatlng,
          mapTypeId: google.maps.MapTypeId.ROADMAP
      }
      map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
   
      var marker = new google.maps.Marker({
          position: myLatlng,
          map: map,
          draggable:true
      });
      var infowindow = new google.maps.InfoWindow({
          content: ""+myLatlng+""
      });
      geocoder.geocode( { 'address': address}, function(results, status) {
          if (status == google.maps.GeocoderStatus.OK) {
              
              //alert(myLatlng+"---"+results[0].geometry.location);
   if(loadCount==1){
   map.setCenter(myLatlng);
   marker.setPosition(myLatlng);
   
   loadCount=0;
   }else{
   map.setCenter(results[0].geometry.location);
   marker.setPosition(results[0].geometry.location);
   
   }
              marker.setMap(map);
              addPoint(results[0].geometry.location);
          } else {
          }
      });
      google.maps.event.addListener(map, 'click', function(event) {
   
          point = event.latLng;
          infowindow.close();
          marker.setPosition(point);
          marker.setMap(map);
          addPoint(point);
   
      });
   
      google.maps.event.addListener(marker, 'mouseout', function() {
          point = marker.getPosition();
          var pointC = ""+point.toUrlValue(6)+"";
          marker.setPosition(point);
          infowindow.setContent(pointC);
          infowindow.open(map,marker);
          addPoint(point);
      });
   
      function addPoint(point) {
          //alert(point.lat());
          window.top.document.forms.registerform.elements.latitude.value = point.lat();
          window.top.document.forms.registerform.elements.longitude.value = point.lng();
      }
      // google.maps.event.addListener(marker, 'click', function() {
      //   map.setZoom(8);
      // });
   }
   
   
   function moveToDarwin() {
      var darwin = new google.maps.LatLng(<?=$latitude?>,<?=$longitude?>);
      map.setCenter(darwin);
   }
   function addPointOnClick(point) {
      //alert(point.lat());
      window.top.document.forms.registerform.elements.latitude.value = point.lat();
      window.top.document.forms.registerform.elements.longitude.value = point.lng();
   }
   
   initialize();
</script>

  <style type="text/css">
      .file-upload {
      background-color: #ffffff;
      width: 100%;
      margin: 0 auto;
      padding: 0px;
      }
      .file-upload-btn {
      margin: 0;
      color: #fff;
      background: #A8082C;
      border: none;
      padding: 10px;
      border-radius: 4px;
      border-bottom: 4px solid #A8082C;
      transition: all .2s ease;
      outline: none;
      text-transform: uppercase;
      font-weight: 700;
      }
      .file-upload-btn:hover {
      background: #A7092D;
      color: #ffffff;
      transition: all .2s ease;
      cursor: pointer;
      }
      .file-upload-btn:active {
      border: 0;
      transition: all .2s ease;
      }
      .file-upload-content {
      display: none;
      text-align: left;
      }
      .file-upload-input {
      position: absolute;
      margin: 0;
      padding: 0;
      width: 100%;
      height: 100%;
      outline: none;
      opacity: 0;
      cursor: pointer;
      }
      .image-upload-wrap {
      margin-top: 20px;
      border: 4px dashed #A7092D;
      position: relative;
      }
      .image-dropping,
      .image-upload-wrap:hover {
      border: 4px dashed #A7092D;
      }
      .image-title-wrap {
      padding: 0;
      color: #222;
      }
      .drag-text {
      text-align: center;
      }
      .drag-text h3 {
      font-weight: 100;
      text-transform: none;
      color: #A7092D;
      padding: 20px 0;
      font-size: 15px;
      }
      .file-upload-image {
      max-height: 200px;
      max-width: 200px;
      margin: auto;
      padding: 10px 0;
      }
      .remove-image {
      width: 200px;
      margin: 0;
      color: #fff;
      background: #cd4535;
      border: none;
      padding: 10px 0;
      border-radius: 4px;
      border-bottom: 4px solid #b02818;
      transition: all .2s ease;
      outline: none;
      text-transform: uppercase;
      font-weight: 700;
      }
      .remove-image:hover {
      background: #c13b2a;
      color: #ffffff;
      transition: all .2s ease;
      cursor: pointer;
      }
      .remove-image:active {
      border: 0;
      transition: all .2s ease;
      }

      .days_div{width: 100%;}
      .days_div td{
        width: 33%;
        padding: 5px 0;
      }

      td label{font-size: 14px;  color: #000;   padding-bottom: 5px;   display: inline-block;}
      .full_width_input input{width: 99.3%;}
   </style>
   <script type="text/javascript">
      function readURL(input) {
            if (input.files && input.files[0]) {
      
              var reader = new FileReader();
      
              reader.onload = function(e) {
                $('.image-upload-wrap').hide();
      
                $('.file-upload-image').attr('src', e.target.result);
                $('.file-upload-content').show();
      
                $('.image-title').html(input.files[0].name);
              };
      
              reader.readAsDataURL(input.files[0]);
      
            } else {
              removeUpload();
            }
          }
      
          function removeUpload() {
            $('.file-upload-input').replaceWith($('.file-upload-input').clone());
            $('.file-upload-content').hide();
            $('.image-upload-wrap').show();
          }
          $('.image-upload-wrap').bind('dragover', function () {
                  $('.image-upload-wrap').addClass('image-dropping');
              });
              $('.image-upload-wrap').bind('dragleave', function () {
                  $('.image-upload-wrap').removeClass('image-dropping');
          });
      
   </script>

   <script type="text/javascript">
  

      $('#with-altField1').multiDatesPicker({
        altField: '#altField1',
        dateFormat: "dd-mm-yy",
      });


 
      $(".ui-datepicker-inline").hide();
        $(".cross").hide();
        $(".cal_icon").click(function(){
          $(".ui-datepicker-inline").toggle();
          $(".cross").show();
        });
      $(".cross").click(function(){
            $(".ui-datepicker-inline").hide();
            $(this).hide();
        });
   </script>
   <style type="text/css">
     .cross{
       position: absolute;
       top: -12px;
       right: -13px;
       z-index: 999;
     }
   </style>
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
    width: 650px;
    background: #fff;
    top: 50%;
    position: absolute;
    left: 50%;
    transform: translate(-50% , -50%);
    border-radius: 10px;
    padding: 15px;

}
.cross1 {
    position: absolute;
    top: -5px;
    right: -5px;
}
.cross1 img {
    width: 18px
}

.login-popup .inner-popup p {
    margin: 0;
    padding: 0;
}
.login-popup .inner-popup .form-group{
   margin-bottom: 10px;
}
.label_space{width: 20%;display: inline-block;}
.row_half{width: 79%;display: inline-block;}
.mobile_margin{display: inline-block;width: 47%;padding-right: 8px;}
.select_time{display: inline-block;width: 100%;}

.login-popup .inner-popup label{
   display: inline-block; width: 100%; font-size: 14px; margin: 5px 0px;
}
.login-popup .inner-popup select, .login-popup .inner-popup input[type="text"]{
   width: 100%;
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