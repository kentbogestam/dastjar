

function checkAccount() {
 var orgNr = prompt("Enter the identity of the company you want accout status for : ", "enter the id here");
var params = "orgnr=" + orgNr + "&service=get";

 var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) {
      document.getElementById("accountStatus").innerHTML = xhttp.responseText;
    }
  };
  xhttp.open("POST", "accountControl.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send(params);

}

function setAccount() {
 var orgNr = prompt("Enter the identity of the company you want accout status for : ", "enter the id here");
 var value = prompt("Set account to 1 to indicate payment done or 0 for unpaid : ", "enter the id here");
var params = "orgnr=" + orgNr + "&service=set&value=" + value;

 var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) {
      document.getElementById("transStatus").innerHTML = xhttp.responseText;
    }
  };
  xhttp.open("POST", "accountControl.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send(params);

}

function checkStatus(page) {
// Checks if status is paid if not Prompts the user and stops
// Takes the page where to go on failure as input parameter
var page = page;
var params = "service=check";
 var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) {
	var res= xhttp.responseText;
	alertAndReload(res, page);
      }
  };
  xhttp.open("POST", "accountControl.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send(params);

}

function alertAndReload(res, page){
if(res == 0){
 alert("Please, activate your account!");
        window.location.assign(window.location.pathname);
        }else{
window.location.href=page;
}

}
