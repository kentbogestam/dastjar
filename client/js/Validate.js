
function frmValidate()
{
   var field = document.getElementById("firstName").value;
   var msg;
   var error = 0;
    if(field=="")
        {
            msg="Please enter first name";
	    document.getElementById("fname_error").innerHTML = msg;
            error=1;
        }
else
{
	document.getElementById("fname_error").innerHTML = "";
            error=0;
}
   field =  document.getElementById("lastName").value;
   if(field=="")
      {
          msg="Please enter last name";
	  document.getElementById("lname_error").innerHTML = msg;
          error=1;
     }
else
{
	document.getElementById("lname_error").innerHTML = "";
            error=0;
}

   field =  document.getElementById("email_id").value;
   var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
   if(reg.test(field)==false)
      {
          msg="Please enter valid e-mail address";
	  document.getElementById("email_error").innerHTML = msg;
          error=1;
     }
else
{
	document.getElementById("email_error").innerHTML = "";
            error=0;
}

   field =  document.getElementById("pwd1").value;
   if(field=="")
      {
          msg="Please enter password";
	  document.getElementById("pwd1_error").innerHTML = msg;
          error=1;
     }
else
{
	document.getElementById("pwd1_error").innerHTML = "";
            error=0;
}
 field =  document.getElementById("pwd2").value;
    if(field != myform.pwd1.value) 
    {
          msg="Password did not match";
	  document.getElementById("pwd2_error").innerHTML = msg;
      }
else
{
	document.getElementById("pwd2_error").innerHTML = "";
            error=0;
}
   var field = document.getElementById("addr1").value;
    if(field=="")
        {
            msg="Please enter Address";
	    document.getElementById("addr1_error").innerHTML = msg;
            error=1;
        }
else
{
	document.getElementById("addr1_error").innerHTML = "";
            error=0;
}
   var field = document.getElementById("addr2").value;
    if(field=="")
        {
            msg="Please enter Address";
	    document.getElementById("addr2_error").innerHTML = msg;
            error=1;
        }
else
{
	document.getElementById("addr2_error").innerHTML = "";
            error=0;
}
   var field = document.getElementById("city").value;
    if(field=="")
        {
            msg="Please enter Address";
	    document.getElementById("city_error").innerHTML = msg;
            error=1;
        }
else
{
	document.getElementById("city_error").innerHTML = "";
            error=0;
}
return lse;

}
