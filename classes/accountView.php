<?php
/*  File Name : accountView.php
 *  Description : Account View class and functions.
 * Author  :Himanshu Singh  Date: 10th,December,2010  Creation
*/

class accountView {
    /* Function Header :svrAccountViewDefault()
     *             Args: none
     *           Errors: none
     *     Return Value: none
     *      Description: User Account Details default function
    */

    function svrAccountViewDefault($paging_limit='0 , 10') {
        if (isset($_REQUEST['m']) && $_REQUEST['m'] != '') {
            $mode = $_REQUEST['m'];
        } else {
            $mode = '';
        }

        switch ($mode) {
            case 'financialStatus':
                return $this->getFinancialDetails();
                break;

            case 'loadAccount':
                $this->loadCompanyAccount();
                exit();
                break;

            case 'companyDetail':
                return $this->getCompanyDetail();
                break;

            case 'updateCompanyDetail':
                return $this->saveUpdateCompanyDetails();
                break;

//            case 'updateUserDetail':
//                return $this->saveUpdateUserDetail();
//                break;
            case 'deleteNewUser':
                return $this->deleteNewUser();
                break;

            default:
                return $this->getNewUserDetail($paging_limit);
                break;
        }
    }

    /* Function Header : getFinancialDetails()
     *             Args: none
     *           Errors: none
     *     Return Value: none
     *      Description: Get  Financial Details related to respective Company.
    */

    function getFinancialDetails() {
        $db = new db();
        $db->makeConnection();
        $data = array();
        $error = '';

        $QUE = "select company_id from employer where u_id='" . $_SESSION['userid'] . "'";
        $res = mysql_query($QUE) or die("Get Company : " . mysql_error());
        $row = mysql_fetch_array($res);
        $companyId = $row['company_id'];
        //echo  "$companyId";
        if($companyId) {
            $query = "SELECT company.* FROM company WHERE company_id='$companyId'" ;
            $q = $db->query($query);
            while ($rs = mysql_fetch_array($q)) {
                $data[] = $rs;
            }
        }
        else
            $QUE = "select company_id from user where u_id='" . $_SESSION['userid'] . "'";
        $res = mysql_query($QUE) or die("Get Company : " . mysql_error());
        $row = mysql_fetch_array($res);
        $companyId = $row['company_id'];
        //echo  "$companyId";

        $query = "SELECT company.* FROM company WHERE company_id='$companyId'" ;
        $q = $db->query($query);
        while ($rs = mysql_fetch_array($q)) {
            $data[] = $rs;
        }
        return $data;
    }

    /* Function Header : loadCompanyAccount()
     *             Args: none
     *           Errors: none
     *     Return Value: none
     *      Description:Load Company Account.
    */

