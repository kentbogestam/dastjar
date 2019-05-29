<?php

/* File Name : registration.php
 *  Description : Registration class and functions
 *  Author  : Sushil Singh  Date: 14th,Nov,2010
 */

class registration {
    /* Function Header :svrRegDflt()
     *             Args: none
     *           Errors: none
     *     Return Value: none
     *      Description: User Registration default function
     */

    function svrRegDflt() {

        if (isset($_REQUEST['m']) && $_REQUEST['m'] != '') {
            $mode = $_REQUEST['m'];
        } else {
            $mode = '';
        }

        switch ($mode) {

            case 'savereg':
                $this->saveAccountDetails();
                break;

            case 'savecomp':
                $this->saveCompanyDetails();
                break;

			case 'saveregseller':
                $this->saveResellerAccountDetails();
                break;
        }
    }

    /* Function Header :saveCreateAccount()
     *             Args: none
     *           Errors: none
     *     Return Value: none
     *      Description: Save details of registration process
     */

    function saveAccountDetails() {
        $privatekey = "6Ldv8r4SAAAAAOIpAG7IaDQryd7rDtzMKhCug1DO";
        $inoutObj = new inOut();
        $db = new db();
        $arrUser = array();
        $error = '';
        if ($_POST["recaptcha_response_field"]) {
            $resp = recaptcha_check_answer($privatekey,
                            $_SERVER["REMOTE_ADDR"],
                            $_POST["recaptcha_challenge_field"],
                            $_POST["recaptcha_response_field"]);

            if ($resp->is_valid) {

            } else {
                # set the error code so that we can display it
                $error.= ERROR_CAPTCHA; //$resp->error;
                $_SESSION['MESSAGE'] = $error;
                $_SESSION['post'] = $_POST;
                $url = BASE_URL . 'registrationProcess.php';

                $inoutObj->reDirect($url);
                exit();
            }
        }

        //echo $link = BASE_URL."reg_action.php?vcode=".md5(time()); die();
        //Request all form details
        $arrUser['email'] = $_POST['emailid'];
        $arrUser['passwd'] = $_POST['pwd'];
        $arrUser['fname'] = addslashes(trim($_POST['fname']));
        $arrUser['lname'] = addslashes(trim($_POST['lname']));
        $arrUser['role'] = "Store Admin"; //addslashes(trim($_POST['role']));
        $arrUser['cprefix'] = $_POST['cprefix'];
        $arrUser['phone'] = trim($_POST['phone']);
        $arrUser['mobile_phone'] = trim($_POST['mob']);
        //retailer session
         $arrUser['retail'] = $_POST['$_SESSION["Retailers"]'];

        $error.= ( $arrUser['email'] == '') ? ERROR_EMAIL : '';

        $error.= ( $arrUser['passwd'] == '') ? ERROR_PASSWORD : '';

        $error.= ( $arrUser['fname'] == '') ? ERROR_FNAME : '';

        $error.= ( $arrUser['lname'] == '') ? ERROR_LNAME : '';

        // $error.= ($arrUser['role']=='')?ERROR_ROLE:'';

        $error.= ( $arrUser['phone'] == '' && $arrUser['mobile_phone'] == '') ? ERROR_PHONE_MOBILE : '';


        if ($error != '') {
            $_SESSION['MESSAGE'] = $error;
            $_SESSION['post'] = $_POST;
            $url = BASE_URL . 'registrationProcess.php';

            $inoutObj->reDirect($url);
            exit();
        } else {
            $_SESSION['post'] = "";
            $rowUniqueId = uuid();
            //$password_sha1 = sha1($arrUser['passwd']);
            $password_sha256 = $arrUser['passwd'];
           $password_hash = hash_hmac('sha256', $password_sha256, $rowUniqueId);
           $passwordHash = password_hash($password_sha256, PASSWORD_BCRYPT);
       
            $arrUser['email_varify_code'] = md5(time());
			
            $query = "INSERT INTO user (u_id, email, passwd, password, fname, lname, role, phone, mobile_phone,email_varify_code,activ)
                VALUES ('" . $rowUniqueId . "', '" . $arrUser['email'] . "', '" . $password_hash . "', '".$passwordHash."', '" . $arrUser['fname'] . "', '" . $arrUser['lname'] . "','" . $arrUser['role'] . "', '" . $arrUser['cprefix'] . $arrUser['phone'] . "', '" . $arrUser['cprefix'] . $arrUser['mobile_phone'] . "','" . $arrUser['email_varify_code'] . "','8');";
            //$res = mysql_query($query) or die(mysql_error());

                // Create connection
            $conn = $db->makeConnection();
            // Check connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            $res = mysqli_query($conn, $query)or die(mysqli_error($conn));

            if ($res) {
                //echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }

            mysqli_close($conn);

            $ch = curl_init();
            $skipper = "luxury assault recreational vehicle";
            $fields = array( 'email' => $arrUser['email'],'password' => $arrUser['passwd']);
            $postvars = '';
            foreach($fields as $key=>$value) {
            $postvars .= $key . "=" . $value . "&";
            }
            $url = USER_APP_BASE_URL . "api/v1/save-password";
            // echo $url;
            // die();

            curl_setopt($ch,CURLOPT_URL,$url);
            curl_setopt($ch,CURLOPT_POST, 1);                //0 for a get request
            curl_setopt($ch,CURLOPT_POSTFIELDS,$postvars);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch,CURLOPT_CONNECTTIMEOUT ,3);
            curl_setopt($ch,CURLOPT_TIMEOUT, 20);
            $response = curl_exec($ch);
            $err = curl_error($ch);
            curl_close ($ch);
            if ($err) {
            //echo "cURL Error #:" . $err;
            } else {
            //echo $response;
            }



            //$res = $db->makeConnection()->query($query);

            //echo $res;
            //$sql = mysqli_query($success, $query);
            //$row = mysqli_num_rows($sql);

            if ($res) {
                //echo "first";
                $mailObj = new emails();
                $mailObj->sendVarificationEmail($rowUniqueId, $arrUser['email_varify_code']);
                // These session variable bea ctive if user has been complete his mail varification

                $_SESSION['userid'] = $data['u_id'];
                $_SESSION['userrole'] = $data['role'];
                $_SESSION['username'] = $arrUser['fname'] . " " . $arrUser['lname'];
                $_SESSION['userid'] = $rowUniqueId;
            }
            //echo $_SESSION['temp_campId'];
            if($_SESSION['temp_campId'])
            {
                echo "second";
                $temp_campId = $_SESSION['temp_campId'];
                $temp_ccode = $_SESSION['temp_ccode'];
                $temp_uId = $_SESSION['temp_uId'];

             $temp_value = $temp_campId.'#'.$temp_ccode.'#'.$temp_uId;

             $query = "UPDATE user SET temp='" . $temp_value . "' WHERE u_id = '" . $_SESSION['userid'] . "'";
            $res = mysql_query($query) or die(mysqli_error($conn));
              
            }

            $_SESSION['MESSAGE'] = REGISTER_EMAIL_VARIFICATION;
            $_SESSION['REG_STEP'] = 8;
            $_SESSION['active_state'] =8;

            
            $url = BASE_URL . 'registrationStep.php';
            $inoutObj->reDirect($url);
            exit();
        }
    }

