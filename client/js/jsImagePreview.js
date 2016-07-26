/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


(function () {
         
	var filesUploadPicture = document.getElementById("picture");
	var filesUploadIcon = document.getElementById("icon");


	function uploadFile (file,field) {
		var width, height;
		if(field=="picture"){
		width=220;
		height=112;
		var fileList = document.getElementById("pic_upload");
		}else{
		width=38;
		height=38;
		var fileList = document.getElementById("upload_area");
		
		}
		fileList.innerHTML="";
			var img,
			reader,
			xhr,
			fileInfo;

		if (typeof FileReader !== "undefined" && (/image/i).test(file.type)) {
			img = document.createElement("img");
			img.setAttribute('width',width);
            img.setAttribute('height',height);
			fileList.appendChild(img);
			reader = new FileReader();
			reader.onload = (function (theImg) {
				return function (evt) {
					theImg.src = evt.target.result;
				};
			}(img));
			reader.readAsDataURL(file);
		}

	}

	function traverseFiles (files,field) {
		if (typeof files !== "undefined") {
				uploadFile(files[0],field);
		}
		else {
			fileList.innerHTML = "No support for the File API in this web browser";
		}
	}
	
	///// For Large image preview  ////////////////
	filesUploadPicture.addEventListener("change", function() {
		 //alert("Event");
		 if(!short_validation()){
		//alert("validation")

		return false;
		exit;
		}else
		{
			traverseFiles(this.files,"picture");
		}
	}, false);
	
	///// For icon preview  ////////////////
	filesUploadIcon.addEventListener("change", function() {
		 //alert("Event");
		 if(!short_validation()){
		//alert("validation")

		return false;
		exit;
		}else
		{
			traverseFiles(this.files,"icon");
		}
	}, false);


}) ();
