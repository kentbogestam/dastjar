$(document).ready(function() {

   $("#continue").click(function(){
        var error = 'false';

        $("#error_selectCompany").html('');




        if(($.trim($("#selectCompany").val()).length == 0))
        {

            var errorMsg = "Please Select Company.<br />";
            $("#error_selectCompany").html(errorMsg);
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