<?php

/*  File Name : addCompany.php
 *  Description : Add Company Form
 *  Author  :Himanshu Singh  Date: 23rd,Nov,2010  Creation
 */

//print_r($_SESSION);
//$_SESSION['COMP_ID']="";
require_once('lib/resizer/resizer.php');
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

    public function deleteDish(){
        if($_REQUEST['m'] == 'deleteDish'){

            $inoutObj = new inOut();
            $db = new db();
            $conn = $db->makeConnection();
            // Check connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }else{}

            $arrUser = array();
            $error = '';

            //echo $arrUser['lang'];die();

            $query = "UPDATE dish_type SET
                    dish_activate='0'
                    WHERE dish_id='" . $_GET['dishId'] . "' ";
            $res = mysqli_query($conn, $query) or die(mysql_error());
            $url = BASE_URL . 'showDishes.php';
            $inoutObj->reDirect($url);

            exit();
            
        }
        
    }

    function showDishType($paging_limit = '0 , 10'){

        
        $db = new db();
        $db->makeConnection();
        $data = array();
        $dishActivate='1';
        if (isset($_REQUEST['keyword']) OR isset($_REQUEST['key'])) {
            // $qstr1 = " store_name REGEXP '[[:<:]]".trim($_REQUEST['keyword'])."[[:>:]]' ";
            // $qstr2 = " email REGEXP '[[:<:]]".trim($_REQUEST['key'])."[[:>:]]' ";
            $set_keywords = "";
            if ($_REQUEST['keyword']) {
                $set_keywords.= 'dish_name LIKE "%' . trim($_REQUEST['keyword']) . '%" AND ';
            }
            if ($_REQUEST['key']) {
                $set_keywords.= 'dish_lang LIKE "%' . trim($_REQUEST['key']) . '%" AND ';
            }
            // $set_keywords = "(u_id='".$_SESSION['userid']."' AND ".$qstr1.") OR
            //                  (u_id='".$_SESSION['userid']."' AND ".$qstr2.")";
        }
        else
            $set_keywords = " 1 AND ";

        //$q = $db->query("SELECT * FROM store WHERE u_id = '" . $_SESSION['userid'] . "' AND $set_keywords s_activ='1'  LIMIT {$paging_limit} ");

        if($_REQUEST['m'] == "showDeletedDishes"){
            $dishActivate='0';
        }

        $q = $db->query("SELECT * FROM dish_type WHERE u_id = '" . $_SESSION['userid'] . "' AND $set_keywords dish_activate='" . $dishActivate . "' ");
        
        // $res = mysql_query($query) or die(mysql_error());
        while ($rs = mysqli_fetch_array($q)) {
            $data[] = $rs;
        }
        return $data;
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
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}
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
        $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
        $rs = mysqli_fetch_array($res);
        $coutryIso = $rs['iso'];
        $storeUniqueId = uuid();
        $query = "INSERT into store(`store_id`,`u_id`,`store_name`,`street`,`city`,`country`,`latitude`,`longitude`,`email`,`phone`,`store_link`,`country_code`,`access_type`,`chain`,`block`,`zip`)
                 VALUES('" . $storeUniqueId . "','" . $_SESSION['userid'] . "','" . $arrUser['store_name'] . "','" . $arrUser['street'] . "','" . $arrUser['city'] . "','" . $arrUser['country'] . "','" . $arrUser['latitude'] . "','" . $arrUser['longitude'] . "','" . $arrUser['email'] . "','" . $arrUser['phone'] . "','" . $arrUser['link'] . "','" . $coutryIso . "','1','" . $arrUser['chain'] . "','" . $arrUser['block'] . "','" . $arrUser['zip'] . "')";
        $res = mysqli_query($conn , $query) or die('1' . mysqli_error($conn));

      $query = "INSERT into coupon_delivery_method(`store`,`delivery_method`)
                 VALUES('" . $storeUniqueId . "','PINCODE')";
        $res = mysqli_query($conn , $query) or die(mysqli_error($conn));

        $query = "INSERT into coupon_delivery_method(`store`,`delivery_method`)
                 VALUES('" . $storeUniqueId . "','TIME_LIMIT')";
        $res = mysqli_query($conn , $query) or die(mysqli_error($conn));

        $query = "INSERT into coupon_delivery_method(`store`,`delivery_method`)
                 VALUES('" . $storeUniqueId . "','MANUAL_SWIPE')";
        $res = mysqli_query($conn , $query) or die(mysqli_error($conn));

        if (isset($arrUser['BARCODE'])) {
          $query = "INSERT into coupon_delivery_method(`store`,`delivery_method`)
                 VALUES('" . $storeUniqueId . "','BARCODE')";
        $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
        }


        if (isset($arrUser['DPS'])) {  /// New Option
            $query = "INSERT into coupon_delivery_method(`store`,`delivery_method`)
                 VALUES('" . $storeUniqueId . "','AUTO')";
            $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
        }

         /////////////////////////////////////////////////////////////////////////////////////////////
        //To check whether store belongs to Campaign or advertise or Product and update coupon related to that table
        $query = "SELECT * FROM campaign WHERE u_id='" . $_SESSION['userid'] . "'";
        $res = mysqli_query($conn , $query) or die('2' . mysqli_error($conn));

        if (mysqli_num_rows($res)) {
            $row = mysqli_fetch_array($res);
            $camp_id = $row['campaign_id'];
            $start_publishing = $row['start_of_publishing'];
            $end_publishing = $row['end_of_publishing'];

           $query = "INSERT into c_s_rel(`campaign_id`,`store_id`,`start_of_publishing`,`end_of_publishing`)
                 VALUES('" . $camp_id . "','" . $storeUniqueId . "','" . $start_publishing . "','" . $end_publishing . "')";
            $res = mysqli_query($conn , $query) or die('3' . mysqli_error($conn));

            //$query = "UPDATE coupon SET store_id = '$storeUniqueId' WHERE campaign_id='" . $camp_id . "'";
            //$res = mysql_query($query) or die(mysql_error());
        } else {
           
            $query = "SELECT * FROM advertise WHERE u_id='" . $_SESSION['userid'] . "'";
           
            $res = mysqli_query($conn , $query) or die('2' . mysqli_error($conn));

            if (mysqli_num_rows($res)) {
                $row = mysqli_fetch_array($res);
                $advt_id = $row['advertise_id'];
                $start_publishing = $row['start_of_publishing'];
                $end_publishing = $row['end_of_publishing'];
                
                 $query = "INSERT into c_s_rel(`advertise_id`,`store_id`,`start_of_publishing`,`end_of_publishing`)
                     VALUES('" . $advt_id . "','" . $storeUniqueId . "','" . $start_publishing . "','" . $end_publishing . "')";
                
                $res = mysqli_query($query) or die('3' . mysqli_error($conn));

            //$query = "UPDATE coupon SET store_id = '$storeUniqueId' WHERE campaign_id='" . $camp_id . "'";
            //$res = mysql_query($query) or die(mysql_error());
        } else {
            $query = "SELECT * FROM product WHERE u_id='" . $_SESSION['userid'] . "'";
            $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
            $row = mysqli_fetch_array($res);
            $product_id = $row['product_id'];
            $start_publishing = $row['start_of_publishing'];

            $query = "INSERT into c_s_rel(`product_id`,`store_id`,`start_of_publishing`)
                 VALUES('" . $product_id . "','" . $storeUniqueId . "','" . $start_publishing . "')";
            $res = mysqli_query($conn , $query) or die("1" . mysqli_error($conn));

            //$query = "UPDATE coupon SET store_id = '$storeUniqueId' WHERE product_id='" . $product_id . "'";
            //$res = mysql_query($query) or die("2" . mysql_error());
        }
        }

