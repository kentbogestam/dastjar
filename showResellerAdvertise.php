<?php
ob_start();
header('Content-Type: text/html; charset=utf-8');
include_once("cumbari.php");

$menu = "offer";
$offer = 'class="selected"';
if ($_GET['m'] == "showadvtoffer")
    $outdated = 'checked="checked"';
else
    $show = 'checked="checked"';
include("mainReseller.php");
include("Paging.php");
#$pager = new pager(10,10 , @$_GET['_p']); 

ob_start();
if ($_SESSION['userid']) {
    $offerObj = new offer();
    $records_per_page = PAGING;
    $total_records = $offerObj->showAdvertiseOffersDetailsResellerRows();
//echo $total_records;
    $pager = new pager($total_records, $records_per_page, @$_GET['_p']);
    $paging_limit = $pager->get_limit();
    $data = $offerObj->svrOfferDflt($paging_limit);
//echo "<pre>"; print_r($data);echo "</pre>";
} else {
    $_SESSION['MESSAGE'] = "Please Login";
    header("location:login.php");
    exit();
}
?>
<link href="lib/grid/css/grid.css" rel="stylesheet" type="text/css" />
<link href="client/css/stylesheet123.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="lib/grid/js/grid.js" type="text/javascript"></script>
<div class="center">

    <div id="container">
        <table width="900"  cellspacing="0" cellpadding="0">
            <tr>
                <td valign="top" ><table height="589"   cellpadding="0" cellspacing="0">

                        <tr>

                            <td height="400" valign="top">
                                <table width="900"  align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td colspan="2" align="center">
                                            <form action="" name="searchbox" method="get">

                                                <input type="hidden" name="m" value="<?= $_GET['m']
?>" />

                                                <table width="100%" border="0" cellpadding="0" cellspacing="0">

                                                    <tr>
                                                        <td align="left"><h2><?
                                                       if ($_GET['m'] == "showadvtoffer") {
                                                           echo "OutDated Advertise";
                                                       } else {
                                                           echo "Advertise Offer";
                                                       }
