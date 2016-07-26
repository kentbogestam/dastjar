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
        $("#MsgError").html('');
        $("#step1_error").hide();
        $("#msg_error").hide();
        $("#error_linkedCat").html('');
        $("#error_titleSlogan").html('');
        $("#error_subSlogan").html('');
        $("#error_icon").html('');
        $("#error_cat_icon").html('');
        $("#error_startDate").html('');
        $("#error_endDate").html('');
        $("#error_linkedCat").html('');
        //$("#error_brandName").html('');
        //$("#error_searchKeyword").html('');
        $("#error_limitDays").html('');
        $("#error_picture").html('');
        $("#error_selectStore").html('');
        //$("#error_descriptive").html('');


        var id = document.getElementById("CampaignBehavior");
        if(id.style.display == "none"){
            id.style.display = "inline";
        }


        var id = document.getElementById("ExtendedCampaign");
        if(id.style.display == "none"){
            id.style.display = "inline";
        }




        if(($.trim($("#selectStore").val()))=='')
        {
            var errorMsg = "Please create Store  first.<br/>";
            $("#error_selectStore").html(errorMsg);
            error = "true";
        }

     
        if(($.trim($("#titleSlogan").val()).length == 0))
        {
            var errorMsg = "Please Enter Your Title Slogan.<br />";
            $("#error_titleSlogan").html(errorMsg);
            error = "true";
        }else
        if(($.trim($("#titleSlogan").val()).length > 20))
        {
            var errorMsg = "Your Title Slogan exceeds the limit.<br />";
            $("#error_titleSlogan").html(errorMsg);
            error = "true";
        }


        if(($.trim($("#subSlogan").val()).length == 0))
        {
            var errorMsg = "Please Enter Your Title Slogan.<br />";
            $("#error_subSlogan").html(errorMsg);
            error = "true";
        }else
        if(($.trim($("#subSlogan").val()).length > 50))
        {
            var errorMsg = "Your Title Slogan exceeds the limit.<br />";
            $("#error_subSlogan").html(errorMsg);
            error = "true";
        }


        //    if(document.getElementById("category_lib").style.display=="inline")
        //    {
        //        if($.trim($("#smallimage").val()).length==0){
        //            if(document.getElementById("category_icon").checked==false){
        //                var errorMsg = "Please upload an icon to represent your Offer.<br />";
        //                $("#error_cat_icon").html(errorMsg);
        //                error = "true";
        //            }
        //        }
        //    }else
        //        if(document.getElementById("category_own").style.display=="inline")
        //    {
        //        if($("#smallimage").val()==''){
        //            if($("#icon").val()==''){
        //                var errorMsg = "Please upload an icon to represent your Offer.<br />";
        //                $("#error_icon").html(errorMsg);
        //                error = "true";
        //            }
        //        }
        //    }

       if($.trim($("#icon").val()).length!=0){
           
                if(!isValidPngImage($("#icon").val()))
                {
                    var errorMsg = "Please upload an icon of png format only.<br />";
                    $("#error_icon").html(errorMsg);
                    error = "true";
                }
            //alert(error);
           
        }
		
        var startDate = $.trim($("#startDate").val());
        var endDate = $.trim($("#endDate").val());

        if(startDate=='')
        {
            var errorMsg = "Please enter Start Date.<br />";
            $("#error_startDate").html(errorMsg);
            error = "true";
        }

        if(endDate=='')
        {
            var errorMsg = "Please enter End Date.<br />";
            $("#error_endDate").html(errorMsg);
            error = "true";
        }
        else
        if(!ValidateDate(startDate,endDate))
        {
            var errorMsg = "End Date must be greater than or equal to Start Date.<br />";
            $("#error_endDate").html(errorMsg);
            error = "true";
        }



        if(($.trim($("#startDateLimitation").val()).length == 0))
        {
            var errorMsg = "Please Enter Start Time<br />";
            $("#error_startDateLimitation").html(errorMsg);
            error = "true";
        }


        if(($.trim($("#endDateLimitation").val()).length == 0))
        {
            var errorMsg = "Please Enter End Time<br />";
            $("#error_endDateLimitation").html(errorMsg);
            error = "true";
        }


        if($.trim($("#linkedCat").val()) == '')
        {
            var errorMsg = "Please Select a Category<br />";
            $("#error_linkedCat").html(errorMsg);
            error = "true";
        }



        if(($.trim($("#limitDays").val()).length == 0))
        {
            var errorMsg = "Please Limit The Campaign days<br />";
            $("#error_limitDays").html(errorMsg);
            error = "true";
        }

        if($.trim($("#largeimage").val()).length==0){

            if(($("#picture").val()==''))
            {
                var errorMsg = "Please upload Image for your coupon.<br />";
                $("#error_picture").html(errorMsg);
                error = "true";
            }
            else
            if(!isValidJpegImage($("#picture").val()))
            {
                var errorMsg = "Please upload Image of jpeg format.<br />";
                $("#error_picture").html(errorMsg);
                error = "true";
            }
        }

        //alert (errorMsg);
       // alert (error);

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



function isValidJpegImage(val)
{

    if (val.match(/\.(jpg||JPG||jpeg||JPEG)$/))
    {
        return true;
    }
    else
    {
        return false;
    }
}
function showCampaignBehavior(){
    var id = document.getElementById("CampaignBehavior");
    if(id.style.display == "none"){
        id.style.display = "inline";
    }
    else
    if(id.style.display == "inline"){
        id.style.display = "none";
    }
}

function showExtendedCampaign(){
    var id = document.getElementById("ExtendedCampaign");
    if(id.style.display == "none"){
        id.style.display = "inline";
    }
    else
    if(id.style.display == "inline"){
        id.style.display = "none";
    }
}


function isURL(val) {
    if(val.match(/http:\/\/[A-Za-z0-9\.-]{3,}\.[A-Za-z]{3}/)){
        return true;
    }
    else{
        return false;
    }
}

function ValidateDate(SDate,EDate)
{
    var eDate = new Date(EDate);
    var sDate= new Date(SDate);
    if(sDate <= eDate)
    {
        return true;
    }
    else
    if(sDate > eDate)
    {
        return false;
    }


}

function chooseCategory(id)
{
    if(id==1)
    {
        document.getElementById("category_lib").style.display="block";
        document.getElementById("category_own").style.display="none";
        document.getElementById('selected_image').value="0";
    }
    else
    {
        document.getElementById("category_own").style.display="block";
        document.getElementById("category_lib").style.display="none";
        document.getElementById('selected_image').value="1";
    }
    //alert(flag);
    return true;

}

function valButton1(btn) {
    //var btn21 = document.getElementById("cat_icon");
    var btn1 = document.registerform.cat_icon;
    //alert(btn1.length); return false;
    var cnt = 0;
    for (var i=btn1.length-1; i > -1; i--) {
        //alert(btn1[i].value)
        if (btn1[i].checked==true)
        {
            //alert(btn1[i].value)
            selectedRadioArray = btn1[i].value.split(".");
            selectedRadio = selectedRadioArray[0];
            cnt = 1;
        //alert(cnt);
        }
    }
    if (cnt > 0)
        return true;
    else
        return false;
}

function getCatImage(catId){
    //alert(catId)
    $.post('classes/ajx/ajxCommon.php',{
        catId:catId,
        m:"getCatImg"
    },
    function(data){

        if(data)
        {
            //alert(data);
            var imageData = "<img src=upload/category_lib/"+data+">";
            $("#category_image").val(data);
            $("#category_image_div").html(imageData);

        }

    }
    );
}



