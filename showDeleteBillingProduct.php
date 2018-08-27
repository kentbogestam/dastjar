<?php
   /*  File Name  : showStandard.php
   *  Description : Show Standard Form
   *  Author      : Himanshu Singh
   * Date         : 6th,Dec,2010  Creation
   */
   header('Content-Type: text/html; charset=utf-8');
   ob_start();

   include_once("cumbari.php");
   
  $menu = "account";
  $account = 'class="selected"';

   include("Paging.php");
   include("mainSupport.php");

    $billingObj = new billing();
    $inoutObj = new inOut();
   
   $menu = "account";
   $account = 'class="selected"';

    $case = $_GET['m'];
    $uId = $_GET['uId'];
    
    if($uId == '')
    {
        $uId = 'default';
    }

   $pager = null;

    if ($uId != '') {
        $records_per_page = PAGING;
        $total_records = $billingObj->getTotalDeletedProduct($uId);
        // echo $total_records;
        $pager = new pager($total_records, $records_per_page, @$_GET['_p']);
        $paging_limit = $pager->get_limit();
        $data = $billingObj->showDeletedPlan($paging_limit, $uId);
    }
   ?>
<link href="lib/grid/css/grid.css" rel="stylesheet" type="text/css" />
<link href="client/css/stylesheet123.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="lib/grid/js/grid.js" type="text/javascript"></script>
<body>
  <div class="frm_cls">
<table border="0" align="center" cellpadding="0" cellspacing="0" style="width: 500px">
  <tr>   
    <td style="width:100px"><input type="radio" <?=$showstandard?> onClick="javascript:window.location.href='productSupport.php'" name="deals" selected="selected">
    Product </td>
    
    <td><input type="radio" <?=$showdeletestand?> onClick="javascript:window.location.href='showDeleteBillingProduct.php'" name="deals" checked>
    Show Deleted Product </td>
  </tr>
  <tr>   
    <td><input type="radio" <?=$showstandard?> onClick="javascript:window.location.href='showBillingCustomer.php'" name="deals">
    Customer </td>    
    <td width="20">&nbsp;</td>
  </tr>
</table>
</div>

   <div class="center">
      <div id="msg" align="center" style="margin-top:20px;">
         <?php
            if ($_SESSION['MESSAGE']) {
                echo $_SESSION['MESSAGE'];
                $_SESSION['MESSAGE'] = "";
                if($_SESSION['askforstoreStand']) {
                    ?>
         <script> askForStoreStand('<?=$_GET['standId']?>')</script>
         <?php
            $_SESSION['askforstoreStand']=0;
            }
            }
            ?>
      </div>
      <div id="container">
         <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
               <td valign="top">
<table  border="0" cellspacing="0" cellpadding="0">
 <tr>
    <td height="400" valign="top">
<table width="900" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
     <td colspan="2" align="center">
        <form action="" name="searchbox" method="get">
           <input type="hidden" name="m" value="<?=$_GET['m']
              ?>" />
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
     <td align="left">
        <h2><?php
            echo "Product";
        ?></h2>
     </td>
     <td>&nbsp;</td>
     <td valign="bottom">&nbsp;</td>
  </tr>
  <tr>
     <td width="24%">&nbsp;</td>
     <td width="455">
    
     </td>
     <td width="24%" valign="top">
        <div align="center"  class="main_bg"><a href="createEditBillingProduct.php">ADD PRODUCT</a></div>
     </td>
  </tr>
