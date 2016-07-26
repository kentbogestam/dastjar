<?php

/*  File Name : addCompany.php
 *  Description : Add Company Form
 *  Author  :Himanshu Singh  Date: 23rd,Nov,2010  Creation
 */

//print_r($_SESSION);
//$_SESSION['COMP_ID']="";
class store {
    /* Function Header :svrStoreDflt()
     *             Args: none
     *           Errors: none
     *     Return Value: none
     *      Description: User Create Store default function
     */

    function svrStoreDflt($paging_limit = '0 , 10') {

        if (isset($_REQUEST['m']) && $_REQUEST['m'] != '') {
            $mode = $_REQUEST['m'];
        } else {
            $mode = '';
        }
        switch ($mode) {
            case 'saveStore':
                $this->saveStoreDetails();
                break;
            case 'saveNewStore':
                $this->saveNewStoreDetails();
                break;
            case 'showOutdatedStore':
                return $this->showOutdatedStore($paging_limit);
                break;
            case 'editSaveStore':
                return $this->editSaveStore($storeid);
                break;
            case 'deleteStore':
                //echo "here"; die();
                $this->deleteStoreById();
                break;

//            case 'deleteDeactiveStore':
//                //echo "here"; die();
//                $this->deleteDeactiveStore();
//                break;

            default:
                return $this->showStore($paging_limit);
                break;
        }
    }

    /* Function Header :saveStoreDetails()
     *             Args: none
     *           Errors: none
     *     Return Value: none
     *      Description:To save all the details related to the Store in the database
     */

    function saveStoreDetails() {
        $inoutObj = new inOut();
        $db = new db();
        $arrUser = array();
        $error = '';

        $arrUser['store_name'] = $_POST['storeName'];
        $arrUser['street'] = $_POST['streetaddStore'];
        $arrUser['city'] = $_POST['cityStore'];
        $arrUser['country'] = $_POST['countryStore'];
        $arrUser['latitude'] = $_POST['latitude'];
        $arrUser['longitude'] = $_POST['longitude'];
        $arrUser['email'] = $_POST['email'];
        $arrUser['phone'] = $_POST['phoneNo'];
        $arrUser['link'] = $_POST['link'];
        $arrUser['chain'] = $_POST['chain'];
        $arrUser['block'] = $_POST['block'];
        $arrUser['zip'] = $_POST['zip'];
        // string matching
        $filestring = $arrUser['link'];
        $findme  = 'http://';
        $pos = strpos($filestring, $findme);
        if ($pos === false) {
            $arrUser['link'] = 'http://' . $filestring;
        } else {
            $arrUser['link'] = $filestring;
        }

        $arrUser['BARCODE'] = $_POST['BARCODE'];
        $arrUser['DPS'] = $_POST['DPS'];

        $error.= ( $arrUser['store_name'] == '') ? ERROR_STORE_NAME : '';

        $error.= ( $arrUser['street'] == '') ? ERROR_STREET_ADDRESS : '';

        $error.= ( $arrUser['city'] == '') ? ERROR_CITY_STORE : '';

        $error.= ( $arrUser['country'] == '') ? ERROR_COUNTRY - STORE : '';

        
        $error.= ( $arrUser['email'] == '') ? ERROR_EMAIL : '';

        $error.= ( $arrUser['phone'] == '') ? ERROR_PHONE_NUMBER : '';

        $error.= ( $arrUser['link'] == '') ? ERROR_LINK : '';

        if ($error != '') {
            $_SESSION['MESSAGE'] = $error;
            $_SESSION['post'] = $_POST;
            $url = BASE_URL . 'createStore.php';

            $inoutObj->reDirect($url);
            exit();
        }

        else
            $_SESSION['post'] = "";

        $contry = $arrUser['country'];
        $query = "select * from country where name = '" . $contry . "'";
        $res = mysql_query($query) or die(mysql_error());
        $rs = mysql_fetch_array($res);
        $coutryIso = $rs['iso'];

        $storeUniqueId = uuid();
        $query = "INSERT into store(`store_id`,`u_id`,`store_name`,`street`,`city`,`country`,`latitude`,`longitude`,`email`,`phone`,`store_link`,`country_code`,`access_type`,`chain`,`block`,`zip`)
                 VALUES('" . $storeUniqueId . "','" . $_SESSION['userid'] . "','" . $arrUser['store_name'] . "','" . $arrUser['street'] . "','" . $arrUser['city'] . "','" . $arrUser['country'] . "','" . $arrUser['latitude'] . "','" . $arrUser['longitude'] . "','" . $arrUser['email'] . "','" . $arrUser['phone'] . "','" . $arrUser['link'] . "','" . $coutryIso . "','1','" . $arrUser['chain'] . "','" . $arrUser['block'] . "','" . $arrUser['zip'] . "')";
        $res = mysql_query($query) or die('1' . mysql_error());

      $query = "INSERT into coupon_delivery_method(`store`,`delivery_method`)
                 VALUES('" . $storeUniqueId . "','PINCODE')";
        $res = mysql_query($query) or die(mysql_error());

        $query = "INSERT into coupon_delivery_method(`store`,`delivery_method`)
                 VALUES('" . $storeUniqueId . "','TIME_LIMIT')";
        $res = mysql_query($query) or die(mysql_error());

        $query = "INSERT into coupon_delivery_method(`store`,`delivery_method`)
                 VALUES('" . $storeUniqueId . "','MANUAL_SWIPE')";
        $res = mysql_query($query) or die(mysql_error());

        if (isset($arrUser['BARCODE'])) {
          $query = "INSERT into coupon_delivery_method(`store`,`delivery_method`)
                 VALUES('" . $storeUniqueId . "','BARCODE')";
        $res = mysql_query($query) or die(mysql_error());
        }


        if (isset($arrUser['DPS'])) {  /// New Option
            $query = "INSERT into coupon_delivery_method(`store`,`delivery_method`)
                 VALUES('" . $storeUniqueId . "','AUTO')";
            $res = mysql_query($query) or die(mysql_error());
        }

         /////////////////////////////////////////////////////////////////////////////////////////////
        //To check whether store belongs to Campaign or advertise or Product and update coupon related to that table
        $query = "SELECT * FROM campaign WHERE u_id='" . $_SESSION['userid'] . "'";
        $res = mysql_query($query) or die('2' . mysql_error());

        if (mysql_num_rows($res)) {
            $row = mysql_fetch_array($res);
            $camp_id = $row['campaign_id'];
            $start_publishing = $row['start_of_publishing'];
            $end_publishing = $row['end_of_publishing'];

           $query = "INSERT into c_s_rel(`campaign_id`,`store_id`,`start_of_publishing`,`end_of_publishing`)
                 VALUES('" . $camp_id . "','" . $storeUniqueId . "','" . $start_publishing . "','" . $end_publishing . "')";
            $res = mysql_query($query) or die('3' . mysql_error());

            //$query = "UPDATE coupon SET store_id = '$storeUniqueId' WHERE campaign_id='" . $camp_id . "'";
            //$res = mysql_query($query) or die(mysql_error());
        } else {
           
            $query = "SELECT * FROM advertise WHERE u_id='" . $_SESSION['userid'] . "'";
           
            $res = mysql_query($query) or die('2' . mysql_error());

            if (mysql_num_rows($res)) {
                $row = mysql_fetch_array($res);
                $advt_id = $row['advertise_id'];
                $start_publishing = $row['start_of_publishing'];
                $end_publishing = $row['end_of_publishing'];
                
                 $query = "INSERT into c_s_rel(`advertise_id`,`store_id`,`start_of_publishing`,`end_of_publishing`)
                     VALUES('" . $advt_id . "','" . $storeUniqueId . "','" . $start_publishing . "','" . $end_publishing . "')";
                
                $res = mysql_query($query) or die('3' . mysql_error());

            //$query = "UPDATE coupon SET store_id = '$storeUniqueId' WHERE campaign_id='" . $camp_id . "'";
            //$res = mysql_query($query) or die(mysql_error());
        } else {
            $query = "SELECT * FROM product WHERE u_id='" . $_SESSION['userid'] . "'";
            $res = mysql_query($query) or die(mysql_error());
            $row = mysql_fetch_array($res);
            $product_id = $row['product_id'];
            $start_publishing = $row['start_of_publishing'];

            $query = "INSERT into c_s_rel(`product_id`,`store_id`,`start_of_publishing`)
                 VALUES('" . $product_id . "','" . $storeUniqueId . "','" . $start_publishing . "')";
            $res = mysql_query($query) or die("1" . mysql_error());

            //$query = "UPDATE coupon SET store_id = '$storeUniqueId' WHERE product_id='" . $product_id . "'";
            //$res = mysql_query($query) or die("2" . mysql_error());
        }
        }

//////////////////////////////////////////////////
        /////Update user table activ field/////////////////////////////
        $query = "UPDATE user SET activ='4' WHERE u_id = '" . $_SESSION['userid'] . "'";
        $res = mysql_query($query) or die("3" . mysql_error());

        $_SESSION['MESSAGE'] = CREATE_STORE_SUCCESS;
        $_SESSION['REG_STEP'] = 5;
        $_SESSION['active_state'] = 4;
        $url = BASE_URL . 'registrationStep.php';
        $inoutObj->reDirect($url);
        exit();
    }

