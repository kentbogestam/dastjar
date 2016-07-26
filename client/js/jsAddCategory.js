$(document).ready(function(){

 $("#continue").click(function(){

var error = 'false';
$("#error_cneng").html('');
$("#error_cnswe").html('');

if(($.trim($("#cNEng").val()).length == 0))
        {
            var errorMsg = "Please Enter Category Name .<br />";
            $("#error_cneng").html(errorMsg);
            error = "true";
        }

if(($.trim($("#cNSwe").val()).length == 0))
        {
            var errorMsg = "Please Enter Category Name.<br />";
            $("#error_cnswe").html(errorMsg);
            error = "true";
        }

 if($.trim($("#icon").val()).length!=0){

            if(!isValidPngImage($("#icon").val()))
            {
                var errorMsg = "Please upload an icon in png format only.<br />";
                $("#error_icon").html(errorMsg);
                error = "true";
            }
        }

  if($.trim($("#icon").val()).length == 0){


                var errorMsg = "Please upload an icon.<br />";
                $("#error_icon").html(errorMsg);
                error = "true";

        }

        if(error=="true")
        {

            return false;

        }
        return true;
 });

  $("#update").click(function(){

var error = 'false';
$("#error_cneng").html('');
$("#error_cnswe").html('');

if(($.trim($("#cNEng").val()).length == 0))
        {
            var errorMsg = "Please Enter Category Name .<br />";
            $("#error_cneng").html(errorMsg);
            error = "true";
        }

if(($.trim($("#cNSwe").val()).length == 0))
        {
            var errorMsg = "Please Enter Category Name.<br />";
            $("#error_cnswe").html(errorMsg);
            error = "true";
        }

 if($.trim($("#icon").val()).length!=0){

            if(!isValidPngImage($("#icon").val()))
            {
                var errorMsg = "Please upload an icon in png format only.<br />";
                $("#error_icon").html(errorMsg);
                error = "true";
            }
        }




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
