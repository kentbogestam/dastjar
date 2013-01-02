$(document).ready(function(){

 $("#continue").click(function(){

var error = 'false';
$("#error_company").html('');
$("#error_country").html('');
$("#error_city").html('');
$("#error_street").html('');
$("#error_orgn").html('');
$("#error_version").html('');
$("#error_zip").html('');


if(($.trim($("#company").val()).length == 0))
        {
            var errorMsg = "Please Enter Your Company Name. <br />";
            $("#error_company").html(errorMsg);
            error = "true";
        }

if(($.trim($("#country").val()).length == 0))
        {
            var errorMsg = "Please Enter Your Country.<br />";
            $("#error_country").html(errorMsg);
            error = "true";
        }

if(($.trim($("#city").val()).length == 0))
        {
            var errorMsg = "Please Enter Your City .<br />";
            $("#error_city").html(errorMsg);
            error = "true";
        }

        if(($.trim($("#street").val()).length == 0))
        {
            var errorMsg = "Please Enter Your Street Address .<br />";
            $("#error_street").html(errorMsg);
            error = "true";
        }

        if(($.trim($("#orgnr").val()).length == 0))
        {
            var errorMsg = "Please Enter your Organisation Code.<br />";
            $("#error_orgn").html(errorMsg);
            error = "true";
        }

        if(($.trim($("#version").val()).length == 0))
        {
            var errorMsg = "Please Enter Version.<br />";
            $("#error_version").html(errorMsg);
            error = "true";
        }else
              if (!isNumeric($.trim($("#version").val())))
                {
                    var errorMsg = "Version code is not significant.<br />";
                    $("#error_version").html(errorMsg);
                  error = "true";
               }

        if(($.trim($("#zip").val()).length == 0))
        {
            var errorMsg = "Please Enter Zip Code.<br />";
            $("#error_zip").html(errorMsg);
            error = "true";
        }
 

        if(error=="true")
        {

            return false;

        }
        return true;
 });

  $("#update").click(function(){

var error = 'false';
$("#error_company").html('');
$("#error_country").html('');
$("#error_city").html('');
$("#error_street").html('');
$("#error_orgn").html('');
$("#error_version").html('');
$("#error_zip").html('');


if(($.trim($("#company").val()).length == 0))
        {
            var errorMsg = "Please Enter Your Company Name. <br />";
            $("#error_company").html(errorMsg);
            error = "true";
        }

if(($.trim($("#country").val()).length == 0))
        {
            var errorMsg = "Please Enter Your Country.<br />";
            $("#error_country").html(errorMsg);
            error = "true";
        }

if(($.trim($("#city").val()).length == 0))
        {
            var errorMsg = "Please Enter Your City .<br />";
            $("#error_city").html(errorMsg);
            error = "true";
        }

        if(($.trim($("#street").val()).length == 0))
        {
            var errorMsg = "Please Enter Your Street Address .<br />";
            $("#error_street").html(errorMsg);
            error = "true";
        }

        if(($.trim($("#orgnr").val()).length == 0))
        {
            var errorMsg = "Please Enter your Organisation Code.<br />";
            $("#error_orgn").html(errorMsg);
            error = "true";
        }

        if(($.trim($("#version").val()).length == 0))
        {
            var errorMsg = "Please Enter Version.<br />";
            $("#error_version").html(errorMsg);
            error = "true";
        }else
              if (!isNumeric($.trim($("#version").val())))
                {
                    var errorMsg = "Version code is not significant.<br />";
                    $("#error_version").html(errorMsg);
                  error = "true";
               }

        if(($.trim($("#zip").val()).length == 0))
        {
            var errorMsg = "Please Enter Zip Code.<br />";
            $("#error_zip").html(errorMsg);
            error = "true";
        }




        if(error=="true")
        {

            return false;

        }
        return true;
 });
});

function isValidPngImage(val)
{
    if (val.match(/\.(png||PNG)$/))
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