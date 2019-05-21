<?php
   /* File Name   : editCompany.php
    *  Description : Edit Company Form
    *  Author      : Himanshu Singh  Date: 12th,Nov,2010  Creation
    */
   header('Content-Type: text/html; charset=utf-8');
   include_once("cumbari.php");
   //$menu = "account";
   //$account = 'class="selected"';
   //$show= 'class="selected"';
   include_once("main.php");
   $regObj = new registration();
   $accountObj = new accountView();
   $data = $accountObj->getCompanyDetail();
   $stripePayment = $accountObj->stripePayment();
   $data1 = $data[0];
   //print_r($data1);
   $countryList = $regObj->getCountryList();
   if (isset($_POST['addCompany'])) {
       $accountObj->saveUpdateCompanyDetails();
   }
   include_once("header.php");
   ?>
<?php include 'config/defines.php'; ?>
<script type="text/javascript" src="lib/?/js/jquery.js"></script>
<script type="text/javascript" src="lib/?/js/vtip.js"></script>
<link rel="stylesheet" type="text/css" href="lib/?/css/vtip.css" />
<style type="text/css">
   body {  }
   a { }
   img { border: 0 }
   .center{width:900px; margin-left:auto; margin-right:auto;}
   .td td{ padding-top:5px; padding-bottom:5px;}
</style>
<script language="JavaScript" src="client/js/jsUpdateCompany.js" type="text/javascript"></script>
<center style="margin-top: 10px;">
   <?php
           if($_SESSION['MESSAGE']) {
            echo $_SESSION['MESSAGE'];
           $_SESSION['MESSAGE']="";
            }
       ?>
    </center>
