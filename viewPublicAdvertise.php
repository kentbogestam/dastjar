<?php
/*  File Name  : viewAdvertise.php
 *  Description : View advertise Form
 *  Author      : Himanshu Singh  Date: 22nd,dec,2010  Creation
*/
header('Content-Type: text/html; charset=utf-8');
include_once("cumbari.php");
$offerObj = new offer();
 $advertiseid = $_GET['advertiseId'];
if (isset($_POST['continue'])) {
    $offerObj->svrOfferDflt();
}
$lang = $offerObj->getAdvertiseLang($advertiseid);

$selectLanguage = $_GET['lang'];
if(!empty($selectLanguage))
    {
        $lang = $selectLanguage;
    }
   
    $data = $offerObj->viewPublicAdvertiseDetailById($advertiseid,$lang);

//echo "<pre>";print_r($data);echo "</pre>";
    if($data[0] == '')
    {
    $inoutObj = new inOut();
    $_SESSION['MESSAGE'] = NO_RECORDS_LANG;
    $url = $_SERVER['HTTP_REFERER'];
     $inoutObj->reDirect($url);
      exit();
}
$menu = "advertise";
$advertise = 'class="selected"';
if ($_GET['m'] == "showadvtoffer")
    $outdatedadvertise = 'class="selected"';
else
    $showadvertise = 'class="selected"';
include_once("main.php");
?>
<?php include 'config/defines.php'; ?>
<script type="text/javascript" src="lib/vtip/js/jquery.js"></script>
<script language="JavaScript" src="client/js/jsAdvertiseOffer.js" type="text/javascript"></script>
<script type="text/javascript" src="lib/vtip/js/vtip.js"></script>
<link rel="stylesheet" type="text/css" href="lib/vtip/css/vtip.css" />


<style type="text/css">
    body { margin: 100px }
    a { }
    img { border: 0 }
</style>

<link rel="stylesheet" href="client/css/datePicker.css" type="text/css">
<link href="lib/grid/css/grid.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="client/js/jquery.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/date.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/jquery.bgiframe.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/jquery.datePicker.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/ajaxupload.js" type="text/javascript"></script>
<META http-equiv="Content-Type" content="text/html; charset=utf-8">
<!--<script language="JavaScript" src="client/js/jsAdvertiseOffer.js" type="text/javascript"></script>-->
<style type="text/css">
    <!--
    .style4 {
        font-size: 10px;
        font-weight: bold;
    }
    .style6 {font-size: 9px}
    -->
</style>
<div class="center">
<table border="0" width="100%" cellspacing="5">
   <tr>
        		<td width="4" class="inner_grid">&nbsp;</td>

            <td width="515" class="inner_grid"><br>            </td>
<td width="469" align="left" ><div id='error_langStand' class="error"></div>            </td>
        </tr>
  </table>
<form name="register" action="" id="registerform" method="Post" enctype="multipart/form-data">
    <h1><b>View Advertise Offers</b></h1>
    <div id="msg" align="center">  <?php
                                                            if ($_SESSION['MESSAGE']) {
                                                                echo $_SESSION['MESSAGE'];
                                                                $_SESSION['MESSAGE'] = ""; } ?> </div>
    <div class="bg_darkgray1" align="center" ><h3><b>
Your Advertise View</b></h3>
     
    </div>
    <table BORDER=0 width="100%">
        <tr>     
          <td>&nbsp;</td>
          <td>View According To Your Language:</td>
          <td><select style="width:250px; background-color:#e4e3dd;" onchange="langChange(this.value,'<?=$_GET['advertiseId']?>');" class="text_field_new" name="lang" id="lang" >
                    <option <? if ($lang == "GER")echo "selected='selected'"; ?> value="GER">German</option>
                    <option <? if ($lang == "ENG")echo "selected='selected'"; ?> value="ENG">English</option>
                    <option <? if ($lang == "SWE")echo "selected='selected'"; ?> value="SWE">Swedish</option>
                </select></td>
        </tr>
        <tr>
            <td width="29%">&nbsp;</td>
            <td width="29%"> <b>Title Slogan for your Advertise:</b>            </td>
            <td width="42%">
                <?=$data[0]['slogan'] ?></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><b> Sub Slogan for your Advertise:</b>            </td>

            <td><?=$data[0]['subslogen'] ?></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><b>Icon: </b></td>
            <td>
            <img src="<?=$data[0]['small_image'] ?>" width="50">        </tr>
    </table>
