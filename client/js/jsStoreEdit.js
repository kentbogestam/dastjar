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
        $("#error_phone_prefix").html('');
        //$("#error_storeImage").html('');
        $("#error_email").html('');
        $("#error_link").html('');
        $("#error_delivery_type").html('');
        $("#error_address").html('');
        $("#error_coordinate").html('');
        $("#error_zip").html('');
        
        if(($.trim($("#storeName").val()).length == 0))
        {

            var errorMsg = "Please Enter Your Location Name.<br />";
            $("#error_storeName").html(errorMsg);
            error = "true";

        }

        // var patt = /^[a-zA-Z0-9- _]+$/i;
        var patt = /^[a-zA-Z0-9- _åäöÅÄÖ]+$/i;
        if( !patt.test($("#storeName").val()) )
        {
            var errorMsg = "Please Enter Valid Location Name.<br />";
            $("#error_storeName").html(errorMsg);
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


        if($.trim($("#phoneNo").val()).length == 0)
        {
            var errorMsg = "Please Enter Phone Number.<br/>";
            $("#error_phoneNo").html(errorMsg);
            error = "true";
        }
        if($.trim($("#phone_prefix").val()).length == 0)
        {
            var errorMsg = "Please Enter National Code.<br/>";
            $("#error_phone_prefix").html(errorMsg);
            error = "true";
        }

        if(phoneValidator($.trim($("#phoneNo").val())))
        {
            //alert('hi'); return false;
            var errorMsg = "Please Enter Valid Phone Number.<br/>";
            $("#error_phoneNo").html(errorMsg);
            error = "true";            
        }

        // if(($.trim($("#imageStore").val()).length == 0))
        // {
        //     var errorMsg = "Please Uplode png formate Image.<br/>";
        //     $("#error_storeImage").html(errorMsg);
        //     error = "true";
        // }

        /*if($.trim($("#link").val()).length == 0)
        {
            var errorMsg = "Please Enter Link to the Location Home.<br/>";
            $("#error_link").html(errorMsg);
            error = "true";
        }*/
        
            
        if($("#link").val().length && !isURL($.trim($("#link").val())))
        {
            var errorMsg = "Please Enter Valid Link to the Location Home.<br />";
            $("#error_link").html(errorMsg);
            error = "true";
        }

        if($('#delivery_type :selected').length == 0)
        {
            var errorMsg = "Please select at least one delivery type.<br />";
            $("#error_delivery_type").html(errorMsg);
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
        //alert(error);

        if(error=="true")
        {
            return false;
        }

        // 
        if( $('input[name="plan_id[]"]:checked').not('[disabled]').length )
        {
            if( $('input[name=payment_method_id]:checked').length )
            {
                $('#charging-saved-cards').trigger('click');
            }
            else if( $('input[name=pay-options]:checked').length )
            {
                $('#card-button').trigger('click');
            }
            else
            {
                alert('Please select payment method.');
                return false;
            }
        }
        else
        {
            $('#registerform').submit();
            return true;
        }
    });
});

function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
    return pattern.test(emailAddress);
}

function phoneValidator(val)
{
    if(val.length < 7){
        return true;
    }
    else if(val.length > 15){
        return true;
    }
    else if(val.match(/[^0-9]/g))
    {
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
    // let reg = /^[a-zA-Z]+$/;
    let reg = /^[a-zA-Z\u00c0-\u017e -]+$/; // Allow a-z, A-Z, letin char, space and hyphen
    reg = new RegExp(reg);

    if (reg.test(val))
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



