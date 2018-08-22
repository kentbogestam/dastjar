<?php

/**
 * Mayank
 */
class testlogs
{
	function logs($str = ""){
        $t=time();
        // echo BASE_URL . "upload/log" . date("Ymd",$t) . ".txt";
        // die();

        // $myfile = fopen("upload/log" . date("Ymd",$t) . ".txt", "a") or die("Unable to open file!");

        try{
            $myfile = fopen("upload/log" . date("Ymd",$t) . ".txt", "a");
        }catch(Exception $ex){
            echo $ex;
            die();
        }

        $txt = date("Y-m-d",$t) . " - " . $str . "  \n";
        fwrite($myfile, $txt);
        fclose($myfile);
    }
}

$testlogs = new testlogs();
$testlogs->logs("Hello World");