    /* Function Header :isValidRegistrationStep()
     *             Args: num (1,2,3,4,5)
     *           Errors: none
     *     Return Value: true/false
     *      Description: Method will check if the current page is right in the registration process
     */

    function isValidRegistrationStep() {
        //print_r($_SERVER); //['PHP_SELF'];

        $page_name = explode("/", $_SERVER['PHP_SELF']);
		if(!empty($page_name[2]))
		{
			$script_name = $page_name[2]; // for local server.
		}
		else
		{
			$script_name = $page_name[1]; // for online server.
		}
		
		
        //echo "<br>";
		//print_r($page_name);
		//echo $page_name[2];
        //die();
        $offer = array();
        $offer[0] = "campaignOffer.php";
        $offer[1] = "advertiseOffer.php";
        $offer[2] = "standardOffer.php";
        $offer[3] = "activation.php";

        $store = array();
        $store[0] = "createStore.php";
        $store[1] = "activation.php";

        $inoutObj = new inOut();
        $db = new db();
       // $inoutObj = new inOut();
		//echo "session".$_SESSION['REG_STEP']."--TTTT".$page_name[1]."TTT-----";
        // if ((!$_SESSION['REG_STEP']) && ($script_name != "registrationProcess.php")) {
        //     $url = BASE_URL . 'registrationStep.php'; //die();
        //     $inoutObj->reDirect($url);
        //     exit;
        // }
        //echo "case1"; die();
        if ($_SESSION['REG_STEP'] == 1 && ($script_name != "addCompany.php")) {
            $url = BASE_URL . 'registrationStep.php?reg_step=1';
            $inoutObj->reDirect($url);
            exit;
        } else if ($_SESSION['REG_STEP'] == 2 && (!in_array($script_name, $offer))) {
            $url = BASE_URL . 'registrationStep.php?reg_step=2';
            $inoutObj->reDirect($url);
            exit;
        } else if ($_SESSION['REG_STEP'] == 3 && (!in_array($script_name, $store))) {
            $url = BASE_URL . 'registrationStep.php?reg_step=3';
            $inoutObj->reDirect($url);
            exit;
        } else if ($_SESSION['REG_STEP'] == 4 && (!in_array($script_name, $store))) {
            $url = BASE_URL . 'registrationStep.php?reg_step=3';
            $inoutObj->reDirect($url);
            exit;
        } 
        
        
        
        else if ($_SESSION['REG_STEP'] == 5 && ($script_name != "activation.php")) {
            $url = BASE_URL . 'registrationStep.php?reg_step=5';
            $inoutObj->reDirect($url);
            exit;
        }else if ($_SESSION['REG_STEP'] == 8) {
            $_SESSION['MESSAGE']=EMAIL_VARIFICATION_CHECK;
            //$_SESSION['MESSAGE'] = "Please confirm your email varificvation";
			$url = BASE_URL . 'registrationStep.php?reg_step=8';
            $inoutObj->reDirect($url);
            exit;
        }
        //echo "Last case"; die();
    }

