<?php
/*  File Name  : viewStore.php
 *  Description : view Store Form
 *  Author      : Deo  Date: 20th,Dec,2010  Creation
 */
header('Content-Type: text/html; charset=utf-8');
include_once("cumbari.php");
$storeObj = new store();
if (isset($_POST['continue'])) {
    //echo "In"; die();
    $storeObj->svrStoreDflt();
} else {
    $storeid = $_GET['storeId']; //die();
    $data = $storeObj->viewStoreDetailById($storeid);
//echo "<pre>";print_r($data);echo "</pre>";die();
}
$menu = "store";
$menu = 'class="selected"';
if ($_GET['m'] == "showOutdatedStore")
    $deleted = 'class="selected"';
else
    $show = 'class="selected"';
include_once("main.php");
?>
<link href="lib/grid/css/grid.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="client/js/jsStore.js" type="text/javascript"></script>
<body>
<div class="center">
<form name="editStore form" action="" id="registerform" method="POst">

    <div style="margin-top:15px;" ><h1><b>View Location</b></h1></div>


    <table BORDER=0  width="100%">
        <tr>
            <td colspan="3"><div align="center" class="bg_darkgray123">
            		Location Details
            </div></td>
        </tr>
        <tr>
            <td width="30%">&nbsp;</td>
            <td width="27%"><b>Location Name:</b></td>
        <td width="43%">
              <?=$data[0]['store_name']
?>            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><b>Email:</b></td>
            <td>
              <?=$data[0]['email'] ?>            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><b>Phone Number:</b></td>
            <td>
                <?=$data[0]['phone'] ?>            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><b>Street Address:</b></td>
            <td>
                <?=$data[0]['street'] ?>            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><b>City:</b></td>
            <td>
               <?=$data[0]['city'] ?>            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><b>Country:</b></td>
            <td>
                <?=$data[0]['country'] ?>            </td>
        </tr>
         <tr>
            <td>&nbsp;</td>
            <td><b>Chain:</b></td>
            <td><?  if($data[0]['chain'] != '')
            { echo $data[0]['chain'];}
            else
            { echo 'NULL';}
                ?>
               </td>
        </tr>
         <tr>
            <td>&nbsp;</td>
            <td><b>Block:</b></td>
            <td>
                <?  if($data[0]['block'] != '')
            { echo $data[0]['block'];}
            else
            { echo 'NULL';}
                ?>           </td>
        </tr>
        <!--<tr>
            <td>&nbsp;</td>
            <td><b>Coupon data:</b></td>
            <td><?=$data[0]['delivery_method']?>                
            </td>-->
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><b>Link:</b></td>
            <td>
                <?=$data[0]['store_link']
?>            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td valign="top"><b>Location on the map:</b></td>
<td><input type="hidden" name="longitude" value="<?=$data[0]['longitude']?>" id="longitude" /><br>
                <input type="hidden" name="latitude" value="<?=$data[0]['latitude']?>" id="latitude" />
                <img src="http://maps.google.com/maps/api/staticmap?center=<?=$data[0]['latitude']?>,<?=$data[0]['longitude']?>&zoom=16&size=256x256&maptype=roadmap&markers=color:red|<?=$data[0]['latitude']?>,<?=$data[0]['longitude']?>&sensor=false"></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td align="center"><div align="right">

                    <INPUT type="button" value="Back" name="" class="button" id="continue" onClick="javascript:location.href='<?=$_SERVER[HTTP_REFERER]
?>';" >
                </div></td>
            <td><p><br />
            				</p>
            		<p><br />
            				</p></td>
        </tr>
    </table>

</form>
</div>
<? include("footer.php"); ?>
</body>
</html>