</table>
        </form>
     </td>
  </tr>
  <tr>
     <td colspan="2" align="left">
        <?php if (1) { ?>
        <form method="post" name="myform" action="category_action.php" onSubmit="return confirm_msg();" class="form">
           <table width="100%" border="0" cellpadding="6" cellspacing="0" class="border">
              <tr>
                 <td width="30%" align="left"><?php //echo $pager->get_title('&nbsp;Displaying results {FROM} to {TO} of {TOTAL}');         ?></td>
                 <td width="70%" align="right" valign="middle" style="color:#881d0a;">
                    <img src="lib/grid/images/view.gif">&nbsp;View&nbsp;&nbsp;&nbsp;
                 </td>
              </tr>
           </table>
           <table width="100%" border="0" cellpadding="2" cellspacing="2" class="border" bgcolor="#CCCCCC">
              <tr align="center">
                 <td width="20%" height="20" align="center"  class="bg_darkgray1"><strong>Product Name</strong></td>
                 <td width="20%" height="20" align="center"  class="bg_darkgray1"><strong>Plan Name</strong></td>
                 <td width="15%" height="20" align="center" class="bg_darkgray1"><strong>Currency</strong></td>
                 <td width="15%" height="20" align="center" class="bg_darkgray1"><strong>Price</strong></td>

                 <td width="10%" height="20" class="bg_darkgray1"><strong>Action</strong></td>
              </tr>

              <?php
                 $i = 1 + $pager->get_limit_offset();
    
                 foreach ($data as $data1) {
                     
                    if($data1['small_image'] == null){
                        $data1['small_image'] = 'images/placeholder-image.png';
                    }else{
                      $content = @file_get_contents($data1['small_image']);
                      if (!strpos($http_response_header[0], "200")) { 
                        $data1['small_image'] = 'images/placeholder-image.png';
                      }
                    } 
                  ?>
              <tr bgcolor="#FFFFFF" style="font-size:18px; font-weight:bold;">
                 
                 <td align="center"><?php echo $data1['product_name']; ?></td>
                 <td align="center"><?php echo $data1['plan_nickname']; ?></td>
                 <td align="center"><?php echo $data1['currency']; ?></td>
                 <td align="center"><?php echo $data1['price']; ?></td>
                 
                 <td align="center">
                    <table border="0" align="center" cellpadding="0" cellspacing="0">
                       <tr>
                          <td>
                             <div class="action-btn2"><a href="viewDeleteBillingProduct.php?uId=<?=$data1['id'];
                                ?>" class="a2" title="View"><img src="lib/grid/images/view.gif" width="11" height="11"></a></div>
                          </td>
                       </tr>
                    </table>
                 </td>
              </tr>
              <?
                 $i++;
                 }
                 ?>
           </table>
           <br>
           <table width='100%'>
              <?php
                 if ($total_records == 0) {
                     echo "No Records Found";
                 }
                 ?>
           </table>
           <table width="100%" border="0" cellpadding="6" cellspacing="0" class="border">
              <tr>
                 <td width="67%" align="left"><?php// echo $pager->get_title('&nbsp;Displaying Results {FROM} to {TO} of {TOTAL}'); ?></td>
                 <td width="33%" align="right"><?php
                  echo $pager->get_prev('<a href="{LINK_HREF}">Prev</a>&nbsp;');
                  echo $pager->get_range('<a href="{LINK_HREF}">{LINK_LINK}</a>', ' &raquo ') . '';
                  echo $pager->get_next('<a href="{LINK_HREF}">&nbsp;Next</a>');
                  ?></td>
              </tr>
           </table>
           <input type="hidden" name="action" value="check_box_action">
        </form>
        <?php } else {
           ?>
        <table width="100%" border="0" cellpadding="6" cellspacing="0" class="border">
           <tr>
              <td width="67%" align="center">No Record Found.</td>
           </tr>
        </table>
        <?php } ?>
        <br />
        <br />                      
     </td>
  </tr>
</table>
    </td>
 </tr>
