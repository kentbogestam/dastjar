$(document).ready(function(){

 $("#continue").click(function(){

var error = 'false';
$("#error_product").html('');
$("#error_plan").html('');
$("#error_price").html('');
$("#error_currency").html('');
$("#error_description").html('');

    if(($.trim($("#product").val()).length == 0))
        {
            var errorMsg = "Please Enter Product Name. <br />";
            $("#error_product").html(errorMsg);
            error = "true";
        }

    if(($.trim($("#plan").val()).length == 0))
        {
            var errorMsg = "Please Enter Plan description.<br />";
            $("#error_plan").html(errorMsg);
            error = "true";
        }

    if(($.trim($("#price").val()).length == 0))
        {
            var errorMsg = "Please Enter Price .<br />";
            $("#error_price").html(errorMsg);
            error = "true";
        }else if(!isNumeric($.trim($("#price").val()))){
            var errorMsg = "Please Enter Valid Price .<br />";
            $("#error_price").html(errorMsg);
            error = "true";
        }

        if(($.trim($("#description").val()).length == 0))
        {
            var errorMsg = "Please Enter Description.<br />";
            $("#error_description").html(errorMsg);
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
$("#error_product").html('');
$("#error_plan").html('');
$("#error_price").html('');
$("#error_currency").html('');
$("#error_description").html('');

    if(($.trim($("#product").val()).length == 0))
        {
            var errorMsg = "Please Enter Product Name. <br />";
            $("#error_product").html(errorMsg);
            error = "true";
        }

    if(($.trim($("#plan").val()).length == 0))
        {
            var errorMsg = "Please Enter Plan description.<br />";
            $("#error_plan").html(errorMsg);
            error = "true";
        }

    if(($.trim($("#price").val()).length == 0))
        {
            var errorMsg = "Please Enter Price .<br />";
            $("#error_price").html(errorMsg);
            error = "true";
        }else if(!isNumeric($.trim($("#price").val()))){
            var errorMsg = "Please Enter Valid Price .<br />";
            $("#error_price").html(errorMsg);
            error = "true";
        }

        if(($.trim($("#description").val()).length == 0))
        {
            var errorMsg = "Please Enter Description.<br />";
            $("#error_description").html(errorMsg);
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