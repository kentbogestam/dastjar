<?php
/*  File Name  : viewAdvertise.php
 *  Description : View advertise Form
 *  Author      : Himanshu Singh  Date: 22nd,dec,2010  Creation
 */
header('Content-Type: text/html; charset=utf-8');
include_once("cumbari.php");
$offerObj = new offer();
$storeObj = new store();
//if (isset($_POST['continue'])) {
//    $offerObj->svrOfferDflt();
//} else {

$advertiseid = $_GET['advertiseId'];

 $uId = $_GET['uId'];
 $ccode = $_GET['ccode'];

 /////////////temp session value
 $_SESSION['temp_advtId'] = $_GET['advertiseId'];
 $_SESSION['temp_ccode'] = $_GET['ccode'];
 $_SESSION['temp_uId'] = $_GET['uId'];
 //////////////////////////////////
 
//echo $advertiseid;
 /////////////alt is for only one reseller
if($_REQUEST['alt'] == 'alt')
{
   // echo "not allowed";die();
    $_SESSION['MESSAGE'] = NOT_ALLOWED;
}
$_SESSION['MAIL_URL'] = "viewResellerAdvertise.php?advertiseId=" . $advertiseid.'&ccode='.$ccode.'&uId='.$uId;
$_SESSION['MESSEAGE_MAIL'] = MESSEAGE_MAIL;
$stores = $storeObj->totalStoreDetails();
//echo "<pre>";print_r($stores); echo "</pre>";

 if($stores == '')
     {

     $_SESSION['createStore'] = 1;
 }

$lang = $offerObj->getAdvertiseLang($advertiseid);

$selectLanguage = $_GET['lang'];
if(!empty($selectLanguage))
    {
        $lang = $selectLanguage;
    }
$data = $offerObj->viewadvertiseDetailById($advertiseid,$lang);
//echo "<pre>";print_r($data); echo "</pre>";
if($data[0] == '')
    {
    $inoutObj = new inOut();
    $_SESSION['MESSAGE'] = NO_RECORDS_LANG;
    $url = $_SERVER['HTTP_REFERER'];
     $inoutObj->reDirect($url);
      exit();
}
if (isset($_POST['accept'])) {
   // echo sdds;die();
    $offerObj->acceptAdvertiseReseller($advertiseid,$uId,$ccode);
}

if(isset($_POST['reject'])) {
   
    $offerObj->rejectAdvertiseReseller($advertiseid,$uId,$ccode);
}
//create session
session_start();
$_SESSION["Retailers"] = "123";
$menu = "advertise";
$advertise = 'class="selected"';
if ($_GET['m'] == "showadvtoffer")
    $outdatedadvertise = 'class="selected"';
else
    $showadvertise = 'class="selected"';
include_once("main.php");


//unset($_SESSION["Retailers"]);
//echo "here"; die();
?>
<?php include 'config/defines.php'; ?>
<script type="text/javascript" src="lib/vtip/js/jquery.js"></script>

<script type="text/javascript" src="lib/vtip/js/vtip.js"></script>
<link rel="stylesheet" type="text/css" href="lib/vtip/css/vtip.css" />


<style type="text/css">
    body { margin: 100px }
    a { }
    img { border: 0 }
</style>

<link rel="stylesheet" href="client/css/datePicker.css" type="text/css">
<link href="lib/grid/css/grid.css" rel="stylesheet" type="text/css" />
<link href="client/css/stylesheet123.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="client/js/jquery.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/date.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/jquery.bgiframe.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/jquery.datePicker.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/ajaxupload.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/jsAddCoupon.js" type="text/javascript"></script>
<script language="JavaScript" src="lib/grid/js/grid.js" type="text/javascript"></script>


<style type="text/css">
    /*
        .style4 {
            font-size: 10px;
            font-weight: bold;
        }
        .style6 {font-size: 9px}
    */
</style>



<body >
<div class="center">
<table border="0" width="100%" cellspacing="5">
   <tr>
        		<td width="4" class="inner_grid">&nbsp;</td>

            <td width="515" class="inner_grid"><br>            </td>
<td width="469" align="left" ><div id='error_langStand' class="error"></div>            </td>
        </tr>
  </table>