    function loadCompanyAccount() {
        //echo "Inside"; //die();
		$db = new db();
        $inoutObj = new inOut();
        $db->makeConnection();
        $data = array();
        $error = '';
        $data['lAccount'] = $_POST['loadaccount'];

        $query = "SELECT * FROM employer WHERE u_id = '" . $_SESSION['userid'] . "'";
        $res = mysql_query($query) or die(mysql_error());
        $arr = mysql_fetch_array($res);
        $companyId = $arr['company_id'];

        $query = "SELECT pre_loaded_value  FROM company WHERE company_id = '" . $companyId . "'";
        $res = mysql_query($query) or die(mysql_error());
        $arr = mysql_fetch_array($res);
        $budget = $arr['pre_loaded_value'];
       
        $queryt = "SELECT company_id FROM company WHERE u_id='" . $_SESSION['userid'] . "'";
        $rest = mysql_query($queryt) or die(mysql_error());
        $arrt = mysql_fetch_array($rest);
        $checkCompId = $arrt['company_id'];

        if($checkCompId == '')
        {
        $queryt = "SELECT company_id FROM employer WHERE u_id='" . $_SESSION['userid'] . "'";
        $rest = mysql_query($queryt) or die(mysql_error());
        $arrt = mysql_fetch_array($rest);
        $checkCompId = $arrt['company_id'];
        }

        if (isset($budget)) {
            //echo "here";die;
            $query = "UPDATE company SET pre_loaded_value = $budget + '" . $data['lAccount'] . "' where company_id  = '" . $checkCompId . "'";
            $res = mysql_query($query) or die(mysql_error());
        } else {
            // echo "Inhere";die;
            $query = "UPDATE company SET pre_loaded_value =  '" . $data['lAccount'] . "' where company_id ='" . $checkCompId . "'";
            $res = mysql_query($query) or die(mysql_error());
        }

        /////////////////// (change activ state of campaign into 1 from 3)
        $query3 = "SELECT * FROM campaign WHERE company_id = '" . $companyId . "' and (spons = '3' or s_activ = '3')";
        $res3 = mysql_query($query3) or die(mysql_error());
        while( $arr3 = mysql_fetch_array($res3))
        {
        $campaignId = $arr3['campaign_id'];

        $query1 = "UPDATE campaign SET `spons` = '1',`s_activ` = '0' WHERE campaign_id = '" . $campaignId . "'";
        $res1 = mysql_query($query1) or die(mysql_error());

        
        $query2 = "UPDATE c_s_rel SET `activ` = '1' WHERE campaign_id = '" . $campaignId . "' and activ != '2'";
        $res2 = mysql_query($query2) or die(mysql_error());

        $query5 = "SELECT * FROM c_s_rel WHERE campaign_id = '" . $campaignId . "'";
        $res5 = mysql_query($query5) or die(mysql_error());
         while( $arr5 = mysql_fetch_array($res5))
        {
        $couponId = $arr5['coupon_id'];
        
        $query4 = "UPDATE coupon SET `is_sponsored` = '1' WHERE coupon_id = '" . $couponId . "'";
        $res4 = mysql_query($query4) or die(mysql_error());
        }
        }
        /////////////////////////////////////////////////

        $_SESSION['MESSAGE'] = LOAD_ACCOUNT_SUCCESS;
        $url = BASE_URL . 'showCampaign.php';
		$inoutObj = new inOut();
            $inoutObj->reDirect($url);
		//header("location:".$url);
        exit;
    }

    /* Function Header : getCompanyDetail()
     *             Args: none
     *           Errors: none
     *     Return Value: none
     *      Description:Get Company Details.
    */

    function getCompanyDetail() {
        $db = new db();
        $db->makeConnection();
        $data = array();
        $error = '';

        $QUE = "select company_id from employer where u_id='" . $_SESSION['userid'] . "'";
        $res = mysql_query($QUE) or die("Get Company : " . mysql_error());
        $row = mysql_fetch_array($res);
        $companyId = $row['company_id'];
        //echo  "$companyId";
        if($companyId) {
            $query = "SELECT company.*,country.name as cname,country.iso as ciso FROM company left join country on (country.iso = company.country) WHERE company.company_id='$companyId'" ;
            $q = $db->query($query);
            while ($rs = mysql_fetch_array($q)) {
                $data[] = $rs;
            }
        }
        else {
            $QUE = "select company_id from user where u_id='" . $_SESSION['userid'] . "'";
            $res = mysql_query($QUE) or die("Get Company : " . mysql_error());
            $row = mysql_fetch_array($res);
            $companyId = $row['company_id'];
            //echo  "$companyId";

            $query = "SELECT company.*,country.name as cname,country.iso as ciso FROM company left join country on (country.iso = company.country) WHERE company.company_id='$companyId'" ;
            $q = $db->query($query);
            while ($rs = mysql_fetch_array($q)) {
                $data[] = $rs;
            }
        }
        return $data;
    }

    /* Function Header : getUserDetail()
     *             Args: none
     *           Errors: none
     *     Return Value: none
     *      Description:View User Details.
    */

    function getUserDetail() {
        $db = new db();
        $db->makeConnection();
        $data = array();
        $error = '';


        $query = "SELECT * FROM user WHERE u_id='" . $_SESSION['userid'] . "'";
        $q = $db->query($query);
        while ($rs = mysql_fetch_array($q)) {
            $data[] = $rs;
        }
        return $data;
    }

    /* Function Header : updateCompanyDetails()
     *             Args: none
     *           Errors: none
     *     Return Value: none
     *      Description:Load Company Account.
    */

