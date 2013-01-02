/*  File Name : addCompany.php
 *  Description : Add Company Form
 *  Author  :Himanshu Singh  Date: 12th,Nov,2010  Creation
 */
$(document).ready(function(){

    $(function()
    {
        $('.startDate').datePicker({
            autoFocusNextInput: true
        });
    });

    $(function()
    {
        $('.endDate').datePicker({
            autoFocusNextInput: true
        });
    });

   $("#continue").click(function(){

var error = 'false';
 $("#error_startDate").html('');
 $("#error_endDate").html('');
$("#error_value").html('');



 var startDate = $.trim($("#startDate").val());
        var endDate = $.trim($("#endDate").val());

        if(startDate=='')
        {
            var errorMsg = "Please Enter Start Date.<br />";
            $("#error_startDate").html(errorMsg);
            error = "true";
        }

        if(endDate=='')
        {
            var errorMsg = "Please Enter End Date.<br />";
            $("#error_endDate").html(errorMsg);
            error = "true";
        }
        else
        //if(!ValidateDate(startDate,endDate))
		if(startDate > endDate)
        {
            var errorMsg = "End Date must be greater than or equal to Start Date.<br />";
            $("#error_endDate").html(errorMsg);
            error = "true";
        }
        ///////////////////////////////
        var now = new Date();

        //alert();

         if(Date(now)>Date(startDate))
        {
            var errorMsg = "Please select valid date.<br />";
            $("#error_startDate").html(errorMsg);
            error = "true";
        }

        if(new Date(endDate)<new Date(now))
        {
            var errorMsg = "Please select valid date.<br />";
            $("#error_endDate").html(errorMsg);
            error = "true";
        }

 if(($.trim($("#value").val()).length == 0))
        {
            var errorMsg = "Please Enter Value.<br />";
            $("#error_value").html(errorMsg);
            error = "true";
        }else
              if (!isNumeric($.trim($("#value").val())))
                {
                    var errorMsg = "value code is not significant.<br />";
                    $("#error_value").html(errorMsg);
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