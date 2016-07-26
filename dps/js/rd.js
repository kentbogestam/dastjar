
var service;
var target_id;
var rt_time;
var detection_mode;
var sequence_id;
var message={};


function getTD(){
device="rd";
service="coupon";
// use SharedId if it exist, if not use storeId if it exists
// if either exists set shareId to 0

storeId="d76d54db2c04778a012c0477ef910029";
target_id=storeId;
rt_time=0.4;
detection_mode="button";
sequence_id=1;
message={ 
"coupon": [
{"couponId" : "5bcc4d1a-cb5b-41ba-b549-95da9934009e", "ean" : 9954321100509, "value" : 5},
{"couponId" : "5bcc4d1a-cb5b-41ba-b549-95da9934009d", "ean" : 99543211006509, "value" : 8},
{"couponId" : "5bcc4d1a-cb5b-41ba-b549-95da9934009s", "ean" : 9954321100709, "value" : 15}],
"client": {"clientId"  : "2a209e12- d3ea-4ae0-b8b6-01d5fa21574b"},
"card": {"memberCardType" : "coop", "memberCardNumber" : 12345678}
};

var clientId=message.client.clientId;
var memberCardType=message.card.memberCardType;
var memberCardNumber=message.card.memberCardNumber;
var coupon1=message.coupon[0].couponId;
var ean1=message.coupon[0].ean;
var value1=message.coupon[0].value;
var coupon2=message.coupon[1].couponId;
var ean2=message.coupon[1].ean;
var value2=message.coupon[1].value;
var coupon3=message.coupon[2].couponId;
var ean3=message.coupon[2].ean;
var value3=message.coupon[2].value;
document.getElementById('res1').innerHTML="<p>Sending.. " +  "</br>" + "Coupons: </br>" + coupon1 + " , " + " ean "  + ean1 + " value: " + value1 + "</br>" +  coupon2 + " , " + coupon3 + "</br>Membercard: " + memberCardType + " : " + memberCardNumber;




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
var url="rd_dps.php";
url=url+"?long=";
url=url+mylong;
url=url+"&lat="+ mylat;
url=url+"&acc="+ myaccuracy + "&service=" + service + "&device=" + device + "&target_id=" + target_id + "&rt_time=" + rt_time + "&detection_mode=" + detection_mode + "&sequence_id=" + sequence_id;
xmlhttp.open("POST",url,false);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send(JSON.stringify(message));

xmlhttp=new XMLHttpRequest();
var url="rd_respons.php";
url=url+"?clientId=" + "2a209e12- d3ea-4ae0-b8b6-01d5fa21574b";
xmlhttp.open("GET",url,false);
//setTimeout("xmlhttp.send()", 5000);
xmlhttp.send();

document.getElementById('res2').innerHTML=xmlhttp.responseText;
}