    /* Function Header :saveNewStoreDetails()
     *             Args: none
     *           Errors: none
     *     Return Value: none
     *      Description:To save all the details related to the Store in the database
     */

    function saveNewStoreDetails() {
        $inoutObj = new inOut();
        $db = new db();
        $arrUser = array();
        $error = '';

        $arrUser['store_name'] = $_POST['storeName'];
        $arrUser['email'] = $_POST['email'];
        $arrUser['street'] = $_POST['streetaddStore'];
        $arrUser['city'] = $_POST['cityStore'];
        $arrUser['country'] = $_POST['countryStore'];
        $arrUser['phone'] = $_POST['phoneNo'];
        $arrUser['link'] = $_POST['link'];
        $arrUser['chain'] = $_POST['chain'];
        $arrUser['block'] = $_POST['block'];
        $arrUser['zip'] = $_POST['zip'];
        // string matching
        $filestring = $arrUser['link'];
        $findme  = 'http://';
        $pos = strpos($filestring, $findme);
        if ($pos === false) {
            $arrUser['link'] = 'http://' . $filestring;
        } else {
            $arrUser['link'] = $filestring;
        }
        // string matching
        $filestring = $arrUser['link'];
        $findme  = 'http://';
        $pos = strpos($filestring, $findme);
        if ($pos === false) {
            $arrUser['link'] = 'http://' . $filestring;
        } else {
            $arrUser['link'] = $filestring;
        }
        
        $arrUser['latitude'] = $_POST['latitude'];
        $arrUser['longitude'] = $_POST['longitude'];
        $arrUser['BARCODE'] = $_POST['BARCODE'];
        $arrUser['DPS'] = $_POST['DPS'];



        $error.= ( $arrUser['store_name'] == '') ? ERROR_STORE_NAME : '';

        $error.= ( $arrUser['street'] == '') ? ERROR_STREET_ADDRESS : '';

        $error.= ( $arrUser['city'] == '') ? ERROR_CITY_STORE : '';

        $error.= ( $arrUser['country'] == '') ? ERROR_COUNTRY - STORE : '';

       

        if ($error != '') {
            $_SESSION['MESSAGE'] = $error;
            $_SESSION['post'] = $_POST;
            $url = BASE_URL . 'newCreateStore.php';

            $inoutObj->reDirect($url);
            exit();
        }

        $contry = $arrUser['country'];
        $query = "select * from country where name = '" . $contry . "'";
        $res = mysql_query($query) or die(mysql_error());
        $rs = mysql_fetch_array($res);
        $coutryIso = $rs['iso'];

        $_SESSION['post'] = "";
        $storeUniqueId = uuid();
        $query = "INSERT into store(`store_id`,`u_id`,`store_name`,`email`,`street`,`phone`,`store_link`,`city`,`country`,`latitude`,`longitude`,`s_activ`,`country_code`,`access_type`,`chain`,`block`,`zip`)
                 VALUES('" . $storeUniqueId . "','" . $_SESSION['userid'] . "','" . $arrUser['store_name'] . "','" . $arrUser['email'] . "','" . $arrUser['street'] . "','" . $arrUser['phone'] . "','" . $arrUser['link'] . "','" . $arrUser['city'] . "','" . $arrUser['country'] . "','" . $arrUser['latitude'] . "','" . $arrUser['longitude'] . "','1','" . $coutryIso . "','1','" . $arrUser['chain'] . "','" . $arrUser['block'] . "','" . $arrUser['zip'] . "')";
        $res = mysql_query($query) or die(mysql_error());

        $query = "INSERT into coupon_delivery_method(`store`,`delivery_method`)
                 VALUES('" . $storeUniqueId . "','PINCODE')";
        $res = mysql_query($query) or die(mysql_error());

        $query = "INSERT into coupon_delivery_method(`store`,`delivery_method`)
                 VALUES('" . $storeUniqueId . "','TIME_LIMIT')";
        $res = mysql_query($query) or die(mysql_error());

        $query = "INSERT into coupon_delivery_method(`store`,`delivery_method`)
                 VALUES('" . $storeUniqueId . "','MANUAL_SWIPE')";
        $res = mysql_query($query) or die(mysql_error());

        if (isset($arrUser['BARCODE'])) {
          $query = "INSERT into coupon_delivery_method(`store`,`delivery_method`)
                 VALUES('" . $storeUniqueId . "','BARCODE')";
        $res = mysql_query($query) or die(mysql_error());
        }

         if (isset($arrUser['DPS'])) {
            $query = "INSERT into coupon_delivery_method(`store`,`delivery_method`)
                 VALUES('" . $storeUniqueId . "','AUTO')";
            $res = mysql_query($query) or die(mysql_error());
        }

        if ($_SESSION['createStore']) {
            $_SESSION['createStore'] = "";
             $url = $_SESSION['MAIL_URL'];
            $_SESSION['MAIL_URL'] = "";
            $_SESSION['MESSAGE'] = CREATE_STORE_SUCCESS_MAIL;
              $inoutObj->reDirect($url);
             exit();
           }
        


        $_SESSION['MESSAGE'] = CREATE_STORE_SUCCESS;
        $url = BASE_URL . 'showStore.php';
        $inoutObj->reDirect($url);
        exit();
    }

