<?php
/*
*   File Name   : showCampaign.php
*   Description : show campaign Form
*   Author      : Tanvi
*   Date        : 27th,Dec,2010  Creation
*/
ob_start();
header('Content-Type: text/html; charset=ISO-8859-15');
include_once("cumbari.php");
//////////////////check temp value
$regObj = new registration();

$tempValue = $regObj->checkTempValue();
if($tempValue)
{
  $tempValueArray = explode('#',$tempValue);
  $campaignId = $tempValueArray[0];
  $ccodeId = $tempValueArray[1];
  $userId = $tempValueArray[2];
  $tempValue = $regObj->SaveResellerId($userId,$ccodeId);
  $inOutObj = new inOut();
  $url = BASE_URL .'viewResellerCampaign.php?campaignId=' . $campaignId.'&ccode='.$ccodeId.'&uId='.$userId;
  $inOutObj->reDirect($url);
   exit();
}
/////////////
//$_SESSION['askforstore'] = 1;
//$_SESSION['MESSAGE'] = "sdsadd";
// To place a call for manu and sub menu
$menu = "offer";
$offer = 'class="selected"';
if ($_GET['m'] == "showcampoffer")
    $outdated = 'checked="checked"';
else
    $show = 'checked="checked"';
include("main.php");
include("Paging.php");
#$pager = new pager(10,10 , @$_GET['_p']); 

