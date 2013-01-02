<?php

/*  File Name : config.php
 *  Description : config file 
 *  Author  : Sushil Singh  Date: 12th,nov,2010  Creation
 */


/* Local Setting */

$base_url = "http://localhost/cumbari_admin/";
$basePath = $_SERVER["DOCUMENT_ROOT"] . '/cumbari_admin/';

$base_url = "http://localhost/cumbari_admin/";

define('BASEPATH', $basePath);
define('BASE_PATH_NO_ADMIN', 'http://localhost/');
define('BASE_URL', $base_url);
define('_HOME_', "http://localhost/cumbari_admin_new");


/* End Here for Local Setting */
define('FUNCTION_DIR', 'function/');
//define('TIME_ZONE','Asia/Calcutta');
define('UPLOAD_DIR', BASEPATH . 'upload/');
define('_UPLOAD_URLDIR_', $base_url . 'upload/');

/////////// upload image dirctory/////////
define('_UPLOAD_IMAGE_', $basePath . 'upload/');
define('IMAGE_AMAZON_PATH', 'https://s3-eu-west-1.amazonaws.com/cumbari-coupons/upload/');
define('IMAGE_DIR_PATH', '/usr/local/bin/cumbari_s3.sh ');
define('IMAGE_DIR_PATH_DELETE', '/usr/local/bin/cumbari_s3del.sh ');

/* Get site user info */
$db = new db();
$con = $db->makeConnection();

$languages = "english";
define("LANGUAGE", "English");


/* Client Paths */
define('IMG_PATH', 'client/images/');
define('CSS_PATH', 'client/css/');
define('JS_PATH', 'client/js/');
define('LIB_PATH', BASE_URL . 'lib/');
define('PAGING', 10);

///////////////////////
// Register for google map key with your domain and update it
define('_GKEY_', 'ABQIAAAA4I2FJ12u6k_VsKf1ZkAGxBRpedP_AkQ-0qMxmraAuu868TnwrBSjQz5UviQktpqH1TVF0HGxFVl12A');

$category_array = array();
$category_array[1] = "Shopping";
$category_array[2] = "Snacks";
$category_array[3] = "Clothes";
?>
