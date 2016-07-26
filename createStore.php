<?php
/* File Name   : addCompany.php
 *  Description : Add Company Form
 *  Author      : Himanshu Singh  Date: 12th,Nov,2010  Creation
*/
header('Content-Type: text/html; charset=utf-8');
include_once("cumbari.php");
$regObj = new registration();
$regObj->isValidRegistrationStep();
$storeObj = new store();
$data = $storeObj->getCompanyDetail($_SESSION['userid']);
$data1 = $storeObj->getEmailId($_SESSION['userid']);
$countryList = $regObj->getCountryList();
//print_r($data);
if (isset($_POST['continue'])) {
//echo "In"; die();
    $storeObj->svrStoreDflt();
}
if ($data[0]['latitude'] && $data[0]['longitude']) {
    $latitude1 = $data[0]['latitude'];
    $longitude1 = $data[0]['longitude'];
    $zoom = 8;
} else {
    $latitude = "64.396938";
    $longitude = "16.699219";
    $zoom = 15;
}
//$zoom = "0";
include_once("header.php");
?>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false"></script>
<!--<script language="JavaScript" src="client/js/jsMap.js" type="text/javascript"></script>
--><script language="JavaScript" src="client/js/jsStore.js" type="text/javascript"></script>

<style type="text/css">
<!--
.center{width:900px; margin-left:auto; margin-right:auto;}

