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
       $dishid = $_GET['dishId']; //echo $storeid; die();
       $data = $storeObj->viewDishDetailById($dishid);
   //echo "<pre>";print_r($data);echo "</pre>";die();
   }
   $menu = "dishType";
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
         <div style="margin-top:15px;" >
            <h1><b>View Dish Type</b></h1>
         </div>
         <table BORDER=0  width="100%">
            <tr>
               <td colspan="3">
                  <div align="center" class="bg_darkgray123">
                     Dish Type Details
                  </div>
               </td>
            </tr>
            <tr>
               <td width="30%">&nbsp;</td>
               <td width="27%"><b>Dish Type:</b></td>
               <td width="43%">
                  <?=$data[0]['dish_name']
                     ?>            
               </td>
            </tr>
            <tr>
               <td>&nbsp;</td>
               <td><b>Lang:</b></td>
               <td>
                  <?=$data[0]['dish_lang'] ?>            
               </td>
            </tr>
            <tr>
               <td>&nbsp;</td>
               <td align="center">
                  <div align="right">
                     <INPUT type="button" value="Back" name="" class="button" id="continue" onClick="javascript:location.href='<?=$_SERVER[HTTP_REFERER]
                        ?>';" >
                  </div>
               </td>
               <td>
                  <p><br />
                  </p>
                  <p><br />
                  </p>
               </td>
            </tr>
         </table>
      </form>
   </div>
   <? include("footer.php"); ?>
</body>
</html>