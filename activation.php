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
<div class="center">
   <div id="main">
      <div id="mainbutton">
         <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
               <td>
                  <?
                     // Campaign Exist
                                         if ($data['act_camp'] == 1) {
                                             if ($data['spons'] == 0) {
                     
                                                 ?>
                  <form name="register" action="" id="registerform" method="Post">
                     <input type="hidden" name="m" value="unsponsoredCampaignActivate">
                     <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                           <td>&nbsp;</td>
                        </tr>
                        <tr>
                           <td >&nbsp;</td>
                        </tr>
                        <tr>
                           <td  class="redwhitebutton">1 Register</td>
                        </tr>
                        <tr>
                           <td >&nbsp;</td>
                        </tr>
                        <tr>
                           <td  class="redwhitebutton">2 Add Company</td>
                        </tr>
                        <!-- <tr>
                           <td >&nbsp;</td>
                        </tr>
                        <tr>
                           <td  class="redwhitebutton">3 Add Offer</td>
                        </tr> -->
                        <tr>
                           <td >&nbsp;</td>
                        </tr>
                        <tr>
                           <td  class="blackbutton">3 Activate</td>
                        </tr>
                        <tr>
                           <td  >&nbsp;</td>
                        </tr>
                        <tr>
                           <td colspan="3" align="center"><strong>Your Campaign Offer Starts and Ends on the following dates.</strong></td>
                        </tr>
                        <tr>
                           <td colspan="3" align="center">&nbsp;</td>
                        </tr>
                     </table>
                     <table width="100%" border="0" >
                        <tr class="bg_lightgray_2">
                           <th align="left">Icon</th>
                           <th align="left">Campaign Name</th>
                           <th align="left">Category</th>
                           <th align="left">Keyword</th>
                           <th align="left">Picture</th>
                           <th align="left">Start Date</th>
                           <th align="left">End Date</th>
                        </tr>
                        <tr align="center" class="bg_lightgray_2_txt">
                           <td align="left" valign="top"><img src="<?php echo $data['small_image'] ?>" height="30" width="30"/></td>
                           <td align="left" valign="top"><? echo $data['campaign_name']; ?></td>
                           <td align="left" valign="top"><? echo $data['text']; ?></td>
                           <td align="left" valign="top"><? echo $data['keyword']; ?></td>
                           <td align="left" valign="top"><img src="<?php echo $data['large_image'] ?>" height="30" width="30"/></td>
                           <td align="left" valign="top"><?  $d=$data['start_of_publishing'];
                              $timeStamp = explode(" ",$d);
                                $start_date = $timeStamp[0];?>
                              <? echo $start_date; ?>
                           </td>
                           <td align="left" valign="top"><?  $d=$data['end_of_publishing'];
                              $timeStamp = explode(" ",$d);
                                 $end_date = $timeStamp[0];?>
                              <? echo $end_date; ?>
                           </td>
                        </tr>
                     </table>
                     <div align="center">
                        <table BORDER=0 width="100%">
                           <tr>
                              <td  >&nbsp;</td>
                              <td align="center"  >&nbsp;</td>
                              <td  >&nbsp;</td>
                           </tr>
                           <tr>
                              <td width="15%"  >&nbsp;</td>
                              <td align="center"  ><INPUT  type="submit" value="Activate" name="Activate" id="Activate" class="button">
                                 <br />
                                 <br />
                              </td>
                              <td  >&nbsp;</td>
                           </tr>
                        </table>
                     </div>
                  </form>
               </td>
            </tr>
            <!--//FETCH RECORDS FROM CCODE TABLE// -->
            <?
               } elseif ($data['spons'] == 1) {
               
                   ?>
            <script language="JavaScript" src="client/js/jsActivation.js" type="text/javascript"></script>
           
         </table>
      </div>
   </div>
</div>
<?php
   include("footer.php");
   ?>