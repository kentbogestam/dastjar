/*  File Name : jsFeedBack.js
 *  Description : js file
 *  Author  :Deo Date: 12th,jan,2011  Creation
 */
$(document).ready(function(){
    $("#feedback").click(function(){
        var error = 'false';
        $("#MsgError").html('');
        $("#step1_error").hide();
        $("#msg_error").hide();
        $("#error_message").html('');
        $("#error_ccid").html('');
        $("#error_cos").html('');


        if($.trim($("#message").val()).length == 0)
        {
            var errorMsg = "Please Enter Message.<br />";
            $("#error_message").html(errorMsg);
            error = "true";
        }
        
        if($.trim($("#ccid").val()).length == 0)
        {
            var errorMsg = "Client Id cannot be blank .<br />";
            $("#error_ccid").html(errorMsg);
            error = "true";
        }
        if($.trim($("#cos").val()).length == 0)
        {
            var errorMsg = "Client OS cannot be blank .<br />";
            $("#error_cos").html(errorMsg);
            error = "true";
        }
        if(error=="true")
        {
            return false;
        }
        return true;
    });
});

