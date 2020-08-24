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
   $openCloseingTimeCatering = $storeObj->listTimeing();
    $storeDetail=$storeObj->getStoreDetailById($_REQUEST['storeId']);
    $storeCount=count($storeDetail);
    if($storeCount>0)
    {
        $storeopenCloseTimeCatering=$storeDetail[0]['store_open_close_day_time_catering'];
        $storeopenCloseTime=$storeDetail[0]['store_open_close_day_time'];
    }
    //print_r($storeDetail);
   $accountObj = new accountView();
   $data = $accountObj->getCompanyDetail();
   $stripePayment = $accountObj->stripePayment();

   $billingObj = new billing();
   
   // Get 'payment method' belongs to customer
   $user = $billingObj->getUserCompanySubsDetail($_SESSION['userid']);
   if(!is_null($user['stripe_customer_id']) && !empty($user['stripe_customer_id']))
   {
        $paymentMethod = $billingObj->getPaymentMethod($user['stripe_customer_id']);
   }

   // 
   $subscribedPlan = $billingObj->getSubscribedPlanByStoreId($_GET['storeId']);
   // echo '<pre>'; print_r($subscribedPlan); exit;

   // Get packages to subscribe for location and logic to show either subscribed recurring/onetime or updated package
   $productsUpd = $billingObj->showPlanToSubscribe($_GET['storeId']);
   $products = $packages = array();

   if($productsUpd)
   {
        foreach($productsUpd as $row)
        {
            if( !in_array($row['package_ids'], $packages) )
            {
                $products[] = $row;
                array_push($packages, $row['package_ids']);
            }
            else
            {
                $key = array_search($row['package_ids'], $packages);

                if( !is_numeric(array_search($row['plan_id'], array_column($subscribedPlan['recurring'], 'plan_id'))) && !isset($products[$key]['up_id']) )
                {
                    $products[($key)] = $row;
                }
                elseif( !is_numeric(array_search($row['plan_id'], array_column($subscribedPlan['oneTime'], 'plan_id'))) && !isset($products[$key]['up_id']) )
                {
                    $products[($key)] = $row;
                }
            }

            // 
            $keySubscribedPlan = array_search($row['plan_id'], array_column($subscribedPlan['recurring'], 'plan_id'));
            $keySubscribedPlanOneTime = array_search($row['plan_id'], array_column($subscribedPlan['oneTime'], 'plan_id'));

            if( is_numeric($keySubscribedPlan) )
            {
                $key = array_search($row['package_ids'], $packages);
                $products[$key] = $row;
                $products[($key)]['up_id'] = 1;
                $products[($key)]['subscription_item'] = $subscribedPlan['recurring'][$keySubscribedPlan]['subscription_item'];
            }
            elseif( is_numeric($keySubscribedPlanOneTime) )
            {
                $key = array_search($row['package_ids'], $packages);
                $products[$key] = $row;
                $products[($key)]['up_id'] = 1;
                $products[($key)]['subscription_item'] = $subscribedPlan['oneTime'][$keySubscribedPlanOneTime]['subscription_item'];
            }
        }
   }

   // echo '<pre>'; print_r($products); exit;

   // Get subscribed plans list
   /*$arrProductsSubscribed = array();
   $productsSubscribedObj = $billingObj->getSubscribedPlanByLocation($_GET['storeId']);

   if($productsSubscribedObj)
   {
        while ($row = mysqli_fetch_array($productsSubscribedObj))
        {
            $arrProductsSubscribed[] = $row['plan_id'];
        }
   }*/

   if ( (isset($_POST['storeName'])) || (isset($_POST['plan_id']) && isset($_POST['stripe_token'])) ) {
       $storeObj->svrStoreDflt();
   } else {
       $storeid = $_GET['storeId']; 
       $data = $storeObj->getStoreDetailById($storeid);
   //echo "<pre>";print_r($data);echo "</pre>";
   }
   $openCloseList = explode(",",$data[0]['store_open_close_day_time']);
   foreach ($openCloseList as $key => $value) {
      $getDay = explode("::",$value);
      $getDay[0] = str_replace(' ', '', $getDay[0]);

      if($getDay[0] == 'All'){
        $getTime = explode("to",$getDay[1]);
        $allDayOpen = $getTime[0];
        $allDayClose = $getTime[1];
      }
      if($getDay[0] == 'Mon'){
        $getTime = explode("to",$getDay[1]);
        $monDayOpen = $getTime[0];
        $monDayClose = $getTime[1];
      }
      if($getDay[0] == 'Tue'){
        $getTime = explode("to",$getDay[1]);
        $tueDayOpen = $getTime[0];
        $tueDayClose = $getTime[1];
      }
      if($getDay[0] == 'Wed'){
        $getTime = explode("to",$getDay[1]);
        $wedDayOpen = $getTime[0];
        $wedDayClose = $getTime[1];
      }
      if($getDay[0] == 'Thu'){
        $getTime = explode("to",$getDay[1]);
        $thuDayOpen = $getTime[0];
        $thuDayClose = $getTime[1];
      }
      if($getDay[0] == 'Fri'){
        $getTime = explode("to",$getDay[1]);
        $friDayOpen = $getTime[0];
        $friDayClose = $getTime[1];
      }
      if($getDay[0] == 'Sat'){
        $getTime = explode("to",$getDay[1]);
        $satDayOpen = $getTime[0];
        $satDayClose = $getTime[1];
      }
      if($getDay[0] == 'Sun'){
        $getTime = explode("to",$getDay[1]);
        $sunDayOpen = $getTime[0];
        $sunDayClose = $getTime[1];
      }
   }



   //open close date for catering
   $openCloseListCatering = explode(",",$data[0]['store_open_close_day_time_catering']);
   foreach ($openCloseListCatering as $key => $value) {
      $getDay = explode("::",$value);
      $getDay[0] = str_replace(' ', '', $getDay[0]);

      if($getDay[0] == 'All'){
        $getTime = explode("to",$getDay[1]);
        $allDayOpenCatering = $getTime[0];
        $allDayCloseCatering = $getTime[1];
      }
      if($getDay[0] == 'Mon'){
        $getTime = explode("to",$getDay[1]);
        $monDayOpenCatering = $getTime[0];
        $monDayCloseCatering = $getTime[1];
      }
      if($getDay[0] == 'Tue'){
        $getTime = explode("to",$getDay[1]);
        $tueDayOpenCatering = $getTime[0];
        $tueDayCloseCatering = $getTime[1];
      }
      if($getDay[0] == 'Wed'){
        $getTime = explode("to",$getDay[1]);
        $wedDayOpenCatering = $getTime[0];
        $wedDayCloseCatering = $getTime[1];
      }
      if($getDay[0] == 'Thu'){
        $getTime = explode("to",$getDay[1]);
        $thuDayOpenCatering = $getTime[0];
        $thuDayCloseCatering = $getTime[1];
      }
      if($getDay[0] == 'Fri'){
        $getTime = explode("to",$getDay[1]);
        $friDayOpenCatering = $getTime[0];
        $friDayCloseCatering = $getTime[1];
      }
      if($getDay[0] == 'Sat'){
        $getTime = explode("to",$getDay[1]);
        $satDayOpenCatering = $getTime[0];
        $satDayCloseCatering = $getTime[1];
      }
      if($getDay[0] == 'Sun'){
        $getTime = explode("to",$getDay[1]);
        $sunDayOpenCatering = $getTime[0];
        $sunDayCloseCatering = $getTime[1];
      }
   }   
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
<script language="JavaScript" src="client/js/jsStoreEdit.js?v=11" type="text/javascript"></script>

