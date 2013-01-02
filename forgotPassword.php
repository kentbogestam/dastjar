<?php
header('Content-Type: text/html; charset=ISO-8859-15');
include_once("cumbari.php");
$inoutObj = new inOut();
if(isset($_POST['continue']))
{
    $inoutObj->forgetPassword();
}

?>
<?php include("header.php");?>
<html>
<head>
<script language="JavaScript" src="client/js/jquery.js" type="text/javascript"></script>
<script language="JavaScript" src="client/js/jsForgotPassword.js" type="text/javascript"></script>
</head>
<body>
<div class="center">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="373" valign="top"><br />
        <form id="change" name="change" action="" method="post" >
          <table width="100%" border="0" bgcolor="#E9E9E3">
            <tr>
              <td width="5%" bgcolor="#E9E9E3">&nbsp;</td>
              <td bgcolor="#e9e9e3"><table width="100%" border="0">
                  <tr>
                    <td width="50%"><table width="100%" border="0">
                        <tr>
                          <td height="35" align="left" valign="top" colspan="2"><strong>Forgot your password? </strong></td>
                        </tr>
                        <tr>
                          <td  align="left" valign="top" width="60%">Please Enter Your Email Address:</td>
                          <td  align="left" valign="top" ><input class="text_field_new" style="width:300px;" type="text" name="email" id="email" size="35"/>
                            <div id='error_email' style="padding-left:0px; " class="error"></div>
                          </td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"></td>
                          <td  align="left" valign="middle"><?php

													if($_SESSION['MESSAGE']) {
														echo $_SESSION['MESSAGE'];
														$_SESSION['MESSAGE']="";
													}
													?>
                          </td>
                        </tr>
                        <tr>
                          <td height="29" align="left" valign="top">&nbsp;</td>
                          <td align="left"><input type="submit" name="continue" id="continue" value="Submit" class="button" />
                          </td>
                        </tr>
                        <tr>
                          <td height="29" align="left" valign="top">&nbsp;</td>
                          <td align="left">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="center"   colspan="2"><!-- <a id="newcumbari" href='registrationProcess.php'>New to Cumbari? Register here!</a> -->
                          </td>
                        </tr>
                      </table></td>
                  </tr>
                </table></td>
              <td width="5%" bgcolor="#E9E9E3">&nbsp;</td>
            </tr>
          </table>
        </form>
      </td>
    </tr>
  </table>
</div>
<?php
		include_once("footer.php");
      ?>
</body>
</html>