    /* Function Header :getStoreDetail()
     *             Args: none
     *           Errors: none
     *     Return Value: none
     *      Description: Select store details of perticular user
     */

    function getStoreDetail($uid) {
        $options = "";
        $query = "SELECT * FROM store WHERE u_id = '" . $uid . "'";
        $res = mysql_query($query) or die(mysql_error());
        while ($rs = mysql_fetch_array($res)) {
            $data[] = $rs;
        }
        return $data;
    }

    /* Function Header :getCompanyDetail()
     *             Args: none
     *           Errors: none
     *     Return Value: none
     *      Description: Select company details of perticular user
     */

    function getCompanyDetail($uid) {
        $options = "";
        $query = "SELECT company.*,country.name as cname,country.iso as ciso FROM company left join country on (country.iso = company.country) WHERE company.u_id = '" . $uid . "'";
        $res = mysql_query($query) or die(mysql_error());
        while ($rs = mysql_fetch_array($res)) {
            $data[] = $rs;
        }
        return $data;
    }

     /* Function Header :getCompanyDetail()
     *             Args: none
     *           Errors: none
     *     Return Value: none
     *      Description: Select company details of perticular user
     */

    function getEmailId($uid) {
        $options = "";
        $query = "SELECT * FROM user WHERE u_id = '" . $uid . "'";
        $res = mysql_query($query) or die(mysql_error());
        while ($rs = mysql_fetch_array($res)) {
            $data1[] = $rs;
        }
        return $data1;
    }

    /* Function Header :ShowStore()
     *             Args: none
     *           Errors: none
     *     Return Value: none
     *      Description: Show store details of perticular user which is in active state
     */

    function ShowStore($paging_limit = '0 , 10') {
        // print_r($data); die("dssdada");
        $db = new db();
        $db->makeConnection();
        $data = array();

        if (isset($_REQUEST['keyword']) OR isset($_REQUEST['key'])) {
            // $qstr1 = " store_name REGEXP '[[:<:]]".trim($_REQUEST['keyword'])."[[:>:]]' ";
            // $qstr2 = " email REGEXP '[[:<:]]".trim($_REQUEST['key'])."[[:>:]]' ";
            $set_keywords = "";
            if ($_REQUEST['keyword']) {
                $set_keywords.= 'store_name LIKE "%' . trim($_REQUEST['keyword']) . '%" AND ';
            }
            if ($_REQUEST['key']) {
                $set_keywords.= 'email LIKE "%' . trim($_REQUEST['key']) . '%" AND ';
            }
            // $set_keywords = "(u_id='".$_SESSION['userid']."' AND ".$qstr1.") OR
            //                  (u_id='".$_SESSION['userid']."' AND ".$qstr2.")";
        }
        else
            $set_keywords = " 1 AND ";

        $q = $db->query("SELECT * FROM store WHERE u_id = '" . $_SESSION['userid'] . "' AND $set_keywords s_activ='1'  LIMIT {$paging_limit} ");

        // $res = mysql_query($query) or die(mysql_error());
        while ($rs = mysql_fetch_array($q)) {
            $data[] = $rs;
        }
        return $data;
    }

