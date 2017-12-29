<?php
   /*  File Name  : editStore.php
    *  Description : Edit Store Form
    *  Author      : Deo  Date: 17th,Dec,2010  Creation
    */
   header('Content-Type: text/html; charset=utf-8');
   include_once("cumbari.php");
   $inoutObj = new inOut();
   $storeObj = new store();
   $regObj = new registration();
   $countryList = $regObj->getCountryList();
   
   if (isset($_POST['continue'])) {
        $dishid = $_GET['dishId']; //echo $dishid; die();
       $storeObj->saveEditDish($dishid);
   } else {
       $dishid = $_GET['dishId']; //echo $dishid; die();
       $data = $storeObj->viewDishDetailById($dishid);
   //echo "<pre>";print_r($data);echo "</pre>";
   }
   $zoom = "18";
   $menu = "dishType";
   $menu = 'class="selected"';
   if ($_GET['m'] == "showOutdatedStore")
       $deleted = 'class="selected"';
   else
       $show = 'class="selected"';
   include_once("main.php");
   ?>
<?php include 'config/defines.php'; ?>

<style type="text/css">
   a { }
   img { border: 0 }
</style>
<body>
   <div class="center">
      <div>
         <div id="preview_frame"></div>
      </div>
      <form name="registerform" action="" id="registerform" method="Post">
         <input type="hidden" name="preview" value="1">
         <input type="hidden" name="productId" value="$_GET['productId']">
         <div class="redwhitebutton123">Add Language</div>
         <input type="hidden" name="m" value="saveNewStandard">
         <input type="hidden" name="productId" value="<?=$_GET['productId']
            ?>">
         <table   width="100%" border="0" align="center" cellspacing="15">
            <tr>
               <td width="50%" class="inner_grid"><b>Language:</b> </td>
               <td width="50%" colspan="2">
                  <select style="width:406px; background-color:#e4e3dd; border: 1px solid #abadb3;" class="text_field_new" name="lang" id="lang">
                     <option value="ENG">English</option>
                     <option value="SWE">Swedish</option>
                     <option value="GER">German</option>
                  </select>
                  <div id='error_langStand' class="error"></div>
               </td>
            </tr>
            <tr>
               <td width="50%"  class="inner_grid"><b>Dish Name</b><span class='mandatory'>*</span>:</td>
               <td>
                  <INPUT class="text_field_new" type=text name="dishType" id="dishType" onBlur="iconPreview(this.form); getTitleForProduct(this.form);" value="<?=$data[0]['dish_name']
                     ?>">
                  <div id='error_dishType' class="error"></div>
               </td>
               <td align="right"><a title="<?=STITLE_TEXT
                  ?>" class="vtip"><b><small>?</small></b></a> </td>
            </tr>
         </table>
         <div align="center"><br />
            <br />
            <INPUT type="submit" value="Submit" name="continue" class="button" id="continue" >
            <INPUT type="button" value="Back" name="" class="button"  id="continue" onClick="javascript:location.href='<?=$_SERVER[HTTP_REFERER]
               ?>';" >
            <br />
            <br />
         </div>
      </form>
      <span class='mandatory'>* These Fields Are Mandatory </span>
   </div>
   <? include("footer.php"); ?>
</body>