    function saveUpdateCompanyDetails() {
        //echo "here";die;
        $inoutObj = new inOut();
        $db = new db();
        $error = '';

        $arrUser['tzcountries'] = $_POST['areatimezone'];
        $arrUser['timezones'] = $_POST['timezone'];
        $arrUser['currencies'] = $_POST['currency'];
        //$arrUser['company_name'] = $_POST['compname'];
        $arrUser['orgnr'] = $_POST['orgcode'];
        $arrUser['street'] = $_POST['streetadd'];
        $arrUser['city'] = $_POST['city'];
        $arrUser['zip'] = $_POST['zipcode'];
        $arrUser['country'] = $_POST['country'];

        if ($error != '') {
            $_SESSION['MESSAGE'] = $error;
            $_SESSION['post'] = $_POST;
            $url = BASE_URL . 'activate.php';
            $inoutObj->reDirect($url);
            exit();
        } else {
            $_SESSION['post'] = "";
        }

        $QUE = "select company_id from user where u_id='" . $_SESSION['userid'] . "'";
        $res = mysql_query($QUE) or die("Get Company : " . mysql_error());
        $row = mysql_fetch_array($res);
        $companyId = $row['company_id'];
        //echo  "$companyId";
        $query = "UPDATE company SET
                tzcountries='" . $arrUser['tzcountries'] . "',
                timezones='" . $arrUser['timezones'] . "',
                currencies='" . $arrUser['currencies'] . "',
                orgnr='" . $arrUser['orgnr'] . "',
                street='" . $arrUser['street'] . "',
                city='" . $arrUser['city'] . "',
                zip='" . $arrUser['zip'] . "',
                country='" . $arrUser['country'] . "'
                WHERE u_id='" . $_SESSION['userid'] . "' OR company_id='$companyId'";
        $res = mysql_query($query) or die(mysql_error());
        $_SESSION['MESSAGE'] = UPDATED_COMPANY;
        $url = BASE_URL . 'viewComapany.php';
        $inoutObj->reDirect($url);

        exit();
    }

    /* Function Header : saveUpdateUserDetails()
     *             Args: none
     *           Errors: none
     *     Return Value: none
     *      Description:Load Company Account.
    */

    function saveUpdateUserDetail($reseller='') {
        $privatekey = "6Ldv8r4SAAAAAOIpAG7IaDQryd7rDtzMKhCug1DO";
        $inoutObj = new inOut();
        $db = new db();
        $arrUser = array();
        $error = '';

        $arrUser['fname'] = $_POST['fname'];
        $arrUser['lname'] = $_POST['lname'];
        $arrUser['role'] = "Store Admin"; //addslashes(trim($_POST['role']));
        $arrUser['phone'] = trim($_POST['phone']);
        $arrUser['mobile_phone'] = trim($_POST['mob']);

        if ($error != '') {
            $_SESSION['MESSAGE'] = $error;
            $_SESSION['post'] = $_POST;
            if($reseller == '')
            {
            $url = BASE_URL . 'editUser.php';

            $inoutObj->reDirect($url);
            exit();
            }else {
                 $url = BASE_URL . 'editUser.php?from=reseller';

            $inoutObj->reDirect($url);
            exit();
            }
        } else {
            $_SESSION['post'] = "";
            $rowUniqueId = uuid();
            $arrUser['email_varify_code'] = md5(time());
             $arrUser['mobile_phone'];
            //die;
            $query = "UPDATE user SET
               fname = '" . $arrUser['fname'] . "',
               lname = '" . $arrUser['lname'] . "',
               phone = '" . $arrUser['phone'] . "',
               mobile_phone = '" . $arrUser['mobile_phone'] . "'
               WHERE u_id = '" . $_SESSION['userid'] . "'";
            $res = mysql_query($query) or die(mysql_error());
            $_SESSION['MESSAGE'] = UPDATED_USER;

            if($reseller == '')
            {
            $url = BASE_URL . 'viewUser.php';
            $inoutObj->reDirect($url);
            exit();
            } else {
            $url = BASE_URL . 'viewResellerUser.php';
            $inoutObj->reDirect($url);
            exit();
            }
        }
    }