</table>
               </td>
            </tr>
         </table>
      </div>
      <?
         $records_page = PAGING;
         // $total_records1 = $standObj->showAllPublicStandardOffers();
         // $pager1 = new pager1($total_records1, $records_page, @$_GET['_pp']);
         // $paging_l = $pager1->get_limit();
         // $is_Public = $standObj->showAllPublicStandardOffersDetails($paging_l);
         $is_Public = 1;
         ?>
      <link href="lib/grid/css/grid.css" rel="stylesheet" type="text/css" />
      <link href="client/css/stylesheet123.css" rel="stylesheet" type="text/css" />
      <script language="JavaScript" src="lib/grid/js/grid.js" type="text/javascript"></script>
      <!-- <h1> <a href="javascript:void()"  onClick="showPublicProduct();">View Others Products</a> </h1> -->
      <div id="msg" align="center">
         <?php
            if ($_SESSION['MESSAGE']) {
                echo $_SESSION['MESSAGE'];
                $_SESSION['MESSAGE'] = "";
            }
            ?>
      </div>
      <div id="page_caption" style="height:20px;"  >
      </div>
      <div id="container1" style="display:none;">
         <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
               <td valign="top">
                  <table  border="0" cellspacing="0" cellpadding="0">
                     <tr>
                        <td height="400" valign="top">
                           <table width="900" border="0" align="center" cellpadding="0" cellspacing="0">
                              <tr>
                                 <td colspan="2" align="center">
                                 </td>
                              </tr>
                              <tr>
                                 <td colspan="2" align="left">
                                    <?php if (1) { ?>
                                    <form method="post" name="myform" action="category_action.php" onSubmit="return confirm_msg();">
                                       <br />
                                       <table width="100%" border="0" cellpadding="0" cellspacing="1" class="border" bgcolor="#CCCCCC">
                                          <tr align="center" >
                                             <td width="5%"  class="bg_darkgray1" align="center"><strong>Product Name</strong></td>
                                             <td width="5%" class="bg_darkgray1"><strong>Icon</strong></td>
                                             <td width="5%" align="center" class="bg_darkgray1"><strong>Sponsored</strong></td>
                                             <td width="5%" class="bg_darkgray1"><strong>Action</strong></td>
                                          </tr>
                                          <?php
                                             $i = 1 + $pager->get_limit_offset();
                                             foreach ($is_Public as $is_Public1) {
                                                 ?>
                                          <tr bgcolor="#FFFFFF">
                                             <!--<td class="bg_lightgray" align="left" style="padding-left:5px;">
                                                <input name='list[]' id='check_box<?=$i
                                                   ?>' type='checkbox' style='size:10px;border:0px;'
                                                value='<?=$line['id']
                                                   ?>'></td>
                                                <td align="center"><?php echo $i; ?> </td>-->
                                             <td align="center"><?php echo $is_Public1['slogen']; ?></td>
                                             <td align="center"><img src="<?php echo $is_Public1['small_image'] ?>" height="30" width="30"/></td>
                                             <td align="center"><?php
                                                $d = $is_Public1['is_sponsored'];                                                                                                    if ($d == 0)
                                                         echo "No";            else
                                              echo "Yes"; ?></td>
                                             <!--<td align="center"><?php echo $is_Public1['link']; ?></td>-->
                                             <!--<td align="center"><?
                                              echo "<br><a href='";                                                 echo $url = BASE_URL . 'addStandStore.php?productId=' . $is_Public1['product_id'];
                                              echo "'>Add Store</a>";
                                                 ?></td>-->
                                             <td class="bg_lightgray" align="center">
                                                <a href="viewPublicProduct.php?productId=<?=$is_Public1['product_id'];
                                                   ?>" class="a2" title="View"><img src="lib/grid/images/view.gif"></a>
                                                &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="<?=BASE_URL . 'addStandStore.php?productId=' . $is_Public1['product_id'];?>" class="a2" title="Add Location"><img src="lib/grid/images/active.gif"></a>
                                             </td>
                                          </tr>
                                          <?
                                             $i++;
                                             }
                                             ?>
                                       </table>
                                       <br>
                                       <table width='100%'>
                                          <?php
                                             if ($total_records1 == 0) {
                                                 echo "No Records Found";
                                             }
                                             ?>
                                          <!-- with selected html starts-->
                                          <!--<tr>
                                             <td width='350' align="left">&nbsp;&nbsp;&nbsp;&nbsp;<img src="lib/grid/images/arrow.gif">
                                             <a href="#" onClick="checkall(true)" ><font color="#FF0000">Check all</font> </a> /
                                             <a href="#" onClick="checkall(false)"><font color="#FF0000">Uncheck all </font> </a>&nbsp
                                             <select id='select_action' name='select_action' onChange="return confirm_msg();">
                                             <option value="">--With Selected--</option>
                                             <option value="1">Activate</option>
                                             <option value="0">De-Activate</option>
                                             <option value="delete">Delete</option>
                                             </select>                              </td>
                                             </tr>-->
                                          <!-- with selected htl ends-->
                                       </table>
                                       <table width="100%" border="0" cellpadding="6" cellspacing="0" class="border">
                                          <tr>
                                             <td width="67%" align="left"><?php //echo $pager1->get_title('&nbsp;Displaying Results {FROM} to {TO} of {TOTAL}'); ?></td>
                                             <td width="33%" align="right"><?php
                                               // echo $pager1->get_prev('<a href="{LINK_HREF}">Prev</a>&nbsp;');                                         echo $pager1->get_range('<a href="{LINK_HREF}">{LINK_LINK}</a>', ' &raquo ') . '';
                                              // echo $pager1->get_next('<a href="{LINK_HREF}">&nbsp;Next</a>');
                                                        ?></td>
                                          </tr>
                                       </table>
                                       <input type="hidden" name="action" value="check_box_action">
                                    </form>
                                    <?php } else {
                                       ?>
                                    <table width="95%" border="0" cellpadding="6" cellspacing="0" class="border">
                                       <tr>
                                          <td width="67%" align="center">No Record Found.</td>
                                       </tr>
                                    </table>
                                    <?php } ?>
                                    <br />
                                    <br />                      
                                 </td>
                              </tr>
                           </table>
                        </td>
                     </tr>
                  </table>
               </td>
            </tr>
         </table>
      </div>
   </div>
   <? include("footer.php"); ?>
</body>
</html>
<script>
   function showPublicProduct()
   {
       document.getElementById("container1").style.display='inline';
   
   }
</script>
