<?php
/*  File Name   : getReportView.php
 *   Description : Get values related to Campaigns.
 *   Author      : Himanshu Singh
 *   Date        : 6th,Dec,2010  Creation
 */
header('Content-Type: text/html; charset=utf-8');
include_once("cumbari.php");
$menu = "report";
$report = 'class="selected"';
$show = 'class="selected"';
include("main.php");
ob_start();
if ($_SESSION['userid']) {
    $reportObj = new reportView();
    $data = $reportObj->svrReportDflt();

    $dataAdvertise = $reportObj->getReportAdvertiseViewDetails();

    $data3 = $reportObj->getReportStandardViewDetails();

    $data2 = $reportObj->getReportStoreViewDetails();
	
	//print_r($data2);
	
	// $data4 = $reportObj->getReportsponserDetails();
	//    echo "<pre>";
	//    print_r($data4);
	//    echo "</pre>";
	//    die();
	//

} else {
    $_SESSION['MESSAGE'] = "Please Login";
    header("location:login.php");
}
?>
<html>
    <head>
    
        <link href="lib/grid/css/grid.css" rel="stylesheet" type="text/css" />
        <link href="client/css/stylesheet123.css" rel="stylesheet" type="text/css" />
        <script language="JavaScript" src="client/js/jsCampaignOffer.js" type="text/javascript"></script>
        <script>
            function divshowhide(val)
            {
                if(val == "standardoffer")
                {
                    document.getElementById('report_campaign').style.display = "none";
                    document.getElementById('report_standard').style.display = "block";
                    document.getElementById('report_location').style.display = "none";
                    document.getElementById('report_advertise').style.display = "none";
                }
                else if(val == "campaignoffer")
                {
                    document.getElementById('report_campaign').style.display = "block";
                    document.getElementById('report_standard').style.display = "none";
                    document.getElementById('report_location').style.display = "none";
                    document.getElementById('report_advertise').style.display = "none";
                }
                else if(val == "advertiseoffer")
                {
                    document.getElementById('report_campaign').style.display = "none";
                    document.getElementById('report_standard').style.display = "none";
                    document.getElementById('report_location').style.display = "none";
                    document.getElementById('report_advertise').style.display = "block";
                }
                else
                {
                    document.getElementById('report_campaign').style.display = "none";
                    document.getElementById('report_standard').style.display = "none";
                    document.getElementById('report_location').style.display = "block";
                    document.getElementById('report_advertise').style.display = "none";
                }
            }
        </script>
    </head>
    <body>
    <div class="center">
        <div align="left" style="color:#821a21; margin-top:20px;"><h2  >Report View</h2></div>
        <div align="left">
            <input type="radio" id="poBoxRadiostan" name="group1" value="standardoffer" onClick="divshowhide('standardoffer');"><b>Standard Offer</b>
            <input type="radio" id="poBoxRadiocam" name="group1" value="campaignoffer" onClick="divshowhide('campaignoffer');" checked><b>Campaign Offer</b>
            <input type="radio" id="poBoxRadioadvt" name="group1" value="advertiseoffer" onClick="divshowhide('advertiseoffer');" ><b>Advertise Offer</b>
            <input type="radio" id="poBoxRadioloc" name="group1" value="Location" onClick="divshowhide('Location');"> <b>Location</b>
        <br>
        <br>
        </div>

        <div  style="display: block; font-size:16px;" id="report_campaign" >
            <table border="0" width="100%" cellspacing="1"  bgcolor="#CCCCCC"    >
                <tr class="bg_darkgray1" bgcolor="#FFFFFF" >
                    <th>Serial No.</th>
                    <th>Campaign Name</th>
                    <th>Used Coupons</th>
                    <th>Distant</th>
                    <th>Viewed Coupons</th>
                    <th>Distant</th>
                    <th>Clicked Coupons</th>
                    <th>Distant</th>
                    <th>Published</th>
                </tr>
                <?php if (isset($data)) {
                ?>
                <?php
                    $i = 1;
                   
                    foreach ($data as $data1) {
                ?>
                        <tr bgcolor="#FFFFFF" >
                            <td><?php echo $i; ?></td>
                            <td><?php echo $data1['campaign_name']; ?></td>
                            <td><?php echo $data1['num_consumes']; ?></td>
                            <td><?php echo $data1['sum_consume_dist_to_store']; ?></td>
                            <td><?php echo $data1['num_views']; ?></td>
                            <td><?php echo $data1['sum_view_dist_to_store']; ?></td>
                            <td><?php echo $data1['num_loads']; ?></td>
                            <td><?php echo $data1['sum_load_dist_to_store']; ?></td>
                            <td><?php echo $data1['start_of_publishing']; ?></td>
                        </tr>
                <?
                        $i++;
                    }
                ?>
                <?php } else {
                ?>
                        <tr bgcolor="#FFFFFF">
                            <td colspan="9" bgcolor="#FFFFFF"><?php echo "No Records Found"; ?></td>
			    </tr>
                <?php } ?>
            </table>
    </div>

        <div style="display:none; font-size:16px;" id="report_standard">
            <table border="0" width="100%" cellspacing="1"  bgcolor="#CCCCCC"  >
                <tr class="bg_darkgray1" bgcolor="#FFFFFF">				
                    <th>Serial No.</th>
                    <th>Product Name</th>
                    <th>Viewed Coupons</th>
                    <th>Distant</th>
                    <th>Clicked Coupons</th>
                    <th>Distant</th>
                    <th>Published</th>
                </tr>
                <?php if (isset($data3)) {
                ?>

                <?php
                    $i = 1;
                    foreach ($data3 as $data1) {
                ?>
                       <tr bgcolor="#FFFFFF">
                            <td><?php echo $i; ?></td>
                            <td><?php echo $data1['product_name']; ?></td>
                            <td><?php echo $data1['num_views']; ?></td>
                            <td><?php echo $data1['sum_view_dist_to_store']; ?></td>
                            <td><?php echo $data1['num_loads']; ?></td>
                            <td><?php echo $data1['sum_load_dist_to_store']; ?></td>
                            <td><?php echo $data1['published']; ?></td>
                        </tr>
                <?
                        $i++;
                    }
                ?>
                <?php } else {
                ?>
                        <tr class="bg_darkgray1" bgcolor="#FFFFFF"> 
                            <td colspan="7"><?php echo "No Records Found"; ?></td>
                        </tr>
                <?php } ?>               
            </table>
        </div>

        <div style="display:none; font-size:16px;" id="report_advertise">
             <table border="0" width="100%" cellspacing="1"  bgcolor="#CCCCCC"    >
                <tr class="bg_darkgray1" bgcolor="#FFFFFF" >
                    <th>Serial No.</th>
                    <th>Ads Name</th>
                    <th>Viewed Coupons</th>
                    <th>Distant</th>
                    <th>Clicked Coupons</th>
                    <th>Distant</th>
                    <th>Published</th>
                </tr>
                <?php if (isset($dataAdvertise)) {
                ?>
                <?php
                    $i = 1;
                    foreach ($dataAdvertise as $data1) {
                ?>
                        <tr bgcolor="#FFFFFF" >
                            <td><?php echo $i; ?></td>
                            <td><?php echo $data1['advertise_name']; ?></td>
                            <td><?php echo $data1['num_views']; ?></td>
                            <td><?php echo $data1['sum_view_dist_to_store']; ?></td>
                            <td><?php echo $data1['num_loads']; ?></td>
                            <td><?php echo $data1['sum_load_dist_to_store']; ?></td>
                            <td><?php echo $data1['start_of_publishing']; ?></td>
                        </tr>
                <?
                        $i++;
                    }
                ?>
                <?php } else {
                ?>
                        <tr bgcolor="#FFFFFF">
                            <td colspan="7" bgcolor="#FFFFFF"><?php echo "No Records Found"; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>

        <div style="display:none; font-size:16px;" id="report_location">
            <table border="0" width="100%" cellspacing="1"  bgcolor="#CCCCCC"  >
                <tr class="bg_darkgray1" bgcolor="#FFFFFF">
                    <th>Serial No.</th>
                    <th>Location Name</th>
                    <th>Street</th>
                    <th>City</th>
                    <th>Country</th>
                    <th>Used Coupons</th>
                    <th>Viewed Coupons</th>
                    <th>Clicked Coupons</th>                   
                </tr>
                <?php if (isset($data2)) {
                ?>
                <?php
                    $i = 1;
                    foreach ($data2 as $data1) {
                         // Serial No, Location Name, Street, City, Country , Used Coupons, Viewed Coupons, Clicked Coupons 
                ?>
                        <tr bgcolor="#FFFFFF">
                            <td><?php echo $i; ?></td>
                            <td><?php echo $data1['store_name']; ?></td>
                            <td><?php echo $data1['street']; ?></td>
                            <td><?php echo $data1['city']; ?></td>
                            <td><?php echo $data1['country']; ?></td>
                            <td><?php echo $data1['num_consumes']; ?></td>
                            <td><?php echo $data1['num_views']; ?></td>
                            <td><?php echo $data1['num_loads']; ?></td>
                        </tr>
                <?
                        $i++;
                    }
                ?>
                <?php } else {
                ?>
                        <tr bgcolor="#FFFFFF"> 
                            <td colspan="8" bgcolor="#FFFFFF"><?php echo "No Records Found"; ?></td>
                    </tr>
                <?php } ?> 
            </table>
        </div>
    </div>
	   <? include("footer.php"); ?>
    </body>
</html>