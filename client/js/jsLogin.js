/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function(){
    $("#login").click(function(){
   
        var error = 'false';
        $("#MsgError").html('');
        $("#step1_error").hide();
        $("#msg_error").hide();
        $("#error_username").html('');
        $("#error_password").html('');

        if(($.trim($("#username").val()).length == 0)&&($.trim($("#password").val()).length == 0))
        {
            var errorMsg = "Please Enter Your Login details .<br />";
            /* $("#step1_error_message").html(errorMsg);

                             $("#step1_error").hide();
                            $("#step1_error").fadeIn("slow");
             */
            $("#step1_uname").fadeIn("slow");
            $("#error_username").html(errorMsg);
            $("#username").focus();
            error = "true";

        }else
        if($.trim($("#username").val()).length == 0)
        {
            var errorMsg = "Please Enter Username<br />";
            $("#error_username").fadeIn("slow");
            $("#error_username").html(errorMsg);
            $("#username").focus();
            error = "true";
        }
        if (!isValidEmailAddress($.trim($("#username").val()))&&($.trim($("#username").val()).length>0)&&(($.trim($("#password").val()).length > 0)))
        {
            var errorMsg = "Your e-mail address is not valid.<br />";
            /* $("#step1_error_message").html(errorMsg);

                             $("#step1_error").hide();
                            $("#step1_error").fadeIn("slow");

             */                 $("#error_username").fadeIn("slow");
            $("#error_username").html(errorMsg);
            $("#username").select();
            error = "true";
        }
        if((($.trim($("#username").val()).length > 0))&&($.trim($("#password").val()).length == 0))
        {
            var errorMsg = "Please Enter Password<br />";
            /* $("#step1_error_message").html(errorMsg);

                             $("#step1_error").hide();
                            $("#step1_error").fadeIn("slow");
             */             $("#error_uname").html('&nbsp;');
            $("#error_password").fadeIn("slow");
            $("#error_password").html(errorMsg);
            $("#password").focus();
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

function containsAlphabets(checkString) {
    var tempString="";
    var regExp = /^[A-Za-z]$/;
    checkString = checkString.replace(" ","");
    // alert(checkString);
    if(checkString != null && checkString != "")
    {
        for(var i = 0; i < checkString.length; i++)
        {
            if (!checkString.charAt(i).match(regExp))
            {
                return false;

            }
        }
    }
    else
    {
        return false;
    }
    return true;

}

// Best One

function checkAlphabetic(sText)
{

    var ValidChars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    var IsAlphabetic=true;
    var Char;


    for (i = 0; i < sText.length && IsAlphabetic == true; i++);
    {
        Char = sText.charAt(i);
        if (ValidChars.indexOf(Char) == -1)
        {
            IsAlphabetic = false;

        }
    }
    return IsAlphabetic;

}

function isAlphabetic(val)
{
    if (val.match(/^[a-zA-Z]+$/))
    {
        return true;
    }
    else
    {
        return false;
    }
}

function emailVarification()
{

    var emailid = $("#emailid").val();
    $.post("classes/registration.php/", {
        m:'emailvarification',
        emailID: emailid
    },   function(data) {
        if(data.length>0)
        {

            // $(tid).child(data);
            var selectOption = data;


            $("#msg_email").html(selectOption);

        }

    });


}



