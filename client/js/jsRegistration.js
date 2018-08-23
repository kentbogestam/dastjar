/*  File Name : addCompany.php
 *  Description : Add Company Form
 *  Author  :Himanshu Singh  Date: 12th,Nov,2010  Creation
 */
$(document).ready(function(){



    $("#Continue").click(function(){

       
        var error = 'false';
        $("#MsgError").html('');
        $("#step1_error").hide();
        $("#msg_error").hide();
        $("#error_role").html('');
        $("#error_emailid").html('');
        $("#error_pwd").html('');
        $("#error_c_pwd").html('');
        $("#error_verification_code").html('');
        $("#error_fname").html('');
        $("#error_lname").html('');
        $("#error_role").html('');
        $("#error_phone").html('');
        $("#error_mobile").html('');
        $("#error_terms").html('');
        // $("#error_recaptcha").html('');
        
        if(($.trim($("#emailid").val()).length == 0))
        {

            var errorMsg = "Please Enter Your e-mail address.<br />";
            $("#error_emailid").html(errorMsg);
            error = "true";

        }else
        if (!isValidEmailAddress($.trim($("#emailid").val())))
        {
            var errorMsg = "Please Enter a valid e-mail address.<br />";
            $("#error_emailid").html(errorMsg);
            error = "true";
        }
        else if(isValidEmailAddress($.trim($("#emailid").val())))
        {
            
            $.post('classes/ajx/ajxCommon.php',{
                email:$("#emailid").val(),
                m:"existemail"
            },
            function(data){
            //debugger;
                if(data>0)
                {
                    errorMsg = "This e-mail address is already registered.<br />";
                    $("#error_emailid").html(errorMsg);
                    error = "true";
                    //alert("ERROR EE")
                }
                else
                {
                    var errorMsg = "Available.<br />";
                    $("#error_emailid").html(errorMsg);
                }
            }
            );
                
        }
        
        if(document.getElementById("checkResult").value=="no")
            {
              alert('This e-mail address is already registered.');
              return false;
                
            }


        if(($.trim($("#pwd").val()).length == 0))
        {
            var errorMsg = "Please Enter Password<br />";
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

        //        if(($.trim($("#verification_code").val()).length == 0))
        //        {
        //            var errorMsg = "Please Enter Your Verification Code.<br/>";
        //            $("#error_verification_code").html(errorMsg);
        //            error = "true";
        //        }else
        //        if (!isNumeric($.trim($("#verification_code").val())))
        //        {
        //            var errorMsg = "Verification code is not significant.<br />";
        //            $("#error_verification_code").html(errorMsg);
        //            error = "true";
        //        }


        if(($.trim($("#fname").val()).length == 0))
        {
            var errorMsg = "Please Enter First Name.<br/>";
            $("#error_fname").html(errorMsg);
            error = "true";
        }else if (!isAlphabetic($.trim($("#fname").val())))
        {
           var errorMsg = "Your First Name is not significant.<br/>";
           $("#error_fname").html(errorMsg);
           error = "true";
        }
       

        if(($.trim($("#lname").val()).length == 0))
        {
            var errorMsg = "Please Enter Last Name.<br/>";
            $("#error_lname").html(errorMsg);
            error = "true";
        }else if (!isAlphabetic($.trim($("#lname").val())))
        {
           var errorMsg = "Your Last Name is not significant.<br />";
           $("#error_lname").html(errorMsg);
           error = "true";
        }

        
        if(($.trim($("#phone").val()).length == 0) && ($.trim($("#mob").val()).length == 0))
        {
            var errorMsg = "Only one Contact Number required.<br/>";
            $("#error_phone").html(errorMsg);
            $("#error_mobile").html(errorMsg);
            error = "true";
        }else if(phoneValidator($.trim($("#phone").val())))
        {
            var errorMsg = "Please Enter Valid Phone Number.<br/>";
            $("#error_phone").html(errorMsg);
            error = "true";
        }else if(phoneValidator($.trim($("#mob").val())))
        {
            var errorMsg = "Please Enter Valid Mobile Number.<br/>";
            $("#error_mobile").html(errorMsg);
            error = "true";
        }

        if(document.getElementById('terms').checked==false)
        {
            var errorMsg = "You have not checked Terms and Conditions.<br />";
            $("#error_terms").html(errorMsg);
            error = "true";
        }


        //alert($("#recaptcha_response_field").val());
        // if (($.trim($("#recaptcha_response_field").val()).length == 0) )
        // {
        //     var errorMsg = "Please enter valid image code.<br />";
        //     $("#error_recaptcha").html(errorMsg);
        //     error = "true";
        // }
        //alert(errorMsg+"--"+error);

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
    if(val.match(/[^0-9]/g))
    {
        return true;
    }else if(val.length < 10 && val.length != 0){
        return true;
    }
    else
    {
        return false;
    }
}

/* Function Header :checkEmailExist()
*             Args: none
*           Errors: none
*     Return Value: none
*      Description:To check whether the email_id exist or not
*/

function checkEmailExist()
{
    $("#error_emailid").html('');
    if($("#emailid").val().length<1)
    {
        return false;
    }else
    if (!isValidEmailAddress($.trim($("#emailid").val())))
    {
        var errorMsg = "Please Enter valid e-mail address.<br />";
        $("#error_emailid").html(errorMsg);
        error = "true";
    }else
    {
        $.post('classes/ajx/ajxCommon.php',{
            email:$("#emailid").val(),
            m:"existemail"
        },
        function(data){

            if(data>0)
            {
                var errorMsg = "This e-mail address is already registered.<br />";
                $("#error_emailid").html(errorMsg);
                document.getElementById("checkResult").value="no";

            //error = "true";
            }
            else
            {
                var errorMsg = "Available.<br />";
                $("#error_emailid").html(errorMsg);
                document.getElementById("checkResult").value="yes";
            }
        }
        );
    }
}


