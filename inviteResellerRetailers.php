<?php
header('Content-Type: text/html; charset=ISO-8859-15');
include_once("cumbari.php");

/* File Name   : inviteRetailers.php
*  Description : Invite Retailers Form
*  Author      : Deo  Date: 12th,Jan,2011  Creation
*/
$inoutObj = new inOut();
$mailObj = new sendInviteRetailers();
if(isset($_POST['continue'])) {

$mailObj->inviteRetailers();
}

$regObj = new registration();
$data = $regObj->getCcode();
include_once("header.php");
?>
<script language="JavaScript" src="client/js/jsInviteRetailers.js" type="text/javascript"></script>
<style type="text/css">
<!--
.center{width:900px; margin-left:auto; margin-right:auto;}
-->
</style>
<div class="center">
<div id="main">
<div id="mainbutton">
<table width="100%">
<tr>

<td colspan="2">&nbsp;</td>
</tr>
<tr>

<td colspan="2" class="redwhitebutton">1 Register</td>
</tr>
<tr>
		<td colspan="2" >&nbsp;</td>
</tr>

<tr>
		<td colspan="2">&nbsp;</td>
</tr>
<tr>

<td colspan="2"class="redwhitebutton">2 Add Offer</td>
</tr>
<tr>
		<td colspan="2" >&nbsp;</td>
</tr>
<tr>

<td colspan="2" class="blackbutton_small">Invite Retailers to add their locations</td>
</tr>
<tr>

<td colspan="2">&nbsp;</td>
</tr>
<form name="registerform" action="" id="registerform" method="POst">
<input type="hidden" name="m" value="sendMail">
<input type="hidden" name="reseller" value="reseller">
      <div id="msg" align="center">
        <?

        if (($_SESSION['MESSAGE'])) {

            echo $_SESSION['MESSAGE'];
            $_SESSION['MESSAGE'] = '';

        }
        ?>

    </div>
<tr>

<td colspan="2"><table BORDER=0 width="100%" cellspacing="15" >
<tr>
		<td width="3">&nbsp;</td>
<td width="528">E-mail Addresses,comma separated
		<span class='mandatory'>*</span>:</td>
<td width="451" align="left" valign="baseline">
<textarea class="text_field_new" name="email" id ="email" value="<?=$_SESSION['post']['email']?>"></textarea>
<div id='error_email' class="error"></div></td>
<td></td>
</tr>
<tr>
		<td>&nbsp;</td>
<td>Message:</td>
<td align="left">
<textarea class="text_field_new" style="height:100px;" name="message" id ="message" value="<?=$_SESSION['post']['message']?>"></textarea>
<div id='error_message' class="error"></div></td>
<td></td>
</tr>


<tr>
<td>&nbsp;</td>
<td align="left">Discount</td>
<td align="left">

<select class="text_field_new" type=text name="ccode" id="ccode" >
 <option value="">Select</option>
   <? foreach($data as $data1) { ?>

<option value="<? echo $data1['ccode']?>"> <? echo $data1['value'];?></option>
                           <? } ?>
 </select>

     <div id='error_ccode' class="error"></div></td>
 <td align="right" valign="middle"><a title="<?=CCODE_TEXTCODE
                       ?>" class="vtip"><b><small>?</small></b></a> </td>
 </tr>

</table></td>
</tr>
<tr>

<td width="98%">
<div align="center">
<INPUT type="submit" value="Send" name="continue" id="continue" class="button" >
</div></td>
<td width="2%">&nbsp;</td>
</tr>
</form>
<tr>

<td colspan="2">&nbsp;</td>
</tr>
<tr>

<td colspan="2" class="redgraybutton">3 Activate</td>
</tr>
<tr>

<td colspan="2">&nbsp;</td>
</tr>
</table>
</div>
<span class='mandatory'>* These Fields Are Mandatory</span>
</div>
</div>
<? include_once("footer.php");?>
