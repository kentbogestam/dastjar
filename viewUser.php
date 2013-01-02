<?php
/*  File Name : addCompany.php
*  Description : Add Company Form
*  Author  :Himanshu Singh  Date: 12th,Nov,2010  Creation
*/
include_once("cumbari.php");
$menu = "account";
$account = 'class="selected"';
$deleted = 'checked="checked"';
include_once("main.php");
$accountObj = new accountView();
$data = $accountObj->getUserDetail();
include_once("header.php");
?>
<?php include 'config/defines.php'; ?>
<style type="text/css">
body { margin: 100px }
a { }
img { border: 0 }
#registerform .redwhitebutton {
}
</style>

<link href="lib/grid/css/grid.css" rel="stylesheet" type="text/css" />
<body>
<div class="center">
<form name="register" action="" id="registerform" method="POst">
<div align="center" style="margin-top:10px; margin-bottom:10px;"> <?php
if ($_SESSION['MESSAGE']) {
echo $_SESSION['MESSAGE'];
$_SESSION['MESSAGE'] = "";
}
?></div>
<input type="hidden" name="m" value="saveuser">

<div class="bg_darkgray1" style="text-align:center; font-size:18px; font-weight:bold;">
<br>
User Details</div>
<a href="changePassword.php"> <img style="padding-left:30px;" src="images/changepassword_button.png" width="30" height="30" /></a><br />
Change Password 
<table BORDER=0 width="100%">
<tr>
	<td colspan="3" align="center">
			<a href="editUser.php"><img src="client/images/edit.png" border="0"></a></td>
  </tr>
<tr>
	<td width="24%"></td>
  <td width="36%"></td>
  <td width="40%"></td>
</tr>

<tr>
	<td width="29%" >&nbsp;</td>
  <td width="29%">Email Address:</td>
  <td width="42%"><b/><?=$data[0]['email']
?></td>
</tr>

<tr>
	<td>&nbsp;</td>
  <td>First Name:</td>
  <td><b/><?=$data[0]['fname']
?></td>
</tr>
<tr>
	<td>&nbsp;</td>
  <td>Last Name:</td>
  <td><b/><?=$data[0]['lname']
?></td>
</tr>
<tr>
	<td>&nbsp;</td>
  <td>Phone Number:</td>
  <td><b/><? $d=$data[0]['phone']
?>
   <?php if ($d == 0)
		echo "Not specified";
	 else
		echo $d; ?>            </td>
</tr>
<tr>
	<td>&nbsp;</td>
  <td>Mobile Number:</td>
  <td><b/><?  $d=$data[0]['mobile_phone']
?>
    <?php if ($d == 0)
		echo "Not specified";
	 else
		echo $d; ?>            </td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	</tr>
<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	</tr>
</table>
</form></div>
<div><? include("footer.php"); ?></div>
</body>
</html>
