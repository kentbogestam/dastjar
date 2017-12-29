<?php
   /* File Name   : addCompany.php
    *  Description : Add Company Form
    *  Author      : Himanshu Singh  Date: 12th,Nov,2010  Creation
    */
   ob_start();
   //$_SESSION['REG_STEP'] = 2;
   header('Content-Type: text/html; charset=utf-8');
   include_once("cumbari.php");
   $inoutObj = new inOut();
   //$inoutObj->validSteps();
   $regObj = new registration();
   $regObj->isValidRegistrationStep();
   $countryList = $regObj->getCountryList();
   if ($_POST['addCompany']) {
       $regObj->svrRegDflt();
   }
   include_once("header.php");
   ?>
<?php include 'config/defines.php'; ?>
<?php
   if($_SESSION['MESSAGE']) {
       echo $_SESSION['MESSAGE'];
       $_SESSION['MESSAGE']="";
   }
   ?>
<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
      <script type="text/javascript" src="lib/vtip/js/jquery.js"></script>
      <script type="text/javascript" src="lib/vtip/js/vtip.js"></script>
      <link rel="stylesheet" type="text/css" href="lib/vtip/css/vtip.css" />
      <script language="JavaScript" src="client/js/jsAddCompany.js" type="text/javascript"></script>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <style type="text/css">
         <!--
            body,td,th {
                .center{width:900px; margin-left:auto; margin-right:auto;}
            
            }
            -->
      </style>
   </head>
   <body>
      <div class="center">
         <div id="main_color">
            <div id="singbutton_portion"></div>
            <div id="mainbutton">
               <table width="100%" cellspacing="2" border="0" >
                  <tr>
                     <td>&nbsp;</td>
                  </tr>
                  <tr>
                     <td width="54%" class="redwhitebutton">1 Register</td>
                  </tr>
                  <tr>
                     <td >&nbsp;</td>
                  </tr>
                  <tr>
                     <td class="blackbutton">2 Add Company</td>
                  </tr>
                  <tr>
                     <td valign="top" >
                        <form name="register" action="" id="registerform" method="POst">
                           <input type="hidden" name="m" value="savecomp">
                           <input type="hidden" name="checkResult" id="checkResult" value="yes"/>
                           <table BORDER=0 width="100%" cellspacing="10">
                              <tr style="display:none;">
                                 <th align="left" width="50%"> Time Zone</th>
                                 <th align="left" width="50%">&nbsp;</th>
                              </tr>
                              <tr style="display:none;">
                                 <td align="left">Select a Country </td>
                                 <td>
                                    <select class="text_field_new" style="background-color:#e4e3dd; width:406px; height:36px;border: 1px solid #abadb3;"  tabindex="27" id="areatimezone" name="areatimezone">
                                       <option value="SE">Sweden</option>
                                       <option value="DE">Germany</option>
                                    </select>
                                 </td>
                              </tr>
                              <tr>
                                 <td align="left">Select a Timezone</td>
                                 <td>
                                    <select class="text_field_new" style="background-color:#e4e3dd; width:406px; height:36px;border: 1px solid #abadb3;" tabindex="27" id="timezone" name="timezone">
                                       <option value="Europe/Stockholm">(GMT+01:00) Stockholm</option>
                                       <option value="Europe/Berlin">(GMT+01:00) Berlin</option>
                                    </select>
                                 </td>
                              </tr>
                              <tr>
                                 <td height="42" align="left">Select a Currency                </td>
                                 <td>
                                    <select class="text_field_new" style="background-color:#e4e3dd; width:406px; height:36px;border: 1px solid #abadb3;" tabindex="27" id="currency" name="currency">
                                       <option value="SEK">svensk krona (SEK kr)</option>
                                       <option value="EUR">euro (EUR)</option>
                                    </select>
                                 </td>
                              </tr>
                             <!--  <tr>
                                 <td height="42" align="left">Type of Restaurant                </td>
                                 <td>
                                    <select class="text_field_new" style="background-color:#e4e3dd; width:406px; height:36px;border: 1px solid #abadb3;" tabindex="27" id="typeofrestrurant" name="typeofrestrurant">
                                       <option value="1">Eat Now</option>
                                       <option value="2">Eat Later</option>
                                       <option value="3">Both</option>
                                    </select>
                                 </td>
                              </tr> -->
                              <tr>
                                 <td align="left">Company Name<span class='mandatory'>*</span></td>
                                 <td>
                                    <INPUT class="text_field_new" type=text name="compname" id ="compname">
                                    <a title="<?=CNAME_TEXT ?>" class="vtip" ><b><small>?</small></b></a>
                                    <div id='error_compname' class="error"></div>
                                 </td>
                              </tr>
                              <tr>
                                 <td align="left">Organisation Code<span class='mandatory'>*</span></td>
                                 <td>
                                    <INPUT class="text_field_new" type=text name="orgcode" id ="orgcode" onBlur="checkOrganExist();">
                                    <a title="<?=OCODE_TEXT ?>" class="vtip" ><b><small>?</small></b></a>
                                    <div id='error_orgcode' class="error"></div>
                                 </td>
                              </tr>
                              <tr style="display:none;">
                                 <td align="left">Account Low Alert Level</td>
                                 <td>
                                    <INPUT class="text_field_new" type=text name="lowLevel" id ="lowLevel" value="50"/>
                                    <a title="<?=LOWLEVEL_TEXT ?>" class="vtip" ><b><small>?</small></b></a>
                                    <div id='error_lowlevel' class="error"></div>
                                 </td>
                              </tr>
                              <tr>
                                 <td align="left">Street Address<span class='mandatory'>*</span></td>
                                 <td>
                                    <INPUT class="text_field_new" type=text name="streetadd" id ="streetadd">
                                    <a title="<?=SADD_TEXT ?>" class="vtip" ><b><small>?</small></b></a>
                                    <div id='error_streetadd' class="error"></div>
                                 </td>
                              </tr>
                              <tr>
                                 <td align="left">City<span class='mandatory'>*</span></td>
                                 <td>
                                    <INPUT class="text_field_new" type=text name="city" id ="city">
                                    <a title="<?=CITYNAME_TEXT ?>" class="vtip" ><b><small>?</small></b></a>
                                    <div id='error_city' class="error"></div>
                                 </td>
                              </tr>
                              <tr>
                                 <td align="left">Zip Code<span class='mandatory'>*</span></td>
                                 <td>
                                    <INPUT class="text_field_new" type=text name="zipcode" id ="zipcode">
                                    <a title="<?=ZCODE_TEXT ?>" class="vtip" ><b><small>?</small></b></a>
                                    <div id='error_zipcode' class="error"></div>
                                 </td>
                              </tr>
                              <tr>
                                 <td align="left">Country<span class='mandatory'>*</span></td>
                                 <td>
                                    <select class="text_field_new" style="width:406px; background-color:#e4e3dd;"  tabindex="27" id="country" name="country">
                                       <option value="">Select</option>
                                       <?php
                                          $countryCode=$_SESSION['post']['country'];
                                          if(empty($countryCode))
                                          {
                                            $countryCode='DE';
                                          }
                                          
                                          foreach($countryList as $key=>$value)
                                          {
                                          ?>
                                       <option value="<?=$key?>" <?php if($countryCode==$key){ echo 'selected=selected'; } ?>><?=$value?></option>
                                       <?php
                                          }
                                          ?>
                                    </select>
                                    <a title="<?=COUNTRY_TEXT ?>" class="vtip" ><b><small>?</small></b></a>
                                    <div id='error_country' class="error"></div>
                                 </td>
                              </tr>
                              <tr>
                                 <td align="left">&nbsp;</td>
                                 <td align="left">&nbsp;</td>
                              </tr>
                              <tr>
                                 <td align="left">&nbsp;</td>
                                 <td align="left"><input style="margin-left:150px;"  type="submit" value="Submit your company information"  name="addCompany" class="button_another" id="addCompany"></td>
                              </tr>
                              <tr>
                                 <td align="left">&nbsp;</td>
                                 <td align="left">&nbsp;</td>
                              </tr>
                              <tr>
                                 <td height="15" colspan='3' align="left" ><span class='mandatory'>* These Fields Are Mandatory</span></td>
                              </tr>
                           </table>
                        </form>
                     </td>
                  </tr>
                  <!--<tr>
                     <td align="left" class="redgraybutton">3 Add Offer</td>
                     </tr>-->
                  <tr>
                     <td >&nbsp;</td>
                  </tr>
                  <tr>
                     <td align="left" class="redgraybutton">4 Activate</td>
                  </tr>
                  <tr>
                     <td>&nbsp;</td>
                  </tr>
               </table>
            </div>
         </div>
      </div>
      <? include("footer.php"); ?>
   </body>
</html>