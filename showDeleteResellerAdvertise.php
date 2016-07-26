<?php
/*
*   File Name   : showAdvertise.php
*   Description : show advertise Form
*   Author      : Tanvi
*   Date        : 27th,Dec,2010  Creation
*/
header('Content-Type: text/html; charset=utf-8');
include_once("cumbari.php");

// To place a call for manu and sub menu
$menu = "offer";
$offer = 'class="selected"';
$showdeleteadvertise = 'checked="checked"';
include("mainReseller.php");
include("Paging.php");
#$pager = new pager(10,10 , @$_GET['_p']); 

ob_start();
//echo "In"; die();
if ($_SESSION['userid']) {
    $offerObj = new offer();
    $records_per_page = PAGING;
    $total_records = $offerObj->showDeleteAdvertiseDetailsResellerRows();
    //echo $total_records;
//die();
    $pager = new pager($total_records, $records_per_page, @$_GET['_p']);
    $paging_limit = $pager->get_limit();
    $data = $offerObj->showDeleteResellerAdvertise($paging_limit);
//echo "<pre>"; print_r($data);echo "</pre>";
} else {
    $_SESSION['MESSAGE'] = "Please Login";
    header("location:login.php");
    exit();
}

$compcont = $offerObj->companycountry();
if ($compcont == 'Sweden') {
    $lang = 'swe';
}
else {
    $lang = 'eng';
}
?>
<link href="lib/grid/css/grid.css" rel="stylesheet" type="text/css" />
<link href="client/css/stylesheet123.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="lib/grid/js/grid.js" type="text/javascript"></script>
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
        <table width="900"  cellspacing="0" cellpadding="0">
            <tr>
                <td valign="top" ><table height="589"   cellpadding="0" cellspacing="0">

                        <tr>

                            <td height="400" valign="top">
                                <table width="900"  align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td colspan="2" align="left">
                                            <form action="" name="searchbox" method="get">

                                                <input type="hidden" name="m" value="showDeleteAdvertise" />


                                                <table width="100%" border="0" cellpadding="0" cellspacing="0">

                                                    <tr>
                                                        <td align="left"><h2><?

                                                                echo "Deleted Advertise";
                                                                ?></h2></td>
                                                      <td align="left"></td>
                                                        <td>&nbsp;</td>
                                                    </tr>

                                                    <tr>
                                                        <td width="24%">&nbsp;</td>
                                                <td  align="right" width="455"><table width="100%"  align="center" cellpadding="0" cellspacing="0" class="border2">
                                                                <tr>
                                                                    <td height="25" colspan="2" align="left" class="bg_darkgray1" style="padding-left:5px;">Search</td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="25%" height="25" align="left" nowrap class='bg_lightgray' name="title">Title Slogan</td>
                                                                    <td width="75%" align="left" class='bg_lightgray'><input type="text" name="ke" id="name" size="48" value="<?=isset($_GET['ke']) ? $_GET['ke'] : ''
        ?>" /></td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="25%" height="25" align="left" nowrap class='bg_lightgray' name="title">Sub Slogan</td>
                                                                    <td width="75%" align="left" class='bg_lightgray'><input type="text" name="key" id="name" size="48" value="<?=isset($_GET['key']) ? $_GET['key'] : ''
        ?>" /></td>
                                                                </tr>
                                                                <tr>
                                                                  <td height="25" align="left" nowrap class='bg_lightgray' name="title">Keywords</td>
                                                                  <td align="left" class='bg_lightgray'><input type="text" name="keyword" id="name2" size="48" value="<?=isset($_GET['keyword']) ? $_GET['keyword'] : ''
        ?>" /></td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="25%" height="40" align="left" nowrap class='bg_lightgray' name="title">&nbsp;</td>
                                                                    <td width="75%" align="left" class='bg_lightgray'><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                      <tr>
                                                                        <td style="padding-left:1px; border:none;"><input name='submitFrm' type='submit' class="submit-search-button" id="submitFrm" value="Search" /></td>
                                                                        <td width="100%" align="left" style="padding-left:15px;">

                                                                                    <a href="showDeleteResellerAdvertise.php"><strong>View All</strong></a>                                                                            </td>
                                                                      </tr>
                                                                    </table></td>
                                                                </tr>
                                                              
                                                            </table>
                                                      </td>
                                                        <td width="24%" align="left" valign="top"><div align="center" class="main_bg"  ><a href="createResellerAdvertise.php" ><strong>ADD ADVERTISE OFFER</strong></a></div>
                                                        </td>
                                                  </tr>
                                                </table>
                                            </form>

                                        </td>
                                    </tr>
                                    <tr valign="top">
                                        <td colspan="2" align="left"><?php if (1) { ?>
                                            <form method="post" name="myform" action="category_action.php" onSubmit="return confirm_msg();">
                                                <table width="100%"  cellpadding="0" cellspacing="0" class="border">
                                                    <tr>
                                                        <td align="left">&nbsp;</td>
                                                        <td align="right" style="color:#881d0a;">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td width="49%" align="left"><?php //echo $pager->get_title('&nbsp;Displaying results {FROM} to {TO} of {TOTAL}');           ?></td>
                                                        <td width="51%" align="right" style="color:#881d0a;"><img src="lib/grid/images/edite.gif">&nbsp;Edit&nbsp;&nbsp;&nbsp;<img src="lib/grid/images/view.gif">&nbsp;View&nbsp;&nbsp;&nbsp;<!--<img src="lib/grid/images/active.gif">Add Store&nbsp;&nbsp;&nbsp;<img src="lib/grid/images/deactive.gif">Mail To Retailers &nbsp;&nbsp;&nbsp;<img src="lib/grid/images/delete.gif">Delete--></td>
                                                  </tr>
                                                    <tr>
                                                        <td align="left">&nbsp;</td>

                                                        <td align="right" style="color:#881d0a;">&nbsp;</td>
                                                    </tr>
                                                </table>

                                                <table width="100%" cellpadding="0" cellspacing="2" class="border" bgcolor="#CCCCCC">
                                               <tr align="center" height="26" >
                                                      
                                                        <td width="9%" height="25" class="bg_darkgray1" align="center"><strong>Title Slogan</strong></td>
                                                        <td width="9%" nowrap class="bg_darkgray1"><strong>Advertise Name</strong></td>
                                                      <td width="3%" class="bg_darkgray1"><strong>Icon</strong></td>

                                                     
                                                        <td width="8%" align="center" class="bg_darkgray1"><strong>Sponsored</strong></td>
                                                        <td width="8%" class="bg_darkgray1"><strong>Start Date</strong></td>
                                                        <td width="7%" class="bg_darkgray1"><strong> End Date</strong></td>
                                                         <td width="7%" class="bg_darkgray1"><strong>Keywords</strong></td>
                                                        
                                                        <td width="13%" align="center" class="bg_darkgray1"><strong>Action</strong></td>
                                                    </tr>
    <?php if (isset($data)) {  ?>

        <?php
                                                            $i = 1 + $pager->get_limit_offset();
                                                            foreach ($data as $data1) {
//print_r($data1);
                                                                ?>

                                                    <tr bgcolor="#FFFFFF">
                                                      
                                                        <td align="center"><?php echo $data1['slogan']; ?></td>
                                                        <td align="center"><?php echo $data1['advertise_name'] ?></td>
                                                        <td align="center"><img src="<?php echo $data1['small_image'] ?>" height="30" width="30"/></td>
                                                      
                                                        <td align="center"><?=($data1['spons'] == 0 ? "No" : "Yes"); ?></td>
            <?  $d=$data1['start_of_publishing'];
                                                                  $timeStamp = explode(" ",$d);
               $start_date = $timeStamp[0];?>
                                                        <td align="center"><?php echo $start_date; ?></td>
            <?  $d=$data1['end_of_publishing'];
                                                                    $timeStamp = explode(" ",$d);
               $end_date = $timeStamp[0];?>
                                                        <td align="center"><?php echo $end_date ?></td>
                                                           <? $keyString = wordwrap($data1['keyword'], 20, "<br>", 1); ?>
                                                         <td align="center"><?php echo $keyString; ?></td>
                                                       
                                                        <td align="center" class="bg_lightgray" >
                                                            <a href="viewDeleteAdvertise.php?advertiseId=<?=$data1['advertise_id'];
            ?>&from=reseller" class="a2" title="View"><img src="lib/grid/images/view.gif"></a>
                                                            &nbsp;
                                                            &nbsp;
                                                            |&nbsp;
                                                            &nbsp;
                                                            <a href="editDeleteAdvertise.php?advertiseId=<?=$data1['advertise_id'];
            ?>&from=reseller" class="a2" title="Edit"> <img src="lib/grid/images/edite.gif"></a>
                                                           
                                                        </td>

                                                    </tr>
            <?
                                                                $i++;
                                                            }
                                                            ?>
                                                            <?php } ?>
                                                </table>
                                            <br>
                                                <table width='100%'  cellpadding="0" cellspacing="0">
    <?php
                                                        if ($total_records == 0) {
                                                            echo "No Records Found";
                                                        }
                                                        ?>                                                   
                                                 
                                                </table>

                                                <table width="100%"  cellpadding="0" cellspacing="0" class="border">
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
                                            <table width="100%"  cellpadding="0" cellspacing="0" class="border">
                                                <tr>
                                                    <td width="67%" align="center">No Record Found.</td>
                                                </tr>
                                            </table>
    <?php } ?>
                                            <br />
                                            <br /> </td>
                                    </tr>
                                </table></td>
                        </tr>
                    </table>
                </td>
            </tr>

        </table>
    </div>
    <div><? include("footer.php"); ?></div>
</div>
</html>
