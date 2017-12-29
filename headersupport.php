<?php
ob_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Dastjar</title>
<META http-equiv="Content-Type" content="text/html; charset=utf-8">

<link href="client/css/stylesheet123.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<script language="JavaScript" src="client/js/jquery.js" type="text/javascript"></script>
<script type="text/javascript" src="lib/vtip/js/vtip.js"></script>
<link rel="stylesheet" type="text/css" href="lib/vtip/css/vtip.css" />


</head>

<body>
<div id="container">
<div id="header">
<div id="logo" align="center"><a href="<?=_HOME_?>"><img src="images/logo.png" width="249" height="118" /></a></div>

<div id="nevi">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
<tr>

<td height="72" colspan="4" align="right" style="font-size:14px; font-weight:bold;"><?php
//echo "userid".$_SESSION['userid'];
if ($_SESSION['supportusername'])
{
echo "<b>Welcome ".$_SESSION['supportusername']."</b>  ";
echo " | <a href='commonAction.php?act=supportlogout'> LogOut </a>";
}
else
{
//echo "<a href='login.php'> Advertiser Sign In</a>";
}

?></td>
<td width="1%" height="72" align="center" style="font-size:14px; font-weight:bold;">&nbsp;</td>
</tr>
<tr>
    
<!--<td width="38%" align="right" id="nevigation_color" ><a href='login.php'><?if (!$_SESSION['username'])
{ ?>Advertiser Sign In<? } ?></a></td>-->


<td width="39%" align="center" id="nevigation_color" style="text-shadow: 0px 1px 0px #e5e5ee; filter: dropshadow(color=#e5e5ee,offX=0,offY=1);"><!--<img src="images/aboutus_button.png" width="115" height="30" /> -->
<!--		<a href="aboutUs.php">About Us</a></td>-->

<td width="21%" align="right" id="nevigation_color" style="text-shadow: 0px 1px 0px #e5e5ee; filter: dropshadow(color=#e5e5ee,offX=0,offY=1);"><!--<img src="images/contactus_button.png" width="123" height="30" /> -->
<!--		<a href="contactus.php">Contact Us</a></td>-->
</tr>
</table>	
</div>


</div>
</div>
</body>
</html>
