<?php
/*
*   File Name   : showCampaign.php
*   Description : show campaign Form
*   Author      : Tanvi
*   Date        : 27th,Dec,2010  Creation
*/
header('Content-Type: text/html; charset=ISO-8859-15');
include_once("cumbari.php");

// To place a call for manu and sub menu
$menu = "offer";
$offer = 'class="selected"';
$showdelete = 'checked="checked"';
include("main.php");
include("Paging.php");
#$pager = new pager(10,10 , @$_GET['_p']); 

ob_start();
//echo "In"; die();
if ($_SESSION['userid']) {
    $offerObj = new offer();
    $records_per_page = PAGING;
    $total_records = $offerObj->showDeleteCampaignDetailsRows();
    //echo $total_records;
//die();
    $pager = new pager($total_records, $records_per_page, @$_GET['_p']);
    $paging_limit = $pager->get_limit();
    $data = $offerObj->showDeleteCampaign($paging_limit);
//echo "<pre>"; print_r($data);echo "</pre>";
} else {
    $_SESSION['MESSAGE'] = "Please Login";
    header("location:login.php");
    exit();
}

$compcont = $offerObj->companycountry();
if ($compcont == 'Sweden') {
    //echo $compcont;die;
    $lang = 'swe';
    //echo $lang;die;
}
else {
    $lang = 'eng';
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
        <table width="900"  cellspacing="0" cellpadding="0">
            <tr>
                <td valign="top" ><table height="589"   cellpadding="0" cellspacing="0">

                        <tr>

                            <td height="400" valign="top">
                                <table width="900"  align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td colspan="2" align="left">
                                            <form action="" name="searchbox" method="get">

                                                <input type="hidden" name="m" value="showDeleteCampaign" />


                                                <table width="100%" border="0" cellpadding="0" cellspacing="0">

                                                    <tr>
                                                        <td><h2><?

                                                                echo "Deleted Campaign";
                                                                ?></h2></td>
                                                        <td align="left"></td>
                                                        <td>&nbsp;</td>
                                                    </tr>

                                                    <tr>
                                                        <td width="24%">&nbsp;</td>
                              <td  align="right" width="455"><table width="100%"  align="center" cellpadding="0" cellspacing="0" class="border2">
                                                                <tr>
                                                                    <td style="padding-left:5px;" height="25" align="left" class="bg_darkgray1"><strong>Search </strong></td>
                                                                    <td height="25" align="left" class="bg_darkgray1">&nbsp;</td>
                                                                </tr>
                                                                
                                                                <tr>
                                                                    <td width="25%" height="25" align="left" nowrap class='bg_lightgray' name="title">Title Slogan</td>
                                                                  <td width="75%" align="left" class='bg_lightgray'><input type="text" name="ke" id="name" size="48" value="<?=isset($_GET['ke']) ? $_GET['ke'] : ''
        ?>" /></td>
                                </tr>
                                                                <tr>
                                                                    <td height="25" align="left" class='bg_lightgray' name="title">Sub Slogan</td>
                                                                  <td width="70%" align="left" class='bg_lightgray'><input type="text" name="key" id="name" size="48" value="<?=isset($_GET['key']) ? $_GET['key'] : ''
        ?>" /></td>
                                </tr>
                                                                <tr>
                                                                    <td height="25" align="left" class='bg_lightgray' name="title">Keywords</td>
                                                                    <td width="70%" align="left" class='bg_lightgray'><input type="text" name="keyword" id="name" size="48" value="<?=isset($_GET['keyword']) ? $_GET['keyword'] : ''
        ?>" /></td>
                                </tr>
                                                               <!-- <tr>
                                                                    <td height="25" colspan="2" align="center"  class='bg_lightgray'><strong>Status</strong></td>
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
                                                                  <td height="43" align="center"  class='bg_lightgray'>&nbsp;</td>
                                                                  <td height="43"  class='bg_lightgray'><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                    <tr>
                                                                      <td style="padding-left:1px; border:none;"><input name='submitFrm' type='submit' class="submit-search-button" id="submitFrm" value="Search" /></td>
                                                                      <td width="100%" align="left" style="padding-left:15px;"><a href="showDeleteCampaign.php"><strong>View All</strong></a></td>
                                                                    </tr>
                                                                  </table></td>
                                                                  </tr>
                                                                <tr></tr>
                                                            </table>
                                                      </td>
                                                        <td width="24%" align="left" valign="top"><div align="center" class="main_bg"  ><a href="createCampaign.php" >ADD CAMPAIGN OFFER</a></div>
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
                                                        <td width="49%" align="left"><?php //echo $pager->get_title('&nbsp;Displaying results {FROM} to {TO} of {TOTAL}');           ?></td>
                                                        <td width="51%" height="30" align="right" valign="middle" style="color:#881d0a;"><img src="lib/grid/images/edite.gif">&nbsp;Edit&nbsp;&nbsp;&nbsp;<img src="lib/grid/images/view.gif">&nbsp;View&nbsp;&nbsp;&nbsp;<!--<img src="lib/grid/images/active.gif">Add Store&nbsp;&nbsp;&nbsp;<img src="lib/grid/images/deactive.gif">Mail To Retailers &nbsp;&nbsp;&nbsp;<img src="lib/grid/images/delete.gif">Delete--></td>
                                                  </tr>
                                                   
                                                </table>

                                                <table width="100%" cellpadding="0" cellspacing="2" class="border" bgcolor="#CCCCCC">
     <tr align="center" height="26" >
                                                       <!-- <td width="4%" class="bg_darkgray1" align="left">&nbsp;</td>
                                                        <td width="4%" height="25" class="bg_darkgray1" align="center"><strong>S.No.</strong></td>-->
                                                        <td width="9%" height="25" align="center" nowrap class="bg_darkgray1"><strong>Title Slogan</strong></td>
                                                        <td width="9%" nowrap class="bg_darkgray1"><strong>Campaign Name</strong></td>
                                                 <td width="3%" nowrap class="bg_darkgray1"><strong>Icon</strong></td>

                                   <!-- <td width="8%" class="bg_darkgray1"><strong>Keywords</strong></td>
                                                        <td width="6%" height="25" class="bg_darkgray1" align="center"><strong>Category</strong></td>-->
                                                        <td width="8%" align="center" nowrap class="bg_darkgray1"><strong>Sponsored</strong></td>
                                                 <td width="8%" nowrap class="bg_darkgray1"><strong>Start Date</strong></td>
                                                 <td width="7%" nowrap class="bg_darkgray1"><strong> End Date</strong></td>
                                                 <td width="7%" nowrap class="bg_darkgray1"><strong>Keywords</strong></td>
                                   <!--<td width="9%" class="bg_darkgray1"><strong> Link to Add Store </strong></td>
                                                        <td width="12%" class="bg_darkgray1"><strong> Retailers</strong></td>-->



                                                        <td width="13%" align="center" class="bg_darkgray1"><strong>Action</strong></td>
                                                    </tr>
    <?php if (isset($data)) {  ?>

        <?php
                                                            $i = 1 + $pager->get_limit_offset();
                                                            foreach ($data as $data1) {
//print_r($data1);
                                                                ?>

                                                    <tr bgcolor="#FFFFFF">
                                                       <!-- <td align="left" class="bg_lightgray"  >
                                                            <input name='list[]' id='check_box<?=$i
                    ?>' type='checkbox' style='size:10px;border:0px;' value='<?=$line['id']
                                                                            ?>'></td>
                                                        <td align="center" valign="middle"><?php echo $i; ?> </td>-->
                                                        <td align="center"><?php echo $data1['slogan']; ?></td>
                                                        <td align="center"><?php echo $data1['campaign_name'] ?></td>
                                                        <td align="center"><img src="<?php echo $data1['small_image'] ?>" width="30" height="30" border="0"/></td>
                                                    <!-- <td align="center"><?php echo $data1['keywords']; ?></td>
                                                        <td align="center"><?php echo $data1['category']; ?></td>-->
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
                                                        <!--<td align="center"><?
            echo "<br><a href='";
                                                                    echo $url = BASE_URL . 'addStore.php?campaignId=' . $data1['campaign_id'];
                                                                    echo "'>Add Store</a>";
                                                                    ?>
                                                        </td>
                                                        <td align="center" ><?
            echo "<br><a href='";
                                                                    echo $url = BASE_URL . 'inviteRetailersCamp.php?campaignId=' . $data1['campaign_id'];
                                                                    echo "'>Mail to Retailers</a>";
                                                                    ?></td>-->
                                                        <td align="center">
                                                            <a href="viewDeleteCampaign.php?campaignId=<?=$data1['campaign_id'];
            ?>" class="a2" title="View"><img src="lib/grid/images/view.gif"></a>
                                                            &nbsp;
                                                            &nbsp;
                                                            |&nbsp;
                                                            &nbsp;
                                                            <a href="editDeleteCampaign.php?campaignId=<?=$data1['campaign_id'];
            ?>" class="a2" title="Edit"> <img src="lib/grid/images/edite.gif"></a>
                                                            <!--&nbsp;
                                                            |&nbsp;
                                                            <a href="javascript:changeStatus('<?=$line['id'];
            ?>','<?=$js_st;
                                                                        ?>');" class="a2" title="<?=$status_alt ?>"><? /* <img src="lib/grid/images/<?=$img?>">&nbsp;|&nbsp; */ ?></a>
                                                            <img src="lib/grid/images/delete.gif">-->
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
                                                    <!-- with selected html starts-->
                                                   <!-- <tr>
                                                        <td width='100%' align="left">&nbsp;&nbsp;<img src="lib/grid/images/arrow.gif">
                                                            <a href="#"  onClick="checkall(true)"  ><font color="#FF0000">Check all</font> </a> /
                                                            <a href="#"  onClick="checkall(false)"><font color="#FF0000">Uncheck all </font> </a>&nbsp;
                                                            <select id='select_action' name='select_action' onChange="return confirm_msg();">
                                                                <option value="">--With selected--</option>
                                                                <option value="1">Activate</option>
                                                                <option value="0">De-Activate</option>
                                                                <option value="delete">Delete</option>
                                                            </select>                              </td>
                                                    </tr>-->
                                                    <!-- with selected htl ends-->
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
    </div></div>
    <div><? include("footer.php"); ?></div>
</body>
</html>
