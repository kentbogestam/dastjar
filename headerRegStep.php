<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Dastjar</title>


<link href="client/css/stylesheet123.css" rel="stylesheet" type="text/css" />
<link href="client/css/stylesheet.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script language="JavaScript" src="client/js/jquery.js" type="text/javascript"></script>
<script type="text/javascript" src="lib/vtip/js/vtip.js"></script>
<link rel="stylesheet" type="text/css" href="lib/vtip/css/vtip.css" />


</head>

<body>
<div id="container">
<div id="header">
<div id="logo"><img src="images/logo.jpg" /></div>

<div id="nevi">
<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td width="13%" height="47">&nbsp;</td>
<td width="27%">&nbsp;</td>
<td width="35%">&nbsp;</td>
<td width="25%">&nbsp;</td>
</tr>
<tr>
<td >&nbsp;</td>
<td colspan="2" id="nevigation_color">		<?php
//echo "userid".$_SESSION['userid'];
if ($_SESSION['username'])
{
echo "<b>Welcome ".$_SESSION['username']."</b> | <a href='commonAction.php?act=logout'> LogOut </a>";
}
else
{
echo "<a href='login.php'> Advertiser Sign In</a>";
}

?></td>
<td id="nevigation_color"><a href="#">About Us</a></td>
</tr>
</table>

</div>


</div>
</div>
