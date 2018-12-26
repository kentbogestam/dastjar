<?php
/* File Name   : addEditCategory.php
 *  Description : addEditCategory
 *
*/
header('Content-Type: text/html; charset=utf-8');
include_once("cumbari.php");
  
  $menu = "account";
  $account = 'class="selected"';

include("mainSupport.php");
$billing = new billing();
$editId = $_GET['editId'];

if(isset($_GET['b'])){
   $backLink = $_GET['b'] . ".php";
}else{
   $backLink = "productSupport.php";
}

if($editId)
{
   $data = $billing->getBillingProduct($editId);
}

if (isset($_POST['continue']) AND $editId == '') {
    $billing->createPlan();
}

if (isset($_POST['continue']) AND $editId != '') {
    $billing->updatePlan($editId);
}

?>
<?php include 'config/defines.php'; ?>
 <script language="JavaScript" src="client/js/jquery.js" type="text/javascript"></script>
 <script language="JavaScript" src="client/js/jsAddPlan.js" type="text/javascript"></script>

 <style type="text/css">
/*
.center{width:900px; margin-left:auto; margin-right:auto;}
*/
</style>

<div class="center">
<table width="100%" border="0">
    <tr>
        <td >&nbsp;</td>
    </tr>
    <tr>
        <td >&nbsp;</td>
    </tr>
    <tr>
                <? if($editId == '') {?>
                    <td class="redwhitebutton">ADD PRODUCT</td>
                <? }  else { ?>

         <td class="redwhitebutton">EDIT PRODUCT</td>
                <? } ?>

    </tr>
</table>


<div align="center">
    <form name="category" action="" id="category" method="post" enctype="multipart/form-data">
                    
       <br>
        <input type="hidden" name="m" value="">
        <div id="msg" align="center">
            <?php
                if($_SESSION['MESSAGE']) {
                    echo $_SESSION['MESSAGE'];
                    $_SESSION['MESSAGE']="";
                }
            ?>
        </div>

        <td width="100%"><table BORDER=0 cellspacing="10" width="100%" >

                <tr>
                    <td colspan="3" ></td>
                </tr>

                <tr>

                    <td width="50%" align="left" class="inner_grid">Product Name<span class='mandatory'>*</span>
                        :</td>
                    <td width="50%" align="left">
                         <INPUT class="text_field_new" type="text" name="product_name" id="product" value="<?=$data[0]['product_name']?>">
                        <a title="<?=PRODUCT_NAME?>" class="vtip"><b><small>?</small></b></a><br/>
                        <div id='error_product' class="error"></div></td>


                </tr>

                <tr>

                    <td align="left" class="inner_grid">Plan Nickname<span class='mandatory'>*</span>:</td>
                    <td align="left">
                        <INPUT class="text_field_new" type="test" name="plan_nickname" id="plan" value="<?=$data[0]['plan_nickname']?>"/>
                        <a title="<?=PLAN_NICKNAME?>" class="vtip"><b><small>?</small></b></a><br/>
                        <div id='error_plan' class="error"></div></td>
                </tr>

              <tr>

                    <td align="left" class="inner_grid">Price<span class='mandatory'>*</span>:</td>
                    <td align="left">
                        <INPUT class="text_field_new" type="test" name="price" id="price" value="<?=$data[0]['price']?>"/>
                        <a title="<?=PRICE?>" class="vtip"><b><small>?</small></b></a><br/>
                        <div id='error_price' class="error"></div></td>
                </tr>

                <tr>
                    <td align="left" class="inner_grid">Trial Period:</td>
                    <td align="left">
                        <INPUT class="text_field_new" type="number" name="trial_period" id="trial_period" value="<?=($data[0]['trial_period']) ? $data[0]['trial_period'] : ''?>" placeholder="Trial period in days" />
                        <a title="<?=TRIAL_PERIOD?>" class="vtip"><b><small>?</small></b></a><br/>
                        <div id='error_price' class="error"></div></td>
                </tr>

                <tr>

                    <td align="left" class="inner_grid">currency<span class='mandatory'>*</span>:</td>
                    <td align="left">
                        <select class="text_field_new" value="<?=$data[0]['currency']?>" style="background-color:#e4e3dd; width:406px; height:36px;border: 1px solid #abadb3;" tabindex="27" id="currency" name="currency">
                            <option value="SEK">svensk krona (SEK kr)</option>
                            <option value="EUR">euro (EUR)</option>
                        </select>
                        <a title="<?=CURRENCY?>" class="vtip"><b><small>?</small></b></a><br/>
                        <div id='error_currency' class="error"></div></td>
                </tr>


                <tr>

                    <td align="left" class="inner_grid">Description<span class='mandatory'>*</span>:</td>
                    <td align="left">
                        <INPUT class="text_field_new" type="test" name="description" id="description" value="<?=$data[0]['description']?>"/>
                        <a title="<?=DESCRIPTION?>" class="vtip"><b><small>?</small></b></a><br/>
                        <div id='error_description' class="error"></div></td>
                </tr>

                <tr>
                    <td align="left" class="inner_grid">Usage Type<span class='mandatory'>*</span>:</td>
                    <td align="left">
                        <select class="text_field_new" type="test" name="usage_type" id="usage_type" value="<?=$data[0]['usage_type']?>">
                            <option value="licensed" selected="selected">licensed</option>
                            <option value="metered">metered</option>
                        </select>
                        <a title="<?=USAGE_TYPE?>" class="vtip"><b><small>?</small></b></a><br/>
                        <div id='error_usage_type' class="error"></div></td>
                </tr>


       <td align="left">&nbsp;</td>
       <td align="left">&nbsp;</td></tr>
              <? if($editId == '') {?>
        <tr>
                    <td colspan='3' align="center">
                        <INPUT style="margin-left:160px;" type="submit" value="Continue" class="button" name="continue" id="continue">
                <INPUT type="button" value="Back" name="continue" id="continue" class="button" onClick="javascript:location.href='<?=$backLink?>';" >
        </tr>
             <? }  else { ?>
                 <tr>
                    <td colspan='3' align="center">
                        <INPUT type="hidden" 
                        value="<?=$editId?>" class="button" name="edit_id">
                        <INPUT type="hidden" 
                        value="<?=$data[0]['product_id']?>" class="button" name="product_id">
                        <INPUT type="hidden" 
                        value="<?=$data[0]['plan_id']?>" class="button" name="plan_id">                        
                        <INPUT style="margin-left:160px;" type="submit" value="Update" class="button" name="continue" id="update">
                <INPUT type="button" value="Back" name="continue" id="continue" class="button" onClick="javascript:location.href='<?=$backLink?>';" >
                 </tr>
           <? } ?>
            </table>
        </td>

    </form>
</div><span class='mandatory'>* These Fields Are Mandatory</span>
</div>
<? include("footer.php"); ?>

<script type="text/javascript">
    $("#currency").val("<?=$data[0]['currency']?>");
</script>

