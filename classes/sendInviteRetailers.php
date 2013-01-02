<?php

/* File Name : registration.php
 *  Description : Registration class and functions
 *  Author  : Himanshu Singh  Date: 17th,jan 2010
 */

class sendInviteRetailers {
    /* Function Header :svrRegDflt()
     *             Args: none
     *           Errors: none
     *     Return Value: none
     *      Description: User Registration default function
     */

    function inviteRetailers() {

        if (isset($_REQUEST['m']) && $_REQUEST['m'] != '') {
            $mode = $_REQUEST['m'];
        } else {
            $mode = '';
        }

        switch ($mode) {

            case 'sendMail':
                $reseller = $_REQUEST['reseller'];
                $this->sendRetailers($reseller);
                break;

            case 'sendMailRetailers':
                $reseller = $_REQUEST['reseller'];
                $this->sendRetailersMail($reseller);
                break;
            

        }
    }

    function sendRetailers($reseller='') {
        //print_r($_SESSION);
		//echo "hiiii";exit;
        $inoutObj = new inOut();
        $db = new db();
        $arrUser = array();
        $error = '';


        $arrUser['email'] = $_POST['email'];
        $arrUser['message'] = $_POST['message'];
        $ccode = trim($_POST['ccode']);
        
        $error.= ( $arrUser['email'] == '') ? ERROR_EMAIL : '';

       // $error.= ( $arrUser['message'] == '') ? ERROR_MESSAGE : '';

        if ($error != '') {
            $_SESSION['MESSAGE'] = $error;
            $_SESSION['post'] = $_POST;
            if($reseller == '')
            {
            $url = BASE_URL . 'inviteRetailers.php';
             $inoutObj->reDirect($url);
            exit();
            } else {
                 $url = BASE_URL . 'inviteResellerRetailers.php';
                  $inoutObj->reDirect($url);
            exit();
            }

        } else {
           
            $res = $db->query("Select * FROM campaign WHERE u_id='" . $_SESSION['userid'] . "'");
            $rs = mysql_fetch_array($res);
            $data = $rs;
            if (mysql_num_rows($res)) {
                if($reseller != '') {

                 ////check this mail id having another reseller or not
            $res = $db->query("Select * FROM user WHERE email='" . $arrUser['email'] . "'");
            $rs = mysql_fetch_array($res);
            $value = $rs['email'];
            if($value != '')
            {
                $query = "select u_id from user where email = '" . $value . "'";
                $res = mysql_query($query);
                $rs = mysql_fetch_array($res);
                $id = $rs['u_id'];


                $query1 = "select * from company where u_id = '" . $id . "'";
                $res1 = mysql_query($query1);
                $rs1 = mysql_fetch_array($res1);
                $resellerId = $rs1['seller_id'];
                $checkCompanyId = $rs1['company_id'];

              if(($checkCompanyId == '') && ($value != ''))
              { 
                $query2 = "select company_id from employer where u_id = '" . $id . "'";
                $res2 = mysql_query($query2);
                $rs2 = mysql_fetch_array($res2);
                $employCompanyId = $rs2['company_id'];

                $query3 = "select * from company where company_id = '" . $employCompanyId . "'";
                $res3 = mysql_query($query3);
                $rs3 = mysql_fetch_array($res3);
                $emplResellerId = $rs3['seller_id'];


                if(($emplResellerId == '') || ($emplResellerId == $_SESSION['userid'])) {

                  $msg = BASE_URL . "viewResellerCampaign.php?campaignId=" . $data['campaign_id'].'&ccode='.$ccode.'&uId='.$data['u_id'];
           // $msg = BASE_URL . "viewResellerCampaign.php?campaignId=" . $campaignId.'&ccode='.$ccode.'&uId='.$data['u_id'];
               }

               else if($emplResellerId != $_SESSION['userid'])
                {
                  $_SESSION['MESSAGE'] = NOT_ALLOWED_RETALER;
                  $url = BASE_URL . 'inviteResellerRetailers.php';
                  $inoutObj->reDirect($url);
                  exit;
                }

            

              }
              else if($checkCompanyId != '')
              {

                 if(($resellerId == '') || ($resellerId == $_SESSION['userid'])) {

             $msg = BASE_URL . "viewResellerCampaign.php?campaignId=" . $data['campaign_id'].'&ccode='.$ccode.'&uId='.$data['u_id'];
           // $msg = BASE_URL . "viewResellerCampaign.php?campaignId=" . $campaignId.'&ccode='.$ccode.'&uId='.$data['u_id'];
               }

                else if($resellerId != $_SESSION['userid'])
                {
                  $_SESSION['MESSAGE'] = NOT_ALLOWED_RETALER;
                  $url = BASE_URL . 'inviteResellerRetailers.php';
                  $inoutObj->reDirect($url);
                  exit;
                }


              }

            }else{
                 $msg = BASE_URL . "viewResellerCampaign.php?campaignId=" . $data['campaign_id'].'&ccode='.$ccode.'&uId='.$data['u_id'];
                //$msg = BASE_URL . "viewResellerCampaign.php?campaignId=" . $campaignId.'&ccode='.$ccode.'&uId='.$data['u_id'];
            }
                         
            }

               
                else {
                     $msg = BASE_URL . "viewCampaignRetailer.php?campaignId=" . $data['campaign_id'];
                }
            } else {
                $res = $db->query("Select * FROM product WHERE u_id='" . $_SESSION['userid'] . "'");
                $rs = mysql_fetch_array($res);
                $data = $rs;
                 if($reseller != '') {
                $msg = BASE_URL . "viewResellerStandard.php?productId=" . $data[product_id].'&ccode='.$ccode.'&uId='.$data['u_id'];
                 }else {
                     $msg = BASE_URL . "viewStandardRetailer.php?productId=" . $data[product_id];
                 }
                }

             $fMsg = "<a href=".$msg.">".$msg."</a>";
           $uId = $_SESSION['userid']; 
            $emails = $arrUser['email'];
            //$messages = $arrUser['message'] . "&nbsp;" . $msg;
            $mailObj = new emails();

             if($arrUser['message'])
                {
                $messages = $arrUser['message'] . "<br>" . $fMsg;
                }
                else
                {
                    $defaultMsg = INVITE_RETAILER_DEFALUTMSG;
                    $messages = $defaultMsg . "<br>" . $fMsg;
                }


            $mailObj->sendEmailRetailers($uId, $emails, $messages);
            // These session variable bea ctive if user has been complete his mail varification
            //$_SESSION['userid'] = $data['u_id'];
            //$_SESSION['userrole'] = $data['role'];
            //$_SESSION['username'] = $arrUser['fname'] . " " . $arrUser['lname'];
            //$_SESSION['userid'] = $rowUniqueId;
            if($reseller == '')
            {
            $url = BASE_URL . 'registrationStep.php';
            $inoutObj->reDirect($url);
            exit();
            } else {
            $url = BASE_URL . 'registrationResellerStep.php';
            $inoutObj->reDirect($url);
            exit();
            }
        }
    }

//    function sendMailRetailersStand() {
//        //echo "hiiii";exit;
//        $inoutObj = new inOut();
//        $db = new db();
//        $arrUser = array();
//        $error = '';
//
//
//        $arrUser['email'] = $_POST['email'];
//        $arrUser['message'] = $_POST['message'];
//
//        $error.= ( $arrUser['email'] == '') ? ERROR_EMAIL : '';
//
//        //$error.= ( $arrUser['message'] == '') ? ERROR_MESSAGE : '';
//
//        if ($error != '') {
//            $_SESSION['MESSAGE'] = $error;
//            $_SESSION['post'] = $_POST;
//            $url = BASE_URL . 'inviteRetailersStand.php';
//
//            $inoutObj->reDirect($url);
//            exit();
//        } else {
//            $productId = $_POST['productId'];
//
//         $msg = BASE_URL . "viewStandardRetailer.php?productId=" . $productId;
////die;
////            else {
////                $res = $db->query("Select * FROM product WHERE u_id='" . $_SESSION['userid'] . "'");
////                $rs = mysql_fetch_array($res);
////                $data = $rs;
////                $msg = BASE_URL . "viewStandard.php?productId=" . $data[product_id];
////            }
//            $uId = $_SESSION['userid'];
//            $emails = $arrUser['email'];
//            $messages = $arrUser['message'] . "&nbsp;" . $msg;
//            $mailObj = new emails();
//
//            if($arrUser['message'])
//                {
//                $messages = $arrUser['message'] . "<br>" . $msg;
//                }
//                else
//                {
//                    $defaultMsg = INVITE_RETAILER_DEFALUTMSG;
//                    $messages = $defaultMsg . "<br>" . $msg;
//                }
//
//
//            $mailObj->sendEmailRetailers($uId, $emails, $messages);
//            // These session variable bea ctive if user has been complete his mail varification
//           /* $_SESSION['userid'] = $data['u_id'];
//            $_SESSION['userrole'] = $data['role'];
//            $_SESSION['username'] = $arrUser['fname'] . " " . $arrUser['lname'];
//            $_SESSION['userid'] = $rowUniqueId;   */
//            $_SESSION['MESSAGE'] = INVITE_RETAILERS_STAND;
//            $url = BASE_URL . 'showStandard.php';
//            $inoutObj->reDirect($url);
//            exit();
//        }
//    }


