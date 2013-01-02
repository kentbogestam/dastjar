/*  File Name : jsChangePassword.js
 *  Description : Add Company Form
 *  Author  :Deo Date: 28th,Jan,2011  Creation
 */
$(document).ready(function(){



    $("#update").click(function(){

        var error = 'false';
        $("#MsgError").html('');
        $("#step1_error").hide();
        $("#msg_error").hide();
        $("#error_opwd").html('');
        $("#error_pwd").html('');
        $("#error_c_pwd").html('');
  
      
        if(($.trim($("#opwd").val()).length == 0))
        {
            var errorMsg = "Please Enter Old Password<br />";
            $("#error_opwd").html(errorMsg);
            error = "true";
        }


        if(($.trim($("#pwd").val()).length == 0))
        {
            var errorMsg = "Please Enter New Password<br />";
            $("#error_pwd").html(errorMsg);
            error = "true";
        }
        else
        if(($.trim($("#pwd").val()).length < 6))
        {
            var errorMsg = "Password is too short.<br />";
            $("#error_pwd").html(errorMsg);
            error = "true";
        }
        else
        if(!passwordValidator($.trim($("#pwd").val())))
        {
            var errorMsg = "Password should have atleast one number or one Upper case character<br />";
            $("#error_pwd").html(errorMsg);
            error = "true";
        }


        if(($.trim($("#c_pwd").val()).length == 0))
        {
            var errorMsg = "Please Enter Verify Password<br />";

            $("#error_c_pwd").fadeIn("slow");
            $("#error_c_pwd").html(errorMsg);
            $("#pwd").focus();
            error = "true";

        }else

        if($("#pwd").val()!=$("#c_pwd").val())
        {
            var errorMsg = "Password did not match<br/>";

            // alert("dddd");
            $("#error_c_pwd").html(errorMsg);

            error = "true";

        }
        if(error=="true")

        {
            return false;
        }
        return true;
    });
});




function passwordValidator(val)
{
    if(val.match(/[A-Z0-9]/))
    {
        return true;
    }
    else
    {
        return false;
    }
}
