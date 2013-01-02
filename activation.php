<?php
/* File Name   : activation.php
*  Description : activation Form
*  Author      : Deo
*  Date        : 4th,Dec,2010  Creation
*/
header('Content-Type: text/html; charset=ISO-8859-15');
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
          <td><?
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
                <tr>
                  <td >&nbsp;</td>
                </tr>
                <tr>
                  <td  class="redwhitebutton">3 Add Offer</td>
                </tr>
                <tr>
                  <td >&nbsp;</td>
                </tr>
                <tr>
                  <td  class="blackbutton">4 Activate</td>
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
                    <? echo $start_date; ?></td>
                  <td align="left" valign="top"><?  $d=$data['end_of_publishing'];
                                           $timeStamp = explode(" ",$d);
                                              $end_date = $timeStamp[0];?>
                    <? echo $end_date; ?></td>
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
                      <br /></td>
                    <td  >&nbsp;</td>
                  </tr>
                </table>
              </div>
            </form></td>
        </tr>
        <!--//FETCH RECORDS FROM CCODE TABLE// -->
        <?

                } elseif ($data['spons'] == 1) {

                    ?>
        <script language="JavaScript" src="client/js/jsActivation.js" type="text/javascript"></script>
        <form name="register" action="payment.php" id="registerform" method="Post">
          <input class="text_field_new" type="hidden" name="m" value="sponsoredCampaignActivate">
          <input class="text_field_new" type="hidden" name="action" value="loadAccountAct">
          <input class="text_field_new" type="hidden" name="userId" value="<?=$_SESSION['userid']?>">
          <table width="100%" border="0" >
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="redwhitebutton">1 Register</td>
  </tr>
  <tr>
    <td  width="100%">&nbsp;</td>
  </tr>
  <tr>
    <td class="redwhitebutton">2 Add Company</td>
  </tr>
  <tr>
    <td  width="100%">&nbsp;</td>
  </tr>
  <tr>
    <td class="redwhitebutton">3 Add Offer</td>
  </tr>
  <tr>
    <td  width="100%">&nbsp;</td>
  </tr>
  <tr>
    <td class="redgraybutton">4 Activate</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0"  >
<tr>
              <td class="blackbutton_small_2">Activate your Account</td>
            </tr>
          </table>
<table width="100%" BORDER="0" cellpadding="0" cellspacing="0">
<tr>
              <td width="51%"><table width="100%" BORDER=0 cellpadding="0" cellspacing="0" >
<tr>
                    <td width="40%" align="left" valign="top" class="td_pad_right">Load your account with(SEK)<span class='mandatory'>*</span>:</td>
<td width="45%" align="left" valign="top" class="td_pad_right"><INPUT class="text_field_new" type=text name="loadaccount" id ="loadaccount">
                      <div id='error_loadaccount' class="error"></div></td>
                    <td width="15%" align="left" valign="top"><img src="images/cards_visa.jpg" width="150" height="49"></td>
                </tr>
                  <tr>
                    <td colspan="3" align="center" style="padding:10px;"><b/>As you recieve coupons, the cost is deducted from a prepaid balance </td>
                  </tr>
                </table></td>
            </tr>
          </table>
<table width="100%" BORDER=0 cellpadding="0" cellspacing="0">
            <tr>
              <td width="100%" class="blackbutton_small_2">Set up a budget for your sponsored coupons</td>
            </tr>
</table>
<table width="100%" BORDER="0" cellpadding="0" cellspacing="0">
            <td width="49%"><table width="100%" cellpadding="0" cellspacing="0" >
                  <tr>
                    <td width="50%" align="left" valign="top" class="td_pad_left">Max cost per month:</td>
                    <td width="50%" align="left" valign="top" class="td_pad_right"><INPUT class="text_field_new" type=text name="maxcost" id ="maxcost">
                    <div id='error_maxcost' class="error"></div></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top" class="td_pad_left">Campaign Code<span class='mandatory'>*</span>:</td>
                    <td align="left" valign="top" class="td_pad_right"><INPUT class="text_field_new" type=text name="campcode" id ="campcode" value=""></td>
                  </tr>
                </table></td>
</table>
<div align="center">
            <table width="100%" BORDER=0 cellpadding="0" cellspacing="0">
              <tr>
                <td align="center" style="padding:10px;"><INPUT  type="submit" value="Activate" name="Activate" id="Activate" class="button"></td>
                <td  >&nbsp;</td>
              </tr>
            </table>
          </div>
        </form>
        <?

            }
        }
