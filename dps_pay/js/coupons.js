
function getLocation() {
// Get location no more than 1 minutes old. 60000 ms = 1 minutes.
        navigator.geolocation.getCurrentPosition(getCoupons, showError, {enableHighAccuracy:true,maximumAge:60000,timeout:0});
}

function showError(error) {
        altert(error.code + ' ' + error.message);
}

function getCoupons(position)
{
var mylat=position.coords.latitude;
var mylong=position.coords.longitude;
var myaccuracy=position.coords.accuracy;
var service="coupon";
var target_id="76a456d2-bff7-4e9e-87de-021027080342";
var rt_time=0.4;
var detection_mode="button";
var sequence_id=1;
var message="5bcc4d1a-cb5b-41ba-b549-95da9934009e";

xmlhttp=new XMLHttpRequest();
var url="connect.php";
url=url+"?long=";
url=url+mylong;
url=url+"&lat="+ mylat;
url=url+"&acc="+ myaccuracy + "&service=" + service + "&target_id=" + target_id + "&rt_time=" + rt_time + "&detection_mode=" + detection_mode + "&sequence_id=" + sequence_id + "&message=" + message;
xmlhttp.open("GET",url,false);
xmlhttp.send(null);
document.getElementById('res').innerHTML=xmlhttp.responseText;
}
