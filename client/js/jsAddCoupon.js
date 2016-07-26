/*  File Name : addCompany.php
 *  Description : Add Company Form
 *  Author  :Himanshu Singh  Date: 12th,Nov,2010  Creation
 */
$(document).ready(function(){



    $("#continue").click(function(){
        var error = 'false';
        
        $("#error_selectStore").html('');




        if(($.trim($("#selectStore").val()).length == 0))
        {

            var errorMsg = "Please Select Store.<br />";
            $("#error_selectStore").html(errorMsg);
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






