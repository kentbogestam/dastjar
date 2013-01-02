/*  File Name : addCompany.php
 *  Description : Add Company Form
 *  Author  :Himanshu Singh  Date: 12th,Nov,2010  Creation
 */
$(document).ready(function(){

    $("#submit").click(function(){

        var error = 'false';
        $("#MsgError").html('');
        $("#step1_error").hide();
        $("#msg_error").hide();
        $("#error_role").html('');
        $("#error_brandName").html('');
        $("#error_icon").html('');

        //alert("here");
        if(($.trim($("#brandName").val())==''))
        {
            var errorMsg = "Please Enter your Brand Name.<br/>";
            $("#error_brandName").html(errorMsg);
            error = "true";
        }

        if(($.trim($("#picture").val())==''))
        {
            var errorMsg = "Please Enter your Brand Icon.<br/>";
            $("#error_picture").html(errorMsg);
            error = "true";
        }

        //alert(error);
        if(error=="true")
        {
            return false;
        }
        return true;
    });
});



