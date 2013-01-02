/*  File Name : addCompany.php
 *  Description : Add Company Form
 *  Author  :Himanshu Singh  Date: 12th,Nov,2010  Creation
 */
$(document).ready(function(){



    $("#continue").click(function(){
        var error = 'false';
        $("#error_price").html('');
        $("#error_selectStore").html('');
       



        if(($.trim($("#selectStore").val()).length == 0))
        {

            var errorMsg = "Please Select Store .<br />";
            $("#error_selectStore").html(errorMsg);
            error = "true";

        }

        if(($.trim($("#price").val()).length == 0))
        {

            var errorMsg = "Please Enter Price.<br />";
            $("#error_price").html(errorMsg);
            error = "true";
        }
        else
        if(!isNumeric($.trim($("#price").val())))
         {
            var errorMsg = "Please Enter valid price.<br />";
            $("#error_price").html(errorMsg);
            error = "true";
         }


        //alert(error);

        if(error=="true")
        {
            return false;
        }
        return true;
    });



     $("#continuePrice").click(function(){
        var error = 'false';
        $("#error_price").html('');
       

        if(($.trim($("#price").val()).length == 0))
        {

            var errorMsg = "Please Enter Price.<br />";
            $("#error_price").html(errorMsg);
            error = "true";
        }
        else
        if(!isNumeric($.trim($("#price").val())))
         {
            var errorMsg = "Please Enter valid price.<br />";
            $("#error_price").html(errorMsg);
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


function isNumericDecimal(value) {
  if (value == null || !value.toString().match(/^[-]?\d*\.?\d*$/)) return false;
  return true;
}
