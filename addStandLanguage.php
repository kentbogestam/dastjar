<?php
/*  File Name  : standardOffer.php
 *  Description : Standard Offer Form
 *  Author      : Himanshu Singh  Date: 25th,Nov,2010  Creation
*/
header('Content-Type: text/html; charset=ISO-8859-15');
include_once("cumbari.php");
$menu = "standard";
$standard = 'class="selected"';
$show = 'class="selected"';
$reseller = $_REQUEST['from'];
if($reseller == '')
{
include_once("main.php");
}
else {
    include_once("mainReseller.php");
}
$standardObj = new offer();
$productid = $_GET['productId'];
if (isset($_POST['continue'])) {
     $standardObj->addSaveStandLang($productid,$reseller);
   
}

 //die();
$lang = $standardObj->getLangProduct($productid);
//echo $lang;
$data = $standardObj->viewStandardDetailById($productid,$lang);
//echo "<pre>";print_r($data);echo "</pre>";
//echo $data[0]['is_public'];

?>


<?php include 'config/defines.php'; ?>
<link rel="stylesheet" href="client/css/datePicker.css" type="text/css">
<script language="JavaScript" src="client/js/date.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/jquery.bgiframe.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/jquery.datePicker.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/ajaxuploadStand.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/jsStandlang.js" type="text/javascript"></script>
<!--<link rel="stylesheet" type="text/css" href="lib/vtip/css/vtip.css" />-->
<META http-equiv="Content-Type" content="text/html; charset=ISO-8859-15">
<style type="text/css">

    a { }
    img { border: 0 }
</style>
<body>
<div class="center">
<div>
    <div id="preview_frame"></div>
</div>
<form name="register" action="" id="registerform" method="Post" enctype="multipart/form-data">
    <input type="hidden" name="preview" value="1">
    <input type="hidden" name="productId" value="$_GET['productId']">

    <div class="blackbutton123">ADD LANGUAGE</div>


    <div id="msg" align="center">
        <?
        if (($_SESSION['MESSAGE'])) {
            //echo "here";
            echo $_SESSION['MESSAGE'];
            $_SESSION['MESSAGE'] = '';
            echo "<br><a href='";
            echo $url = BASE_URL . 'getFinancial.php';
            echo "'>Load your Account</a>";
        }
        ?>
    </div>


    <div class="redwhitebutton_small123">Edit Data List View  For Standard Offer</div>
    <input type="hidden" name="m" value="saveNewStandard">
    <input type="hidden" name="productId" value="<?=$_GET['productId']
                   ?>">
    <table   width="100%" border="0" align="center" cellspacing="15">
<tr>
            

            <td width="50%" class="inner_grid"><b>Language:</b> </td>
      <td width="50%" colspan="2">
                <select style="width:406px; background-color:#e4e3dd; border: 1px solid #abadb3;" onChange="getLangImage('<?=$data[0]['category']?>',this.value);" class="text_field_new" name="lang" id="lang">
                    <option <? if ($lang == "ENG"
                        )echo "selected='selected'"; ?> value="ENG">English</option>
                    <option <? if ($lang == "SWE"
                        )echo "selected='selected'"; ?> value="SWE">Swedish</option>
                </select>
      <div id='error_langStand' class="error"></div>            </td>
</tr>
        <tr>
            

            <td width="50%"  class="inner_grid"><b>Product Name</b><span class='mandatory'>*</span>:</td>
<td>
            <INPUT class="text_field_new" type=text name="titleSloganStand" id="titleSloganStand" onBlur="iconPreview(this.form); getTitleForProduct(this.form);" value="<?=$data[0]['slogen']
                           ?>">
            <div id='error_titleSloganStand' class="error"></div></td>
        <td align="right"><a title="<?=STITLE_TEXT
                       ?>" class="vtip"><b><small>?</small></b></a> </td>
        </tr>
         <tr>

            
            <td width="50%"><b>Category: </b>
