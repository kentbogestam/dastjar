<?php
/*  File Name   : main.php
*   Description : Main form
*   Author      : Deo
*   Date        : 4th,Dec,2010  Creation
*/

include_once("cumbari.php");
 include("headersupport.php");
$inoutObj = new inOut();

//$regObj = new registration();
//$regObj->isValidRegistrationStep();




//$inoutObj = new inOut();
//if(!isset($_SESSION['userid'])) {
//    $url = BASE_URL.'login.php';
//    $inoutObj->reDirect($url);
//    exit();
//}

$current_tab = basename($_SERVER['SCRIPT_FILENAME'], '.php');
$selected_tab_css = ' style="background-color:#ADDFFF" ';

?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="client/css/mouseovertabs.css">
<!--<script language="javascript" src="client/js/main.js" type="text/javascript" ></script>-->
<script language="javascript" src="client/js/mouseovertabs.js" type="text/javascript" ></script>


</head>
<body>

<div id="yourtabsmenu" class="tabsmenuclass" style="width:900px; margin-left:auto; margin-right:auto;">
<ul>

<li><a  href="userActivity.php" >User Activity</a></li>
<li><a  href="showCategory.php" > Category</a></li>
<li><a  href="showPartner.php" > Partner</a></li>

</ul>
</div>

    

</body>
</html>