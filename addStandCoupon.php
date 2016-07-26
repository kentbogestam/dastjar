<?php
/*  File Name  : standardOffer.php
 *  Description : Standard Offer Form
 *  Author      : Himanshu Singh  Date: 25th,Nov,2010  Creation
 */
header('Content-Type: text/html; charset=utf-8');
include_once("cumbari.php");
$menu = "standard";
$standard = 'class="selected"';
$show = 'class="selected"';
//echo $_SESSION['userid'];
//exit;
include("main.php");
$regObj = new registration();
$storeObj = new store();

//$regObj->isValidRegistrationStep();
$standardObj = new offer();
$_GET['productId'];
$stores = $storeObj->totalStoreDetails();
if (isset($_POST['continue'])) {
    $standardObj->saveNewCouponStandardDetails();
}
include_once("header.php");
?>
<?php include 'config/defines.php'; ?>

<script language="JavaScript" src="client/js/ajaxuploadStand.js" type="text/javascript"></script>


<style type="text/css">

    a { }
    img { border: 0 }
</style>
<script language="JavaScript" src="client/js/jsCouponStandardOffer.js" type="text/javascript"></script>
<div>
    <div id="preview_frame"></div>
</div>
<form name="register" action="" id="registerform" method="Post" enctype="multipart/form-data"></form>
<input type="hidden" name="preview" value="1">
<input type="hidden" name="m" value="saveNewCouponStandard">
<input type="hidden" name="productId" value="<?=$_GET['productId']; ?>">
<div id="msg" align="center">
    <?php
    if ($_SESSION['MESSAGE']) {
        echo $_SESSION['MESSAGE'];
        $_SESSION['MESSAGE'] = "";
    }
    ?>
</div>

