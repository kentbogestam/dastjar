/*  File Name : addCompany.php
 *  Description : Add Company Form
 *
 */
$(document).ready(function(){


    $("#continue").click(function(){

        var error = 'false';
        $("#MsgError").html('');
        $("#step1_error").hide();
        $("#msg_error").hide();

        $("#error_titleSloganStand").html('');
         $("#error_searchKeywordStand").html('');


//
//
//        var id = document.getElementById("CampaignBehavior");
//        if(id.style.display == "none"){
//            id.style.display = "inline";
//        }
//
//
//
//
//        var id = document.getElementById("ExtendedCampaign");
//        if(id.style.display == "none"){
//            id.style.display = "inline";
//        }



        if(($.trim($("#titleSloganStand").val()).length == 0))
        {
            var errorMsg = "Please Enter Your Title Slogan.<br />";
            $("#error_titleSloganStand").html(errorMsg);
            error = "true";
        }else
        if(($.trim($("#titleSloganStand").val()).length > 19))
        {
            var errorMsg = "Your Title Slogan exceeds the limit.<br />";
            $("#error_titleSloganStand").html(errorMsg);
            error = "true";
        }


       

         if(($.trim($("#searchKeywordStand").val()).length == 0))
        {
            var errorMsg = "Please Enter Your Keyword.<br />";
            $("#error_searchKeywordStand").html(errorMsg);
            error = "true";
        }else
        if(($.trim($("#searchKeywordStand").val()).length > 91))
        {
            var errorMsg = "Your Search Keyword exceeds the limit.<br />";
            $("#error_searchKeywordStand").html(errorMsg);
            error = "true";
        }



        if(error=="true")
        {

            return false;

        }
        return true;
    });
});

function isURL(val) {
    if(val.match(/http:\/\/[A-Za-z0-9\.-]{3,}\.[A-Za-z]{3}/)){
        return true;
    }
    else{
        return false;
    }
}

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
    // alert(val);

    if (val.match(/\.(jpg||JPG||jpeg||JPEG||png||PNG)$/))
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
        id.style.display = "inline-table";
    }
    else
    if(id.style.display == "inline-table"){
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



function showIconCat()
{

    $("#tslogan").html($("#titleSlogan").val());
    $("#sslogan").html($("#subSlogan").val());
    //alert(document.getElementById('iconF').value); return false;
    //var myicon=document.getElementById('icon');
    var myiconsrc=document.getElementById('icon').files[0].getAsDataURL();
    var IMGsrc = "<img src='"+myiconsrc+"' width='30' height='30'>"
    document.getElementById("upload_area").innerHTML = IMGsrc;
//document.getElementById('myCatIcon').style.visibility = 'visible';

// Check if rendering succeded
}


function iconPreviewCat(imageData)
{

    if(!short_validation()){
        //alert("validation")

        return false;
        exit;
    }
    else
    {
        $("#tslogan").html($("#titleSlogan").val());
        $("#sslogan").html($("#subSlogan").val());

        $("#upload_area").html(imageData);
    }
    return false;


//ajaxUpload(form,'classes/ajx/ajxUpload.php?filename=icon&amp;maxW=200','upload_area'); return false;
}

function iconPreview(form)
{

    if(!short_validation()){
        //alert("validation")

        return false;
        exit;
    }
    else
    {
        $("#tslogan").html($("#titleSlogan").val());
        $("#sslogan").html($("#subSlogan").val());
        //	         alert(document.getElementById('iconF').value); return false;
        //		var myicon=document.getElementById('icon');
        //		var myiconsrc=document.getElementById('icon').files[0].getAsDataURL();
        //		var IMGsrc = "<img src='"+myiconsrc+"' width='30' height='30'>"
        //		document.getElementById("upload_area").innerHTML = IMGsrc;
//        (function () {
//            var filesUpload = document.getElementById("icon");
//
//
//            function uploadFile (file) {
//                var fileList = document.getElementById("upload_area");
//                fileList.innerHTML="";
//                var img,
//                reader,
//                xhr,
//                fileInfo;
//
//                if (typeof FileReader !== "undefined" && (/image/i).test(file.type)) {
//                    img = document.createElement("img");
//                    fileList.appendChild(img);
//                    reader = new FileReader();
//                    reader.onload = (function (theImg) {
//                        return function (evt) {
//                            theImg.src = evt.target.result;
//                        };
//                    }(img));
//                    reader.readAsDataURL(file);
//                }
//
//            }
//
//            function traverseFiles (files) {
//                if (typeof files !== "undefined") {
//                    uploadFile(files[0]);
//                }
//                else {
//                    fileList.innerHTML = "No support for the File API in this web browser";
//                }
//            }
//
//            filesUpload.addEventListener("change", function () {
//                traverseFiles(this.files);
//            }, false);
//
//
//        }) ();

    }
    return false;
}

function getLangImage($selectedId,langId){
    //alert(lang)
    $.post('classes/ajx/ajxCommon.php',{
        langId:langId,
        $selectedId:$selectedId,
        m:"getLangSingleImg",
        contentType: "application/x-www-form-urlencoded;charset=utf-8",
    },
    function(data){

        if(data)
        {
            //alert(data);

            var categoryData = "<div id='linkedCat'  tabindex='27' name='linkedCat'>"+data+"</div>";
            $("#category_lang_div").html(categoryData);

        }

    }
    );
}



function showIconPic()
{
    var myicon=document.getElementById('aicon');
    myicon.src=document.getElementById('picture').files[0].getAsDataURL();
    document.getElementById('aicon').style.visibility = 'visible';
// Check if rendering succeded
}

function picturePreview(form)
{

    if(!short_validation()){
        //alert("validation")

        return false;
        exit;
    }
    else
    {
        $("#pictslogan").html($("#titleSlogan").val());
        $("#picsslogan").html($("#subSlogan").val());
        //	        alert(document.getElementById('iconF').value); return false;
        //		var myicon=document.getElementById('picImg');
        //		myicon.src=document.getElementById('picture').files[0].getAsDataURL();
        //		var IMGsrc = "<img src='"+myiconsrc+"' width='55' height='60'>"
        //		document.getElementById('picImg').style.visibility = 'visible';
        //		//document.getElementById("upload_area").innerHTML = IMGsrc;
//        (function () {
//            var filesUpload = document.getElementById("picture");
//
//
//            function uploadFile (file) {
//                var fileList = document.getElementById("picImg");
//                fileList.innerHTML="";
//                var img,
//                reader,
//                xhr,
//                fileInfo;
//
//                if (typeof FileReader !== "undefined" && (/image/i).test(file.type)) {
//                    img = document.createElement("img");
//                    fileList.appendChild(img);
//                    reader = new FileReader();
//                    reader.onload = (function (theImg) {
//                        return function (evt) {
//                            theImg.src = evt.target.result;
//                        };
//                    }(img));
//                    reader.readAsDataURL(file);
//                }
//
//            }
//
//            function traverseFiles (files) {
//                if (typeof files !== "undefined") {
//                    uploadFile(files[0]);
//                }
//                else {
//                    fileList.innerHTML = "No support for the File API in this web browser";
//                }
//            }
//
//            filesUpload.addEventListener("change", function () {
//                traverseFiles(this.files);
//            }, false);
//
//
//        })();

    }
    return false;
}

// delete view campaign
function delete_campStore(id)
{
    if(confirm('Are you sure you want to delete this record?')) {
        var url ='commonAction.php?act=deleteViewStore&'+id;
        window.location = url;
    }
}


