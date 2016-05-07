<?php
ob_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cumbari</title>
<META http-equiv="Content-Type" content="text/html; charset=ISO-8859-15">
<link href="client/css/stylesheet123.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<script language="JavaScript" src="client/js/jquery.js" type="text/javascript"></script>
<!--<script type="text/javascript" src="lib/vtip/js/vtip.js"></script>
<link rel="stylesheet" type="text/css" href="lib/vtip/css/vtip.css" />-->
</head>
<body>
<div id="container">
<div style="float: right; font-size: 18px; right: 10px; position: absolute; right: 510px; padding-top: 5px; padding-right: 22px;"><a style="text-decoration:none" href="index.php" id="nevigation_color"></a></div>
  <div id="header">
    <div id="logo" align="center"><a href="http://cumbari.com/index_org.php" ><img src="images/cmarkplatf.png" width="249" height="118" /></a></div>
    <div id="nevi">
      <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="72" colspan="4" align="right" style="font-size:14px; font-weight:bold;"><?php
//echo "userid".$_SESSION['userid'];
if ($_SESSION['username'])
{
echo "<b>Welcome ".$_SESSION['username']."</b>  ";
if($_SESSION['active_state']==5){

    if($_SESSION['userrole'] == 'Store Admin')
    {
    echo" | <a href='showCampaign.php'>My Account </a>";
    }if($_SESSION['userrole'] == 'Reseller')
 {
    echo" | <a href='showResellerCampaign.php'>My Account</a>";
        }

    }
    echo " | <a href='commonAction.php?act=logout'> LogOut </a>";
}
else
{
//echo "<a href='login.php'> Advertiser Sign In</a>";
}

?></td>
          <td width="1%" height="72" align="center" style="font-size:14px; font-weight:bold;">&nbsp;</td>
        </tr>
        <tr>
          <td width="38%" align="center" id="nevigation_color" ><a href='login.php'>
            <?if (!$_SESSION['username'])
{ ?>
            Advertiser Sign In
            <? } ?>
            </a></td>
          <td width="18%" align="center" id="nevigation_color" ><a href='loginReseller.php'>
            <?if (!$_SESSION['username'])
{ ?>
            Reseller
            <? } ?>
            </a></td>
        </tr>
      </table>
    </div>
  </div>
</div>
</body>
</html>
