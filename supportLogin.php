<?php

/*  File Name   : supportlogin.php
*   Description : support login
*   Author      : Amit
*/
header('Content-Type: text/html; charset=utf-8');
include_once("cumbari.php");
include("Paging.php");

$inoutObj = new inOut();

if(!isset($_SESSION['supportuserid'])) {
    $url = BASE_URL . 'support.php';
    $inoutObj->reDirect($url);
    exit;
}
else
{
	$userid = $_GET['userid'];
	$action = $_GET['action'];
	if($action=='showUser')
	{
		$inoutObj->usrLogin('','',$userid);
	}
	else if($action=='showActivities')
	{
		$data = $inoutObj->showUserActivities($userid);
	}

}

?>


<?php //include("headersupport.php");?>
<script language="JavaScript" src="client/js/jsLogin.js" type="text/javascript"></script>
<link href="client/css/stylesheet123.css" rel="stylesheet" type="text/css" />
<link href="lib/grid/css/grid.css" rel="stylesheet" type="text/css" />

<body>
<div class="center">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td class="header-bg"></td>
        </tr>
        <tr>
            <td height="22" class="tnb_admin">&nbsp;</td>
        </tr>
        <tr>
            <td height="373" valign="top"><br />

                <form id="submitFrm" name="submitFrm" action="" method="post" >
                    <input type="hidden" name="m" value="support_in">

                   
					    <table width="100%" cellpadding="0" cellspacing="2" class="border">
                                                    
			  <tr align="center" height="26" >
										<td width="15%" height="25" align="center" class="bg_darkgray1"><strong>User Name</strong></td>
									  <td width="15%" class="bg_darkgray1"><strong>Login Id</strong></td>
										<td width="30%" class="bg_darkgray1"><strong>Log in Time</strong></td>
										<td width="30%" align="center" class="bg_darkgray1"><strong>Log Out Time</strong></td>
									</tr>
									<?php
									foreach($data as $data1)
										{
									?>

										<tr align="center" height="26" >
											<td align="center">
											<?php 
											if(!empty($data1['supportusername']))
											{
												echo $data1['supportusername'];
											}
											else
											{
												echo  $data1['username'];
											}
										    ?>
											</td>
											<td align="center">
											<?php 
											if(!empty($data1['supportemail']))
											{
												echo $data1['supportemail'];
											}
											else
											{
												echo  $data1['useremail'];
											}
										    ?>
											</td>
											<td align="center"><?php echo $data1['in_time']; ?></td>
											<td align="center"><?php echo $data1['out_time']; ?></td>
										</tr>

									<?php } ?>


                         </table>

              </form>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>

        <tr>
            <td height="30" align="left">

            </td>
        </tr>
    </table></div>
    <?php
    include_once("footer.php");
    ?>


