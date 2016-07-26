<?php

/*  File Name : afterActivation.php
 *  Description : Activation class and functions.
 *  Author  :Himanshu Singh  Date: 15th,Dec,2010  Creation
 */
$_SESSION['COMP_ID'] = "";

class afterActivation {
    /* Function Header :svrActivationDflt()
     *             Args: none
     *           Errors: none
     *     Return Value: none
     *      Description: User Activation default function
     */

    function svrActivationDflt() {

        if (isset($_REQUEST['m']) && $_REQUEST['m'] != '') {
            $mode = $_REQUEST['m'];
        } else {
            $mode = '';
        }

        switch ($mode) {
            case 'unsponsoredCampaignActivate':
                $reseller = $_REQUEST['reseller'];
                $this->unsponsoredCampaignActivationDetails($reseller);
                break;

            case 'unsponsoredAdvertiseActivate':
                $reseller = $_REQUEST['reseller'];
                $this->unsponsoredAdvertiseActivationDetails($reseller);
                break;

            // To do
            case 'unsponsoredStandardActivate':
                $reseller = $_REQUEST['reseller'];
                $this->unsponsoredStandardActivationDetails($reseller);
                break;

            case 'sponsoredCampaignActivate':
                $reseller = $_REQUEST['reseller'];
                $this->sponsoredCampaignActivationDetails($reseller);
                break;

            case 'sponsoredAdvertiseActivate':
                $reseller = $_REQUEST['reseller'];
                $this->sponsoredAdvertiseActivationDetails($reseller);
                break;

            // To do
            case 'sponsoredStandardActivate':
                $reseller = $_REQUEST['reseller'];
                //echo $reseller;die();
                $this->sponsoredStandardActivationDetails($reseller);
                break;

            case 'noOfferDetails':
                 $reseller = $_REQUEST['reseller'];
                $this->noCampaignActivationDetails($reseller);
                break;
        }
    }

    /* Function Header :unsponsoredCampaignActivationDetails()
     *             Args: none
     *           Errors: none
     *     Return Value: none
     *      Description:Update tables related to unsponsored Campaign.
     */

    function unsponsoredCampaignActivationDetails($reseller = '') {
        $inoutObj = new inOut();
        $db = new db();
        $arrUser = array();
          
        $query = "SELECT campaign_id, company_id FROM campaign WHERE u_id = '" . $_SESSION['userid'] . "'";
        $res = mysql_query($query) or die(mysql_error());
        $arrUser1 = mysql_fetch_array($res);
        $camp_id = $arrUser1['campaign_id'];
        $comp_id = $arrUser1['company_id'];

        $query = "UPDATE company SET c_activ = '1'
                 WHERE company_id = '" . $comp_id . "'";
        $res = mysql_query($query) or die(mysql_error());

        $this->updateStoreCampaign($camp_id);
        ///////Update user table activ field/////////////////////////////
        $query = "UPDATE user SET activ='5' WHERE u_id = '" . $_SESSION['userid'] . "'";
        $res = mysql_query($query) or die(mysql_error());

        $_SESSION['active_state'] = 5;

        if (isset($_SESSION['MAIL_URL'])) {


                    $url = $_SESSION['MAIL_URL'];
                    $_SESSION['MAIL_URL'] = "";
                    $inoutObj->reDirect($url);
                    exit();
                }

        if ($reseller == '') {
        $url = BASE_URL . 'showCampaign.php';
        $inoutObj->reDirect($url);
        exit();
        } else {
     $url = BASE_URL . 'showResellerCampaign.php';
        $inoutObj->reDirect($url);
        exit();
        }
    }

    /* Function Header :unsponsoredStandardActivationDetails()
     *             Args: none
     *           Errors: none
     *     Return Value: none
     *      Description:Update tables related to unsponsored Standard.
     */

