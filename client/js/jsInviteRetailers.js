/*  File Name : jsInviteRetailers.js
 *  Description : js file
 *  Author  :Deo Date: 12th,jan,2011  Creation
 */
$(document).ready(function(){
    $("#continue").click(function(){
        var error = 'false';
        $("#MsgError").html('');
        $("#step1_error").hide();
        $("#msg_error").hide();
        $("#error_email").html('');
       // $("#error_message").html('');


        if(($.trim($("#email").val()).length == 0))
        {

            var errorMsg = "Please Enter Your e-mail address.<br />";
            $("#error_email").html(errorMsg);
            error = "true";

        }
        else{
            var emailArr = 0;
            var str = $.trim($("#email").val())
            emailArr = str.split(",");
           
            var emailerror = "false";
            var errorMsg = "";
            for(var i=0; i<emailArr.length; i++)
            {
               // alert(emailArr[i])
				if(!isValidEmailAddress($.trim(emailArr[i])))
                {
                    //alert(emailArr[i]);
                    emailerror = "true";
                //alert(emailerror)
                }
            }

//alert(emailerror);
            if(emailerror=="true")
            {
                errorMsg = "Your e-mail address is not valid.<br/>";
                $("#error_email").html(errorMsg);
                error = "true"
            }
        }

//        if(($.trim($("#message").val()).length == 0))
//        {
//
//            var errorMsg = "Please Enter message.<br />";
//            $("#error_message").html(errorMsg);
//            error = "true";
//
//        }
       // 
       // alert(error); return false;

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

