/*  File Name : addCompany.php
 *  Description : Add Company Form
 *  Author  :Himanshu Singh  Date: 12th,Nov,2010  Creation
*/
$(document).ready(function(){

    $("#addCompany").click(function(){

        var error = 'false';
        $("#MsgError").html('');
        $("#step1_error").hide();
        $("#msg_error").hide();
        $("#error_compname").html('');
        $("#error_orgcode").html('');
        $("#error_streetadd").html('');
        $("#error_zipcode").html('');
        $("#error_city").html('');
        $("#error_country").html('');
        $("#error_lowlevel").html('');
        


        if(($.trim($("#compname").val()).length == 0))
        {
            var errorMsg = "Please Enter Your Company Name.<br />";
            $("#error_compname").html(errorMsg);
            error = "true";
        }


        if (($.trim($("#orgcode").val()).length == 0))
        {
            var errorMsg = "Please Enter your Organisation Code.<br />";
            $("#error_orgcode").html(errorMsg);
            error = "true";
        }
        else if(($("#orgcode").val()))
        {

            $.post('classes/ajx/ajxCommon.php',{
            orgnisation:$("#orgcode").val(),
            m:"existorgnsation"
        },
        function(data){

            if(data>0)
            {
                var errorMsg = "This Organisation Code is already registered.<br />";
               $("#error_orgcode").html(errorMsg);
                    error = "true";

            //error = "true";
            }
            else
            {
                var errorMsg = "Available.<br />";
                 $("#error_orgcode").html(errorMsg);
            }
        }
        );

        }

        if(($.trim($("#streetadd").val()).length == 0))
        {
            var errorMsg = "Please Enter Your Street Address<br />";
            $("#error_streetadd").html(errorMsg);
            error = "true";
        }


        if(($.trim($("#city").val()).length == 0))
        {
            var errorMsg = "Please Enter Your City<br />";
            $("#error_city").html(errorMsg);
            error = "true";
        }


        if(($.trim($("#zipcode").val()).length == 0))
        {
            var errorMsg = "Please Enter Zip Code<br />";
            $("#error_zipcode").html(errorMsg);
            error = "true";
        }else if(!isNumeric($.trim($("#zipcode").val()))){
            var errorMsg = "Please Enter Valid Zip Code<br />";
            $("#error_zipcode").html(errorMsg);
            error = "true";            
        }

        if(($.trim($("#country").val()).length == 0))
        {
            var errorMsg = "Please Enter Your Country<br />";
            $("#error_country").html(errorMsg);
            error = "true";
        }

//        if(($.trim($("#lowLevel").val()).length == 0))
//        {
//            var errorMsg = "Please Enter Account Level.<br />";
//            $("#error_lowlevel").html(errorMsg);
//            error = "true";
//        }else
          if(($.trim($("#lowLevel").val()).length > 0))
              {
              if (!isNumeric($.trim($("#lowLevel").val())))
                {
                    var errorMsg = "value code is not significant.<br />";
                    $("#error_lowlevel").html(errorMsg);
                  error = "true";
               }
              }

        if(document.getElementById("checkResult").value=="no")
            {
              alert('This Organisation Code is already registered.');
              return false;

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

function buttonLinkAction(regStep)
{
    //alert(regStep);
    if(regStep==1)
    {
        document.getElementById("step1").disabled=true;
        document.getElementById("step2").disabled = false;
        document.getElementById("step1").className='register_inactive';
        document.getElementById("step2").className='register';
    }
    else
    if(regStep==2)
    {
        document.getElementById("step1").disabled=true;
        document.getElementById("step2").disabled = true;
        document.getElementById("step3").disabled=false;
        document.getElementById("step1").className='register_inactive';
        document.getElementById("step3").className='register'
        document.getElementById("offer").style.display='inline';
    }
}

 

function checkOrganExist()
{
   
        $.post('classes/ajx/ajxCommon.php',{
            orgnisation:$("#orgcode").val(),
            m:"existorgnsation"
        },
        function(data){
           
            if(data>0)
            {
                var errorMsg = "This Organisation Code is already registered.<br />";
                $("#error_orgcode").html(errorMsg);
                document.getElementById("checkResult").value="no";

            //error = "true";
            }
            else
            {
                var errorMsg = "Available.<br />";
                $("#error_orgcode").html(errorMsg);
                document.getElementById("checkResult").value="yes";
            }
        }
        );
    
}