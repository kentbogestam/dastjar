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
//print_r($data1);
} else {
$_SESSION['MESSAGE'] = "Please Login";
header("location:login.php");
exit();
}
$menu = "account";
$account = 'class="selected"';
$add = 'checked="checked"';
include("main.php");
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
<div class="bg_darkgray123" align="center" style="line-height:16px;">
Financial Details</div>
<table BORDER=0 width="100%"  style="margin-top:10px; ">
<input type="hidden" name="m" value="financialStatus">
<?php ?>
<tr>
		<td width="29%">&nbsp;</td>

<td width="29%" align="left"><strong>Country or Area for the Timezone:</strong></td>
<td width="42%"><b/><?php echo $data1['tzcountries']; ?></td>
</tr>
<tr>
		<td>&nbsp;</td>

<td align="left"><strong>Timezone:</strong></td>
<td><b/><?php echo $data1['timezones']; ?></td>
</tr>
<tr>
		<td>&nbsp;</td>

<td align="left"><strong>Select a permanent currency for
    <br>
your account:</strong></td>
<td><b/><?php echo $data1['currencies']; ?></td>
</tr>
<tr>
		<td>&nbsp;</td>

<td align="left"><strong>Company Name:</strong></td>
<td><b/><?php echo $data1['company_name']; ?></td>
</tr>
<tr>
		<td>&nbsp;</td>

<td align="left"><strong>Organisation Code:</strong></td>
<td><b/><?php echo $data1['orgnr']; ?></td>
</tr>
<tr>
		<td>&nbsp;</td>

<td align="left"><strong>Street Address:</strong></td>
<td><b/><?php echo $data1['street']; ?>&nbsp;<?php echo $data1['city']; ?>&nbsp;<?php echo $data1['country']; ?></td>
</tr>
<tr>
		<td>&nbsp;</td>

<td align="left"><strong>Zip Code:</strong></td>
<td><b/><?php echo $data1['zip']; ?></td>
</tr>
<tr>
		<td>&nbsp;</td>

<td align="left"><strong>Company Account Status:</strong></td>
<td><b/><?php echo $data1['pre_loaded_value']; ?></td>
</tr>
<tr>
		<td>&nbsp;</td>

<td align="left"><strong>Discount Coupon Left:</strong></td>
<td><b/><?php echo $data1['cc_value']; ?></td>
</tr>
</table>
<div align="center">
<?php
if(isset($_SESSION['MESSAGE'])) {
echo $_SESSION['MESSAGE'];
$_SESSION['MESSAGE']='';
}
?>
</div>
<!--<div class="bg_darkgray123">
Load your Company Account</div>
<form name="loadAccountForm" action="payment.php" id="loadAccountForm" method="get">
<table  width="100%" BORDER=0  style="margin-top:10px;">
<input type="hidden" name="action" value="loadAccount">

<input type="hidden" name="userId" value="<?=$_SESSION['userid']?>" >
<tr>

<td class="inner_grid">Load your Company Account
		<span class='mandatory'>*</span>:<b/>
<div id='' class="error" style="width:100px;"></div>  </td>
<td width="20%"><INPUT class="text_field_new" type=text name="loadaccount" id ="loadaccount" style="height:25px;">
<b/>
<div id='error_loadaccount' class="error"></div>                    </td>
<td>(SEK) <a  title="<?=ACCOUNT_VALUE?>" class="vtip" ><b><small>?</small></b></a>
<b/>
<div id='' class="error" style="width:10px;"></div>
</td>
<td align="right"><img src="images/cards_visa.jpg" width="120" height="32">
<b/>
<div id='' class="error" style="width:100px;"></div></td>
</tr>
<tr>
<td COLSPAN='5' align="center">
<INPUT style="color:#FFFFFF" type="submit" value="Submit" class="button" name="continue" id="continue">                    </td>
</tr>
</table>
</form>
<h1><span class='mandatory'>* These Fields Are Mandatory </span></h1>
</div>-->
<? include("footer.php"); ?>
</body>
</html>
