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
<style>
    .planeButton,.direct-order-button{
        cursor:pointer;
    }
    h2{
        color:#7e151c;
    }
    .spanClass{
        font-size: 14px;
        margin-left: 80px;
        color: #28a745;
        text-shadow: chocolate !important;
        text-shadow: 2px 2px 10px currentColor;
    }
</style>
<script language="JavaScript" src="client/js/jsStore.js" type="text/javascript"></script>
<body>
<div class="center">
<form name="editStore form" action="" id="registerform" method="POst">
    <div style="margin-top:15px;" ><h1><b>Get a <b>free order online button</b> for your Business/Restaurant!</b></h1></div>
    <table BORDER=0  width="100%">
        <tr>
            <td>
                <div>
                    <h2>Having an <b>Order Online Button</b> on your restaurant <b>Web-site</b> or <b>Face book page</b>, gives your customers the opportunity to Order directly from several Media/Channels!</h2>
                    <h4>Order Online Button for EAT NOW</h4>
                    <div style="width:100%;clear:both;">
                        <div style="float:left;width:40%;">
                            <a href="<?=USER_APP_BASE_URL?>restro-menu-list/<?=$data[0]['store_id'] ?>"><button type="button" class="direct-order-button" style="color: #fff; background-color: #28a745; border: none; padding: 8px 11px; font-size: 0.875rem; border-radius: 4px; font-family: sans-serif; font-weight: 600; box-shadow: 4px 4px 6px gray;">Beställ och betala direkt online</button></a>
                        </div>
                        <div style="float:left;width:20%;">
                            <button onclick="myFunction('eatNowCode')" class="planeButton" type="button"><b>Copy this button !</b></button>
                        </div>
                        <div style="float:left;width:40%;">
                            <button onclick="myFunction('eatNowLink')" class="planeButton" type="button"><b>Eat now - </b> Click to copy the link</button>
                        </div>
                    </div>
                    <div style="clear:both;">
                    <p>Copy the button above and paste it into Html code of you web-site or FaceBook</p>
                    <h4>Order Online Button For EAT LATER/CATERING</h4>
                    <div style="width:100%;clear:both;">
                        <div style="float:left;width:40%;">
                            <a href="<?=USER_APP_BASE_URL?>iframe/eat-later-datetime/<?=$data[0]['store_id'] ?>"><button type="button" class="direct-order-button" style="color: #fff; background-color: #28a745; border: none; padding: 8px 11px; font-size: 0.875rem; border-radius: 4px; font-family: sans-serif; font-weight: 600; box-shadow: 4px 4px 6px gray;">Beställ & betala direkt online</button></a>
                        </div>
                        <div style="float:left;width:20%;">
                            <button onclick="myFunction('eatLaterCode')" class="planeButton" type="button"><b>Copy this button !</b></button>
                        </div>
                        <div style="float:left;width:40%;">
                            <button onclick="myFunction('eatLaterLink')" class="planeButton" type="button"><b>Eat later - </b> Click to copy the link</button>
                        </div>
                    </div>
                    <div style="clear:both;">
                    <p>Copy the button above and paste it into Html code of you web-site or FaceBook</p><br><br>
                    <h2> A Link to make  you Facebook Business page ready for online ordering</h2>
                    <p>Add a button to your Facebook page to make ordering instant</p>
                    <p><b><a href="https://www.facebook.com/business/learn/lessons/add-a-call-to-action-button-on-facebook" style="color:dodgerblue">Check this Video description on how to add it!</a></b>&nbsp;&nbsp;<img src="lib/grid/images/leftArrow.gif" style="vertical-align: top;width:20px;height:15px"><span class="spanClass">Add a <b>CALL TO ACTION</b> button in your FaceBook business Page!</span></p>
                    <p>To add a CTA button, start on your Page. Below you page's cover photo, click Edit. You'll see a Preview section at the top that shows what you button look like. Select a button to see how to add it will look. if you want people to make a purchase from your shop, click Shop with you.  Add following link.</p>
                    <button onclick="myFunction('eatNowLink')" class="planeButton" type="button"><b>Eat now - </b> Click to copy the link</button><br>
                    <button onclick="myFunction('eatLaterLink')" class="planeButton" type="button"><b>Eat later - </b> Click to copy the link</button> 
                    <p>Click Finish to add the CTA button to your Page.</p>
                </div>
            </td>
        </tr>
    </table>
</form>
<br>
</div>
<input type="text" class="copyFromHere" value='<div style="width:100%;clear:both"><a href="<?=USER_APP_BASE_URL?>restro-menu-list/<?=$data[0]['store_id'] ?>"><button type="button" class="direct-order-button" style="color: #fff; background-color: #28a745; border: none; padding: 8px 11px; font-size: 0.875rem; border-radius: 4px; font-family: sans-serif; font-weight: 600; box-shadow: 4px 4px 6px gray;">Beställ och betala direkt online</button></a></div>' id="eatNowCode">
<input type="text" class="copyFromHere" value='<div style="width:100%;clear:both"><a href="<?=USER_APP_BASE_URL?>iframe/eat-later-datetime/<?=$data[0]['store_id'] ?>"><button type="button" class="direct-order-button" style="color: #fff; background-color: #28a745; border: none; padding: 8px 11px; font-size: 0.875rem; border-radius: 4px; font-family: sans-serif; font-weight: 600; box-shadow: 4px 4px 6px gray;">Beställ & betala direkt online</button></a></div>' id="eatLaterCode">
<input type="text" class="copyFromHere" value='<?=USER_APP_BASE_URL?>restro-menu-list/<?=$data[0]['store_id'] ?>"' id="eatNowLink">
<input type="text" class="copyFromHere" value='<?=USER_APP_BASE_URL?>iframe/eat-later-datetime/<?=$data[0]['store_id'] ?>' id="eatLaterLink">
<div id="tooltip">
     <div id="tooltiptext">Copied</div>
</div>
<? include("footer.php"); ?>
<script>
    function myFunction(id) {
        var copyText = document.getElementById(id);
        copyText.select();
        document.execCommand("copy");
        document.getElementById('tooltip').style.display="block";
        setTimeout(function(){
            document.getElementById('tooltip').style.display="none";
        },500);
    }
</script>
</body>
</html>
