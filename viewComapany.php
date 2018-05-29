<?php
   /*  File Name : addCompany.php
    *  Description : Add Company Form
    *  Author  :Himanshu Singh  Date: 12th,Nov,2010  Creation
    */
   header('Content-Type: text/html; charset=utf-8');
   include_once("cumbari.php");
   $menu = "account";
   $account = 'class="selected"';
   $companyshow= 'checked="checked"';
   include_once("main.php");
   $accountObj = new accountView();
   $data = $accountObj->getCompanyDetail();
   $stripePayment = $accountObj->stripePayment();
   //echo"<pre>";print_r($data);echo"</pre>";
   include_once("header.php");
   ?>
<?php include 'config/defines.php'; ?>
<style type="text/css">
   body { margin: 100px }
   a { }
   img { border: 0 }
</style>
<link href="lib/grid/css/grid.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="client/js/jsAddCompany.js" type="text/javascript"></script>
<body>
   <div class="center">
      <form name="register" action="" id="registerform" method="POst">
         <?php
            if ($_SESSION['MESSAGE']) {
                echo $_SESSION['MESSAGE'];
                $_SESSION['MESSAGE'] = "";
            }
            ?>
         <input type="hidden" name="m" value="savecomp">
         <div class="bg_darkgray123">
            Company Details
         </div>
         <table BORDER=0 width="100%" >
            <tr>
               <td colspan="3" align="center">
                  <a href="editCompany.php"><img src="client/images/edit.png" border="0"></a>            
               </td>
            </tr>
            <tr>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td width="23%">&nbsp;</td>
            </tr>
            <tr>
               <td width="29%">&nbsp;</td>
               <td width="29%">Country or Area for the Timezone:</td>
               <td width="42%" ><b/><?=$data[0]['tzcountries']
                  ?></td>
            </tr>
            <tr>
               <td>&nbsp;</td>
               <td>Timezone:</td>
               <td><b/><?=$data[0]['timezones']
                  ?></td>
            </tr>
            <tr>
               <td>&nbsp;</td>
               <td>Select a permanent currency for
                  <br>your account:
               </td>
               <td><b/><?=$data[0]['currencies']
                  ?></td>
            </tr>
            <tr>
               <td>&nbsp;</td>
               <td>Company Name:</td>
               <td><b/><?=$data[0]['company_name']
                  ?></td>
            </tr>
            <tr>
               <td>&nbsp;</td>
               <td>Organisation Code:</td>
               <td><b/><?=$data[0]['orgnr']
                  ?></td>
            </tr>
            <tr>
               <td>&nbsp;</td>
               <td>Street Address:</td>
               <td><b/><?=$data[0]['street']
                  ?></td>
            </tr>
            <tr>
               <td>&nbsp;</td>
               <td>City:</td>
               <td><b/><?=$data[0]['city']
                  ?></td>
            </tr>
            <tr>
               <td>&nbsp;</td>
               <td>Zip Code:</td>
               <td><b/><?=$data[0]['zip']
                  ?></td>
            </tr>
            <tr>
               <td>&nbsp;</td>
               <td>Country:</td>
               <td><b/><?=$data[0]['cname']
                  ?></td>
            </tr>
            <tr>
               <td>&nbsp;</td>
               <td>Stripe Payment:</td>
               <td><b/><?=
                        $stripePayment;
                     ?>
               </td>
            </tr>
            <tr>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
            </tr>
         </table>
      </form>
   </div>
   <? include("footer.php"); ?>
</body>
</html>