    function sendRetailersMail($reseller='') {
        //echo "hiiii";exit;
        $inoutObj = new inOut();
        $db = new db();
        $arrUser = array();
        $error = '';


        $arrUser['email'] = $_POST['email'];
        $arrUser['message'] = $_POST['message'];
        $ccode = trim($_POST['ccode']);


        $error.= ( $arrUser['email'] == '') ? ERROR_EMAIL : '';

        $productId = $_POST['productId'];
         $campaignId = $_POST['campaignId'];
        
      
        if ($error != '') {
            $_SESSION['MESSAGE'] = $error;
            $_SESSION['post'] = $_POST;
            if($reseller == '')
            {
            $url = BASE_URL . 'showCampaign.php';
            $inoutObj->reDirect($url);
            exit();
            } else {
            $url = BASE_URL . 'showResellerCampaign.php';
            $inoutObj->reDirect($url);
            exit();
            }
        }

        
           
        if($campaignId)
          {
            $res = $db->query("Select * FROM campaign WHERE u_id='" . $_SESSION['userid'] . "'");
            $rs = mysql_fetch_array($res);
            $data = $rs;
             if($reseller != '') {
             ////check this mail id having another reseller or not
            $res = $db->query("Select * FROM user WHERE email='" . $arrUser['email'] . "'");
            $rs = mysql_fetch_array($res);
            $value = $rs['email'];
            if($value != '')
            { 
                $query = "select u_id from user where email = '" . $value . "'";
                $res = mysql_query($query);
                $rs = mysql_fetch_array($res);
                $id = $rs['u_id'];

               
                $query1 = "select * from company where u_id = '" . $id . "'";
                $res1 = mysql_query($query1);
                $rs1 = mysql_fetch_array($res1);
                $resellerId = $rs1['seller_id'];
                $checkCompanyId = $rs1['company_id'];

              if(($checkCompanyId == '') && ($value != ''))
              { 
                $query2 = "select company_id from employer where u_id = '" . $id . "'";
                $res2 = mysql_query($query2);
                $rs2 = mysql_fetch_array($res2);
                $employCompanyId = $rs2['company_id'];

                $query3 = "select * from company where company_id = '" . $employCompanyId . "'";
                $res3 = mysql_query($query3);
                $rs3 = mysql_fetch_array($res3);
                $emplResellerId = $rs3['seller_id'];

                 if(($emplResellerId == '') || ($emplResellerId == $_SESSION['userid'])) {

            $msg = BASE_URL . "viewResellerCampaign.php?campaignId=" . $campaignId.'&ccode='.$ccode.'&uId='.$data['u_id'];
               }


               else if($emplResellerId != $_SESSION['userid'])
                { 
                  $_SESSION['MESSAGE'] = NOT_ALLOWED_RETALER;
                  $url = BASE_URL . 'showResellerCampaign.php';
                  $inoutObj->reDirect($url);
                  exit;
                }
               
            

              }
              else if($checkCompanyId != '')
              { 
              
                 if(($resellerId == '') || ($resellerId == $_SESSION['userid'])) {

            $msg = BASE_URL . "viewResellerCampaign.php?campaignId=" . $campaignId.'&ccode='.$ccode.'&uId='.$data['u_id'];
               }

                else if($resellerId != $_SESSION['userid'])
                {
                  $_SESSION['MESSAGE'] = NOT_ALLOWED_RETALER;
                  $url = BASE_URL . 'showResellerCampaign.php';
                  $inoutObj->reDirect($url);
                  exit;
                }

           
              }
           
            }else{
                $msg = BASE_URL . "viewResellerCampaign.php?campaignId=" . $campaignId.'&ccode='.$ccode.'&uId='.$data['u_id'];
            }

            }else {
                 $msg = BASE_URL . "viewCampaignRetailer.php?campaignId=" . $campaignId;
             }
            }
           
        if($productId)
        {  $res = $db->query("Select * FROM product WHERE u_id='" . $_SESSION['userid'] . "'");
                $rs = mysql_fetch_array($res);
                $data = $rs;
                 if($reseller != '') {
            $msg = BASE_URL . "viewResellerStandard.php?productId=" . $productId.'&ccode='.$ccode.'&uId='.$data['u_id'];
                 }else {
                     $msg = BASE_URL . "viewStandardRetailer.php?productId=" . $productId;
                 }
                 }
	
      $fMsg = "<a href=".$msg.">".$msg."</a>";
       $uId = $_SESSION['userid'];
            $emails = $arrUser['email'];
            if($arrUser['message'])
                {
                $messages = $arrUser['message'] . "<br>" . $fMsg;
                }
                else
                {
                    $defaultMsg = INVITE_RETAILER_DEFALUTMSG;
                    $messages = $defaultMsg . "<br>" . $fMsg;
                }
            $mailObj = new emails();
            $mailObj->sendEmailRetailers($uId, $emails, $messages);


            if($campaignId)
            {

             $_SESSION['MESSAGE'] = INVITE_RETAILERS;
              if($reseller != '') {
                 $url = BASE_URL . 'showResellerCampaign.php';
            $inoutObj->reDirect($url);
            exit();
              }else {
                   $url = BASE_URL . 'showCampaign.php';
            $inoutObj->reDirect($url);
            exit();
              }
           
            }

           if($productId)

                if($reseller != '') {
                 $url = BASE_URL . 'showResellerStandard.php';
            $inoutObj->reDirect($url);
            exit();
              }else {
                   $url = BASE_URL . 'showStandard.php';
            $inoutObj->reDirect($url);
            exit();
              }
        
     }

}
?>
