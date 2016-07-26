<?php
header('Content-Type: text/html; charset=utf-8');
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
include_once("header.php");
?>
<link rel="stylesheet" type="text/css" href="client/css/stylesheet123.css" />
<script language="JavaScript" src="client/js/jsInviteRetailers.js" type="text/javascript"></script>
<style type="text/css">
<!--
.center {
	width:900px;
	margin-left:auto;
	margin-right:auto;
}
-->
</style>
<div class="center">
  <div id="main">
    <div id="mainbutton">
      <table border="0" align="center" cellpadding="0" cellspacing="0">
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
          <td colspan="2" class="redwhitebutton">2 Add Company</td>
        </tr>
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2"class="redwhitebutton">3 Add Offer</td>
        </tr>
        <tr>
          <td colspan="2" ><img src="images/spacer.gif" width="1" height="12" /></td>
        </tr>
        <tr>
          <td colspan="2" class="blackbutton_small_ir">Invite Retailers to add their locations</td>
        </tr>
        <form name="registerform" action="" id="registerform" method="POst">
          <input type="hidden" name="m" value="sendMail">
          <tr>
            <td colspan="2"><table width="90%" BORDER=0 align="center" cellpadding="0" cellspacing="0" >
                <tr>
                  <td width="50%" valign="top" class="td_pad_left">E-mail Addresses,comma separated <span class='mandatory'>*</span>:</td>
                  <td width="50%" align="left" valign="baseline" class="td_pad_right"><textarea class="text_field_new_ir" name="email" id ="email" value="<?=$_SESSION['post']['email']?>"></textarea>
                    <div id='error_email' class="error" style="display:none"></div></td>
                </tr>
                <tr>
                  <td width="50%" valign="top" class="td_pad_left">Message:</td>
                  <td width="50%" align="left" class="td_pad_right"><textarea class="text_field_new_ir" style="height:100px;" name="message" id ="message" value="<?=$_SESSION['post']['message']?>"></textarea>
                    <div id='error_message' class="error" style="display:none"></div></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td width="98%" align="center"><div align="center">
                <INPUT type="submit" value="Send" name="continue" id="continue" class="button" >
              </div></td>
          </tr>
        </form>
        <tr>
          <td colspan="2"><img src="images/spacer.gif" width="1" height="10" /></td>
        </tr>
        <tr>
          <td colspan="2" class="redgraybutton">4 Activate</td>
        </tr>
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
      </table>
    </div>
    <span class='mandatory'>* These Fields Are Mandatory</span>
    <?include_once("footer.php");?>
  </div>
</div>
</html>