//////////////////////////////////////////////////
        /////Update user table activ field/////////////////////////////
        $query = "UPDATE user SET activ='4' WHERE u_id = '" . $_SESSION['userid'] . "'";
        $res = mysqli_query($conn , $query) or die("3" . mysqli_error($conn));

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
        
        // echo "<pre>";print_r($_POST['opencloseTimeing']);/*print_r($_POST) ;*/
        
        // die();
        
        $inoutObj = new inOut();
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}
        $arrUser = array();
        $error = '';

        // if($_POST['Sunday'] != null) {$sun = $_POST['Sunday'];} else {$sun = 'close';}
        // if($_POST['Monday'] != null) { $mon =$_POST['Monday'];} else {$mon = 'close';}
        // if($_POST['Tuesday'] != null) { $tues = $_POST['Tuesday'];} else {$tues = 'close';}
        // if($_POST['Wednesday'] != null) {$wed = $_POST['Wednesday'];} else {$wed = 'close';}
        // if($_POST['Thursday'] != null) {$thur = $_POST['Thursday'];} else {$thur = 'close';}
        // if($_POST['Friday'] != null) {$fri = $_POST['Friday'];} else {$fri = 'close';}
        // if($_POST['Saturday'] != null) {$sat = $_POST['Saturday'];} else {$sat = 'close';}

        // $arrUser['openDays'] = $mon .','. $tues .',' . $wed .','. $thur .',' . $fri .',' . $sat . ',' . $sun; 
        //echo "<pre>";print_r($arrUser['openDays']);die();
        // $arrUser['store_open'] = $_POST['storeOpenTime'];
        // $arrUser['store_close'] = $_POST['storeCloseTime'];
        $arrUser['close_dates'] = $_POST['altField'];
        $arrUser['store_open_close_day_time'] = $_POST['opencloseTimeing'];

        if($_POST['onlinePayment'] == 1){
            $arrUser['online_payment'] = $_POST['onlinePayment'];
        }else{
           $arrUser['online_payment'] = 0; 
        }

        $arrUser['store_type'] = addslashes(trim($_POST['typeofrestrurant']));
        $arrUser['store_name'] = addslashes(trim($_POST['storeName']));
        $arrUser['email'] = addslashes(trim($_POST['email']));
        $arrUser['street'] = addslashes(trim($_POST['streetaddStore']));
        $arrUser['city'] = addslashes(trim($_POST['cityStore']));
        $arrUser['country'] = addslashes(trim($_POST['countryStore']));
        $arrUser['phone'] = addslashes(trim($_POST['phoneNo']));
        $arrUser['link'] = addslashes(trim($_POST['link']));
        $arrUser['chain'] = addslashes(trim($_POST['chain']));
        $arrUser['block'] = addslashes(trim($_POST['block']));
        $arrUser['zip'] = addslashes(trim($_POST['zip']));
        $arrUser['tagline']= addslashes(trim($_POST['tagline'])); // added code for tag line by saurabh
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

