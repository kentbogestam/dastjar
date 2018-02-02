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
   
   if (isset($_POST['continue'])) {
       //echo "In"; die();
       $storeObj->svrStoreDflt();
   } else {
       $storeid = $_GET['storeId']; //die();
       $data = $storeObj->getStoreDetailById($storeid);
   //echo "<pre>";print_r($data);echo "</pre>";
   }
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
<script language="JavaScript" src="client/js/jsStore.js" type="text/javascript"></script>
<style type="text/css">
   <!--
      .center{width:900px; margin-left:auto; margin-right:auto;}
      -->
</style>
<body>
   <div class="center">
      <form name="registerform" action="" id="registerform" method="Post">
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
            <tr>
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
            <tr>
               <td>Uplode Image For Restaurent<span class='mandatory'>*</span>:</td>
               <td>
                  <div class="file-upload">
                     <button class="file-upload-btn" type="button" onclick="$('.file-upload-input').trigger( 'click' )">Add Image</button>
                     <div class="image-upload-wrap">
                        <input class="file-upload-input" type='file' id="imageStore" name="imageStore" onBlur="iconPreview(this.form);"  onchange="readURL(this);" accept="image/png" />
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
   <? include("footer.php"); ?>
</body>
</html>
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