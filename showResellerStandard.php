<?php
/*  File Name  : showStandard.php
*  Description : Show Standard Form
*  Author      : Himanshu Singh
* Date         : 6th,Dec,2010  Creation
*/

include_once("cumbari.php");
$menu = "offer";
$offer = 'class="selected"';
$showstandard = 'checked="checked"';

include("mainReseller.php");
include("Paging.php");


ob_start();
if ($_SESSION['userid']) {
    $standObj = new offer();
    $records_per_page = PAGING;
    $total_records = $standObj->showStandardOffersDetailsResellerRows();
//echo $total_records;
    $pager = new pager($total_records, $records_per_page, @$_GET['_p']);
    $paging_limit = $pager->get_limit();
    $data = $standObj->showStandardOffersResellerDetails($paging_limit);
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
            if($_SESSION['askforstoreStand']) {
                ?>
        <script> //askForStoreStand('<?=$_GET['standId']?>')</script>
        <?php
                $_SESSION['askforstoreStand']=0;
            }
        }
        ?>
    </div></div>

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
                                                        <td><h2><?
if ($_GET['m'] == "showStandoffer") {
//echo "Standard Offer";
                                                                }
                                                                echo "Standard Offer";
                                                                ?></h2></td>
                                                        <td>&nbsp;</td>
                                                        <td valign="bottom">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td width="26%">&nbsp;</td>
                                                        <td width="45%"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="border">
                                                                <tr>
                                                                    <td height="25" colspan="4" align="left" class="bg_darkgray1"><div align="left" style="width:50px; margin-left:31px; font-size:16px;"><strong>Search </strong></div></td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="28%" height="25" align="left" name="title" class='bg_lightgray'><strong>Product Name</strong></td>

                                                                    <td width="72%" align="left" class='bg_lightgray'><input type="text" name="keyword" id="name" size="48" value="<?=isset($_GET['keyword']) ? $_GET['keyword'] : ''
        ?>" /></td>
                                                                </tr>
                                                                  <tr>
                                                                    <td width="28%" height="25" align="left" name="title" class='bg_lightgray'><strong>Keywords</strong></td>

                                                                    <td width="72%" align="left" class='bg_lightgray'><input type="text" name="key" id="name" size="48" value="<?=isset($_GET['key']) ? $_GET['key'] : ''
        ?>" /></td>
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
                                                                <td height="25" align="left"  class='bg_lightgray'><strong>Status</strong></td>

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
                                                                <tr>
                                                                    <td height="25" colspan="3" align="center"  class='bg_lightgray'><table width="100%" border="0">
                                                                            <tr>
                                                                                <td width="17%">&nbsp;</td>



                                                                                <td width="24%"><input name='submitFrm' type='submit' class="submit-search-button" id="submitFrm" value="Search" /></td>
                                                                                <td width="59%"><a href="showResellerStandard.php"><strong>View All</strong></a></td>
                                                                            </tr>
                                                                        </table>  </td>
                                                                </tr>
                                                            </table></td>
                                                        <td width="29%" valign="top"><div align="center"  class="main_bg"><a href="createResellerStandardOffer.php"><strong>ADD STANDARD OFFER</strong></a></div></td>
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
                                                        <td width="51%" align="right" style="color:#881d0a;"><img src="lib/grid/images/edite.gif">Edit&nbsp;&nbsp;&nbsp;<img src="lib/grid/images/view.gif">View&nbsp&nbsp;&nbsp;<img src="lib/grid/images/deactive.gif">Mail To Retailers &nbsp;&nbsp;&nbsp;<img src="lib/grid/images/delete.gif">Delete</td>
                                                    </tr>
                                                </table>

                                                <br />
                                                <table width="100%" border="0" cellpadding="0" cellspacing="2" class="border" bgcolor="#CCCCCC">
                                                  <tr align="center">
                                                    <!-- <td width="8%" class="bg_darkgray1" align="left">&nbsp;</td>
                                                    <td width="8%"  class="bg_darkgray1" align="center"><strong>S.No.</strong></td>-->
                                                        <td width="19%"  class="bg_darkgray1" align="center"><strong>Product Name</strong></td>
                                                        <!--<td width="22%" class="bg_darkgray1"><strong>Product Name</strong></td>-->
                                                        <td width="18%"  class="bg_darkgray1" align="center"><strong>Icon</strong></td>
                                                        <!--                                                                <td width="5%" class="bg_darkgray1"><strong>keywords</strong></td>-->
                                                        <!-- <td width="10%"  class="bg_darkgray1" align="center"><strong>Category</strong></td>-->
                                                        <td width="15%" align="center" class="bg_darkgray1"><strong>Sponsored</strong></td>
                                                         <td width="15%" align="center" class="bg_darkgray1"><strong>Keywords</strong></td>
                                                          <td width="10%" align="center" class="bg_darkgray1"><strong>Status</strong></td>

