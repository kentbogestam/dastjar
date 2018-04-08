<?php

/*  File Name  : viewUser.php
*  Description : View User Details.
*  Author      : Tanvi
*  Date        : 25th,Jan,2011  Creation
*/

header('Content-Type: text/html; charset=utf-8');
include("cumbari.php");
$menu = "account";
$account = 'class="selected"';
$usershow = 'checked="checked"';
include("main.php");
include("Paging.php");

//echo "In"; die();
if ($_SESSION['userid']) {
$accountObj = new accountView();
$records_per_page = PAGING;
$total_records = $accountObj->getNewUserDetailRow();
 $total_records;//die();

$pager = new pager($total_records, $records_per_page, @$_GET['_p']);
$paging_limit = $pager->get_limit();
$data = $accountObj->svrAccountViewDefault($paging_limit);
//print_r($data); die();
} else {
$_SESSION['MESSAGE'] = "Please Login";
header("location:login.php");
}
?>
<link href="lib/grid/css/grid.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="lib/grid/js/grid.js" type="text/javascript"></script>
<body>
<div class="center">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

<tr>
<td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td height="400" valign="top">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td colspan="2"><?php
//echo show_session_msg();

$_SESSION['msgType'] = '';
$_SESSION['msg'] = ''; ?></td>
</tr>
<tr>
<td colspan="2" align="center">

<form action="" name="searchbox" method="get">
<input type="hidden" name="m" value="<?=$_GET['m']?>" />
<table width="100%" border="0">
<tr>
		<td valign="top" style="font-size:22px;"><strong><?

echo "Users";

?></strong></td>
		<td><div id="msg" align="center">
<?php
if ($_SESSION['MESSAGE']) {
echo $_SESSION['MESSAGE'];
$_SESSION['MESSAGE'] = "";
}
?>
</div></td>
		<td valign="top">&nbsp;</td>
</tr>
<tr>
<td width="24%">&nbsp;</td>
<td  width="455">
<!--<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="border2">
<tr>
<td height="25" colspan="3" align="left" class="bg_darkgray1" style="padding-left:5px;">Search</td>
</tr>
<tr>
<td width="25%" height="25" align="left" name="title" class='bg_lightgray'>First Name</td>
<td width="75%" align="left" class='bg_lightgray'><input type="text" name="keyword" id="name" size="48" value="<?=isset($_GET['keyword']) ? $_GET['keyword'] : ''
?>" /></td>
</tr>
<tr>
<td width="25%" height="25" align="left" name="title" class='bg_lightgray'>Last Name</td>
<td width="75%" align="left" class='bg_lightgray'><input type="text" name="key" id="name" size="48" value="<?=isset($_GET['key']) ? $_GET['key'] : ''
?>" /></td>
</tr>
<tr>
  <td height="25" align="left" name="title" class='bg_lightgray'>Email</td>
  <td align="left" class='bg_lightgray'><input type="text" name="ke" id="name2" size="48" value="<?=isset($_GET['ke']) ? $_GET['ke'] : ''
?>" /></td>
</tr>
<tr>
<td width="28%" height="40" align="center" name="title" class='bg_lightgray'>&nbsp;</td>
<td width="72%" align="left" class='bg_lightgray'><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="padding-left:1px; border:none;"><input name='submitFrm' type='submit' class="submit-search-button" id="submitFrm" value="Search" /></td>
    <td width="100%" align="left" style="padding-left:15px;">
<a href="viewNewUser.php"><strong>View All</strong></a></td>
  </tr>
</table></td>
</tr>

<tr>
<td height="25" align="center"  class='bg_lightgray'><strong>Status</strong></td>
<td height="25" align="center"  class='bg_lightgray'><div align="left">
<select name="status" style="width:80px;">
<option value="">Both</option>
<option <? if ($_GET['status'] == '1')
echo 'selected="selected"'; ?> value="1">Active</option>
<option <? if ($_GET['status'] == '0')
echo 'selected="selected"'; ?> value="0">Inactive</option>
</select>
</div></td>
</tr>
<tr></tr>
</table>
</td>-->
<td width="24%" valign="top"><div align="center" class="main_bg"><a href="addNewUser.php"> <strong>ADD NEW USER</strong> </a></div></td>
</tr>
</table>

