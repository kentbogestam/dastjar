<?php
   /* File Name   : activation.php
   *  Description : activation Form
   *  Author      : Deo
   *  Date        : 4th,Dec,2010  Creation
   */
   header('Content-Type: text/html; charset=utf-8');
   include_once("cumbari.php");
   $regObj = new registration();
   $activateObj = new activate();
   $afterActivationObj = new afterActivation();
   
   $regObj->isValidRegistrationStep();
   if (isset($_POST['Activate'])) {
       $afterActivationObj->svrActivationDflt();
   }
   $data = $activateObj->svrActivateDefault();
   include_once("header.php");
   //echo "<pre>"; print_r($data);echo "</pre>";
   ?>
<style type="text/css">
   <!--
      body, td, th {
        color: #000000;
      }
      .center {
        width:900px;
        margin-left:auto;
        margin-right:auto;
      }
      -->
</style>
<link rel="stylesheet" type="text/css" href="client/css/stylesheet123.css" />

<?php
   include("footer.php");
   ?>