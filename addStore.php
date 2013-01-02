<?php

header('Content-Type: text/html; charset=ISO-8859-15');
include_once("cumbari.php");
$inoutObj = new inOut();
$storeObj = new store();
include("main.php");
include("Paging.php");
$_GET['campaignId'];
$campaignid = $_GET['campaignId'];
if ($_SESSION['userid']) {
    $storeObj = new store();

    $pag = $_GET['pag'];

if($pag == '')
{
        $records_per_page = 10;
}
else{
    $records_per_page = $pag;
}

    $total_records = $storeObj->getAllPrivateLocationRows();
   // $total_records;

    $pager = new pager($total_records, $records_per_page, @$_GET['_p']);
    $paging_limit = $pager->get_limit();
    $data = $storeObj->getAllPrivateLocation($paging_limit);
   $checkData = $storeObj->getAllSelecterPrivateLocation($campaignid);
   // $data = $storeObj->svrStoreDflt($paging_limit);

//print_r($checkData);
} else {
    $_SESSION['MESSAGE'] = "Please Login";
    header("location:login.php");
}
$menu = "campaign";
$campaign = 'class="selected"';
if($_GET['m']=="showcampoffer")
	$outdated = 'class="selected"';
else
    $show = 'class="selected"';


//echo '<pre>';
///print_r($data);
//echo '</pre>';
if (isset($_POST['continue'])) {
        $storeObj->savePrivateLocation($campaignid);
}

?>
<link href="lib/grid/css/grid.css" rel="stylesheet" type="text/css" />
<link href="client/css/stylesheet123.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="lib/grid/js/grid.js" type="text/javascript"></script>