<script type="text/javascript" src="client/js/newJs/jquery-1.11.1.js"></script>
<link rel="stylesheet" type="text/css" href="client/js/newJs/mdp.css">
 
<script type="text/javascript" src="client/js/newJs/jquery-ui.min.js"></script>
<script type="text/javascript" src="client/js/newJs/jquery-ui.multidatespicker.js"></script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

<style type="text/css">
    input[type="checkbox"][readonly] {
        pointer-events: none;
    }
    
    input[type='checkbox'][disabled][checked] {
        display: none;
    }

    input[type="checkbox"]:disabled + label:before {
        content: '';
        font-size: 20px;
        font-weight: bold;
    }

    input[type="checkbox"][disabled][checked] + label:before {
        content: '✓';
    }
</style>
<body>
   <div class="center">
      <form name="registerform" action="" id="registerform" method="Post" class="form-horizontal" enctype="multipart/form-data">
        <input type="hidden" name="opencloseTimeing" value="<?php echo $storeopenCloseTime;   ?>" id="opencloseTimeing">
        <input type="hidden" name="opencloseTimeingCatering" value="<?php echo $storeopenCloseTimeCatering;   ?>" id="opencloseTimeingCatering">
        <input type="hidden" name="m" value="editSaveStore">
        <input type="hidden" name="storeId" value="<?php echo $data[0]['store_id']; ?>">
        <input type="hidden" name="s" value="<?=$_REQUEST['s']?>">
        <div class="redwhitebutton123">Edit Location</div>
        <div class="form-group">
            <label class="control-label col-sm-5 text-left" for="storeName">Name of location 
                <span class='mandatory'>*</span>:</label>
            <div class="col-sm-6">
                <input class="form-control"  type=text name="storeName" id ="storeName" value="<?=$data[0]['store_name']?>">
                <small><i>Note*- Only letters, numbers and dash (-) allowed</i></small>
                <div id='error_storeName' class="error"></div>
            </div>
            <div class="col-sm-1">
                <a title="<?=SNAME_OF_LOCATION_TEXT?>" class="vtip"><b><small>?</small></b></a>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-5 text-left" for="storeName">Restaurant email<span class='mandatory'>*</span>:</label>
            <div class="col-sm-6">
                <input class="form-control" type=text name="email" value="<?=$data[0]['email']?>" id ="email">
                <div id='error_email' class="error"></div>
            </div>
            <div class="col-sm-1">
                <a title="<?=STORE_EMAIL_TEXT?>" class="vtip"><b><small>?</small></b></a>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-5 text-left" for="storeName">Restaurant phone<span class='mandatory'>*</span>:</label>
            <div class="col-sm-3">
                <?php 
                //if in phone input already code then pick there prefix
                //otherwise take from prefix column
                    $selected_prefix=$data[0]['phone_prefix'];
                    if($selected_prefix==null)
                    {
                        if(substr($data[0]['phone'], 0, 2)=="46")
                        {
                            $selected_prefix=46;
                        }
                        if(substr($data[0]['phone'], 0, 2)=="91")
                        {
                            $selected_prefix=91;
                        }
                        elseif(substr($data[0]['phone'], 0, 1)=="0")
                        {
                            $selected_prefix=46;
                        }
                        else
                        {
                            $selected_prefix=46;
                        }        
                    }
                    else
                    {
                        $selected_prefix=$data[0]['phone_prefix'];
                    }
                 ?>
                <select class="form-control" name="phone_prefix" id="phone_prefix">
                    <option <?php if($selected_prefix==46){ echo "selected"; }  ?> value="46" >Sweden - 46</option>  <!-- selected="selected" -->
                    <option <?php if($selected_prefix==91){ echo "selected"; }  ?> value="91" >India - 91</option>
                </select>
                <div id='error_phone_prefix' class="error"></div>
            </div>
            <div class="col-sm-3">
                <input class="form-control" type=text name="phoneNo"  value="<?=$data[0]['phone']?>" id ="phoneNo">
                <br>
                <div id='error_phoneNo' class="error"></div>
            </div>
            <div class="col-sm-1">
                <a title="<?=PHONE_NUMBER_TEXT?>" class="vtip"><b><small>?</small></b></a>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-5 text-left" for="storeName">Street Address<span class='mandatory'>*</span>:</label>
            <div class="col-sm-6">
                <input class="form-control" type=text name="streetaddStore" id ="streetaddStore" value="<?=$data[0]['street'] ?>" onChange="initialize()">
                <div id='error_streetaddStore' class="error" ></div>
            </div>
            <div class="col-sm-1">
                <a title="<?=STREET_ADDRESS_TEXT?>" class="vtip"><b><small>?</small></b></a>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-5 text-left" for="storeName">City<span class='mandatory'>*</span>:</label>
            <div class="col-sm-6">
                <input class="form-control" type=text name="cityStore" id ="cityStore" value="<?=$data[0]['city']?>" onChange="initialize()">
                <div id='error_cityStore' class="error" ></div>
            </div>
            <div class="col-sm-1">
                <a title="<?=CITY_TEXT?>" class="vtip"><b><small>?</small></b></a>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-5 text-left" for="storeName">Country<span class='mandatory'>*</span>:</label>
            <div class="col-sm-6">
                <select class="form-control" style=" background-color:#e4e3dd;"  tabindex="27"   name="countryStore" id ="countryStore" value="<?=$data[0]['country']?>" onChange="initialize()" >
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
            </div>
            <div class="col-sm-1">
                <a title="<?=COUNTRY_TEXT?>" class="vtip"><b><small>?</small></b></a>
            </div>
        </div>
        <!-- <div class="form-group">
            <label class="control-label col-sm-5 text-left" for="storeName">Block:</label>
            <div class="col-sm-6">
                <input class="form-control" type=text name="block" id ="block" value="<?=$data[0]['block']?>" >
                <div id='error_block' class="error" ></div>
            </div>
            <div class="col-sm-1">
                <a title="<?=BLOCK_TEXT?>" class="vtip"><b><small>?</small></b></a>
            </div>
        </div> -->
        <div class="form-group">
            <label class="control-label col-sm-5 text-left" for="storeName">Zip<span class='mandatory'>*</span>:</label>
            <div class="col-sm-6">
                <input class="form-control" type=text name="zip" id ="zip" value="<?=$data[0]['zip'] ?>">
                <div id='error_zip' class="error" ></div>
            </div>
            <div class="col-sm-1">
                <a title="<?=ZIP_TEXT?>" class="vtip"><b><small>?</small></b></a>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-5 text-left" for="storeName">Opening hours of the Location</label>
            <div class="col-sm-6">
                <?php include('elements/store-opening-hours.php'); ?>
            </div>
            <div class="col-sm-1">
                <a title="<?=STORE_OPEN_CLOSE_TEXT?>" class="vtip"><b><small>?</small></b></a>
            </div>
        </div>
        <div class="form-group" id="catering_open_close_row">
            <label class="control-label col-sm-5 text-left" for="storeName">Opening hours of the Location for catering</label>
            <div class="col-sm-6">
                <?php include('elements/store-catering-opening-hours.php'); ?>
            </div>
            <div class="col-sm-1">
                <a title="<?=STORE_OPEN_CLOSE_TEXT?>" class="vtip"><b><small>?</small></b></a>
            </div>
        </div>
        <div class="form-group" >
            <label class="control-label col-sm-5 text-left" for="storeName">Location is close following dates</label>
            <div class="col-sm-6">
                <div id="with-altField1">
                    <span class="cross"><img src="client/js/newJs/images/error.png"></span>
                </div>
                <div id="with-altField1"></div>
                <div id="withAltField1" class="box">
                    <img class="cal_icon" id="cal_icon" src="client/js/newJs/images/calendar.gif">   <input class="form-control" type="text" id="altField1" name="altField1" value="<?=$data[0]['store_close_dates']?>">
                    <label><?=$data[0]['store_close_dates']?></label>
                </div>
            </div>
            <div class="col-sm-1">
                <a title="<?=STORE_CLOSE_TEXT?>" class="vtip"><b><small>?</small></b></a>
            </div>
        </div>
        <div class="form-group" >
            <label class="control-label col-sm-5 text-left" for="storeName">Restaurant homepage:</label>
            <div class="col-sm-6">
                <input class="form-control" type=text name="link"  value="<?=$data[0]['store_link'] ?>" id ="link" >
                <div id='error_link' class="error"></div>
            </div>
            <div class="col-sm-1">
                <a title="<?=LINK_TO_THE_LOCATION_HOME_TEXT?>" class="vtip"><b><small>?</small></b></a>
            </div>
        </div>
        <div class="form-group" >
            <label class="control-label col-sm-5 text-left" for="storeName">Type of Restaurant</label>
            <div class="col-sm-6">
                <select class="form-control" style="background-color:#e4e3dd; height:36px;border: 1px solid #abadb3;" tabindex="27" id="typeofrestrurant" name="typeofrestrurant">
                    <option <? if ($data[0]['store_type'] == '1')echo "selected='selected'"; ?>   value="1">Eat Now</option>
                    <option <? if ($data[0]['store_type'] == '2')echo "selected='selected'"; ?>   value="2">Eat Later</option>
                    <option <? if ($data[0]['store_type'] == '3')echo "selected='selected'"; ?>   value="3">Both</option>
                </select>
            </div>
            <div class="col-sm-1">
                
            </div>
        </div>
        <div class="form-group" >
            <label class="control-label col-sm-5 text-left" for="storeName">Delivery Type</label>
            <div class="col-sm-6">
                 <?php
                $delivery_type = explode(',', $data[0]['delivery_type']);
                ?>
                <select class="form-control" id="delivery_type" name="delivery_type[]" multiple="" style=" height:55px;border: 1px solid #abadb3;">
                    <option value="1" <?php echo (in_array(1, $delivery_type)) ? "selected='selected'" : ''; ?>>Dine-in</option>
                    <option value="2" <?php echo (in_array(2, $delivery_type)) ? "selected='selected'" : ''; ?>>Take away</option>
                    <option value="3" <?php echo (in_array(3, $delivery_type)) ? "selected='selected'" : ''; ?>>Home Delivery</option>
                </select>
                <div id='error_delivery_type' class="error"></div>
            </div>
            <div class="col-sm-1">
                <a title="<?=DELIVERY_TYPE?>" class="vtip"><b><small>?</small></b></a>
            </div>
        </div>
        <div class="form-group" >
            <label class="control-label col-sm-5 text-left" for="storeName">Tag line For Location:
            </label>
            <div class="col-sm-6">
                  <input class="form-control"  type="text" name="tagline" id ="tagline" value="<?=$data[0]['tagline']?>" maxlength="50" />
                  <div id='error_storeName' class="error"></div>
            </div>
            <div class="col-sm-1">
                <a title="<?=RESTAURANT_TAGLINE?>" class="vtip"><b><small>?</small></b></a>
            </div>
        </div>
        <div class="form-group" >
            <label class="control-label col-sm-5 text-left" for="storeName"></label>
            <div class="col-sm-6">
                <input class="form-control" type="hidden" name="latitude" id="latitude" value="<?=$data[0]['latitude']?>"/>
                <input class="form-control" type="hidden" name="longitude" id="longitude" value="<?=$data[0]['longitude']?>" />
                <input class="form-control" name="zoom" id="zoom" value="<?=$zoom?>" type="hidden" style="width:150px;" />
                <div id='error_coordinate' class="error"></div>
            </div>
            <div class="col-sm-1">
                <a title="<?=STYPE_OF_TEXT?>" class="vtip"><b><small>?</small></b></a>
            </div>
        </div>
        <div class="form-group" >
            <label class="control-label col-sm-5 text-left" for="storeName">Map<span class='mandatory'>*</span>:</label>
            <div class="col-sm-6">
                <div id="map_canvas" style="height:320px;  border: 1px solid #99999b;"></div>
                <div id='error_coordinate' class="error"></div>
            </div>
            <div class="col-sm-1">
                <a title="<?=MAP_TEXT?>" class="vtip"><b><small>?</small></b></a>
            </div>
        </div>
        <div class="form-group" >
            <label class="control-label col-sm-5 text-left" for="storeName"></label>
            <div class="col-sm-5">
                You can set your location on map by click or drag
            </div>
            <div class="col-sm-2"></div>
        </div>
        <div class="form-group" >
            <label class="control-label col-sm-5 text-left" for="storeName">
                Upload Image For Restaurant<span class='mandatory'>*</span>:<br>
                <strong>Recommended: 1024x1024</strong>
            </label>
            <div class="col-sm-6">
                <div class="file-upload">
                    <button class="file-upload-btn" type="button" onclick="$('.file-upload-input').trigger( 'click' );$('.image-removed').val('0');">Add Image</button>
                    <div class="image-upload-wrap">
                        <input class="file-upload-input" type='file' id="imageStore" name="imageStore" onBlur="iconPreview(this.form);"  onchange="readURL(this);" accept="image/" />
                        <div class="drag-text">
                            <h3>Drag and drop a file or select add Image</h3>
                            <samp>Please upload only png/jpg/jpeg Image</samp>
                        </div>
                    </div>
                    <div class="file-upload-content">
                        <input type="hidden" name="image_removed" class="image-removed" value="0">
                        <input type="hidden" name="store_image_original" value="<?=$data[0]['store_image']?>">
                        <img class="file-upload-image" src="<?=$data[0]['store_image']?>" alt="<?=$data[0]['store_name']?>" onerror="removeUpload()"/>
                        <div class="image-title-wrap">
                            <button type="button" onclick="removeUpload()" class="remove-image">Remove <span class="image-title">Uploaded Image</span></button>
                        </div>
                    </div>
                </div>
                <div id='error_storeImage' class="error"></div>
                <div id='warning-store-image' class="warning"></div>
            </div>
            <div class="col-sm-1">
                
            </div>
        </div>
        <div class="form-group" >&nbsp;</div>
        <div class="panel panel-default">
          <div class="panel-heading">Update Subscription</div>
          <div class="panel-body">
              <table BORDER=0 width="100%" class="prod_table table table-striped" cellspacing="10" cellpadding="10">
                <thead>
                    <tr>
                        <th></th>
                        <th>S. No.</th>
                        <th colspan="2" style="padding-bottom: 10px; padding-right: 10px">Product Description</th>
                        <th>Free Intro</th>
                        <th>Unit Price(kr)</th>
                        <th>Fee / Month (kr)</th>
                        <th>One time (kr)</th>
                        <th>Action</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    $i = 1;
                    foreach ($products as $key => $product) {
                      if($product['product_type'] == 1 && !is_numeric($product['up_id']))
                      {
                        continue;
                      }
                    ?>
                        <tr class="prods">
                            <td align="left">
                                <input type="checkbox" name="plan_id[]" value="<?=$product['plan_id']?>" <?php echo ($product['package_ids'] == '1') ? "checked='checked' readonly" : "" ?> <?php echo (is_numeric($product['up_id'])) ? "checked='checked' disabled" : ''; ?> data-amount="<?php echo $product['price']; ?>" data-package="<?php echo $product['package_ids']; ?>" data-tax="25" data-price_type="<?php echo $product['price_type']; ?>">
                                <label for="plan_id<?php echo $product['plan_id']; ?>"></label>
                            </td>
                            <td><?php echo $i; ?></td>
                            <td align="left" colspan="2" style="padding-right: 10px; padding-left: 10px">
                                <?php
                                if($product['package_ids'] == '1' || !empty($product['mappedPackages'])){ 
                                ?>
                                    <div class="panel-group">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                <a data-toggle="collapse" href="#collapse<?php echo $product['id'] ?>"><?php echo $product['product_name']; ?><span class="caret pull-right"></span></a>
                                                </h4>
                                            </div>
                                            <div id="collapse<?php echo $product['id'] ?>" class="panel-collapse collapse">
                                                <ul class="list-group">
                                                    <?php
                                                    if(!empty($product['mappedPackages']))
                                                    {
                                                        foreach($product['mappedPackages'] as $row)
                                                        {
                                                            ?>
                                                            <li class="list-group-item">
                                                                <?php echo $row; ?>
                                                            </li>
                                                            <?php
                                                        }
                                                    }
                                                    else
                                                    {
                                                        ?>
                                                        <li class="list-group-item">Order status (incoming and delivered orders)</li><li class="list-group-item">Delivery and Payment confirmation</li><li class="list-group-item">Menu (Edit and add new dishes to Menu)</li><li class="list-group-item">Administration support (Change company setting and information)</li><li class="list-group-item">Additional features under “More” ooo</li>
                                                        <?php
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                <?php }else{ ?>   
                                    <?=$product['product_name']?>
                                <?php } ?>
                            </td>
                            <td>
                                <?php echo ($product['trial_period'] && ($product['price_type'] == '1')) ? $product['trial_period'].' Days' : 'No'; ?>
                            </td>
                            <td align="left">
                                <?= number_format(($product['price']), 2, '.', '')." (" .$product['currency'].")"?>
                            </td>
                            <td align="left">
                                <?php
                                if($product['price_type'] == '1')
                                {
                                  echo number_format(($product['price']*1), 2, '.', '');
                                }
                                ?>
                            </td>
                            <td align="left">
                                <?php
                                if($product['price_type'] == '2')
                                {
                                  echo number_format(($product['price']*1), 2, '.', '');
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if( !is_null($product['subscription_item']) && $product['package_ids'] != '1' && $product['price_type'] == '1' )
                                {
                                    ?>
                                    <a href="javascript:removeSubscriptionItem('<?php echo $product['subscription_item'] ?>')" data-toggle="tooltip" data-placement="top" title="Remove package">Remove</a>
                                    <?php
                                }
                                ?>
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
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td align="left">
                        <div><strong>Sub Total: </strong></div>
                        <div><strong>Tax: </strong></div>
                        <div><strong>Total: </strong></div>
                      </td>
                      <td>
                        <div class="display-sub-total-recurring"><?=number_format($total, 2, '.', '');?></div>
                        <div class="display-tax-recurring"><?=number_format($total, 2, '.', '');?></div>
                        <div class="display-total-recurring"><?=number_format($total, 2, '.', '');?></div>
                      </td>
                      <td>
                        <div class="display-sub-total-onetime"><?=number_format($total, 2, '.', '');?></div>
                        <div class="display-tax-onetime"><?=number_format($total, 2, '.', '');?></div>
                        <div class="display-total-onetime"><?=number_format($total, 2, '.', '');?></div>
                      </td>
                      <td>&nbsp;</td>
                    </tr>
                </tbody>
            </table>
              <div class="block-total row hidden">
                  <div class="col-md-9 text-right"><strong>Sub Total:</strong></div>
                  <div class="col-md-3 subscription-sub-total" style="padding-left: 97px;"><?=number_format($total, 2, '.', '');?></div>
                  <div class="col-md-9 text-right"><strong>Tax: </strong></div>
                  <div class="col-md-3 subscription-tax" style="padding-left: 97px;"><?=number_format($total, 2, '.', '');?></div>
                  <div class="col-md-9 text-right"><strong>Total: </strong></div>
                  <div class="col-md-3 subscription-total" style="padding-left: 97px;"><?=number_format($total, 2, '.', '');?></div>
                  <div class="col-md-12">
                      <strong>Total Services fee per month: 
                          <span class="subscription-total"><?=number_format($total, 2, '.', '');?></span> SEK (Valid after free introduction period)
                      </strong>
                  </div>
                  <div class="col-md-12">
                      <small>Note*: The total value of (SUM)  will be deducted from you account after end of trial period.</small>
                  </div>
              </div>
              <div class="panel panel-info panel-make-payment">
                  <div class="panel-heading">Make payment</div>
                  <div class="panel-body">
                      <div class="row">
                          <?php
                          $isCardDefault = false;
                          if(isset($paymentMethod->data))
                          {
                              $i = 0;
                              if( count($paymentMethod->data) == 1 )
                              {
                                  $isCardDefault = true;
                              }
                              ?>
                              <div class="col-md-12 row-saved-cards">
                                  <?php
                                  foreach($paymentMethod->data as $row)
                                  {
                                      ?>
                                      <div class="radio">
                                          <label>
                                              <input type="radio" name="payment_method_id" id="payment-method-<?=$i;?>" value="<?=$row->id;?>" <?php echo ($isCardDefault) ? 'checked' : ''; ?>>
                                              <i class="fa fa-cc-visa" aria-hidden="true"></i>
                                              <i class="fa fa-circle" aria-hidden="true" style="font-size: 9px;"></i><i class="fa fa-circle" aria-hidden="true" style="font-size: 9px;"></i><i class="fa fa-circle" aria-hidden="true" style="font-size: 9px;"></i><i class="fa fa-circle" aria-hidden="true" style="font-size: 9px;"></i>
                                              <?php echo $row->card->last4; ?>
                                          </label>
                                          <button type="button" class="btn btn-link btn-xs" onclick="deleteSource('<?php echo $row->id; ?>', this)">Delete</button>
                                      </div>
                                      <?php
                                      $i++;
                                  }
                                  ?>
                                  <div class="card-errors"></div>
                                  <button type="button" id="charging-saved-cards" class="hidden">Pay Securely</button>
                              </div>
                              <?php
                          }
                          ?>
                          <div class="col-md-12 row-new-card">
                              <label>
                                  <input type="radio" name="pay-options" id="pay-options" <?php echo ($isCardDefault == false) ? 'checked' : ''; ?>> Credit card / Debit card
                              </label>
                              <div class="section-pay-with-card <?php echo ($isCardDefault == false) ? '' : ' hidden'; ?>">
                                  <div id="card-element"></div>
                                  <div class="card-errors"></div>
                                  <button type="button" id="card-button" class="hidden">Pay</button>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
         <div align="center"><br />
            <br />
            <input type="checkbox" name="onlinePayment" value="1" <?php echo ($data[0]['online_payment']) ? 'checked="checked" readonly' : '' ?> style="display: none;" />
            <input type="button" value="Update" name="continue" class="button" id="continue" >
            <input type="button" value="Back" name="" class="button" onClick="javascript:location.href='<?=$_SERVER[HTTP_REFERER]
               ?>';" >
            <input type="hidden" id="stripe_token" name="stripe_token" value="">
            <br />
            <br />
         </div>
      </form>
      <span class='mandatory'>* These Fields Are Mandatory </span>
   </div>

    <!-- Loading modal -->
    <div class="modal fade" id="modal-loading" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div clas="loader-txt">
                        <p>Loading...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
   </div>
   <? include("footer.php"); ?>

   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
   <!-- <script src="https://checkout.stripe.com/checkout.js"></script> -->
   <script src="https://js.stripe.com/v3/"></script>
</body>
</html>
<script>
    cdata='<?php  echo $data[0]['store_open_close_day_time_catering']; ?>';
    cdata1='<?php  echo $data[0]['store_open_close_day_time']; ?>';
    console.log(cdata); 
    if(cdata!=cdata1)
    {
        $('#catering_open_close_row').show();        
    }
    else
    {
        $('#catering_open_close_row').hide();        
    }    
     
    $("#catering_open_close").change(function() {
    catering_option=$('#catering_open_close').is(":checked"); 
    if(catering_option==true)
    {
        $('#catering_open_close_row').show();
    }
    else
    {
        $('#catering_open_close_row').hide();        
    }   
    });
</script>
<script type="text/javascript">
    stripePayment = "<?php echo $stripePayment ?>";

    // Initialize Stripe and card element
    var stripe = Stripe('<?php echo STRPIE_PUB_KEY; ?>');

    var elements = stripe.elements();
    var cardElement = elements.create('card', {
        hidePostalCode: true
    });
    cardElement.mount('#card-element');

    // Pay with Card
    // var cardholderName = document.getElementById('cardholder-name');
    var cardButton = document.getElementById('card-button');
    cardButton.addEventListener('click', function(ev) {
        ev.preventDefault();

        if( !$('#stripe_token').val().length && $('input[name="plan_id[]"]:checked').not('[disabled]').length )
        {
            $('#modal-loading').modal('show');
            $('#continue').prop('disabled', true);
            let planIds = $('input[name="plan_id[]"]:checked').not('[disabled]').map(function () {
                return this.value;
            }).get();
            let totalAmount = parseFloat($('.subscription-total').html());

            if(totalAmount)
            {
              let tokenId;
              // stripe.createPaymentMethod('card', cardElement).then(function(result) {
              stripe.createToken(cardElement).then(function(result) {
                  if (result.error) {
                      // Display error.message in your UI.
                      let message = result.error;
                      if( typeof(result.error) == 'object' ) {
                          message = result.error.message;
                      }
                      $('.row-new-card').find('div.card-errors').html(message);
                      $('#stripe_token').val('');
                      $('#modal-loading').modal('hide');
                      $('#continue').prop('disabled', false);
                  } else {
                      tokenId = result.token.id;
                      confirmStoreSubscription(planIds, tokenId);
                  }
              });
            }
            else
            {
              confirmStoreSubscription(planIds);
            }
        }
        else
        {
            // $('#registerform').submit();
        }
    });

    // 
    function confirmStoreSubscription(planIds, tokenId)
    {
      // Check if it has the Payment package, open Stripe create account help PDF 
      let packages = '';

      $('input[name="plan_id[]"]:checked').each(function() {
          if(packages)
          {
              packages += ','+$(this).data('package');
          }
          else
          {
              packages += $(this).data('package');
          }
      });

      packages = packages.toString().split(',');

      if( packages.indexOf('5') != -1 )
      {
          openWindow();
      }

      // 
      let data = {
          // 'stripe_token': $('#stripe_token').val(),
          'store_id': $('input[name=storeId]').val(),
          'store_name': $('#storeName').val(),
          'plan_id': planIds
      };

      // 
      if(tokenId)
      {
        $('#stripe_token').val(tokenId);
        data.stripe_token = $('#stripe_token').val();
      }
      
      // 
      fetch('<?php echo BASE_URL ?>classes/billing.php', {
          method: 'POST',
          body: 'confirmStoreSubscription__='+encodeURIComponent( JSON.stringify(data) ),
          headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
          },
      }).then(function(result) {
          // Handle server response (see Step 3)
          result.json().then(function(json) {
              // console.log(json);
              handleServerResponse(json);
          })
      });
    }

    // Handle subscription response
    function handleServerResponse(response) {
        if (response.error) {
            // Show error from server on payment form
            let message = response.error;
            if( typeof(response.error) == 'object' ) {
                message = response.error.message;
            }
            $('.row-new-card').find('div.card-errors').html(message);
            $('#stripe_token').val('');
            $('#modal-loading').modal('hide');
            $('#continue').prop('disabled', false);
        } else if (response.requires_action) {
            // Use Stripe.js to handle required auth action
            stripe.handleCardPayment(response.payment_intent_client_secret).then(function(result) {
                if(result.error)
                {
                    // Display error.message in your UI.
                    let message = result.error;
                    if( typeof(result.error) == 'object' ) {
                        message = result.error.message;
                    }
                    $('.row-new-card').find('div.card-errors').html(message);
                    $('#stripe_token').val('');
                    $('#modal-loading').modal('hide');
                    $('#continue').prop('disabled', false);
                }
                else
                {
                    $('#modal-loading').modal('hide');
                    $('#registerform').submit();
                }
            });
        } else {
            $('#modal-loading').modal('hide');
            $('#registerform').submit();
        }
    }

    // Pay with PaymentMethod (saved card)
    $('#charging-saved-cards').on('click', function(ev) {
        ev.preventDefault();

        if( $('input[name=payment_method_id]:checked').length && $('input[name="plan_id[]"]:checked').not('[disabled]').length )
        {
            // Check if it has the Payment package, open Stripe create account help PDF 
            let packages = '';

            $('input[name="plan_id[]"]:checked').each(function() {
                if(packages)
                {
                    packages += ','+$(this).data('package');
                }
                else
                {
                    packages += $(this).data('package');
                }
            });

            packages = packages.toString().split(',');

            if( packages.indexOf('5') != -1 )
            {
                openWindow();
            }

            // 
            $('#modal-loading').modal('show');
            $('#continue').prop('disabled', true);
            let planIds = $('input[name="plan_id[]"]:checked').not('[disabled]').map(function () {
                return this.value;
            }).get();

            // 
            let data = {
                // 'payment_method_id': $('input[name=payment_method_id]:checked').val(),
                'store_id': $('input[name=storeId]').val(),
                'plan_id': planIds
            };

            let totalAmount = parseFloat($('.subscription-total').html());

            if(totalAmount)
            {
              data.payment_method_id = $('input[name=payment_method_id]:checked').val();
            }
            
            // 
            fetch('<?php echo BASE_URL ?>classes/billing.php', {
                method: 'POST',
                body: 'confirmStoreSubscription__='+encodeURIComponent( JSON.stringify(data) ),
                headers: {
                  "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
                },
            }).then(function(result) {
                // Handle server response (see Step 3)
                result.json().then(function(json) {
                    handleServerResponseSavedCard(json);
                })
            });
        }
        else
        {
            $('#registerform').submit();
        }
    });

    // Handle response when pay with 'saved card' 
    function handleServerResponseSavedCard(response) {
        if (response.error) {
            // Show error from server on payment form
            let message = response.error;
            if( typeof(response.error) == 'object' ) {
                message = response.error.message;
            }
            $('.row-saved-cards').find('div.card-errors').html(message);
            $('#modal-loading').modal('hide');
            $('#continue').prop('disabled', false);
        } else if (response.requires_action) {
            // Use Stripe.js to handle required auth action
            stripe.handleCardPayment(response.payment_intent_client_secret).then(function(result) {
                if(result.error)
                {
                    // Display error.message in your UI.
                    let message = result.error;
                    if( typeof(result.error) == 'object' ) {
                        message = result.error.message;
                    }
                    $('.row-saved-cards').find('div.card-errors').html(message);
                    $('#modal-loading').modal('hide');
                    $('#continue').prop('disabled', false);
                }
                else
                {
                    $('#modal-loading').modal('hide');
                    $('#registerform').submit();
                }
            });
        } else {
            $('#modal-loading').modal('hide');
            $('#registerform').submit();
        }
    }

    // Delete source
    function deleteSource(sourceId = null, This)
    {
        if( confirm('Are you sure you want to delete this card?') )
        {
            let $this = $(This);
            $('#modal-loading').modal('show');

            $.ajax({
                type: 'POST',
                url: '<?php echo BASE_URL ?>classes/billing.php',
                data: {
                    'deleteSource': 1,
                    'sourceId': sourceId
                },
                dataType: 'json',
                success: function(response) {
                    if(response.deleted)
                    {
                        $this.closest('.radio').remove();
                    }

                    $('#modal-loading').modal('hide');
                }
            });
        }
    }

    // Remove subscription item
    function removeSubscriptionItem(subscriptionItem = null)
    {
        if( confirm('Are you sure you want to remove this item?') )
        {
            $('#modal-loading').modal('show');

            $.ajax({
                type: 'POST',
                url: '<?php echo BASE_URL ?>classes/billing.php',
                data: {
                    'removeSubscriptionItem': 1,
                    'subscriptionItem': subscriptionItem
                },
                dataType: 'json',
                success: function(response) {
                    if(response.deleted || response.status)
                    {
                        window.location.reload();
                    }
                    else if(response.error)
                    {
                        alert(response.error);
                    }

                    $('#modal-loading').modal('hide');
                }
            });
        }
    }

    // 
    $(document).ready(function(){
        $('input[name=payment_method_id]').on('click', function() {
            $('#pay-options').prop('checked', false);
            $('.section-pay-with-card').addClass('hidden');
        });

        // 
        $('#pay-options').on('click', function() {
            $('input[name=payment_method_id]').prop('checked', false);
            $('.section-pay-with-card').removeClass('hidden');
        });

        // 
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
        $("input[name = openingDaysCatering]").click(function(){
            var vals = $(this).val();
            vals = 'catall'+vals;
            if(vals=='catall1'){
                $('.catall1').show();
                $('.catall2').hide();
            }else{
                $('.catall2').show();
                $('.catall1').hide();
            }
        });

        // Update total
        $('input[name="plan_id[]"]').change(function() {
            var inputFields = '';
            var packages = ($(this).data('package')).toString().split(',');
            var checkedValue = $(this).is(':checked') ? true : false;

            // Update 'onlinePayment' fields
            if(packages.indexOf('5') != -1)
            {
                inputFields = 'onlinePayment';
                $('input[name="'+inputFields+'"]').prop('checked', checkedValue);
            }

            // Update 'typeofrestrurant'
            if(packages.indexOf('4') != -1)
            {
                if(checkedValue)
                {
                    $('#typeofrestrurant').val('3');
                }
                else
                {
                    $('#typeofrestrurant').val('1');
                }
            }

            // Home delivery
            if(packages.indexOf('12') != -1)
            {
              let selectedDeliveryTypes = $('#delivery_type').val();

              if(checkedValue)
              {
                selectedDeliveryTypes.push('3');
              }
              else
              {
                let index = selectedDeliveryTypes.indexOf('3');
                selectedDeliveryTypes.splice(index);
              }
              
              $('#delivery_type').val(selectedDeliveryTypes);
            }

            if(checkedValue && packages.indexOf('16') != -1)
            {
                alert("From admin@datjar.com: \nYou will get a mail from us as soon the new website is available. \nIt can take from 10 minutes up to a couple of hours to finish the process so we can send the mail. \nYou can then login with you userid and password and select your website and select your wanted template. \nYou can also change domain etc in settings");
            }

            // Update total
            updateTotal();

            // Check if added plan including payment plan, and Stripe payment not been added before
            if(checkedValue && stripePayment == 'No')
            {
                if(packages.indexOf('5') != -1)
                {
                    alert("Stripe & IBAN\nYou will be redirected to our payment partner Stripe to get your company account details. Stripe is one of the most reliable payment systems in the World. Please follow the instructions and fill in the required information. \n\n- Step 1 Company card details\nWe are using electronic invoice. Please fill in your company card details.\nYou’ll receive a confirmation for each invoice on your e-mail. By doing so, we’ll contribute to a better environment for all of us.\n\n- Step 2 This information is needed for transferring all customer payments to your company account.\n\nNote: Stripe requires IBAN (International Bank Account Number). You can find IBAN, either in your internet bank or call your bank to help you.");
                }
            }
        });

        if(typeof("<?=$data[0]['store_image']?>") != "undefined" && "<?=$data[0]['store_image']?>" !== null){
            $('.image-upload-wrap').hide();
            $('.file-upload-image').attr('src', "<?=$data[0]['store_image']?>");
            $('.file-upload-image').attr('alt', "<?=$data[0]['store_name']?>");
            $('.file-upload-content').show();
            $('.image-title').html("Image");
        }

        // Tooltip
        $('[data-toggle="tooltip"]').tooltip();
      });

     $(function(){
      $('[id*=Open], [id*=Close]').change(function()
      {
        openingDays = $('input[name=openingDays]:checked').val();
        var dataString = new Array();
        var i = 0;
        if(openingDays == 1){
          if($('[id*=allOpen]').val() != '' && $('[id*=allClose]').val() != ''){
            dataString = 'All :: '+$('[id*=allOpen]').val()+' to '+$('[id*=allClose]').val();
          }
        }else if(openingDays == 2){
          if($('[id*=monOpen]').val() != '' && $('[id*=monClose]').val() != ''){
            dataString[i] = 'Mon :: '+$('[id*=monOpen]').val()+' to '+$('[id*=monClose]').val();
            i = i+1;
          }
          if($('[id*=tueOpen]').val() != '' && $('[id*=tueClose]').val() != ''){
            dataString[i] = ['Tue :: '+$('[id*=tueOpen]').val()+' to '+$('[id*=tueClose]').val()];
            i = i+1;
          }
          if($('[id*=wedOpen]').val() != '' && $('[id*=wedClose]').val() != ''){
            dataString[i] = ['Wed :: '+$('[id*=wedOpen]').val()+' to '+$('[id*=wedClose]').val()];
            i = i+1;
          }
          if($('[id*=thuOpen]').val() != '' && $('[id*=thuClose]').val() != ''){
            dataString[i] = ['Thu :: '+$('[id*=thuOpen]').val()+' to '+$('[id*=thuClose]').val()];
            i = i+1;
          }
          if($('[id*=friOpen]').val() != '' && $('[id*=friClose]').val() != ''){
            dataString[i] = ['Fri :: '+$('[id*=friOpen]').val()+' to '+$('[id*=friClose]').val()];
            i = i+1;
          }
          if($('[id*=satOpen]').val() != '' && $('[id*=satClose]').val() != ''){
            dataString[i] = ['Sat :: '+$('[id*=satOpen]').val()+' to '+$('[id*=satClose]').val()];
            i = i+1;
          }
          if($('[id*=sunOpen]').val() != '' && $('[id*=sunClose]').val() != ''){
            dataString[i] = ['Sun :: '+$('[id*=sunOpen]').val()+' to '+$('[id*=sunClose]').val()];
            i = i+1;
          }

        }
         document.getElementById('opencloseTimeing').value=dataString;
         $.ajax({
            type: "POST",
            url: "storeOpenCloseTime.php?",
            data: dataString,
            success: function (response) {
               $data = JSON.parse(response);
               // $('#addDishType-popup').hide();
            },
            failure: function (response) {
               alert(response.responseText);
            },
            error: function (response) {
               alert(response.responseText);
            }
         });
      });



      $('[id*=OpenCatering], [id*=CloseCatering]').change(function()
      {

        openingDaysCatering = $('input[name=openingDaysCatering]:checked').val();
        var dataString = new Array();
        var i = 0;
        if(openingDaysCatering == 1){
          if($('[id*=allOpenCatering]').val() != '' && $('[id*=allCloseCatering]').val() != ''){
            dataString = 'All :: '+$('[id*=allOpenCatering]').val()+' to '+$('[id*=allCloseCatering]').val();
          }
        }else if(openingDaysCatering == 2){
          if($('[id*=monOpenCatering]').val() != '' && $('[id*=monCloseCatering]').val() != ''){
            dataString[i] = 'Mon :: '+$('[id*=monOpenCatering]').val()+' to '+$('[id*=monCloseCatering]').val();
            i = i+1;
          }
          if($('[id*=tueOpenCatering]').val() != '' && $('[id*=tueCloseCatering]').val() != ''){
            dataString[i] = ['Tue :: '+$('[id*=tueOpenCatering]').val()+' to '+$('[id*=tueCloseCatering]').val()];
            i = i+1;
          }
          if($('[id*=wedOpenCatering]').val() != '' && $('[id*=wedCloseCatering]').val() != ''){
            dataString[i] = ['Wed :: '+$('[id*=wedOpenCatering]').val()+' to '+$('[id*=wedCloseCatering]').val()];
            i = i+1;
          }
          if($('[id*=thuOpenCatering]').val() != '' && $('[id*=thuCloseCatering]').val() != ''){
            dataString[i] = ['Thu :: '+$('[id*=thuOpenCatering]').val()+' to '+$('[id*=thuCloseCatering]').val()];
            i = i+1;
          }
          if($('[id*=friOpenCatering]').val() != '' && $('[id*=friCloseCatering]').val() != ''){
            dataString[i] = ['Fri :: '+$('[id*=friOpenCatering]').val()+' to '+$('[id*=friCloseCatering]').val()];
            i = i+1;
          }
          if($('[id*=satOpenCatering]').val() != '' && $('[id*=satCloseCatering]').val() != ''){
            dataString[i] = ['Sat :: '+$('[id*=satOpenCatering]').val()+' to '+$('[id*=satCloseCatering]').val()];
            i = i+1;
          }
          if($('[id*=sunOpenCatering]').val() != '' && $('[id*=sunCloseCatering]').val() != ''){
            dataString[i] = ['Sun :: '+$('[id*=sunOpenCatering]').val()+' to '+$('[id*=sunCloseCatering]').val()];
            i = i+1;
          }

        }
         document.getElementById('opencloseTimeingCatering').value=dataString;
         $.ajax({
            type: "POST",
            url: "storeOpenCloseTime.php?",
            data: dataString,
            success: function (response) {
               $data = JSON.parse(response);
               // $('#addDishType-popup').hide();
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

      // Store delivery type, dine-in/take away/home delivery
      $(document).on('change', '#delivery_type', function() {
        deliveryType = $("#delivery_type option:selected").map(function(){ return this.value }).get().join(",");
        deliveryType = deliveryType.split(',');

        if(!$('input[name="plan_id[]"][data-package=12]').prop('disabled'))
        {
            if(deliveryType.indexOf('3') != -1)
            {
                $('input[name="plan_id[]"][data-package=12]').prop('checked', true);
            }
            else
            {
                $('input[name="plan_id[]"][data-package=12]').prop('checked', false);
            }
        }

        updateTotal();
      });
   });

     // Update plan on load
     $(window).load(function() {
        updateTotal();
     });

     // Update plan
     function updatePlan()
     {
        var typeOfRestrurant = $('#typeofrestrurant option:selected').val();
        addPlan = [];

        if(typeOfRestrurant != '1')
        {
            addPlan.push('4');
        }

        // $('input[name="plan_id[]"]:not([readonly])').prop('checked', false);
        
        if(addPlan.length)
        {
            for(index = 0; index < addPlan.length; index++)
            {
                $('input[name="plan_id[]"][data-package='+addPlan[index]+']').prop('checked', true);
            }
        }

        // Update total
        updateTotal();
     }

     // Sum amount of selected packages and update total
     function updateTotal()
     {
        var subTotal = taxTotal = tax = amount = priceType = 0;
        var subTotalRecurring = taxTotalRecurring = 0;
        var subTotalOnetime = taxTotalOnetime = 0;

        $('input[name="plan_id[]"]:checked').not('[disabled]').each(function() {
            tax = ( $(this).data('amount') * $(this).data('tax') ) / 100;
            amount = parseFloat($(this).data('amount'));

            priceType = $(this).data('price_type');

            if(priceType == '1')
            {
              subTotalRecurring += amount;
              taxTotalRecurring += tax;
            }
            else if(priceType == '2')
            {
              subTotalOnetime += amount;
              taxTotalOnetime += tax;
            }

            taxTotal += tax;
            subTotal += amount;
        });

        var totalAmount = subTotal + taxTotal;
        var totalAmountRecurring = subTotalRecurring + taxTotalRecurring;
        var totalAmountOnetime = subTotalOnetime + taxTotalOnetime;

        $('.display-sub-total-recurring').html(subTotalRecurring.toFixed(2));
        $('.display-tax-recurring').html(taxTotalRecurring.toFixed(2));
        $('.display-total-recurring').html(totalAmountRecurring.toFixed(2));

        $('.display-sub-total-onetime').html(subTotalOnetime.toFixed(2));
        $('.display-tax-onetime').html(taxTotalOnetime.toFixed(2));
        $('.display-total-onetime').html(totalAmountOnetime.toFixed(2));

        $('.subscription-sub-total').html(subTotal.toFixed(2));
        $('.subscription-tax').html(taxTotal.toFixed(2));
        $('.subscription-total').html(totalAmount.toFixed(2));

        if(totalAmount)
        {
          $('.panel-make-payment').show();
        }
        else
        {
          $('.panel-make-payment').hide();
        }
     }
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
            $('.image-removed').val("1");
            $('.file-upload-content').hide();
            $('.image-upload-wrap').show();
        }

        $('.image-upload-wrap').bind('dragover', function () {
            $('.image-upload-wrap').addClass('image-dropping');
        });

        $('.image-upload-wrap').bind('dragleave', function () {
            $('.image-upload-wrap').removeClass('image-dropping');
        });
        
        // 
        function openWindow()
        {
            windowWidth = ($(window).width()/2)-10;
            windowHeight = $(window).height(); 
            window.open('https://dastjar-admin.s3-eu-west-1.amazonaws.com/uploads/stripe-account-activation-form.pdf', '_blank', 'height='+windowHeight+',width='+windowWidth+',top=0,left='+windowWidth)
        }
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
