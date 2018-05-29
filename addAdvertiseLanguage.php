<?php
/* File Name   : addLanguage.php
 *  Description : Add Language Form
 *  Author      : Tanvi vyas  Date:
*/
header('Content-Type: text/html; charset=utf-8');
include_once("cumbari.php");
$offerObj = new offer();
$regObj = new registration();

$reseller = $_GET['from'];
//echo $_GET['advertiseId'];die;
if (isset($_POST['continue'])) {
    //echo $advertiseid = $_POST['advertiseId'];echo "here";die;
    $offerObj->addSaveAdvertiseLang($_POST['advertiseId'],$reseller);
}
$menu = "advertise";
$advertise = 'class="selected"';
if ($_GET['m'] == "showadvtoffer")
    $outdatedadvertise = 'class="selected"';
else
    $showadvertise = 'class="selected"';

if($reseller == '')
{ include_once("main.php"); }
else
{ include_once("mainReseller.php"); }
 $advertiseid = $_GET['advertiseId']; 
 $lang = $offerObj->getAdvertiseLang($advertiseid);
  //print_r($lang)

//die();
$data = $offerObj->viewadvertiseDetailById($advertiseid,$lang);
//echo "<pre>"; print_r($data); print "</pre>";die();


?>

<link rel="stylesheet" href="client/css/datePicker.css" type="text/css">

<script language="JavaScript" src="client/js/jquery.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/date.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/jquery.bgiframe.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/jquery.datePicker.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/ajaxupload.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/jsAdvertiselang.js" type="text/javascript"></script>
<META http-equiv="Content-Type" content="text/html; charset=utf-8">

<style type="text/css">
    /*
    .style4 {
        font-size: 10px;
        font-weight: bold;
    }
    .style6 {font-size: 9px}.center{width:900px; margin-left:auto; margin-right:auto;}
    */
</style>
<body>
<div class="center">
<form name="registerform" action="" id="registerform" method="Post" target="_self" enctype="multipart/form-data">
    <input type="hidden" name="advertiseId" value="<?=$_GET['advertiseId']
                   ?>">
    <input type="hidden" name="preview" value="1">
    <input type="hidden" name="m" value="addSaveLang">
    <div>
        <div id="preview_frame"></div>
    </div>


    <div id="msg" align="center">
        <?
        if (($_SESSION['MESSAGE'])) {
            //echo "here";
            $_SESSION['postPayment'] = $x ;
            echo $_SESSION['MESSAGE'];
            $_SESSION['MESSAGE'] = '';
            echo "<br><a href='";
            echo $url = BASE_URL . 'getFinancial.php';
            echo "'>Load your Account</a>";
        }
        ?>

    </div>
  <div class="blackbutton" style="padding-top: 50px;">ADD LANGUAGE</div>
    <div class="redwhitebutton_small123">Basic Advertise Information</div>


    <table border="0" width="100%" cellspacing="15" align="center" >
<tr>
        		

            <td width="50%" class="inner_grid">Language:<br>            </td>
            <td colspan="2" align="left" >
                <select style="width:406px; background-color:#e4e3dd;" onChange="getLangImage('<?=$data[0]['category']?>',this.value);"  class="text_field_new" name="lang" id="lang">
                    <option <? if ($lang == "GER")echo "selected='selected'"; ?> value="GER">German</option>
                    <option <? if ($lang == "ENG")echo "selected='selected'"; ?> value="ENG">English</option>
                    <option <? if ($lang == "SWE")echo "selected='selected'"; ?> value="SWE">Swedish</option>
                </select>
                <div id='error_langStand' class="error"></div>            </td>
        </tr>
        <tr>
        		

            <td width="50%"  class="inner_grid">Advertise Title. Max. 19 characters<span class='mandatory'>*</span>:</td>
        <td colspan="2" >
            <INPUT class="text_field_new" maxlength="19" type=text name="titleSlogan" id="titleSlogan" onBlur="iconPreview(this.form);limitPreview(this.form);" value="<?=$data[0]['slogan'] ?>">

            <div id='error_titleSlogan' class="error"></div></td>
        </tr>
        <tr>
        		

            <td width="50%" class="inner_grid">Advertise Description. Max. 50 characters<span class='mandatory'>*</span>:</td>
        <td>
            <INPUT class="text_field_new" maxlength="50" type=text name="subSlogan" id="subSlogan" onBlur="iconPreview(this.form);limitPreview(this.form);" value="<?=$data[0]['subslogen']
                           ?>">
            <div id='error_subSlogan' class="error"></div></td>
        <td align="right"><a title="<?=ADESCRIPTION_TEXT?>" class="vtip"><b><small>?</small></b></a> </td>
      </tr>
   
           <tr>
         
            <td width="50%">Category:<td colspan="2">
    <div id="category_lang_div">
                     <div id="linkedCat" name="linkedCat" >
                  <? echo $offerObj->getSingleCategoryList($data[0]['category'],$lang); ?>                     </div>
                   </div>

        </tr>
        
         <tr>
           
            <td width="50%">Icon:</td>
            <td colspan="2">
            <img src="<?=$data[0]['small_image'] ?>" width="50">        </tr>                 
    </table>
    
  <div class="redwhitebutton_small123">Advertise Behaviour</div>
    <table BORDER=0 width="100%" cellspacing="15" id="AdvertiseBehavior" align="center" >


