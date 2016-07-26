<?
header('Content-Type: text/html; charset=utf-8');
include_once("cumbari.php");
$inoutObj = new inOut();
/* File Name   : inviteRetailers.php
 *  Description : Invite Retailers Form
 *  Author      : Deo  Date: 12th,Jan,2011  Creation
*/
$reseller = $_REQUEST['from'];
if($reseller == '')
{
include("main.php");
} else {
    include("mainReseller.php");
}
$mailObj = new sendInviteRetailers();
if (isset($_POST['continue'])) {
    
    //print_r($_POST); die();
    $mailObj->inviteRetailers();
}
//echo $_GET['campaignId'];
include_once("header.php");
?>
<script language="JavaScript" src="client/js/jsInviteRetailers.js" type="text/javascript"></script>
<style type="text/css">
<!--
.center{width:900px; margin-left:auto; margin-right:auto;}
-->
</style>
<body>
<div class="center">
    <div id="mainbutton">
        <form name="registerform" action="" id="registerform" method="POst">
            <input type="hidden" name="m" value="sendMailRetailers">
             <input type="hidden" name="reseller" value="<?=$_REQUEST['from']?>">
            <input type="hidden" name="productId" value="<?=$_GET['productId']?>">
            <table width="100%">
                <tr>
                   
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    
                    <td width="100%" class="redwhitebutton_small1234">Invite Retailers to add their locations</td>
                   
                </tr>
                

                <tr>
               
                    <td><table BORDER=0 width="100%" cellspacing="15" >
                            <tr>
                              <td width="50%" class="inner_grid">E-mail Addresses<br />
                       		  (comma separated)<span class='mandatory'>*</span>:</td>
                                <td width="50%">
                                    <textarea class="text_field_new"  name="email" id ="email" value="<?=$_SESSION['post']['email']
                                                      ?>"></textarea>
                              <div id='error_email' class="error"></div>                                </td>
                            </tr>
                            <tr>
                              <td width="50%" class="inner_grid">Message:</td>
                                <td width="50%">
                                    <textarea class="text_field_new" style=" height: 100px;" name="message" id ="message" value="<?=$_SESSION['post']['message']
                                                      ?>"></textarea>
                              <div id='error_message' class="error"></div>                                </td>
                            </tr>
                        </table></td>
                    
                </tr>
                <tr>
                    
                    <td width="51%">
                        <div align="center">
                            <INPUT type="submit" value="Submit" name="continue" id="continue" class="button" >
                        </div>
                    </td>
                    
                </tr>
                <tr>
                   
                    <td>&nbsp;</td>
                </tr>
            </table>
        </form>

    </div>
<span class='mandatory'>* These Fields Are Mandatory</span>
</div>
    <? include_once("footer.php"); ?>

</body>
</html>
