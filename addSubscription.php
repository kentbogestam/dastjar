<?php
   /* File Name   : addCompany.php
    *  Description : Add Company Form
    *  Author      : Himanshu Singh  Date: 12th,Nov,2010  Creation
    */
   ob_start();

   header('Content-Type: text/html; charset=utf-8');
   include_once("cumbari.php");

   if($_SESSION['active_state']!=2){
      $url = BASE_URL . 'login.php';
      $inoutObj = new inOut();
      $inoutObj->reDirect($url);
      exit();
   }

   $billingObj = new billing();
   
   $data = $billingObj->showPlan();

   if(isset($_POST['plan_id'])){
    $billingObj->subscribe();    
   }

   include_once("header.php");
   ?>
<?php include 'config/defines.php'; ?>

<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

      <script type="text/javascript" src="lib/vtip/js/jquery.js"></script>
      <script type="text/javascript" src="lib/vtip/js/vtip.js"></script>
      <link rel="stylesheet" type="text/css" href="lib/vtip/css/vtip.css" />
      <script language="JavaScript" src="client/js/jsAddCompany.js" type="text/javascript"></script>

      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

      <style type="text/css">
         /*
            body,td,th {
                .center{width:900px; margin-left:auto; margin-right:auto;}
            
            }
            */

         .caret{
            color: #ac0810;
         }   

         .prod_table td, .prod_table th {
            vertical-align:top;
         }

         .prod_table th {
            padding-bottom: 15px;
         }
      </style>
   </head>
   <body>
   <center>
   <?php
           if($_SESSION['MESSAGE']) {
            echo $_SESSION['MESSAGE'];
           $_SESSION['MESSAGE']="";
            }
       ?>
    </center>

      <div class="center">

         <div id="main_color">
            <div id="singbutton_portion"></div>
            <div id="mainbutton">
              
              <form action="#" name="register" id="registerform" method="POST" >

               <table width="100%" cellspacing="2" border="0" >
                  <tr>
                     <td>&nbsp;</td>
                  </tr>
                  <tr>
                     <td class="blackbutton">Add Subscription</td>
                  </tr>
                  <tr>
                     <td>&nbsp;</td>
                  </tr>
                  
                  <tr>
                     <td valign="top" >
                           <input type="hidden" name="m" value="savecomp">
                           <input type="hidden" name="checkResult" id="checkResult" value="yes"/>
                           <table BORDER=0 width="100%" class="prod_table table table-striped" cellspacing="10" cellpadding="10">
                              <thead>
                                 <tr>
                                    <th></th>
                                    <th colspan="2" style="padding-bottom: 10px; padding-right: 10px">Product Description</th>
                                    <th>Unit Price(kr)</th>
                                    <th>Quantity</th>
                                    <th>Amount</th>
                                 </tr>
                              </thead>

                              <tbody>
                                                           
                                 <?php
                                    krsort($data);
                                    foreach ($data as $key => $value) {
                                  ?>

                              <tr>
                                 <td align="left">
                                  <?php if($value['product_name'] == "Anar Base Package"){ ?>
                                    <input type="checkbox" 
                                    name="" 
                                    value="<?=$value['plan_id']?>"  checked="checked" required>
                                  <?php }else{ ?>
                                    <input type="checkbox" 
                                    name="plan_id[]" 
                                    value="<?=$value['plan_id']?>">
                                   <?php } ?>
                                 </td>
                                 <td align="left" colspan="2" style="padding-right: 10px; padding-left: 10px">

                                    <?php if($value['product_name'] == "Anar Base Package"){ ?>
                                <div class="panel-group">
                                  <div class="panel panel-default">
                                    <div class="panel-heading">
                                       <h4 class="panel-title">
                                        <a data-toggle="collapse" href="#collapse1">Anar Base Package<span class="caret pull-right"></span></a>
                                       </h4>
                                    </div>
                                    <div id="collapse1" class="panel-collapse collapse">
                                      <ul class="list-group">
                                        <li class="list-group-item">Order status (incoming and delivered orders)
                                        </li>
                                        <li class="list-group-item">Order On-site (possibility to order for the customer)</li>
                                        <li class="list-group-item">Delivery and Payment confirmation</li>
                                        <li class="list-group-item">Kitchen Service including new orders and comments</li>
                                        <li class="list-group-item">Catering Service including delivery date/ time</li>
                                        <li class="list-group-item">Menu (Edit and add new dishes to Menu)</li>
                                        <li class="list-group-item">Administration support (Change company setting and information)</li>
                                        <li class="list-group-item">Additional features under “More” ooo</li>
                                      </ul>
                                    </div>
                                  </div>
                                </div>
                                    <?php }else{ ?>   
                                    <?=$value['product_name']?>

                                     <?php } ?>  

                                 </td>
                                 <td align="left">
                                    <?=$value['price']?>                 
                                 </td>
                                 <td align="left">
                                    1
                                 </td>
                                 <td align="left">
                                    <?=$value['price']*1?>                 
                                 </td>
                              </tr>

                                 <?php
                                    }
                                  ?>

                                                      
                           </tbody>

                           </table>
                     </td>
                  </tr>
                  
                 
               </table>

               <div>
                 <span class='mandatory'>* These Fields Are Mandatory</span>
               </div><br/>

               <div>
                 <input type="checkbox" name="" value="terms" required>
                                    Terms & Condition 
               </div>

               <div>
                 <span class='mandatory'>- Terms & Conditions have to be marked and accepted to be able to continue</span>
               </div><br/>

                    <div style="text-align: center;">
                      <input type="hidden" id="stripe_token" 
                        name="stripeToken" value="">

                      <input type="submit" value="Accept & Continue"  name="addCompanys" class="button_another" id="addCompanys" />
                   </div><br/>

                </form>


            </div>
         </div>
      </div>
      <? include("footer.php"); ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://checkout.stripe.com/checkout.js"></script>

        <script type="text/javascript">
          $(document).ready(function(){
            
          var handler = StripeCheckout.configure({
              key: "pk_test_5P1GedJTk0HsWb3AnjYBbz6G",
              name: "Dastjar",
              description: "<?=$_SESSION['username'];?>",
              image: "https://stripe.com/img/documentation/checkout/marketplace.png",
              label: "Donate",
              'panel-label': "Subscribe",
              locale: "auto",
                token: function(token) {
                  // You can access the token ID with `token.id`.
                  // Get the token ID to your server-side code for use.
                  // alert(token.id);

                  $('#stripe_token').val(token.id);
                  $('#registerform').submit();
                }
          });

          $('#registerform').submit(function(e){
            if($('#stripe_token').val()==""){
                e.preventDefault();
                handler.open({

                });              
            }
          });

          });          
        </script>

   </body>
</html>

<style type="text/css">
   .main_bg{display: inline-block;border-radius: 100px;
    padding: 6px 12px;
    vertical-align: middle;line-height: 24px;}
</style>