    /* Function Header :showOutdatedStore()
     *             Args: none
     *           Errors: none
     *     Return Value: none
     *      Description: Show store details of perticular user which is outdated
     */

    function showOutdatedStore($paging_limit = '0 , 10') {

        $db = new db();
        $db->makeConnection();
        $data = array();
        if (isset($_REQUEST['keyword']) OR isset($_REQUEST['key'])) {
            //$qstr1 = " store_name REGEXP '[[:<:]]".trim($_REQUEST['keyword'])."[[:>:]]' ";
            // $qstr2 = " email REGEXP '[[:<:]]".trim($_REQUEST['key'])."[[:>:]]' ";
            $set_keywords = "";
            if ($_REQUEST['keyword']) {
                $set_keywords.= 'store_name LIKE "%' . trim($_REQUEST['keyword']) . '%" AND ';
            }
            if ($_REQUEST['key']) {
                $set_keywords.= 'email LIKE "%' . trim($_REQUEST['key']) . '%" AND ';
            }
            // $set_keywords = "(u_id='".$_SESSION['userid']."' AND ".$qstr1.") OR
            //                 (u_id='".$_SESSION['userid']."' AND ".$qstr2.")";
        }
        else
            $set_keywords = " 1 AND ";


        $Query = "SELECT * FROM store WHERE u_id = '" . $_SESSION['userid'] . "' AND $set_keywords s_activ='2' LIMIT {$paging_limit}";
        $q = $db->query($Query);

        //$res = mysql_query($query) or die(mysql_error());

        while ($rs = mysql_fetch_array($q)) {
            $data[] = $rs;
        }
        // print_r($data); die("dssdada");
        return $data;
        // print_r($data); die("dssdada");
    }

    /* Function Header : getStoreDetailById($storeid)
     *             Args: none
     *           Errors: none
     *     Return Value: none
     *      Description: Show store details of perticular user with unique storeId
     */

    function getStoreDetailById($storeid) {
        // print_r($data); die("dssdada");
        $db = new db();
        $db->makeConnection();
        $data = array();
        $q = $db->query("SELECT * FROM store LEFT JOIN coupon_delivery_method ON (store.store_id = coupon_delivery_method.store)  WHERE store.u_id = '" . $_SESSION['userid'] . "' AND store.store_id='" . $storeid . "' ");
      
        // $res = mysql_query($query) or die(mysql_error());
        while ($rs = mysql_fetch_array($q)) {
            $data[] = $rs;
        }
        return $data;
    }

     function getCouponDeliveryById($storeid) {
        // print_r($data); die("dssdada");
        $db = new db();
        $db->makeConnection();
        $data = array();
        $QUE = "select delivery_method from coupon_delivery_method where store='" . $storeid . "' and delivery_method = 'BARCODE'";
                $res = mysql_query($QUE) or die("Get  : " . mysql_error());
                $row = mysql_fetch_array($res);
                $barcode = $row['delivery_method'];
        
               return $barcode;
    }

    function getCouponDeliveryByIdDPS($storeid) {
        // print_r($data); die("dssdada");
        $db = new db();
        $db->makeConnection();
        $data = array();
        $QUE = "select delivery_method from coupon_delivery_method where store='" . $storeid . "' and delivery_method = 'AUTO'";
        $res = mysql_query($QUE) or die("Get  : " . mysql_error());
        if(mysql_num_rows($res) > 0)
            return "DPS";
        else 
            return "";
    }
    
    
    /* Function Header :  editSaveStore($storeid)
     *             Args: none
     *           Errors: none
     *     Return Value: none
     *      Description: update store details of perticular user with unique storeId
     */

    function editSaveStore($storeid) {

        // print_r($data);
        //echo $_REQUEST['s'];
        // die();
        $inoutObj = new inOut();
        $db = new db();
        $arrUser = array();
        $error = '';

        $arrUser['store_name'] = $_POST['storeName'];
        $arrUser['email'] = $_POST['email'];
        $arrUser['phone'] = $_POST['phoneNo'];
        $arrUser['street'] = $_POST['streetaddStore'];
        $arrUser['city'] = $_POST['cityStore'];
        $arrUser['country'] = $_POST['countryStore'];
        $arrUser['link'] = $_POST['link'];
        $arrUser['chain'] = $_POST['chain'];
        $arrUser['block'] = $_POST['block'];
        $arrUser['zip'] = $_POST['zip'];
        // string matching
        $filestring = $arrUser['link'];
        $findme  = 'http://';
        $pos = strpos($filestring, $findme);
        if ($pos === false) {
            $arrUser['link'] = 'http://' . $filestring;
        } else {
            $arrUser['link'] = $filestring;
        }
        $arrUser['latitude'] = $_POST['latitude'];
        $arrUser['longitude'] = $_POST['longitude'];
        $arrUser['BARCODE'] = $_POST['BARCODE'];
        $arrUser['DPS'] = $_POST['DPS'];

        $error.= ( $arrUser['store_name'] == '') ? ERROR_STORE_NAME : '';

        $error.= ( $arrUser['street'] == '') ? ERROR_STREET_ADDRESS : '';

        $error.= ( $arrUser['city'] == '') ? ERROR_CITY_STORE : '';

        $error.= ( $arrUser['country'] == '') ? ERROR_COUNTRY - STORE : '';

        

        if ($error != '') {
            $_SESSION['MESSAGE'] = $error;
            $_SESSION['post'] = $_POST;
            $url = BASE_URL . 'editStore.php';

            $inoutObj->reDirect($url);
            exit();
        }
        else
            $_SESSION['post'] = "";

        $contry = $arrUser['country'];
        $query = "select * from country where name = '" . $contry . "'";
        $res = mysql_query($query) or die(mysql_error());
        $rs = mysql_fetch_array($res);
        $coutryIso = $rs['iso'];

        $storeUniqueId = uuid();
        $query = "update store SET latitude='" . $arrUser['latitude'] . "',longitude='" . $arrUser['longitude'] . "',`store_name`='" . $arrUser['store_name'] . "' ,`street`='" . $arrUser['street'] . "', `city`='" . $arrUser['city'] . "', `country`='" . $arrUser['country'] . "', `email`='" . $arrUser['email'] . "', `phone`='" . $arrUser['phone'] . "', `store_link`='" . $arrUser['link'] . "'
        , `chain`='" . $arrUser['chain'] . "', `block`='" . $arrUser['block'] . "', `zip`='" . $arrUser['zip'] . "' , `country_code`='" . $coutryIso . "'   WHERE u_id='" . $_SESSION['userid'] . "' AND store_id='" . $_GET['storeId'] . "'";
        $res = mysql_query($query) or die(mysql_error());

         $query = "delete from coupon_delivery_method where store = '" . $_GET['storeId'] . "' and delivery_method in ('BARCODE','AUTO')";
             $res = mysql_query($query) or die(mysql_error());
        
        
        if ($arrUser['BARCODE'] == 'BARCODE') {
            $query = "insert into coupon_delivery_method(`store`,`delivery_method`)
                values('" . $_GET['storeId'] . "','BARCODE')";
             $res = mysql_query($query) or die(mysql_error());
        }

        if ($arrUser['DPS'] == 'DPS') {
            $query = "insert into coupon_delivery_method(`store`,`delivery_method`)
                values('" . $_GET['storeId'] . "','AUTO')";
            $res = mysql_query($query) or die(mysql_error());
        }
        
        $_SESSION['MESSAGE'] = CREATE_STORE_SUCCESS;
        $_SESSION['REG_STEP'] = 5;
        if ($_REQUEST['s'] == 1) {
            $url = BASE_URL . 'showStore.php?m=showOutdatedStore';
            $inoutObj->reDirect($url);
        } else {
            $url = BASE_URL . 'showStore.php';
            $inoutObj->reDirect($url);
        }
        exit();
    }

