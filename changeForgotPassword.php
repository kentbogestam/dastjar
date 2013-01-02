<?php
/* File Name   : editCompany.php
 *  Description : Change Password Form
 *  Author      : Deo  Date: 28th,Jan,2011  Creation
*/
header('Content-Type: text/html; charset=ISO-8859-15');
include_once("cumbari.php");
$email = $_GET['email'];
$inoutObj = new inOut();
if (isset($_POST['update'])) {
    $inoutObj->saveChangeForgotPassword($email);
}

//after post

/////////////////////


include_once("header.php");
?>
<?php include 'config/defines.php'; ?>
 <script language="JavaScript" src="client/js/jquery.js" type="text/javascript"></script>
 <script language="JavaScript" src="client/js/jsChangeForgotPassword.js" type="text/javascript"></script><style type="text/css">
<!--
.center{width:900px; margin-left:auto; margin-right:auto;}

</style>
<div class="center">
<table width="100%" border="0">
		<tr>
				<td >&nbsp;</td>
		</tr>
		<tr>
				<td >&nbsp;</td>
		</tr>
		<tr>

				<td class="redwhitebutton">Enter New Password</td>
		</tr>
</table>


<div align="center">
		<form name="register" action="" id="registerform" method="post">
       <br>
        <input type="hidden" name="m" value="">
        <div id="msg" align="center">

            <?php

            if($_SESSION['MESSAGE']) {
                echo $_SESSION['MESSAGE'];
                $_SESSION['MESSAGE']="";
            }
            ?>
        </div>

        <input type="hidden" name="m" value="">



        <td width="100%"><table BORDER=0 cellspacing="13" width="100%" >

                <tr>
                    <td colspan="3" ></td>
                </tr>

                <tr>

                    <td width="50%" align="left" class="inner_grid"> E-mail
                    		:</td>
                    <td width="50%" align="left">
                        <div><? echo $email;?></div>
                       
                        </td>
                </tr>

                <tr>

                    <td align="left" class="inner_grid">New Password<span class='mandatory'>*</span>:</td>
                    <td align="left">
                        <INPUT class="text_field_new" type=password name="pwd" id="pwd">
                        <a title="<?=PASS_TEXT?>" class="vtip"><b><small>?</small></b></a></br>
                        <div id='error_pwd' class="error"></div></td>
                </tr>

                 <tr>

                    <td align="left" class="inner_grid">Verify Password<span class='mandatory'>*</span>:</td>
                    <td align="left">
                        <INPUT class="text_field_new" type=Password name="c_pwd" id="c_pwd" value="<?=$_SESSION['post']['c_pwd']?>">
                        <div id='error_c_pwd' class="error"></div></td>
                </tr>

			 <td align="left">&nbsp;</td>
			 <td align="left">&nbsp;</td></tr>
                <tr>
                    <td colspan='3' align="center">
                        <INPUT style="margin-left:160px;" type="submit" value="Change" class="button" name="update" id="update">
                </tr>

            </table>
        </td>

    </form>
</div><span class='mandatory'>* These Fields Are Mandatory</span>
</div>
<? include("footer.php"); ?>

</body>
</html>

