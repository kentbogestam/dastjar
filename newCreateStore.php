<?php
   /* File Name   : addCompany.php
    *  Description : Add Company Form
    *  Author      : Himanshu Singh  Date: 12th,Nov,2010  Creation
    */
   header('Content-Type: text/html; charset=utf-8');
   include_once("cumbari.php");
   $storeObj = new store();
   $regObj = new registration();
   $data = $storeObj->getCompanyDetail($_SESSION['userid']);
   $data1 = $storeObj->getEmailId($_SESSION['userid']);
   $countryList = $regObj->getCountryList();
   //$data = $storeObj->getCompanyDetail($_SESSION['userid']);
   $openCloseingTime = $storeObj->listTimeing();
   //print_r($openCloseingTime);
   if (isset($_POST['continue'])) {
   //echo "In"; die();
       $storeObj->svrStoreDflt();
   }
   //echo $_SESSION['longitude'];
   if ($data[0]['latitude'] && $data[0]['longitude']) {
       $latitude1 = $data[0]['latitude'];
       $longitude1 = $data[0]['longitude'];
   } else {
       $latitude = "64.396938";
       $longitude = "16.699219";
   }
   
   $zoom = "18";
   $menu = "store";
   $$menu = 'class="selected"';
   $add = 'class="selected"';
   
   include_once("main.php");
   ?>