<!--<td width="9%" class="bg_darkgray1"><strong>Link</strong></td>-->
<!-- <td width="9%" class="bg_darkgray1"><strong>Link to Add Store</strong></td>
<td width="14%" class="bg_darkgray1"><strong> Retailers</strong></td>-->
                                                        <td width="26%" class="bg_darkgray1"><strong>Action</strong></td>
                                                    </tr>

    <?php
                                                        $i = 1 + $pager->get_limit_offset();
                                                        foreach ($data as $data1) {
                                                            ?>
                                                    <tr bgcolor="#FFFFFF" style="font-size:18px; font-weight:bold;">
                                                    <!--<td class="bg_lightgray" align="left" style="padding-left:5px;">
                                                    <input name='list[]' id='check_box<?=$i
                ?>' type='checkbox' style='size:10px;border:0px;'
                                                    value='<?=$line['id']
                ?>'></td>
                                                    <td align="center"><?php echo $i; ?> </td>-->
                                                        <td align="center"><?php echo $data1['slogen']; ?></td>
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
                                                         <td align="center"><?php echo $data1['keyword']; ?></td>
                                                           <td align="center"><?php if($data1['reseller_status'] == 'A')
                                                         {  echo "Accept"; }
                                                         elseif($data1['reseller_status'] == 'P')
                                                         {  echo "Pending";  }
                                                          elseif($data1['reseller_status'] == 'R')
                                                          {  echo "Reject";  }
                                                             ?></td>
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
                                                        <td class="bg_lightgray" align="center">

                                                           
                                                            <a href="viewStandard.php?productId=<?=$data1['product_id'];
        ?>&from=reseller" class="a2" title="View"><img src="lib/grid/images/view.gif"></a>

                                                     <? if($data1['reseller_status'] == 'A') { 

                                                            } else { ?>
                                                            &nbsp;
                                                            &nbsp; |&nbsp;
                                                            &nbsp;<a href="editStandard.php?productId=<?=$data1['product_id'];
        ?>&from=reseller" class="a2" title="Edit"><img src="lib/grid/images/edite.gif"></a>&nbsp;
                                                            &nbsp;
                                                            |
                                                            &nbsp;
                                                            &nbsp;<a href="javascript:delete_standard('productId=<?=$data1['product_id']; ?>','reseller=reseller')" onClick="" class="a2" title="Delete"><img src="lib/grid/images/delete.gif"></a>&nbsp;
                                                            &nbsp;
                                                           
                                                            |&nbsp;
                                                            &nbsp;<a href="<?=BASE_URL . 'inviteRetailersStand.php?productId=' . $data1['product_id']?>&from=reseller" class="a2" title="Mail To Retailers"><img src="lib/grid/images/deactive.gif"></a>&nbsp;
                                                            &nbsp;
                                                            
                                                            |&nbsp;
                                                            &nbsp;<a href="<?=BASE_URL . 'addStandLanguage.php?productId=' . $data1['product_id']?>&from=reseller" class="a2" title="ADD LANGUAGE"><img src="lib/grid/images/lang.png"></a>&nbsp;
                                                            &nbsp;
                                                            <? } ?>
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



<?
    $records_page = PAGING;
    $total_records1 = $standObj->showAllPublicStandardOffers();
    $pager1 = new pager1($total_records1, $records_page, @$_GET['_pp']);
    $paging_l = $pager1->get_limit();
    $is_Public = $standObj->showAllPublicStandardOffersDetails($paging_l);
    ?>


<link href="lib/grid/css/grid.css" rel="stylesheet" type="text/css" />
<link href="client/css/stylesheet123.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="lib/grid/js/grid.js" type="text/javascript"></script>
<body>
    <h1> <!--<a href="javascript:void()"  onClick="showPublicProduct();">View Others Products</a>--> </h1>

<div class="center">
    <div id="msg" align="center">
<?php
        if ($_SESSION['MESSAGE']) {
            echo $_SESSION['MESSAGE'];
            $_SESSION['MESSAGE'] = "";
        }
        ?>
    </div>
    <div id="page_caption" style="height:20px;"  >

    </div></div>
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
                                                    <!--<td width="1%" class="bg_darkgray1" align="left">&nbsp;</td>
                                                    <td width="2%"  class="bg_darkgray1" align="center"><strong>S.No.</strong></td>-->
                                                        <td width="5%"  class="bg_darkgray1" align="center"><strong>Product Name</strong></td>
                                                        <!--<td width="5%" class="bg_darkgray1"><strong>Product Name</strong></td>-->
                                                        <td width="5%" class="bg_darkgray1"><strong>Icon</strong></td>


<!--                                                                <td width="5%" class="bg_darkgray1"><strong>keywords</strong></td>-->
<!--<td width="5%"  class="bg_darkgray1" align="center"><strong>Category</strong></td>-->
                                                        <td width="5%" align="center" class="bg_darkgray1"><strong>Sponsored</strong></td>

<!--<td width="5%" class="bg_darkgray1"><strong>Link</strong></td>-->
<!--<td width="5%" class="bg_darkgray1"><strong>Link to Add Store</strong></td>-->
                                                        <td width="5%" class="bg_darkgray1"><strong>Action</strong></td>
                                                    </tr>

    <?php
                                                        $i = 1 + $pager->get_limit_offset();
                                                        foreach ($is_Public as $is_Public1) {
                                                            ?>
                                                    <tr bgcolor="#FFFFFF">
                                                    <!--<td class="bg_lightgray" align="left" style="padding-left:5px;">
                                                    <input name='list[]' id='check_box<?=$i
                ?>' type='checkbox' style='size:10px;border:0px;'
                                                    value='<?=$line['id']
                ?>'></td>
                                                    <td align="center"><?php echo $i; ?> </td>-->
                                                        <td align="center"><?php echo $is_Public1['slogen']; ?></td>
                                                        <!--<td align="center"><?php echo $is_Public1['product_name']; ?></td>-->
                                                        <td align="center"><img src="<?php echo $is_Public1['small_image'] ?>" height="30" width="30"/></td>


<!--                                                                <td align="center"><?php echo $is_Public1['keywords']; ?></td>-->
<!--<td align="center"><?php echo $is_Public1['category']; ?></td>-->
                                                        <td align="center"><?php
        $d = $is_Public1['is_sponsored'];
                                                                    if ($d == 0)
                                                                        echo "No";
                                                                    else
                                                                        echo "Yes"; ?></td>

<!--<td align="center"><?php echo $is_Public1['link']; ?></td>-->
<!--<td align="center"><?
        echo "<br><a href='";

                                                                echo $url = BASE_URL . 'addStandStore.php?productId=' . $is_Public1['product_id'];
                                                                echo "'>Add Store</a>";
                                                                ?></td>-->
                                                        <td class="bg_lightgray" align="center">
                                                            <a href="viewPublicProduct.php?productId=<?=$is_Public1['product_id'];
        ?>" class="a2" title="View"><img src="lib/grid/images/view.gif"></a>
                                                            &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="<?=BASE_URL . 'addStandStore.php?productId=' . $is_Public1['product_id'];?>" class="a2" title="Add Location"><img src="lib/grid/images/active.gif"></a>


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
                                                    <!-- with selected html starts-->
                                                    <!--<tr>
                                                    <td width='350' align="left">&nbsp;&nbsp;&nbsp;&nbsp;<img src="lib/grid/images/arrow.gif">
                                                    <a href="#" onClick="checkall(true)" ><font color="#FF0000">Check all</font> </a> /
                                                    <a href="#" onClick="checkall(false)"><font color="#FF0000">Uncheck all </font> </a>&nbsp
                                                    <select id='select_action' name='select_action' onChange="return confirm_msg();">
                                                    <option value="">--With Selected--</option>
                                                    <option value="1">Activate</option>
                                                    <option value="0">De-Activate</option>
                                                    <option value="delete">Delete</option>
                                                    </select>                              </td>
                                                    </tr>-->
                                                    <!-- with selected htl ends-->
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
    <?php } else {
                                                ?>
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
</body>
</html>
<script>
    function showPublicProduct()
    {
        document.getElementById("container1").style.display='inline';

    }
</script>