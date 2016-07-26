<?php

/*  File Name   : getBrandView.php
*   Description : Brand Details
*   Author      : Himanshu Singh
*   Date        : 6th,Dec,2010  Creation
*/

header('Content-Type: text/html; charset=utf-8');

ob_start();
include_once("cumbari.php");
include("Paging.php");
$menu = "brand";
$brand = 'class="selected"';
$add = 'class="selected"';
include("main.php");
if ($_SESSION['userid']) {
    $brandObj = new brandView();
    $brandObj->svrBrandDflt();
//    $records_per_page = PAGING;
//  $total_records = $offerObj->showCampaignOffersDetailsRows();
//echo $total_records;
//    $pager = new pager($total_records, $records_per_page, @$_GET['_p']);
//    $paging_limit = $pager->get_limit();


// echo count($data);
    $datas = $brandObj->getBrandViewDetails();
    //print_r($datas);
    $x= count($datas);
// echo count($datas);
    $data = $brandObj->registerBrandDetails();
//die;
} else {
    $_SESSION['MESSAGE'] = "Please Login";
    header("location:login.php");
}

?>


<html>
    <head>
<link href="lib/grid/css/grid.css" rel="stylesheet" type="text/css" />
<link href="client/css/stylesheet123.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="lib/grid/js/grid.js" type="text/javascript"></script>

    <body>
    <div class="center">
        <div id="msg" align="Center" style="margin-top:20px;">
        <?php
        if ($_SESSION['MESSAGE']) {
            echo $_SESSION['MESSAGE'];
            $_SESSION['MESSAGE'] = "";
        }
        ?>
        </div>
	   
        <div style=" font-size:22px;"  >
            <b>   <?
                echo "Brands";
                ?></b>
        </div>

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

                                                    <input type="hidden" name="m" value="<?=$_GET['m']
                                                                   ?>" />

                                                    <table width="100%" border="0" cellpadding="0" cellspacing="0">

                                                        <tr>

                                                            <td align="center"> <?php
                                                                if ($_SESSION['MESSAGE']) {
                                                                    echo $_SESSION['MESSAGE'];
                                                                    $_SESSION['MESSAGE'] = "";

                                                                }
                                                                ?></td>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                        <tr></tr>
                                                        <tr>
                                                            <td width="24%">&nbsp;</td>
                                                    <td  align="right" width="455"><table width="100%"  align="center" cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td height="25" colspan="2" align="left" class="bg_darkgray1" style="padding-left:5px;">Search </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td width="8%" height="3" align="center"  name="title"></td>
                                                                        <td align="left" ></td>
                                                                    </tr>
                                                                    <tr>
                                                                      <td height="25" align="left" nowrap class='bg_lightgray' name="title">Brand Name</td>
                                                                      <td align="left" class='bg_lightgray'><input type="text" name="ke" id="name" size="48" value="<?=isset($_GET['ke']) ? $_GET['ke'] : ''
                                                                                                                                         ?>" /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td width="25%" height="40" align="left" nowrap class='bg_lightgray' name="title"></td>
                                                                        <td width="75%" align="left" class='bg_lightgray'><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                          <tr>
                                                                            <td style="padding-left:1px; border:none;"><input name='submitFrm' type='submit' class="submit-search-button" id="submitFrm" value="Search" /></td>
                                                                            <td width="100%" align="left" style="padding-left:15px;">
                                                                                        <?php if ($_REQUEST['m'] == "showcampoffer") {
                                                                                            ?>
                                                                                        <a href="showCampaign.php?m=showcampoffer"><strong>View All</strong></a>
                                                                                            <?php } else {
                                                                                            ?>
                                                                                        <a href="showCampaign.php"><strong>View All</strong></a>
                                                                                            <?php } ?></td>
                                                                          </tr>
                                                                        </table></td>
                                                                    </tr>

                                                                    <tr></tr>
                                                                </table>
                                                          </td>
                                                            <td width="24%" align="left" valign="top"><div align="center" class="main_bg"  ><a href="addBrand.php" onClick="return displayHelpInfo('<?=$x?>');" ><strong>ADD NEW BRAND</strong></a></div>
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
                                                            <td width="51%" align="right" style="color:#881d0a;">
                                                                    <?php if ($_REQUEST['m'] == "showcampoffer") {
                                                                        ?><? } else { ?>
                                                                <img src="lib/grid/images/edite.gif">&nbsp;Edit&nbsp;&nbsp;&nbsp; <? } ?>

                                                                    <?php if ($_REQUEST['m'] == "showcampoffer") {
                                                                        ?><? } else { ?>
                                                                        <? } ?>
                                                                    <?php if ($_REQUEST['m'] == "showcampoffer") {
                                                                        ?><? } else { ?>

                                                                <img src="lib/grid/images/delete.gif">&nbsp;Delete</td> 
                                                          <? } ?>
                                                        </tr>
                                                        <tr>
                                                            <td align="left">&nbsp;</td>

                                                            <td align="right" style="color:#881d0a;">&nbsp;</td>
                                                        </tr>
                                                    </table>

                                                    <table width="100%" cellpadding="0" cellspacing="1" class="border" bgcolor="#CCCCCC">
                                                        <tr align="center" height="26" >
                                                        <!--<td width="4%" class="bg_darkgray1" align="left">&nbsp;</td>
                                                        <td width="4%" height="25" class="bg_darkgray1" align="center"><strong>S.No.</strong></td>-->
                                                            <td width="15%" height="25" class="bg_darkgray1" align="center"><strong>Brand Icon</strong></td>
                                                            <td width="15%" class="bg_darkgray1"><strong>Brand Name</strong></td>


                                                            <td width="29%" align="center" class="bg_darkgray1"><strong>Action</strong></td>
                                                        </tr>
                                                            <?php if (isset($datas)) {
                                                                ?>
                                                                <?php
                                                                //$i = 1 + $pager->get_limit_offset();

                                                                foreach ($datas as $datas1) {
//print_r($data1);
                                                                    ?>

                                                        <tr bgcolor="#FFFFFF" >
                                                               <!--<td align="left" class="bg_lightgray"  >
                                                                      <input name='list[]' id='check_box<?=$i
                                                                                ?>' type='checkbox' style='size:10px;border:0px;' value='<?=$line['id']
                                                                                ?>'></td>
                                     <td align="center" valign="middle"><?php echo $i; ?> </td>-->

                                                            <td align="center"><img src="<?php echo $datas1['icon'] ?>" height="30" width="30"/></td>
                                                            <td align="center"><?php echo $datas1['brand_name']; ?></td>


                                                            <td align="center" class="bg_lightgray" >

                                                                &nbsp;
                                                                &nbsp;
                                                                            <?php if ($_REQUEST['m'] == "showcampoffer") { ?>
                                                                                <? } else { ?>
                                                             

                                                                <a href="editBrand.php?brandId=<?=$datas1['id'];
                                                                                   ?>" class="a2" title="Edit"> <img src="lib/grid/images/edite.gif"></a>

                                                              
                                                               
                                                                &nbsp;
                                                                |&nbsp;
                                                                <a href="javascript:deleteBrand_rec('brandId=<?=$datas1['id']; ?>')" onClick="" class="a2" title="Delete">
                                                                    <img src="lib/grid/images/delete.gif"></a>
                                                                                <? } ?>
                                                            </td>
                                                        </tr>
                                                                    <?
                                                                    $i++;
                                                                }

                                                                ?>
                                                                <?php } else {
                                                                ?>

                                                    </table>
                                                            <?php echo "No Records Found";
                                                        } ?>
                                    </table>
                                    <br>
                                    <table width='100%'  cellpadding="0" cellspacing="0">
                                            <?php
//                                                            if ($total_records == 0) {
//                                                                echo "No Records Found";
//                                                            }
//                                                            ?>
                                    </table>

                                    <table width="100%"  cellpadding="0" cellspacing="0" class="border">
                                        <tr>
                                            <td width="67%" align="left"><?php //echo $pager->get_title('Displaying Results {FROM} to {TO} of {TOTAL}'); ?></td>
                                            <td width="33%" align="right"><?php
                                                    //echo $pager->get_prev('<a href="{LINK_HREF}">Prev</a>&nbsp;');
                                                    //echo $pager->get_range('<a href="{LINK_HREF}">{LINK_LINK}</a>', ' &raquo ') . '';
                                                    //echo $pager->get_next('<a href="{LINK_HREF}">&nbsp;Next</a>');
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



<table width="100%" >
    <tr>
        <td height="60">&nbsp;</td>
    </tr>

    <tr>

        <td ><span class='mandatory'>* These Fields Are Mandatory </span>
           </td>
    </tr>
</table></div>
 <? include("footer.php"); ?>
