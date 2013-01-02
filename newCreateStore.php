<?php
/* File Name   : addCompany.php
 *  Description : Add Company Form
 *  Author      : Himanshu Singh  Date: 12th,Nov,2010  Creation
 */
header('Content-Type: text/html; charset=ISO-8859-15');
include_once("cumbari.php");
$storeObj = new store();
$regObj = new registration();
$data = $storeObj->getCompanyDetail($_SESSION['userid']);
$data1 = $storeObj->getEmailId($_SESSION['userid']);
$countryList = $regObj->getCountryList();
//$data = $storeObj->getCompanyDetail($_SESSION['userid']);
//print_r($data);
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
<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false"></script>
<script language="JavaScript" src="client/js/jsStore.js" type="text/javascript"></script>
<style type="text/css">
<!--
.center{width:900px; margin-left:auto; margin-right:auto;}
-->
</style><body>
<div class="center">
<form name="registerform" action="" id="registerform" method="POst">
        <input type="hidden" name="m" value="saveNewStore">
    <table width="100%"  border="0"><tr><td class="redwhitebutton">Add Location</td></tr></table>

    <table width="100%" border="0" cellspacing="15">

        <tr>
            
            <td width="50%" class="inner_grid">Name of location 
            		<span class='mandatory'>*</span>:</td>
            <td width="27%"><INPUT class="text_field_new" type=text name="storeName" id ="storeName" value="<?=$data[0]['company_name']
                                                                   ?>"><div id='error_storeName' class="error"></div>            </td>
        </tr>
        <tr>
            
            <td class="inner_grid">E-mail
            		<span class='mandatory'>*</span>:</td>
            <td> <INPUT class="text_field_new" type=text name="email" id ="email" value="<?=$data1[0]['email']
                                                                   ?>"><div id='error_email' class="error"></div>            </td>
        </tr>
        <tr>
            
            <td class="inner_grid">Link to the location home<span class='mandatory'>*</span>:</td>
            <td> <INPUT class="text_field_new" type=text name="link" id ="link" ><div id='error_link' class="error"></div>           </td>
        </tr>
        <tr>
            
            <td class="inner_grid">Phone Number<span class='mandatory'>*</span>:</td>
            <td> <INPUT class="text_field_new" type=text name="phoneNo" id ="phoneNo"><div id='error_phoneNo' class="error"></div>           </td>
        </tr>
        <tr>
            
            <td class="inner_grid">Select a method for receiving 
                Coupon data:</td>
            <td>
            <table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><input type="checkbox" name="BARCODE" value="BARCODE"/>BARCODE</td>
    <td width="30">&nbsp;</td>
    <td><input type="checkbox" name="PINCODE" value="PINCODE" disabled  checked />PINCODE</td>
  </tr>
  <tr>
    <td nowrap="nowrap"><input type="checkbox" name="MANUAL_SWIPE" value="MANUAL_SWIPE" disabled checked />MANUAL SWIPE</td>
    <td width="20">&nbsp;</td>
    <td nowrap="nowrap"><input type="checkbox" name="TIME_LIMIT" value="TIME_LIMIT" disabled checked />TIME LIMIT</td>
  </tr>
</table></td>
        </tr>
        <tr>
            
            <td class="inner_grid">Street Address<span class='mandatory'>*</span>:</td>
            <td><input class="text_field_new" type="text" name="streetaddStore" id ="streetaddStore" value="<?=$data[0]['street'] ?>" onChange="initialize()" />
           <div id='error_address' class="error"></div>            </td>
        </tr>
        <tr>
            
            <td class="inner_grid">City<span class='mandatory'>*</span>:</td>
            <td><input class="text_field_new" type="text" name="cityStore" id ="cityStore" value="<?=$data[0]['city'] ?>" onChange="initialize()" />
            <div id='error_cityStore' class="error"></div>            </td>
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
        </tr>

        <tr>

            <td class="inner_grid">Chain:</td>
            <td><input class="text_field_new" type="text" name="chain" id ="chain" value="<?=$data[0]['chain'] ?>" />
            <div id='error_chain' class="error"></div>            </td>
        </tr>

        <tr>

            <td class="inner_grid">Block:</td>
            <td><input class="text_field_new" type="text" name="block" id ="block" value="<?=$data[0]['block'] ?>"  />
            <div id='error_block' class="error"></div>            </td>
        </tr>

        <tr>

            <td class="inner_grid">Zip:</td>
            <td><input class="text_field_new" type="text" name="zip" id ="zip" value="<?=$data[0]['zip'] ?>" />
            <div id='error_zip' class="error"></div>            </td>
        </tr>
      
        <tr>
        		<td valign="top">Map<span class='mandatory'>*</span></td>
        		
        		<td><div id="map_canvas" style="height:320px; width:400px; border: solid 1px;"></div></td>
        		
        </tr>
          <tr>
            
             
             
            <td><div id='error_coordinate' class="error"></div></td>
           
        </tr>
        <tr><td></td><td> You can set your location on map by click or drag</td>
      </tr>
        <tr>
            <td colspan="4">
                <input type="hidden" name="longitude" value="<?=$longitude1 ?>" id="longitude" />
                <input type="hidden" name="latitude" value="<?=$latitude1 ?>" id="latitude" />
                <input name="zoom" id="zoom" value="<?=$zoom ?>" type="hidden" style="width:150px;" />        </tr>
    </table>
    <div align="center">
        <INPUT style="margin-left:700px;" type="submit" value="Submit" name="continue" id="continue" class="button" >
    <br />
    <br />
    </div>
</form>
<div>
    <span class='mandatory'>* These Fields Are Mandatory</span></div></div>
	<? include("footer.php"); ?>

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