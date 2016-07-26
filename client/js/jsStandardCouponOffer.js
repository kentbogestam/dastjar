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
        $("#error_standOfferName").html('');
       // $("#error_searchKeywordStand").html('');
        $("#error_picture").html('');
        $("#error_linkedCatStand").html('');

        $("#error_cat_icon").html('');

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


        //        if($.trim($("#subSloganStand").val()).length == 0)
        //        {
        //            var errorMsg = "Please Enter Your Sub Slogan for Standard offer.<br />";
        //            $("#error_subSloganStand").html(errorMsg);
        //            error = "true";
        //        }else
        //        if($.trim($("#subSloganStand").val()).length > 30)
        //        {
        //            var errorMsg = "Your Sub Slogan for Standard offer exceeds the limit.<br />";
        //            $("#error_subSloganStand").html(errorMsg);
        //            error = "true";
        //        }

        if($.trim($("#smallimage").val()).length==0){
            if(document.getElementById("category_lib").style.display!="none")
            {
                var chkbtn = document.getElementById("cat_icon")
                if(!valButton(chkbtn))
                {
                    var errorMsg = "Please select an icon to represent your Offer.<br />";
                    $("#error_cat_icon").html(errorMsg);
                    error = "true";
                }
            }
            else
            {
                if(!isValidPngImage($("#icon").val()))
                {
                    var errorMsg = "Please upload an icon in png format only.<br />";
                    $("#error_icon").html(errorMsg);
                    error = "true";
                }
            }
        }



        if($.trim($("#standOfferName").val()).length == 0)
        {
            var errorMsg = "Please Enter Your Standard offer name.<br />";
            $("#error_standOfferName").html(errorMsg);
            error = "true";
        }else
        if($.trim($("#standOfferName").val()).length > 15)
        {
            var errorMsg = "Your Standard offer name exceeds the limit.<br />";
            $("#error_standOfferName").html(errorMsg);
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
                var errorMsg = "Please upload picture as your coupon.<br />";
                $("#error_picture").html(errorMsg);
                error = "true";
            }else
            if(!isValidJpegImage($("#picture").val()))
            {
                var errorMsg = "Please upload picture of Jpeg format.<br />";
                $("#error_picture").html(errorMsg);
                error = "true";
            }
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
//
//function isURL(val) {
//    if(val.match(/http:\/\/[A-Za-z0-9\.-]{3,}\.[A-Za-z]{3}/)){
//        return true;
//    }
//    else{
//        return false;
//    }
//}

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