//Store image uplode to server.

        $CategoryIconName = "cat_icon_" . time();
        $info = pathinfo($_FILES["imageStore"]["name"]);
        if (!empty($_FILES["imageStore"]["name"])) {
            if (!empty($_FILES["imageStore"]["name"])) {
                //echo "Cat in"; die();
                if (strtolower($info['extension']) == "png" || strtolower($info['extension']) == "jpg") {
                    if ($_FILES["imageStore"]["error"] > 0) {
                        $error.=$_FILES["imageStore"]["error"] . "<br />";
                    } else {
                        $cat_filename = $CategoryIconName . "." . strtolower($info['extension']);
                        //move_uploaded_file($_FILES["icon"]["tmp_name"],UPLOAD_DIR."Category/" .$cat_filename);
                        $fileOriginal = $_FILES['imageStore']['tmp_name'];
                        $crop = '5';
                        $size = 'iphone4_cat';
                        $path = UPLOAD_DIR . "category/";
                        $fileThumbnail = $path . $cat_filename;
                        createFileThumbnail($fileOriginal, $fileThumbnail, $size, $frontUpload = 0, $crop, $errorMsg);
//echo 'errorMsg'; die();
                        $arrUser['store_image'] = $cat_filename;
                    }
                } else {
                    $error.=NOT_VALID_EXT;
                }
            } else {
                if ($_SESSION['preview']['small_image'] != "") {
                    $arrUser['small_image'] = $_SESSION['preview']['small_image'];
                } elseif ($_POST['smallimage'] == "") {
                    $error.= ERROR_SMALL_IMAGE;
                } else {
                    $arrUser['small_image'] = $_POST['smallimage'];
                }
            }
        } else {
            //echo "Cat Resp icon"; die();
            $category_image = $_POST["category_image"];
            if (!empty($category_image)) {

                $categoryImageName = explode(".", $category_image);
                $cat_filename = $CategoryIconName . "." . $categoryImageName[1];
                //move_uploaded_file($_FILES["icon"]["tmp_name"],UPLOAD_DIR."Category/" .$cat_filename);
                $fileOriginal = UPLOAD_DIR . "category_lib/" . $category_image;
                //$crop = '5';
                //$size = 'iphone4_cat';
                $path = UPLOAD_DIR . "category/";
                $fileThumbnail = $path . $cat_filename;
                copy($fileOriginal, $fileThumbnail);
                //createFileThumbnail($fileOriginal, $fileThumbnail, $size, $frontUpload = 0, $crop, $errorMsg);
                $arrUser['small_image'] = $cat_filename;
            } else {
                if ($_SESSION['preview']['small_image'] != "") {
                    $arrUser['small_image'] = $_SESSION['preview']['small_image'];
                } elseif ($_POST['smallimage'] == "") {
                    $error.= ERROR_SMALL_IMAGE;
                } else {
                    $arrUser['small_image'] = $_POST['smallimage'];
                }
            }
        }

        /////////////////////////// upload smallimages into server///////////////////
        $file1 = _UPLOAD_IMAGE_ . 'category/' . $arrUser['store_image'];

        $dir1 = "category";
        $command = IMAGE_DIR_PATH . $file1 . " " . $dir1;
        system($command);

        $catImg = IMAGE_AMAZON_PATH . 'category/' . $arrUser['store_image'];