    /* Function Header :  viewStoreDetailById($storeid)
     *             Args: none
     *           Errors: none
     *     Return Value: none
     *      Description: View store details of perticular user with unique storeId
     */

    function viewStoreDetailById($storeid) {
        // print_r($data); die("dssdada");
        $db = new db();
        $db->makeConnection();
        $data = array();
      //  $que = "SELECT * FROM store LEFT JOIN coupon_delivery_method ON (coupon_delivery_method.store = store.store_id)
        //    WHERE store.u_id = '" . $_SESSION['userid'] . "' AND store.store_id='" . $storeid . "'";
        
        $q = $db->query("SELECT * FROM store WHERE store.u_id = '" . $_SESSION['userid'] . "' AND store.store_id='" . $storeid . "'");

        // $res = mysql_query($query) or die(mysql_error());
        while ($rs = mysql_fetch_array($q)) {
            $data[] = $rs;
        }
        $query = "SELECT delivery_method FROM coupon_delivery_method WHERE coupon_delivery_method.store='".$storeid."'";
        $res = mysql_query($query) or die(mysql_error());
        $delivery_method = "";
        while ($rs = mysql_fetch_array($res)) {
            $delivery_method .= $rs['delivery_method']."  ";
        }
        $data[0]['delivery_method']=  str_replace("AUTO","DPS",trim($delivery_method));
        
        return $data;
    }

    /* Function Header :  deleteStoreById($storeid)
     *             Args: none
     *           Errors: none
     *     Return Value: none
     *      Description: Delete store details of particular user with unique storeId
     */

    function deleteStoreById() {
        //print_r($data); die("dssdada");

        $db = new db();
        $inoutObj = new inOut();
        $db->makeConnection();
        $_SQL = "UPDATE store SET s_activ='2' WHERE u_id = '" . $_SESSION['userid'] . "' AND store_id='" . $_GET['storeId'] . "'";
        $q = $db->query($_SQL);
        $url = BASE_URL . 'showStore.php';
        $inoutObj->reDirect($url);
    }

    /* Function Header :showstoreDetailsRows()
     *             Args: none
     *           Errors: none
     *     Return Value: none
     *      Description: count rows for total record.
     */

    function showstoreDetailsRows() {
        // print_r($data); die("dssdada");
        $db = new db();
        $db->makeConnection();
        $data = array();

        if (isset($_REQUEST['keyword']) OR isset($_REQUEST['key'])) {
//            $qstr1 = " store_name REGEXP '[[:<:]]".trim($_REQUEST['keyword'])."[[:>:]]' ";
//            $qstr2 = " email REGEXP '[[:<:]]".trim($_REQUEST['key'])."[[:>:]]' ";
            $set_keywords = "";
            if ($_REQUEST['keyword']) {
                $set_keywords.= 'store_name LIKE "%' . trim($_REQUEST['keyword']) . '%" AND ';
            }
            if ($_REQUEST['key']) {
                $set_keywords.= 'email LIKE "%' . trim($_REQUEST['key']) . '%" AND ';
            }

            //$set_keywords = "(u_id='".$_SESSION['userid']."' AND ".$qstr1.") OR
            //              (u_id='".$_SESSION['userid']."' AND ".$qstr2.")";
        }
        else
            $set_keywords = " 1 AND ";

        if ($_REQUEST['m'] == "showOutdatedStore") {
           $QUE = "SELECT * FROM store WHERE u_id = '" . $_SESSION['userid'] . "' AND $set_keywords  s_activ='2'";
        } else {
           $QUE = "SELECT * FROM store WHERE u_id = '" . $_SESSION['userid'] . "' AND $set_keywords  s_activ='1'";
        }
        //echo $QUE;
        // $res = mysql_query($query) or die(mysql_error());
        $res = mysql_query($QUE) or die(mysql_error());
        $total_records = $db->numRows($res);

        return $total_records;
    }

//    function deleteDeactiveStore() {
//       //echo $_GET['storeId'];
//        //print_r($data); die("dssdada");
//
//        $db = new db();
//        $inoutObj = new inOut();
//        $db->makeConnection();
//        $_SQL = "SELECT text FROM product_price_list WHERE store_id = '" . $_GET['storeId'] ."'";
//
//        $res = mysql_query($_SQL);
//        $rs = mysql_fetch_array($res);
//         $data = $rs['text'];
//
//        if($data)
//            {
//            $_SESSION['MESSAGE'] = DEACTIVE_DELETE;
//             $url = BASE_URL . 'showStore.php?m=showOutdatedStore';
//             $inoutObj->reDirect($url);
//             exit();
//            }
//       else {
//        $_SQL = "DELETE FROM store WHERE u_id = '" . $_SESSION['userid'] . "' AND store_id='" . $_GET['storeId'] . "'";
//        $q = $db->query($_SQL);
//        $url = BASE_URL . 'showStore.php?m=showOutdatedStore';
//        $inoutObj->reDirect($url);
//    }
//    }

