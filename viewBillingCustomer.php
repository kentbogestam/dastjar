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
        $data = $billingObj->viewBillingCustomer($uId);
    }
   ?>
<link href="lib/grid/css/grid.css" rel="stylesheet" type="text/css" />
<link href="client/css/stylesheet123.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="lib/grid/js/grid.js" type="text/javascript"></script>
<body>
  

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
         <div align="center">
          <div class="top_h3">View Billing Customer</div>
          <div style="clear:both"></div>

          <h4 class="bg_darkgray123">
          Customer Info Page</h4>
          <table BORDER=0 width="100%" id="infopage" style="display:row-inline;">
              <tr align="left">
                  <td width="29%"></td>
                  <td width="29%"><b>Customer Name:</b>        
                  </td>
                  <td>
                      <?$d=$data[0]['fname'] . " " . $data[0]['lname']?>
                      <?php if ($d=='') echo "Not specified";
                      else echo $d; ?>
                  </td>
              </tr>

              <tr align="left">
                  <td width="29%"></td>
                  <td width="29%"><b>Customer Email:</b>        
                  </td>
                  <td>
                      <?$d=$data[0]['email']?>
                      <?php if ($d=='') echo "Not specified";
                      else echo $d; ?>
                  </td>
              </tr>

              <tr align="left">
                  <td width="29%"></td>
                  <td width="29%"><b>Product Name:</b>        </td>
                  <td>
                      <?$d=$data[0]['product_name']?>
                      <?php if ($d=='') echo "Not specified";
                      else echo $d; ?>
                  </td>
              </tr>

              <tr align="left">
                  <td width="29%"></td>
                  <td width="29%"><b>Plan Nickname:</b>        </td>
                  <td>
                      <?$d=$data[0]['plan_nickname']?>
                      <?php if ($d=='') echo "Not specified";
                      else echo $d; ?>
                  </td>
              </tr>

              <tr align="left">
                  <td width="29%"></td>
                  <td width="29%"><b>Price:</b>        </td>
                  <td>
                      <?$d=$data[0]['price']?>
                      <?php if ($d=='') echo "Not specified";
                      else echo $d; ?>
                  </td>
              </tr>

              <tr align="left">
                  <td width="29%"></td>
                  <td width="29%"><b>Currency:</b>        </td>
                  <td>
                      <?$d=$data[0]['currency']?>
                      <?php if ($d=='') echo "Not specified";
                      else echo $d; ?>
                  </td>
              </tr>

              <tr align="left">
                  <td width="29%"></td>
                  <td width="29%"><b>Description:</b>        </td>
                  <td>
                      <?$d=$data[0]['description']?>
                      <?php if ($d=='') echo "Not specified";
                      else echo $d; ?>
                  </td>
              </tr>

              <tr align="left">
                  <td width="29%"></td>
                  <td width="29%"><b>Usage Type:</b>        </td>
                  <td>
                      <?$d=$data[0]['usage_type']?>
                      <?php if ($d=='') echo "Not specified";
                      else echo $d; ?>
                  </td>
              </tr>
          </table>
      </div>
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
      
    
      <div align="center"><br/>
       <INPUT type="button" value="Back" name="continue" id="continue" class="button" onClick="javascript:location.href='showBillingCustomer.php';" >
      <br />
      <br />
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