//End Store image uplode to server.

        $contry = $arrUser['country'];
        $query = "select * from country where name = '" . $contry . "'";
        $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
        $rs = mysqli_fetch_array($res);
        $coutryIso = $rs['iso'];

        $_SESSION['post'] = "";
        $storeUniqueId = uuid();
        $query = "INSERT into store(`store_id`,`u_id`,`store_type`,`tagline`,`store_name`,`email`,`street`,`phone`,`store_link`,`city`,`country`,`latitude`,`longitude`,`s_activ`,`country_code`,`access_type`,`chain`,`block`,`zip`,`store_image`,`store_open_close_day_time`,`store_close_dates`,`online_payment`)
                 VALUES('" . $storeUniqueId . "','" . $_SESSION['userid'] . "','" . $arrUser['store_type'] . "','" . $arrUser['tagline'] . "','" . $arrUser['store_name'] . "','" . $arrUser['email'] . "','" . $arrUser['street'] . "','" . $arrUser['phone'] . "','" . $arrUser['link'] . "','" . $arrUser['city'] . "','" . $arrUser['country'] . "','" . $arrUser['latitude'] . "','" . $arrUser['longitude'] . "','1','" . $coutryIso . "','1','" . $arrUser['chain'] . "','" . $arrUser['block'] . "','" . $arrUser['zip'] . "','" . $catImg . "','" . $arrUser['store_open_close_day_time'] . "','" . $arrUser['close_dates'] . "','" . $arrUser['online_payment'] . "')";
        $res = mysqli_query($conn , $query) or die(mysqli_error($conn));

        $query = "INSERT into coupon_delivery_method(`store`,`delivery_method`)
                 VALUES('" . $storeUniqueId . "','PINCODE')";
        $res = mysqli_query($conn , $query) or die(mysqli_error($conn));

        $query = "INSERT into coupon_delivery_method(`store`,`delivery_method`)
                 VALUES('" . $storeUniqueId . "','TIME_LIMIT')";
        $res = mysqli_query($conn , $query) or die(mysqli_error($conn));

        $query = "INSERT into coupon_delivery_method(`store`,`delivery_method`)
                 VALUES('" . $storeUniqueId . "','MANUAL_SWIPE')";
        $res = mysqli_query($conn , $query) or die(mysqli_error($conn));

        if (isset($arrUser['BARCODE'])) {
          $query = "INSERT into coupon_delivery_method(`store`,`delivery_method`)
                 VALUES('" . $storeUniqueId . "','BARCODE')";
        $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
        }

         if (isset($arrUser['DPS'])) {
            $query = "INSERT into coupon_delivery_method(`store`,`delivery_method`)
                 VALUES('" . $storeUniqueId . "','AUTO')";
            $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
        }

        // Create subscription for newly created location
        if( !empty($_POST['plan_id']) )
        {
            $billingObj = new billing();
            $billingObj->subscribeForLocation($storeUniqueId);
        }

        //
        if ($_SESSION['createStore']) {
            $_SESSION['createStore'] = "";
             $url = $_SESSION['MAIL_URL'];
            $_SESSION['MAIL_URL'] = "";
            $_SESSION['MESSAGE'] = CREATE_STORE_SUCCESS_MAIL;
              $inoutObj->reDirect($url);
             exit();
           }
        


        $_SESSION['MESSAGE'] = CREATE_STORE_SUCCESS;

        if($_POST['productid'] != ""){
            $url = BASE_URL . 'addStandStore.php?productId=' . $_POST['productid'];
        }else{
            $url = BASE_URL . 'showStore.php';
        }

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

        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}

        $options = "";
        $query = "SELECT company.*,country.name as cname,country.iso as ciso FROM company left join country on (country.iso = company.country) WHERE company.u_id = '" . $uid . "'";
        $res = mysqli_query($conn ,$query) or die(mysql_error());
        while ($rs = mysqli_fetch_array($res)) {
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
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}

        $options = "";
        $query = "SELECT * FROM user WHERE u_id = '" . $uid . "'";
        $res = mysqli_query($conn , $query) or die(mysql_error());
        while ($rs = mysqli_fetch_array($res)) {
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
        while ($rs = mysqli_fetch_array($q)) {
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

        while ($rs = mysqli_fetch_array($q)) {
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
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}
        $data = array();
        $q = $db->query("SELECT * FROM store LEFT JOIN coupon_delivery_method ON (store.store_id = coupon_delivery_method.store)  WHERE store.u_id = '" . $_SESSION['userid'] . "' AND store.store_id='" . $storeid . "' ");
      
        // $res = mysql_query($query) or die(mysql_error());
        while ($rs = mysqli_fetch_array($q)) {
            $data[] = $rs;
        }
        return $data;
    }

     function getCouponDeliveryById($storeid) {
        // print_r($data); die("dssdada");
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}

        $data = array();
        $QUE = "select delivery_method from coupon_delivery_method where store='" . $storeid . "' and delivery_method = 'BARCODE'";
                $res = mysqli_query($conn ,$QUE) or die("Get  : " . mysqli_error($conn));
                $row = mysqli_fetch_array($res);
                $barcode = $row['delivery_method'];
        
               return $barcode;
    }

    function getCouponDeliveryByIdDPS($storeid) {
        // print_r($data); die("dssdada");
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}

        $data = array();
        $QUE = "select delivery_method from coupon_delivery_method where store='" . $storeid . "' and delivery_method = 'AUTO'";
        $res = mysqli_query($conn , $QUE) or die("Get  : " . mysqli_error($conn));
        if(mysqli_num_rows($res) > 0)
            return "DPS";
        else 
            return "";
    }
    
    public function saveEditDish($dishid){

        $inoutObj = new inOut();
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}

        $arrUser = array();
        $error = '';
        $arrUser['lang'] = $_POST['lang'];
        $arrUser['dishType'] = $_POST['dishType'];
