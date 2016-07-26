
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
//getLocation();

var mylat=59.3049227;
var mylong=17.9918352;
var myaccuracy=1;

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
var card=respons.card[0].cardId;
var card1=respons.card[1].cardId;
var target_id=respons.target_id;
document.getElementById('res').innerHTML="<p>Received: card: " + card + " , " + card1 + "</p>";

if (target_id){
	
// Prepare payment
	var amount=122;
	var session_id=target_id;

xmlhttp=new XMLHttpRequest();
var sequence_id=3;
var accept="yes" ;
var url="td_respons.php";
url=url + "?accept=" +accept + "&sequence_id=" + sequence_id + "&target_id=" + target_id + "&device=" + device;
message={ "service" : "payment", "posID" : 24356677, "url" : "makeFastPayment.php", };

xmlhttp.open("POST",url,false);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send(JSON.stringify(message));
var answer=xmlhttp.responseText;
}

}
