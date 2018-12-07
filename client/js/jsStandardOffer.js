/*  File Name : addCompany.php
 *  Description : Add Company Form
 *  Author  :Himanshu Singh  Date: 25th,Nov,2010  Creation
*/
$(document).ready(function(){
	
	$("#continue").click(function(){

        var error = 'false';
        //$("#MsgError").html('');
        //$("#step1_error").hide();
        //$("#msg_error").hide();
        $("#error_titleSloganStand").html('');
        $("#error_icon").html('');
        $("#error_standOfferName").html('');
        $("#error_searchKeywordStand").html('');
        // $("#error_picture").html('');
        // $("#error_linkedCatStand").html('');
        //$("#error_descriptiveStand").html('');
       
        $("#error_startDateStand").html('');
        //$("#error_cat_icon").html('');
        $("#error_link").html('');
         $("#error_sponsStand").html('');
         

        if($.trim($("#titleSloganStand").val()).length == 0)
        {
            var errorMsg = "Please Enter Your Product Name.<br />";
            $("#error_titleSloganStand").html(errorMsg);
            error = "true";
        }else
        if($.trim($("#titleSloganStand").val()).length > 24)
        {
            var errorMsg = "Your Product Name for Standard offer exceeds the limit.<br />";
            $("#error_titleSloganStand").html(errorMsg);
            error = "true";
        }

        $('#icon').bind('change', function() {
          iconSize = this.files[0].size;
        });

        if($.trim($("#xx").val()) == '')
        {
            var errorMsg = "Please Select Dish Type.<br />";
            $("#error_dishType").html(errorMsg);
            return false;
        }

        if($.trim($("#icon").val()).length!=0){

            $('.box-icon-default').hide();
           
            if(!isValidPngImage($("#icon").val()))
            {
                var errorMsg = "Please upload an icon in png, jpg and jpeg format only.<br />";
                $("#error_icon").html(errorMsg);
                error = "true";
            }else if(iconSize>6000000)
            {
                var errorMsg = "Image size should be smaller than 6MB.<br />";
                $("#error_icon").html(errorMsg);
                error = "true";
            }
        }
        else {
            if( !$('#icondefault').is(':checked') )
            {
                var errorMsg = "Please choose an image or use default image below.<br />";
                $("#error_icon").html(errorMsg);
                error = "true";
            }

            $('.box-icon-default').show();
        }

       

       if($.trim($("#sponsStand").val()).length ==0)
        {
            var errorMsg = "Please Select Your Sponsor.<br />";
            $("#error_sponsStand").html(errorMsg);
            error = "true";
        }


        // if($.trim($("#linkedCatStand").val()) == '')
        // {
        //     var errorMsg = "Please Select a Category<br />";
        //     $("#error_linkedCatStand").html(errorMsg);
        //     error = "true";
        // }


        if($.trim($("#searchKeywordStand").val()).length > 91)
        {
            var errorMsg = "Your Search Keyword exceeds the limit.<br />";
            $("#error_searchKeywordStand").html(errorMsg);
            error = "true";
        }

	    if(($.trim($("#searchKeywordStand").val()).length == 0))
        {
            var errorMsg = "Please enter one or more Search Keyword<br />";
            $("#error_searchKeywordStand").html(errorMsg);
            error = "true";
        }

        // if($.trim($("#largeimage").val()).length==0){

        //     if(($("#picture").val())=='')
        //     {
        //         var errorMsg = "Please upload image in jpeg or png format.<br />";
        //         $("#error_picture").html(errorMsg);
        //         error = "true";
        //     }else
        //     if(!isValidJpegImage($("#picture").val()))
        //     {
        //         var errorMsg = "Please upload image in jpeg or png format.<br />";
        //         $("#error_picture").html(errorMsg);
        //         error = "true";
        //     }
        // }
        //  else
        // {
        //     if(($("#picture").val()!=''))
        //     {
        //         if(!isValidJpegImage($("#picture").val()))
        //         {
        //             var errorMsg = "Please upload image of jpeg Or png format.<br />";
        //             $("#error_picture").html(errorMsg);
        //             error = "true";
        //         }
        //     }
        // }




        var startDate = $.trim($("#startDateStand").val());

        if(startDate=='')
        {
            var errorMsg = "Please Enter Start Date.<br />";
            $("#error_startDateStand").html(errorMsg);
            error = "true";
        }


        var now = new Date();

         if(Date(now)>Date(startDate))
        {
            var errorMsg = "Please select valid date.<br />";
            $("#error_startDateStand").html(errorMsg);
            error = "true";
        }


       


//        if($.trim($("#eanCode").val()).length==0 && $.trim($("#productNumber").val()).length ==0)
//        {
//            var errorMsg = "Please Enter either EAN Code or product number.<br />";
//            $("#error_eanCode").html(errorMsg);
//            $("#error_productNumber").html(errorMsg);
//            error = "true";
//        }
        
//                if($.trim($("#productNumber").val()).length ==0)
//                {
//                    var errorMsg = "Please Enter either EAN Code or product number.<br />";
//                    $("#error_productNumber").html(errorMsg);
//                    error = "true";
//                }

//else if($.trim($("#eanCode").val()).length>0 )
//          {
//             if(!isNumeric($.trim($("#eanCode").val())))
//                {
//                    var errorMsg = "Please Enter valid EAN Code.<br />";
//                    $("#error_eanCode").html(errorMsg);
//                    error = "true";
//                }
//          }
//                else
//
//                if(($.trim($("#eanCode").val()).length >0) && ($.trim($("#eanCode").val()).length >11) )
//                {
//                    var errorMsg = "Please Enter Valid length of EAN Code.<br />";
//                    $("#error_eanCode").html(errorMsg);
//                    error = "true";
//                }

 if(($.trim($("#link").val()).length >0))
  {
 if(!isURL($.trim($("#link").val())))
        {
            var errorMsg = "Please Enter Valid Link .<br />";
            $("#error_link").html(errorMsg);
            error = "true";
        }
  }

/*if(($.trim($("#descriptiveStand").val()).length >0))
  {
    //alert("---"+isURL($.trim($("#descriptiveStand").val())))
	if(!isURL($.trim($("#descriptiveStand").val())))
        {
            var errorMsg = "Please Enter Valid Link .<br />";
            $("#error_descriptiveStand").html(errorMsg);
            error = "true";
        }
  }*/
        //alert(errorMsg+"---"+error);
     //////////////////////////////////////////////

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
    else if(val.match(/\.(jpg||JPG)$/)){
        return true;
    }
    else if(val.match(/\.(jpeg||JPEG)$/)){
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

    if (val.match(/\.(jpg||JPG||jpeg||JPEG||png||PNG)$/))
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
        id.style.display = "inline";
    }
    else
    if(id.style.display == "inline"){
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
 // alert(val)
 //var urlregex = new RegExp("^(http:\/\/www.|https:\/\/www.|ftp:\/\/www.|www.|http:\/\/.){1}([0-9A-Za-z]+\.)");
  var urlregex = new RegExp("([0-9A-Za-z]+\.)");
  //alert(urlregex.test(val));
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

function getCatImage(catId,form){
    $.post('classes/ajx/ajxCommon.php',{
        catId:catId,
        m:"getCatImg"
    },
    function(data){
	
        if(data)
        {            var imageData = "<img src=upload/category_lib/"+data+">";
            $("#category_image").val(data);
            $("#category_image_div").html(imageData);
                   
        }
        iconPreviewCat(imageData)
               
    }
    );
}
function iconPreviewCat(imageData)
{
	
	if(!short_validation()){
            return false;
            exit;
        }
		else
		{
			$("#tslogan").html($("#titleSloganStand").val());
 			$("#sslogan").html($("#subSlogan").val());

			$("#upload_area").html(imageData);
		}
	return false;


	//ajaxUpload(form,'classes/ajx/ajxUpload.php?filename=icon&amp;maxW=200','upload_area'); return false;
}


function iconPreview(form)
{

	if(!short_validation()){
            return false;
            exit;
        }
		else
		{
		 $("#tslogan").html($("#titleSloganStand").val());
		 $("#sslogan").html($("#subSlogan").val());
		}
	return false;
}




function getLangImage(langId){
  //alert(lang)
    $.post('classes/ajx/ajxCommon.php',{
        langId:langId,
        m:"getLangImg",
        contentType: "application/x-www-form-urlencoded;charset=utf-8",
    },
    function(data){

        if(data)
        {
            //alert(data);

           var categoryData = "<select id='linkedCatStand' onchange='getCatImage(this.value);' class='text_field_new' tabindex='27' name='linkedCatStand'><option value=''>Select Category</option>"+data+"</select>";
            $("#category_lang_div").html(categoryData);

        }

    }
    );
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
		 $("#pictslogan").html($("#titleSloganStand").val());
		 
//			//alert(document.getElementById('iconF').value); return false;
//		var myicon=document.getElementById('picImg');
//		myicon.src=document.getElementById('picture').files[0].getAsDataURL();
//		//var IMGsrc = "<img src='"+myiconsrc+"' width='55' height='60'>"
//		document.getElementById('picImg').style.visibility = 'visible';
//		//document.getElementById("upload_area").innerHTML = IMGsrc;

		}
	return false;
}


function getTitleForProduct(form)
{
    //alert(form);
            //alert($("#titleSloganStand").val());
               
		 $("#productName").val($("#titleSloganStand").val());
               

	return false;
}

function delete_standStore(id)
{
    if(confirm('Are you sure you want to delete this record?')) {
        var url ='commonAction.php?act=deleteViewstandStore&'+id;
        window.location = url;
    }
}

function standardPreview(form)
{

       $("#tSlogen").html($("#titleSloganStand").val());


    return false;


//ajaxUpload(form,'classes/ajx/ajxUpload.php?filename=icon&amp;maxW=200','upload_area'); return false;
}

$(document).ready(function(){
    $("[id*=submit-btn]").click(function(){
        $("#error_dishName").html('');
        checkDishTypeExist();
    });
});

/* Function Header :checkDishTypeExist()
*             Args: none
*           Errors: none
*     Return Value: none
*      Description:To check whether the email_id exist or not
*/


function checkDishTypeExist()
{
    if($("#txtDishType").val().trim().length<1)
    {
        var errorMsg = "Please Enter Dish Type.<br />";
        $("#error_newDishType").html(errorMsg);
    }else{
        $.post('classes/ajx/ajxCommon.php',{
            dish_type:$("#txtDishType").val().trim(),
            lang:$("#lang").val(),
            m:"existdishtype"
        },
        function(data){
            if(data>0)
            {
                var errorMsg = "This dish type already exists.<br />";
                $("#error_newDishType").html(errorMsg);
            }
            else
            {
                var errorMsg = "Available.<br />";
                addNewDishTpye();
            }
        }
        );
    }
}