<form name="register" action="" id="registerform" method="Post" enctype="multipart/form-data">
    <input type="hidden" name="advertiseId" value="$_GET['advertiseId']">
   
    <h1><b>View Advertise offers</b></h1> &nbsp;&nbsp;&nbsp;
    <div align="center">  <?php
                                                            if ($_SESSION['MESSAGE']) {
                                                                echo $_SESSION['MESSAGE'];
                                                                $_SESSION['MESSAGE'] = ""; } ?> </div>
    <div class="bg_darkgray1" align="center" ><h3><b>
    		Advertise Offer View</b></h3>
    </div>
    <table BORDER=0 width="100%">
        <tr>
          <td>&nbsp;</td>
         <td>View According To Your Language:</td>
          <td><select style="width:250px; background-color:#e4e3dd;" onChange="langChange(this.value,'<?=$_GET['advertiseId']?>','<?=$_REQUEST['uId']?>','<?=$_REQUEST['ccode']?>');" class="text_field_new" name="lang" id="lang" >
            <option <? if ($lang == "GER")echo "selected='selected'"; ?> value="GER">German</option>
            <option <? if ($lang == "ENG")echo "selected='selected'"; ?> value="ENG">English</option>
            <option <? if ($lang == "SWE")echo "selected='selected'"; ?> value="SWE">Swedish</option>
          </select></td>
        </tr>
        <tr>
            <td width="29%">&nbsp;</td>
            <td width="29%" align="left"> <b>Title Slogan for your Advertise:</b>            </td>
            <td width="42%">
<?=$data[0]['slogan'] ?></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td align="left"><b> Sub Slogan for your Advertise:</b>            </td>

            <td><?=$data[0]['subslogen'] ?></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td align="left"><b>Icon: </b></td>
            <td>
            <img src="<?=$data[0]['small_image'] ?>" width="50">        </tr>
    </table>
<table BORDER=0  align="center" width="100%">


        <tr>
            <td width="29%">&nbsp;</td>
            <td width="29%"><b> sponsored:</b></td>


            <td width="42%"> <? $d = $data[0]['spons'] ?>
                <?php
                if ($d == 0)
                    echo "NO";
                else
                    echo "YES";
                ?>        </td>
        </tr>
        <tr>
            <td>
            <td><b>Category: </b>
            <td> <?=$data[0]['categoryName']
                ?></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><b>Start calender:</b></td>
          <td>  <?  $d=$data[0]['start_of_publishing'];
               $date = date_create($d);
               $start_date = date_format($date, 'Y-m-d');?>
                <?=$start_date ?>        </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><b>End calender:</b></td>
             <td> <?  $d=$data[0]['end_of_publishing'];
               $date = date_create($d);
               $end_date = date_format($date, 'Y-m-d');?>
                <?=$end_date ?></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><b>Advertise Name:</b></td>
            <td>
<?=$data[0]['advertise_name']
                ?></td>
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
<? $d=$data[0]['keyword']
                ?>
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
            <td width="29%"> <b>Picture:</b></td>
            <td width="42%">
                <img src="<?=$data[0]['large_image']
                ?>" width="150"></td>
        </tr>


    </table>

    <table BORDER=0  id="infopage" width="100%" >

        <tr>
            <td width="29%">&nbsp;</td>

            <td width="29%" valign="bottom"><b>Link:</b></td>
            <td width="42%">
                <? $d = $data[0]['infopage'] ?>
                <?php
                if ($d == '')
                    echo "Not Specified";
                else
                    echo $d;
                ?>        </td>

        </tr>
    </table>   

    <? if($_REQUEST['alt'] != 'alt') { ?>

                 <div align="center"><br />
<br />

        <INPUT type="submit" value="Accept" name="accept" id="accept" class="button" >
        &nbsp;&nbsp;
         <INPUT type="submit" value="Reject" name="reject" id="reject" class="button" ><br />
<br />

    </div>

<? } ?>

</form>
</div>
<? include("footer.php"); ?>
</body>
<script>
    function langChange(lang,advtId,uId,ccode)
{
  javascript:location.href = "viewResellerAdvertise.php?lang="+lang+"&advertiseId="+advtId+"&uId="+uId+"&ccode="+ccode;
}
</script>