// Product Exist
        else if ($data['act_prod'] == 1) {
            if ($data['is_sponsored'] == 0) {

                ?>
        <form name="register" action="" id="registerform" method="Post">
          <table width="100%" border="0">
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td class="redwhitebutton">1 Register</td>
            </tr>
            <tr>
              <td  >&nbsp;</td>
            </tr>
            <tr>
              <td  class="redwhitebutton">2 Add Company</td>
            </tr>
            <tr>
              <td  >&nbsp;</td>
            </tr>
            <tr>
              <td  class="redwhitebutton">3 Add Offer</td>
            </tr>
            <tr>
              <td >&nbsp;</td>
            </tr>
            <tr>
              <td  class="blackbutton">4 Activate</td>
            </tr>
            <tr>
              <td  >&nbsp;</td>
            </tr>
          </table>
          <input class="text_field_new" type="hidden" name="m" value="unsponsoredStandardActivate">
          <p><b/>Your Standard Offer Starts on the following date.</p>
          <table width="100%" border="0">
            <tr  class='bg_lightgray'>
              <th>Category Icon</th>
              <th>Product Name</th>
              <th>Category</th>
              <th>Picture</th>
              <th>Start Date</th>
            </tr>
            <tr align="center">
              <td><img src="<?php echo $data['small_image'] ?>" height="30" width="30"/></td>
              <td><? echo $data['product_name']; ?></td>
              <td><? echo $data['lang']; ?></td>
              <td><img src="<?php echo $data['large_image'] ?>" height="30" width="30"/></td>
              <?  $d=$data['start_of_publishing'];
                    $timeStamp = explode(" ",$d);
                      $start_date = $timeStamp[0];?>
              <td><? echo $start_date; ?></td>
            </tr>
          </table>
          <table BORDER=0 width="100%">
            <tr >
              <td  width="27%">&nbsp;</td>
              <td align="center"  ><INPUT  type="submit" value="Activate" name="Activate" id="Activate" class="button"></td>
              <td  width="22%">&nbsp;</td>
            </tr>
            <tr>
              <td  width="27%">&nbsp;</td>
              <td align="center"  >&nbsp;</td>
              <td  width="22%">&nbsp;</td>
            </tr>
          </table>
        </form>
        <!--//FETCH RECORDS FROM CCODE TABLE// -->
        <?

            }
            elseif ($data['is_sponsored'] == 1) {

                ?>
        <script language="JavaScript" src="client/js/jsActivation.js" type="text/javascript"></script>
        <form name="register" action="payment.php" id="registerform" method="Post">
          <input class="text_field_new" type="hidden" name="m" value="sponsoredStandardActivate">
          <input class="text_field_new" type="hidden" name="action" value="loadAccountAct">
          <input class="text_field_new" type="hidden" name="userId" value="<?=$_SESSION['userid']?>">
          <table width="100%" border="0">
            <tr>
              <td>&nbsp;</td>
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
            <tr>
              <td >&nbsp;</td>
            </tr>
            <tr>
              <td  class="redwhitebutton">3 Add Offer</td>
            </tr>
            <tr>
              <td >&nbsp;</td>
            </tr>
            <tr>
              <td  class="blackbutton">4 Activate</td>
            </tr>
            <tr>
              <td >&nbsp;</td>
            </tr>
          </table>
          <table BORDER=0 width="100%" >
            <tr>
              <td width="100%" class="blackbutton_small">Activate your Account</td>
            </tr>
          </table>
          <table BORDER=0>
            <tr>
              <td width="25%">&nbsp;</td>
              <td width="58%">&nbsp;</td>
              <td width="40%">&nbsp;</td>
            </tr>
            <tr>
              <td width="25%">&nbsp;</td>
              <td width="58%"><table BORDER=0 >
                  <tr>
                    <td>Load your account with(SEK)<span class='mandatory'>*</span>:</td>
                    <td><INPUT class="text_field_new" type=text name="loadaccount" id ="loadaccount">
                    <div id='error_loadaccount' class="error"></div></td>
                    <td width="26%"><img src="images/cards_visa.jpg" width="150" height="49"></td>
                  </tr>
                  <tr>
                    <td colspan="2"><b/>As you recieve coupons, the cost is deducted from a prepaid balance</td>
                  </tr>
                </table></td>
              <td width="40%">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="3" class="blackbutton_small" style="padding-left:290px;">Set Your Budget For Your Sponsored Coupons</td>
            </tr>
            <tr>
              <td width="25%">&nbsp;</td>
              <td width="58%"><table BORDER=0 class="table">
                  <tr>
                    <td width="62%">Max cost per month<span class='mandatory'>*</span>:</td>
                    <td width="38%"><INPUT class="text_field_new" type=text name="maxcost" id ="maxcost">
                    <div id='error_maxcost' class="error"></div></td>
                  </tr>
                  <tr>
                    <td width="30%">Min cost per month<span class='mandatory'>*</span>:</td>
                    <td width="51%"><INPUT class="text_field_new" type=text name="mincost" id ="mincost">
                    <div id='error_mincost' class="error"></div></td>
                  </tr>
                </table></td>
              <td width="40%">&nbsp;</td>
            </tr>
          </table>
          <table BORDER=0 align="center">
            <tr>
              <td  width="27%">&nbsp;</td>
              <td width="51%" align="center"  ><INPUT   type="submit" value="Activate" name="Activate" id="Activate" class="button"></td>
              <td  width="22%">&nbsp;</td>
            </tr>
          </table>
        </form>
        <!--//FETCH RECORDS FROM CCODE TABLE// -->
        <?

            }
        }
