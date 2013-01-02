<?
header('Content-Type: text/html; charset=ISO-8859-15');
include_once("cumbari.php");
$inoutObj = new inOut();
/* File Name   : inviteRetailers.php
 *  Description : Invite Retailers Form
 *  Author      : Deo  Date: 12th,Jan,2011  Creation
*/
$menu = "offer";
$offer = 'class="selected"';
if ($_GET['m'] == "showcampoffer")
    $outdated = 'checked="checked"';
else
    $show = 'checked="checked"';
$reseller = $_REQUEST['from'];
if($reseller == '')
{
include("main.php");
} else {
    include("mainReseller.php");
}

$mailObj = new sendInviteRetailers();
if (isset($_POST['continue'])) {

    $mailObj->inviteRetailers();
}
//echo $_GET['campaignId'];
 $regObj = new registration();
 $data = $regObj->getCcode();
include_once("header.php");
?>
<script language="JavaScript" src="client/js/jsInviteRetailers.js" type="text/javascript"></script>
<style type="text/css">
<!--
.center{width:900px; margin-left:auto; margin-right:auto;}
-->
</style><body>
<div class="center">
<div id="main">
    <div id="mainbutton">
        <form name="registerform" action="" id="registerform" method="POst">
            <input type="hidden" name="m" value="sendMailRetailers">
            <input type="hidden" name="reseller" value="<?=$_REQUEST['from']?>">
            <input type="hidden" name="campaignId" value="<?=$_GET['campaignId']?>">

              <div id="msg" align="center">
        <?

        if (($_SESSION['MESSAGE'])) {
             
            echo $_SESSION['MESSAGE'];
            $_SESSION['MESSAGE'] = '';

        }
        ?>

    </div>
            <table width="100%">
                <tr>

                    <td width="51%" class="redwhitebutton_small" style="padding-top:5px; text-align:center">Invite Retailers to add their locations</td>
                </tr>
                <tr>

                    <td width="51%">&nbsp;</td>
                </tr>

                <tr>

                    <td><table BORDER=0 width="100%" cellspacing="15" >
                            <tr>
                            		
                                <td width="578" class="inner_grid">Email Addresses(comma<br /> 
                                		separated) 
                                		<span class='mandatory'>*</span>:</td>
                                <td width="455">
                                    <textarea class="text_field_new"  name="email" id ="email" value="<?=$_SESSION['post']['email']
                                                      ?>"></textarea>
                                    <div id='error_email' class="error"></div>      
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                              <td width="578" class="inner_grid">Message
                                		:</td>
                                <td width="455">
                                    <textarea class="text_field_new" style=" height: 100px;" name="message" id ="message" value="<?=$_SESSION['post']['message']
                                          ?>"></textarea>
                                    <div id='error_message' class="error"></div>   
                                </td>
                                <td></td>
                            </tr>

                            <? if($reseller == 'reseller') { ?>
                             <tr>
                               <td align="left">Discount:</td>
                <td align="left">

                    <select class="text_field_new"  name="ccode" id="ccode" >
                      <option value="">Select</option>
   <? foreach($data as $data1) { ?>

                        <option value="<? echo $data1['ccode'] ;?> "> <? echo $data1['value'];?></option>
                           <? } ?>
                    </select>

                    <div id='error_ccode' class="error"></div>
                
                </td>
                <td align="right" valign="middle"><a title="<?=CCODE_TEXTCODE
                       ?>" class="vtip"><b><small>?</small></b></a> </td>
            </tr>
            <? } ?>
                        </table></td>
                </tr>
                <tr>
                   
                    <td width="51%">
                        <div align="center">
                            <INPUT style="margin-left:140px;" type="submit" value="Submit" name="continue" id="continue" class="button" >
                        </div>                    </td>
                </tr>
                <tr>
                    
                    
                  
                    <td>
                        
                        <div id='error_message' class="error"></div>                                </td>
                </tr>
            </table>
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
</div><? include_once("footer.php"); ?>
</body>
</html>
