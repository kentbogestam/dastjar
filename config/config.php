<?php

/*  File Name : config.php
 *  Description : config file 
 *  Author  : Sushil Singh  Date: 12th,nov,2010  Creation
 */


/* Local Setting */

<<<<<<< HEAD
$base_url = "https://admin-dev.dastjar.com/";
$user_app_base_url = "https://anar-dev.dastjar.com/";
=======
$base_url = "http://localhost/dastjar/";
$user_app_base_url = "http://localhost/anar/public/";
>>>>>>> 5cc0b9d863b050c75ae40bf9926604635487b3e7

$basePath = $_SERVER["DOCUMENT_ROOT"] . '/';

define('BASEPATH', $basePath);
define('USER_APP_BASE_URL', $user_app_base_url);
<<<<<<< HEAD
define('BASE_PATH_NO_ADMIN', 'https://admin-dev.dastjar.com/');
=======
define('BASE_PATH_NO_ADMIN', 'http://localhost/dastjar/');
>>>>>>> 5cc0b9d863b050c75ae40bf9926604635487b3e7
define('BASE_URL', $base_url);
define('_HOME_', "https://admin-dev.dastjar.com/");


/* End Here for Local Setting */
define('FUNCTION_DIR', 'function/');
//define('TIME_ZONE','Asia/Calcutta');
<<<<<<< HEAD
define('UPLOAD_DIR', BASEPATH . 'upload/');
define('_UPLOAD_URLDIR_', $base_url . 'upload/');

/////////// upload image dirctory/////////
define('_UPLOAD_IMAGE_', $basePath . 'upload/');
=======
define('UPLOAD_DIR', BASEPATH . 'admin/upload/');
define('_UPLOAD_URLDIR_', $base_url . 'upload/');

/////////// upload image dirctory/////////
define('_UPLOAD_IMAGE_', $basePath . 'admin/upload/');
>>>>>>> 5cc0b9d863b050c75ae40bf9926604635487b3e7

define('IMAGE_AMAZON_PATH', 'https://s3-eu-west-1.amazonaws.com/dastjar-coupons/upload/');

define('IMAGE_DIR_PATH', $basePath . 'admin/lib/bin/cumbari_s3.sh');

define('IMAGE_DIR_PATH_DELETE', $basePath . 'admin/lib/bin/cumbari_s3del.sh');

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

define('PERCH_EMAIL_METHOD', 'smtp');
define('PERCH_EMAIL_HOST', 'smtp.mailtrap.io');
define('PERCH_EMAIL_SECURE', 'tls');
define('PERCH_EMAIL_AUTH', true);
define('PERCH_EMAIL_PORT', 2525);
define('PERCH_EMAIL_USERNAME', 'fc37838be07f5f');
define('PERCH_EMAIL_PASSWORD', '4504d2abb7065c');

///////////////////////
// Register for google map key with your domain and update it
define('_GKEY_', 'ABQIAAAA4I2FJ12u6k_VsKf1ZkAGxBRpedP_AkQ-0qMxmraAuu868TnwrBSjQz5UviQktpqH1TVF0HGxFVl12A');

/* Stripe ID and KEY */
$stripe_client_id = 'ca_BsQwDxmv6Nde3fzblaLT8KiuPh7q02px'; // test 
<<<<<<< HEAD
//$stripe_client_id = 'ca_BsQwCBSJ8NG6N6346v26Ep5z51raygS9'; // live 
$stripe_client_secret = 'sk_test_EypGXzv2qqngDIPIkuK6aXNi'; // test 
//$stripe_client_secret = 'sk_live_INm31rvosK6bnFT48xjipoBP'; // live 

=======
//$stripe_client_id = 'ca_BsQwCBSJ8NG6N6346v26Ep5z51raygS9'; // live
$stripe_pub_id = 'pk_test_5P1GedJTk0HsWb3AnjYBbz6G'; // test 
//$stripe_pub_id = 'pk_live_VGfy6Y668OALZbbUVbY9FwXV'; // live  
$stripe_client_secret = 'sk_test_EypGXzv2qqngDIPIkuK6aXNi'; // test 
//$stripe_client_secret = 'sk_live_INm31rvosK6bnFT48xjipoBP'; // live 

define('STRPIE_CLIENT_SECRET', $stripe_client_secret);

/* Google Captcha ID and KEY */
$captcha_site_key = '6Le-8UgUAAAAAHADYrs839SRaC8d8XacoiH9w5ao'; // test 
//$captcha_site_key = '6LeDA0kUAAAAANgrH6YdoQmix-_OawzmczkQr094'; // live 
$captcha_secret_key = '6Le-8UgUAAAAAPuaEkq19jbaC1k16Kys541kOjB4'; // test 
//$captcha_secret_key = '6LeDA0kUAAAAALDRS2EZYnsprwDqOayFuSELyFbX'; // live 

>>>>>>> 5cc0b9d863b050c75ae40bf9926604635487b3e7
$category_array = array();
$category_array[1] = "Shopping";
$category_array[2] = "Snacks";
$category_array[3] = "Clothes";
?>
