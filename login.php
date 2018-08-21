<?php
/*  File Name   : login.php
*   Description : Login form
*   Author      : Sushil Singh  Date: 12th,Nov,2010  Creation
*/
header('Content-Type: text/html; charset=utf-8');
include_once("cumbari.php");
$inoutObj = new inOut();
//$inoutObj->validSteps();

if(isset($_SESSION['userid']) && $_SESSION['active_state']==5) {
    $url = BASE_URL . 'showStandard.php';
    $inoutObj->reDirect($url);
    exit;
}else if(isset($_SESSION['userid']) && $_SESSION['active_state']==2) {
    $url = BASE_URL . 'addSubscription.php';
    $inoutObj->reDirect($url);
    exit;
}else if(isset($_SESSION['userid']) && $_SESSION['active_state']==1) {
    $url = BASE_URL . 'addCompany.php';
    $inoutObj->reDirect($url);
    exit;
}

if(isset($_POST['SLogin']) || $_SESSION['userid']) {
    $inOutObj = new inOut();
    $inOutObj->svrInOutDflt();
}

?>
<?php include("header.php");?>
<script language="JavaScript" src="client/js/jsLogin.js" type="text/javascript"></script>
<div class="center">
<table width="900" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="header-bg"></td>
  </tr>
  <tr>
    <td height="22" class="tnb_admin">&nbsp;</td>
  </tr>
  <tr>
    <td height="373" valign="top"><br />
      <form id="submitFrm" name="submitFrm" action="" method="post" >
        <input type="hidden" name="m" value="in">
       <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#e9e9e3">
  <tr>
    <td><table border="0" align="center" bgcolor="#e9e9e3">
          <tr>
            <td height="35" align="center" valign="middle" colspan="2"><strong>LOGIN </strong></td>
            <!-- <td align="left" valign="top" >&nbsp;</td> -->
          </tr>
          <tr>
            <td align="right">Username :</td>
            <td align="left" valign="top" ><input class="text_field_new" style="width:300px;" type="text" name="username" id="username" size="35"  /></td>
          </tr>
          <tr>
            <td align="right"> Password : </td>
            <td align="left" valign="top"><input class="text_field_new"  style="width:300px;"  type="password" name="password" id="password"  size="35"  />
            </td>
          </tr>
          <tr>
            <td align="left" valign="middle"></td>
            <td  align="left" valign="middle"  ><?php
                                                        if($_SESSION['MESSAGE']!='') {
                                                            echo $_SESSION['MESSAGE'];
                                                            $_SESSION['MESSAGE']="";
                                                        }
                                                        if($_SESSION['MESSEAGE_MAIL']!='') {
                                                            echo $_SESSION['MESSEAGE_MAIL'];
                                                            $_SESSION['MESSEAGE_MAIL']="";
                                                        }
                                                        ?>            </td>
          </tr>
          <tr>
            <td height="29" align="left" valign="top">&nbsp;</td>
            <td align="left"><input type="hidden" name="action" value="login" />
              <input  id="SLogin" type="submit" value="Login" name="SLogin" class="button1" />
            </td>
          </tr>
          <tr>
            <td></td>
            <td><input type="button" value="Forgot Password" onClick="location.href='forgotPassword.php'" name="forgot" class="button1" />
            </td>
          </tr>
          <tr>
            <td height="29" align="left" valign="top">&nbsp;</td>
            <td align="left">&nbsp;</td>
          </tr>
          <tr>
            <td height="40" colspan="2" align="center" valign="middle"><a id="newcumbari" href='registrationProcess.php'>New to us? Register here!</a></td>
          </tr>
        </table></td>
  </tr>
</table>
 
      </form>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="30" align="left"></td>
  </tr>
</table>
</div>
<?php
    include_once("footer.php");
    ?>