    /* Function Header :saveCompanyDetails()
     *             Args: none
     *           Errors: none
     *     Return Value: none
     *      Description: To store company detials of registered user, this is the second step of registration process
     */

    function saveCompanyDetails() {
        $inoutObj = new inOut();
        $db = new db();

        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}


        $arrUser = array();
        $error = '';
        //echo $link = BASE_URL."reg_action.php?vcode=".md5(time()); die();
        //Request all form details
        $arrUser['tzcountries'] = $_POST['areatimezone'];
        $arrUser['timezones'] = $_POST['timezone'];
        $arrUser['currencies'] = addslashes(trim($_POST['currency']));
        $arrUser['company_name'] = addslashes(trim($_POST['compname']));
        // $arrUser['orgnr'] = $_POST['orgcode'];
        $orgcode = str_replace(' ', '', $_POST['orgcode']);
        $arrUser['orgnr'] = preg_replace("/[^a-zA-Z0-9]+/", "", $orgcode);
        $arrUser['street'] = trim($_POST['streetadd']);
        $arrUser['zip'] = trim($_POST['zipcode']);
        $arrUser['city'] = trim($_POST['city']);
        $arrUser['country'] = $_POST['country'];
        $arrUser['lowLevel'] = $_POST['lowLevel'];
        
        if($arrUser['lowLevel'] == '')
        { 
            $arrUser['lowLevel'] = '50'; 
        }

        if($arrUser['typeofrestrurant'] == '')
        { 
            $arrUser['lowLevel'] = '1'; 
        }

        $error.= ( $arrUser['tzcountries'] == '') ? ERROR_TZCOUNTRY : '';

        $error.= ( $arrUser['timezones'] == '') ? ERROR_TIMEZONE : '';

        $error.= ( $arrUser['currencies'] == '') ? ERROR_CURRENCIES : '';

        $error.= ( $arrUser['company_name'] == '') ? ERROR_COMP_NAME : '';

        $error.= ( $arrUser['orgnr'] == '') ? ERROR_COMP_ORG : '';

        $error.= ( $arrUser['street'] == '') ? ERROR_COMP_STREET : '';

        $error.= ( $arrUser['zip'] == '') ? ERROR_COMP_ZIP : '';

        $error.= ( $arrUser['city'] == '') ? ERROR_COMP_CITY : '';

        $error.= ( $arrUser['country'] == '') ? ERROR_COMP_COUNTRY : '';

