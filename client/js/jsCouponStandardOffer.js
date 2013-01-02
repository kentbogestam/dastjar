/*  File Name : addCompany.php
 *  Description : Add Company Form
 *  Author  :Himanshu Singh  Date: 25th,Nov,2010  Creation
*/
$(document).ready(function(){

    $("#continue").click(function(){

        var error = 'false';
        $("#MsgError").html('');
        $("#step1_error").hide();
        $("#msg_error").hide();
        $("#error_titleSloganStand").html('');
        $("#error_icon").html('');
       // $("#error_standOfferName").html('');
        $("#error_picture").html('');
        $("#error_linkedCatStand").html('');
        $("#error_descriptiveStand").html('');
        $("#error_cat_icon").html('');
        $("#error_selectStore").html('');

        if($.trim($("#titleSloganStand").val()).length == 0)
        {
            var errorMsg = "Please Enter Your Title Slogan for Standard offer.<br />";
            $("#error_titleSloganStand").html(errorMsg);
            error = "true";
        }else
        if($.trim($("#titleSloganStand").val()).length > 15)
        {
            var errorMsg = "Your Title Slogan for Standard offer exceeds the limit.<br />";
            $("#error_titleSloganStand").html(errorMsg);
            error = "true";
        }


        if($.trim($("#linkedCatStand").val())=='')
        {
            var errorMsg = "Please select a category.<br />";
            $("#error_linkedCatStand").html(errorMsg);
            error = "true";
        }


        if($.trim($("#largeimage").val()).length==0){

            if(($("#picture").val())=='')
            {
                var errorMsg = "Please upload Image for your coupon.<br />";
                $("#error_picture").html(errorMsg);
                error = "true";
            }else
            if(!isValidJpegImage($("#picture").val()))
            {
                var errorMsg = "Please upload Image in jpeg format.<br />";
                $("#error_picture").html(errorMsg);
                error = "true";
            }
        }

        if(($.trim($("#selectStore").val()))=='')
        {
            var errorMsg = "Please create Store  first.<br />";
            $("#error_selectStore").html(errorMsg);
            error = "true";
        }


        if($.trim($("#descriptiveStand").val()).length > 60)
        {
            var errorMsg = "Please Enter Descriptive text less than 60 characters.<br />";
            $("#error_descriptiveStand").html(errorMsg);
            error = "true";
        }

        alert(errorMsg+"---"+error);


        if(error=="true")
        {
            return false;

        }
        return true;

    });
});

/* Function Header :isValidPngImage(val)
*             Args: none
*           Errors: none
*     Return Value: none
*      Description:To check whether the icon is of png format or not
    */

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
/* Function Header :isValidJpegImage(val)
*             Args: none
*           Errors: none
*     Return Value: none
*      Description:To check whether the picture is of jpeg format or not
    */

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

function showAdvancedSearchStand(){
    var id = document.getElementById("advancedSearchStand");
    if(id.style.display == "none"){
        id.style.display = "inline-table";
    }
    else
    if(id.style.display == "inline-table"){
        id.style.display = "none";
    }

}


function showAdvancedInfoPageStnad(){
    var id = document.getElementById("infopageStand");
    if(id.style.display == "none"){
        id.style.display = "inline-table";
    }
    else
    if(id.style.display == "inline-table"){
        id.style.display = "none";
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

function isURL(val) {

 var urlregex = new RegExp("^(http:\/\/www.|https:\/\/www.|ftp:\/\/www.|www.|http:\/\/.){1}([0-9A-Za-z]+\.)");
if(urlregex.test(val))
    //if(val.match(/http:\/\/[A-Za-z0-9\.-]{3,}\.[A-Za-z]{3}/))
       {
       return true;
    }
    else{
        return false;
    }
}

function valButton(btn) {
    //var btn21 = document.getElementById("cat_icon");
    var btn1 = document.register.cat_icon;
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
