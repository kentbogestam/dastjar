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
   $offerObj = new offer();
   $storeId = $_GET['storeId'];
   $productId = $_GET['productId'];
    $data = $offerObj->getStoreDetail($storeId,$productId);
    //print_r($data);//die();
   // Total Location
   $stores = $storeObj->totalStoreDetails();
   if (isset($_POST['continue'])) {
       $offerObj->saveEditStorePrice($storeId,$productId);
   }
   include_once("header.php");
   ?>
<?php include 'config/defines.php'; ?>
<script language="JavaScript" src="client/js/ajaxuploadStand.js" type="text/javascript"></script>
<style type="text/css">
   a { }
   img { border: 0 }.center{width:900px; margin-left:auto; margin-right:auto;}
</style>
<script language="JavaScript" src="client/js/jsAddStandCoupon.js" type="text/javascript"></script>
<body>
   <div class="center">
      <div>
         <div id="preview_frame"></div>
      </div>
      <form name="register" action="" id="registerform" method="Post" enctype="multipart/form-data">
         <input type="hidden" name="preview" value="1">
         <div id="msg" align="center">
            <?php
               if ($_SESSION['MESSAGE']) {
                   echo $_SESSION['MESSAGE'];
                   $_SESSION['MESSAGE'] = "";
               }
               ?>
         </div>
         <div class="redwhitebutton_small123" style="margin-top:20px; margin-bottom:5px;">Edit Location Price</div>
         <table width="100%" border="0" cellspacing="15">
            <tr>
               <td width="10%" align="left">Location Name:</td>
               <td align="left">
                  <div align="" class="normalfont" >
                     <? echo $data['store_name'];?>
                  </div>
               </td>
            </tr>
            <tr>
               <td width="50%" align="left">Price<span class='mandatory'>*</span>:</td>
               <td align="left">
                  <div align="center" class="normalfont" >
                     <?  $d=$data['text'];
                        $price = explode(':',$d);
                                  
                                    $new_price = preg_replace("[^0-9]", "", $price[1] );
                                  // echo $new_price;  ?>
                     <input class="text_field_new" type="text" name="price" id="price" value="<? echo $new_price; ?>">
                     <div id='error_price' class="error123"></div>
                  </div>
               </td>
            </tr>
         </table>
         <div align="center"><br />
            <br />
            <INPUT  style="margin-left:115px;" type="submit" value="Submit" name="continue" id="continuePrice" class="button" ><br />
            <br />
         </div>
         <span class='mandatory'>* These Fields Are Mandatory</span>
      </form>
   </div>
   <? include("footer.php"); ?>
</body>
</html>