        if ($error != '') {
            $_SESSION['MESSAGE'] = $error;
            $_SESSION['post'] = $_POST;
            $url = BASE_URL . 'addCompany.php';

            $inoutObj->reDirect($url);
            exit();
        } else {
            $_SESSION['post'] = "";

            // Add company details in the database
            $compUniqueId = uuid();
            //echo $_SESSION['userid'];
			$pre_loaded_value = 10000;
             $query = "INSERT INTO company(`company_id` ,`u_id` ,`company_name` ,`orgnr` ,`street` ,`zip` ,`city` ,`country` ,`tzcountries` ,`timezones` ,`currencies`,`low_level`,`pre_loaded_value`)
                VALUES ('" . $compUniqueId . "', '" . $_SESSION['userid'] . "', '" . $arrUser['company_name'] . "', '" . $arrUser['orgnr'] . "', '" . $arrUser['street'] . "', '" . $arrUser['zip'] . "', '" . $arrUser['city'] . "', '" . $arrUser['country'] . "', '" . $arrUser['tzcountries'] . "', '" . $arrUser['timezones'] . "', '" . $arrUser['currencies'] . "', '" . $arrUser['lowLevel'] . "',".$pre_loaded_value.");";

            $res = mysqli_query($conn,$query)or die(mysqli_error($conn));
            $storeUniqueId = uuid();

            //$query = "UPDATE user SET activ='2' WHERE u_id = '" . $_SESSION['userid'] . "'";
            $query = "UPDATE user SET activ='5' WHERE u_id = '" . $_SESSION['userid'] . "'";
            $res = mysqli_query($conn,$query) or die(mysqli_error($conn));

            $query = "INSERT INTO employer(`u_id`,`company_id`)
            VALUES ( '" . $_SESSION['userid'] . "','" . $compUniqueId . "')";
            $res = mysqli_query($conn,$query) or die("Employer : " . mysqli_error($conn));
            // Add Default store by company registration
            // Since we are not clear at company state whether to add these details as store.
            // $query = "INSERT INTO store(`store_id` ,`u_id` ,`store_name` ,`street`,`city` ,`country`)
            // VALUES ('".$storeUniqueId."', '".$_SESSION['userid']."', '".$arrUser['company_name']."', '".$arrUser['street']."', '".$arrUser['city']."', '".$arrUser['country']."');";
            // $res = mysql_query($query) or die(mysql_error());


            $_SESSION['MESSAGE'] = ADD_COUNTRY_SUCCESS;
            //$_SESSION['REG_STEP'] = 2;
            // $_SESSION['active_state'] = 2;
            $_SESSION['active_state'] = 5;
            $url = BASE_URL . 'showStore.php';
            $inoutObj->reDirect($url);
            exit();
        }
    }

    /* Function Header :emailValification()
     *             Args: none
     *           Errors: none
     *     Return Value: none
     *      Description: 
     */

    function emailVarification($get) {
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}

        $inoutObj = new inOut();
        $url_recieved = base64_decode($get['ucode']);
        $data = explode("&", $url_recieved);
        //print_r($data); 
		$uid = explode("=", $data[0]);
        $vcode = explode("=", $data[1]);
        $retailers = explode("=", $data[2]);
        $_SESSION["Retailers"] = $retailers[1];

        $query = "select * from user where u_id='" . $uid[1] . "'";
        $res = mysqli_query($conn, $query) or die(mysql_error());
        $result = mysqli_fetch_array($res);
	//echo $result['email_varify_code']." VCODE ".$vcode['0']; die();
        if ($result['email_varify_code'] == $vcode['1']) {
            $query = "UPDATE user SET email_varify_code='0', activ='1' where  u_id='" . $uid[1] . "'";
            $res = mysqli_query($conn ,$query) or die(mysql_error());

            $_SESSION['userid'] = $result['u_id'];
            $_SESSION['userrole'] = $result['role'];
            $_SESSION['username'] = $result['fname'] . " " . $result['lname'];
            $_SESSION['useremailid'] = $result['email'];

            $_SESSION['MESSAGE'] = SUCCESS_EMAIL_VALID;
            $_SESSION['REG_STEP'] = 1;
///////////////////for testing
                //  unset($_SESSION['userid']);
		//unset($_SESSION['active_state']);
		//unset($_SESSION['userrole']);
		//unset($_SESSION['username']);
		//unset($_SESSION['useremail']);
		    unset($_SESSION['usersessionid']);
		   //unset($_SESSION['REG_STEP']);
    		unset($_SESSION['MAIL_URL']);
	   	    unset($_SESSION['createStore']);
            unset($_SESSION['ccode']);
            unset($_SESSION['temp_campId']);
            unset($_SESSION['temp_ccode']);
            unset($_SESSION['temp_uId']);

            $url = BASE_URL . 'registrationStep.php';


            $inoutObj->reDirect($url);
        } else {
            $_SESSION['MESSAGE'] = VALID_MATCH_ERROR;
            $_SESSION['REG_STEP'] = 8;
            $url = BASE_URL . 'registrationStep.php';
            $inoutObj->reDirect($url);
        }
    }


	function getCountryList()
	{
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

		$query = "select iso,printable_name from country where iso in('SE','IN','DE')";
        $result = mysqli_query($conn, $query);

		$countryList=array();
		
		while($row=mysqli_fetch_array($result))
		{
			$countryList[$row['iso']]=$row['printable_name'];
		}

		return $countryList;
	}


	/* Function Header :saveResellerAccountDetails()
     *             Args: none
     *           Errors: none
     *     Return Value: none
     *      Description: Save details of reseller registration process
     */

    function saveResellerAccountDetails() {
        $privatekey = "6Ldv8r4SAAAAAOIpAG7IaDQryd7rDtzMKhCug1DO";
        $inoutObj = new inOut();
        $db = new db();
        $arrUser = array();
        $error = '';
        if ($_POST["recaptcha_response_field"]) {
            $resp = recaptcha_check_answer($privatekey,
                            $_SERVER["REMOTE_ADDR"],
                            $_POST["recaptcha_challenge_field"],
                            $_POST["recaptcha_response_field"]);

            if ($resp->is_valid) {

            } else {
                # set the error code so that we can display it
                $error.= ERROR_CAPTCHA; 
                $_SESSION['MESSAGE'] = $error;
                $_SESSION['post'] = $_POST;
                $url = BASE_URL . 'registrationResellerProcess.php';

                $inoutObj->reDirect($url);
                exit();
            }
        }

        //Request all form details
        $arrUser['email'] = $_POST['emailid'];
        $arrUser['passwd'] = $_POST['pwd'];
        $arrUser['fname'] = addslashes(trim($_POST['fname']));
        $arrUser['lname'] = addslashes(trim($_POST['lname']));
        $arrUser['role'] = "Reseller"; //addslashes(trim($_POST['role']));
        $arrUser['cprefix'] = $_POST['cprefix'];
        $arrUser['phone'] = trim($_POST['phone']);
        $arrUser['mobile_phone'] = trim($_POST['mob']);
        $arrUser['street_addr'] = addslashes(trim($_POST['street_addr']));
        $arrUser['city_addr'] = addslashes(trim($_POST['city_addr']));
        $arrUser['home_zip'] = addslashes(trim($_POST['home_zip']));
        $arrUser['country'] = $_POST['country'];
		$arrUser['social_number'] = addslashes(trim($_POST['social_number']));
		$arrUser['resellers_bank'] = addslashes(trim($_POST['resellers_bank']));
                 
		
				
		//retailer session
        $arrUser['retail'] = $_POST['$_SESSION["Retailers"]'];

        $error.= ( $arrUser['email'] == '') ? ERROR_EMAIL : '';

        $error.= ( $arrUser['passwd'] == '') ? ERROR_PASSWORD : '';

        $error.= ( $arrUser['fname'] == '') ? ERROR_FNAME : '';

        $error.= ( $arrUser['lname'] == '') ? ERROR_LNAME : '';

        $error.= ( $arrUser['phone'] == '' && $arrUser['mobile_phone'] == '') ? ERROR_PHONE_MOBILE : '';


       $error.= ( $arrUser['street_addr'] == '') ? ERROR_STREET : '';
       
	   $error.= ( $arrUser['city_addr'] == '') ? ERROR_CITY : '';
	   
	   $error.= ( $arrUser['home_zip'] == '') ? ERROR_ZIP : '';
	   
	   $error.= ( $arrUser['country'] == '') ? ERROR_COUNTRY : '';
	   
	   $error.= ( $arrUser['social_number'] == '') ? ERROR_SOCIAL_NUMBER : '';
	   
	   $error.= ( $arrUser['resellers_bank'] == '') ? ERROR_BANK_AC_NUMBER : '';
		
		
		
		if ($error != '') {
            $_SESSION['MESSAGE'] = $error;
            $_SESSION['post'] = $_POST;
            $url = BASE_URL . 'registrationResellerProcess.php';

            $inoutObj->reDirect($url);
            exit();
        } else {
            $_SESSION['post'] = "";
            $rowUniqueId = uuid();
            //$password_sha1 = sha1($arrUser['passwd']);

            $password_sha256 = $arrUser['passwd'];
           $password_hash = hash_hmac('sha256', $password_sha256, $rowUniqueId);
           $passwordHash = password_hash($password_sha256, PASSWORD_BCRYPT);
            
            $arrUser['email_varify_code'] = md5(time());
			
            $query = "INSERT INTO user(`u_id`, `email`, `passwd`, `password`, `fname`, `lname`, `role`, `phone`, `mobile_phone`,`email_varify_code`,`activ`,`street_addr`,`city_addr`,`home_zip`,`country`,`social_number`,`resellers_bank`)
                VALUES ('" . $rowUniqueId . "', '" . $arrUser['email'] . "', '" . $password_hash . "', '".$passwordHash."', '" . $arrUser['fname'] . "', '" . $arrUser['lname'] . "','" . $arrUser['role'] . "', '" . $arrUser['cprefix'] . $arrUser['phone'] . "', '" . $arrUser['cprefix'] . $arrUser['mobile_phone'] . "','" . $arrUser['email_varify_code'] . "','8','" . $arrUser['street_addr'] . "','" . $arrUser['city_addr'] . "','" . $arrUser['home_zip'] . "','" . $arrUser['country'] . "','" . $arrUser['social_number'] . "','" . $arrUser['resellers_bank'] . "');";
            $res = mysql_query($query) or die(mysql_error());

            if ($res) {
                $mailObj = new emails();
                $mailObj->sendResellerVarificationEmail($rowUniqueId, $arrUser['email_varify_code']);
                // These session variable bea ctive if user has been complete his mail varification

                $_SESSION['userid'] = $data['u_id'];
                $_SESSION['userrole'] = $data['role'];
                $_SESSION['username'] = $arrUser['fname'] . " " . $arrUser['lname'];
                $_SESSION['userid'] = $rowUniqueId;
                  
            }

            $_SESSION['MESSAGE'] = REGISTER_EMAIL_VARIFICATION;
            $_SESSION['REG_STEP'] = 8;
            $_SESSION['active_state'] =8;

            $url = BASE_URL . 'registrationResellerStep.php';
            $inoutObj->reDirect($url);
            exit();
        }
    }



	 function emailVarificationReseller($get) {

        $inoutObj = new inOut();
        $url_recieved = base64_decode($get['ucode']);
        $data = explode("&", $url_recieved);
        //print_r($data); 
		$uid = explode("=", $data[0]);
        $vcode = explode("=", $data[1]);
        $retailers = explode("=", $data[2]);
        $_SESSION["Retailers"] = $retailers[1];

        $query = "select * from user where u_id='" . $uid[1] . "'";
        $res = mysql_query($query) or die(mysql_error());
        $result = mysql_fetch_array($res);
		//echo $result['email_varify_code']." VCODE ".$vcode['0']; die();
        if ($result['email_varify_code'] == $vcode['1']) {
            $query = "UPDATE user SET email_varify_code='0', activ='1' where  u_id='" . $uid[1] . "'";
            $res = mysql_query($query) or die(mysql_error());

            $_SESSION['userid'] = $result['u_id'];
            $_SESSION['userrole'] = $result['role'];
            $_SESSION['username'] = $result['fname'] . " " . $result['lname'];
            $_SESSION['useremailid'] = $result['email'];

            $_SESSION['MESSAGE'] = SUCCESS_EMAIL_VALID;
            $_SESSION['REG_STEP'] = 1;
            $url = BASE_URL . 'registrationResellerStep.php'; // We have to change it for reseller.


            $inoutObj->reDirect($url);
        } else {
            $_SESSION['MESSAGE'] = VALID_MATCH_ERROR;
            $_SESSION['REG_STEP'] = 8;
            $url = BASE_URL . 'registrationResellerStep.php'; // We have to change it for reseller.
            $inoutObj->reDirect($url);
        }
    }


	 function isValidResellerRegistrationStep() {
        //print_r($_SERVER); //['PHP_SELF'];

        $page_name = explode("/", $_SERVER['PHP_SELF']);
		if(!empty($page_name[2]))
		{
			$script_name = $page_name[2]; // for local server.
		}
		else
		{
			$script_name = $page_name[1]; // for online server.
		}
		
		
        //echo "<br>";
		//print_r($page_name);
		//echo $page_name[2];
        //die();
        $offer = array();
        $offer[0] = "campaignOffer.php";
        $offer[1] = "standardOffer.php";
        $offer[2] = "resllerActivation.php";

        $store = array();
        $store[0] = "createStore.php";
        $store[1] = "resllerActivation.php";

        $inoutObj = new inOut();
        $db = new db();
        $inoutObj = new inOut();
		//echo "session".$_SESSION['REG_STEP']."--TTTT".$page_name[1]."TTT-----";
        if ((!$_SESSION['REG_STEP']) && ($script_name != "registrationResellerProcess.php")) {
            $url = BASE_URL . 'registrationResellerStep.php'; //die();
            $inoutObj->reDirect($url);
            exit;
        }
        //echo "case1"; die();
        if ($_SESSION['REG_STEP'] == 1 && ($script_name != "addCompany.php")) {
            $url = BASE_URL . 'registrationResellerStep.php?reg_step=1';
            $inoutObj->reDirect($url);
            exit;
        } else if ($_SESSION['REG_STEP'] == 2 && (!in_array($script_name, $offer))) {
            $url = BASE_URL . 'registrationResellerStep.php?reg_step=2';
            $inoutObj->reDirect($url);
            exit;
        } else if ($_SESSION['REG_STEP'] == 3 && (!in_array($script_name, $store))) {
            $url = BASE_URL . 'registrationResellerStep.php?reg_step=3';
            $inoutObj->reDirect($url);
            exit;
        } else if ($_SESSION['REG_STEP'] == 4 && (!in_array($script_name, $store))) {
            $url = BASE_URL . 'registrationResellerStep.php?reg_step=3';
            $inoutObj->reDirect($url);
            exit;
        } else if ($_SESSION['REG_STEP'] == 5 && ($script_name != "activation.php")) {
            $url = BASE_URL . 'registrationResellerStep.php?reg_step=5';
            $inoutObj->reDirect($url);
            exit;
        }else if ($_SESSION['REG_STEP'] == 8) {
            $_SESSION['MESSAGE']=EMAIL_VARIFICATION_CHECK;
            //$_SESSION['MESSAGE'] = "Please confirm your email varificvation";
			$url = BASE_URL . 'registrationResellerStep.php?reg_step=8';
            $inoutObj->reDirect($url);
            exit;
        }
        //echo "Last case"; die();
    }

    function getCcode()
    {
        $inoutObj = new inOut();
        $db = new db();

        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}
        $arrUser = array();
        $error = '';

        $query = "SELECT * FROM ccode WHERE activ = '1'";
        $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
         while($rs = mysqli_fetch_array($res)) {
        $data[] = $rs;
       
         }
         return $data;
    }

