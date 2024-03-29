<?php   
session_start();

/*  File Name   : cumbari.php
 *  Description : config file 
 *  Author      : Sushil Singh  Date: 12th,Nov,2010  Creation
*/    

/* Include  Config DB  Files */
//error_reporting(E_ALL); 
ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

require('config/defines.php');
require('config/dbConfig.php');
require('config/config.php');
require('config/help.php');
require_once(BASEPATH.'lib/php-image-resize/lib/ImageResize.php');

function __autoload($class_name) {
    include "classes/".$class_name . '.php';
}

//exit("Wess 34");
/* This is a general function which we are using to generate 36 Char unique id. */
function uuid()
{
	$chars = md5(uniqid(mt_rand(), true));
	$uuid  = substr($chars,0,8) . '-';
	$uuid .= substr($chars,8,4) . '-';
	$uuid .= substr($chars,12,4) . '-';
	$uuid .= substr($chars,16,4) . '-';
	$uuid .= substr($chars,20,12);
	return $uuid;
}

/**
 * Image resize using 'gumlet/php-image-resize' lib
 * @return [type] [description]
 */
function gumletImageResize($tmpName, $fileName, $path, $w, $h = '', $imgType = IMAGETYPE_JPEG)
{
	$image = new \Gumlet\ImageResize($tmpName);
    $image->resizeToWidth($w)->save($path.$fileName, $imgType);
	// ->save(BASEPATH.'upload/store_image/image1.jpg', $imgType);
	
	return $fileName;
}

?>
