/*  File Name : addCompany.php
 *  Description : Add Company Form
 *  Author  :Himanshu Singh  Date: 12th,Nov,2010  Creation
 */
$(document).ready(function(){

    $("#continue1").click(function(){
        var error = 'false';
        $("#error_dishName").html('');

        if(($.trim($("#dishName").val()).length == 0))
        {

            var errorMsg = "Please Enter Your Dish Name.<br />";
            $("#error_dishName").html(errorMsg);
            error = "true";

        }

        if(error=="true")
        {
            return false;
        }
        return true;
    });

    $("#continue").click(function(){
        var error = 'false';
        $("#error_storeName").html('');
        $("#error_streetaddStore").html('');
        $("#error_cityStore").html('');
        $("#error_countryStore").html('');
        $("#error_phoneNo").html('');
        $("#error_storeImage").html('');
        $("#error_email").html('');
        $("#error_link").html('');
        $("#error_address").html('');
        $("#error_coordinate").html('');
        $("#error_storeTime").html('');
        $("#error_zip").html('');
        
        if(($.trim($("#storeName").val()).length == 0))
        {

            var errorMsg = "Please Enter Your Location Name.<br />";
            $("#error_storeName").html(errorMsg);
            error = "true";

        }

        if(($.trim($("#opencloseTimeing").val()).length == 0))
        {

            var errorMsg = "Please Select Open And Close Time Store.<br />";
            $("#error_storeTime").html(errorMsg);
            error = "true";

        }


          if(($.trim($("#streetaddStore").val()).length == 0))
        {

            var errorMsg = "Please Enter Your Street Address .<br />";
            $("#error_address").html(errorMsg);
            error = "true";

        }

        if(($.trim($("#streetaddStore").val()).length == 0))
        {
            
            var errorMsg = "Please Enter Street Address.<br />";
            $("#error_streetaddStore").html(errorMsg);
            error = "true";
        }

        if(($.trim($("#cityStore").val()).length == 0))
        {
            var errorMsg = "Please Enter City.<br />";
            $("#error_cityStore").html(errorMsg);
            error = "true";
        }else if(!isAlphabetic($.trim($("#cityStore").val())))
        {
            var errorMsg = "Please Enter Valid City Name.<br />";
            $("#error_cityStore").html(errorMsg);
            error = "true";
        }

        if (!isValidEmailAddress($.trim($("#email").val())))
        {
            var errorMsg = "Please Enter Valid e-mail address.<br />";
            $("#error_email").html(errorMsg);
            error = "true";
        }


        if(($.trim($("#phoneNo").val()).length == 0))
        {
            var errorMsg = "Please Enter Phone Number.<br/>";
            $("#error_phoneNo").html(errorMsg);
            error = "true";
        }

        if(phoneValidator($.trim($("#phoneNo").val())))
        {
            var errorMsg = "Please Enter Valid Phone Number.<br/>";
            $("#error_phoneNo").html(errorMsg);
            error = "true";            
        }

        if($.trim($("#link").val()).length == 0)
        {
            var errorMsg = "Please Enter Link to the Location Home.<br/>";
            $("#error_link").html(errorMsg);
            error = "true";
        }
        
            
        if(!isURL($.trim($("#link").val())))
        {
            var errorMsg = "Please Enter Valid Link to the Location Home.<br />";
            $("#error_link").html(errorMsg);
            error = "true";
        }
 
        if(($.trim($("#countryStore").val()).length == 0))
        {
            var errorMsg = "Please Enter Country.<br/>";
            $("#error_countryStore").html(errorMsg);
            error = "true";
        }

        if(($.trim($("#zip").val()).length == 0))
        {
            var errorMsg = "Please Enter Zip.<br/>";
            $("#error_zip").html(errorMsg);
            error = "true";
        }else if(!isNumeric($.trim($("#zip").val())))
        {
            var errorMsg = "Please Enter Valid Zip.<br/>";
            $("#error_zip").html(errorMsg);
            error = "true";
        }

        if(($.trim($("#longitude").val()).length == 0) && ($.trim($("#latitude").val()).length == 0))
        {
            var errorMsg = "Please Show your Location on the map.<br/>";
           
            $("#error_coordinate").html(errorMsg);
            error = "true";
        }

        if(!$('#terms').is(':checked'))
        {
            error = "true";
        }

        if(error=="true")
        {
            return false;
        }
        return true;
    });
});

function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
    return pattern.test(emailAddress);
}

function phoneValidator(val)
{
    if(val.match(/[^0-9]/g))
    {
        return true;
    }else if(val.length < 7){
        return true;
    }
    else
    {
        return false;
    }
}

function isNumeric(val)
{
    if (val.match(/^[0-9]+$/))
    {
        return true;
    }
    else
    {
        return false;
    }
}

function isAlphabetic(val)
{
    if (val.match(/^[a-zA-Z]+$/))
    {
        return true;
    }
    else
    {
        return false;
    }
}

function isURL(val) {
     var urlregex = new RegExp("^(http:\/\/www.|https:\/\/www.|ftp:\/\/www.|www.|http:\/\/.){1}([0-9A-Za-z]+\.)");
      if(urlregex.test(val))
   // if(val.match(/http:\/\/[A-Za-z0-9\.-]{3,}\.[A-Za-z]{3}/))
       {
       return true;
    }
    else{
        return false;
    }
}