    function unsponsoredStandardActivationDetails($reseller = '') {
        //echo "In Function"; die();
        $inoutObj = new inOut();
        $db = new db();
        $arrUser = array();

        $query = "SELECT product_id, company_id FROM product WHERE u_id = '" . $_SESSION['userid'] . "'";
        $res = mysql_query($query) or die(mysql_error());
        $arrUser1 = mysql_fetch_array($res);
        $prod_id = $arrUser1['product_id'];
        $comp_id = $arrUser1['company_id'];

        $query = "UPDATE company SET c_activ = '1'
                 WHERE company_id = '" . $comp_id . "'";
        $res = mysql_query($query) or die(mysql_error());

        $this->updateStoreStandard($prod_id);
        ///////Update user table activ field/////////////////////////////
        $query = "UPDATE user SET activ='5' WHERE u_id = '" . $_SESSION['userid'] . "'";
        $res = mysql_query($query) or die(mysql_error());

        $_SESSION['active_state'] = 5;

        if (isset($_SESSION['MAIL_URL'])) {


                    $url = $_SESSION['MAIL_URL'];
                    $_SESSION['MAIL_URL'] = "";
                    $inoutObj->reDirect($url);
                    exit();
                }
        if ($reseller == '') {
        $url = BASE_URL . 'showCampaign.php';
        $inoutObj->reDirect($url);
        exit();
  }  else {

       $url = BASE_URL . 'showResellerCampaign.php';
        $inoutObj->reDirect($url);
        exit();
  }
    }

    /* Function Header :sponsoredCampaignActivationDetails()
     *             Args: none
     *           Errors: none
     *     Return Value: none
     *      Description:Update tables related to sponsored Campaign.
     */

    function sponsoredCampaignActivationDetails($reseller = '') {
        // echo $reseller;die();
// echo("here");exit;
        $inoutObj = new inOut();
        $db = new db();
        $error = '';
        $arrUser = array();

        $arrUser['pre_loaded_value'] = $_POST['loadaccount'];
        $arrUser['budget'] = $_POST['maxcost'];


        //$error.= ($arrUser['budget'] =='')?ERROR_BUDGET :'';

        if ($error != '') {

            $_SESSION['MESSAGE'] = $error;
            $_SESSION['post'] = $_POST;
            if ($reseller == '') {
            $url = BASE_URL . 'activate.php';
            $inoutObj->reDirect($url);
            exit();
            } else {
            $url = BASE_URL . 'resellerActivation.php';
            $inoutObj->reDirect($url);
            exit();
            }
        } else {
            $_SESSION['post'] = "";
        }

        $query = "SELECT campaign_id, company_id FROM campaign WHERE u_id = '" . $_SESSION['userid'] . "'";
        $res = mysql_query($query) or die(mysql_error());
        $arrUser1 = mysql_fetch_array($res);
        $camp_id = $arrUser1['campaign_id'];
        $comp_id = $arrUser1['company_id'];

        $query = "UPDATE company
                 SET budget = '" . $arrUser['budget'] . "',
                     pre_loaded_value = '" . $arrUser['pre_loaded_value'] . "',
                     c_activ = '1'
                 WHERE company_id = '" . $comp_id . "'";
        $res = mysql_query($query) or die(mysql_error());

        $this->updateStoreCampaign($camp_id);
        ///////Update user table activ field/////////////////////////////
        $query = "UPDATE user SET activ='5' WHERE u_id = '" . $_SESSION['userid'] . "'";
        $res = mysql_query($query) or die(mysql_error());

        $_SESSION['active_state'] = 5;

         if (isset($_SESSION['MAIL_URL'])) {


                    $url = $_SESSION['MAIL_URL'];
                    $_SESSION['MAIL_URL'] = "";
                    $inoutObj->reDirect($url);
                    exit();
                }
                //echo $reseller;die();
        if ($reseller == '') {
        $url = BASE_URL . 'showCampaign.php';
        $inoutObj->reDirect($url);
        exit();
         } else {
        $url = BASE_URL . 'showResellerCampaign.php';
        $inoutObj->reDirect($url);
        exit();
         }
    }

    /* Function Header :sponsoredStandardActivationDetails()
     *             Args: none
     *           Errors: none
     *     Return Value: none
     *      Description:Update tables related to sponsored Standard.
     */

