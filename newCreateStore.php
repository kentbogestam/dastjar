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
   
   // 
   $accountObj = new accountView();
   $data = $accountObj->getCompanyDetail();
   $stripePayment = $accountObj->stripePayment();
   // echo $stripePayment; exit;

   // Get packages to subscribe for location
   $billingObj = new billing();
   $productsAll = $billingObj->showPlanToSubscribe();
   $products = $packages = array();

   if($productsAll)
   {
        // Logic to get latest product if belongs to same package
        foreach($productsAll as $row)
        {
            if(!in_array($row['package_ids'], $packages))
            {
                $products[] = $row;
            }
            else
            {
                $key = array_search($row['package_ids'], $packages);
                $products[$key] = $row;
            }

            array_push($packages, $row['package_ids']);
        }
   }

   // echo '<pre>'; print_r($products); exit;

   $productid = $_GET['productId'];

   // Create location and then create subscribtion for that location
   if (isset($_POST['plan_id']) && isset($_POST['stripeToken'])) {
       $storeObj->svrStoreDflt();
   }

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

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<style type="text/css">
   /*
      .center{width:900px; margin-left:auto; margin-right:auto;}
      */
    input[type="checkbox"][readonly] {
        pointer-events: none;
    }
</style>
<body>
   <div class="center">
      <form name="registerform" id="registerform" method="POST" action="" enctype="multipart/form-data">
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
               <td align="right"><a title="<?=TYPE_OF_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
            </tr>
            <tr>
                <td height="42" align="left">Delivery Type</td>
                <td>
                    <select class="text_field_new" id="delivery_type" name="delivery_type[]" multiple="" style="width:406px; height:55px;border: 1px solid #abadb3;">
                        <option value="1">Dine-in</option>
                        <option value="2" selected>Take away</option>
                        <option value="3">Home Delivery</option>
                    </select>
                    <div id='error_delivery_type' class="error"></div>
                </td>
                <td align="right"><a title="<?=DELIVERY_TYPE?>" class="vtip"><b><small>?</small></b></a></td>
            </tr>

             <!-- code added by saurabh to add new field for restaurant keyword"-->
             <tr>
               <td class="inner_grid">Tag line For Location:</td>
               <td>
                  <input type="text" class="text_field_new"  name="tagline" id ="tagline" maxlength="50" />
                  <div id='error_link' class="error"></div>
               </td>
               <td align="right"><a title="<?=RESTAURANT_TAGLINE?>" class="vtip"><b><small>?</small></b></a></td>
            </tr>
            <!-- End code added by saurabh to add new field for restaurant keyword"-->
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
               <td align="right"><a title="<?=STORE_CLOSE_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
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
                  <td>Location is closed following dates</td>
               <td style="position: relative;">
                 <div id="with-altField"><span class="cross"><img src="client/js/newJs/images/error.png"></span></div>
                  <div id="withAltField" class="box">

                   <img class="cal_icon" id="cal_icon" src="client/js/newJs/images/calendar.gif"> 

                     <input class="text_field_new" type="text" id="altField" name="altField" value="">
                  </div>
               </td>
               <td align="right"><a title="<?=STORE_CLOSE_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
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
                  <input type="hidden" name="productid" value="<?=$productid?>">
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
                <td>
                    Upload Image For Restaurant<span class='mandatory'>*</span>:<br>
                    <strong>Recommended: 1024x1024</strong>
                </td>
                <td>
                  <div class="file-upload">
                     <button class="file-upload-btn" type="button" onclick="$('.file-upload-input').trigger( 'click' )">Add Image</button>
                     <div class="image-upload-wrap">
                        <input class="file-upload-input" type='file' id="imageStore" name="imageStore" onchange="readURL(this)" onBlur="iconPreview(this.form);" accept="image" />
                        <div class="drag-text">
                           <h3>Drag and drop a file or select add Image</h3>
                           <samp>Please upload only png Image</samp>
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
                <div id='warning-store-image' class="warning"></div>
               </td>
               <td align="right"><a title="<?=IMAGE_RESTAURANT?>" class="vtip"><b><small>?</small></b></a></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="panel panel-default">
                        <div class="panel-heading">Add Subscription</div>
                        <div class="panel-body">
                            <table width="100%" cellspacing="2" border="0" >
                                <tr>
                                    <td valign="top" >
                                        <!-- <input type="hidden" name="m" value="savecomp">
                                        <input type="hidden" name="checkResult" id="checkResult" value="yes"/> -->
                                        <table BORDER=0 width="100%" class="prod_table table table-striped" cellspacing="10" cellpadding="10">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>S. No.</th>
                                                    <th colspan="2" style="padding-bottom: 10px; padding-right: 10px">Product Description</th>
                                                    <th>Unit Price(kr)</th>
                                                    <!-- <th>Quantity</th> -->
                                                    <th>Amount</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $total = 0;
                                                $i = 1;
                                                foreach ($products as $key => $product) {
                                                ?>
                                                    <tr class="prods">
                                                        <td align="left">
                                                            <input type="checkbox" name="plan_id[]" value="<?=$product['plan_id']?>" <?php echo ($product['package_ids'] == '1') ? "checked='checked' readonly" : '' ?> data-amount="<?php echo $product['price']; ?>" data-package="<?php echo $product['package_ids']; ?>" data-tax="25">
                                                        </td>
                                                        <td><?php echo $i; ?></td>
                                                        <td align="left" colspan="2" style="padding-right: 10px; padding-left: 10px">
                                                            <?php
                                                            if($product['package_ids'] == '1'){ 
                                                                $total += floatval($product['price']);
                                                            ?>
                                                                <div class="panel-group">
                                                                    <div class="panel panel-default">
                                                                        <div class="panel-heading">
                                                                            <h4 class="panel-title">
                                                                            <a data-toggle="collapse" href="#collapse1"><?php echo $product['product_name']; ?><span class="caret pull-right"></span></a>
                                                                            </h4>
                                                                        </div>
                                                                        <div id="collapse1" class="panel-collapse collapse">
                                                                            <ul class="list-group">
                                                                                <li class="list-group-item">Order status (incoming and delivered orders)
                                                                                </li>
                                                                                <li class="list-group-item">Delivery and Payment confirmation</li>
                                                                                <li class="list-group-item">Menu (Edit and add new dishes to Menu)</li>
                                                                                <li class="list-group-item">Administration support (Change company setting and information)</li>
                                                                                <li class="list-group-item">Additional features under “More” ooo</li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php }else{ ?>   
                                                                <?=$product['product_name']?>
                                                            <?php } ?>
                                                        </td>
                                                        <td align="left">
                                                            <?= number_format(($product['price']), 2, '.', '')." (" .$product['currency'].")"?>
                                                        </td>
                                                        <!-- <td align="left">1</td> -->
                                                        <td align="left">
                                                            <?php  echo number_format(($product['price']*1), 2, '.', ''); ?>
                                                        </td>
                                                        <td>
                                                            <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="<?php echo $product['description']; ?>">
                                                                <span class="glyphicon glyphicon-info-sign"></span>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php
                                                    $i++;
                                                }
                                                ?>
                                                <!-- <tr>
                                                    <td align="left" colspan="4" style="padding-right: 10px; padding-left: 10px">&nbsp;</td>
                                                    <td align="left"><strong>Total: </strong></td>
                                                    <td align="left" colspan="2" class="subscription-total"><?=number_format($total, 2, '.', '');?></td>
                                                </tr> -->
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <div class="block-total row">
                                <div class="col-md-9 text-right"><strong>Sub Total: </strong></div>
                                <div class="col-md-3 subscription-sub-total" style="padding-left: 75px;"><?=number_format($total, 2, '.', '');?></div>
