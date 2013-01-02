<?php
/*  File Name   : login.php
 *   Description : Login form
 *
 */
header('Content-Type: text/html; charset=ISO-8859-15');
include_once("cumbari.php");
$menu = "delete";
$delete = 'class="selected"';
$dstand = 'checked="checked"';
include("Paging.php");
include("mainSupport.php");
$supportObj = new support();
$inoutObj = new inOut();
$case = $_GET['m'];
$uId = $_GET['uId'];

if($uId == '')
{
    $uId = 'default';
}
if ($uId != '') {

    $records_per_page = PAGING;
    $total_records = $supportObj->getTotalStandard($uId);
     
    $pager = new pager($total_records, $records_per_page, @$_GET['_p']);
    $paging_limit = $pager->get_limit();
    $data = $supportObj->getStandardDetails($paging_limit, $uId);
    //echo"<pre>";  print_r($data);echo"</pre>";//die();
}

if ($case == 'deleteCategory') {
    $productId = $_GET['productId'];
    $supportObj = new support();
    $supportObj->permanentDeleteStandard($productId, $uId);
}


if (!isset($_SESSION['supportuserid'])) {
    $url = BASE_URL . 'support.php';
    $inoutObj->reDirect($url);
    exit;
} else {


    // echo"<pre>";  print_r($data);echo"</pre>";//die();
}

$userName = $supportObj->getAllUser();
?>
<script>

    function getUserList(uId)
    {
        javascript:location.href = "showPermntDeleteStandard.php?uId="+uId;
    }

    function deleteStandard(proId,uId)
    {

        var answer = confirm('Are you sure you want to delete this Campaign')
        if(answer)
        {
            var url = 'showPermntDeleteStandard.php?m=deleteCategory&productId='+proId+'&uId='+uId;
            window.location = url;
        }


    }

</script>
<link href="client/css/stylesheet123.css" rel="stylesheet" type="text/css" />
<link href="lib/grid/css/grid.css" rel="stylesheet" type="text/css" />

<body><div class="center">
        <div style="font-size: 22px; margin-top:20px;">
            <b>Delete Standard</b>
        </div>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">

            <form id="submitFrm" name="submitFrm" action="" method="get" >

                <tr>
                    <td height="20"></td>
                </tr>
                <div align="center"><h2><?php
if ($_SESSION['MESSAGE']) {
    echo $_SESSION['MESSAGE'];
    $_SESSION['MESSAGE'] = "";
}
?></h2></div>



                <tr>
                    <td width="24%">&nbsp;</td>
                    <td  align="right" width="455"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="border2">
                            <input type="hidden" name="uId" value="<?=$_GET['uId']?>"/>
                            <tr>
                                <td  style="padding-left:5px;" height="25" colspan="4" align="left" class="bg_darkgray1">Search</td>
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
                                            <td height="40" align="left" valign="middle" nowrap class='bg_lightgray' name="title">&nbsp;</td>
                                            <td height="25" align="left" nowrap class='bg_lightgray' name="title"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td style="padding-left:1px; border:none;"><input name='submitFrm' type='submit' class="submit-search-button" id="submitFrm" value="Search" /></td>
                                                        <td width="100%" align="left" style="padding-left:15px;"><a href="showPermntDeleteStandard.php?uId=<? echo $uId; ?>"><strong>View All</strong></a></td>
                                                    </tr>
                                                </table></td>
                                        </tr>
                                              
                            <tr></tr>
                        </table>                                                      </td>
                    <td width="24%" align="left" valign="top">                                                       </td>
                </tr>
        </table>
        <!-- </form> -->
        <table width="100%" border="0" cellpadding="6" cellspacing="0" class="border">
            <tr>
                <td width="49%" align="left"><?php //echo $pager->get_title('&nbsp;Displaying results {FROM} to {TO} of {TOTAL}');              ?></td>
                <td width="51%" align="right" style="color:#881d0a;">
                    <img src="lib/grid/images/view.gif">&nbsp;View&nbsp;&nbsp;&nbsp;
                    <img src="lib/grid/images/delete.gif">&nbsp;Delete</td>
            </tr>
        </table>

    </td>
</tr>

<tr>
    <td height="373" valign="top"><br />




        <table border="0" width="95%" cellspacing="5" align="center" >
            <tr>


                <td width="515" class="inner_grid">Choose User Name & Email-Id:<br>            </td>
                <td width="469" align="left" >


                    <select style="width:406px; background-color:#e4e3dd;" onChange="getUserList(this.value);" class="text_field_new" >

                        <option  value="">Select </option>
                        <?
                            foreach ($userName as $userName1) {
                                if ($uId == $userName1['u_id']) {
                                    $selected = 'selected';
                                } else {
                                    $selected = '';
                                }
                        ?>
                                <option <? echo $selected ?> value="<? echo $userName1['u_id']; ?> "> <? echo $userName1['fname'];?> ( <? echo $userName1['email']; ?> )</option>
                        <? } ?>
                        </select>
                    </td>
                </tr>

            </table>




            <table width="100%" cellpadding="0" cellspacing="2" class="border">

                <tr align="center" height="26" >
                    <td width="15%" height="25" class="bg_darkgray1" align="center"><strong>Product Name</strong></td>
                    
                    <td width="15%" align="center" class="bg_darkgray1"><strong>Icon</strong></td>
                    <td width="15%" align="center" class="bg_darkgray1"><strong>Sponsored</strong></td>
                    
                    <td width="15%" align="center" class="bg_darkgray1"><strong>Keyword</strong></td>
                    <td width="15%" align="center" class="bg_darkgray1"><strong>Action</strong></td>
                </tr>
            <?php
                            foreach ($data as $data1) {
            ?>

                                <tr align="center" height="26" >

                                    <td align="center"><?php echo $data1['slogen']; ?></td>
                                   
                                    <td align="center"><img src="<?php echo $data1['small_image']; ?>" height="30" width="30"/></td>
                                    <td align="center"><?=($data1['is_sponsored'] == 0 ? "No" : "Yes"); ?></td>

                                   <? $keyString = wordwrap($data1['keyword'], 20, "<br>", 1); ?>
                                <td align="center"><?php echo $keyString; ?></td>
                                <td align="center"><strong><a href="viewSupportStandard.php?productId=<?=$data1['product_id']; ?>&backuid=<?=$uId; ?>" title="view" ><img src="lib/grid/images/view.gif"></a></strong>&nbsp;&nbsp;|&nbsp;&nbsp;<strong><a href="#" title="Delete" onClick="deleteStandard('<?=$data1['product_id']; ?>','<?=$uId; ?>');"> <img src="lib/grid/images/delete.gif"></a></strong></td>
                            </tr>

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
                                <td width="67%" align="left"><?php echo $pager->get_title('Displaying Results {FROM} to {TO} of {TOTAL}'); ?></td>
                                <td width="33%" align="right">
                    <?php
                            echo $pager->get_prev('<a href="{LINK_HREF}">Prev</a>&nbsp;');
                            echo $pager->get_range('<a href="{LINK_HREF}">{LINK_LINK}</a>', ' &raquo ') . '';
                            echo $pager->get_next('<a href="{LINK_HREF}">&nbsp;Next</a>');
                    ?>
                        </td>
                    </tr>
                </table>

                </form>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>

        <tr>
            <td height="30" align="left">

            </td>
        </tr>
        </table>
        </div>
<?php
                            include_once("footer.php");
?>








