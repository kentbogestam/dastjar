/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function(){
    $("#continue").click(function(){
      
        var error = 'false';
        $("#error_email").html('');
 if(($.trim($("#email").val()).length == 0))
        {

            var errorMsg = "Please Enter Your e-mail address.<br />";
            $("#error_email").html(errorMsg);
            error = "true";

        }else
        if (!isValidEmailAddress($.trim($("#email").val())))
        {
            var errorMsg = "Please Enter a valid e-mail address.<br />";
            $("#error_email").html(errorMsg);
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