    function saveNewUserInfo() {
        //$privatekey = "6Ldv8r4SAAAAAOIpAG7IaDQryd7rDtzMKhCug1DO";
        $inoutObj = new inOut();
        $db = new db();
        $arrUser = array();
        $error = '';
        $arrUser['email'] = $_POST['emailid'];
        $arrUser['passwd'] = $_POST['pwd'];
        $arrUser['fname'] = addslashes(trim($_POST['fname']));
        $arrUser['lname'] = addslashes(trim($_POST['lname']));
        $arrUser['role'] = "Store Admin"; //addslashes(trim($_POST['role']));
        $arrUser['cprefix'] = $_POST['cprefix'];
        $arrUser['phone'] = trim($_POST['phone']);
        $arrUser['mobile_phone'] = trim($_POST['mob']);

        if ($error != '') {
            $_SESSION['MESSAGE'] = $error;
            $_SESSION['post'] = $_POST;
            $url = BASE_URL . 'addNewUser.php';

            $inoutObj->reDirect($url);
            exit();
        } else {
            $_SESSION['post'] = "";
            $userId = uuid();
            $password_sha256 = $arrUser['passwd'];
            $password_hash = hash_hmac('sha256', $password_sha256, $userId);
             //$password_sha1 = sha1($arrUser['passwd']);
             //print_r($password_sha1);die();

            $QUE = "select company_id from employer where u_id='" . $_SESSION['userid'] . "'";
            $res = mysql_query($QUE) or die("Get Company : " . mysql_error());
            $row = mysql_fetch_array($res);
            $companyId = $row['company_id'];
            
          
           $query = "INSERT INTO user(`u_id`, `email`, `passwd`, `fname`, `lname`, `role`, `phone`, `mobile_phone`,`email_varify_code`,`activ`,`company_id`)
                VALUES ('" . $userId . "', '" . $arrUser['email'] . "', '" .$password_hash . "', '" . $arrUser['fname'] . "', '" . $arrUser['lname'] . "','" . $arrUser['role'] . "', '"  .$arrUser['cprefix']. $arrUser['phone'] . "', '"  .$arrUser['cprefix']. $arrUser['mobile_phone'] . "','" . $arrUser['email_varify_code'] . "','5','" . $companyId . "');";
            $res = mysql_query($query) or die(mysql_error());
          
              $query = "INSERT INTO employer(`company_id`, `u_id`)
             VALUES ('" . $companyId . "', '" . $userId . "');";
              $res = mysql_query($query) or die(mysql_error());
///////////////////////////////////////
//            if ($res) {
//                $mailObj = new emails();
//                $mailObj->sendVarificationEmail($rowUniqueId, $arrUser['email_varify_code']);
//                // These session variable bea ctive if user has been complete his mail varification
//                $_SESSION['userid'] = $data['u_id'];
//                $_SESSION['userrole'] = $data['role'];
//                $_SESSION['username'] = $arrUser['fname'] . " " . $arrUser['lname'];
//                $_SESSION['userid'] = $rowUniqueId;
//            }
//
//            $_SESSION['MESSAGE'] = REGISTER_SUCCESS;
//            $_SESSION['REG_STEP'] = 1;
//            $_SESSION['active_state'] = 1;

            $url = BASE_URL . 'viewNewUser.php';
            $_SESSION['MESSAGE'] = INSERTED_USER;
            $inoutObj->reDirect($url);
            exit();
        }
    }

//    function getNewUserDetail($paging_limit='0 , 10') {
//        $db = new db();
//        $db->makeConnection();
//        $data = array();
//        $error = '';
//
//        $QUE = "select company_id from company where u_id='" . $_SESSION['userid'] . "'";
//        $res = mysql_query($QUE) or die("Get Company : " . mysql_error());
//        $row = mysql_fetch_array($res);
//        $companyId = $row['company_id'];
//
//
//        $query = "SELECT usr.* FROM user as usr LEFT JOIN employer as emp ON (emp.company_id=usr.company_id) WHERE emp.company_id='" . $companyId . "'  LIMIT {$paging_limit}";
//        $q = $db->query($query);
//        while ($rs = mysql_fetch_array($q)) {
//            $data[] = $rs;
//        }
//        return $data;
//    }

