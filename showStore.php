<?php
/*  File Name  : showStore.php
*  Description : Show store Form
*  Author      : Deo
*  Date        : 14th,Dec,2010  Creation
*/
header('Content-Type: text/html; charset=ISO-8859-15');
include("cumbari.php");
$menu = "store";
$$menu = 'class="selected"';
if ($_GET['m'] == "showOutdatedStore")
    $deleted = 'checked="checked"';
else
    $show = 'checked="checked"';

include("main.php");
include("Paging.php");

//echo "In"; die();
if ($_SESSION['userid']) {
    $storeObj = new store();
    $records_per_page = PAGING;

    $total_records = $storeObj->showstoreDetailsRows();
   // $total_records;

    $pager = new pager($total_records, $records_per_page, @$_GET['_p']);
    $paging_limit = $pager->get_limit();
    $data = $storeObj->svrStoreDflt($paging_limit);
//print_r($data); die();
} else {
    $_SESSION['MESSAGE'] = "Please Login";
    header("location:login.php");
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


    <div style=" font-size:22px;"  >
        <b>   <?
            if ($_GET['m'] == "showOutdatedStore") {
                echo "Deleted Locations";
            } else {
                echo "Locations";
            }
            ?></b>
    </div>
    <div id="container">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                            <td colspan="2"><?php
//echo show_session_msg();

                                $_SESSION['msgType'] = '';
                                $_SESSION['msg'] = ''; ?></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center">

                                <form action="" name="searchbox" method="get">

                                    <input type="hidden" name="m" value="<?=$_GET['m']
                                                   ?>" />

                                </form></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="left"><?php if (1) { ?>
                                <form method="post" name="myform" action="">
                                    <table width="100%" border="0">
                                        <tr>
                                            <td colspan="3">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td width="24%">&nbsp;</td>
                                            <td width="455" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="border2">
                                                    <tr>
                                                        <td height="25" colspan="3" align="left" class="bg_darkgray1" style="padding-left:5px;">Search</td>
                                                    </tr>
                                                    <tr>
                                                        <td width="25%" height="25" align="left" nowrap class='bg_lightgray' name="title">Location Name</td>
                                                        <td width="72%" align="left" class='bg_lightgray'><input type="text" name="keyword" id="name" size="48" value="<?=isset($_GET['keyword']) ? $_GET['keyword'] : ''
                                                                                                                             ?>" /></td>
                                                    </tr>
                                                    <tr>
                                                      <td height="25" align="left" nowrap class='bg_lightgray' name="title">Email</td>
                                                      <td width="75%" align="left" class='bg_lightgray'><input type="text" name="key" id="name2" size="48" value="<?=isset($_GET['key']) ? $_GET['key'] : ''
                                                                                                                             ?>" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="28%" height="40" align="left" valign="middle" class='bg_lightgray' name="title">&nbsp;</td>
                                                        <td width="72%" align="left" class='bg_lightgray'><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                          <tr>
                                                            <td style="padding-left:1px; border:none;"><input name='submitFrm' type='submit' class="submit-search-button" id="submitFrm" value="Search" /></td>
                                                            <td width="100%" align="left" style="padding-left:15px;">
                                                                            <?php if ($_REQUEST['m'] == "showOutdatedStore") {
                                                                                ?>
                                                                        <a href="showStore.php?m=showOutdatedStore"><strong>View All</strong></a>
                                                                                <?php } else {
                                                                                ?>
                                                                        <a href="showStore.php"><strong>View All</strong></a>
                                                                                <?php } ?></td>
                                                          </tr>
                                                        </table></td>
                                                    </tr>
                                                    <!--<tr>
                                                    <td height="25" align="center"  class='bg_lightgray'><strong>Status</strong></td>
                                                    <td height="25" align="center"  class='bg_lightgray'><div align="left">
                                                    <select name="status"  style="width:80px;">
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
                                          <td width="24%" valign="top"><div align="center" class="main_bg"  ><a href="newCreateStore.php" ><strong>ADD LOCATION</strong></a></div></td>
                                      </tr>
                                    </table>

      <table width="100%" border="0" cellpadding="6" cellspacing="0" class="border">
                                        <tr>
                                            <td width="49%" align="left"><?php //echo $pager->get_title('&nbsp;Displaying results {FROM} to {TO} of {TOTAL}');        ?></td>
                                            <td width="51%" align="right" style="color:#881d0a;">
                                                    <?php if ($_REQUEST['m'] == "showOutdatedStore") {
                                                        ?> <? } else { ?>
                                                <img src="lib/grid/images/edite.gif">&nbsp;Edit&nbsp;&nbsp;&nbsp;<img src="lib/grid/images/delete.gif">&nbsp;Delete&nbsp;&nbsp;&nbsp;
                                                        <? } ?>
                                               <img src="lib/grid/images/view.gif">&nbsp;View&nbsp;&nbsp;&nbsp;<!--<img src="lib/grid/images/active.gif">Active&nbsp;&nbsp;&nbsp;<img src="lib/grid/images/deactive.gif">Inactive &nbsp;&nbsp;&nbsp;--></td>
                    </tr>
                                    </table>

                                    <br />
                                    <table width="100%" border="0" cellpadding="0" cellspacing="2" class="border" bgcolor="#CCCCCC"  >
                                      <tr align="center" height="26" style="font-weight:bold;">
                                        <!--<td width="4%" class="bg_darkgray1" align="left">&nbsp;</td>
                                        <td width="4%"  class="bg_darkgray1" align="center">S.No.</td>-->
                                            <td width="9%" align="center" nowrap class="bg_darkgray1">Location Name</td>
                                          <td width="8%" align="center" class="bg_darkgray1">Email</td>
                                            <td width="10%" align="center" class="bg_darkgray1">Phone No.</td>
                                            <td width="8%" class="bg_darkgray1"> Street</td>
                                            <td width="8%"  class="bg_darkgray1" align="center">City</td>
                                            <td width="8%" align="center" class="bg_darkgray1">Country</td>
                                            <!--<td width="5%" class="bg_darkgray1"> Type</td>-->
                                            <!--<td width="5%" align="center" class="bg_darkgray1">Link</td>-->
                                            <!--<td width="12%" class="bg_darkgray1"> Map</td>-->
                                            <td width="10%" class="bg_darkgray1">Action</td>
                                      </tr>

                                            <?php
                                            $i = 1 + $pager->get_limit_offset();
                                            foreach ($data as $data1) {
                                                ?>
                                        <tr bgcolor="#FFFFFF">
                                        <!--<td class="bg_lightgray" align="center" style="padding-left:5px;"><input name='check[]' id='check_box<?=$i
                                                            ?>' type='checkbox' style='size:10px;border:0px;'
                                        value='<?=$line['id']
                                                            ?>'></td>
                                        <td align="center"><?php echo $i; ?> </td>-->
                                            <td align="center"><?php echo $data1['store_name']; ?></td>
                                            <td align="center"><?php echo $data1['email']; ?></td>
                                            <td align="center"><?php echo $data1['phone']; ?></td>
                                            <td align="center"><?php echo $data1['street']; ?></td>
                                            <td align="center"><?php echo $data1['city']; ?></td>
                                            <td align="center"><?php echo $data1['country']; ?></td>
                                            <!--<td align="center"><?php echo $data1['coupon_delivery_type']; ?></td>-->
                                            <!--<td align="center"><?php echo $data1['link']; ?></td>-->
                                            <!--<td align="center"><a href="map.php?lat=<?=$data1['latitude'] ?>&lang=<?=$data['longitude'] ?>&zoom=16" rel="lyteframe" rev="width: 650px; height: 600px; scrolling: no;" >View Store on Map</a></td>-->
                                            <td align="center">
                                                <a href="viewStore.php?storeId=<?=$data1['store_id']; ?>" class="a2" title="View"><img src="lib/grid/images/view.gif"></a>&nbsp;&nbsp;


                                                        <?php if ($_REQUEST['m'] == "showOutdatedStore") {
                                                            ?>
<!--<a href="javascript:delete_re('storeId=<?=$data1['store_id']; ?>')" onClick="" class="a2" title="Delete">
<img src="lib/grid/images/delete.gif">
</a>-->
                                                            <?php } else {
                                                            ?> |
                                                <a href="javascript:delete_record('storeId=<?=$data1['store_id']; ?>')" onClick="" class="a3" title="Delete">
                                                    <img src="lib/grid/images/delete.gif">
                                                </a>
                                                            <?php } ?>

                                                        <?php if ($_REQUEST['m'] == "showOutdatedStore") {
                                                            ?>

                                                            <?php } else {
                                                            ?> &nbsp;|&nbsp;
                                                <a href="editStore.php?storeId=<?=$data1['store_id']; ?>" class="a2" title="Edit"><img src="lib/grid/images/edite.gif"></a>
                                                            <?php } ?>
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

    </div>
    </div>
    <div><? include("footer.php"); ?></div>
</body>
</html>