//No Offer
        else {

            ?>
        <form name="register" action="" id="registerform" method="Post">
          <table width="100%" border="0">
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td class="redwhitebutton">1 Register</td>
            </tr>
            <tr>
              <td  >&nbsp;</td>
            </tr>
            <tr>
              <td class="redwhitebutton">2 Add Company</td>
            </tr>
            <tr>
              <td  >&nbsp;</td>
            </tr>
            <?php if(!$_SESSION['Retailers']) {?>
            <tr>
              <td class="redwhitebutton">3 Add Offer</td>
            </tr>
            <? } ?>
            <tr>
              <td  >&nbsp;</td>
            </tr>
            <tr>
              <td class="blackbutton">4 Activate</td>
            </tr>
            <tr>
              <td  >&nbsp;</td>
            </tr>
          </table>
          <input class="text_field_new" type="hidden" name="m" value="noOfferDetails">
          <table BORDER=0  width="100%">
            <tr>
              <td ></td>
              <td><div  style="  color: brown; text-align: center; font-size: 20px; font-weight: bold;"> Your Company has been added successfully updated.<br>
                  You can just click to activate your Account. </div></td>
              <td ></td>
            </tr>
          </table>
          <table width="100%" BORDER=0>
            <tr>
              <td  width="27%">&nbsp;</td>
              <td align="center" width="51%" ><INPUT   type="submit" value="Activate" name="Activate" id="Activate" class="button "></td>
              <td  width="22%">&nbsp;</td>
            </tr>
          </table>
        </form>
        <?

        }
        ?>
      </table>
    </div>
  </div>
</div>
<?php
    include("footer.php");
    ?>
