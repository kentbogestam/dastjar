<?php
/* File Name   : editCompany.php
 *  Description : Edit Company Form
 *  Author      : Himanshu Singh  Date: 12th,Nov,2010  Creation
*/
header('Content-Type: text/html; charset=ISO-8859-15');
include_once("cumbari.php");
//$menu = "account";
//$account = 'class="selected"';
//$deleted = 'class="selected"';
$reseller = $_REQUEST['from'];
if($reseller == '')
{
    include_once("main.php");
}
else {
     include_once("mainReseller.php");
}
$accountObj = new accountView();
$data = $accountObj->getUserDetail();
$data1 = $data[0];

if (isset($_POST['updateUser'])) {
    $accountObj->saveUpdateUserDetail($reseller);
}
include_once("header.php");
?>
<?php include 'config/defines.php'; ?>
<!--<script type="text/javascript" src="lib/vtip/js/jquery.js"></script>

<script type="text/javascript" src="lib/vtip/js/vtip.js"></script>-->



<style type="text/css">
    body {  }
    a { }
    img { border: 0 }
</style>
<script language="JavaScript" src="client/js/jsEditUser.js" type="text/javascript"></script>
<link href="lib/grid/css/grid.css" rel="stylesheet" type="text/css" />
<div class="center">
<div style="line-height:90px; text-align:center; margin-top:25px;" class="register">Update User Details</div>
<div align="center">

    <form name="register" action="" id="registerform" method="Post">
        

        <input type="hidden" name="m" value="">
        <input type="hidden" name="companyId" value="">


        <div id="msg" align="center">

            <?php
            if ($_SESSION['MESSAGE']) {
                echo $_SESSION['MESSAGE'];
                $_SESSION['MESSAGE'] = "";
            }
            ?>
        </div>

        <input type="hidden" name="m" value="">
        <table width="100%" border="0">
            <tr>
                
                <td colspan="2">
                    <table BORDER=0 cellspacing="15"  width="100%" >
                       
                        <tr>
                           
                            <td width="47%" align="left" class="inner_grid">Email Address:</td>
                            <td width="53%" align="left"><b/><?=$data[0]['email']
                                        ?></td>
                      </tr>
                        <tr style="display: none;">
                            <th height="50" colspan ="3" align="left">Verify that you are the owner of this email address:by clicking on
                                <br>
                                the link you just just received on your mailbox                    </th>
                        </tr>
                        <tr style="display: none;">
                            
                            <td align="left">Enter your verification number:</td>
                            <td align="left">
                                <INPUT class="text_field_new" type=text name="verification_code" id="verification_code"  value="<?=$_SESSION['post']['verification_code']
                                               ?>">
                                <div id='error_verification_code' class="error"></div></td>
                        </tr>
                        <tr>
                           
                            <td align="left" class="inner_grid">First Name<span class='mandatory'>*</span>:</td>
                            <td align="left">
                                <INPUT class="text_field_new" type=text name="fname" id="fname"  value="<?=$data[0]['fname']
                                               ?>">
                                <a  title="<?=FIRST_TEXT
                                           ?>" class="vtip" ><b><small>?</small></b></a><br />
                                <div id='error_fname' class="error"></div></td>
                        </tr>
                        <tr>
                            
                            <td align="left" class="inner_grid">Last Name<span class='mandatory'>*</span>:</td>
                            <td align="left">
                                <INPUT class="text_field_new" type=text name="lname" id="lname"  value="<?=$data[0]['lname']
                                               ?>">
                                <div id='error_lname' class="error"></div></td>
                        </tr>
                        <tr>
                            
                            <td align="left" class="inner_grid">Phone Number<span class='mandatory'>*</span>:</td>
                            <td align="left">
                                <INPUT class="text_field_new" type=text name="phone" id="phone"  value="<?=$data[0]['phone']
                                               ?>">
                                <a  title="<?=PHONE_TEXT
                                           ?>" class="vtip" ><b><small>?</small></b></a></br>
                                <div id='error_phone' class="error"></div></td>
                        </tr>
                        <tr>
                            
                            <td align="left" class="inner_grid">Mobile Number<span class='mandatory'>*</span>:</td>
                            <td align="left">
                                <INPUT class="text_field_new" type=text name="mob" id="mob"  value="<?=$data[0]['mobile_phone']
                                               ?>">
                                <div id='error_mobile' class="error"></div></td>
                        </tr>
                    </table> </td></tr>
            
        </table>
       <table width="100%"><tr>
                <td width="48%"  align="center">
                <td width="52%"  align="left">	<INPUT  type="submit" value="Update User" class="button"  name="updateUser" id="updateUser"></td>			
            </tr></table>
    </form>
</div>
<span class='mandatory'>*These Fields Are Mandatory</span> 
</div>
<? include("footer.php"); ?>

</body>
</html>