?></h2></td>
                                                        <td align="center"> <?php
                                                                if ($_SESSION['MESSAGE']) {
                                                                    echo $_SESSION['MESSAGE'];
                                                                    $_SESSION['MESSAGE'] = "";
                                                                    if ($_SESSION['askforstore']) {
                                                                        $_SESSION['askforstore'] = 0;
        ?>
                                                                    <script> /* askForStore('<?= $_GET['advtId']
        ?>') */ </script>
                                                                    <?php
                                                                }
                                                            }
                                                            ?></td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr></tr>
                                                    <tr>
                                                        <td width="24%">&nbsp;</td>
                                                        <td  align="right" width="455"><table width="100%"  align="center" cellpadding="0" cellspacing="0">
                                                                <tr>
                                                                    <td height="25" colspan="2" align="left" class="bg_darkgray1" style="padding-left:5px;">Search</td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="25%" height="25" align="left" nowrap class='bg_lightgray' name="title">Title Slogan</td>
                                                                    <td width="75%" align="left" class='bg_lightgray'><input type="text" name="ke" id="name" size="48" value="<?= isset($_GET['ke']) ? $_GET['ke'] : ''
                                                            ?>" /></td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="25" align="left" nowrap class='bg_lightgray' name="title">Sub Slogan</td>
                                                                    <td width="75%" align="left" class='bg_lightgray'><input type="text" name="key" id="name" size="48" value="<?= isset($_GET['key']) ? $_GET['key'] : ''
                                                            ?>" /></td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="25" align="left" nowrap class='bg_lightgray' name="title">Keywords</td>
                                                                    <td width="75%" align="left" class='bg_lightgray'><input type="text" name="keyword" id="name2" size="48" value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : ''
                                                            ?>" /></td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="40" align="left" valign="middle" class='bg_lightgray' name="title">&nbsp;</td>
                                                                    <td width="75%" align="left" class='bg_lightgray'><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                            <tr>
                                                                                <td style="padding-left:1px; border:none;"><input name='submitFrm' type='submit' class="submit-search-button" id="submitFrm" value="Search" /></td>
                                                                                <td width="100%" align="left" style="padding-left:15px;">
                                                                                    <?php if ($_REQUEST['m'] == "showadvtoffer") {
                                                                                        ?>
                                                                                        <a href="showResellerAdvertise.php?m=showadvtoffer"><strong>View All</strong></a>
                                                                                    <?php } else {
                                                                                        ?>
                                                                                        <a href="showResellerAdvertise.php"><strong>View All</strong></a>
                                                                                    <?php } ?></td>
                                                                            </tr>
                                                                        </table></td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td width="24%" align="left" valign="top"><div align="center" class="main_bg"  ><a href="createResellerAdvertise.php" >ADD CAMPAIGN OFFER</a></div>
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
                                                            <td width="49%" align="left"><?php //echo $pager->get_title('&nbsp;Displaying results {FROM} to {TO} of {TOTAL}');             ?></td>
                                                            <td width="51%" align="right" style="color:#881d0a;">
                                                                <?php if ($_REQUEST['m'] == "showadvtoffer") {
                                                                    ?><? } else {
                                                                    ?>
                                                                    <img src="lib/grid/images/edite.gif">&nbsp;Edit&nbsp;&nbsp;&nbsp; <? } ?>
                                                                <img src="lib/grid/images/view.gif">&nbsp;View&nbsp;&nbsp;&nbsp;
                                                                <?php if ($_REQUEST['m'] == "showadvtoffer") { ?><? } else {
                                                                    ?>
                                                                    <img src="lib/grid/images/deactive.gif">&nbsp;Mail To Retailers &nbsp;&nbsp;<? } ?>
                                                                <?php if ($_REQUEST['m'] == "showadvtoffer") { ?><? } else {
                                                                    ?>

                                                                    <img src="lib/grid/images/delete.gif">&nbsp;Delete&nbsp;&nbsp;</td>
                                                            <? } ?>

                                                        </tr>
                                                        <tr>
                                                            <td align="left">&nbsp;</td>

                                                            <td align="right" style="color:#881d0a;">&nbsp;</td>
                                                        </tr>
                                                    </table>

                                                    <table width="100%" cellpadding="2" cellspacing="2" class="border" bgcolor="#CCCCCC">
                                                        <tr align="center" height="26" >

                                                            <td width="15%" height="25" class="bg_darkgray1" align="center">Title Slogan</td>
                                                            <td width="13%" nowrap class="bg_darkgray1">Advertise Name</td>
                                                            <td width="6%" class="bg_darkgray1">Icon</td>                                                                        
                                                            <td width="12%" align="center" class="bg_darkgray1">Sponsored</td>
                                                            <td width="13%" class="bg_darkgray1">Start Date</td>
                                                            <td width="10%" class="bg_darkgray1"> End Date</td>
                                                            <td width="10%" class="bg_darkgray1"> Company Name</td>                                                                                                                               
                                                            <td width="8%" class="bg_darkgray1"> Status</td>                                                                                                                            
                                                            <td width="29%" align="center" class="bg_darkgray1">Action</td>
                                                        </tr>

                                                        <?php
                                                        $i = 1 + $pager->get_limit_offset();
                                                        foreach ($data as $data1) {
//print_r($data1);
                                                            ?>

                                                            <tr bgcolor="#FFFFFF" >                                                                                                                                            
                                                                <td align="center"><?php echo $data1['slogan']; ?></td>
                                                                <td align="center"><?php echo $data1['advertise_name'] ?></td>
                                                                <td align="center"><img src="<?php echo $data1['small_image'] ?>" height="30" width="30"/></td>                                                               
                                                                <td align="center"><?= ($data1['spons'] == 0 ? "No" : "Yes"); ?></td>
                                                                <?
                                                                $d = $data1['start_of_publishing'];
                                                                //$date = date_create($d);
                                                                $timeStamp = explode(" ", $d);
                                                                $start_date = $timeStamp[0];
                                                                //$start_date = date_format($date, 'Y-m-d');
                                                                ?>
                                                                <td align="center"><?php echo $start_date; ?></td>
                                                                <?
                                                                $d = $data1['end_of_publishing'];
                                                                //$date = date_create($d);
                                                                $timeStamp = explode(" ", $d);
                                                                $end_date = $timeStamp[0];
                                                                //$end_date = date_format($date, 'Y-m-d');
                                                                ?>
                                                                <td align="center"><?php echo $end_date; ?></td>
                                                                <?
                                                                if ($data1['company_name'] == '')
                                                                    $data1['company_name'] = 'None';
                                                                ?>
                                                                <td align="center"><?php echo $data1['company_name'] ?></td>                                                     
                                                                <td align="center"><?php
                                                                if ($data1['reseller_status'] == 'A') {
                                                                    echo "Accept";
                                                                } elseif ($data1['reseller_status'] == 'P') {
                                                                    echo "Pending";
                                                                } elseif ($data1['reseller_status'] == 'R') {
                                                                    echo "Reject";
                                                                }
                                                                ?></td>

                                                                <td align="center" class="bg_lightgray" >
                                                                    <table border="0" align="center" cellpadding="0" cellspacing="0">
                                                                        <tr>
                                                                            <td><div class="action-btn1"><a href="viewAdvertise.php?advertiseId=<?= $data1['advertise_id'];
                                                                ?>&from=reseller" class="a2" title="View">	<img src="lib/grid/images/view.gif"></a></div>
        <? if ($data1['reseller_status'] != 'A') { ?>
                                                                                    <div class="action-btn1"><a href="editAdvertise.php?advertiseId=<?= $data1['advertise_id']; ?>&from=reseller" class="a2" title="Edit"> 
                                                                                            <img src="lib/grid/images/edite.gif"></a></div><div class="action-btn1"><a href="<?= BASE_URL . 'inviteRetailersAdvt.php?advertiseId=' . $data1['advertise_id'] ?>&from=reseller" class="a2" title="Mail To Retailers"> 
                                                                                                    <img src="lib/grid/images/deactive.gif"></a></div><div class="action-btn1"><a href="javascript:delete_advertise_reseller('advertiseId=<?= $data1['advertise_id']; ?>','reseller=reseller')" onClick="" class="a2" title="Delete">
                                                                                            <img src="lib/grid/images/delete.gif"></a></div><div class="action-btn2"><a href="<?= BASE_URL . 'addAdvertiseLanguage.php?advertiseId=' . $data1['advertise_id'] ?>&from=reseller" class="a2" title="Add Language"> <img src="lib/grid/images/lang.png"></a></div></td>
        <? } ?>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            <?
                                                            $i++;
                                                        }
                                                        ?>
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
<?php } else { ?>
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





    <?
    $records_page = PAGING;
    $total_records1 = $offerObj->showAllPublicAdvertiseOffers();
    $pager1 = new pager1($total_records1, $records_page, @$_GET['_pp']);
    $paging_l = $pager1->get_limit();
    $is_Public = $offerObj->showAllPublicAdvertiseOffersDetails($paging_l);
    //echo "<pre>"; print_r ($is_Public); echo "</pre>";
    //die();
    ?>


    <link href="lib/grid/css/grid.css" rel="stylesheet" type="text/css" />
    <link href="client/css/stylesheet123.css" rel="stylesheet" type="text/css" />
    <script language="JavaScript" src="lib/grid/js/grid.js" type="text/javascript"></script>
   

    <div id="msg" align="center">
        <?php
        if ($_SESSION['MESSAGE']) {
            echo $_SESSION['MESSAGE'];
            $_SESSION['MESSAGE'] = "";
        }
        ?>
    </div>
    <div id="page_caption" style="height:20px;"  >

    </div>
    <div id="container1" style="display:none;">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td valign="top"><table  border="0" cellspacing="0" cellpadding="0">

                        <tr>
                            <td height="400" valign="top">
                                <table width="900" border="0" align="center" cellpadding="0" cellspacing="0">

                                    <tr>
                                        <td colspan="2" align="center">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" align="left"><?php if (1) { ?>
                                                <form method="post" name="myform" action="category_action.php" onSubmit="return confirm_msg();">
                                                    <br />
                                                    <table width="100%" border="0" cellpadding="0" cellspacing="1" class="border" bgcolor="#CCCCCC">
                                                        <tr align="center" >                                                       
                                                            <td width="5%"  class="bg_darkgray1" align="center"><strong>Advertise Name</strong></td>                                                          
                                                            <td width="5%" class="bg_darkgray1"><strong>Icon</strong></td>                                                                                                                                                                                        
                                                            <td width="5%" align="center" class="bg_darkgray1"><strong>Sponsored</strong></td>                                                                                                                                                                                        
                                                            <td width="5%" class="bg_darkgray1"><strong>Action</strong></td>
                                                        </tr>

                                                        <?php
                                                        $i = 1 + $pager->get_limit_offset();
                                                        foreach ($is_Public as $is_Public1) {
                                                            ?>
                                                            <tr bgcolor="#FFFFFF">
                                                            
                                                                <td align="center"><?php echo $is_Public1['advertise_name']; ?></td>
                                                               
                                                                <td align="center"><img src="<?php echo $is_Public1['small_image'] ?>" height="30" width="30"/></td>      
                                                                <td align="center"><?php
                                                            $d = $is_Public1['spons'];
                                                            if ($d == 0)
                                                                echo "No";
                                                            else
                                                                echo "Yes";
                                                            ?></td>
                                                                <td class="bg_lightgray" align="center">
                                                                    <a href="viewPublicAdvertise.php?advertiseId=<?= $is_Public1['advertise_id'];
                                                            ?>" class="a2" title="View"><img src="lib/grid/images/view.gif"></a>
                                                                    &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="<?= BASE_URL . 'addStore.php?advertiseId=' . $is_Public1['advertise_id'];
                                                                                                    ?>" class="a2" title="Add Location"><img src="lib/grid/images/active.gif"></a>


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
                                                        if ($total_records1 == 0) {
                                                            echo "No Records Found";
                                                        }
                                                        ?>                                                       
                                                    </table>

                                                    <table width="100%" border="0" cellpadding="6" cellspacing="0" class="border">
                                                        <tr>
                                                            <td width="67%" align="left"><?php echo $pager1->get_title('&nbsp;Displaying Results {FROM} to {TO} of {TOTAL}'); ?></td>
                                                            <td width="33%" align="right"><?php
                                                            echo $pager1->get_prev('<a href="{LINK_HREF}">Prev</a>&nbsp;');
                                                            echo $pager1->get_range('<a href="{LINK_HREF}">{LINK_LINK}</a>', ' &raquo ') . '';
                                                            echo $pager1->get_next('<a href="{LINK_HREF}">&nbsp;Next</a>');
                                                            ?></td>
                                                        </tr>
                                                    </table>

                                                    <input type="hidden" name="action" value="check_box_action">
                                                </form>
<?php } else { ?>
                                                <table width="95%" border="0" cellpadding="6" cellspacing="0" class="border">
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




    <div><? include("footer.php"); ?></div>
</div>
</html>
<script>
    function showPublicProduct()
    {
        document.getElementById("container1").style.display='inline';

    }
</script>
