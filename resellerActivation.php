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

if (isset($_POST['Activate'])) {
    $afterActivationObj->svrActivationDflt();
}
$data = $activateObj->svrActivateDefault();
include_once("header.php");
?><style type="text/css">
/*
    .center{width:900px; margin-left:auto; margin-right:auto;}
*/
</style>
<div class="center">
<div id="main">
    <div id="mainbutton">
        <table width="100%">
            <tr>
                <td>&nbsp;</td>
                <td>
                    <?
// Campaign Exist
                    if ($data['act_camp'] == 1) {
                        if ($data['spons'] == 0) {

                            ?>
                    <form name="register" action="" id="registerform" method="Post">
                        <input type="hidden" name="m" value="unsponsoredCampaignActivate">
                         <input class="text_field_new" type="hidden" name="reseller" value="reseller">

                        <table width="100%" border="0">
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
                                <td >&nbsp;</td>
                            </tr>
                            <tr>

                                <td  class="redwhitebutton">2 Add Offer</td>
                            </tr>
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
                            <tr  class='bg_lightgray'  >
                                <th>Icon</th>
                                <th>Campaign Name</th>
                                <th>Category</th>
                                <th>Keyword</th>
                                <th>Picture</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                            </tr>
                            <tr align="center">
                                <td align="center"><img src="<?php echo $data['small_image'] ?>" height="30" width="30"/></td>
                                <td align="center"><? echo $data['campaign_name']; ?></td>
                                <td align="center"><? echo $data['text']; ?></td>
                                <td align="center"><? echo $data['keyword']; ?></td>
                                <td align="center"><img src="<?php echo $data['large_image'] ?>" height="30" width="30"/></td>
                                <td align="center">
                                            <?  $d=$data['start_of_publishing'];
                                            $timeStamp = explode(" ",$d);
                                              $start_date = $timeStamp[0];?>
                                            <? echo $start_date; ?></td>
                                <td align="center">
                                            <?  $d=$data['end_of_publishing'];
                                           $timeStamp = explode(" ",$d);
                                              $end_date = $timeStamp[0];?>
                                            <? echo $end_date; ?></td>
                            </tr>
                        </table>
                        <div align="center"><table BORDER=0 width="100%">
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
            <!--<script language="JavaScript" src="client/js/jsActivation.js" type="text/javascript"></script>-->
            <form name="register" action="" id="registerform" method="Post">
                        <input type="hidden" name="m" value="unsponsoredCampaignActivate">
                         <input class="text_field_new" type="hidden" name="reseller" value="reseller">

                        <table width="100%" border="0">
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
                                <td >&nbsp;</td>
                            </tr>
                            <tr>

                                <td  class="redwhitebutton">2 Add Offer</td>
                            </tr>
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
                            <tr  class='bg_lightgray'  >
                                <th>Icon</th>
                                <th>Campaign Name</th>
                                <th>Category</th>
                                <th>Keyword</th>
                                <th>Picture</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                            </tr>
                            <tr align="center">
                                <td align="center"><img src="<?php echo $data['small_image'] ?>" height="30" width="30"/></td>
                                <td align="center"><? echo $data['campaign_name']; ?></td>
                                <td align="center"><? echo $data['text']; ?></td>
                                <td align="center"><? echo $data['keyword']; ?></td>
                                <td align="center"><img src="<?php echo $data['large_image'] ?>" height="30" width="30"/></td>
                                <td align="center">
                                            <?  $d=$data['start_of_publishing'];
                                            $timeStamp = explode(" ",$d);
                                              $start_date = $timeStamp[0];?>
                                            <? echo $start_date; ?></td>
                                <td align="center">
                                            <?  $d=$data['end_of_publishing'];
                                           $timeStamp = explode(" ",$d);
                                              $end_date = $timeStamp[0];?>
                                            <? echo $end_date; ?></td>
                            </tr>
                        </table>
                        <div align="center"><table BORDER=0 width="100%">
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

                    <td  >&nbsp;</td>

                </tr>

                <tr>

                    <td  class="redwhitebutton">2 Add Offer</td>

                </tr>
                <tr>

                    <td >&nbsp;</td>

                </tr>
                <tr>

                    <td  class="blackbutton">3 Activate</td>

                </tr>
                <tr>

                    <td  >&nbsp;</td>

                </tr>

            </table>
            <input class="text_field_new" type="hidden" name="m" value="unsponsoredStandardActivate">
             <input class="text_field_new" type="hidden" name="reseller" value="reseller">
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
        <!--<script language="JavaScript" src="client/js/jsActivation.js" type="text/javascript"></script>-->
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

                    <td  >&nbsp;</td>

                </tr>

                <tr>

                    <td  class="redwhitebutton">2 Add Offer</td>

                </tr>
                <tr>

                    <td >&nbsp;</td>

                </tr>
                <tr>

                    <td  class="blackbutton">3 Activate</td>

                </tr>
                <tr>

                    <td  >&nbsp;</td>

                </tr>

            </table>
            <input class="text_field_new" type="hidden" name="m" value="unsponsoredStandardActivate">
             <input class="text_field_new" type="hidden" name="reseller" value="reseller">
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

                    <td  >&nbsp;</td>

                </tr>
                <tr>

                    <td class="redwhitebutton">2 Add Offer</td>

                </tr>
                <tr>

                    <td  >&nbsp;</td>

                </tr>
                <tr>

                    <td class="blackbutton">3 Activate</td>

                </tr>
                <tr>

                    <td  >&nbsp;</td>

                </tr>
            </table>
            <input class="text_field_new" type="hidden" name="m" value="noOfferDetails">
            <input class="text_field_new" type="hidden" name="reseller" value="reseller">
           
            <table BORDER=0  width="100%">
                <tr>
                    <td ></td>
                    <td>
                        <div  style="  color: brown; text-align: center; font-size: 20px; font-weight: bold;">
                               You can just click to activate your Account.
                        </div>
                    </td>
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
</body>
</html>