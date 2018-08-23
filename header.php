<?php
   ob_start();
   ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1" />
      <meta name="mobile-web-app-capable" content="yes" />
      <meta name="apple-mobile-web-app-capable" content="yes" />
      <meta name="msapplication-starturl" content="/" />
      <meta name="theme-color" content="#f48c5b" />

      <link rel="manifest" href="/manifest.json" />

      <title>Dastjar</title>
      <link href="client/css/stylesheet123.css" rel="stylesheet" type="text/css" />
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

    <link rel="icon" href="client/images/favicon.png">

      <script language="JavaScript" src="client/js/jquery.js" type="text/javascript"></script>
      <!--<script type="text/javascript" src="lib/vtip/js/vtip.js"></script>
         <link rel="stylesheet" type="text/css" href="lib/vtip/css/vtip.css" />-->
   </head>
   <body>
      <div id="container">
         <div style="float: right; font-size: 18px; right: 10px; position: absolute; right: 510px; padding-top: 5px; padding-right: 22px;"><a style="text-decoration:none" href="index.php" id="nevigation_color"></a></div>
         <div id="header">
            <div id="logo" align="center"><a href="index.php" ><img src="images/cmarkplatf.png" width="249" height="118"  /></a></div>
            <div id="nevi">
               <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                     <td height="72" colspan="4" align="right" style="font-size:14px; font-weight:bold;"><?php
                        //echo "userid".$_SESSION['userid'];
                        if (isset($_SESSION['username']))
                        {
                        echo "<b>Welcome ".$_SESSION['username']."</b>  ";
                        if($_SESSION['active_state']==5){
                        
                            if($_SESSION['userrole'] == 'Store Admin')
                            {
                            echo" | <a href='showStandard.php'>My Account </a>";
                            }if($_SESSION['userrole'] == 'Reseller')
                         {
                            echo" | <a href='showResellerCampaign.php'>My Account</a>";
                                }
                        
                            }
                            echo " | <a href='commonAction.php?act=logout'> LogOut </a>";
                        }
                        else
                        {
                        //echo "<a href='login.php'> Advertiser Sign In</a>";
                        }
                        
                        ?></td>
                     <td width="1%" height="72" align="center" style="font-size:14px; font-weight:bold;">&nbsp;</td>
                  </tr>
                  <tr>
                     <td width="38%" align="center" id="nevigation_color" >
                        <a href='login.php'>
                        </a>
                     </td>
                     <td width="18%" align="center" id="nevigation_color" >
                        <a href='loginReseller.php'>
                        </a>
                     </td>
                  </tr>
               </table>
            </div>
         </div>
      </div>
   </body>
</html>
