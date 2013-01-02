/*  File Name : jsEditUser.js
 *  Description : Edit User Form
 *  Author  :Deo  Date: 28th,Jan,2011  Creation
 */
$(document).ready(function(){



    $("#submit").click(function(){

        var error = 'false';
        $("#MsgError").html('');
        $("#step1_error").hide();
        $("#msg_error").hide();
        $("#error_role").html('');
         $("#error_picture").html();


        $("#error_brandName").html('');
        $("#error_picture").html('');
   

        //alert($.trim($("#icon").val()).length);
        if(($.trim($("#brandName").val()).length == 0))
        {
            var errorMsg = "Please Enter Brand Name.<br/>";
            $("#error_brandName").html(errorMsg);
            error = "true";
        }

        //    else
        //        if (!isAlphabetic($.trim($("#fname").val())))
        //        {
        //            var errorMsg = "Your Name is not significant.<br />";
        //            $("#error_fname").html(errorMsg);
        //            error = "true";
        //        }
 if($.trim($("#icon").val()).length==0){

            if(($("#picture").val()==''))
            {
                var errorMsg = "Please upload image in png format.<br />";
                $("#error_picture").html(errorMsg);
                error = "true";

            }
            else
            if(!isValidPngImage($("#picture").val()))
            {
                var errorMsg = "Please upload image in  png format.<br />";
                $("#error_picture").html(errorMsg);
                error = "true";
            }
        }
        else
        {
            if(($("#picture").val()!=''))
            {
                if(!isValidPngImage($("#picture").val()))
                {
                    var errorMsg = "Please upload image in png format only.<br />";
                    $("#error_picture").html(errorMsg);
                    error = "true";
                }
            }
        }

        //        else
        //        if (!isAlphabetic($.trim($("#lname").val())))
        //        {
        //            var errorMsg = "Your Name is not significant.<br />";
        //            $("#error_lname").html(errorMsg);
        //            error = "true";
        //        }

        if(error=="true")
        {
            return false;
        }
        return true;
    });
});

function isValidPngImage(val)
{
    if (val.match(/\.(png||PNG)$/))
    {

        return true;
    }
    else
    {
        return false;
    }
}