<script type="text/javascript">
function select(a) {
    var theForm = document.myForm1;
    for (i=0; i<theForm.elements.length; i++) {
        if (theForm.elements[i].name=='privatelocation[]')
            theForm.elements[i].checked = a;
    }
}
</script>


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

                echo "Private Locations";

            ?></b>
    </div>
     <form  name="myForm1" action="" id="myForm1" method="Post" target="_self" enctype="multipart/form-data">
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
                             <!--   <form method="post" name="myform" action="">-->
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
                                                      <td height="25" align="left" nowrap class='bg_lightgray' name="title">City</td>
                                                      <td width="75%" align="left" class='bg_lightgray'><input type="text" name="key5" id="name2" size="48" value="<?=isset($_GET['key5']) ? $_GET['key5'] : ''
                                                                                                                             ?>" /></td>
                                                    </tr>
                                                     <tr>
                                                      <td height="25" align="left" nowrap class='bg_lightgray' name="title">Chain</td>
                                                      <td width="75%" align="left" class='bg_lightgray'><input type="text" name="key3" id="name3" size="48" value="<?=isset($_GET['key3']) ? $_GET['key3'] : ''
                                                                                                                             ?>" /></td>
                                                    </tr>
                                                     <tr>
                                                      <td height="25" align="left" nowrap class='bg_lightgray' name="title">Block</td>
                                                      <td width="75%" align="left" class='bg_lightgray'><input type="text" name="key4" id="name4" size="48" value="<?=isset($_GET['key4']) ? $_GET['key4'] : ''
                                                                                                                             ?>" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="28%" height="40" align="left" valign="middle" class='bg_lightgray' name="title">&nbsp;</td>
                                                        <td width="72%" align="left" class='bg_lightgray'><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                          <tr>
                                                            <td style="padding-left:1px; border:none;"><input name='submitFrm' type='submit' class="submit-search-button" id="submitFrm" value="Search" /></td>
                                                            <td width="100%" align="left" style="padding-left:15px;">

                                                                <a href="addStore.php?campaignId=<?=$campaignid;?>"><strong>View All</strong></a>

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
                                          <td width="24%" valign="top"><div align="right"  ><a href="newCreateStore.php" >ADD NEW LOCATION</a><br>
          <a href="createPublicLocation.php?campaignId=<?=$campaignid;?>" >ADD PUBLIC LOCATION</a>
          </div></td>
                                      </tr>
                                    </table>

      <table width="100%" border="0" cellpadding="6" cellspacing="0" class="border">
                                        <tr>
                                            <td width="49%" align="left"><input type="text" id="paging_val" name="paging" value="<? echo $records_per_page;?>" style="width:40px"/>  <input type="button" name="paging" value="Show" onClick="paging_manual('<? echo $campaignid;?>');"/></td>
                                            <td width="51%" align="right" >
                                                   </td>
                    </tr>
                                    </table>

                                    <br />
                                    <table width="100%" border="0" cellpadding="0" cellspacing="2" class="border" bgcolor="#CCCCCC"  >
                                      <tr align="center" height="26" style="font-weight:bold;">
                                        <!--<td width="4%" class="bg_darkgray1" align="left">&nbsp;</td>
                                        <td width="4%"  class="bg_darkgray1" align="center">S.No.</td>-->
                                          <td width="10%" class="bg_darkgray1">Action</td>
                                            <td width="9%" align="center" nowrap class="bg_darkgray1">Location Name</td>
                                          <td width="8%" align="center" class="bg_darkgray1">Email</td>
                                            <td width="10%" align="center" class="bg_darkgray1">Phone No.</td>
                                            <td width="8%" class="bg_darkgray1"> Street</td>
                                            <td width="8%"  class="bg_darkgray1" align="center">City</td>
                                            <td width="8%" align="center" class="bg_darkgray1">Country</td>
                                            <td width="8%" align="center" class="bg_darkgray1">Chain</td>
                                            <td width="8%" align="center" class="bg_darkgray1">Block</td>
                                            <!--<td width="5%" class="bg_darkgray1"> Type</td>-->
                                            <!--<td width="5%" align="center" class="bg_darkgray1">Link</td>-->
                                            <!--<td width="12%" class="bg_darkgray1"> Map</td>-->

                                      </tr>

                                            <?php
                                            $i = 1 + $pager->get_limit_offset();
                                            foreach ($data as $data1) {
                                                ?>
                                        <tr bgcolor="#FFFFFF">
                                        <!--<td class="bg_lightgray" align="center" style="padding-left:5px;"><input name='check[]' id='check_box<?=$i
                                                            ?>' type='checkbox' style='size:10px;border:0px;'
                                        value='<?=$line['id']
                                                            ?>'></td>-->

                                               <? if (in_array($data1['store_id'],$checkData)) {  ?>

                                            <td align="center"> <img src="lib/grid/images/active.gif"> </td>

                                           <? }else{ ?>

                                           <td align="center"> <input type="checkbox" name="privatelocation[]" id="privatelocation" value="<?=$data1['store_id'];?>"></td>

                                          <?  } ?>

                                            <td align="center"><?php echo $data1['store_name']; ?></td>
                                            <td align="center"><?php echo $data1['email']; ?></td>
                                            <td align="center"><?php echo $data1['phone']; ?></td>
                                            <td align="center"><?php echo $data1['street']; ?></td>
                                            <td align="center"><?php echo $data1['city']; ?></td>
                                            <td align="center"><?php echo $data1['country']; ?></td>
                                            <td align="center"><?php echo $data1['chain']; ?></td>
                                            <td align="center"><?php echo $data1['block']; ?></td>
                                            <!--<td align="center"><?php echo $data1['coupon_delivery_type']; ?></td>-->
                                            <!--<td align="center"><?php echo $data1['link']; ?></td>-->
                                            <!--<td align="center"><a href="map.php?lat=<?=$data1['latitude'] ?>&lang=<?=$data['longitude'] ?>&zoom=16" rel="lyteframe" rev="width: 650px; height: 600px; scrolling: no;" >View Store on Map</a></td>-->

                                        </tr>
                                                <?
                                                $i++;
                                            }
                                            ?>
                                    </table>
                                    <div><a href="javascript:select(1)">Check all</a> |
<a href="javascript:select(0)">Uncheck all</a>
                                       <!-- <input type="checkbox" name="checkall" id="checkall" onClick="checkedAll(frm1);"> Select All--> </div><br/>
                                    <div><input type="submit" name="continue" value="Continue" class="button"/>
                                    <INPUT type="button" value="Back" name="continue1" id="continue1" class="button" onClick="javascript:location.href='showCampaign.php'" >
                                    </div>


                                <br>
                                    <table width='100%'>
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
                                <!-- </form>-->
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


<script>

function paging_manual(camid)
{

 var pag_val = $('#paging_val').val();

  if($('#paging_val').val() == "") {
      javascript:location.href = "addStore.php?campaignId="+camid;
    }
    else{
    var value = $('#paging_val').val().replace(/^\s\s*/, '').replace(/\s\s*$/, '');
    var intRegex = /^\d+$/;
    if(!intRegex.test(value)) {
        alert("Field must be numeric.");
        javascript:location.href = "addStore.php?campaignId="+camid;
    }
    else {
javascript:location.href = "addStore.php?campaignId="+camid+'&pag='+pag_val;
    }
  }
}

</script>