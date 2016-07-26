<?php
/*  File Name : shoeNewUser.php
 *  Description : show new user Form
 *  Author  :Deo  Date: 31st,Jan,2011  Creation
 */
header('Content-Type: text/html; charset=utf-8');
include_once("cumbari.php");
include_once("main.php");
$accountObj = new accountView();
 $userid = $_GET['userId'];
$data = $accountObj->getNewUserDetailById($userid);
include_once("header.php");
?>
<?php include 'config/defines.php'; ?>
<style type="text/css">
a {
}
img {
	border: 0
}
.center {
	width:900px;
	margin-left:auto;
	margin-right:auto;
}
</style>
<link href="client/css/stylesheet123.css" rel="stylesheet" type="text/css">
<body>
<div class="center">
  <form name="register" action="" id="registerform" method="POst">
    <?php
    if ($_SESSION['MESSAGE']) {
        echo $_SESSION['MESSAGE'];
        $_SESSION['MESSAGE'] = "";
    }
    ?>
    <input type="hidden" name="m" value="saveuser">
    <div style="height:93px; width:100%; margin-top:20px;">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="100%" height="93" class="redwhitebutton1234">New User Details</td>
        </tr>
      </table>
    </div>
    <table width="100%" border="0">
      <tr>
        <td width="57%"><table BORDER=0 width="100%">
            <tr>
              <td width="47%"></td>
              <td width="53%"></td>
            </tr>
            <tr>
              <td></td>
              <td></td>
            </tr>
          </table>
          <table border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td align="left" class="td_pad_left_2">Email Address:</td>
              <td align="left" class="td_pad_right_2"><b/>
                <?=$data[0]['email']
    ?>
              </td>
            </tr>
            <tr>
              <td align="left" class="td_pad_left_2">First Name:</td>
              <td align="left" class="td_pad_right_2"><b/>
                <?=$data[0]['fname']
    ?></td>
            </tr>
            <tr>
              <td align="left" class="td_pad_left_2">Last Name:</td>
              <td align="left" class="td_pad_right_2"><b/>
                <?=$data[0]['lname']
    ?></td>
            </tr>
            <tr>
              <td align="left" class="td_pad_left_2">Phone Number:</td>
              <td align="left" class="td_pad_right_2"><b/>
                <?=$data[0]['phone']
    ?></td>
            </tr>
            <tr>
              <td align="left" class="td_pad_left_2">Mobile Number:</td>
              <td align="left" class="td_pad_right_2"><b/>
                <?=$data[0]['mobile_phone']
    ?></td>
            </tr>
          </table></td>
      </tr>
    </table>
    <div align="center"> <br>
      <INPUT type="button" value="Back" name="continue" id="continue" class="button" onClick="javascript:location.href='<?=$_SERVER[HTTP_REFERER]
                       ?>';" >
      <br />
      <br />
    </div>
  </form>
</div>
<? include("footer.php"); ?>
</body>
</html>