    /////////////////////////////////////
     function getNewUserDetailRow() {

        //$inoutObj = new inOut();
        $db = new db();
        $db->makeConnection();
        $data = array();

        $res = $this->searchNewUser();

        $total_records = $db->numRows($res);

        return $total_records;
    }

     function searchNewUser($paging_limit=0) {
        if (isset($_REQUEST['keyword']) OR isset($_REQUEST['key']) OR isset($_REQUEST['ke'])) {
            // $qstr1 = " store_name REGEXP '[[:<:]]".trim($_REQUEST['keyword'])."[[:>:]]' ";
            // $qstr2 = " email REGEXP '[[:<:]]".trim($_REQUEST['key'])."[[:>:]]' ";
            $set_keywords = "";
            if ($_REQUEST['keyword']) {
                $set_keywords.= 'usr.fname LIKE "%' . trim($_REQUEST['keyword']) . '%" AND ';
            }
            if ($_REQUEST['key']) {
                $set_keywords.= 'usr.lname LIKE "%' . trim($_REQUEST['key']) . '%" AND ';
            }
            if ($_REQUEST['ke']) {
                $set_keywords.= 'usr.email LIKE "%' . trim($_REQUEST['ke']) . '%" AND ';
            }
            
            // $set_keywords = "(u_id='".$_SESSION['userid']."' AND ".$qstr1.") OR
        }
        else
            $set_keywords = " 1 AND ";


        $QUE = "select company_id from employer where u_id='" . $_SESSION['userid'] . "'";
        $res = mysql_query($QUE) or die("Get Company : " . mysql_error());
       $row = mysql_fetch_array($res);
       $companyId = $row['company_id'];


        if($paging_limit)
            $limit = "limit ".$paging_limit;
        
            $QUE = "SELECT usr.* FROM user as usr LEFT JOIN employer as emp ON (emp.u_id=usr.u_id) WHERE emp.company_id ='" . $companyId . "' AND $set_keywords 1 ".$limit;
           $res = mysql_query($QUE) or die(mysql_error());
        
        return $res;
        
     }

      function getNewUserDetail($paging_limit='0 , 10') {

        //$inoutObj = new inOut();
        $db = new db();
        $db->makeConnection();
        $data = array();

        $q = $this->searchNewUser($paging_limit);

        while ($rs = mysql_fetch_array($q)) {
            $data[] = $rs;
        }
        return $data;
    }


 /////////////////////////////////




    /* Function Header : getNewUserDetailRow()
     *             Args: none
     *           Errors: none
     *     Return Value: none
     *      Description: New User Details.
    */

//    function getNewUserDetailRow() {
//        $db = new db();
//        $db->makeConnection();
//        $data = array();
//        $error = '';
//        $QUE = "select company_id from company where u_id='" . $_SESSION['userid'] . "'";
//        $res = mysql_query($QUE) or die("Get Company : " . mysql_error());
//        $row = mysql_fetch_array($res);
//        $companyId = $row['company_id'];
//
//
//        $query = "SELECT * FROM user as usr LEFT JOIN employer as emp ON  (emp.company_id=usr.company_id)  WHERE emp.company_id='" . $companyId . "'";
//        $res = mysql_query($query) or die(mysql_error());
//        $total_records = $db->numRows($res);
//
//        return $total_records;
//    }

    /* Function Header : saveChangePassword()
     *             Args: none
     *           Errors: none
     *     Return Value: none
     *      Description:Change Password.
    */

