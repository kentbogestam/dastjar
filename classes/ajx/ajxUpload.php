<?php
include_once("../../cumbari.php");
include('../../lib/resizer/resizer.php');

function uploadImage1($fileName, $maxH = null ) {
    //echo "here1"; die();
   //print_r($_FILES[$fileName]);
    $maxlimit = 9999999999;
	$maxW = 200;
	$colorR =255;
	$colorG =255;
	$colorB =255;
	$fullPath= BASE_URL."upload/category/";
	$relPath= "../../upload/category/";
	 $folder = $relPath;
    $allowed_ext = "png,PNG";
    $match = "";
    $filesize = $_FILES[$fileName]['size'];
//    $info = pathinfo($_FILES["filename"]["name"]);
//    $cat_filename = $CategoryIconName.".".$info['extension'];
//                    //move_uploaded_file($_FILES["icon"]["tmp_name"],UPLOAD_DIR."Category/" .$cat_filename);
//                    $fileOriginal=$_FILES['filename']['tmp_name'];
//                    $crop	=	'5';
//                    $size ='iphone4_cat';
//                    $path = UPLOAD_DIR."category/";
//                    $fileThumbnail = $path.$cat_filename;
//                    createFileThumbnail($fileOriginal, $fileThumbnail, $size, $frontUpload=0,$crop, &$errorMsg) ;
    if($filesize > 0) {
        $filename = strtolower($_FILES[$fileName]['name']);
        $filename = preg_replace('/\s/', '_', $filename);
        if($filesize < 1) {
            $errorList[] = "File size is empty.";
        }
        if($filesize > $maxlimit) {
            $errorList[] = "File size is too big.";
        }
        if(count($errorList)<1) {
            $file_ext = preg_split("/\./",$filename);
            $allowed_ext = preg_split("/\,/",$allowed_ext);
            foreach($allowed_ext as $ext) {
                if($ext==end($file_ext)) {
                    $match = "1"; // File is allowed
                    $NUM = time();
                    $front_name = substr($file_ext[0], 0, 15);
                    $newfilename = $front_name."_".$NUM.".".end($file_ext);
                    $filetype = end($file_ext);
                    $save = $folder.$newfilename;
                    if(!file_exists($save)) {
                        list($width_orig, $height_orig) = getimagesize($_FILES[$fileName]['tmp_name']);
                        if($maxH == null) {
                            if($width_orig < $maxW) {
                                $fwidth = $width_orig;
                            }else {
                                $fwidth = $maxW;
                            }
                            $ratio_orig = $width_orig/$height_orig;
                            $fheight = $fwidth/$ratio_orig;

                            $blank_height = $fheight;
                            $top_offset = 0;

                        }else {
                            if($width_orig <= $maxW && $height_orig <= $maxH) {
                                $fheight = $height_orig;
                                $fwidth = $width_orig;
                            }else {
                                if($width_orig > $maxW) {
                                    $ratio = ($width_orig / $maxW);
                                    $fwidth = $maxW;
                                    $fheight = ($height_orig / $ratio);
                                    if($fheight > $maxH) {
                                        $ratio = ($fheight / $maxH);
                                        $fheight = $maxH;
                                        $fwidth = ($fwidth / $ratio);
                                    }
                                }
                                if($height_orig > $maxH) {
                                    $ratio = ($height_orig / $maxH);
                                    $fheight = $maxH;
                                    $fwidth = ($width_orig / $ratio);
                                    if($fwidth > $maxW) {
                                        $ratio = ($fwidth / $maxW);
                                        $fwidth = $maxW;
                                        $fheight = ($fheight / $ratio);
                                    }
                                }
                            }
                            if($fheight == 0 || $fwidth == 0 || $height_orig == 0 || $width_orig == 0) {
                                die("FATAL ERROR REPORT ERROR CODE");
                            }
                            if($fheight < 45) {
                                $blank_height = 45;
                                $top_offset = round(($blank_height - $fheight)/2);
                            }else {
                                $blank_height = $fheight;
                            }
                        }
                        $image_p = imagecreatetruecolor($fwidth, $blank_height);
                        $white = imagecolorallocate($image_p, $colorR, $colorG, $colorB);
                        imagefill($image_p, 0, 0, $white);
                        switch($filetype) {
                            case "gif":
                                $image = @imagecreatefromgif($_FILES[$fileName]['tmp_name']);
                                break;
                            case "jpg":
                                $image = @imagecreatefromjpeg($_FILES[$fileName]['tmp_name']);
                                break;
                            case "jpeg":
                                $image = @imagecreatefromjpeg($_FILES[$fileName]['tmp_name']);
                                break;
                            case "png":
                                $image = @imagecreatefrompng($_FILES[$fileName]['tmp_name']);
                                break;
                        }
                        @imagecopyresampled($image_p, $image, 0, $top_offset, 0, 0, $fwidth, $fheight, $width_orig, $height_orig);
                        switch($filetype) {
                            case "gif":
                                if(!@imagegif($image_p, $save)) {
                                    $errorList[]= "PERMISSION DENIED [GIF]";
                                }
                                break;
                            case "jpg":
                                if(!@imagejpeg($image_p, $save, 100)) {
                                    $errorList[]= "PERMISSION DENIED [JPG]";
                                }
                                break;
                            case "jpeg":
                                if(!@imagejpeg($image_p, $save, 100)) {
                                    $errorList[]= "PERMISSION DENIED [JPEG]";
                                }
                                break;
                            case "png":
                                if(!@imagepng($image_p, $save, 0)) {
                                    $errorList[]= "PERMISSION DENIED [PNG]";
                                }
                                break;
                        }
                        @imagedestroy($filename);
                    }else {
                        $errorList[]= "CANNOT MAKE IMAGE IT ALREADY EXISTS";
                    }
                }
            }
        }
    }else {
        $errorList[]= "NO FILE SELECTED";
    }
    if(!$match) {
        $errorList[]= "File type isn't allowed: $filename";
    }
    if(sizeof($errorList) == 0) {
        return $fullPath.$newfilename;
    }else {
        $eMessage = array();
        for ($x=0; $x<sizeof($errorList); $x++) {
            $eMessage[] = $errorList[$x];
        }
        return $eMessage;
    }
}
function uploadImage($fileName, $maxH = null ) {
    //echo "here1"; die();
  // print_r($_FILES[$fileName]);
    $maxlimit = 9999999999;
	$maxW = 200;
	$colorR =255;
	$colorG =255;
	$colorB =255;
	$fullPath= BASE_URL."upload/category/";
	$relPath= "../../upload/category/";
	 $folder = $relPath;
    $allowed_ext = "png,PNG";
    $match = "";
    $filesize = $_FILES[$fileName]['size'];
    $CategoryIconName = "cat_icon_".md5(time());
    $info = pathinfo($_FILES[$fileName]["name"]);
    $cat_filename = $CategoryIconName.".".$info['extension'];
                    //move_uploaded_file($_FILES["icon"]["tmp_name"],UPLOAD_DIR."Category/" .$cat_filename);
                    $fileOriginal=$_FILES[$fileName]['tmp_name'];
                    $crop	=	'5';
                    $size ='iphone4_cat';
                    $path = UPLOAD_DIR."category/";
                    $fileThumbnail = $folder.$cat_filename;
                    createFileThumbnail($fileOriginal, $fileThumbnail, $size, $frontUpload=0,$crop, &$errorMsg) ;
 $upload_image = BASE_URL."upload/category/".$fileThumbnail; //die();
 return $upload_image;
}
////////////////////////////////////////////////////////
$filename = strip_tags($_REQUEST['filename']);
$maxSize = strip_tags($_REQUEST['maxSize']);
$maxW = strip_tags($_REQUEST['maxW']);
$fullPath = strip_tags($_REQUEST['fullPath']);
$relPath = strip_tags($_REQUEST['relPath']);
$colorR = strip_tags($_REQUEST['colorR']);
$colorG = strip_tags($_REQUEST['colorG']);
$colorB = strip_tags($_REQUEST['colorB']);
$maxH = strip_tags($_REQUEST['maxH']);
$filesize_image = $_FILES[$filename]['size'];
if($filesize_image > 0) {
    
    $upload_image = uploadImage($filename, $maxH);
    if(is_array($upload_image)) {
        foreach($upload_image as $key => $value) {
            if($value == "-ERROR-") {
                unset($upload_image[$key]);
            }
        }
        $document = array_values($upload_image);
        for ($x=0; $x<sizeof($document); $x++) {
            $errorList[] = $document[$x];
        }
        $imgUploaded = false;
    }else {
        $imgUploaded = true;
    }
}else {
    $imgUploaded = false;
    $errorList[] = "File Size Empty";
}
?>
<?php
if($imgUploaded) {


    if (isset($_GET['campaignId']))
     {
    $db = new db();
    
    $icon = basename($upload_image);
    $campaignid = $_GET['campaignId'];

       
    $query = "UPDATE `cumbari_admin`.`campaign` SET  `small_image` = '".$icon."' WHERE `campaign`.`campaign_id` = '".$campaignid."'";
    $res = mysql_query($query) or die(mysql_error());

    $query = "UPDATE `cumbari_admin`.`coupon` SET  `small_image` = '".$icon."' WHERE `coupon`.`campaign_id` = '".$campaignid."'";
    $res = mysql_query($query) or die(mysql_error());
 }
    
   
    
    echo '<img src="'.$upload_image.'" border="0" />';
}else {
    echo '<img src="/php_ajax_image_upload/images/error.gif" width="16" height="16px" border="0" style="marin-bottom: -3px;" /> Error(s) Found: ';
    foreach($errorList as $value) {
        echo $value.', ';
    }
}
?>