<div class="center">
   <form name="register" action="" id="registerform" method="Post">
      <div style="margin-top:20px">
         <table width="100%" border="0">
            <tr>
               <td align="center" class="redwhitebutton">Update Your Company</td>
            </tr>
         </table>
      </div>
      <input type="hidden" name="m" value="savecomp">
      <input type="hidden" name="companyId" value="<?=$data1['company_id'] ?>">
      <table width="100%" border="0">
         <tr>
            <td>
               <div class="td">
                  <table width="100%" BORDER=0 >
                     <tr>
                        <td width="49%" height="45" align="left" valign="bottom" class="inner_grid">Select a Country</td>
                        <td width="51%" colspan="3" align="left" valign="bottom">
                           <select class="text_field_new"  style="width:426px; background-color:#e4e3dd; border: 1px solid #abadb3" tabindex="27" id="areatimezone" name="areatimezone">
                              <option <?
                                 if ($data1['tzcountries'] == "SE") {
                                     echo 'selected = "selected"';
                                 }
                                 ?> value="SE">Sweden</option>
                           </select>
                        </td>
                     </tr>
                     <tr>
                        <td align="left" class="inner_grid">Timezone</td>
                        <td colspan="3" align="left">
                           <select  style="width:426px; background-color:#e4e3dd; border: 1px solid #abadb3" class="text_field_new" tabindex="27" id="timezone" name="timezone">
                              <option <?
                                 if ($data1['timezones'] == "Europe/Stockholm") {
                                     echo 'selected = "selected"';
                                 }
                                 ?> value="Europe/Stockholm">(GMT+01:00) Stockholm</option>
                           </select>
                        </td>
                     </tr>
                     <tr>
                        <td align="left" class="inner_grid">Select a Currency               </td>
                        <td colspan="3" align="left">
                           <select style="width:426px; background-color:#e4e3dd; border: 1px solid #abadb3" class="text_field_new" tabindex="27" id="currency" name="currency">
                              <option <?
                                 if ($data1['currencies'] == "SEK") {
                                     echo 'selected = "selected"';
                                 } ?> value="SEK">Svensk krona (SEK kr)</option>
                              <option <?
                                 if ($data1['currencies'] == "DOL") {
                                     echo 'selected = "selected"';
                                 }
                                 ?> value="DOL">Dollar</option>
                              <option <?
                                 if ($data1['currencies'] == "RUP") {
                                     echo 'selected = "selected"';
                                 }
                                 ?> value="RUP">Ruppees</option>
                           </select>
                        </td>
                     </tr>
                     <tr>
                        <td align="left" class="inner_grid">Company Name</td>
                        <td colspan="3" align="left">
                           <?=$data1['company_name']
                              ?>                    
                        </td>
                     </tr>
                     <tr>
                        <td align="left" class="inner_grid">Organisation Code<span class='mandatory'>*</span></td>
                        <td colspan="3" align="left">
                           <INPUT class="text_field_new" type=text name="orgcode" id ="orgcode" style="width:420px;" value="<?=$data1['orgnr']
                              ?>">
                           <div id='error_orgcode' class="error"></div>
                        </td>
                     </tr>
                     <tr>
                        <td align="left" class="inner_grid">Street Address<span class='mandatory'>*</span></td>
                        <td colspan="3" align="left">
                           <INPUT class="text_field_new" type=text name="streetadd" id ="streetadd" style="width:420px;" value="<?=$data1['street']
                              ?>">
                           <div id='error_streetadd' class="error"></div>
                        </td>
                     </tr>
                     <tr>
                        <td align="left" class="inner_grid">City<span class='mandatory'>*</span></td>
                        <td colspan="3" align="left">
                           <INPUT  class="text_field_new" type=text name="city" style="width:420px;" id ="city" value="<?=$data1['city']
                              ?>">
                           <div id='error_city' class="error"></div>
                        </td>
                     </tr>
                     <tr>
                        <td align="left" class="inner_grid">Zip Code<span class='mandatory'>*</span></td>
                        <td align="left">
                           <INPUT class="text_field_new" type=text name="zipcode" style="width:420px;" id ="zipcode" value="<?=$data1['zip']
                              ?>">
                           <div id='error_zipcode' class="error"></div>
                        </td>
                        <td align="right" valign="top"><a  title="<?=ZCODE_TEXT
                           ?>" class="vtip" ><b><small>?</small></b></a></td>
                     </tr>
                     <tr>
                        <td align="left">Country<span class='mandatory'>*</span></td>
                        <td colspan="3" align="left">
                           <select class="text_field_new" style="width:426px; background-color:#e4e3dd;"  tabindex="27" id="country" name="country" >
                              <option value="">Select</option>
                              <?php 
                                 $countryCode = $data1['ciso'];
                                 if(empty($countryCode))
                                 {
                                    $countryCode='SE';
                                 }
                                 
                                 foreach($countryList as $key=>$value)
                                 {
                                                                                   
                                 ?>
                              <option value="<?=$key?>" <?php if($countryCode==$key){ echo 'selected=selected'; } ?>><?=$value?></option>
                              <?php
                                 }
                                 ?>
                           </select>
                           <div id='error_country' class="error"></div>
                        </td>
                     </tr>
                     <tr>
                        <td align="left">&nbsp;</td>
                        <td align="left"><div align="center" class="main_bg"><a href="reDirectStripEditCompany.php"><strong>Add Payment</strong></a></div><input style="margin-left:45px;"  type="submit" value="Submit your company information"  name="addCompany" class="button_another" id="addCompany"></td>
						
                     </tr>

                     <tr>
                        <td COLSPAN='5' align="center"><br />
                           <br />
                        </td>
                     </tr>
                  </table>
               </div>
            </td>
         </tr>
      </table>
   </form>
   <span class='mandatory'>* These Fields Are Mandatory</span>
</div>
<div><? include("footer.php"); ?></div>
</body>
</html>


<style type="text/css">
   .main_bg{
       display: inline-block;border-radius: 100px;
       padding: 6px 12px;
       vertical-align: middle;line-height: 24px;
    }
</style>