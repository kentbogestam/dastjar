<?
/*  File Name  : gdata.php
*  Description : To show map
*  Author      : Sushil Singh Date: 22th,Dec,2010  Creation
 */
header('Content-Type: text/html; charset=utf-8');
require_once('cumbari.php');
//$objComp = new users();
//$objconnection = new connection();
//$latitude = "64.396938";
//$longitude = "16.699219";
// Get request

$latitude = $_GET['latitude']; //"64.396938";
$longitude = $_GET['longitude']; //"16.699219";
$zoom = $_GET['zoom'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<title>Google Maps JavaScript API v3 Example: Event Simple</title>
<link href="http://code.google.com/apis/maps/documentation/javascript/examples/default.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
  var map;
var marker = null;
  function initialize() {
 // var address = "sec 43 Gurgaon India";
   var address = window.top.document.forms.registerform.elements.streetaddStore.value+" "+window.top.document.forms.registerform.elements.cityStore.value+" "+window.top.document.forms.registerform.elements.countryStore.value;
    geocoder = new google.maps.Geocoder();
	 
	var myLatlng = new google.maps.LatLng(<?=$latitude?>,<?=$longitude?>);
	//alert("int"+myLatlng);
    var myOptions = {
      zoom: <?=$zoom?>,
      center: myLatlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
	
	//codeAddress();
   // google.maps.event.addListener(map, 'zoom_changed', function() {
      //setTimeout(moveToDarwin, 1500);
   // });

	
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
		//alert(results[0].geometry.location);
        //var marker = new google.maps.Marker({
        //    map: map, 
		//alert(results[0].geometry.location);
		marker.setPosition(results[0].geometry.location);
		marker.setMap(map);
		addPoint(results[0].geometry.location);
           // position: results[0].geometry.location,
		//	draggable:true
       // });
      } else {
        //alert("Geocode was not successful for the following reason: " + status);
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

</script>
</head>
<body onLoad="initialize()">
  <div id="map_canvas"></div>
</body>

</html>
