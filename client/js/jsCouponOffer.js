/*  File Name : addCompany.php
 *  Description : Add Company Form
 *  Author  :Himanshu Singh  Date: 23rd,Nov,2010  Creation
 */
$(document).ready(function(){

    
    
    $("#continue").click(function(){
        var error = 'false';
        $("#error_picture").html('');
        $("#error_descriptive").html('');
        $("#error_link").html('');


        if(($.trim($("#descriptive").val()).length == 0))
        {
            var errorMsg = "Please Enter Descriptive Text for your campaign.<br />";
            $("#error_descriptive").html(errorMsg);
            error = "true";
        }else
        if(($.trim($("descriptive").val()).length > 15))
        {
            var errorMsg = "Your Descriptive Text exceeds the limit.<br />";
            $("#error_descriptive").html(errorMsg);
            error = "true";
        }


        if(!isValidJpegImage($.trim($("#picture").val())))
        {
            var errorMsg = "Please upload an icon in jpeg format only.<br />";
            $("#error_picture").html(errorMsg);
            error = "true";
        }


        if(($.trim($("#link").val()).length == 0))
        {
            var errorMsg = "Please Enter a Link to your Homepage.<br />";
            $("#error_link").html(errorMsg);
            error = "true";
        }


        if(error=="true")
        {
            return false;

        }
        return true;
    });
});



function isValidJpegImage(val)
{
    if (val.match(/^[.jpg][.JPG][.jpeg][.JPEG]+$/))
    {
        return true;
    }
    else
    {
        return false;
    }
}