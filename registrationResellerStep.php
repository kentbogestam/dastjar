<html xmlns="http://www.w3.org/1999/xhtml">
<head><?php
/*  File Name  : registrationStep.php
*  Description : To check the state of the user.
*  
*/
header('Content-Type: text/html; charset=ISO-8859-15');
include_once("cumbari.php");
if (isset($_SESSION['msg'])) {

} else {
//header("Location:index.php");
}

if ($_GET['reg_step']) {
    $_SESSION['REG_STEP'] = $_GET['reg_step'];
}
include_once("header.php");
//echo $_SESSION["Retailers"];
?>




<script type="text/javascript" src="lib/vtip/js/jquery.js"></script>
<script type="text/javascript" src="lib/vtip/js/vtip.js"></script>
<script type="text/javascript" src="client/js/jsRegistrationResellerStep.js"></script>
<link rel="stylesheet" type="text/css" href="lib/vtip/css/vtip.css" /></head>

<div class="center">
<div align="center"   >
    <table width="100%">
        <tr>
            <td height="14" ></td>
            <td ></td>
        </tr>
        <tr>
            <td width="1%" >&nbsp;</td>
            <td  width="63%" class="redwhitebutton"  id="step1" onClick="javascript:window.location.href='registrationResellerProcess.php'" value="Register">1 Register</td>
        </tr>
    </table>

    <br><br>
    <div id="register" align="center"  >
        <?
        if (isset($_SESSION['MESSAGE']) && $_SESSION['REG_STEP'] == 8) {
            echo $_SESSION['MESSAGE'];
            $_SESSION['MESSAGE'] = '';
        }
        if (isset($_SESSION['MESSAGE']) && $_SESSION['REG_STEP'] == 1) {
            echo $_SESSION['MESSAGE'];
            $_SESSION['MESSAGE'] = '';
        }
        ?>
    </div>
    

    
	 <table width="100%" style="display:none">
        <tr>
            <td width="1%" >&nbsp;</td>
            <td width="63%"id="step2"  value="Add Company" onClick="javascript:window.location.href='addCompany.php'" class="register_inactive">2 Add Company</td>

        </tr>
    </table>
	
	
	
	
	
	
	
	<br>
    <br>
    <div id="company"  align="center">
        <?
        if (isset($_SESSION['MESSAGE']) && $_SESSION['REG_STEP'] == 2) {
            echo $_SESSION['MESSAGE'];
            $_SESSION['MESSAGE'] = '';
            ?>
    <!--  <script>
    buttonLinkAction('<?=$_SESSION['REG_STEP']
                    ?>');
    </script> -->
            <?
        }
        ?>

    </div>
    
    <?php if(!$_SESSION['Retailers']) {?>
    <table width="100%">
        <tr>
            <td width="1%" >&nbsp;</td>
            <td width="63%"id="step3" value="Add Offer"  class="register_inactive" align="left">2 Add Offer</td>

        </tr>
    </table>


    <div id="offer_msg" style="display: none;  ">

            <?
            if (isset($_SESSION['MESSAGE']) && ($_SESSION['REG_STEP'] == 3 || $_SESSION['REG_STEP'] == 4)) {
                echo $_SESSION['MESSAGE'];
                $_SESSION['MESSAGE'] = '';
                ?>
<!--  <script>
buttonLinkAction('<?=$_SESSION['REG_STEP']
                        ?>');
</script> -->
                <?
            }
            ?>
    </div>
    <div id="offer" style="display: none; ">
        <div style=" "><b>Would you like to add a time limited Campaign Offer?</b> <a title="<?=CAMPAIGN_TEXT
                                                                                                  ?>" class="vtip"><b><small>( ? )</small></b></a></br></div><br>
        <table width="100%" border="0">
            <tr>
               
                <td style="padding-top:5px;" align="left" width="63%" id="step3" onClick="javascript:window.location.href='campaignResellerOffer.php'" class="redwhitebutton_small">Add Campaign Offer</td>

            </tr>
        </table>

        <br>

        <div id="offer1" style="display: inline;">
                <?
                if (isset($_SESSION['MESSAGE']) && $_SESSION['REG_STEP'] == 3) {
                    echo "!!!!!!!!!!!!!!!";
                    echo $_SESSION['MESSAGE'];
                    $_SESSION['MESSAGE']='';
                    ?>
        <!--  <script>
        buttonLinkAction('<?=$_SESSION['REG_STEP']
                            ?>');
        </script> -->
                    <?
                }
                ?>
        </div>
                             <!-- hiding standard in registration for reseller case -->
     <!--   <div ><b>Would you like to add a Standard Offer based on a product or a Service?</b><a title="<?=STANDARD_TEXT
                                                                                                           ?>" class="vtip"><b><small>( ? )</small></b></a></div><br>
        <table width="100%" border="0">
            <tr>
                
                <td align="left" style="padding-left:350px; padding-top:5px;" width="63%" id="step4" onClick="javascript:window.location.href='standardResellerOffer.php'" class="redwhitebutton_small">Add Standard Offer</td>

            </tr>
        </table>-->
  <input type="hidden" id="step4" value=""/>
        <div id="offer2" style="display: none;">
                <?
                if (isset($_SESSION['MESSAGE']) && $_SESSION['REG_STEP'] == 4) {
                    echo $_SESSION['MESSAGE'];
                    $_SESSION['MESSAGE'] = '';
                    ?>
        <!--  <script>
        buttonLinkAction('<?=$_SESSION['REG_STEP']
                            ?>');
        </script> -->
                    <?
                }
                ?>
        </div>
        <div style=" display:none;width:200px;">

            <INPUT class="button" type="submit"  id="thanks" value="No thanks I'll add a deal later!"  onClick="javascript:window.location.href='activation.php'">
        </div>
    </div>
    <div id="offer3" style="display:none">
        <h1>Congratulations!</h1>
        <h3>You have just added your first cumbari offer.</h3>
       <h4>Do you want to add one or more locations where deal is valid? </h4>

    </div>
    <!--
    <table width="100%">
    <tr>
    <td width="1%" >&nbsp;</td>
    <td width="63%"  onClick="javascript:window.location.href='createStore.php'" align="left" class="register_inactive">Add Store</td>
    </tr>
    <tr>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    </tr>
    <tr>
    <td colspan="2" style="  font-size: 23px; background-position:center; padding-left:230px;" id="step7" onClick="javascript:window.location.href='inviteRetailers.php'" class="register_inactive" >Invite Retailers to Add their Locations</td>
    </tr>
    <tr>
    <td >&nbsp;</td>
    <td   ></td>
    </tr>
    </table>-->
    <table width="100%" border="0">
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>

            <td width="43%" id="step5"></td>
            <td width="57%" colspan="2" id="step7" onClick="javascript:window.location.href='inviteResellerRetailers.php'"  ><img src="images/invite.png"></td>
        </tr>
       
        <tr>
            <td  >&nbsp;</td>
            <td colspan="2"><a id="step8" onClick="javascript:window.location.href='resellerActivation.php'" ><img src="images/addlcationlater.png" width="299" height="46" /></a></td>
        </tr>
    </table>
        <?}?>
        
   
    <div id="store" style="display: none;">
        <?
        if (isset($_SESSION['MESSAGE']) && $_SESSION['REG_STEP'] == 5) {
            echo $_SESSION['MESSAGE'];
            $_SESSION['MESSAGE'] = '';
        }
        ?>
    </div>
    
    <table width="100%" border="0">
        <tr>
            <td width="1%" >&nbsp;</td>
            <td width="63%"  id="step6" align="left" onClick="javascript:window.location.href='resellerActivation.php'" class="register_inactive" > 3 Activate</td>
        </tr>
        <tr>
            <td >&nbsp;</td>
            <td  align="left" >&nbsp;</td>
        </tr>
    </table>

    <div id="activation">
    </div>
</div></div>
<div><? include("footer.php"); ?></div>
</body>
</html>

<script>
    buttonLinkAction(<?=$_SESSION['REG_STEP']?>);
</script>