<div id="main">
    <div id="mainbutton">
        <table width="100%" cellspacing="10" border="0">
            <tr>
                
                <td width="201">&nbsp;</td>
            </tr>
            <tr>
               
                <td  class="blackbutton">Add Coupon</td>
              
            </tr>
            <tr>
                
                <td align="center"  class="redwhitebutton_small" style=" padding-top: 5px; text-align:center ">Add your Coupon Details</td>
            
            </tr>
            <tr>
              
                <td>
                    <table BORDER=0 width="100%" >
                        <tr>
                            <td width="50%">Title Slogan:<br></td>
                            <td>
                                <INPUT class="text_field_new" type=text name="titleSloganStand" id="titleSloganStand" value="<?=$_SESSION['post']['titleSloganStand']
    ?>">
                                <a title="<?=STITLE_TEXT
    ?>" class="vtip"><b><small>?</small></b></a><br/>
                                    <div id='error_titleSloganStand' class="error"></div></td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr style="display:none;">
                                <td>Price</td>
                                <td>
                                    <INPUT class="text_field_new" type=text name="price" id="price" value="<?=$_SESSION['post']['price']
    ?>">
                                <a title="<?=PRICE_TEXT
    ?>" class="vtip"><b><small>?</small></b></a><br/></td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>Category:</td>
                                <td><select class="text_field_new" onchange="getCatImage(this.value);"  tabindex="27" id="linkedCatStand" name="linkedCatStand" value="<?=$_SESSION['post']['linkedCat']
    ?>">
                                    <option value="">Select Category</option>

      <?=$standardObj->getCategoryList($_SESSION['post']['linkedCatStand']) ?>
                                    </select>
                                    <input type="hidden" name="category_image" id="category_image" value="">
                                    <div id="category_image_div" style="display:none;"></div>
                                    <div id='error_linkedCatStand' class="error"></div></td>
                            </tr>
                            <form action="" method="post" name="standard_use" id="standard_use" enctype="multipart/form-data">

                                <tr>
                                    <td>Add a icon to represent your offer or<br> select a category icon from our library:</td>
                                    <td>
                                        <div id="pre_image">
                                        <?php if ($_SESSION['preview']['small_image']) {
                                        ?>
                                            <img src="upload/category/<?=$_SESSION['preview']['small_image'] ?>">
                                        <input class="text_field_new" type="hidden" name="smallimage" id="smallimage" value="<?=$_SESSION['preview']['small_image'] ?>">
                                        <br>
                                        <?
                                    }
                                        ?>
                                    </div>
                                    <INPUT class="text_field_new" type=file name="icon" id="icon">
                                    <a title="<?=ICON_TEXT
                                        ?>" class="vtip"><b><small>?</small></b></a><br/>
                                     <div id='error_icon' class="error"></div>
                                     <div>
                                         <input class="text_field_new" type="hidden" id="selected_image" name="selected_image" value="0">
                                     </div>                                    </td>
                                 <td>&nbsp;</td>
                             </tr>
                             <tr>
                                 <td colspan="2" align="left" height="20"><strong><button onclick="ajaxUpload(this.form,'classes/ajx/ajxUpload.php?filename=icon&amp;maxW=200','upload_area'); return false;">Click here</button> to check how your short standard offer proposal looks like</strong></td>
                             </tr>
                         </form>
                     </table>
                     <table width="100%" border="0" cellpadding="0" cellspacing="0">
                         <tr id="short_preview" style="display:none;">
                             <td width="300">&nbsp;</td>
                             <td width="220" align="center" valign="top" style="background-image:url(client/images/iphone.png); width:220px; height:430px; background-repeat:no-repeat; background-position:center;">

                                 <div style="margin-top:120px; width:190px; margin-left:8px;" >
                                     <table   border="0">
                                         <tr>
                                             <td width="41" rowspan="2"><div id="upload_area" style="vertical-align:top;"></div></td>
                                             <td width="116" valign="middle" class="style4" id="tslogan"></td>
                                         </tr>
                                     </table>
                                 </div>                                    </td>
                             <td >&nbsp;</td>
                         </tr>
                     </table>
                     <table BORDER=0 width="100%">
                         <tr>
                         <table width="100%" border="0"><tr>
                                 <td  class="redwhitebutton_small" style=" padding-top: 5px; text-align:center">Add your Coupon View</td>
                             </tr></table>
             </tr>
             <tr>
                 
                 <td>
                     <table  width="100%" BORDER=0 cellpadding="0" cellspacing="0" >
                         <tr>
                             <td width="100%"> Do you want to sponsor your <br />
                                 Standard Offer:</td>
                             <td><select class="text_field_new"  tabindex="27" id="" value="<?=$_SESSION['post']['sponsStand']
                                        ?>" name="sponsStand">
                                    <div id='error_sponsStand' class="error"></div>
                                    <option <? if ($_SESSION['post']['sponsStand'] == '0'

                                            )echo "selected='selected'"; ?> value="0">No</option>

                                    <option <? if ($_SESSION['post']['sponsStand'] == '1'

                                            )echo "selected='selected'"; ?> value="1">Yes</option>
                                </select><div id='error_sponsStand' class="error"></div></td>
                        </tr>
                    </table>
              
        </table></td>
        
        </tr>
        <tr>
            <td colspan="3"><table width="100%" border="0">
                    <tr>
                       
                        <td width="50%">Select a picture as your Coupon </td>
                        <td width="518">
                            <?php if ($_SESSION['preview']['large_image']) {
                            ?>
                                            <img src="upload/coupon/<?=$_SESSION['preview']['large_image'] ?>">
                            <input class="text_field_new" type="hidden" name="largeimage" id="largeimage" value="<?=$_SESSION['preview']['large_image'] ?>">
                            <br>Or&nbsp;
                            <?
                        }
                            ?>
                            <INPUT class="text_field_new" type=file name="picture" id="picture">
                            <a title="<?=SPICTURE_TEXT
                            ?>" class="vtip"><b><small>?</small></b></a><br/>
                            <div id='error_picture' class="error"></div></td>
                    </tr>
                    <tr>
                      
                        <td width="209">Product description:</td>
                        <td width="518">
                            <TEXTAREA class="text_field_new" NAME="descriptiveStand" id="descriptiveStand" COLS=30 ROWS=4 value="<?=$_SESSION['post']['descriptiveStand']
                            ?>"></TEXTAREA>
                            <a title="<?=SDESCRIPTION_TEXT
                            ?>" class="vtip"><b><small>?</small></b></a><br/>
                                   <div id='error_descriptiveStand' class="error"></div></td>
                           </tr>
                           <tr>
                              
                               <td>Select a Store</td>
                               <td>
                                   <select  class="text_field_new" name="selectStore" id="selectStore" value="<?=$_SESSION['post']['selectStore']
                            ?>">
                                        <?php foreach ($stores as $stores1) {
// print_r($stores1);    ?>
                                    <option  value="<?=$stores1['store_id'] ?>"><? echo $stores1['store_name']; ?></option>

                                <? } ?>
                                </select>
                                <div id='error_selectStore' class="error"></div></td>
                        </tr>
                    </table></td>
            </tr>
            </table>
        </div>
<div align="center"><br />
<br />

            <INPUT type="submit" value="continue" name="continue" id="continue" class="button" >
        <br />
        <br />
</div>

    <? include("footer.php"); ?>
</div>
</form>
</body>
</html>