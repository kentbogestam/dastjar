/*  File Name : jsEditUser.js
 *  Description : Edit User Form
 *  Author  :Deo  Date: 28th,Jan,2011  Creation
 */
$(document).ready(function(){



    $("#updateUser").click(function(){

        var error = 'false';
        $("#MsgError").html('');
        $("#step1_error").hide();
        $("#msg_error").hide();
        $("#error_role").html('');
      
       
        $("#error_fname").html('');
        $("#error_lname").html('');
        $("#error_role").html('');
        $("#error_phone").html('');
        $("#error_mobile").html('');


        if(($.trim($("#fname").val()).length == 0))
        {
            var errorMsg = "Please Enter First Name.<br/>";
            $("#error_fname").html(errorMsg);
            error = "true";
        }

//    else
//        if (!isAlphabetic($.trim($("#fname").val())))
//        {
//            var errorMsg = "Your Name is not significant.<br />";
//            $("#error_fname").html(errorMsg);
//            error = "true";
//        }


        if(($.trim($("#lname").val()).length == 0))
        {
            var errorMsg = "Please Enter Last Name.<br/>";
            $("#error_lname").html(errorMsg);
            error = "true";
        }

//        else
//        if (!isAlphabetic($.trim($("#lname").val())))
//        {
//            var errorMsg = "Your Name is not significant.<br />";
//            $("#error_lname").html(errorMsg);
//            error = "true";
//        }

        if(($.trim($("#phone").val()).length == 0) && ($.trim($("#mob").val()).length == 0))
        {
            var errorMsg = "Please Enter atleast one Contact Number.<br/>";
            $("#error_phone").html(errorMsg);
            $("#error_mobile").html(errorMsg);
            error = "true";
        }
        

        if(error=="true")
        {
            return false;
        }
        return true;
    });
});

//function isValidEmailAddress(emailAddress) {
//    var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
//    return pattern.test(emailAddress);
//}
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
/* Function Header :phoneValidator(val)
*             Args: none
*           Errors: none
*     Return Value: none
*      Description:To check whether the phone no validator
*/

function phoneValidator(val)
{
    if(val.match(/^[1-9]/))
    {
        return true;
    }
    else
    {
        return false;
    }
}
