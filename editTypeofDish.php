<?php
   /*  File Name  : standardOffer.php
    *  Description : Standard Offer Form
    *  Author      : Himanshu Singh  Date: 25th,Nov,2010  Creation
   */
   header('Content-Type: text/html; charset=utf-8');
   include_once("cumbari.php");
   //echo $_SESSION['userid'];
   $standardObj = new offer();
   $compcont = $standardObj->companycountry();
   if ($compcont == 'Sweden') {
       $lang = 'SWE';
       //echo $lang;die;
   }
   else {
       $lang = 'ENG';
   }
   //$standardObj->checkBudgetDetails();
   
   if (isset($_POST['continue1'])) {
       $standardObj->editTypeofdishsave();
   }{
    $dishId = $_GET['dishId']; 
    $data = $standardObj->getTypeOfDishDetail($dishId);    //print_r($data) ; die();
   }
   $menu = "dishType";
   $dishType = 'class="selected"';
   $showstandard = 'checked="checked"';
   include_once("main.php");
   if (isset($_GET['reedit'])) {
       $lang = $_SESSION['post']['lang'];
   }
   
   
   ?>

<script language="JavaScript" src="client/js/jsStore.js" type="text/javascript"></script>
<style type="text/css">
   <!--
      .center{width:900px; margin-left:auto; margin-right:auto;}
      -->
</style>
<body>
   <div class="center">
      <form name="registerform" action="" id="registerform" method="POst">
         <input type="hidden" name="m" value="saveNewStore">
         <table width="100%"  border="0">
            <tr>
               <td class="redwhitebutton">Edit Type of Dish</td>
            </tr>
         </table>
         <table width="100%" border="0" cellspacing="15">
          <tr>
               <td width="50%" class="inner_grid"><b>Language:</b> </td>
               <td width="50%" colspan="2">
                  <select style="width:406px; background-color:#e4e3dd; border: 1px solid #abadb3;" class="text_field_new" name="lang" id="lang">
                     <option <? if ($data[0]['dish_lang'] == 'SWE')echo "selected='selected'"; ?> value="SWE">Swedish</option>
                     <option <? if ($data[0]['dish_lang'] == 'ENG')echo "selected='selected'"; ?> value="ENG">English</option>
                  </select>
                  <div id='error_langStand' class="error"></div>
               </td>
            </tr>
            <tr>
               <td width="50%" class="inner_grid">Dish name 
                  <span class='mandatory'>*</span>:
               </td>
               <td width="27%">
                 <INPUT class="text_field_new" type="hidden" name="dishid" id ="dishid" value="<?=$dishId ?>">
                  <INPUT class="text_field_new" type=text name="dishName" id ="dishName" value="<?=$data[0]['dish_name']
                     ?>">
                  <div id='error_dishName' class="error"></div>
               </td>
               <td align="right"><a title="<?=SNAME_OF_LOCATION_TEXT?>" class="vtip"><b><small>?</small></b></a></td>
            </tr>
         </table>
         <div align="center">
            <INPUT style="margin-left:700px;" type="submit" value="Submit" name="continue1" id="continue1" class="button" >
          <br />
          <br />
        </div>
      </form>
      <div>
         <span class='mandatory'>* These Fields Are Mandatory</span>
      </div>
   </div>
   <? include("footer.php"); ?>