    function totalStoreDetails() {
        $db = new db();
        $db->makeConnection();
        $data = array();
        //echo $_SESSION['userid'];
        $q = $db->query("SELECT store_id,store_name FROM store WHERE u_id = '" . $_SESSION['userid'] . "' AND s_activ='1'");
        while ($rs = mysql_fetch_array($q)) {
        $stores[] = $rs;
        //echo $storename=$stores['store_name'];
           // die;
        }
        return $stores;
    }

    function getAllPublicLocationRows() {
        // print_r($data); die("dssdada");
        $db = new db();
        $db->makeConnection();
        $data = array();

        if (isset($_REQUEST['keyword']) OR isset($_REQUEST['key']) OR isset($_REQUEST['key5']) OR isset($_REQUEST['key3']) OR isset($_REQUEST['key4'])) {
            // $qstr1 = " store_name REGEXP '[[:<:]]".trim($_REQUEST['keyword'])."[[:>:]]' ";
            // $qstr2 = " email REGEXP '[[:<:]]".trim($_REQUEST['key'])."[[:>:]]' ";
            $set_keywords = "";
            if ($_REQUEST['keyword']) {
                $set_keywords.= 'store_name LIKE "%' . trim($_REQUEST['keyword']) . '%" AND ';
            }
            if ($_REQUEST['key']) {
                $set_keywords.= 'email LIKE "%' . trim($_REQUEST['key']) . '%" AND ';
            }
             if ($_REQUEST['key5']) {
                $set_keywords.= 'city LIKE "%' . trim($_REQUEST['key5']) . '%" AND ';
            }
             if ($_REQUEST['key3']) {
                $set_keywords.= 'chain LIKE "%' . trim($_REQUEST['key3']) . '%" AND ';
            }
             if ($_REQUEST['key4']) {
                $set_keywords.= 'block LIKE "%' . trim($_REQUEST['key4']) . '%" AND ';
            }
            // $set_keywords = "(u_id='".$_SESSION['userid']."' AND ".$qstr1.") OR
            //                  (u_id='".$_SESSION['userid']."' AND ".$qstr2.")";
        }
        else
            $set_keywords = " 1 AND ";
 
           $q = "SELECT * FROM store WHERE access_type = '0' AND $set_keywords  s_activ='1'";
       
        $res = mysql_query($q) or die(mysql_error());
        $total_records = $db->numRows($res);

        return $total_records;
    }

    function getAllPublicLocation($paging_limit = '0 , 10') {
       $db = new db();
        $db->makeConnection();
        $data = array();

        if (isset($_REQUEST['keyword']) OR isset($_REQUEST['key']) OR isset($_REQUEST['key5']) OR isset($_REQUEST['key3']) OR isset($_REQUEST['key4'])) {
            // $qstr1 = " store_name REGEXP '[[:<:]]".trim($_REQUEST['keyword'])."[[:>:]]' ";
            // $qstr2 = " email REGEXP '[[:<:]]".trim($_REQUEST['key'])."[[:>:]]' ";
            $set_keywords = "";
            if ($_REQUEST['keyword']) {
                $set_keywords.= 'store_name LIKE "%' . trim($_REQUEST['keyword']) . '%" AND ';
            }
            if ($_REQUEST['key']) {
                $set_keywords.= 'email LIKE "%' . trim($_REQUEST['key']) . '%" AND ';
            }
           if ($_REQUEST['key5']) {
                $set_keywords.= 'city LIKE "%' . trim($_REQUEST['key5']) . '%" AND ';
            }
             if ($_REQUEST['key3']) {
                $set_keywords.= 'chain LIKE "%' . trim($_REQUEST['key3']) . '%" AND ';
            }

             if ($_REQUEST['key4']) {
                $set_keywords.= 'block LIKE "%' . trim($_REQUEST['key4']) . '%" AND ';
            }
            // $set_keywords = "(u_id='".$_SESSION['userid']."' AND ".$qstr1.") OR
            //                  (u_id='".$_SESSION['userid']."' AND ".$qstr2.")";
        }
        else
            $set_keywords = " 1 AND ";

        $q = $db->query("SELECT * FROM store WHERE access_type = '0' AND $set_keywords s_activ='1'  LIMIT {$paging_limit} ");

         //$res = mysql_query($q) or die(mysql_error());
        while ($rs = mysql_fetch_array($q)) {
            $data[] = $rs;
        }
        return $data;
    }

