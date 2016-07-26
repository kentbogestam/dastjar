<?php
/* File Name   : addEditCategory.php
 *  Description : addEditCategory
 *
*/
header('Content-Type: text/html; charset=utf-8');
include_once("cumbari.php");
$menu = "ccode";
$ccode = 'class="selected"';
include("mainSupport.php");
$supportObj = new support();
$editId = $_GET['editId'];

if($editId)
{
   $data = $supportObj->getCcode($editId);
  //echo"<pre>"; print_r($data);echo"</pre>";
}
if (isset($_POST['continue']) AND $editId == '') {
    $supportObj->addCcode();
}

if (isset($_POST['continue']) AND $editId != '') {
    $supportObj->editCcode($editId);
}
//after post

/////////////////////



?>
<?php include 'config/defines.php'; ?>
<link rel="stylesheet" href="client/css/datePicker.css" type="text/css">
 <script language="JavaScript" src="client/js/jquery.js" type="text/javascript"></script>
 <script language="JavaScript" src="client/js/jsAddCcode.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/date.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/jquery.bgiframe.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/jquery.datePicker.js" type="text/javascript"></script>
<div class="center">
<table width="100%" border="0">
		<tr>
				<td >&nbsp;</td>
		</tr>
		<tr>
				<td >&nbsp;</td>
		</tr>
		<tr>
                           <? if($editId == '') {?>
                    <td class="redwhitebutton">ADD CCODE</td>
                    <? }  else { ?>

				 <td class="redwhitebutton">EDIT CCODE</td>
                           <? } ?>

		</tr>
</table>


<div align="center">
		<form name="category" action="" id="category" method="post" enctype="multipart/form-data">
                    
       <br>
        <input type="hidden" name="m" value="">
        <div id="msg" align="center">

            <?php

            if($_SESSION['MESSAGE']) {
                echo $_SESSION['MESSAGE'];
                $_SESSION['MESSAGE']="";
            }
            ?>
        </div>





        <td width="100%"><table BORDER=0 cellspacing="10" width="100%" >

                <tr>
                    <td colspan="3" ></td>
                </tr>

                   <tr>
                               <?  $d=$data[0]['start_of_validity'];
            $timeStamp = explode(" ",$d);
            $start_date = trim($timeStamp[0]);?>

                                <td class="inner_grid">Start of validity<span class='mandatory'>*</span>:</td>
                                <td><input style="width: 380px;" type="text" name="startDate" readonly="readonly" value="<?=$start_date?>" id="startDate" class="startDate text_field_new" />
                                    <a title="<?=START_TEXT ?>" class="vtip"><b><small>?</small></b></a><br/>
                                    <div id='error_startDate' class="error"></div>                                </td>
                            </tr>

               <tr>
                                 <?  $d=$data[0]['end_of_validity'];
                $timeStamp = explode(" ",$d);
                $end_date = trim($timeStamp[0]);?>

                                <td class="inner_grid">Start of validity<span class='mandatory'>*</span>:</td>
                                <td><input style="width: 380px;" type="text" name="endDate" readonly="readonly" value="<?=$end_date?>" id="endDate" class="endDate dp-applied text_field_new" />
                                    <a title="<?=END_TEXT ?>" class="vtip"><b><small>?</small></b></a><br/>
                                    <div id='error_endDate' class="error"></div>                                </td>
                            </tr>
             

                <tr>

                    <td align="left" class="inner_grid">Value<span class='mandatory'>*</span>:</td>
                    <td align="left">
                        <INPUT class="text_field_new" type="text" name="value" id="value" value="<?=$data[0]['value']?>"/>
                        <a title="<?=CCODE_TEXT?>" class="vtip"><b><small>?</small></b></a><br/>
                        <div id='error_value' class="error"></div></td>
                </tr>


               

			 <td align="left">&nbsp;</td>
			 <td align="left">&nbsp;</td></tr>
              <? if($editId == '') {?>
        <tr>
                    <td colspan='3' align="center">
                        <INPUT style="margin-left:160px;" type="submit" value="Continue" class="button" name="continue" id="continue">
                <INPUT type="button" value="Back" name="continue" id="continue" class="button" onClick="javascript:location.href='showCcode.php';" >
        </tr>
             <? }  else { ?>
                 <tr>
                    <td colspan='3' align="center">
                        <INPUT style="margin-left:160px;" type="submit" value="Update" class="button" name="continue" id="continue">
                <INPUT type="button" value="Back" name="continue" id="continue" class="button" onClick="javascript:location.href='showCcode.php';" >
                 </tr>
           <? } ?>
            </table>
        </td>

    </form>
</div><span class='mandatory'>* These Fields Are Mandatory</span>
</div>
<? include("footer.php"); ?>

</body>
</html>

