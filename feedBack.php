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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Feedback</title>
<link href="client/css/datePicker.css" rel="stylesheet" type="text/css" />
</head>

<body style="background-image:url(client/images/backgroundoffeedback.jpg);">
<div id="container_feeback">
<div>
<form style="width:320px;" name="register" action="" id="registerform" method="POst" >
            <input type="hidden" name="m" value="savefeedback">
            <input type="hidden" name="ccid" id ="ccid" value="<?=$_GET['ccid']?>"> <div id='error_ccid' class="error"></div>
            <input type="hidden" name="cos" id="cos" value="<?=$_GET['cos']?>"> <div id='error_cos' class="error"></div>
            <div class="feed">
                <table BORDER=0>
                    <tr>
                        <td >&nbsp;</td>
                       <td  height="40" style="color:#FFFFFF; font-family:Geneva, Arial, Helvetica, sans-serif; font-size:20px; font-weight:bold" >Feed Back</td>
                    </tr>
                    <tr>
                        <td height="214" valign="top"style="color:#FFFFFF;">Message:</td>
                        <td>
                            <textarea name="message" id ="message" style="width:230px; height:200px;"></textarea>
                            <div id='error_message' class="error"></div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            
                        </td>
				     <td align="right">
                            <INPUT type="submit" value="Submit" name="feedback" id="feedback" onclick="feedBackMessage.php">                        </td>
                    </tr>
                </table>
            </div>
        </form>
	   </div>
</div>
<div><? include("footer.php"); ?></div>
</body>
</html>