    function savePublicLocation($campaignId) {

        $db = new db();
        $db->makeConnection();
        $data = array();
        $arrUser = array();
        $inoutObj = new inOut();


        $arrUser['store_id'] = $_POST['publiclocation'];
        //print_r($arrUser['store_id']);die();

        foreach ($arrUser['store_id'] as $store) {


        $QUE = "select * from c_s_rel where campaign_id='" . $campaignId . "' AND store_id='" . $store . "' AND activ = '1'";
        $res = mysql_query($QUE) or die("Get Company : " . mysql_error());
        $row = mysql_fetch_array($res);
        $checkCampaignId = $row['campaign_id'];
        //print_r($row);die();
        if ($checkCampaignId) {
            //echo lskf;die();
            $_SESSION['MESSAGE'] = STORE_NOT_SUCCESS;
            $url = BASE_URL . 'showCampaign.php';
            $inoutObj->reDirect($url);
            exit();
        } else {
            $QUE = "select start_of_publishing from campaign where campaign_id='" . $campaignId . "'";
            $res = mysql_query($QUE) or die("Get Company : " . mysql_error());
            $row = mysql_fetch_array($res);
            $startdate = $row['start_of_publishing'];

            $QUE = "select end_of_publishing from campaign where campaign_id='" . $campaignId . "'";
            $res = mysql_query($QUE) or die("Get Company : " . mysql_error());
            $row = mysql_fetch_array($res);
            $enddate = $row['end_of_publishing'];

            if ($startdate < date('Y-m-d')) {
                $finStartDate = date('Y-m-d');
            } else if ($startdate > date('Y-m-d')) {
                $finStartDate = $startdate;
            }
//

           $_SQL = "insert into c_s_rel(`campaign_id`,`store_id`,`start_of_publishing`,`end_of_publishing`,`activ`) values('" . $campaignId . "','" . $store . "','" . $finStartDate . "','" . $enddate . "','1')";
            $res = mysql_query($_SQL) or die("limitttt id in relational table : " . mysql_error());
            }
 }

            $_SESSION['MESSAGE'] = COUPON_OFFER_SUCCESS;
            $url = BASE_URL . 'showCampaign.php';
            $inoutObj->reDirect($url);
            exit();
    }
       
    function getAllSelecterPublicLocation($campaignid) {
       $db = new db();
        $db->makeConnection();
        $data = array();

     

        $q = $db->query("SELECT store_id FROM c_s_rel WHERE campaign_id = '" . $campaignid . "' AND  activ='1'");

         //$res = mysql_query($q) or die(mysql_error());
      //  $rs = mysql_fetch_array($q);
        while ($rs = mysql_fetch_array($q)) {
            $data[] = $rs[0];
        }
        return $data;
    }

    function getAllPrivateLocationRows() {
        // print_r($data); die("dssdada");
        $db = new db();
        $db->makeConnection();
        $data = array();

        if (isset($_REQUEST['keyword']) OR isset($_REQUEST['key']) OR isset($_REQUEST['key5']) OR isset($_REQUEST['key3']) OR isset($_REQUEST['key4'])) {
            // $qstr1 = " store_name REGEXP '[[:<:]]".trim($_REQUEST['keyword'])."[[:>:]]' ";
            // $qstr2 = " email REGEXP '[[:<:]]".trim($_REQUEST['key'])."[[:>:]]' ";
            $set_keywords = "";
            if ($_REQUEST['keyword']) {
                $set_keywords.= 'store_name LIKE "%' . trim($_REQUEST['keyword']) . '%" AND ';
            }
            if ($_REQUEST['key']) {
                $set_keywords.= 'email LIKE "%' . trim($_REQUEST['key']) . '%" AND ';
            }
            if ($_REQUEST['key5']) {
                $set_keywords.= 'city LIKE "%' . trim($_REQUEST['key5']) . '%" AND ';
            }
             if ($_REQUEST['key3']) {
                $set_keywords.= 'chain LIKE "%' . trim($_REQUEST['key3']) . '%" AND ';
            }
             if ($_REQUEST['key4']) {
                $set_keywords.= 'block LIKE "%' . trim($_REQUEST['key4']) . '%" AND ';
            }
            // $set_keywords = "(u_id='".$_SESSION['userid']."' AND ".$qstr1.") OR
            //                  (u_id='".$_SESSION['userid']."' AND ".$qstr2.")";
        }
        else
            $set_keywords = " 1 AND ";

        $q = "SELECT * FROM store WHERE u_id = '" . $_SESSION['userid'] . "' AND s_activ='1'";

        $res = mysql_query($q) or die(mysql_error());
        $total_records = $db->numRows($res);

        return $total_records;
    }

    function getAllPrivateLocation($paging_limit = '0 , 10') {
       $db = new db();
        $db->makeConnection();
        $data = array();

        if (isset($_REQUEST['keyword']) OR isset($_REQUEST['key']) OR isset($_REQUEST['key5']) OR isset($_REQUEST['key3']) OR isset($_REQUEST['key4'])) {
            // $qstr1 = " store_name REGEXP '[[:<:]]".trim($_REQUEST['keyword'])."[[:>:]]' ";
            // $qstr2 = " email REGEXP '[[:<:]]".trim($_REQUEST['key'])."[[:>:]]' ";
            $set_keywords = "";
            if ($_REQUEST['keyword']) {
                $set_keywords.= 'store_name LIKE "%' . trim($_REQUEST['keyword']) . '%" AND ';
            }
            if ($_REQUEST['key']) {
                $set_keywords.= 'email LIKE "%' . trim($_REQUEST['key']) . '%" AND ';
            }
            if ($_REQUEST['key5']) {
                $set_keywords.= 'city LIKE "%' . trim($_REQUEST['key5']) . '%" AND ';
            }
              if ($_REQUEST['key3']) {
                $set_keywords.= 'chain LIKE "%' . trim($_REQUEST['key3']) . '%" AND ';
            }
              if ($_REQUEST['key4']) {
                $set_keywords.= 'block LIKE "%' . trim($_REQUEST['key4']) . '%" AND ';
            }
            // $set_keywords = "(u_id='".$_SESSION['userid']."' AND ".$qstr1.") OR
            //                  (u_id='".$_SESSION['userid']."' AND ".$qstr2.")";
        }
        else
            $set_keywords = " 1 AND ";

        $q = $db->query("SELECT * FROM store WHERE u_id = '" . $_SESSION['userid'] . "' AND s_activ='1' AND  $set_keywords s_activ='1'  LIMIT {$paging_limit} ");

         //$res = mysql_query($q) or die(mysql_error());
        while ($rs = mysql_fetch_array($q)) {
            $data[] = $rs;
        }
        return $data;
    }