<div class="col-md-9 text-right"><strong>Tax: </strong></div>
                                <div class="col-md-3 subscription-tax" style="padding-left: 75px;"><?=number_format($total, 2, '.', '');?></div>
<div class="col-md-9 text-right"><strong>Total: </strong></div>
                                <div class="col-md-3 subscription-total" style="padding-left: 75px;"><?=number_format($total, 2, '.', '');?></div>
                            </div>
                            <div>
                                <label><input type="checkbox" name="terms" id="terms" value="terms" required>Terms & Condition</label> 
                                <span class="mandatory">*</span>
                                <input type="hidden" id="stripe_token" name="stripeToken" value="">
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
         </table>
         <div align="center">
            <input type="checkbox" name="onlinePayment" value="1"  checked style="display: none;" />
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
                                          <option>Select Opening Time</option>
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
                                          <option>Select Closing Time</option>
                                   <?php foreach($openCloseingTime as $key =>$value) { ?>
                                           <option value = <?php echo $value['close_time']?> ><?php echo $value['close_time']?></option>
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
                                          <option>Select Opening Time</option>
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
                                       <option>Select Closing Time</option>
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
                                             <option>Select Opening Time</option>
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
                                                <option>Select Closing Time</option>
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
                                          <option>Select Opening Time</option>
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
                                          <option>Select Closing Time</option>
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
                                          <option>Select Opening Time</option>
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
                                             <option>Select Closing Time</option>
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
                                          <option>Select Opening Time</option>
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
                                             <option>Select Closing Time</option>
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
                                         <option>Select Opening Time</option>
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
                                         <option>Select Closing Time</option>
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
                                          <option>Select Opening Time</option>
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
                                          <option>Select Closing Time</option>
                                   <?php foreach($openCloseingTime as $key =>$value) { ?>
                                           <option value = <?php echo $value['close_time']?> ><?php echo $value['close_time']?></option>
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
   
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
   <script src="https://checkout.stripe.com/checkout.js"></script>

   <script type="text/javascript">
    stripePayment = "<?php echo $stripePayment ?>";
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

        // Update total
        $('input[name="plan_id[]"]').change(function() {
            // Update 'onlinePayment' fields
            var inputFields = '';
            var checkedValue = $(this).is(':checked') ? true : false;

            if($(this).data('package') == '5')
            {
                inputFields = 'onlinePayment';
            }

            if(inputFields != '')
            {
                $('input[name="'+inputFields+'"]').prop('checked', checkedValue);
            }

            // Update total
            updateTotal();

            // Check if added plan including payment plan, and Stripe payment not been added before
            if(checkedValue && stripePayment == 'No')
            {
                var packages = ($(this).data('package')).toString().split(',');
                
                if(packages.indexOf("5") != -1)
                {
                    alert("Stripe & IBAN\nYou will be redirected to our payment partner Stripe to get your company account details. Stripe is one of the most reliable payment systems in the World. Please follow the instructions and fill in the required information. \n\n- Step 1 Company card details\nWe are using electronic invoice. Please fill in your company card details.\nYou’ll receive a confirmation for each invoice on your e-mail. By doing so, we’ll contribute to a better environment for all of us.\n\n- Step 2 This information is needed for transferring all customer payments to your company account.\n\nNote: Stripe requires IBAN (International Bank Account Number). You can find IBAN, either in your internet bank or call your bank to help you.");
                }
            }
        });

        // Initialize Stripe
        var handler = StripeCheckout.configure({
            key: "<?php echo STRPIE_PUB_KEY; ?>",
            image: "https://stripe.com/img/documentation/checkout/marketplace.png",
            name: "Dastjar",
            description: "<?=$_SESSION['username'];?>",
            locale: "auto",
            allowRememberMe: false,
            token: function(token) {
                $('#stripe_token').val(token.id);
                $('#registerform').submit();
            }
        });

        // Ask for detail before submit the location
        $('#registerform').submit(function(e){
            if( !$('#stripe_token').val().length ){
                e.preventDefault();
                
                var totalAmount = parseFloat($('.subscription-total').html());

                //
                handler.open({
                    currency: 'sek',
                    amount: (totalAmount*100)
                });
            }
        });

        // Tooltip
        $('[data-toggle="tooltip"]').tooltip();
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
        if($('[id*=allOpen]').val() != 'Select Opening Time' && $('[id*=allClose]').val() != 'Select Closing Time'){
          dataString = 'All :: '+$('[id*=allOpen]').val()+' to '+$('[id*=allClose]').val();
        }else{
          if($('[id*=monOpen]').val() != 'Select Opening Time' && $('[id*=monClose]').val() != 'Select Closing Time'){
            dataString[i] = 'Mon :: '+$('[id*=monOpen]').val()+' to '+$('[id*=monClose]').val();
            i = i+1;
          }
          if($('[id*=tueOpen]').val() != 'Select Opening Time' && $('[id*=tueClose]').val() != 'Select Closing Time'){
            dataString[i] = ['Tue :: '+$('[id*=tueOpen]').val()+' to '+$('[id*=tueClose]').val()];
            i = i+1;
          }
          if($('[id*=wedOpen]').val() != 'Select Opening Time' && $('[id*=wedClose]').val() != 'Select Closing Time'){
            dataString[i] = ['Wed :: '+$('[id*=wedOpen]').val()+' to '+$('[id*=wedClose]').val()];
            i = i+1;
          }
          if($('[id*=thuOpen]').val() != 'Select Opening Time' && $('[id*=thuClose]').val() != 'Select Closing Time'){
            dataString[i] = ['Thu :: '+$('[id*=thuOpen]').val()+' to '+$('[id*=thuClose]').val()];
            i = i+1;
          }
          if($('[id*=friOpen]').val() != 'Select Opening Time' && $('[id*=friClose]').val() != 'Select Closing Time'){
            dataString[i] = ['Fri :: '+$('[id*=friOpen]').val()+' to '+$('[id*=friClose]').val()];
            i = i+1;
          }
          if($('[id*=satOpen]').val() != 'Select Opening Time' && $('[id*=satClose]').val() != 'Select Closing Time'){
            dataString[i] = ['Sat :: '+$('[id*=satOpen]').val()+' to '+$('[id*=satClose]').val()];
            i = i+1;
          }
          if($('[id*=sunOpen]').val() != 'Select Opening Time' && $('[id*=sunClose]').val() != 'Select Closing Time'){
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

      // Update plan on change
      $(document).on('change', '#typeofrestrurant', function() {
        updatePlan();
      });
   });

     // Update plan on load
     $(window).load(function() {
        updatePlan();
     });

     // Update plan
     function updatePlan()
     {
        var typeOfRestrurant = $('#typeofrestrurant option:selected').val();
        addPlan = []; // Default 'Payment package' (static id from packages)

        if(typeOfRestrurant != '1')
        {
            addPlan.push('4'); // Add 'Catering package'
        }

        if(addPlan.length)
        {
            $('input[name="plan_id[]"]:not([readonly])').prop('checked', false);

            for(index = 0; index < addPlan.length; index++)
            {
                $('input[name="plan_id[]"][data-package='+addPlan[index]+']').prop('checked', true);
                // $('input[name="plan_id[]"][value='+addPlan[index]+']').prop('checked', true);
            }
        }

        // Update total
        updateTotal();
     }

     // Sum amount of selected packages and update total
     function updateTotal()
     {
        var subTotal = taxTotal = 0;

        $('input[name="plan_id[]"]:checked').each(function() {
            taxTotal += ( $(this).data('amount') * $(this).data('tax') ) / 100;
            subTotal += parseFloat($(this).data('amount'));
        });

        var totalAmount = subTotal + taxTotal;

        $('.subscription-sub-total').html(subTotal.toFixed(2));
        $('.subscription-tax').html(taxTotal.toFixed(2));
        $('.subscription-total').html(totalAmount.toFixed(2));
     }
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
        function iconPreview() {}

        var _URL = window.URL || window.webkitURL;
        function readURL(input) {
            var file, img;

            if (input.files && input.files[0]) {
                file = input.files[0];
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#warning-store-image').html('');
                    $('.image-upload-wrap').hide();
                    $('.file-upload-image').attr('src', e.target.result);
                    $('.file-upload-content').show();
                    $('.image-title').html(input.files[0].name);

                    // Get image size
                    img = new Image();
                    img.onload = function () {
                        if(this.width < 1024)
                        {
                            $('#warning-store-image').html('Image size should be (1024x1024) width and height.');
                        }
                    };
                    img.src = _URL.createObjectURL(file);
                };

                reader.readAsDataURL(input.files[0]);
            } else {
                removeUpload();
            }
        }

        function removeUpload() {
            $('#warning-store-image').html('');
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