    function saveChangePassword($reseller='') {

        $inoutObj = new inOut();
        $db = new db();
        $arrUser = array();
        $error = '';

        $arrUser['passwd'] = $_POST['pwd'];
         $arrUser['oPasswd'] = $_POST['opwd'];

         $query = "select * from user where email = '".$email."'";
         $res= $db->query($query);
         $rs = mysql_fetch_array($res);
          $uId = $_SESSION['userid'];
           
          ///for old 
          $password_old = $arrUser['oPasswd'];
           $password_hash_old = hash_hmac('sha256', $password_old, $uId);

           //for new
          $password_new = $arrUser['passwd'];
           $password_hash_new = hash_hmac('sha256', $password_new, $uId);

          
        $QUE = "select u_id from user where u_id='" . $_SESSION['userid'] . "' AND passwd = '" .$password_hash_old . "'";
        $res = mysql_query($QUE) or die("Get Company : " . mysql_error());
        $rowCount = mysql_num_rows($res);


        if ($rowCount) {
            $query = "UPDATE user SET
               passwd='" .$password_hash_new . "'
                WHERE u_id='" . $_SESSION['userid'] . "'";
            $res = mysql_query($query) or die(mysql_error());
            $_SESSION['MESSAGE'] = UPDATED_USERPASS;
        if($reseller == '')
        {
            $url = BASE_URL . 'viewUser.php';
            $inoutObj->reDirect($url);
            exit();
        } else {
             $url = BASE_URL . 'viewResellerUser.php';
            $inoutObj->reDirect($url);
            exit();
        }
        }
        else {
            $_SESSION['MESSAGE'] = UNUPDATED_USER;
            if($reseller == '')
            {
            $url = BASE_URL . 'changePassword.php';
            $inoutObj->reDirect($url);
            exit();
            } else {
             $url = BASE_URL . 'changePassword.php?from=reseller';
            $inoutObj->reDirect($url);
            exit();
            }

        }

    }

    /* Function Header : getNewUserDetailById($userid)
     *             Args: none
     *           Errors: none
     *     Return Value: none
     *      Description:New User Detail By Id.
    */

    function getNewUserDetailById($userid) {

        $db = new db();
        $db->makeConnection();
        $data = array();
        $q = $db->query("SELECT * FROM user  WHERE u_id ='" . $userid . "'");

        // $res = mysql_query($query) or die(mysql_error());
        while ($rs = mysql_fetch_array($q)) {
            $data[] = $rs;
        }
        return $data;
    }

    function saveUpdateNewUserDetailById($userid) {
        //$privatekey = "6Ldv8r4SAAAAAOIpAG7IaDQryd7rDtzMKhCug1DO";

        $inoutObj = new inOut();
        $db = new db();
        $arrUser = array();
        $error = '';

        $arrUser['fname'] = $_POST['fname'];
        $arrUser['lname'] = $_POST['lname'];
        $arrUser['role'] = "Store Admin"; //addslashes(trim($_POST['role']));
        
        $arrUser['phone'] = trim($_POST['phone']);
        $arrUser['mobile_phone'] = trim($_POST['mob']);

        if ($error != '') {
            $_SESSION['MESSAGE'] = $error;
            $_SESSION['post'] = $_POST;
            $url = BASE_URL . 'editNewUser.php';

            $inoutObj->reDirect($url);
            exit();
        } else {
            $_SESSION['post'] = "";
            $query = "UPDATE user SET
               fname='" . $arrUser['fname'] . "',
                lname='" . $arrUser['lname'] . "',
                phone='" . $arrUser['phone'] . "',
                mobile_phone='" . $arrUser['mobile_phone'] . "'
                WHERE u_id='" . $userid . "'";
            $res = mysql_query($query) or die(mysql_error());

            $_SESSION['MESSAGE'] = UPDATEDNEW_USER;
            $url = BASE_URL . 'viewNewUser.php';
            $inoutObj->reDirect($url);
            exit();
        }
    }

    function deleteNewUser() {
        $db = new db();
        $inoutObj = new inOut();
        $db->makeConnection();
        $_SQL = "DELETE FROM `cumbari_admin`.`user` WHERE u_id = '" . $_GET['userId'] . "'";
        $q = $db->query($_SQL);

        $_SESSION['MESSAGE'] = DELETED_USER;
        $url = BASE_URL . 'viewNewUser.php';
        $inoutObj->reDirect($url);
    }

//    function  allowUser() {
//        $db = new db();
//        $inoutObj = new inOut();
//        $db->makeConnection();
//        $data = array();
//        $error = '';
//        $QUE = "select company_id from employer where u_id='" . $_SESSION['userid'] . "'";
//        $res = mysql_query($QUE) or die("Get Company : " . mysql_error());
//        $row = mysql_num_rows($res);
//        //$companyId = $row['company_id'];
//
//        if($row) {
//
//            return true;
//        }
//
//        return false;
//
//    }

}
?>