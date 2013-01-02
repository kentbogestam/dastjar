<?php   
session_start();

/*  File Name   : cumbari.php
 *  Description : config file 
 *  Author      : Sushil Singh  Date: 12th,Nov,2010  Creation
*/    

/* Include  Config DB  Files */
//error_reporting(E_ALL); 
ini_set('display_errors', 0);

require_once('config/defines.php');
require_once('config/dbConfig.php');
require_once('config/config.php');
require_once('config/help.php');
//require('classes/db.php');


function __autoload($class_name) {
    include "classes/".$class_name . '.php';
}


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

?>