function putCcode($d)
    {
        $inoutObj = new inOut();
        $db = new db();

        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}
        $arrUser = array();
        $error = '';

        $query = "SELECT * FROM ccode WHERE ccode = '" . $d . "'";
        $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
        $rs = mysqli_fetch_array($res);
        $value = $rs['value'];

         return $value;
    }


    function checkTempValue()
    {
        $inoutObj = new inOut();
        $db = new db();
        $arrUser = array();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}
        $error = '';


        $query = "SELECT * FROM user WHERE u_id = '" . $_SESSION['userid'] . "'";
        $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
        $rs = mysqli_fetch_array($res);
        $tempValue = $rs['temp'];
        return $tempValue;

    }

    function SaveResellerId($resellerId,$ccodeId)
    {  //echo 'hereeeeeeeeeeeeeeeeee'; die();
        $inoutObj = new inOut();
       $db = new db();

        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}
        $arrUser = array();
        $error = '';

       
        $query = "SELECT * FROM ccode WHERE ccode = '" . $ccodeId . "'";
        $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
        $rs = mysqli_fetch_array($res);
        $ccValue = $rs['value'];

         $date = date('Y-m-d H:i:s');
         $query = "UPDATE company SET seller_id='" . $resellerId . "' , `seller_date` = '" . $date . "', `ccode` = '" . $ccodeId . "', `cc_value` = '" . $ccValue . "'  WHERE u_id = '" . $_SESSION['userid'] . "'";
         $res = mysqli_query($conn , $query) or die(mysqli_error($conn));

             $query = "UPDATE user SET temp='' WHERE u_id = '" . $_SESSION['userid'] . "'";
            $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
    }

    function getOwnerName($owner) {

        $inoutObj = new inOut();
        $db = new db();

        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}
        $arrUser = array();
        $error = '';


        $query = "SELECT * FROM user WHERE u_id = '" . $owner . "'";
        $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
        $rs = mysqli_fetch_array($res);
        $ownerName[] = $rs;
        return $ownerName;
      
    }


    function saveStripDetail($access_token,$stripe_publishable_key,$stripe_user_id,$refresh_token){
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}

        $uId = $_SESSION['userid'];

        // Get company and associated stripe customer detail
        $qry = "SELECT C.company_id, CSD.company_id AS csd_company_id FROM company AS C LEFT JOIN company_subscription_detail AS CSD ON C.company_id = CSD.company_id WHERE C.u_id = '{$uId}'";
        $res = mysqli_query($conn , $qry) or die(mysqli_error($conn));
        $company = mysqli_fetch_array($res);

        // If company exist then only insert/update stripe detail in table
        if($company)
        {
            if(!$company['csd_company_id'])
            {
                $query = "INSERT INTO company_subscription_detail(company_id, access_token, stripe_user_id, refresh_token, stripe_publishable_key) VALUES('{$company['company_id']}', '{$access_token}', '{$stripe_user_id}', '{$refresh_token}', '{$stripe_publishable_key}')";
            }
            else
            {
                $query = "UPDATE company_subscription_detail SET access_token = '{$access_token}', stripe_user_id = '{$stripe_user_id}', refresh_token = '{$refresh_token}', stripe_publishable_key = '{$stripe_publishable_key}' WHERE company_id = '{$company['company_id']}'";
            }

            $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
        }
        
        $inoutObj = new inOut();
        $_SESSION['MESSAGE'] = CREATE_STRIPACCOUNT_SUCCESS;

        $url = BASE_URL . 'addCompany.php';
        $inoutObj->reDirect($url);
    }

    function saveStripDetailEditCompany($access_token,$stripe_publishable_key,$stripe_user_id,$refresh_token){
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}

        $uId = $_SESSION['userid'];

        // Get company and associated stripe customer detail
        $qry = "SELECT C.company_id, CSD.company_id AS csd_company_id FROM company AS C LEFT JOIN company_subscription_detail AS CSD ON C.company_id = CSD.company_id WHERE C.u_id = '{$uId}'";
        $res = mysqli_query($conn , $qry) or die(mysqli_error($conn));
        $company = mysqli_fetch_array($res);

        // If company exist then only insert/update stripe detail in table
        if($company)
        {
            if(!$company['csd_company_id'])
            {
                $query = "INSERT INTO company_subscription_detail(company_id, access_token, stripe_user_id, refresh_token, stripe_publishable_key) VALUES('{$company['company_id']}', '{$access_token}', '{$stripe_user_id}', '{$refresh_token}', '{$stripe_publishable_key}')";
            }
            else
            {
                $query = "UPDATE company_subscription_detail SET access_token = '{$access_token}', stripe_user_id = '{$stripe_user_id}', refresh_token = '{$refresh_token}', stripe_publishable_key = '{$stripe_publishable_key}' WHERE company_id = '{$company['company_id']}'";
            }

            $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
        }
        
        $inoutObj = new inOut();
        $_SESSION['MESSAGE'] = CREATE_STRIPACCOUNT_SUCCESS;

        $url = BASE_URL . 'editCompany.php';
        $inoutObj->reDirect($url);
    }

    /**
     * [companyStripConnect description]
     * @param  [type] $access_token           [description]
     * @param  [type] $stripe_publishable_key [description]
     * @param  [type] $stripe_user_id         [description]
     * @param  [type] $refresh_token          [description]
     * @param  [type] $redirect_url           [description]
     * @return [type]                         [description]
     */
    function companyStripeConnect($access_token,$stripe_publishable_key,$stripe_user_id,$refresh_token,$redirect_url){
        $db = new db();
        $conn = $db->makeConnection();
        
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}

        $uId = $_SESSION['userid'];

        // Get company and associated stripe customer detail
        $qry = "SELECT C.company_id, CSD.company_id AS csd_company_id FROM company AS C LEFT JOIN company_subscription_detail AS CSD ON C.company_id = CSD.company_id WHERE C.u_id = '{$uId}'";
        $res = mysqli_query($conn , $qry) or die(mysqli_error($conn));
        $company = mysqli_fetch_assoc($res);

        // If company exist then only insert/update stripe detail in table
        if($company)
        {
            if(!$company['csd_company_id'])
            {
                $query = "INSERT INTO company_subscription_detail(company_id, access_token, stripe_user_id, refresh_token, stripe_publishable_key) VALUES('{$company['company_id']}', '{$access_token}', '{$stripe_user_id}', '{$refresh_token}', '{$stripe_publishable_key}')";
            }
            else
            {
                $query = "UPDATE company_subscription_detail SET access_token = '{$access_token}', stripe_user_id = '{$stripe_user_id}', refresh_token = '{$refresh_token}', stripe_publishable_key = '{$stripe_publishable_key}' WHERE company_id = '{$company['company_id']}'";
            }

            $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
        }

        $inoutObj = new inOut();
        // $_SESSION['MESSAGE'] = CREATE_STRIPACCOUNT_SUCCESS;
        $_SESSION['MESSAGE'] = CREATE_STORE_SUCCESS;

        $url = BASE_URL . $redirect_url;
        $inoutObj->reDirect($url);
    }
}
?>
