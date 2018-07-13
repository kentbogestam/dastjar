<?php
   /*  File Name  : registrationStep.php
   *  Description : To check the state of the user.
   *  Author      : Himanshu Singh  Date: 12th,Nov,2010  Creation
   */
   header('Content-Type: text/html; charset=utf-8');
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
<link rel="stylesheet" type="text/css" href="client/css/stylesheet123.css" />
<script type="text/javascript" src="lib/vtip/js/jquery.js"></script>
<script type="text/javascript" src="lib/vtip/js/vtip.js"></script>
<script type="text/javascript" src="client/js/jsRegistrationStep.js"></script>
<link rel="stylesheet" type="text/css" href="lib/vtip/css/vtip.css" />
<body>
   <div class="center">
      <div class="b_h_nhpx">
         <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
               <td colspan="2" bgcolor="#FFFFFF">&nbsp;</td>
            </tr>
            <tr>
               <td colspan="2" bgcolor="#FFFFFF"  class="redwhitebutton"  id="step1" onClick="javascript:window.location.href='registrationProcess.php'" value="Register">1 Register</td>
            </tr>
         </table>
         <div id="register" align="center" style="padding-top:10px; padding-bottom:10px;">
            <?php
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
         <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
               <td colspan="2" id="step2"  value="Add Company" onClick="javascript:window.location.href='addCompany.php'" class="register_inactive">2 Add Company</td>
            </tr>
         </table>
         <div id="company"  align="center" style="padding-top:10px; padding-bottom:10px;">
            <?php
               if (isset($_SESSION['MESSAGE']) && $_SESSION['REG_STEP'] == 2) {
                   echo $_SESSION['MESSAGE'];
                   $_SESSION['MESSAGE'] = '';
                   ?>
            <!--  <script>
               buttonLinkAction('<?=$_SESSION['REG_STEP']
                  ?>');
               </script> -->
            <?php
               }
               ?>
         </div>
         <?php if(!$_SESSION['Retailers']) { ?>
         <!--<table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td colspan="2" id="step3" value="Add Offer"  class="register_inactive">3 Add Offer</td>
            </tr>
            </table>-->
         <div id="offer_msg" style="display: none;">
            <?php
               if (isset($_SESSION['MESSAGE']) && ($_SESSION['REG_STEP'] == 3 || $_SESSION['REG_STEP'] == 4)) {
                   echo $_SESSION['MESSAGE'];
                   $_SESSION['MESSAGE'] = '';
                   ?>
            <!--  <script>
               buttonLinkAction('<?=$_SESSION['REG_STEP']
                  ?>');
               </script> -->
            <?php
               }
               ?>
         </div>
         <div id="offer" style="display:none">
            <div style=" padding:10px;">
               <!--<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="center"> <b>Would you like to add a time limited Campaign Offer?</b> <a title="<?=CAMPAIGN_TEXT
                     ?>" class="vtip"><b><small>( ? )</small></b></a></td>
                  </tr>
                  </table>-->
            </div>
            <!--<table width="100%" border="0">
               <tr>
                 <td style="padding-top:5px; text-align:center;" align="center" width="63%" id="step3" onClick="javascript:window.location.href='campaignOffer.php'" class="redwhitebutton_small">Add Campaign Offer</td>
               </tr>
               </table>-->
            <br>
            <div id="offer1" style="display: inline;">
               <?php
                  if (isset($_SESSION['MESSAGE']) && $_SESSION['REG_STEP'] == 3) {
                      echo "!!!!!!!!!!!!!!!";
                      echo $_SESSION['MESSAGE'];
                      $_SESSION['MESSAGE']='';
                      ?>
               <!--  <script>
                  buttonLinkAction('<?=$_SESSION['REG_STEP']
                     ?>');
                  </script> -->
               <?php
                  }
                  ?>
            </div>
            <div style=" padding:10px;">
               <!--<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="center"> <b>Would you like to add an Advertise Offer?</b> <a title="<?=ADVERTISE_TEXT?>" class="vtip"><b><small>( ? )</small></b></a></td>
                  </tr>
                  </table>-->
            </div>
            <!--<table width="100%" border="0">
               <tr>
                 <td style="padding-top:5px; text-align:center;" align="center" width="63%" id="step3" onClick="javascript:window.location.href='advertiseOffer.php'" class="redwhitebutton_small">Add Advertise Offer</td>
               </tr>
               </table>-->
            <br>
            <div id="offer4" style="display: inline;">
               <?php
                  if (isset($_SESSION['MESSAGE']) && $_SESSION['REG_STEP'] == 3) {
                      echo "!!!!!!!!!!!!!!!";
                      echo $_SESSION['MESSAGE'];
                      $_SESSION['MESSAGE']='';
                      ?>
               <!--  <script>
                  buttonLinkAction('<?=$_SESSION['REG_STEP']
                     ?>');
                  </script> -->
               <?php
                  }
                  ?>
            </div>
            <div>
               <!--      <table border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="center"><b>Would you like to add a Standard Offer based on a product or a Service?</b><a title="<?=STANDARD_TEXT
                     ?>" class="vtip"><b><small>( ? )</small></b></a></td>
                  </tr>
                  </table>-->
            </div>
            <br>
            <!--<table width="100%" border="0">
               <tr>
                 <td align="left" style="text-align:center; padding-top:5px;" width="63%" id="step4" onClick="javascript:window.location.href='standardOffer.php'" class="redwhitebutton_small">Add Standard Offer</td>
               </tr>
               </table>-->
            <div id="offer2" style="display: none;">
               <?php
                  if (isset($_SESSION['MESSAGE']) && $_SESSION['REG_STEP'] == 4) {
                      echo $_SESSION['MESSAGE'];
                      $_SESSION['MESSAGE'] = '';
                      ?>
               <!--  <script>
                  buttonLinkAction('<?=$_SESSION['REG_STEP']
                     ?>');
                  </script> -->
               <?php
                  }
                  ?>
            </div>
            <div style="width:200px;">
               <input class="button" type="submit"  id="thanks" value="No thanks I'll add a deal later!"  onClick="javascript:window.location.href='activation.php'">
            </div>
         </div>
         <div id="offer3" style="display:none">
            <h1>Congratulations!</h1>
            <h3>You have just added your first Dastjar offer.</h3>
            <!--<h4>Do you want to add one or more locations where deal is valid? </h4>-->
         </div>
         <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
            </tr>
            <!--      <tr>
               <td width="43%" id="step5"  onClick="javascript:window.location.href='createStore.php'" align="center" ><img src="images/addlocation.png" width="177" height="57"></td>
               <td width="57%" colspan="2" align="left" id="step7" style="padding-bottom:10px" onClick="javascript:window.location.href='inviteRetailers.php'"  ><img src="images/invite.png"></td>
               </tr>
               <tr>
               <td  >&nbsp;</td>
               <td colspan="2" align="left"><a id="step8" onClick="javascript:window.location.href='activation.php'" ><img src="images/addlcationlater.png" width="299" height="46" /></a></td>
               </tr>-->
            <tr>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
            </tr>
         </table>
         <?php }else { ?>
         <input type="hidden" id="step3" value=""/>
         <?php } ?>
         <div id="store" style="display: none;">
            <?
               if (isset($_SESSION['MESSAGE']) && $_SESSION['REG_STEP'] == 5) {
                   echo $_SESSION['MESSAGE'];
                   $_SESSION['MESSAGE'] = '';
               }
               ?>
         </div>
         <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
               <td colspan="2" id="step6" onClick="javascript:window.location.href='activation.php'" class="register_inactive" > 3 Activate</td>
            </tr>
            <tr>
               <td >&nbsp;</td>
               <td  align="left" >&nbsp;</td>
            </tr>
         </table>
         <div id="activation"> </div>
      </div>
   </div>
   <?php include("footer.php"); ?>
</body>
</html>
<script>
   buttonLinkAction(<?=$_SESSION['REG_STEP']
      ?>);
</script>
