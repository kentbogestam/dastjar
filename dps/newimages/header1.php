<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cumbari</title>


<link href="css/Home.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<!--<script language="JavaScript" src="/client/js/jquery.js" type="text/javascript"></script>a-->
<!--<script type="text/javascript" src="/lib/vtip/js/vtip.js"></script>a-->



</head>

<body>
<div id="container">
<div id="header">
<div id="logo" align="center"><a href="#"><img src="newimages/images/logo.png" width="249" height="118" /></a></div>

<div id="nevi">
	<table width="100%" height="100%" cellpadding="0" cellspacing="0">
				<tr>
						<td height="72" align="center" style="font-size:14px; font-weight:bold;"></td>
						<td height="72" colspan="2" align="right" style="font-size:14px; font-weight:bold; font-family:Verdana,Arial,Helvetica,sans-serif;"></td>
						<td width="1%" height="72" align="center" style="font-size:14px; font-weight:bold;">&nbsp;</td>
				</tr>
				<tr>
						<td width="53%" align="center" id="nevigation_color" style="text-shadow: 0px 1px 0px #e5e5ee; filter: dropshadow(color=#e5e5ee,offX=0,offY=1);"><a href="http://advertise.cumbari.com/aboutUs.php" ><?php
//echo "userid".$_SESSION['userid'];
if ($_SESSION['username'])
{
echo "<b>Welcome ".$_SESSION['username']."</b> | <a href='http://advertise.cumbari.com/commonAction.php?act=logout'> LogOut </a>";
}
else
{
echo "<a href='http://advertise.cumbari.com/login.php'> Advertiser Sign In</a>";
}

?></td>
						
                               
						<td width="24%" id="nevigation_color"  style="text-shadow: 0px 1px 0px #e5e5ee; filter: dropshadow(color=#e5e5ee,offX=0,offY=1);"><a href="http://advertise.cumbari.com/aboutUs.php">About Us</a></td>
						<td width="22%" align="right" id="nevigation_color"  style="text-shadow: 0px 1px 0px #e5e5ee; filter: dropshadow(color=#e5e5ee,offX=0,offY=1);"><a href="http://advertise.cumbari.com/contactus.php">Contact Us</a></td>
				</tr>
		</table>	
</div>


</div>