    function getAllSelecterPrivateLocation($campaignid) {
       $db = new db();
        $db->makeConnection();
        $data = array();



        $q = $db->query("SELECT store_id FROM c_s_rel WHERE campaign_id = '" . $campaignid . "' AND  activ='1'");

         //$res = mysql_query($q) or die(mysql_error());
      //  $rs = mysql_fetch_array($q);
        while ($rs = mysql_fetch_array($q)) {
            $data[] = $rs[0];
        }
        return $data;
    }

    function savePrivateLocation($campaignId) {
        $db = new db();
        $db->makeConnection();
        $data = array();
        $arrUser = array();
        $inoutObj = new inOut();

        $arrUser['store_id'] = $_POST['privatelocation'];
        foreach ($arrUser['store_id'] as $store) {
        $QUE = "select * from c_s_rel where campaign_id='" . $campaignId . "' AND store_id='" . $store . "' AND activ = '1'";
        $res = mysql_query($QUE) or die("Get Company : " . mysql_error());
        $row = mysql_fetch_array($res);
        $checkCampaignId = $row['campaign_id'];
        //print_r($row);die();
        if ($checkCampaignId) {
            //echo lskf;die();
            $_SESSION['MESSAGE'] = STORE_NOT_SUCCESS;
            $url = BASE_URL . 'showCampaign.php';
            $inoutObj->reDirect($url);
            exit();
        } else {
            $QUE = "select start_of_publishing from campaign where campaign_id='" . $campaignId . "'";
            $res = mysql_query($QUE) or die("Get Company : " . mysql_error());
            $row = mysql_fetch_array($res);
            $startdate = $row['start_of_publishing'];

            $QUE = "select end_of_publishing from campaign where campaign_id='" . $campaignId . "'";
            $res = mysql_query($QUE) or die("Get Company : " . mysql_error());
            $row = mysql_fetch_array($res);
            $enddate = $row['end_of_publishing'];

            if ($startdate < date('Y-m-d')) {
                $finStartDate = date('Y-m-d');
            } else if ($startdate > date('Y-m-d')) {
                $finStartDate = $startdate;
            }
//

           $_SQL = "insert into c_s_rel(`campaign_id`,`store_id`,`start_of_publishing`,`end_of_publishing`,`activ`) values('" . $campaignId . "','" . $store . "','" . $finStartDate . "','" . $enddate . "','1')";
            $res = mysql_query($_SQL) or die("limitttt id in relational table : " . mysql_error());
            }
 }

            $_SESSION['MESSAGE'] = COUPON_OFFER_SUCCESS;
            $url = BASE_URL . 'showCampaign.php';
            $inoutObj->reDirect($url);
            exit();
    }

// Advertise Store add for advertise offer support.

    function getAllSelecterPrivateAdvertiseLocation($advertiseid) {
        $db = new db();
        $db->makeConnection();
        $data = array();
        $q = $db->query("SELECT store_id FROM c_s_rel WHERE advertise_id = '" . $advertiseid . "' AND  activ='1'");
        while ($rs = mysql_fetch_array($q)) {
            $data[] = $rs[0];
        }
        return $data;
    }

    function savePrivateAdvertiseLocation($advertiseId) {
        $db = new db();
        $db->makeConnection();
        $data = array();
        $arrUser = array();
        $inoutObj = new inOut();
        $arrUser['store_id'] = $_POST['privatelocation'];
        foreach ($arrUser['store_id'] as $store) {
            $QUE = "select * from c_s_rel where advertise_id='" . $advertiseId . "' AND store_id='" . $store . "' AND activ = '1'";
            $res = mysql_query($QUE) or die("Get Company : " . mysql_error());
            $row = mysql_fetch_array($res);
            $checkAdvertiseId = $row['advertise_id'];
            if ($checkAdvertiseId) {
                $_SESSION['MESSAGE'] = STORE_NOT_SUCCESS;
                $url = BASE_URL . 'showAdvertise.php';
                $inoutObj->reDirect($url);
                exit();
            } else {
                $QUE = "select start_of_publishing from advertise where advertise_id='" . $advertiseId . "'";
                $res = mysql_query($QUE) or die("Get Company : " . mysql_error());
                $row = mysql_fetch_array($res);
                $startdate = $row['start_of_publishing'];

                $QUE = "select end_of_publishing from advertise where advertise_id='" . $advertiseId . "'";
                $res = mysql_query($QUE) or die("Get Company : " . mysql_error());
                $row = mysql_fetch_array($res);
                $enddate = $row['end_of_publishing'];

                if ($startdate < date('Y-m-d')) {
                    $finStartDate = date('Y-m-d');
                } else if ($startdate > date('Y-m-d')) {
                    $finStartDate = $startdate;
                }
                $_SQL = "insert into c_s_rel(`advertise_id`,`store_id`,`start_of_publishing`,`end_of_publishing`,`activ`) values('" . $advertiseId . "','" . $store . "','" . $finStartDate . "','" . $enddate . "','1')";
                $res = mysql_query($_SQL) or die("limit id in relational table : " . mysql_error());
            }
        }
        $_SESSION['MESSAGE'] = COUPON_OFFER_SUCCESS;
        $url = BASE_URL . 'showAdvertise.php';
        $inoutObj->reDirect($url);
        exit();
    }

}

?>