<?php
/*  File Name  : showStandard.php
*  Description : Show Standard Form
*  Author      : Himanshu Singh
* Date         : 6th,Dec,2010  Creation
*/header('Content-Type: text/html; charset=utf-8');
include_once("cumbari.php");
$menu = "offer";
$offer = 'class="selected"';
$showdeletestand = 'checked="checked"';

include("main.php");
include("Paging.php");


ob_start();
if ($_SESSION['userid']) {
$standObj = new offer();
$records_per_page = PAGING;
$total_records = $standObj->showDeleteStandardOffersDetailsRows();
//echo $total_records;
$pager = new pager($total_records, $records_per_page, @$_GET['_p']);
$paging_limit = $pager->get_limit();
$data = $standObj->showDeleteStandard($paging_limit);
$standObj->svrOfferDflt();
//echo "<pre>"; print_r($data);echo "</pre>";

//print_r($is_Public);
} else {
$_SESSION['MESSAGE'] = "Please Login";
header("location:login.php");
exit;
}
?>


<link href="lib/grid/css/grid.css" rel="stylesheet" type="text/css" />
<link href="client/css/stylesheet123.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="lib/grid/js/grid.js" type="text/javascript"></script>
<body>
<div class="center">


<div id="msg" align="center" style="margin-top:20px;">
<?php
if ($_SESSION['MESSAGE']) {
echo $_SESSION['MESSAGE'];
$_SESSION['MESSAGE'] = "";
}
?>
</div>

<div id="container">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td valign="top"><table  border="0" cellspacing="0" cellpadding="0">

<tr>
<td height="400" valign="top">
<table width="900" border="0" align="center" cellpadding="0" cellspacing="0">

<tr>
<td colspan="2" align="center">
<form action="" name="searchbox" method="get">

<input type="hidden" name="m" value="<?=$_GET['m']
?>" />
<table width="100%" border="0" cellpadding="0" cellspacing="0">


<tr>
<td align="left"><h2><?

echo "Deleted Standard";
?></h2></td>
<td>&nbsp;</td>
<td valign="bottom">&nbsp;</td>
</tr>
<tr>
<td width="24%">&nbsp;</td>
<td width="455"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="border2">
<tr>
<td height="25" colspan="4" align="left" class="bg_darkgray1" style="padding-left:5px;">Search</td>
</tr>
<tr>
<td width="25%" height="25" align="left" nowrap class='bg_lightgray' name="title">Product Name</td>

<td width="75%" align="left" class='bg_lightgray'><input type="text" name="keyword" id="name" size="48" value="<?=isset($_GET['keyword']) ? $_GET['keyword'] : ''
												 ?>" /></td>
</tr>
<tr>
  <td height="25" align="left" nowrap class='bg_lightgray' name="title">Keywords</td>
  <td align="left" class='bg_lightgray'><input type="text" name="key" id="name2" size="48" value="<?=isset($_GET['key']) ? $_GET['key'] : ''
												 ?>" /></td>
</tr>
<tr>
<td width="28%" height="40" align="left" valign="middle" nowrap class='bg_lightgray' name="title">&nbsp;</td>

<td width="72%" align="left" class='bg_lightgray'><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="padding-left:1px; border:none;"><input name='submitFrm' type='submit' class="submit-search-button" id="submitFrm" value="Search" />
    </td>
    <td width="100%" align="left" style="padding-left:15px;"><a href="showDeleteStandard.php"><strong>View All</strong></a></td>
  </tr>
</table></td>
</tr>
<!--<tr>
<td width="28%" height="25" align="left" name="title" class='bg_lightgray'><strong>Product Name</strong></td>

<td width="72%" align="left" class='bg_lightgray'><input type="text" name="key" id="name" size="48" value="<?=isset($_GET['key']) ? $_GET['key'] : ''
												 ?>" /></td>
