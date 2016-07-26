<?
header('Content-Type: text/html; charset=utf-8');
include_once("cumbari.php");
/* File Name   : feedBack.php
*  Description : feedback Form
*  Author      : Deo  Date: 11th,Jan,2011  Creation
*/
//print_r($_GET);
ob_start();

$feedObj = new feedback();
$feedObj->svrRegDflt();

?>
<link rel="stylesheet" href="client/css/datePicker.css" type="text/css">
<script language="JavaScript" src="client/js/jquery.js"></script>
<script language="JavaScript" src="client/js/jsFeedback.js" type="text/javascript"></script>

<div id="main">
    <div id="innermain">
        <form style="width:320px;" name="register" action="" id="registerform" method="POst">
            <input type="hidden" name="m" value="savefeedback">
            <input type="hidden" name="ccid" id ="ccid" value="<?=$_GET['ccid']?>"> <div id='error_ccid' class="error"></div>
            <input type="hidden" name="cos" id="cos" value="<?=$_GET['cos']?>"> <div id='error_cos' class="error"></div>
            <div class="feed">
                <table BORDER=0 >
                    <tr>
                        <td >&nbsp;</td>
                        <td align="left"><h4>Feed Back</h4>
                        </td>
                    </tr>
                    <tr>
                        <td>Message:</td>
                        <td>
                            <textarea name="message" id ="message"></textarea>
                            <div id='error_message' class="error"></div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <INPUT type="submit" value="Submit" name="feedback" id="feedback" onclick="feedBackMessage.php">
                        </td>
                    </tr>
                </table>
            </div>
        </form>

    </div>
</div>
</Body>
