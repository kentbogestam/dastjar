/*  File Name : addCompany.php
 *  Description : Add Company Form
 *  Author  :Himanshu Singh  Date: 12th,Nov,2010  Creation
 */
$(document).ready(function(){

    $("#Activate").click(function(){
        var error = 'false';
        $("#MsgError").html('');
        $("#step1_error").hide();
        $("#msg_error").hide();
        $("#error_loadaccount").html('');
        $("#error_maxcost").html('');


        if (($.trim($("#loadaccount").val()).length == 0))
        {
            var errorMsg = "Please Load your Account.<br />";
            $("#error_loadaccount").html(errorMsg);
            error = "true";
        }else
        if (($.trim($("#loadaccount").val()).length > 0)&& !isNumeric($.trim($("#loadaccount").val())))
        {
            var errorMsg = "Please Load your Account with proper values.<br />";
            $("#error_loadaccount").html(errorMsg);
            error = "true";
        }


        if (($.trim($("#maxcost").val()).length == 0))
        {
            var errorMsg = "Please setup a budget.<br />";
            $("#error_maxcost").html(errorMsg);
            error = "true";
        }else
        if (($.trim($("#maxcost").val()).length > 0)&& !isNumeric($.trim($("#maxcost").val())))
        {
            var errorMsg = "Please setup a budget with proper values    .<br />";
            $("#error_maxcost").html(errorMsg);
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