</tr>-->
<!--                                                            <tr>
<td width="28%" height="25" align="center" name="title" class='bg_lightgray'><strong>Keywords</strong></td>
<td width="72%" align="left" class='bg_lightgray'><input type="text" name="ke" id="name" size="48" value="<?=isset($_GET['ke']) ? $_GET['ke'] : ''
?>" /></td>
</tr>-->
<!--<tr>
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
</tr>-->
<tr></tr>
</table></td>
<td width="24%" valign="top"><div align="center"  class="main_bg"><a href="createStandardOffer.php">ADD STANDARD OFFER</a></div></td>
</tr>
</table>
</form></td>
</tr>
<tr>
<td colspan="2" align="left"><?php if (1) { ?>
<form method="post" name="myform" action="category_action.php" onSubmit="return confirm_msg();">
<table width="100%" border="0" cellpadding="6" cellspacing="0" class="border">
<tr>
<td width="49%" align="left"><?php //echo $pager->get_title('&nbsp;Displaying results {FROM} to {TO} of {TOTAL}');         ?></td>
<td width="51%" align="right" style="color:#881d0a;"><!-- <img src="lib/grid/images/edite.gif">&nbsp;Edit&nbsp;&nbsp;&nbsp; --><img src="lib/grid/images/view.gif">&nbsp;View&nbsp;&nbsp;&nbsp;</td>
</tr>
</table>


<table width="100%" border="0" cellpadding="0" cellspacing="2" class="border" bgcolor="#CCCCCC">
<tr align="center">
<!-- <td width="8%" class="bg_darkgray1" align="left">&nbsp;</td>
<td width="8%"  class="bg_darkgray1" align="center"><strong>S.No.</strong></td>-->
<td width="9%"  class="bg_darkgray1" align="center"><strong>Product Name</strong></td>
<!--<td width="12%" class="bg_darkgray1"><strong>Product Name</strong></td>-->
<td width="8%"  class="bg_darkgray1" align="center"><strong>Icon</strong></td>
<!--                                                                <td width="5%" class="bg_darkgray1"><strong>keywords</strong></td>-->
<!-- <td width="10%"  class="bg_darkgray1" align="center"><strong>Category</strong></td>-->
<td width="11%" align="center" class="bg_darkgray1"><strong>Sponsored</strong></td>
<td width="11%" align="center" class="bg_darkgray1"><strong>Keywords</strong></td>

<!--<td width="9%" class="bg_darkgray1"><strong>Link</strong></td>-->
<!-- <td width="9%" class="bg_darkgray1"><strong>Link to Add Store</strong></td>
<td width="14%" class="bg_darkgray1"><strong> Retailers</strong></td>-->
<td width="10%" class="bg_darkgray1"><strong>Action</strong></td>
</tr>

<?php
$i = 1 + $pager->get_limit_offset();
foreach ($data as $data1) {
  $content = @file_get_contents($data1['small_image']);
  if (!strpos($http_response_header[0], "200")) { 
      $data1['small_image'] = 'images/placeholder-image.png';
  } 
?>
<tr bgcolor="#FFFFFF">
<!--<td class="bg_lightgray" align="left" style="padding-left:5px;">
<input name='list[]' id='check_box<?=$i
?>' type='checkbox' style='size:10px;border:0px;'
value='<?=$line['id']
?>'></td>
<td align="center"><?php echo $i; ?> </td>-->
<td align="center"><?php echo $data1['product_name']; ?></td>
<!--<td align="center"><?php echo $data1['product_name']; ?></td>-->

<td align="center"><img src="<?php echo $data1['small_image'] ?>" height="30" width="30"/></td>
<!--                                                                <td align="center"><?php echo $data1['keywords']; ?></td>-->
<!--<td align="center"><?php echo $data1['category']; ?></td>-->
<td align="center"><?php
$d = $data1['is_sponsored'];
if ($d == 0)
echo "No";
else
echo "Yes"; ?></td>
   <? $keyString = wordwrap($data1['keyword'], 20, "<br>", 1); ?>
<td align="center" class="key"><?php echo $data1['product_description'] ?></td>
<!--<td align="center"><?php echo $data1['link']; ?></td>-->
<!--<td align="center"><?
echo "<br><a href='";
echo $url = BASE_URL . 'addStandStore.php?productId=' . $data1['product_id'];
echo "'>Add Store</a>";
?></td>
<td align="center" ><?
echo "<br><a href='";
echo $url = BASE_URL . 'inviteRetailersStand.php?productId=' . $data1['product_id'];
echo "'>Mail to Retailers</a>";
?></td>-->
<td  align="center">
<a href="viewDeleteStandard.php?productId=<?=$data1['product_id'];
?>" class="a2" title="View"><img src="lib/grid/images/view.gif"></a>&nbsp;
&nbsp; <!-- |&nbsp;
&nbsp;<a href="editDeleteStandard.php?productId=<?=$data1['product_id'];
?>" class="a2" title="Edit"><img src="lib/grid/images/edite.gif"></a>&nbsp;
&nbsp; -->
<!--|
&nbsp;
&nbsp;<img src="lib/grid/images/delete.gif">&nbsp;
&nbsp;
|&nbsp;
&nbsp;<a href="<?=BASE_URL . 'addStandStore.php?productId=' . $data1['product_id']?>" class="a2" title="Add Store"><img src="lib/grid/images/active.gif"></a>&nbsp;
&nbsp;
|&nbsp;
&nbsp;<a href="<?=BASE_URL . 'inviteRetailersStand.php?productId=' . $data1['product_id']?>" class="a2" title="Mail To Retailers"><img src="lib/grid/images/deactive.gif"></a>&nbsp;
&nbsp;-->
</td>
</tr>
<?
$i++;
}
?>
</table>
<br>
<table width='100%'>
<?php
if ($total_records == 0) {
echo "No Records Found";
}
?>
<!-- with selected html starts-->
<!--<tr>
<td width='350' align="left">&nbsp;&nbsp;&nbsp;&nbsp;<img src="lib/grid/images/arrow.gif">
<a href="#" onClick="checkall(true)" ><font color="#FF0000">Check all</font> </a> /
<a href="#" onClick="checkall(false)"><font color="#FF0000">Uncheck all </font> </a>
<select id='select_action' name='select_action' onChange="return confirm_msg();">
<option value="">--With selected--</option>
<option value="1">Activate</option>
<option value="0">De-Activate</option>
<option value="delete">Delete</option>
</select>                              </td>
</tr>-->
<!-- with selected htl ends-->
</table>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="border">
<tr>
<td width="67%" align="left"><?php echo $pager->get_title('Displaying Results {FROM} to {TO} of {TOTAL}'); ?></td>
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
</table>

</td>
</tr>

</table>
</div>
</div>



<? include("footer.php"); ?>
</body>
</html>
<script>
function showPublicProduct()
{
document.getElementById("container1").style.display='inline';

}
</script>