<td colspan="2">  <div id="category_lang_div">
                     <div id="linkedCat" name="linkedCat" >
                  <? echo $standardObj->getSingleCategoryList($data[0]['category'],$lang); ?>                     </div>
                   </div></td>
        </tr>
       <tr align="left">
                
                <td width="50%"><b>Icon: </b></td>
<td colspan="2">
                <img src="<?=$data[0]['small_image']?>">        </tr>
    </table>
  
  <div class="redwhitebutton_small123">Describe how your Standard Offer should Behave</div>
    <table  width="100%" border="0" align="center" cellspacing="15">
<tr align="left">
        
          
          <td width="50%"><b> Sponsored:</b></td>
            <td width="50%"> <?$d=$data[0]['is_sponsored']?>
                <?php if ($d==0) echo "NO";
                else echo "YES";?>        </td>
        </tr>
  </table>
  <div class="redwhitebutton_small123">Advanced Options-Optional</div>
    <table width="100%" align="center" cellspacing="15" id="advancedSearchStand"   style="display:inline_row;">
        <tr>
          <td width="50%" class="inner_grid"><b>Keywords:</b></td>
            <td>
              <INPUT class="text_field_new" type=text name="searchKeywordStand" id="searchKeywordStand"  value="<?=$data[0]['keyword']
                               ?>">
              <div id='error_searchKeywordStand' class="error"></div></td>
          <td align="right"><a title="<?=SKEYWORD_TEXT
                           ?>" class="vtip"><b><small>?</small></b></a> </td>
        </tr>
          <tr align="left" >
            
            <td width="50%"><b> EAN Code:</b>        </td>
            <td width="50%" colspan="2"> <?$d=$data[0]['ean_code']?>
                <?php if ($d=='') echo "Not specified";
                else echo $d; ?>            </td>
        </tr>

        <tr>
  </table>
  <div class="redwhitebutton_small123">Add your Coupon View</div>
  <table  width="100%" border="0" align="center" cellspacing="15">
<tr align="left">
  <td width="50%" class="inner_grid"> <b>Picture:</b>        </td>
        <td width="50%">
                <img src="<?=$data[0]['large_image']?>" width="180" height="180">        </td>
      </tr>
      
        

      <tr align="left" >
            
            <td width="50%"><b> Public product </b>        </td>
        <td width="50%"><?php $d = $data[0]['is_public'];
                if ($d==0) echo "No";
                else
                    echo "Yes"; ?>            </td>
      </tr>
        <div id='error_publicProduct' class="error"></div>
    </table>
  <div class="redwhitebutton_small123">Add your Info Page</div>
    <table  width="100%" align="center" cellspacing="15" id="infopageStand" style="display: inline_row;">
  <tr align="left">
        	
      <td width="50%" class="inner_grid"><b>Link:</b>        </td>
      <td align="left" width="50%">
                <?$d=$data[0]['link']?>
                <?php if ($d=='') echo "Not specified";
                else echo $d; ?>            </td>
      </tr>
    </table>
    
<div align="center"><br />
        <br />

  <?if($reseller == '') {?>
        <INPUT type="submit" align="center" value="Update" name="continue" class="button" id="continue" >
         <INPUT type="button" value="Back" name="continue" id="continue" class="button" onClick="javascript:location.href='showStandard.php'" >
        <?} else {?>
        <INPUT type="submit" align="center" value="Update" name="continue" class="button" id="continue" >
        <INPUT type="button" value="Back" name="continue" id="continue" class="button" onClick="javascript:location.href='showResellerStandard.php'" >
        <?}?>
        <br />
        <br />
    </div>
</form>

<span class='mandatory'>* These Fields Are Mandatory </span>
</div>
<? include("footer.php"); ?>
</body>
<script language="JavaScript">
    //alert("sdfsfs");
    getCatImage('<?=$data[0]['category']?>');
        
</script>
<script language="JavaScript" src="client/js/jsImagePreview.js" type="text/javascript"></script>