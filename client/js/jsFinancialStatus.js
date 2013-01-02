/*  File Name : jsFinancialStatus.php
 *  Description : Get financial Status Form Validations.
 *  Author  :Himanshu Singh  Date: 20th,Dec,2010  Creation
 */
$(document).ready(function(){
    $("#continue").click(function(){
        var error = 'false';
        $("#MsgError").html('');
        $("#msg_error").hide();
        $("#error_loadaccount").html('');

        if($.trim($("#loadaccount").val()).length == 0)
        {
            var errorMsg = "Load your Account<br />";
            $("#error_loadaccount").html(errorMsg);
            error = "true";
        }else
        if(!isNumeric($.trim($("#loadaccount").val())))
        {
            var errorMsg = "Load your Account with proper values<br />";
            $("#error_loadaccount").html(errorMsg);
            error = "true";
        }
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