<!-- <script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyBA2NjukdsOEeCHb1ZTbZmaKbYGs0SMFgE&sensor=false"></script> -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyByLiizP2XW9JUAiD92x57u7lFvU3pS630"></script>
<script language="JavaScript" src="client/js/jsStore.js" type="text/javascript"></script>


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
      <form name="registerform" action="" id="registerform" method="POst" enctype="multipart/form-data">
         <input type="hidden" name="m" value="saveNewStore">
         <input type="hidden" name="opencloseTimeing" value="" id="opencloseTimeing">
         <table width="100%"  border="0">
            <tr>
               <td class="redwhitebutton">Add Location</td>
            </tr>
         </table>
         <table width="100%" border="0" cellspacing="15">
            <tr>
               <td width="50%" class="inner_grid">Name of location 
                  <span class='mandatory'>*</span>:
               </td>
               <td width="27%">
                  <INPUT class="text_field_new" type=text name="storeName" id ="storeName" value="<?=$data[0]['company_name']
                     ?>">
                  <div id='error_storeName' class="error"></div>
               </td>
               <td align="right"><a title="<?=NAME_OF_LOCATION_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
            </tr>
            <tr>
               <td class="inner_grid">E-mail
                  <span class='mandatory'>*</span>:
               </td>
               <td>
                  <INPUT class="text_field_new" type=text name="email" id ="email" value="<?=$data1[0]['email']
                     ?>">
                  <div id='error_email' class="error"></div>
               </td>
               <td align="right"><a title="<?=STORE_EMAIL_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
            </tr>
            <tr>
               <td class="inner_grid">Link to the location home<span class='mandatory'>*</span>:</td>
               <td>
                  <INPUT class="text_field_new" type=text name="link" id ="link" >
                  <div id='error_link' class="error"></div>
               </td>
               <td align="right"><a title="<?=LINK_TO_THE_LOCATION_HOME_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
            </tr>
            <tr>
               <td height="42" align="left">Type of Restaurant                </td>
               <td>
                  <select class="text_field_new" style="background-color:#e4e3dd; width:406px; height:36px;border: 1px solid #abadb3;" tabindex="27" id="typeofrestrurant" name="typeofrestrurant">
                     <option value="1">Eat Now</option>
                     <option value="2">Eat Later</option>
                     <option value="3">Both</option>
                  </select>
               </td>
            </tr>
            <tr>
               <td height="42" align="left">Online Payment<span class='mandatory'>*</span>:</td>
               <td><input type="checkbox" name="onlinePayment" value="1"  checked />Online Payment</td>
            </tr>
            <tr>
               <td class="inner_grid">Phone Number<span class='mandatory'>*</span>:</td>
               <td>
                  <INPUT class="text_field_new" type=text name="phoneNo" id ="phoneNo">
                  <div id='error_phoneNo' class="error"></div>
               </td>
               <td align="right"><a title="<?=PHONE_NUMBER_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
            </tr>
            <!-- <tr>
               <td class="inner_grid">Select a method for receiving 
                  Coupon data:
               </td>
               <td>
                  <table border="0" cellspacing="0" cellpadding="0">
                     <tr>
                        <td><input type="checkbox" name="BARCODE" value="BARCODE"/>BARCODE</td>
                        <td><input type="checkbox" name="DPS" value="DPS" />DPS</td>
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
               <tr>
                <td height="42" align="left">Opening hours of the Location <span class='mandatory'>*</span>: </td>
               <td>
                  <a style="font-size: 15px;vertical-align: top; cursor:pointer; text-decoration: underline;" id="add_tpye_of_dish">Location is open following days of the week</a></label>
                  <div id='error_storeTime' class="error"></div>
               </td>
               <td align="right"><a title="<?=STORE_OPEN_CLOSE_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
            </tr>
               <!-- <td><label>Location opens at</label>
                  <select class="text_field_new" style="background-color:#e4e3dd; width:406px; height:36px;border: 1px solid #abadb3;" tabindex="27" id="storeOpenTime" name="storeOpenTime">
                    <?php foreach($openCloseingTime as $key =>$value) { ?>
                            <option value = <?php echo $value['open_time']?> ><?php echo $value['open_time']?></option>
                    <?php } ?>
                  </select>
               </td> -->
            </tr>
           <!--  <tr>
               <td></td>
               <td><label>Location closes at</label>
                  <select class="text_field_new" style="background-color:#e4e3dd; width:406px; height:36px;border: 1px solid #abadb3;" tabindex="27" id="storeCloseTime" name="storeCloseTime">
                     <?php foreach($openCloseingTime as $key =>$value) { ?>
                              <option value = <?php echo $value['close_time']?> ><?php echo $value['close_time']?></option>
                      <?php } ?>
                  </select>
               </td>
            </tr> -->
            <!--  <tr>
               <td class="inner_grid">
               </td>
               <td>
                  <table class="days_div" border="0" cellspacing="0" cellpadding="0">
                    <label>
                    <a style="font-size: 15px;vertical-align: top; cursor:pointer; text-decoration: underline;" id="add_tpye_of_dish">Location is open following days of the week</a></label>
                     <tr>
                        <td><input type="checkbox" name="Monday" value="Mon"/>Monday</td>
                        <td><input type="checkbox" name="Tuesday" value="Tue" />Tuesday</td>
                        <td><input type="checkbox" name="Wednesday" value="Wed" />Wednesday</td>
                     </tr>
                     <tr>
                        <td ><input type="checkbox" name="Thursday" value="Thu" />Thursday</td>
                        <td><input type="checkbox" name="Friday" value="Fri"/>Friday</td>
                        <td><input type="checkbox" name="Saturday" value="Sat"/>Saturday</td>
                        <td >&nbsp;</td>
                     </tr>
                      <tr>
                        <td><input type="checkbox" name="Sunday" value="Sun"/>Sunday</td>
                     </tr>
                  </table>
               </td>
               <td align="right"><a title="<?=METHOD_FOR_RECEIVING_COUPON_DATA_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
            </tr> -->
                <tr>
                  <td>Location is close following dates</td>
               <td style="position: relative;">
                 <div id="with-altField"><span class="cross"><img src="client/js/newJs/images/error.png"></span></div>
                  <div id="withAltField" class="box">

                   <img class="cal_icon" id="cal_icon" src="client/js/newJs/images/calendar.gif"> 

                     <input class="text_field_new" type="text" id="altField" name="altField" value="">
                  </div>
               </td>
            </tr>
            <tr>
               <td class="inner_grid">Street Address<span class='mandatory'>*</span>:</td>
               <td>
                  <input class="text_field_new" type="text" name="streetaddStore" id ="streetaddStore" value="<?=$data[0]['streetaddStore'] ?>" onChange="initialize()" />
                  <div id='error_address' class="error"></div>
               </td>
               <td align="right"><a title="<?=STREET_ADDRESS_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
            </tr>
            <tr>
               <td class="inner_grid">City<span class='mandatory'>*</span>:</td>
               <td>
                  <input class="text_field_new" type="text" name="cityStore" id ="cityStore" value="<?=$data[0]['city'] ?>" onChange="initialize()" />
                  <div id='error_cityStore' class="error"></div>
               </td>
               <td align="right"><a title="<?=CITY_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
            </tr>
            <tr>
               <td class="inner_grid">Country<span class='mandatory'>*</span>:</td>
               <td>
                  <select class="text_field_new" style="width:406px; background-color:#e4e3dd;"  tabindex="27"  name="countryStore" id ="countryStore" value="<?=$data[0]['cname'] ?>" onChange="initialize()" >
                     <option value="">Select</option>
                     <?php
                        $countryCode = $data[0]['ciso'];
                        if(empty($countryCode))
                        {
                            $countryCode='SE';
                        }
                        
                        foreach($countryList as $key=>$value)
                        {
                        
                        ?>
                     <option value="<?=$value?>" <?php if($countryCode==$key){ echo 'selected=selected'; } ?>><?=$value?></option>
                     <?php
                        }
                        ?>
                  </select>
                  <div id='error_countryStore' class="error"></div>
               </td>
               <td align="right"><a title="<?=COUNTRY_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
            </tr>
            <tr>
               <td class="inner_grid">Chain:</td>
               <td>
                  <input class="text_field_new" type="text" name="chain" id ="chain" value="<?=$data[0]['chain'] ?>" />
                  <div id='error_chain' class="error"></div>
               </td>
               <td align="right"><a title="<?=CHAIN_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
            </tr>
            <!-- <tr>
               <td class="inner_grid">Block:</td>
               <td>
                  <input class="text_field_new" type="text" name="block" id ="block" value="<?=$data[0]['block'] ?>"  />
                  <div id='error_block' class="error"></div>
               </td>
               <td align="right"><a title="<?=BLOCK_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
            </tr> -->
            <tr>
               <td class="inner_grid">Zip:</td>
               <td>
                  <input class="text_field_new" type="text" name="zip" id ="zip" value="<?=$data[0]['zip'] ?>" />
                  <div id='error_zip' class="error"></div>
               </td>
               <td align="right"><a title="<?=ZIP_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
            </tr>
            <tr>
               <td valign="top">Map<span class='mandatory'>*</span></td>
               <td>
                  <div id="map_canvas" style="height:320px; width:400px; border: solid 1px;"></div>
               </td>
               <td align="right" valign="top"><a title="<?=MAP_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
            </tr>
            <tr>
               <td>
                  <div id='error_coordinate' class="error"></div>
               </td>
            </tr>
            <tr>
               <td></td>
               <td> You can set your location on map by click or drag</td>
            </tr>
            <tr>
               <td colspan="4">
                  <input type="hidden" name="longitude" value="<?=$longitude1 ?>" id="longitude" />
                  <input type="hidden" name="latitude" value="<?=$latitude1 ?>" id="latitude" />
                  <input name="zoom" id="zoom" value="<?=$zoom ?>" type="hidden" style="width:150px;" />        
            </tr>
            <tr>
               <td>Upload Image For Restaurent<span class='mandatory'>*</span>:</td>
               <td>
                  <div class="file-upload">
                     <button class="file-upload-btn" type="button" onclick="$('.file-upload-input').trigger( 'click' )">Add Image</button>
                     <div class="image-upload-wrap">
                        <input class="file-upload-input" type='file' id="imageStore" name="imageStore" onBlur="iconPreview(this.form);"  onchange="readURL(this);" accept="image" />
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
            </tr>
         </table>
         <div align="center">
            <INPUT style="margin-left:700px;" type="submit" value="Submit" name="continue" id="continue" class="button" >
            <br />
            <br />
         </div>
      </form>
      <div>
         <span class='mandatory'>* These Fields Are Mandatory</span>
      </div>
   </div>
   <div id="addDishType-popup" style="display: none;" class="login-popup" data-theme="a">
     <div class="inner-popup">
           <div id = "cancel-popup" class="cross1">
              <img src="client/images/cross.png" />
           </div>
           <div class="pop-body">
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
                                        <option value = <?php echo $value['close_time']?> ><?php echo $value['close_time']?></option>
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
                                        <option value = <?php echo $value['close_time']?> ><?php echo $value['close_time']?></option>
                                <?php } ?>
                             </select>
                          </div>
                      </div>
                  </div>
              </div>
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
                                        <option value = <?php echo $value['close_time']?> ><?php echo $value['close_time']?></option>
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
                                        <option value = <?php echo $value['close_time']?> ><?php echo $value['close_time']?></option>
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
                                            <option value = <?php echo $value['close_time']?> ><?php echo $value['close_time']?></option>
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
                                            <option value = <?php echo $value['close_time']?> ><?php echo $value['close_time']?></option>
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
                                        <option value = <?php echo $value['close_time']?> ><?php echo $value['close_time']?></option>
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
                                        <option value = <?php echo $value['close_time']?> ><?php echo $value['close_time']?></option>
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
                                        <option value = <?php echo $value['close_time']?> ><?php echo $value['close_time']?></option>
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
                                        <option value = <?php echo $value['close_time']?> ><?php echo $value['close_time']?></option>
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
                                        <option value = <?php echo $value['close_time']?> ><?php echo $value['close_time']?></option>
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
                                        <option value = <?php echo $value['close_time']?> ><?php echo $value['close_time']?></option>
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
                                        <option value = <?php echo $value['close_time']?> ><?php echo $value['close_time']?></option>
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
                                        <option value = <?php echo $value['close_time']?> ><?php echo $value['close_time']?></option>
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
                                        <option value = <?php echo $value['close_time']?> ><?php echo $value['close_time']?></option>
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
                                        <option value = <?php echo $value['close_time']?> ><?php echo $value['close_time']?></option>
                                <?php } ?>
                             </select>
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
   <script type="text/javascript">
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
      var map;
      var marker = null;
      function initialize() {
          var address =document.forms.registerform.elements.streetaddStore.value+" "+document.forms.registerform.elements.cityStore.value+" "+document.forms.registerform.elements.countryStore.value;
          geocoder = new google.maps.Geocoder();
      
          var myLatlng = new google.maps.LatLng(<?=$latitude ?>,<?=$longitude ?>);
          var myOptions = {
              zoom: <?=$zoom ?>,
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
                  map.setCenter(results[0].geometry.location);
                  marker.setPosition(results[0].geometry.location);
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
          var darwin = new google.maps.LatLng(<?=$latitude ?>,<?=$longitude ?>);
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
  
/*$('#mdp-demo').multiDatesPicker({
  mode: 'daysRange',
  autoselectRange: [0,5]
});*/
$('#with-altField').multiDatesPicker({
  altField: '#altField',
  dateFormat: "dd-mm-yy",
});
/*
 
    $(".ui-datepicker-inline").hide();
    $(".cal_icon").click(function(){
        
    });*/


        // Show hide popover
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