ob_start();
//echo "In"; die();
if ($_SESSION['userid']) {
    $offerObj = new offer();
    $records_per_page = PAGING;
    $total_records = $offerObj->showCampaignOffersDetailsRows();
//echo $total_records;
    $pager = new pager($total_records, $records_per_page, @$_GET['_p']);
    $paging_limit = $pager->get_limit();
    $data = $offerObj->showCampaignOffersDetails($paging_limit);
    $offerObj->svrOfferDflt();

//echo "<pre>"; print_r($data);echo "</pre>";die();
} else {
    $_SESSION['MESSAGE'] = "Please Login";
    header("location:login.php");
    exit();
}
?>
<link href="lib/grid/css/grid.css" rel="stylesheet" type="text/css" />
<link href="client/css/stylesheet123.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="lib/grid/js/grid.js" type="text/javascript"></script>
<body class="center">
<div class="center">
    <div id="msg" align="center" class="center">



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
                                                        <td align="left"><h2><?
                                                                if ($_GET['m'] == "showcampoffer") {
                                                                    echo "OutDated Campaign";
                                                                } else {
                                                                    echo "Campaign Offer";
                                                                }
                                                                ?></h2></td>
                                                  <td align="center"> <?php
                                                            if ($_SESSION['MESSAGE']) {
                                                                echo $_SESSION['MESSAGE'];
                                                                $_SESSION['MESSAGE'] = "";
                                                                if($_SESSION['askforstore']) {
                                                                    $_SESSION['askforstore']=0;
                                                                    ?>
                                                            <script> askForStore('<?=$_GET['campId']?>')</script>
        <?php

                                                                }
                                                            }
                                                            ?></td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr></tr>
                                                    <tr>
                                                        <td width="24%">&nbsp;</td>
                                                        <td  align="right" width="455"><table width="100%"  align="center" cellpadding="0" cellspacing="0" class="border2">
                                                                <tr>
                                                                    <td height="25" colspan="2" align="left" class="bg_darkgray1" style="padding-left:5px;"><strong>Search</strong></td>
                                                                </tr>
                                                                
                                                  <tr>
                                                                    <td width="25%" height="25" align="left" class='bg_lightgray2' name="title">Title Slogan</td>
                                                                  <td width="80%" align="left" class='bg_lightgray'><input type="text" name="ke" id="name" size="48" value="<?=isset($_GET['ke']) ? $_GET['ke'] : ''
        ?>" /></td>
                                                          </tr>
                                                                <tr>
                                                                    <td height="25" align="left" class='bg_lightgray2' name="title">Sub Slogan</td>
                                                                  <td width="80%" align="left" class='bg_lightgray'><input type="text" name="key" id="name" size="48" value="<?=isset($_GET['key']) ? $_GET['key'] : ''
        ?>" /></td>
                                                                </tr>
                                                                <tr>
                                                                  <td height="25" align="left" class='bg_lightgray2' name="title">Keywords</td>
                                                                  <td align="left" class='bg_lightgray'><input type="text" name="keyword" id="name2" size="48" value="<?=isset($_GET['keyword']) ? $_GET['keyword'] : ''
        ?>" /></td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="40" align="left" valign="middle" bgcolor="#d6d5ce">&nbsp;</td>
                                                                    <td width="80%" align="left" valign="middle" bgcolor="#d6d5ce"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                      <tr>
                                                                        <td style="padding-left:8px; border:none;"><input name='submitFrm' type='submit' class="submit-search-button" id="submitFrm" value="Search" /></td>
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

                                                            </table>                                                      </td>
                                                        <td width="24%" align="left" valign="top"><div align="center" class="main_bg"  ><a href="createCampaign.php" >ADD CAMPAIGN OFFER</a></div>                                                        </td>
                                                  </tr>
                                                    
                                                </table>
                                          </form>

                                        </td>
                                    </tr>
                                    <tr valign="top">
                                        <td colspan="2" align="left"><?php if (1) { ?>
                                            <form method="post" name="myform" action="category_action.php" onSubmit="return confirm_msg();">
                                                <table width="100%"  cellpadding="0" cellspacing="0" class="border" border="0">
                                                    
                                                    <tr>
                                                        <td width="30%" align="left"><?php //echo $pager->get_title('&nbsp;Displaying results {FROM} to {TO} of {TOTAL}');           ?></td>
                                                        <td width="70%" height="30" align="right" valign="middle" style="color:#881d0a;">
    
                                                            <img src="lib/grid/images/view.gif">&nbsp;View&nbsp;&nbsp;&nbsp;
	<?php if ($_REQUEST['m'] == "showcampoffer") {
                                                                    ?><? } else { ?>
                                                            <img src="lib/grid/images/edite.gif">&nbsp;Edit&nbsp;&nbsp;&nbsp; <? } ?>
    
	
	<?php if ($_REQUEST['m'] == "showcampoffer") {
                                                                    ?><? } else { ?>
                                                            <img src="lib/grid/images/active.gif">&nbsp;Add Location&nbsp;&nbsp;&nbsp;<img src="lib/grid/images/deactive.gif">&nbsp;Mail To Retailers &nbsp;&nbsp;&nbsp;<? } ?>
    <?php if ($_REQUEST['m'] == "showcampoffer") {
                                                                    ?><? } else { ?>

                                                            <img src="lib/grid/images/delete.gif">&nbsp;Delete<? } ?>
	<?php if ($_REQUEST['m'] == "showcampoffer") {
                                                                    ?><? } else { ?>

                                                            &nbsp;&nbsp;&nbsp;<img src="lib/grid/images/lang.png">&nbsp;Add Language&nbsp;&nbsp;</td> 
                                                      <? } ?>
                                                    </tr>
                                                    
                                                </table>

                                <table width="100%" cellpadding="2" cellspacing="2" class="border" bgcolor="#CCCCCC">
<tr align="center" height="26" >
                                                    <!--<td width="4%" class="bg_darkgray1" align="left">&nbsp;</td>
                                                    <td width="4%" height="25" class="bg_darkgray1" align="center"><strong>S.No.</strong></td>-->
                                                        <td width="13%" height="20" class="bg_darkgray1" align="center">Title Slogan</td>
                                                      <td width="18%" height="20" class="bg_darkgray1">Campaign Name</td>
                                                      <td width="6%" height="20" class="bg_darkgray1">Icon</td>

<!--<td width="8%" class="bg_darkgray1"><strong>Keywords</strong></td>
<td width="6%" height="25" class="bg_darkgray1" align="center"><strong>Category</strong></td>-->
                                                        <td width="12%" height="20" align="center" class="bg_darkgray1">Sponsored</td>
                                                        <td width="11%" height="20" class="bg_darkgray1">Start Date</td>
                                                    <td width="11%" height="20" class="bg_darkgray1">End Date</td>
                                                    <td width="11%" height="20" class="bg_darkgray1">Keywords</td>
                                    <!--<td width="9%" class="bg_darkgray1"><strong> Link to Add Store </strong></td>
                                                        <td width="12%" class="bg_darkgray1"><strong> Retailers</strong></td>-->



                                                    <td width="14%" height="20" align="center" class="bg_darkgray1">Action</td>
                                                  </tr>

    <?php
                                                        $i = 1 + $pager->get_limit_offset();
                                                        foreach ($data as $data1) {
//print_r($data1);
                                                            ?>

                                                    <tr bgcolor="#FFFFFF" >
                                                           <!--<td align="left" class="bg_lightgray"  >
                                                                  <input name='list[]' id='check_box<?=$i
                ?>' type='checkbox' style='size:10px;border:0px;' value='<?=$line['id']
                                                                        ?>'></td>
                                 <td align="center" valign="middle"><?php echo $i; ?> </td>-->
                                                        <td align="center"><?php echo $data1['slogan']; ?></td>
                                                        <td align="center"><?php echo $data1['campaign_name'] ?></td>
                                                        <td align="center"><img src="<?php echo $data1['small_image'] ?>" height="30" width="30"/></td>
                                                        <!--<td align="center"><?php echo $data1['keyword']; ?></td>
                                                        <td align="center"><?php echo $data1['category']; ?></td>-->
                                                        <td align="center"><?=($data1['spons'] == 0 ? "No" : "Yes"); ?></td>
        <?  $d=$data1['start_of_publishing'];
                                                                //$date = date_create($d);
                                                                $timeStamp = explode(" ",$d);
                                                                $start_date = $timeStamp[0];
                                                                //$start_date = date_format($date, 'Y-m-d');
                                                                ?>
                                                        <td align="center"><?php echo $start_date; ?></td>
        <?  $d=$data1['end_of_publishing'];
                                                                //$date = date_create($d);
                                                                $timeStamp = explode(" ",$d);
                                                                $end_date = $timeStamp[0];
                                                                //$end_date = date_format($date, 'Y-m-d');?>
                                                        <td align="center"><?php echo $end_date; ?></td>
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
                                                        <td align="center" valign="middle" class="bg_lightgray" >
                                                        
                                                        <table border="0" align="center" cellpadding="0" cellspacing="0">
                                                  <tr>
                                                    <td><div class="action-btn1"><a href="viewCampaign.php?campaignId=<?=$data1['campaign_id'];
        ?>" class="a2" title="View"><img src="lib/grid/images/view.gif" width="11" height="11"></a></div><div class="action-btn1"><a href="editCampaign.php?campaignId=<?=$data1['campaign_id'];
            ?>" class="a2" title="Edit"> <img src="lib/grid/images/edite.gif" width="15" height="15"></a></div><div class="action-btn2"><a href="<?=BASE_URL . 'addStore.php?campaignId=' . $data1['campaign_id']?>" class="a2" title="Add Location"> <img src="lib/grid/images/active.gif" width="14" height="12"></a></div></td>
                                                  </tr>
                                                  <tr>
                                                    <td><div class="action-btn1"><a href="<?=BASE_URL . 'inviteRetailersCamp.php?campaignId=' . $data1['campaign_id']?>" class="a2" title="Mail To Retailers"> <img src="lib/grid/images/deactive.gif" width="14" height="12"></a></div><div class="action-btn1"><a href="javascript:delete_rec('campaignId=<?=$data1['campaign_id']; ?>')" onClick="" class="a2" title="Delete">
                                                                <img src="lib/grid/images/delete.gif" width="11" height="11"></a></div><div class="action-btn2"><a href="<?=BASE_URL . 'addLanguage.php?campaignId=' . $data1['campaign_id']?>" class="a2" title="Add Language"> <img src="lib/grid/images/lang.png" width="16" height="16"></a></div></td>
                                                  </tr>
                                                </table></td>
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
                                                    <!-- with selected html starts-->
                                                    <!--<tr>
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
    $total_records1 = $offerObj->showAllPublicCampaignOffers();
    $pager1 = new pager1($total_records1, $records_page, @$_GET['_pp']);
    $paging_l = $pager1->get_limit();
    $is_Public = $offerObj->showAllPublicCampaignOffersDetails($paging_l);
    //echo "<pre>"; print_r ($is_Public); echo "</pre>";
    //die();
    ?>


<link href="lib/grid/css/grid.css" rel="stylesheet" type="text/css" />
<link href="client/css/stylesheet123.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="lib/grid/js/grid.js" type="text/javascript"></script>

    <h1> <a href="javascript:void()"  onClick="showPublicProduct();">View Others Campaign</a> </h1>

<div id="msg" align="center" class="center">
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
                                                    <!--<td width="1%" class="bg_darkgray1" align="left">&nbsp;</td>
                                                    <td width="2%"  class="bg_darkgray1" align="center"><strong>S.No.</strong></td>-->
                                                        <td width="5%"  class="bg_darkgray1" align="center"><strong>Campaign Name</strong></td>
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
                                                        <td align="center"><?php echo $is_Public1['campaign_name']; ?></td>
                                                        <!--<td align="center"><?php echo $is_Public1['product_name']; ?></td>-->
                                                        <td align="center"><img src="<?php echo $is_Public1['small_image'] ?>" height="30" width="30"/></td>


<!--                                                                <td align="center"><?php echo $is_Public1['keywords']; ?></td>-->
<!--<td align="center"><?php echo $is_Public1['category']; ?></td>-->
                                                        <td align="center"><?php
        $d = $is_Public1['spons'];
                                                                    if ($d == 0)
                                                                        echo "No";
                                                                    else
                                                                        echo "Yes"; ?></td>

<!--<td align="center"><?php echo $is_Public1['link']; ?></td>-->
<!--<td align="center"><?
        echo "<br><a href='";

                                                                echo $url = BASE_URL . 'addStore.php?campaignId=' . $is_Public1['campaign_id'];
                                                                echo "'>Add Store</a>";
                                                                ?></td>-->


                                                        <td class="bg_lightgray" align="center">
                                                            <a href="viewPublicCampaign.php?campaignId=<?=$is_Public1['campaign_id'];
        ?>" class="a2" title="View"><img src="lib/grid/images/view.gif"></a>
                                                            &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="<?=BASE_URL . 'addStore.php?campaignId=' . $is_Public1['campaign_id'];?>" class="a2" title="Add Location"><img src="lib/grid/images/active.gif"></a>


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
