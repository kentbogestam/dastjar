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
<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false"></script>
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
          		<span class='mandatory'>*</span>:</td>
      <td width="415" >
        <INPUT class="text_field_new"  type=text name="storeName" id ="storeName" value="<?=$data[0]['store_name']
?>"><div id='error_storeName' class="error"></div>            </td>
       <td align="right"><a title="<?=NAME_OF_LOCATION_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
      </tr>
        <tr>
          
            <td class="inner_grid">E-mail<span class='mandatory'>*</span>:</td>
            <td>
                <INPUT class="text_field_new" type=text name="email" value="<?=$data[0]['email']
?>" id ="email"><div id='error_email' class="error"></div>            </td>
            <td align="right"><a title="<?=STORE_EMAIL_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
        </tr>
        <tr>
       
            <td class="inner_grid">Phone Number<span class='mandatory'>*</span>:</td>
            <td>
                <INPUT class="text_field_new" type=text name="phoneNo"  value="<?=$data[0]['phone']
?>" id ="phoneNo"><div id='error_phoneNo' class="error"></div>            </td>
             <td align="right"><a title="<?=PHONE_NUMBER_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
            
        </tr>
        <tr>
            
            <td class="inner_grid">Street Address<span class='mandatory'>*</span>:</td>
            <td>
                <INPUT class="text_field_new" type=text name="streetaddStore" id ="streetaddStore" value="<?=$data[0]['street']
?>" onChange="initialize()"><div id='error_streetaddStore' class="error" ></div>            </td>
            <td align="right"><a title="<?=STREET_ADDRESS_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
        </tr>
        <tr>
            
            <td class="inner_grid">City<span class='mandatory'>*</span>:</td>
            <td>
                <INPUT class="text_field_new" type=text name="cityStore" id ="cityStore" value="<?=$data[0]['city']
?>" onChange="initialize()"><div id='error_cityStore' class="error" ></div>            </td>
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

                <div id='error_countryStore' class="error" ></div>            </td>
             <td align="right"><a title="<?=COUNTRY_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
        </tr>

        <tr>

            <td class="inner_grid">Chain:</td>
            <td>
                <INPUT class="text_field_new" type=text name="chain" id ="chain" value="<?=$data[0]['chain']
?>" ><div id='error_chain' class="error" ></div>            </td>
            <td align="right"><a title="<?=CHAIN_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
        </tr>

        <tr>

            <td class="inner_grid">Block:</td>
            <td>
                <INPUT class="text_field_new" type=text name="block" id ="block" value="<?=$data[0]['block']
?>" ><div id='error_block' class="error" ></div>            </td>
              <td align="right"><a title="<?=BLOCK_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
        </tr>

        <tr>

            <td class="inner_grid">Zip:</td>
            <td>
                <INPUT class="text_field_new" type=text name="zip" id ="zip" value="<?=$data[0]['zip']
?>" ><div id='error_zip' class="error" ></div>            </td>
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
?>" id ="link" ><div id='error_link' class="error"></div>            </td>
             <td align="right"><a title="<?=LINK_TO_THE_LOCATION_HOME_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
        </tr>
                        <tr>
             
             <td class="inner_grid"></td>
             <td><input class="text_field_new" type="hidden" name="latitude" id="latitude" value="<?=$data[0]['latitude']
?>"/><input class="text_field_new" type="hidden" name="longitude" id="longitude" value="<?=$data[0]['longitude']
?>" />
                <input class="text_field_new" name="zoom" id="zoom" value="<?=$zoom
?>" type="hidden" style="width:150px;" />
                <div id='error_coordinate' class="error"></div>            </td>
        </tr>
        <tr>
            
            <td width="592" valign="top">Map
            		<span class='mandatory'>*</span>:</td>
          <td><div id="map_canvas" style="height:320px; width:400px; border: 1px solid #99999b;"></div></td>
           <td align="right" valign="top"><a title="<?=MAP_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
          
        </tr>
       <tr> <td></td>
        <td>You can set your location on map by click or drag</td></tr>
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
</div><? include("footer.php"); ?>

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