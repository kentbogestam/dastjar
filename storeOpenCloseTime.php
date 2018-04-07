<?php 

	header('Content-Type: text/html; charset=utf-8');
	//header ('Content-type: text/html; charset=utf-8');



	include('lib/resizer/resizer.php');
	require_once('classes/db.php');
	require_once('config/dbConfig.php');
	require_once('classes/inOut.php');
	//use classes\db.php;
    $_SESSION['storeOpenCloseTime'] = $_POST;
    echo json_encode(true);
?>