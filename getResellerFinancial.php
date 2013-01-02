<?php
include_once("cumbari.php");
/*  File Name   : getfinancial.php
*   Description : show Financial Status
*   Author      : Himanshu Singh
*   Date        : 6th,Dec,2010  Creation
*/

if (isset($_POST['continue'])) {
$accountObj = new accountView();
$accountObj->svrAccountViewDefault();
exit();
}
//echo $_SESSION['userid'];

if ($_SESSION['userid']) {
$accountObj = new accountView();
$data = $accountObj->getFinancialDetails();
$data1 = $data[0];
} else {
$_SESSION['MESSAGE'] = "Please Login";
header("location:login.php");
exit();
}
$menu = "account";
$account = 'class="selected"';
$add = 'checked="checked"';
include("mainReseller.php");
//Session Start

?>
<html>
<head>
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="-1">
<link rel="stylesheet" href="client/css/styleSheet.css" type="text/css">
<link href="lib/grid/css/grid.css" rel="stylesheet" type="text/css" />

<script language="JavaScript" src="client/js/jsFinancialStatus.js" type="text/javascript"></script>

</head>
<body>
<div class="center">
<!--<div class="bg_darkgray1" align="center"    ><h3><br>
Company Details</h3></div>
<table BORDER=0 width="100%"  style="margin-top:0px; ">
<input type="hidden" name="m" value="financialStatus">
<?php ?>
<tr>
		<td width="29%">&nbsp;</td>

<td width="29%">Country or Area for the Timezone:</td>
<td width="42%"><b/><?php echo $data1['tzcountries']; ?></td>
</tr>
<tr>
		<td>&nbsp;</td>

<td>Timezone:</td>
<td><b/><?php echo $data1['timezones']; ?></td>
</tr>
<tr>
		<td>&nbsp;</td>

<td>Select a permanent currency for
<br>your account:</td>
<td><b/><?php echo $data1['currencies']; ?></td>
</tr>
<tr>
		<td>&nbsp;</td>

<td>Company Name:</td>
<td><b/><?php echo $data1['company_name']; ?></td>
</tr>
<tr>
		<td>&nbsp;</td>

<td>Organisation Code:</td>
<td><b/><?php echo $data1['orgnr']; ?></td>
</tr>
<tr>
		<td>&nbsp;</td>

<td>Street Address:</td>
<td><b/><?php echo $data1['street']; ?>&nbsp;<?php echo $data1['city']; ?>&nbsp;<?php echo $data1['country']; ?></td>
</tr>
<tr>
		<td>&nbsp;</td>

<td>Zip Code:</td>
<td><b/><?php echo $data1['zip']; ?></td>
</tr>
<tr>
		<td>&nbsp;</td>

<td><b/>Company Account Status:</td>
<td><b/><?php echo $data1['pre_loaded_value']; ?></td>
</tr>
<tr>
		<td>&nbsp;</td>

<td><b/>Company Budget:</td>
<td><b/><?php echo $data1['budget']; ?></td>
</tr>
</table>-->
<div align="center">
<?php
if(isset($_SESSION['MESSAGE'])) {
echo $_SESSION['MESSAGE'];
$_SESSION['MESSAGE']='';
}
?>
</div>
<div class="bg_darkgray1" align="center"><h3><br>
Load your Company Account</h3></div>
<form name="loadAccountForm" action="payment.php" id="loadAccountForm" method="get">
<table BORDER=0  width="100%"  style="margin-top:0px;">
<input type="hidden" name="action" value="loadAccount">

<input type="hidden" name="userId" value="<?=$_SESSION['userid']?>" >
<tr>

<td width="34%" class="inner_grid">Load your Company Account
		<span class='mandatory'>*</span>:</td>
<td width="53%"><INPUT class="text_field_new" type=text name="loadaccount" id ="loadaccount">
<b/> (SEK)
<a  title="<?=ACCOUNT_VALUE?>" class="vtip" ><b><small>?</small></b></a>
<div id='error_loadaccount' class="error"></div>                    </td>
<td width="13%" align="right"><img src="images/cards_visa.jpg" width="133" height="42"></td>
</tr>
<tr>
<td COLSPAN='4' align="center">
<INPUT style="color:#FFFFFF" type="submit" value="Submit" class="button" name="continue" id="continue">                    </td>
</tr>
</table>
</form>
<div>
    <h1><span class='mandatory'>* These Fields Are Mandatory </span></h1>
</div>
</div>
<? include("footer.php"); ?>
</body>
</html>