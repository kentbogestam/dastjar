<?php
/* File Name   : campaignOffer.php
 *  Description : Add Campaign Offer Form
 *  Author      : Himanshu Singh  Date: 12th,Nov,2010  Creation
 */
header('Content-Type: text/html; charset=utf-8');
include_once("cumbari.php");
$menu = "ccode";
$ccode = 'class="selected"';
include("Paging.php");
include("mainSupport.php");
$supportObj = new support();
$ccode = $_GET['ccode'];
$data = $supportObj->getCompanyDetail($ccode);
$ccodeDetail = $supportObj->getCcode($ccode);
//echo "<pre>";print_r($ccodeDetail);echo "</pre>";
//die();

?>
<link rel="stylesheet" href="client/css/datePicker.css" type="text/css">
<script language="JavaScript" src="client/js/jquery.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/date.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/jquery.bgiframe.js" type="text/javascript"></script>


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
<link href="client/css/stylesheet123.css" rel="stylesheet" type="text/css">
<link href="lib/grid/css/grid.css" rel="stylesheet" type="text/css" />

<body>
      
<div class="center">
    
     <div style="clear:both"></div>
 
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

      <table width="100%" cellpadding="0" cellspacing="2" class="border">
      <tr align="center" height="26" >
        <td width="23%" height="25" class="bg_darkgray1" align="center"><strong>Start of validity</strong></td>
        <td width="16%" class="bg_darkgray1"><strong>End of validity</strong></td>
        <td width="21%" class="bg_darkgray1"><strong>Value</strong></td>
        
      </tr>
      <?php
                    foreach ($ccodeDetail as $ccodeDetail1) {
?>
      <tr align="center" height="26" >
        <td align="center"><? echo $ccodeDetail1['start_of_validity']; ?></td>
        <td align="center"><? echo $ccodeDetail1['end_of_validity'];?></td>
        <td align="center"><? echo $ccodeDetail1['value']; ?></td>
        
      </tr>
      <?php } ?>

    </table>
<br/><br/>
 <div class="top_h1"> View Company Details</div>
    <table width="100%" cellpadding="0" cellspacing="2" class="border">
      <tr align="center" height="26" >
        <td width="23%" height="25" class="bg_darkgray1" align="center"><strong>Company Name</strong></td>
        <td width="16%" class="bg_darkgray1"><strong>Street</strong></td>
        <td width="21%" class="bg_darkgray1"><strong>City</strong></td>
        <td width="21%" class="bg_darkgray1"><strong>Country</strong></td>
        <td width="20%" align="center" class="bg_darkgray1"><strong>Zip</strong></td>
      </tr>
      <?php
                    foreach ($data as $data1) {
?>
      <tr align="center" height="26" >
        <td align="center"><? echo $data1['company_name']; ?></td>
        <td align="center"><? echo $data1['street'];?></td>
        <td align="center"><? echo $data1['city']; ?></td>
        <td align="center"><? echo $data1['name'];?></td>
        <td align="center"><? echo $data1['zip'];?></td>
      </tr>
      <?php } ?>
      
    </table>

      <table width="100%" border="0" >
           <?php
                if ($data1 == '') {
                    echo "No Records Found";
                }
?>
 		<tr>
 				<td>&nbsp;</td>
	  </tr>
 		<tr><td><div align="center" >
                            
        <INPUT type="button" value="Back" name="continue" id="continue" class="button" onClick="javascript:location.href='showCcode.php'" >
       
    <br />
          <br />
          </div></td></tr></table>
    <br>
    <table width='100%'  cellpadding="0" cellspacing="0">
     
    </table>
  </form>
</div>

<? include("footer.php"); ?>

</body>

