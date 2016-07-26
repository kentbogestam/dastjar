<?php

/*  File Name   : accoutSupport.php
*   Description : Status and updates of company payment status
*   Author      : Kent Bogestam
*   Date        : 6th,Juli,2016  Creation
*/

header('Content-Type: text/html; charset=utf-8');

ob_start();
include_once("cumbari.php");
$inoutObj = new inOut();
$menu = "account";
$account = 'class="selected"';
include("mainSupport.php");


if(!isset($_SESSION['supportuserid'])) {
    $url = BASE_URL . 'support.php';
    $inoutObj->reDirect($url);
    exit;
}


	   
	   
?>


<script language="JavaScript" src="client/js/jsLogin.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/account.js" type="text/javascript"></script>
<link href="client/css/stylesheet123.css" rel="stylesheet" type="text/css" />
<link href="lib/grid/css/grid.css" rel="stylesheet" type="text/css" />


<html>
<head>


<link href="lib/grid/css/grid.css" rel="stylesheet" type="text/css" />
<link href="client/css/stylesheet123.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="lib/grid/js/grid.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/account.js" type="text/javascript"></script>
</head>
<body>
<div class="center">
 <div style="font-size: 22px; margin-top:20px;">
<b>Account</b>
</div>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">

          <form id="submitFrm" name="submitFrm" action="" method="get" >

        <tr>
            <td height="20"></td>
        </tr>
<div align="center"><h2><?php
                                                            if ($_SESSION['MESSAGE']) {
                                                                echo $_SESSION['MESSAGE'];
                                                                $_SESSION['MESSAGE'] = "";
                                                            }
                                                                    ?></h2></div>



                                                     <table>
                                                    <tr>
                                                       <td width="26%" align="left" valign="top"><div align="center" class="inner_grid"  >Check Organisations account to find if payment is done<br></div></td>
                                                    </tr>
                                                    <tr>
                                                       <td width="26%" align="left" valign="top"><div align="center" class="inner_grid" id="accountStatus"  ><br><br></div> </td>
                                                    </tr>
                                                    <tr>
                                                        </td>
                                                       <td width="26%" align="left" valign="top"><div align="center" class="main_bg" onclick="checkAccount()" ><strong>Check Account status</strong></div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                       <td width="26%" align="left" valign="top"><div align="center" class="inner_grid" ><br><br>Set Organisations account to fit payment status<br></div> </td>
                                                    </tr>
                                                    <tr>
                                                       <td width="26%" align="left" valign="top"><div align="center" class="inner_grid" id=transStatus ><br><br><br></div> </td>
                                                    </tr>
                                                    <tr>
                                                        </td>
                                                       <td width="26%" align="left" valign="top"><div align="center" class="main_bg" onclick="setAccount()" ><strong>Set Account status</strong></div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        </td>
                                                       <td width="26%" align="left" valign="top"><div align="center" class="inner_grid"  ><br><br></div>
                                                        </td>
                                                    </tr>
                                                </table>



</div>


 <? include("footer.php"); ?>
</body>
</html>
