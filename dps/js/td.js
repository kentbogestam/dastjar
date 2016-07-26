
var service;
var target_id;
var rt_time;
var detection_mode;
var sequence_id;
var message={};


function getRD(){
device="td";
service="coupon, payment, valuecheck";
storeId="d76d54db2c04778a012c0477ef910029";
rt_time=0.1;
detection_mode="mouseDown";
sequence_id=1;
target_id=storeId;
// Check if there is an ID in the request if not add storeID 
//target_id==SharedId || storeId
message={ "posID" : 24356677};
getLocation();

}

function getLocation() {
// Get location no more than 1 minutes old. 60000 ms = 1 minutes.
        navigator.geolocation.getCurrentPosition(getTarget, showError, {enableHighAccuracy:true,maximumAge:60000,timeout:0});
}

function showError(error) {
        alert(error.code + ' ' + error.message);
}

function getTarget(position)
{
var mylat=position.coords.latitude;
var mylong=position.coords.longitude;
var myaccuracy=position.coords.accuracy;

xmlhttp=new XMLHttpRequest();
var url="td_dps.php";
url=url+"?long=";
url=url+mylong;
url=url+"&lat="+ mylat;
url=url+"&acc="+ myaccuracy + "&service=" + service + "&device=" + device + "&target_id=" + target_id + "&rt_time=" + rt_time + "&detection_mode=" + detection_mode + "&sequence_id=" + sequence_id;
xmlhttp.open("POST",url,false);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send(JSON.stringify(message));
var respons=JSON.parse(xmlhttp.responseText);
var clientId=respons.client.clientId;
var coupon=respons.coupon[0].couponId;
var ean=respons.coupon[0].ean;
var value=respons.coupon[0].value;
var coupon1=respons.coupon[1].couponId;
var ean1=respons.coupon[1].ean;
var value1=respons.coupon[1].value;
var coupon2=respons.coupon[2].couponId;
var ean2=respons.coupon[2].ean;
var value2=respons.coupon[2].value;
var card=respons.card.memberCardType;
var number=respons.card.memberCardNumber;
document.getElementById('res').innerHTML="<p>Received: clientId: " + clientId + " membercard: " + card + " number: " + number + "</br>" +
	"Coupon: " + coupon + " , " + ean + " , "  + value + "</br>"
	+ "Coupon: " + coupon1 + " , " + ean1 + " , "  + value1 + "</br>"
	+ "Coupon: " + coupon2 + " , " + ean2 + " , "  + value2 + "</br>"
	+ "</h2>";

if (clientId){
xmlhttp=new XMLHttpRequest();
var sequence_id=3;
var accept="yes";
var url="td_respons.php";
url=url + "?accept=" +accept + "&sequence_id=" + sequence_id + "&clientId=" + clientId + "&device=" + device;
message={ "posID" : 24356677, "respons" : "We have reciveed many coupons"};
xmlhttp.open("POST",url,false);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send(JSON.stringify(message));
var answer=xmlhttp.responseText;
}

}