</form></td>
</tr>
<tr>
<td colspan="2" align="left"><?php if (1) { ?>
<form method="post" name="myform" action="category_action.php" onSubmit="return confirm_msg();">
<table width="100%" border="0" cellpadding="6" cellspacing="0" class="border">
<tr>
<td width="49%" align="left"><?php //echo $pager->get_title('&nbsp;Displaying results {FROM} to {TO} of {TOTAL}');  ?></td>
<td width="51%" align="right" style="color:#881d0a;"><img src="lib/grid/images/edite.gif">Edit&nbsp;&nbsp;&nbsp;<img src="lib/grid/images/view.gif">View&nbsp;&nbsp;&nbsp;<!--<img src="lib/grid/images/active.gif">Active&nbsp;&nbsp;&nbsp;<img src="lib/grid/images/deactive.gif">Inactive &nbsp;&nbsp;&nbsp;--></td>
</tr>
</table>

<br />
<table width="100%" border="0" cellpadding="2" cellspacing="2" class="border"  bgcolor="#CCCCCC">
<tr align="center" height="26">
<!--<td width="1%" class="bg_darkgray1" align="left">&nbsp;</td>
<td width="2%"  class="bg_darkgray1" align="center"><strong>S.No.</strong></td>-->
<td width="5%" align="center" class="bg_darkgray1"><strong>Email</strong></td>
<td width="5%" class="bg_darkgray1"><strong>First Name</strong></td>
<td width="5%"  class="bg_darkgray1" align="center"><strong>Last Name</strong></td>
<td width="5%" align="center" class="bg_darkgray1"><strong>Phone</strong></td>
<!--<td width="5%" class="bg_darkgray1"><strong>Mobile No.</strong></td>-->
<!--<td width="5%" align="center" class="bg_darkgray1"><strong>Role</strong></td>-->

<td width="5%" class="bg_darkgray1"><strong>Action</strong></td>
</tr>

<?php
$i = 1 + $pager->get_limit_offset();
foreach ($data as $data1) {
?>
<tr>
<!--<td class="bg_lightgray" align="left" style="padding-left:5px;"><input name='check[]' id='check_box<?=$i
				 ?>' type='checkbox' style='size:10px;border:0px;'
	value='<?=$line['id']
				 ?>'></td>
<td align="center"><?php echo $i; ?> </td>-->
<td align="center" bgcolor="#FFFFFF"><?php echo $data1['email']; ?></td>
<td align="center" bgcolor="#FFFFFF"><?php echo $data1['fname']; ?></td>
<td align="center" bgcolor="#FFFFFF"><?php echo $data1['lname']; ?></td>
<td align="center" bgcolor="#FFFFFF"><?php echo $data1['phone']; ?></td>
<!--<td align="center"><?php echo $data1['mobile_phone']; ?></td>-->
<!--<td align="center"><?php echo $data1['role']; ?></td>-->


<td align="center" bgcolor="#FFFFFF">
<a href="showNewUser.php?userId=<?=$data1['u_id']; ?>" class="a2" title="View"><img src="lib/grid/images/view.gif"></a>&nbsp;&nbsp;|&nbsp;&nbsp;

<a href="editNewUser.php?userId=<?=$data1['u_id']; ?> " class="a2" title="Edit"><img src="lib/grid/images/edite.gif"></a>

&nbsp;&nbsp;</td>
</tr>
<?
$i++;
}
?>
</table>

<table width='100%'>
<?php if ($total_records==0) {
echo "No Records Found";
}
?>
<!-- with selected html starts-->
<!--<tr>
<td width='350' align="left">&nbsp;&nbsp;&nbsp;<img src="lib/grid/images/arrow.gif">
<a href="#" onClick="checkall(true)" ><font color="#FF0000">Check all</font> </a> /
<a href="#"  onClick="checkall(false)"><font color="#FF0000">Uncheck all </font> </a>&nbsp;</a>
<select id='select_action' name='select_action' onChange="return confirm_msg();">
<option value="">--With selected--</option>
<option value="1">Activate</option>
<option value="0">De-Activate</option>
<option value="delete">Delete</option>
</select>                              </td>
</tr>-->
<!-- with selected htl ends-->
</table>

<table width="100%" border="0" cellpadding="6" cellspacing="0" class="border">
<tr>
<td width="67%" align="left"><?php echo $pager->get_title('&nbsp;Displaying Results {FROM} to {TO} of {TOTAL}'); ?></td>
<td width="33%" align="right"><?php
echo $pager->get_prev('<a href="{LINK_HREF}">Prev</a>&nbsp;');
echo $pager->get_range('<a href="{LINK_HREF}">{LINK_LINK}</a>', ' &raquo ') . '';
echo $pager->get_next('<a href="{LINK_HREF}">&nbsp;Next</a>');
?></td>
</tr>
</table>

<input type="hidden" name="action" value="check_box_action">
</form>
<?php } else {
?>
<table width="100%" border="0" cellpadding="6" cellspacing="0" class="border">
<tr>
<td width="67%" align="center">No Record Found.</td>
</tr>
</table>
<?php } ?>
<br />
<br />                      </td>
</tr>
</table></td>
</tr>
</table></td>
</tr>
</table></td>
</tr>
<tr>
<td align="left" bgcolor="#CCCCCC" height="1"></td>
</tr>
</table></div>

<? include("footer.php"); ?>
</body>
</html>