//echo $_SESSION['userid'];die();
        $query = "select * from dish_type where u_id = '" . $_SESSION['userid'] . "' AND dish_lang = '" . $arrUser['lang'] . "' AND dish_name = '" . $arrUser['dishType'] . "'";
        $res = mysqli_query($conn , $query);
        $rs = mysqli_fetch_array($res);

        if(sizeof($rs) == '0'){
            $query = "select company_id from dish_type where u_id = '" . $_SESSION['userid'] . "'";
            $res = mysqli_query($conn , $query);
            $rs = mysqli_fetch_array($res);
            $companyId = $rs['company_id'];

            $query = "INSERT INTO dish_type(`dish_lang`,`dish_name`,`company_id`, `u_id`)
            VALUES ('" . $arrUser['lang'] . "','" . $arrUser['dishType'] . "','" . $companyId . "', '" . $_SESSION['userid'] . "');";

            $res = mysqli_query($conn , $query) or die(mysqli_error($conn));

            $_SESSION['MESSAGE'] = DISH_TYPE_SUCCESS;
        }

        // $query = "UPDATE dish_type SET
        //         dish_lang='" . $arrUser['lang'] . "',
        //         dish_name='" . $arrUser['dishType'] . "'
        //         WHERE dish_id='" . $dishid . "' ";
        // $res = mysqli_query($conn, $query) or die(mysql_error());
        // $_SESSION['MESSAGE'] = UPDATED_DISH;
        $url = BASE_URL . 'showDishes.php';
        $inoutObj->reDirect($url);

        exit();

    }
    
    /* Function Header :  editSaveStore($storeid)
     *             Args: none
     *           Errors: none
     *     Return Value: none
     *      Description: update store details of perticular user with unique storeId
     */

    function editSaveStore($storeid) {        
        $inoutObj = new inOut();
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}

        $arrUser = array();
        $error = '';

        // if($_POST['Sunday'] != null) {$sun = $_POST['Sunday'];} else {$sun = 'close';}
        // if($_POST['Monday'] != null) { $mon =$_POST['Monday'];} else {$mon = 'close';}
        // if($_POST['Tuesday'] != null) { $tues = $_POST['Tuesday'];} else {$tues = 'close';}
        // if($_POST['Wednesday'] != null) {$wed = $_POST['Wednesday'];} else {$wed = 'close';}
        // if($_POST['Thursday'] != null) {$thur = $_POST['Thursday'];} else {$thur = 'close';}
        // if($_POST['Friday'] != null) {$fri = $_POST['Friday'];} else {$fri = 'close';}
        // if($_POST['Saturday'] != null) {$sat = $_POST['Saturday'];} else {$sat = 'close';}

        // $arrUser['openDays'] = $mon .','. $tues .',' . $wed .','. $thur .',' . $fri .',' . $sat . ',' . $sun; 
        //echo "<pre>";print_r($arrUser['openDays']);die();
        // $arrUser['store_open'] = $_POST['storeOpenTime'];
        // $arrUser['store_close'] = $_POST['storeCloseTime'];
        if($_POST['opencloseTimeing']){
            $arrUser['store_open_close_day_time'] = $_POST['opencloseTimeing'];
        }

        if($_POST['onlinePayment'] == 1){
            $arrUser['online_payment'] = $_POST['onlinePayment'];
        }else{
           $arrUser['online_payment'] = 0; 
        }


        $arrUser['close_dates'] = $_POST['altField1'];

        $arrUser['store_type'] = $_POST['typeofrestrurant'];
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
        $arrUser['tagline'] = $_POST['tagline'];
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
        $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
        $rs = mysqli_fetch_array($res);
        $coutryIso = $rs['iso'];

		//$query = "select store_image from store where u_id='" . $_SESSION['userid'] . "' AND store_id='" . $_GET['storeId'] . "'";
        //$res = mysqli_query($conn , $query) or die(mysqli_error($conn));
        //$rs = mysqli_fetch_array($res);
		//print_r($rs);

		$catImg = "";

        $CategoryIconName = "cat_icon_" . time();
        $info = pathinfo($_FILES["imageStore"]["name"]);
   
            if ($_FILES["imageStore"]["name"] <> "") {

				$file_extension = strtolower($info['extension']);
                if ($file_extension == "png" || $file_extension == "jpg" || $file_extension == "jpeg") {
                    if ($_FILES["imageStore"]["error"] > 0) {
                        $error.=$_FILES["imageStore"]["error"] . "<br />";
                    } else {
                        $cat_filename = $CategoryIconName . "." . strtolower($info['extension']);
                        $fileOriginal = $_FILES['imageStore']['tmp_name'];
                        $crop = '5';
                        $size = 'iphone4_cat';
                        $path = UPLOAD_DIR . "store_image/";
                        $fileThumbnail = $path . $cat_filename;
                        createFileThumbnail($fileOriginal, $fileThumbnail, $size, $frontUpload = 0, $crop, $errorMsg);
                        $arrUser['store_image'] = $cat_filename;
                        
                        $file1 = _UPLOAD_IMAGE_ . 'store_image/' . $arrUser['store_image'];
                        $dir1 = "store_image";
                        $command = IMAGE_DIR_PATH . $file1 . " " . $dir1;
                        system($command);

                        $catImg = IMAGE_AMAZON_PATH . 'store_image/' . $arrUser['store_image']; 

                    }
                }
            }


        if($catImg <> ""){
            $query = "update store SET store_image='" . $catImg . "' WHERE u_id='" . $_SESSION['userid'] . "' AND store_id='" . $_GET['storeId'] . "'";
            $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
		}else if($_POST['image_removed'] == 1){
            $query = "update store SET store_image='null' WHERE u_id='" . $_SESSION['userid'] . "' AND store_id='" . $_GET['storeId'] . "'";
            $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
        }        
        		
        $storeUniqueId = uuid();

		$arrUser['store_name'] = mysqli_real_escape_string($conn, $arrUser['store_name']);
        $arrUser['street'] = mysqli_real_escape_string($conn, $arrUser['street']);
        $arrUser['city'] = mysqli_real_escape_string($conn, $arrUser['city']);
		
        if($_POST['opencloseTimeing']){

            $query = "update store SET store_type='" . $arrUser['store_type'] . "',tagline='" . $arrUser['tagline'] . "',latitude='" . $arrUser['latitude'] . "',longitude='" . $arrUser['longitude'] . "',`store_name`='" . $arrUser['store_name'] . "' ,`street`='" . $arrUser['street'] . "', `city`='" . $arrUser['city'] . "', `country`='" . $arrUser['country'] . "', `email`='" . $arrUser['email'] . "', `phone`='" . $arrUser['phone'] . "', `store_link`='" . $arrUser['link'] . "'
            , `chain`='" . $arrUser['chain'] . "', `block`='" . $arrUser['block'] . "', `zip`='" . $arrUser['zip'] . "' , `country_code`='" . $coutryIso . "' , `store_open_close_day_time`='" .$arrUser['store_open_close_day_time'] . "' , `store_close_dates`='" . $arrUser['close_dates'] . "', `online_payment` = '".$arrUser['online_payment']."' WHERE u_id='" . $_SESSION['userid'] . "' AND store_id='" . $_GET['storeId'] . "'";
        }else{

            $query = "update store SET store_type='" . $arrUser['store_type'] . "',tagline='" . $arrUser['tagline'] . "',latitude='" . $arrUser['latitude'] . "',longitude='" . $arrUser['longitude'] . "',`store_name`='" . $arrUser['store_name'] . "' ,`street`='" . $arrUser['street'] . "', `city`='" . $arrUser['city'] . "', `country`='" . $arrUser['country'] . "', `email`='" . $arrUser['email'] . "', `phone`='" . $arrUser['phone'] . "', `store_link`='" . $arrUser['link'] . "'
            , `chain`='" . $arrUser['chain'] . "', `block`='" . $arrUser['block'] . "', `zip`='" . $arrUser['zip'] . "' , `country_code`='" . $coutryIso . "' , `store_close_dates`='" . $arrUser['close_dates'] . "', `online_payment` = '".$arrUser['online_payment']."' WHERE u_id='" . $_SESSION['userid'] . "' AND store_id='" . $_GET['storeId'] . "'";
        }
        $res = mysqli_query($conn , $query) or die(mysqli_error($conn));

         $query = "delete from coupon_delivery_method where store = '" . $_GET['storeId'] . "' and delivery_method in ('BARCODE','AUTO')";
             $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
        
        
        if ($arrUser['BARCODE'] == 'BARCODE') {
            $query = "insert into coupon_delivery_method(`store`,`delivery_method`)
                values('" . $_GET['storeId'] . "','BARCODE')";
             $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
        }

        if ($arrUser['DPS'] == 'DPS') {
            $query = "insert into coupon_delivery_method(`store`,`delivery_method`)
                values('" . $_GET['storeId'] . "','AUTO')";
            $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
        }

        // Create subscription for updating location
        if( !empty($_GET['storeId']) && !empty($_POST['plan_id']) )
        {
            $billingObj = new billing();
            $billingObj->subscribeForLocation($_GET['storeId']);
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


    function viewDishDetailById($dishid){
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}
        $data = array();

        $q = $db->query("SELECT * FROM dish_type WHERE dish_type.u_id = '" . $_SESSION['userid'] . "' AND dish_type.dish_id='" . $dishid . "'");

        // $res = mysql_query($query) or die(mysql_error());
        while ($rs = mysqli_fetch_array($q)) {
            $data[] = $rs;
        }

        return $data;
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
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}
        $data = array();
      //  $que = "SELECT * FROM store LEFT JOIN coupon_delivery_method ON (coupon_delivery_method.store = store.store_id)
        //    WHERE store.u_id = '" . $_SESSION['userid'] . "' AND store.store_id='" . $storeid . "'";
        
        $q = $db->query("SELECT * FROM store WHERE store.u_id = '" . $_SESSION['userid'] . "' AND store.store_id='" . $storeid . "'");

        // $res = mysql_query($query) or die(mysql_error());
        while ($rs = mysqli_fetch_array($q)) {
            $data[] = $rs;
        }
        $query = "SELECT delivery_method FROM coupon_delivery_method WHERE coupon_delivery_method.store='".$storeid."'";
        $res = mysqli_query($conn , $query) or die(mysqli_error());
        $delivery_method = "";
        while ($rs = mysqli_fetch_array($res)) {
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
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}
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
        $res = mysqli_query($conn,$QUE) or die(mysql_error());
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
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $data = array();
        //echo $_SESSION['userid'];
        $q = $db->query("SELECT store_id,store_name FROM store WHERE u_id = '" . $_SESSION['userid'] . "' AND s_activ='1'");
        while ($rs = mysqli_fetch_array($q)) {
        $stores[] = $rs;
        //echo $storename=$stores['store_name'];
           // die;
        }
        return $stores;
    }

    function getAllPublicLocationRows() {
        // print_r($data); die("dssdada");
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
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
       
        $res = mysqli_query($conn , $q) or die(mysqli_error($conn));
        $total_records = $db->numRows($res);

        return $total_records;
    }

    function getAllPublicLocation($paging_limit = '0 , 10') {
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
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
        while ($rs = mysqli_fetch_array($q)) {
            $data[] = $rs;
        }
        return $data;
    }

    function savePublicLocation($campaignId) {

        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $data = array();
        $arrUser = array();
        $inoutObj = new inOut();


        $arrUser['store_id'] = $_POST['publiclocation'];
        //print_r($arrUser['store_id']);die();

        foreach ($arrUser['store_id'] as $store) {


        $QUE = "select * from c_s_rel where campaign_id='" . $campaignId . "' AND store_id='" . $store . "' AND activ = '1'";
        $res = mysqli_query($conn , $QUE) or die("Get Company : " . mysqli_error($conn));
        $row = mysqli_fetch_array($res);
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
            $res = mysqli_query($conn , $QUE) or die("Get Company : " . mysqli_error($conn));
            $row = mysqli_fetch_array($res);
            $startdate = $row['start_of_publishing'];

            $QUE = "select end_of_publishing from campaign where campaign_id='" . $campaignId . "'";
            $res = mysqli_query($conn , $QUE) or die("Get Company : " . mysqli_error());
            $row = mysqli_fetch_array($res);
            $enddate = $row['end_of_publishing'];

            if ($startdate < date('Y-m-d')) {
                $finStartDate = date('Y-m-d');
            } else if ($startdate > date('Y-m-d')) {
                $finStartDate = $startdate;
            }
//

           $_SQL = "insert into c_s_rel(`campaign_id`,`store_id`,`start_of_publishing`,`end_of_publishing`,`activ`) values('" . $campaignId . "','" . $store . "','" . $finStartDate . "','" . $enddate . "','1')";
            $res = mysqli_query($conn , $_SQL) or die("limitttt id in relational table : " . mysqli_error($conn));
            }
 }

            $_SESSION['MESSAGE'] = COUPON_OFFER_SUCCESS;
            $url = BASE_URL . 'showCampaign.php';
            $inoutObj->reDirect($url);
            exit();
    }
       
    function getAllSelecterPublicLocation($campaignid) {
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $data = array();

     

        $q = $db->query("SELECT store_id FROM c_s_rel WHERE campaign_id = '" . $campaignid . "' AND  activ='1'");

         //$res = mysql_query($q) or die(mysql_error());
      //  $rs = mysql_fetch_array($q);
        while ($rs = mysqli_fetch_array($q)) {
            $data[] = $rs[0];
        }
        return $data;
    }

    function getAllPrivateLocationRows() {
        // print_r($data); die("dssdada");
         $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}
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

        $res = mysqli_query($conn , $q) or die(mysqli_error($conn));
        $total_records = $db->numRows($res);

        return $total_records;
    }

    function getAllPrivateLocation($paging_limit = '0 , 10') {
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}
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
        while ($rs = mysqli_fetch_array($q)) {
            $data[] = $rs;
        }
        return $data;
    }

    function getAllSelecterPrivateLocation($campaignid) {
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}
        $data = array();



        $q = $db->query("SELECT store_id FROM c_s_rel WHERE campaign_id = '" . $campaignid . "' AND  activ='1'");

         //$res = mysql_query($q) or die(mysql_error());
      //  $rs = mysql_fetch_array($q);
        while ($rs = mysqli_fetch_array($q)) {
            $data[] = $rs[0];
        }
        return $data;
    }

    function listTimeing(){
        $db = new db();
        $db->makeConnection();
        $q = $db->query("SELECT open_time,close_time FROM store_open_close");
        while ($rs = mysqli_fetch_array($q)) {
            $data[] = $rs;
        }
        return $data;
    } 

    function savePrivateLocation($campaignId) {
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}

        $data = array();
        $arrUser = array();
        $inoutObj = new inOut();

        $arrUser['store_id'] = $_POST['privatelocation'];
        foreach ($arrUser['store_id'] as $store) {
        $QUE = "select * from c_s_rel where campaign_id='" . $campaignId . "' AND store_id='" . $store . "' AND activ = '1'";
        $res = mysqli_query($conn , $QUE) or die("Get Company : " . mysqli_error($conn));
        $row = mysqli_fetch_array($res);
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
            $res = mysqli_query($conn , $QUE) or die("Get Company : " . mysqli_error($conn));
            $row = mysqli_fetch_array($res);
            $startdate = $row['start_of_publishing'];

            $QUE = "select end_of_publishing from campaign where campaign_id='" . $campaignId . "'";
            $res = mysqli_query($conn , $QUE) or die("Get Company : " . mysqli_error($conn));
            $row = mysqli_fetch_array($res);
            $enddate = $row['end_of_publishing'];

            if ($startdate < date('Y-m-d')) {
                $finStartDate = date('Y-m-d');
            } else if ($startdate > date('Y-m-d')) {
                $finStartDate = $startdate;
            }
//

           $_SQL = "insert into c_s_rel(`campaign_id`,`store_id`,`start_of_publishing`,`end_of_publishing`,`activ`) values('" . $campaignId . "','" . $store . "','" . $finStartDate . "','" . $enddate . "','1')";
            $res = mysqli_query($conn , $_SQL) or die("limitttt id in relational table : " . mysqli_error($conn));
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
        while ($rs = mysqli_fetch_array($q)) {
            $data[] = $rs[0];
        }
        return $data;
    }

    function savePrivateAdvertiseLocation($advertiseId) {
       $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}

        $data = array();
        $arrUser = array();
        $inoutObj = new inOut();
        $arrUser['store_id'] = $_POST['privatelocation'];
        foreach ($arrUser['store_id'] as $store) {
            $QUE = "select * from c_s_rel where advertise_id='" . $advertiseId . "' AND store_id='" . $store . "' AND activ = '1'";
            $res = mysqli_query($conn , $QUE) or die("Get Company : " . mysqli_error($conn));
            $row = mysqli_fetch_array($res);
            $checkAdvertiseId = $row['advertise_id'];
            if ($checkAdvertiseId) {
                $_SESSION['MESSAGE'] = STORE_NOT_SUCCESS;
                $url = BASE_URL . 'showAdvertise.php';
                $inoutObj->reDirect($url);
                exit();
            } else {
                $QUE = "select start_of_publishing from advertise where advertise_id='" . $advertiseId . "'";
                $res = mysqli_query($conn , $QUE) or die("Get Company : " . mysqli_error($conn));
                $row = mysqli_fetch_array($res);
                $startdate = $row['start_of_publishing'];

                $QUE = "select end_of_publishing from advertise where advertise_id='" . $advertiseId . "'";
                $res = mysqli_query($conn , $QUE) or die("Get Company : " . mysqli_error($conn));
                $row = mysqli_fetch_array($res);
                $enddate = $row['end_of_publishing'];

                if ($startdate < date('Y-m-d')) {
                    $finStartDate = date('Y-m-d');
                } else if ($startdate > date('Y-m-d')) {
                    $finStartDate = $startdate;
                }
                $_SQL = "insert into c_s_rel(`advertise_id`,`store_id`,`start_of_publishing`,`end_of_publishing`,`activ`) values('" . $advertiseId . "','" . $store . "','" . $finStartDate . "','" . $enddate . "','1')";
                $res = mysqli_query($conn , $_SQL) or die("limit id in relational table : " . mysqli_error($conn));
            }
        }
        $_SESSION['MESSAGE'] = COUPON_OFFER_SUCCESS;
        $url = BASE_URL . 'showAdvertise.php';
        $inoutObj->reDirect($url);
        exit();
    }

}

?>
