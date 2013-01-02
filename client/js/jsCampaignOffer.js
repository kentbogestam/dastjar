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
        //        $("#error_cat_icon").html('');
        $("#error_brandName").html('');
        $("#error_startDate").html('');
        $("#error_endDate").html('');
        $("#error_linkedCat").html('');
        $("#error_campaignName").html('');
        $("#error_searchKeyword").html('');
        // $("#error_limitDays").html('');
        $("#error_picture").html('');
        $("#error_descriptive").html('');
        $("#error_sponsor").html('');
        //$("#error_codes").html('');
       


        var id = document.getElementById("CampaignBehavior");
        if(id.style.display == "none"){
            id.style.display = "inline";
        }




        var id = document.getElementById("ExtendedCampaign");
        if(id.style.display == "none"){
            id.style.display = "inline";
        }

        if(($.trim($("#campaignName").val()).length == 0))
        {
            var errorMsg = "Please Enter Your Campaign Name.<br />";
            $("#error_campaignName").html(errorMsg);
            error = "true";
        }

        if(($.trim($("#sponsor").val()).length == 0))
        {
            var errorMsg = "Please Select Your Sponsor.<br />";
            $("#error_sponsor").html(errorMsg);
            error = "true";
        }

       


        if(($.trim($("#titleSlogan").val()).length == 0))
        {
            var errorMsg = "Please Enter Your Title Slogan.<br />";
            $("#error_titleSlogan").html(errorMsg);
            error = "true";
        }else
        if(($.trim($("#titleSlogan").val()).length > 19))
        {
            var errorMsg = "Your Title Slogan exceeds the limit.<br />";
            $("#error_titleSlogan").html(errorMsg);
            error = "true";
        }


        if(($.trim($("#subSlogan").val()).length == 0))
        {
            var errorMsg = "Please Enter Your Sub Slogan.<br />";
            $("#error_subSlogan").html(errorMsg);
            error = "true";
        }else
        if(($.trim($("#subSlogan").val()).length > 51))
        {
            var errorMsg = "Your Sub Slogan exceeds the limit.<br />";
            $("#error_subSlogan").html(errorMsg);
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
        
        //  if($.trim($("#smallimage").val()).length!=0){
        //
        //
        //        if(!isValidPngImage($("#icon").val()))
        //        {
        //            var errorMsg = "Please upload an icon of PNG format only.<br />";
        //            $("#error_icon").html(errorMsg);
        //            error = "true";
        //        }
        //        //alert(error);
        //
        //	}



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
        ///////////////////////////////////
        if(($.trim($("#searchKeyword").val()).length > 91))
        {
            var errorMsg = "Your Search Keyword exceeds the limit.<br />";
            $("#error_searchKeyword").html(errorMsg);
            error = "true";
        }


        //
        //        if(($.trim($("#startDateLimitation").val()).length == 0))
        //        {
        //            var errorMsg = "Please Enter Start Time<br />";
        //            $("#error_startDateLimitation").html(errorMsg);
        //            error = "true";
        //        }
        //
        //
        //        if(($.trim($("#endDateLimitation").val()).length == 0))
        //        {
        //            var errorMsg = "Please Enter End Time<br />";
        //            $("#error_endDateLimitation").html(errorMsg);
        //            error = "true";
        //        }


        if($.trim($("#linkedCat").val()) == '')
        {
            var errorMsg = "Please Select Your Category<br />";
            $("#error_linkedCat").html(errorMsg);
            error = "true";
        }



        //        if(($.trim($("#limitDays").val()).length == 0))
        //        {
        //            var errorMsg = "Please Limit The Campaign days<br />";
        //            $("#error_limitDays").html(errorMsg);
        //            error = "true";
        //        }

        if($.trim($("#largeimage").val()).length==0){

            if(($("#picture").val()==''))
            {
                var errorMsg = "Please upload image in jpeg Or png format.<br />";
                $("#error_picture").html(errorMsg);
                error = "true";
               
            }
            else
            if(!isValidJpegImage($("#picture").val()))
            {
                var errorMsg = "Please upload image in jpeg Or png format.<br />";
                $("#error_picture").html(errorMsg);
                error = "true";
            }
        }
        else
        { 
            if(($("#picture").val()!=''))
            {
                if(!isValidJpegImage($("#picture").val()))
                {
                    var errorMsg = "Please upload image in jpeg Or png format.<br />";
                    $("#error_picture").html(errorMsg);
                    error = "true";
                }
            }
        }
        
        if(($.trim($("#descriptive").val()).length >0))
        {
            if(!isURL($.trim($("#descriptive").val())))
            {
                var errorMsg = "Please Enter Valid Link .<br />";
                $("#error_descriptive").html(errorMsg);
                error = "true";
            }
        }
       // alert(errorMsg+"---"+error);
// if($.trim($("#codes").val()) != '')
//        {
//            if($.trim($("#etntext").val()).length == 0)
//           {
//           var errorMsg = "Please Enter Code<br />";
//            $("#error_codes").html(errorMsg);
//            error = "true";
//           }
//        }

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

function getCatImage(catId, form){
    //alert(catId)
    $.post('classes/ajx/ajxCommon.php',{
        catId:catId,
        m:"getCatImg"
    },
    function(data){
	
        if(data)
        {
            //alert(data);
            var imageData = "<img id='myCatIcon' height=38 width=38 src=upload/category_lib/"+data+">";
            $("#category_image").val(data);
            $("#category_image_div").html(imageData);
                   
        }
		
        iconPreviewCat(imageData)
               
    }
    );
}

function getCatImageDefault(){

var imgPath = $("#smallimage").val();
var imageData = "<img id='myCatIcon' height=38 width=38 src='"+imgPath+"'>";
//iconPreviewCat(imageData)


        $("#tslogan").html($("#titleSlogan").val());
        $("#sslogan").html($("#subSlogan").val());
        $("#upload_area").html(imageData);
		//alert(imageData)
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

function wordwrap( str, width, brk, cut ) {

    brk = brk || '\n';
    width = width || 75;
    cut = cut || false;

    if (!str) { return str; }

    var regex = '.{1,' +width+ '}(\\s|$)' + (cut ? '|.{' +width+ '}|.+$' : '|\\S+?(\\s|$)');

    return str.match( RegExp(regex, 'g') ).join( brk );

}

function iconPreviewCat(imageData)
{
	
    if(!short_validation()){
        //alert("validation")

        return false;
        exit;
    }
    else
    {   //var xxx = $("#subSlogan").val()+'The quick brown fox jumped over the lazy dog.';
        //alert(wordwrap(xxx, 20, '<br/>\n'));
        $("#tslogan").html($("#titleSlogan").val());
        $("#sslogan").html($("#subSlogan").val());
  
        //$("#sslogan").html(wordwrap($("#subSlogan").val(), 10, '<br/>\n'));

       //// alert($("#subSlogan").val());
       // alert(wordwrap($("#subSlogan").val(), 10, '<br/>\n'));

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

function getLangImage(langId){
    //alert(lang)
    $.post('classes/ajx/ajxCommon.php',{
        langId:langId,
        m:"getLangImg",
        contentType: "application/x-www-form-urlencoded;charset=ISO-8859-15",
    },
    function(data){

        if(data)
        {
            //alert(data);

            var categoryData = "<select id='linkedCat' onchange='getCatImage(this.value);' class='text_field_new' tabindex='27' name='linkedCat'><option value=''>Select Category</option>"+data+"</select>";
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


function limitPreview(form)
{
         
       $("#ttSlogen").html($("#titleSlogan").val());
        $("#ssSlogen").html($("#subSlogan").val());
        var preview = '';
		if($("#limitDays").val()!="")
		{
			preview = preview+'<strong>Valid: </strong><span id="limitValid">'+$("#limitDays").val()+'</span><br>';
			
			if($("#startDateLimitation").val()!="" || $("#endDateLimitation").val()!="")
			{
			preview = preview + '<span id="startLimit">'+$("#startDateLimitation").val()+'</span>-<span id="endLimit">'+$("#endDateLimitation").val()+'</span>'
			}
		}
		
		
		//$("#startLimit").html($("#startDateLimitation").val());
        //$("#endLimit").html($("#endDateLimitation").val());
       // $("#limitValid").html($("#limitDays").val());
	   $("#limitPreview").html(preview);

     
    return false;


//ajaxUpload(form,'classes/ajx/ajxUpload.php?filename=icon&amp;maxW=200','upload_area'); return false;
}