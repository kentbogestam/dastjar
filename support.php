<?php
/*  File Name   : login.php
*   Description : Login form
*   Author      : Sushil Singh  Date: 12th,Nov,2010  Creation
*/
header('Content-Type: text/html; charset=utf-8');
include_once("cumbari.php");
$inoutObj = new inOut();
//$inoutObj->validSteps();



if(isset($_POST['SLogin']) || $_SESSION['supportuserid']) {
//echo "In"; die();

    $inOutObj = new inOut();

    $inOutObj->svrInOutDflt();


}

if(isset($_SESSION['supportuserid'])) {
    $url = BASE_URL . 'userActivity.php';
    $inoutObj->reDirect($url);
    exit;
}
?>


<?php include("headersupport.php");?>
<script language="JavaScript" src="client/js/jsLogin.js" type="text/javascript"></script>
<body>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td class="header-bg"></td>
        </tr>
        <tr>
            <td height="22" class="tnb_admin">&nbsp;</td>
        </tr>
        <tr>
            <td height="373" valign="top"><br />

                <form id="submitFrm" name="submitFrm" action="" method="post" >
                    <input type="hidden" name="m" value="support_in">

                    <table width="100%" border="0">
                        <tr>
                            <td width="20%">&nbsp;</td>
                            <td bgcolor="#e9e9e3"><table width="100%" border="0">
                                    <tr>
                                        <td width="50%"><table width="100%" border="0">
                                                <tr>
                                                    <td height="35" align="left" valign="top" colspan="2"><strong>SUPPORT LOGIN </strong></td>
                                                <!-- <td align="left" valign="top" >&nbsp;</td> -->
                                                </tr>
                                                <tr>
                                                    <td width="295" height="29" align="left" valign="top">Username
                                                        :</td>
                                                    <td width="210" align="left" valign="top" >
                                                        <input class="text_field_new" style="width:300px;" type="text" name="username" id="username" size="35"  />
                                                        <div id='error_username' style="padding-left:0px; " class="error"></div></td>
                                                </tr>
                                                <tr>
                                                    <td align="left" valign="top"> Password : </td>
                                                    <td align="left" valign="top">
                                                        <input class="text_field_new"  style="width:300px;"  type="password" name="password" id="password"  size="35"  />

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="left" valign="top"></td>
                                                    <td  align="left" valign="middle"  >
                                                        <?php
                                                        if($_SESSION['MESSAGE']!='') {
                                                            echo $_SESSION['MESSAGE'];
                                                            $_SESSION['MESSAGE']="";
                                                        }
                                                        if($_SESSION['MESSEAGE_MAIL']!='') {
                                                            echo $_SESSION['MESSEAGE_MAIL'];
                                                            $_SESSION['MESSEAGE_MAIL']="";
                                                        }
                                                        ?>

                                                  </td>
                                                </tr>
                                                <tr>
                                                    <td height="29" align="left" valign="top">&nbsp;</td>
                                                    <td align="left"><input type="hidden" name="action" value="login">
                                                        <input  id="SLogin" type="submit" value="Login" name="SLogin" class="button" />  </td>
                                                </tr>
                                                <tr>
                                                    <td height="29" align="left" valign="top">&nbsp;</td>
                                                    <td align="left">&nbsp;</td>
                                                </tr>
                                                <tr>

                                                    <td align="center"   colspan="2"> <!-- <a id="newcumbari" href='registrationProcess.php'>New to Dastjar? Register here!</a> --> </td>
                                                </tr>
                                            </table></td>

                                    </tr>
                                </table></td>
                            <td width="15%">&nbsp;</td>
                        </tr>
                    </table>








                </form>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>

        <tr>
            <td height="30" align="left">

            </td>
        </tr>
    </table>
    <?php
    include_once("footer.php");
    ?>
