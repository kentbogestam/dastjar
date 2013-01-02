<?php
/* File Name   : campaignOffer.php
 *  Description : Add Campaign Offer Form
 *  Author      : Himanshu Singh  Date: 12th,Nov,2010  Creation
 */
header('Content-Type: text/html; charset=ISO-8859-15');
include_once("cumbari.php");
$menu = "ccode";
$ccode = 'class="selected"';
include("Paging.php");
include("mainSupport.php");
$supportObj = new support();
$data = $supportObj->getCompanyDetail();
//echo "<pre>";print_r($data);echo "</pre>";
//die();
if (isset($_POST['continue'])) {
    $supportObj->assignCcodeToCompany();
}

?>
<link rel="stylesheet" href="client/css/datePicker.css" type="text/css">
<link href="client/css/stylesheet123.css" rel="stylesheet" type="text/css">

<script language="JavaScript" src="client/js/jquery.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/date.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/jquery.bgiframe.js" type="text/javascript"></script>
<script language="Javascript" src="client/js/assignCcode.js" type="text/javascript"></script>

<style type="text/css">
<!--
.style4 {
	font-size: 10px;
	font-weight: bold;
}
.style6 {
	font-size: 9px
}
-->
</style>


<body>
<div class="center">
  <div>
    <div id="preview_frame"></div>
  </div>
  <div id="registerform" align="center">
    <?
    if (isset($_SESSION['MESSAGE'])) {
        echo $_SESSION['MESSAGE'];
        $_SESSION['MESSAGE'] = '';
    }
    ?>
  </div>
  <br>
  <br>
  <form name="registerform" action="" id="registerform" method="Post" target="_self" enctype="multipart/form-data">
   <input type="hidden" name="ccode" value="<?=$_GET['ccode'];?>"/>
    <input type="hidden" name="value" value="<?=$_GET['value'];?>"/>
    
    <div class="redwhitebutton_small123">Assign CCode to a Company</div>
     
   
    <table width="100%">
      <div align="center">
        <table border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td align="right" valign="top">&nbsp;</td>
            <td align="left" valign="top"></td>
          </tr>
          <div align="right"  ></div>
          <tr>
            <td align="right" valign="top" style="padding-right:10px;">Select Company<span class='mandatory'>*</span>: </td>
            <td align="left" valign="top"><select style="width:406px; background-color:#e4e3dd; border:#abadb3 solid 1px;" class="text_field_new" name="selectCompany" id="selectCompany">
                <option <? if ($company1['company_id'] == ''

            )echo "selected='selected'"; ?> value="">Select Company </option>
                <?php foreach ($data as $data1) {
                            // print_r($stores1);  ?>
                <option  value="<?=$data1['company_id'] ?>"><? echo $data1['company_name']; ?></option>
                <? } ?>
              </select>
                <div id="error_selectCompany" class="error"> </div>
            </td>
          </tr>
        </table>
      </div>
      <div align="center"><br />
        <br />
        <INPUT type="submit" value="Submit" name="continue" id="continue" class="button" >
        <br />
        <br />
      </div>
    </table>
  </form>
</div>
<div style="margin-left:auto; margin-right:auto; width:900px;"><span class='mandatory'>* These Fields Are Mandatory</span></div>
<? include("footer.php"); ?>

</body>

