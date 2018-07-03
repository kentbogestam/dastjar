function $m(theVar){
    return document.getElementById(theVar)
}
function remove(theVar){
    var theParent = theVar.parentNode;
    theParent.removeChild(theVar);
}
function addEvent(obj, evType, fn){
    if(obj.addEventListener)
        obj.addEventListener(evType, fn, true)
    if(obj.attachEvent)
        obj.attachEvent("on"+evType, fn)
}
function removeEvent(obj, type, fn){
    if(obj.detachEvent){
        obj.detachEvent('on'+type, fn);
    }else{
        obj.removeEventListener(type, fn, false);
    }
}
function isWebKit(){
    return RegExp(" AppleWebKit/").test(navigator.userAgent);
}
var selectedRadio = null;

function ajaxUpload(form,url_action,id_element){
    if($("#icon").val()=="")
    {		
		if(!short_validation()){
            return false;
            exit;
        }
        $m('short_preview').style.display="inline";
        $m('upload_area').innerHTML = $m('category_image_div').innerHTML;
        $m('tslogan').innerHTML = $m('titleSloganStand').value;
    }
    else
    {
    if(!short_validation()){
        return false;
        exit;
    }

    var html_show_loading = ""; //"File Uploading Please Wait...&lt;br /&gt;&lt;img src=\'lib/php_ajax_image_upload/images/loader_light_blue.gif\' width=\'128\' height=\'15\' border=\'0\' /&gt;";
    var html_error_http = ""; //'&lt;img src=\'images/error.gif\' width=\'16\' height=\'16\' border=\'0\' /&gt; Error in Upload, check settings and path info in source code.';
    var detectWebKit = isWebKit();
    form = typeof(form)=="string"?$m(form):form;
    var erro="";

    if(form==null || typeof(form)=="undefined"){
        erro += "The form of 1st parameter does not exists.\n";
    }else if(form.nodeName.toLowerCase()!="form"){
        erro += "The form of 1st parameter its not a form.\n";
    }
    if($m(id_element)==null){
        erro += "The element of 3rd parameter does not exists.\n";
    }
    if(erro.length>0){
        alert("Error in call ajaxUpload:\n" + erro);
        return;
    }
    var iframe = document.createElement("iframe");
    iframe.setAttribute("id","ajax-temp");
    iframe.setAttribute("name","ajax-temp");
    iframe.setAttribute("width","0");
    iframe.setAttribute("height","0");
    iframe.setAttribute("border","0");
    iframe.setAttribute("style","width: 0; height: 0; border: none;");
    $m('preview_frame').parentNode.appendChild(iframe);
    window.frames['ajax-temp'].name="ajax-temp";
    var doUpload = function(){
        removeEvent($m('ajax-temp'),"load", doUpload);
        var cross = "javascript: ";
        cross += "window.parent.$m('"+id_element+"').innerHTML = document.body.innerHTML; void(0);";
        $m(id_element).innerHTML = html_error_http;
        $m('ajax-temp').src = cross;
        if(detectWebKit){
            remove($m('ajax-temp'));
        }else{
            setTimeout(function(){
                remove($m('ajax-temp'))
            }, 250);
        }
    }
    addEvent($m('ajax-temp'),"load", doUpload);
    form.setAttribute("target","ajax-temp");
    form.setAttribute("action",url_action);
    form.setAttribute("method","post");
    form.setAttribute("enctype","multipart/form-data");
    form.setAttribute("encoding","multipart/form-data");
    if(html_show_loading.length > 0){
        $m(id_element).innerHTML = html_show_loading;
    }
    else
    {
        $m('short_preview').style.display="inline";
        $m('tslogan').innerHTML = $m('titleSloganStand').value;
    }
    form.submit();
    form.setAttribute("action","");
    form.setAttribute("target","_self");
	}
}

function short_validation()
{

    var error = "false";
    $("#error_titleSloganStand").html('');
    $("#error_preparationTime").html('');
    $("#error_dishType").html('');
    $("#error_dishName").html('');
    $("#error_productDescription").html('');
    $("#error_icon").html('');
    $("#error_cat_icon").html('');

    if(($.trim($("#titleSloganStand").val()).length == 0))
    {
        var errorMsg = "Please Enter Your Product Name.<br />";
        $("#error_titleSloganStand").html(errorMsg);
        error = "true";
       
    }else
    if(($.trim($("#titleSloganStand").val()).length > 50))
    {
        var errorMsg = "Your Product Name exceeds the limit.<br />";
        $("#error_titleSloganStand").html(errorMsg);
        error = "true";
    }

    if($.trim($("#dishType").val()) == '')
    {
        var errorMsg = "Please Enter Dish Type.<br />";
        $("#error_dishType").html(errorMsg);
        error = "true";
    }

    if($.trim($("#dishName").val()) == '')
    {
        var errorMsg = "Please Enter Dish Name.<br />";
        $("#error_dishName").html(errorMsg);
        error = "true";
    }

    if($.trim($("#preparationTime").val()) == '')
    {
        var errorMsg = "Please Enter Preparation Time.<br />";
        $("#error_preparationTime").html(errorMsg);
        error = "true";
    }

    if($.trim($("#productDescription").val()) == '')
    {
        var errorMsg = "Please Enter Product Description.<br />";
        $("#error_productDescription").html(errorMsg);
        error = "true";
    }
	
	// if($.trim($("#linkedCatStand").val()) == '')
	// {
	// 	var errorMsg = "Please Select a Category<br />";
	// 	$("#error_linkedCatStand").html(errorMsg);
	// 	error = "true";
	// }
	
	 if($.trim($("#icon").val()).length!=0){
           
                if(!isValidPngImage($("#icon").val()))
                {
                    var errorMsg = "Please upload an icon in png format only.<br />";
                    $("#error_icon").html(errorMsg);
                    error = "true";
                }
            
           
        }    
	
       // if(!isValidPngImage($("#icon").val()))
//        {
//            var errorMsg = "Please upload an icon of PNG format only.<br />";
//            $("#error_icon").html(errorMsg);
//            error = "true";
//        }
        //alert(error);
	

   if(error=="true")
    {
        return false;

    }
    return true;
}

function valButton(btn) {
	var btn1 = document.register.cat_icon;
    var cnt = 0;
    for (var i=btn1.length-1; i > -1; i--) {
        if (btn1[i].checked==true)
        {
		   selectedRadioArray = btn1[i].value.split(".");
		   selectedRadio = selectedRadioArray[0];
		   cnt = 1; 
        }
    }
    if (cnt > 0)
        return true;
    else
        return false;
}