-->
</style><body>
<div class="center">
    <form name="registerform" action="" id="registerform" method="Post">
        <div id="main">
            <div id="mainbutton">
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                       
                        <td width="55%">&nbsp;</td>
                       
                    </tr>
                    <tr>
                        
                        <td width="55%" class="redwhitebutton" style="margin-top: 10px;">1 Register</td>
                       
                    </tr>
                    <tr>
                       
                        <td  >&nbsp;</td>
                        
                    </tr>
                    <tr>
                        
                        <td width="55%" class="redwhitebutton" style="margin-top: 10px;" >2 Add Company</td>
                        
                    </tr>
                    <tr>
                        
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                       
                        <td width="55%" class="redwhitebutton" style="margin-top: 10px;" >3 Add Offer</td>
                       
                    </tr>
                    <tr>
                       
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                       
                        <td  width="55%" class="blackbutton" style="margin-top: 10px;">4 Add Location</td>
                      
                    </tr>
                </table>

                <table width="100%" border=0 cellpadding="0" cellspacing="0" >
                    <tr>
                        <td width="72%">
                            <table width="100%"  border=0 cellpadding="0" cellspacing="0" >
                                <tr>

                                    <td width="59%">
                                        <table width="100%" border=0 cellpadding="0" cellspacing="15" >
                                            <tr>

                                                <td width="52%" >&nbsp;</td>
                                                <td width="47%"><input type="hidden" name="m" value="saveStore"></td>
                                            </tr>
                                            <tr>

                                                <td >Name of location 
                                                		<span class='mandatory'>*</span>:</td>
                                                <td width="47%" align="left">
                                                    <INPUT class="text_field_new" type=text name="storeName" id ="storeName" value="<?=$data[0]['company_name']
                                                                   ?>">
                                                    <div id='error_storeName' class="error"></div>          </td>
                                                 <td align="right"><a title="<?=NAME_OF_LOCATION_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
                                            </tr>
                                            <tr>

                                                <td  height="29">E-mail 
                                                		<span class='mandatory'>*</span>:</td>
                                                <td width="47%" align="left">
                                                    <INPUT class="text_field_new" type=text name="email" id ="email" value="<?=$data1[0]['email']
                                                                   ?>">
                                                    <div id='error_email' class="error"></div></td>
                                                 <td align="right"><a title="<?=STORE_EMAIL_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
                                                
                                            </tr>
                                            <tr>

                                                <td >Link to the location home<span class='mandatory'>*</span>:</td>
                                                <td align="left">
                                                    <INPUT class="text_field_new" type=text name="link" id ="link" >
                                                    <div id='error_link' class="error"></div>                                    </td>
                                                 <td align="right"><a title="<?=LINK_TO_THE_LOCATION_HOME_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
                                            </tr>
                                            <tr>

                                                <td >Phone Number<span class='mandatory'>*</span>:</td>
                                                <td align="left">
                                                    <INPUT class="text_field_new" type=text name="phoneNo" id ="phoneNo">
                                                    <div id='error_phoneNo' class="error"></div>                                    </td>
                                                
                                                <td align="right"><a title="<?=PHONE_NUMBER_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
                                            </tr>
                                            <tr>

                                                <td >Select a method for receiving Coupon data:</td>
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
                                                    
                                                    
                                            <!--  <input type="checkbox" name="BARCODE" value="BARCODE"/>BARCODE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                              <input type="checkbox" name="DPS" value="DPS" />DPS&nbsp;&nbsp;
            <input type="checkbox" name="PINCODE" value="PINCODE" disabled  checked />PINCODE&nbsp;&nbsp;<br/>
            <input type="checkbox" name="MANUAL_SWIPE" value="MANUAL_SWIPE" disabled checked />MANUAL SWIPE&nbsp;&nbsp;
            <input type="checkbox" name="TIME_LIMIT" value="TIME_LIMIT" disabled checked />TIME LIMIT&nbsp;&nbsp;
                                              -->
            </td>
                                               <td align="right"><a title="<?=METHOD_FOR_RECEIVING_COUPON_DATA_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
                                            </tr>
                                            
                                        </table></td>
                                    
                                </tr>
                                <tr>

                                    <td valign="top">
							 <table width="100%" height="159" border="0" cellpadding="0" cellspacing="15" >
                                            <tr>
                                                <td width="54%" height="33">Street Address
                                                		<span class='mandatory'>*</span>:</td>
                                                <td width="47%" align="left"><input class="text_field_new" type="text" name="streetaddStore" id ="streetaddStore" value="<?=$data[0]['street']
                                                                               ?>" onChange="initialize()" />
                                                 		<div id='error_address' class="error"></div>                                                </td>
                                                 <td align="right"><a title="<?=STREET_ADDRESS_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
                                            </tr>
                                            <tr>
                                                <td height="32">City<span class='mandatory'>*</span>:</td>
                                                <td align="left"><input class="text_field_new" type="text" name="cityStore" id ="cityStore" value="<?=$data[0]['city']
                                                                   ?>" onChange="initialize()" />
                                               		<div id='error_cityStore' class="error"></div>                                                </td>
                                                     <td align="right"><a title="<?=CITY_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
                                            </tr>
                                            <tr>
                                                <td height="22">Country<span class='mandatory'>*</span>:</td>
                                                <td>

                                                      <select class="text_field_new" style="width:406px; background-color:#e4e3dd;"  tabindex="27"  name="countryStore" id ="countryStore" value="<?=$data[0]['cname']
                                                                   ?>" onChange="initialize()" >
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


                                                <div id='error_countryStore' class="error"></div>                                                </td>
                                                 <td align="right"><a title="<?=COUNTRY_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
                                            </tr>

                                             <tr>
                                                <td height="32">Chain<span class='mandatory'>*</span>:</td>
                                                <td align="left"><input class="text_field_new" type="text" name="chain" id ="chain" value="<?=$data[0]['chain']
                                                                   ?>" />
                                               		<div id='error_chain' class="error"></div>                                                </td>
                                                <td align="right"><a title="<?=CHAIN_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
                                            </tr>

                                             <tr>
                                                <td height="32">Block<span class='mandatory'>*</span>:</td>
                                                <td align="left"><input class="text_field_new" type="text" name="block" id ="block" value="<?=$data[0]['block']
                                                                   ?>" />
                                               		<div id='error_block' class="error"></div>                                                </td>
                                                <td align="right"><a title="<?=BLOCK_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
                                            </tr>

                                             <tr>
                                                <td height="32">Zip<span class='mandatory'>*</span>:</td>
                                                <td align="left"><input class="text_field_new" type="text" name="zip" id ="zip" value="<?=$data[0]['zip']
                                                                   ?>" />
                                               		<div id='error_zip' class="error"></div>                                                </td>
                                                 <td align="right"><a title="<?=ZIP_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
                                            </tr>
                                            
                                            <tr>
                                            		<td height="22" valign="top">Map<span class='mandatory'>*</span>:</td>
                                            		<td><table width="71%" border="0">
                                                             
                                            <tr>

                                                <td width="100%"><div id="map_msg"></div></td>
                                            </tr>
                                            <tr>

                                                <td><div id="map_canvas" style="height:320px; width:400px;  border: solid 1px;"></div></td>
                                                 <td align="right" valign="top"><a title="<?=MAP_TEXT?>" class="vtip"><b><small>?</small></b></a></td>   
                                            </tr>
                                            
                                         <!--   <tr>

                                                <td align="right"><input type="button" name="location" id="location" value="Submit Location" class="button" /></td>
                                            </tr> -->
                                            <tr>

                                                <td>
                                                    <input type="hidden" name="longitude" value="<?=$longitude1
                                                                   ?>" id="longitude" />
                                                   
                                                    <input type="hidden" name="latitude" value="<?=$latitude1
                                                                   ?>" id="latitude" />
                                                    <input name="zoom" id="zoom" value="<?=$zoom
                                                                   ?>" type="hidden" style="width:150px;" />
                                                    <div id='error_coordinate' class="error"></div></td>
                                            </tr>
                                             
                                            <tr>
                                              <td align="left">You can set your location on map by click or drag</td>
                                            </tr>
                                            <tr> 
                                            		<td align="right">
                                                            <div align="right">
                <INPUT type="submit" value="Submit" name="continue" id="continue" class="button" >
            </div></td>
                                            		</tr>
                                            <tr>
                                                <td></td>
                                            </tr>
                                        </table></td>
                                            		</tr>
                                        </table></td>
                                </tr>
                            </table>


                        </td>
                        
                    </tr>
                </table>
            </div>
            
            <table border="0" width="100%" cellpadding="0" cellspacing="0"> 
                 <tr>
                <td ><span class='mandatory'>* These Fields Are Mandatory</span></td>
            </tr>
                <tr>
                    
                    <td width="51%"class="redgraybutton">4 Activate</td>
                </tr>
                <tr>
                		<td>&nbsp;</td>
              		  </tr>
            </table>
           
            
        </div>
    </form>
    </div>
<? include_once("footer.php"); ?>
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
            window.top.document.forms.registerform.elements.latitude.value = point.lat();
            window.top.document.forms.registerform.elements.longitude.value = point.lng();
        }
    }
    function moveToDarwin() {
        var darwin = new google.maps.LatLng(<?=$latitude ?>,<?=$longitude ?>);
        map.setCenter(darwin);
    }
    function addPointOnClick(point) {
        window.top.document.forms.registerform.elements.latitude.value = point.lat();
        window.top.document.forms.registerform.elements.longitude.value = point.lng();
    }

    initialize();
</script>