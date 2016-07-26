<?php
/* File Name   : addEditCategory.php
 *  Description : addEditCategory
 *
*/
header('Content-Type: text/html; charset=utf-8');
include_once("cumbari.php");
$menu = "partner";
$partner = 'class="selected"';
include("mainSupport.php");
$supportObj = new support();
$editId = $_GET['editId'];

if($editId)
{
   $data = $supportObj->getPartner($editId);
  //echo"<pre>"; print_r($data);echo"</pre>";
}
if (isset($_POST['continue']) AND $editId == '') {
    $supportObj->addPartner();
}

if (isset($_POST['continue']) AND $editId != '') {
    $supportObj->editPartner($editId);
}
//after post

/////////////////////



?>
<?php include 'config/defines.php'; ?>
 <script language="JavaScript" src="client/js/jquery.js" type="text/javascript"></script>
 <script language="JavaScript" src="client/js/jsAddPartner.js" type="text/javascript"></script><style type="text/css">
<!--
.center{width:900px; margin-left:auto; margin-right:auto;}

-->
</style>

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
                    <td class="redwhitebutton">ADD PARTNER</td>
                    <? }  else { ?>

				 <td class="redwhitebutton">EDIT PARTNER</td>
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

                    <td width="50%" align="left" class="inner_grid">Company Name<span class='mandatory'>*</span>
                    		:</td>
                    <td width="50%" align="left">
                         <INPUT class="text_field_new" type="text" name="company" id="company" value="<?=$data[0]['company_name']?>">
                        <a title="<?=COMP_NAME?>" class="vtip"><b><small>?</small></b></a><br/>
                        <div id='error_company' class="error"></div></td>


                </tr>

                <tr>

                    <td align="left" class="inner_grid">Country<span class='mandatory'>*</span>:</td>
                    <td align="left">
                        <INPUT class="text_field_new" type="test" name="country" id="country" value="<?=$data[0]['country']?>"/>
                        <a title="<?=COUNTRY_TEXT?>" class="vtip"><b><small>?</small></b></a><br/>
                        <div id='error_country' class="error"></div></td>
                </tr>

              <tr>

                    <td align="left" class="inner_grid">City<span class='mandatory'>*</span>:</td>
                    <td align="left">
                        <INPUT class="text_field_new" type="test" name="city" id="city" value="<?=$data[0]['city']?>"/>
                        <a title="<?=CITYNAME_TEXT?>" class="vtip"><b><small>?</small></b></a><br/>
                        <div id='error_city' class="error"></div></td>
                </tr>

                <tr>

                    <td align="left" class="inner_grid">Street<span class='mandatory'>*</span>:</td>
                    <td align="left">
                        <INPUT class="text_field_new" type="test" name="street" id="street" value="<?=$data[0]['street']?>"/>
                        <a title="<?=SADD_TEXT?>" class="vtip"><b><small>?</small></b></a><br/>
                        <div id='error_street' class="error"></div></td>
                </tr>


                <tr>

                    <td align="left" class="inner_grid">Organisation<span class='mandatory'>*</span>:</td>
                    <td align="left">
                        <INPUT class="text_field_new" type="test" name="orgnr" id="orgnr" value="<?=$data[0]['orgnr']?>"/>
                        <a title="<?=OCODE_TEXT?>" class="vtip"><b><small>?</small></b></a><br/>
                        <div id='error_orgn' class="error"></div></td>
                </tr>

                <tr>

                    <td align="left" class="inner_grid">Version<span class='mandatory'>*</span>:</td>
                    <td align="left">
                        <INPUT class="text_field_new" type="test" name="version" id="version" value="<?=$data[0]['version']?>"/>
                        <a title="<?=VERSION?>" class="vtip"><b><small>?</small></b></a><br/>
                        <div id='error_version' class="error"></div></td>
                </tr>

                 <tr>

                    <td align="left" class="inner_grid">Zip<span class='mandatory'>*</span>:</td>
                    <td align="left">
                        <INPUT class="text_field_new" type="test" name="zip" id="zip" value="<?=$data[0]['zip']?>"/>
                       <a title="<?=ZCODE_TEXT?>" class="vtip"><b><small>?</small></b></a><br/>
                        <div id='error_zip' class="error"></div></td>
                </tr>

			 <td align="left">&nbsp;</td>
			 <td align="left">&nbsp;</td></tr>
              <? if($editId == '') {?>
        <tr>
                    <td colspan='3' align="center">
                        <INPUT style="margin-left:160px;" type="submit" value="Continue" class="button" name="continue" id="continue">
                <INPUT type="button" value="Back" name="continue" id="continue" class="button" onClick="javascript:location.href='showPartner.php';" >
        </tr>
             <? }  else { ?>
                 <tr>
                    <td colspan='3' align="center">
                        <INPUT style="margin-left:160px;" type="submit" value="Update" class="button" name="continue" id="update">
                <INPUT type="button" value="Back" name="continue" id="continue" class="button" onClick="javascript:location.href='showPartner.php';" >
                 </tr>
           <? } ?>
            </table>
        </td>

    </form>
</div><span class='mandatory'>* These Fields Are Mandatory</span>
</div>
<? include("footer.php"); ?>