    function sponsoredStandardActivationDetails($reseller = '') {

// echo("here");exit;
        $inoutObj = new inOut();
        $db = new db();
        $error = '';
        $arrUser = array();

        $arrUser['pre_loaded_value'] = $_POST['loadaccount'];
        $arrUser['budget'] = $_POST['maxcost'];

        //$error.= ($arrUser['budget'] =='')?ERROR_BUDGET :'';

        if ($error != '') {

            $_SESSION['MESSAGE'] = $error;
            $_SESSION['post'] = $_POST;
            if ($reseller == '') {
            $url = BASE_URL . 'activate.php';
            $inoutObj->reDirect($url);
            exit();
            } else {
             $url = BASE_URL . 'resellerActivation.php';
            $inoutObj->reDirect($url);
            exit();
            }
        } else {
            $_SESSION['post'] = "";

            $query = "SELECT product_id, company_id FROM product WHERE u_id = '" . $_SESSION['userid'] . "'";
            $res = mysql_query($query) or die(mysql_error());
            $arrUser1 = mysql_fetch_array($res);
            $prod_id = $arrUser1['product_id'];
            $comp_id = $arrUser1['company_id'];

            $query = "UPDATE company
                 SET budget = '" . $arrUser['budget'] . "',
                     pre_loaded_value = '" . $arrUser['pre_loaded_value'] . "',
                     c_activ = '1'
                 WHERE company_id = '" . $comp_id . "'";
            $res = mysql_query($query) or die(mysql_error());

            $this->updateStoreStandard($prod_id);
            ///////Update user table activ field/////////////////////////////
            $query = "UPDATE user SET activ='5' WHERE u_id = '" . $_SESSION['userid'] . "'";
            $res = mysql_query($query) or die(mysql_error());

            $_SESSION['active_state'] = 5;

             if (isset($_SESSION['MAIL_URL'])) {


                    $url = $_SESSION['MAIL_URL'];
                    $_SESSION['MAIL_URL'] = "";
                    $inoutObj->reDirect($url);
                    exit();
                }

            if ($reseller == '') {
            $url = BASE_URL . 'showCampaign.php';
            $inoutObj->reDirect($url);
            exit();
                } else {
            $url = BASE_URL . 'showResellerCampaign.php';
            $inoutObj->reDirect($url);
            exit();
                }
        }
    }

    function noCampaignActivationDetails($reseller = '') {
      
        
        $inoutObj = new inOut();
        $db = new db();
        $error = '';
        $arrUser = array();

        ///////Update user table activ field/////////////////////////////
        $query = "UPDATE user SET activ='5' WHERE u_id = '" . $_SESSION['userid'] . "'";
        $res = mysql_query($query) or die(mysql_error());

        $_SESSION['active_state'] = 5;

         if (isset($_SESSION['MAIL_URL'])) {


                    $url = $_SESSION['MAIL_URL'];
                    $_SESSION['MAIL_URL'] = "";
                    $inoutObj->reDirect($url);
                    exit();
                }
        if ($reseller == '') {
        $url = BASE_URL . 'showCampaign.php';
        $inoutObj->reDirect($url);
        exit();
        } else {
         $url = BASE_URL . 'showResellerCampaign.php';
        $inoutObj->reDirect($url);
        exit();
    }
    }

    /* Function Header :updateStoreCampaign()
     *             Args: none
     *           Errors: none
     *     Return Value: none
     *      Description: Update store and c_s_rel if store is added for campaign offer in registration process.
     */

    function updateStoreCampaign($campId) {
        $_SQL = "select store_id FROM store WHERE u_id='" . $_SESSION['userid'] . "'";
        $res = mysql_query($_SQL) or die(mysql_error());
        if (mysql_num_rows($res)) {
            $query = "UPDATE store SET s_activ='1' WHERE u_id='" . $_SESSION['userid'] . "'";
            $res = mysql_query($query) or die(mysql_error());

            $query = "UPDATE c_s_rel SET activ = '1' WHERE campaign_id ='" . $campId . "'";
            $res = mysql_query($query) or die(mysql_error());
        }
    }

    /* Function Header :updateStoreStandard()
     *             Args: none
     *           Errors: none
     *     Return Value: none
     *      Description:Update store and c_s_rel if store is added for standard offer in registration process.
     */

    function updateStoreStandard($prodId) {
        $_SQL = "select store_id FROM store WHERE u_id='" . $_SESSION['userid'] . "'";
        $res = mysql_query($_SQL) or die(mysql_error());
        if (mysql_num_rows($res)) {
            $query = "UPDATE store SET s_activ='1'
		WHERE u_id='" . $_SESSION['userid'] . "'";
            $res = mysql_query($query) or die(mysql_error());

            $query = "UPDATE c_s_rel SET activ = '1'
                WHERE product_id ='" . $prodId . "'";
            $res = mysql_query($query) or die(mysql_error());
        }
    }
// code related to advertise 
    /* Function Header :updateStoreAdvertise()
     *             Args: none
     *           Errors: none
     *     Return Value: none
     *      Description: Update store and c_s_rel if store is added for advertise offer in registration process.
     */

    function updateStoreAdvertise($advtId) {
        $_SQL = "select store_id FROM store WHERE u_id='" . $_SESSION['userid'] . "'";
        $res = mysql_query($_SQL) or die(mysql_error());
        if (mysql_num_rows($res)) {
            $query = "UPDATE store SET s_activ='1' WHERE u_id='" . $_SESSION['userid'] . "'";
            $res = mysql_query($query) or die(mysql_error());

            $query = "UPDATE c_s_rel SET activ = '1' WHERE advertise_id ='" . $advtId . "'";
            $res = mysql_query($query) or die(mysql_error());
        }
    }