<tr>
            
            <td width="50%">Sponsored:</td>


<td width="50%"> <? $d = $data[0]['spons'] ?>
                <?php if ($d == 0)
                    echo "No";
                else
                    echo "Yes"; ?>        </td>
    </tr>

        <tr>
            
            <td width="50%">Start calender:</td>
<td colspan="2">  <?  $d=$data[0]['start_of_publishing'];
               $timeStamp = explode(" ",$d);
               $start_date = $timeStamp[0];?>
                <?=$start_date ?>        </td>
      </tr>
        <tr>
          
            <td width="50%">End calender:</td>
<td width="52%" colspan="2"> <?  $d=$data[0]['end_of_publishing'];
               $timeStamp = explode(" ",$d);
               $end_date = $timeStamp[0];?>
                <?=$end_date ?></td>
      </tr>

       <tr>
           
            <td width="50%">Advertise Name:</td>
<td width="52%" colspan="2">
                <?=$data[0]['advertise_name'] ?></td>
      </tr>
    </table>
<table BORDER=0   id="advancedSearch" width="100%" cellspacing="15" align="center" >
<tr >
        		

            <td width="50%" class="inner_grid"> Keywords<span class='mandatory'>*</span>:</td>
<td width="50%">
<INPUT class="text_field_new" type=text name="searchKeyword" value="<?=$data[0]['keyword']
                               ?>" id="searchKeyword">
                <div id='error_searchKeyword' class="error" ></div></td>
            <td align="right"><a title="<?=AKEYWORD_TEXT ?>" class="vtip"><b><small>?</small></b></a> </td>
        </tr>       
    </table>
  <div class="redwhitebutton_small123">Extended Advertise Behaviour</div>
    <table width="100%" BORDER=0 align="center" cellspacing="15">
<tr>
           
            <td width="50%">Picture:</td>
<td width="50%">
                <img src="<?=$data[0]['large_image'] ?>" width="180" height="180">        </td>
      </tr>

 <tr>
            

            <td width="50%" valign="bottom">Link:</td>
<td width="50%">
                <? $d =$data[0]['infopage'] ?>
                <?php if ($d == '')
                    echo "Not specified";
                else
                    echo $d; ?>        </td>

      </tr>
    </table>
    
   

  
  <div align="center"><br />
<br />
        <?if($reseller == '') {?>
        <INPUT type="submit" value="Save" name="continue" id="continue" class="button" >
       <INPUT type="button" value="Back" name="continue" id="continue" class="button" onClick="javascript:location.href='showAdvertise.php';" >
           <?} else {?>
       <INPUT type="submit" value="Save" name="continue" id="continue" class="button" >
       <INPUT type="button" value="Back" name="continue" id="continue" class="button" onClick="javascript:location.href='showResellerAdvertise.php';" >
       <?}?>
        <br />
        <br />
    </div>

</form>

<span class='mandatory'>* These Fields Are Mandatory</span>
</div>
<? include("footer.php"); ?>
</body>
<script language="JavaScript" src="client/js/jsImagePreview.js" type="text/javascript"></script>