<table BORDER=0  align="center" width="100%">
       <tr>
            <td width="29%">&nbsp;</td>
            <td width="29%"><b> Sponsored:</b></td>


            <td width="42%"> <? $d = $data[0]['spons'] ?>
                <?php if ($d == 0)
                    echo "No";
                else
                    echo "Yes"; ?>        </td>
        </tr>
        <tr>
            <td>
            <td><b>Category: </b>
            <td> <?=$data[0]['categoryName'] ?></td>

        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><b>Start calender:</b></td>
            <td>  <?  $d=$data[0]['start_of_publishing'];
               $timeStamp = explode(" ",$d);
               $start_date = $timeStamp[0];?>
                <?=$start_date ?>        </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><b>End calender:</b></td>
            <td> <?  $d=$data[0]['end_of_publishing'];
               $timeStamp = explode(" ",$d);
               $end_date = $timeStamp[0];?>
                <?=$end_date ?></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><b>Advertise Name:</b></td>
            <td>
                <?=$data[0]['advertise_name'] ?></td>
        </tr>
    </table>
    <div align="center" class="bg_darkgray1"><h3><b>
    		Advanced Options</b></h3>
    </div>
    <table BORDER=0   id="advancedSearch" width="100%">
        <tr >
            <td width="29%">&nbsp;</td>
            <td width="29%"><b> Keywords:</b>        </td>
            <td width="42%">
                <? $d=$data[0]['keywords'] ?>
             <?php if ($d == '')
                    echo "Not Specified";
                else
                    echo $d; ?>

            </td>
        </tr>

    </table>    
    <div align="center" class="bg_darkgray1"><h3><b>
    		Your Coupon View</b></h3>
    </div>
    <table BORDER=0 width="100%" >
        <tr>
            <td width="29%">&nbsp;</td>
            <td width="29%"> <b>Picture:</b>        </td>
            <td width="42%">
                <img src="<?=$data[0]['large_image'] ?>" width="180" height="180">        </td>
        </tr>


    </table>

    <table BORDER=0  id="infopage" width="100%" >

        <tr>
            <td width="29%">&nbsp;</td>

            <td width="29%" valign="bottom"><b>Link:</b>        </td>
            <td width="42%">
                <? $d =$data[0]['infopage'] ?>
                <?php if ($d == '')
                    echo "Not specified";
                else
                    echo $d; ?>        </td>

        </tr>
    </table>
    <div align="center" class="bg_darkgray1"><h3><b>
    		Location Information</b></h3>
    </div>
    <table BORDER=0  id="store" width="100%" >
        <tr class="newcolor_heading" >

            <td width="21%" align="center"><b>Location Name</b></td>
            <td width="12%" align="center"><b>Street</b></td>
            <td width="11%" align="center"><b>City</b></td>
            <td width="20%" align="center"><b>Country</b></td>
            <td width="26%" align="center"><b>Coupon Delivery type</b></td>

            <?$current_date = date('Y-m-d');
             //echo $current_date;
            if($data[0]['end_of_publishing'] >$current_date ){ ?>

	    <td width="10%" align="center"><b>Action</b></td>
            <?}?>
        </tr>
        <tr>
            <?php if (isset($data['storeDetails'])) { ?>
                <?php $i = 1;
                foreach ($data['storeDetails'] as $data1['storeDetails']) { 
                      $storeid = $data1['storeDetails']['store_id'];              
                    
                    ?>


            <td align="center"><?php echo $data1['storeDetails']['store_name']; ?> </td>
            <td align="center"><?php echo $data1['storeDetails']['street']; ?> </td>
            <td align="center"><?php echo $data1['storeDetails']['city']; ?> </td>
            <td align="center"><?php echo $data1['storeDetails']['country']; ?> </td>
            <td align="center"><?php echo $coupon_dil; ?></td>
            <? if($data[0]['end_of_publishing'] >$current_date ){ ?>
             <td height="32" align="center"><a href="javascript:delete_advtStore('storeId=<?=$data1['storeDetails']['store_id']?>&advertiseId=<?=$data[0]['advertise_id']?>' )" onClick="" class="a2" title="Delete">
                                                                <img src="lib/grid/images/delete.gif"></a> </td>
                                                                <?}?>
        </tr>

                <?
                $i++;
            }
            ?>
            <?php } else { ?>
    </table>


        <?php echo "No Records Found";
    } ?>


 <table width="100%" border="0" >
 		<tr>
 				<td>&nbsp;</td>
 				</tr>
 		<tr><td><div align="center" >
        <INPUT type="button" value="Back" name="continue" id="continue" class="button" onClick="javascript:location.href='<?=$_SERVER[HTTP_REFERER] ?>';" >
    <br />
          <br />
          </div></td></tr></table>
</form>
</div>
<? include("footer.php"); ?>
<script>
    function langChange(lang,advtId)
{
    javascript:location.href = "viewPublicAdvertise.php?lang="+lang+"&advertiseId="+advtId;
}
</script>