    /* Function Header :unsponsoredAdvertiseActivationDetails()
     *             Args: none
     *           Errors: none
     *     Return Value: none
     *      Description:Update tables related to unsponsored Advertise.
     */

    function unsponsoredAdvertiseActivationDetails($reseller = '') {
        $inoutObj = new inOut();
        $db = new db();
        $arrUser = array();

        $query = "SELECT advertise_id, company_id FROM advertise WHERE u_id = '" . $_SESSION['userid'] . "'";
        $res = mysql_query($query) or die(mysql_error());
        $arrUser1 = mysql_fetch_array($res);
        $advt_id = $arrUser1['advertise_id'];
        $comp_id = $arrUser1['company_id'];

        $query = "UPDATE company SET c_activ = '1'
                 WHERE company_id = '" . $comp_id . "'";
        $res = mysql_query($query) or die(mysql_error());

        $this->updateStoreAdvertise($advt_id);
        ///////Update user table activ field/////////////////////////////
        $query = "UPDATE user SET activ='5' WHERE u_id = '" . $_SESSION['userid'] . "'";
        $res = mysql_query($query) or die(mysql_error());

        $_SESSION['active_state'] = 5;

        if (isset($_SESSION['MAIL_URL'])) {


            $url = $_SESSION['MAIL_URL'];
            $_SESSION['MAIL_URL'] = "";
            $inoutObj->reDirect($url);
            exit();
        }

        if ($reseller == '') {
            $url = BASE_URL . 'showAdvertise.php';
            $inoutObj->reDirect($url);
            exit();
        } else {
            $url = BASE_URL . 'showResellerAdvertise.php';
            $inoutObj->reDirect($url);
            exit();
        }
    }

    /* Function Header :sponsoredAdvertiseActivationDetails()
     *             Args: none
     *           Errors: none
     *     Return Value: none
     *      Description:Update tables related to sponsored Advertise.
     */

    function sponsoredAdvertiseActivationDetails($reseller = '') {
        // echo $reseller;die();
// echo("here");exit;
        $inoutObj = new inOut();
        $db = new db();
        $error = '';
        $arrUser = array();

        $arrUser['pre_loaded_value'] = $_POST['loadaccount'];
        $arrUser['budget'] = $_POST['maxcost'];


        //$error.= ($arrUser['budget'] =='')?ERROR_BUDGET :'';

        if ($error != '') {

            $_SESSION['MESSAGE'] = $error;
            $_SESSION['post'] = $_POST;
            if ($reseller == '') {
                $url = BASE_URL . 'activate.php';
                $inoutObj->reDirect($url);
                exit();
            } else {
                $url = BASE_URL . 'resellerActivation.php';
                $inoutObj->reDirect($url);
                exit();
            }
        } else {
            $_SESSION['post'] = "";
        }

        $query = "SELECT advertise_id, company_id FROM advertise WHERE u_id = '" . $_SESSION['userid'] . "'";
        $res = mysql_query($query) or die(mysql_error());
        $arrUser1 = mysql_fetch_array($res);
        $advt_id = $arrUser1['advertise_id'];
        $comp_id = $arrUser1['company_id'];

        $query = "UPDATE company
                 SET budget = '" . $arrUser['budget'] . "',
                     pre_loaded_value = '" . $arrUser['pre_loaded_value'] . "',
                     c_activ = '1'
                 WHERE company_id = '" . $comp_id . "'";
        $res = mysql_query($query) or die(mysql_error());

        $this->updateStoreAdvertise($advt_id);
        ///////Update user table activ field/////////////////////////////
        $query = "UPDATE user SET activ='5' WHERE u_id = '" . $_SESSION['userid'] . "'";
        $res = mysql_query($query) or die(mysql_error());

        $_SESSION['active_state'] = 5;

        if (isset($_SESSION['MAIL_URL'])) {


            $url = $_SESSION['MAIL_URL'];
            $_SESSION['MAIL_URL'] = "";
            $inoutObj->reDirect($url);
            exit();
        }
        //echo $reseller;die();
        if ($reseller == '') {
            $url = BASE_URL . 'showAdvertise.php';
            $inoutObj->reDirect($url);
            exit();
        } else {
            $url = BASE_URL . 'showResellerAdvertise.php';
            $inoutObj->reDirect($url);
            exit();
        }
    }

}

?>