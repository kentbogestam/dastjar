<?php
/* File Name : db.php
 *  Description : Log in and log out class and related function
 *  Author  : Sushil Singh  Date: 15th,Nov,2010
*/
class inOut {

    /* Function Header :svrInOutDflt()
*             Args: none
*           Errors: none
*     Return Value: none
*      Description: User Login default function
    */
    function svrInOutDflt() {



        if(isset($_REQUEST['m']) && $_REQUEST['m']!='') {
            $mode=$_REQUEST['m'];
        }else {
            $mode='';
        }
        // echo "Hiiiiiiiiiiiiiii"; exit;

        switch($mode) {
            case 'in':
            //echo "here"; die();
                $this->usrLogin($_POST['username'],$_POST['password']);
                break;
             case 'inReseller':
            //echo "here"; die();
                $this->usrResellerLogin($_POST['username'],$_POST['password']);
                break;
            case 'out':
                $this->usrLogout();
                break;
//            default:
//                $this->usrLogin('','');

             case 'support_in':
            //echo "here"; die();
                $this->supportLogin($_POST['username'],$_POST['password']);
                break;
        }
    }

    /* Function Header :usrLogin()
*             Args: none
*           Errors: none
*     Return Value: none
*      Description: User Log In function
    */
    function usrLogin($username,$password,$userid='') {

       
		// Login by user.
		if(empty($userid))
		{
			if(($username=='')&&($password=='')) {
				$_SESSION['MESSAGE']=LOGIN_DETAIL;
				$url = BASE_URL.'login.php';
				$this->reDirect($url);
				exit();

			}

			if($username=='') {

				$_SESSION['MESSAGE']=LOGIN_EMAIL_BLANK;
				$url = BASE_URL.'login.php';
				$this->reDirect($url);
				exit();
			}
			if(($username!='')&&($password=='')) {

				$_SESSION['MESSAGE']=LOGIN_PASSWORD_BLANK;
				$url = BASE_URL.'login.php';
				$this->reDirect($url);
				exit();
			}
		}
        
		if(empty($userid))
		{
			$res =$this->dbSvrLogindChk($username,$password,'Store Admin');			
		}
		else
		{
			// Login by support user.
			$res =$this->getUserdById($userid);
		}

        if($res!=0) {
            $db = new db;
            //print_r($res); die("error:");
            $data = $db->fetchRow($res);
			session_regenerate_id();
            $_SESSION['userid'] = $data['u_id'];
            $_SESSION['active_state'] = $data['activ'];
            $_SESSION['userrole'] = $data['role'];
            $_SESSION['username'] = $data['fname']." ".$data['lname'];
            $_SESSION['useremail']= $data['email'];
			$_SESSION['usersessionid']=session_id();
            date_default_timezone_set (TIME_ZONE);

           /* Code to enter user login entry in user_activity table */

            $id = uuid();
            $session_id = session_id();
            $user_id    = $data['u_id'];
            $in_time = date('Y-m-d h:i:s');
            if(empty($userid))
			{
				$query = "insert into user_activity(id,user_id,session_id,in_time) values('$id','$user_id','$session_id','$in_time')";
			}
			else
			{
				$support_user_id = $_SESSION['supportuserid'];
				$query = "insert into user_activity(id,user_id,support_user_id,session_id,in_time) values('$id','$user_id','$support_user_id','$session_id','$in_time')";
			}
           // $db->makeConnection();
            $res= $db->query($query);


           /* End code for user_activity */

//// to check at which stage the user has completed registration process/////////
//            $query = "SELECT activ FROM user WHERE u_id =  '".$_SESSION['userid']."'";
//            $res = mysql_query($query) or die(mysql_error());
//            $row = mysql_fetch_array($res);
            //echo $row;
            if($_SESSION['active_state']==1) {
                $url = BASE_URL.'registrationStep.php?reg_step=1';
                $this->reDirect($url);
            }
            else if($_SESSION['active_state']==2) {
                $url = BASE_URL.'registrationStep.php?reg_step=2';
                $this->reDirect($url);
            }
            else if($_SESSION['active_state']==3) {
                $url = BASE_URL.'registrationStep.php?reg_step=3';
                $this->reDirect($url);
            }
            else if($_SESSION['active_state']==4) {
                $url = BASE_URL.'registrationStep.php?reg_step=5';
                $this->reDirect($url);
            }else if($_SESSION['active_state']==8) {
                $_SESSION['MESSAGE'] = EMAIL_VARIFICATION_CHECK;
                $url = BASE_URL.'registrationStep.php?reg_step=8';
                $this->reDirect($url);

            }

            else {
                if (isset($_SESSION['MAIL_URL'])) {

              
                    $url = $_SESSION['MAIL_URL'];
                    $_SESSION['MAIL_URL'] = "";
                    $this->reDirect($url);
                    exit();

                }
                else {
                    $url = BASE_URL.'showCampaign.php';
                    $this->reDirect($url);
                }
            }
            exit();
        }
        else {
            $_SESSION['MESSAGE']=INVALID_LOGIN;
            $url = BASE_URL.'login.php';
            header("location:".$url);
            $this->reDirect($url);
            exit();

        }

    }
	
	
	///////////for reseller login
	
	function usrResellerLogin($username,$password,$userid='') {

       
		// Login by user.
		if(empty($userid))
		{
			if(($username=='')&&($password=='')) {
				$_SESSION['MESSAGE']=LOGIN_DETAIL;
				$url = BASE_URL.'loginReseller.php';
				$this->reDirect($url);
				exit();

			}

			if($username=='') {

				$_SESSION['MESSAGE']=LOGIN_EMAIL_BLANK;
				$url = BASE_URL.'loginReseller.php';
				$this->reDirect($url);
				exit();
			}
			if(($username!='')&&($password=='')) {

				$_SESSION['MESSAGE']=LOGIN_PASSWORD_BLANK;
				$url = BASE_URL.'loginReseller.php';
				$this->reDirect($url);
				exit();
			}
		}
        
		if(empty($userid))
		{

			$res =$this->dbSvrLogindChk($username,$password,'Reseller');
		}
		else
		{
			// Login by support user.
			$res =$this->getUserdById($userid);
		}

        if($res!=0) {
            $db = new db;
            //print_r($res); die("error:");
            $data = $db->fetchRow($res);
			session_regenerate_id();
            $_SESSION['userid'] = $data['u_id'];
            $_SESSION['active_state'] = $data['activ'];
            $_SESSION['userrole'] = $data['role'];
            $_SESSION['username'] = $data['fname']." ".$data['lname'];
            $_SESSION['useremail']= $data['email'];
			$_SESSION['usersessionid']=session_id();
                         $_SESSION['ccode'] = $data['ccode'];
            date_default_timezone_set (TIME_ZONE);

           /* Code to enter user login entry in user_activity table */

            $id = uuid();
            $session_id = session_id();
            $user_id    = $data['u_id'];
            $in_time = date('Y-m-d h:i:s');
            if(empty($userid))
			{
				$query = "insert into user_activity(id,user_id,session_id,in_time) values('$id','$user_id','$session_id','$in_time')";
			}
			else
			{
				$support_user_id = $_SESSION['supportuserid'];
				$query = "insert into user_activity(id,user_id,support_user_id,session_id,in_time) values('$id','$user_id','$support_user_id','$session_id','$in_time')";
			}
           // $db->makeConnection();
            $res= $db->query($query);


           /* End code for user_activity */

//// to check at which stage the user has completed registration process/////////
//            $query = "SELECT activ FROM user WHERE u_id =  '".$_SESSION['userid']."'";
//            $res = mysql_query($query) or die(mysql_error());
//            $row = mysql_fetch_array($res);
            //echo $row;
            if($_SESSION['active_state']==1) {
                $url = BASE_URL.'registrationResellerStep.php?reg_step=1';
                $this->reDirect($url);
            }
            else if($_SESSION['active_state']==2) {
                $url = BASE_URL.'registrationResellerStep.php?reg_step=2';
                $this->reDirect($url);
            }
            else if($_SESSION['active_state']==3) {
                $url = BASE_URL.'registrationResellerStep.php?reg_step=3';
                $this->reDirect($url);
            }
            else if($_SESSION['active_state']==4) {
                $url = BASE_URL.'registrationResellerStep.php?reg_step=5';
                $this->reDirect($url);
            }else if($_SESSION['active_state']==8) {
                $_SESSION['MESSAGE'] = EMAIL_VARIFICATION_CHECK;
                $url = BASE_URL.'registrationResellerStep.php?reg_step=8';
                $this->reDirect($url);

            }

            else {
                if (isset($_SESSION['MAIL_URL'])) {

               
                    $url = $_SESSION['MAIL_URL'];
                    $_SESSION['MAIL_URL'] = "";
                    $this->reDirect($url);
                    exit();

                }
                else {
                    $url = BASE_URL.'showResellerCampaign.php';
                    $this->reDirect($url);
                }
            }
            exit();
        }
        else {
            $_SESSION['MESSAGE']=INVALID_LOGIN;
            $url = BASE_URL.'loginReseller.php';
            header("location:".$url);
            $this->reDirect($url);
            exit();

        }

    }


    /* Function Header :dbSvrLogindChk()
*             Args: none
*           Errors: none
*     Return Value: none
*      Description: Check login credentials
    */
    function dbSvrLogindChk($username, $password,$role) {
        $data = array();
        $db = new db;
        $db->makeConnection();
        // To protect MySQL injection
        $username = stripslashes($username);
        $password = stripslashes($password);
        $username = mysql_real_escape_string($username);
        $password = mysql_real_escape_string($password);

        $query = "select * from user where email = '".$username."'";
         $res= $db->query($query);
         $rs = mysql_fetch_array($res);
         $uId = $rs['u_id'];
         
        $password_sha256 = $password;
        $password_hash = hash_hmac('sha256', $password_sha256, $uId);
        ##$query = "select * from user where email = '".$username."' and passwd = '".$password_hash."' and role = '" . $role . "'";
        $query = "select * from user where email = '".$username."' and role = '" . $role . "'";
  		
        $res= $db->query($query);
        $count = $db->numRows($res);

        if($count) {
            return $res;
        }
        else {
            return $count;
        }


    }

	    /* Function Header :dbSvrLogindChk()
*             Args: none
*           Errors: none
*     Return Value: none
*      Description: Check login credentials
    */
    function getUserdById($userid) {
        $data = array();
        // To protect MySQL injection
        //$username = stripslashes($username);
        //$password = stripslashes($password);
       // $username = mysql_real_escape_string($username);
       // $password = mysql_real_escape_string($password);

        //$password_sha1 = sha1($password);
        $query = "select * from user where u_id = '".$userid."'";
        $db = new db;
        $db->makeConnection();
        $res= $db->query($query);
        $count = $db->numRows($res);

        if($count) {
            return $res;
        }
        else {
            return $count;
        }


    }

    /* Function Header :usrLogout()
*             Args: none
*           Errors: none
*     Return Value: none
*      Description: User LogOut Function
    */
    function usrLogout() {


        /* Code to enter user logout entry in user_activity table */

        $db = new db;
        //$session_id = session_id();
        $session_id = $_SESSION['usersessionid'];
        $user_id    = $_SESSION['userid'];
        $out_time = date('Y-m-d h:i:s');
        $query = "update user_activity set out_time = '$out_time' where user_id = '$user_id' and session_id = '$session_id'";
        $res= $db->query($query);

        /* End code */

        //session_regenerate_id();
        //session_unset();
        //session_destroy();

		unset($_SESSION['userid']);
		unset($_SESSION['active_state']);
		unset($_SESSION['userrole']);
		unset($_SESSION['username']);
		unset($_SESSION['useremail']);
		unset($_SESSION['usersessionid']);
		unset($_SESSION['REG_STEP']);
		unset($_SESSION['MAIL_URL']);
		unset($_SESSION['createStore']);
        unset($_SESSION['ccode']);
        //unset($_SESSION['temp_campId']);
        //unset($_SESSION['temp_ccode']);
        //unset($_SESSION['temp_uId']);
      
        $_SESSION['MESSAGE']=LOGOUT_MESSAGE;
        $url = BASE_URL.'index.php';
        $this->reDirect($url);


    }

       /* Function Header :supportLogout()
*             Args: none
*           Errors: none
*     Return Value: none
*      Description: Support User LogOut Function
    */
    function supportLogout() {


        /* Code to enter user logout entry in user_activity table */

        $db = new db;
        //$session_id = session_id();
        $session_id = $_SESSION['supportsessionid'];
        $user_id    = $_SESSION['supportuserid'];
        $out_time	= date('Y-m-d h:i:s');
        $query		= "update user_activity set out_time = '$out_time' where user_id = '$user_id' and session_id = '$session_id'";
        $res= $db->query($query);

        /* End code */

        // session_regenerate_id();
        //session_unset();
        //session_destroy();
		
		unset($_SESSION['supportuserid']);
		unset($_SESSION['supportusername']);
		unset($_SESSION['supportuseremail']);
		unset($_SESSION['supportsessionid']);

        $_SESSION['MESSAGE']=LOGOUT_MESSAGE;
        $url = BASE_URL.'support.php';
        $this->reDirect($url);


    }

    /* Function Header :reDirect()
*             Args: none
*           Errors: none
*     Return Value: none
*      Description: redirect url
    */
    function reDirect($url) {
        echo '<meta http-equiv="refresh" content="0;url='.$url.'">';
        //header("Location:".$url);
    }

    function reDirectUrl($url) {
        header("location:".$url);
    }

    function jsRedirect($url) { //echo "asdsadsa".$url;
        ?>
<script type="text/javascript">

    window.location.href="<?=$url?>";

</script>
        <?php
    }

    function validSteps() {
        if (isset($_SESSION[userid]) && $_SESSION['active_state']==5) {
        }

        else {
            $url = BASE_URL.'login.php';
            $this->reDirect($url);
            exit();
        }


    }
//
//    function date_time() {
//        date_default_timezone_set('America/Los_Angeles');
//
//        $script_tz = date_default_timezone_get();
//
//        if (strcmp($script_tz, ini_get('date.timezone'))) {
//            echo 'Script timezone differs from ini-set timezone.';
//        } else {
//            echo 'Script timezone and ini-set timezone match.';
//        }
//    }

     /* Function Header :supportLogin()
*             Args: two
*           Errors: none
*     Return Value: none
*      Description: Support User Log In function
    */
    function supportLogin($username,$password) {

        if(($username=='')&&($password=='')) {
            $_SESSION['MESSAGE']=LOGIN_DETAIL;
            $url = BASE_URL.'support.php';
            $this->reDirect($url);
            exit();

        }

        if($username=='') {

            $_SESSION['MESSAGE']=LOGIN_EMAIL_BLANK;
            $url = BASE_URL.'support.php';
            $this->reDirect($url);
            exit();
        }
        if(($username!='')&&($password=='')) {

            $_SESSION['MESSAGE']=LOGIN_PASSWORD_BLANK;
            $url = BASE_URL.'support.php';
            $this->reDirect($url);
            exit();
        }

        $res =$this->dbSupportLogindChk($username,$password);

        if($res!=0) {
            $db = new db;
            //print_r($res); die("error:");
            $data = $db->fetchRow($res);
            session_regenerate_id();
            $_SESSION['supportuserid'] =   $data['u_id'];
            $_SESSION['supportusername'] = $data['fname']." ".$data['lname'];
            $_SESSION['supportuseremail']= $data['email'];
			$_SESSION['supportsessionid']= session_id();
            date_default_timezone_set (TIME_ZONE);

           /* Code to enter user login entry in user_activity table */

            $id = uuid();
            $session_id = session_id();
            $user_id    = $data['u_id'];
            $in_time = date('Y-m-d h:i:s');
            $query = "insert into user_activity(id,user_id,session_id,in_time,user_type) values('$id','$user_id','$session_id','$in_time','1')";
           // $db->makeConnection();
            $res= $db->query($query);


           /* End code for user_activity */

             $url = BASE_URL.'userActivity.php';
             $this->reDirect($url);

                  
        }
        else {
            $_SESSION['MESSAGE']=INVALID_LOGIN;
            $url = BASE_URL.'support.php';
            header("location:".$url);
            $this->reDirect($url);
            exit();

        }

    }

      /* Function Header :dbSupportLogindChk()
*             Args: none
*           Errors: none
*     Return Value: none
*      Description: Check support login credentials
    */
    function dbSupportLogindChk($username, $password) {
        $data = array();
        $db = new db;
        $db->makeConnection();
        // To protect MySQL injection
        $username = stripslashes($username);
        $password = stripslashes($password);
        $username = mysql_real_escape_string($username);
        $password = mysql_real_escape_string($password);

        $query = "select * from user_support where email = '".$username."'";
         $res= $db->query($query);
         $rs = mysql_fetch_array($res);
         $uId = $rs['u_id'];

        $password_sha256 = $password;
        $password_hash = hash_hmac('sha256', $password_sha256, $uId);
        
        $query = "select * from user_support where email = '".$username."' and passwd = '".$password_hash."'";
        
        $res= $db->query($query);
        $count = $db->numRows($res);

        if($count) {
            return $res;
        }
        else {
            return $count;
        }


    }

	 /* Function Header :showUserActivities()
*             Args: none
*           Errors: none
*     Return Value: none
*      Description: Check support login credentials
    */
    function showUserActivities($userid) {
        $data = array();
		$db = new db;
        $db->makeConnection();
        $query = "select user_activity.*,concat(user.fname,' ',user.lname) as username,user.email as useremail,user_support.email as supportemail,concat(user_support.fname,' ',user_support.lname) as supportusername from user_activity left join user on user_activity.user_id = user.u_id left join user_support on user_activity.support_user_id = user_support.u_id  where user_id = "."'".$userid."'"." order by in_time desc";
        $res= $db->query($query);

		 while ($rs = mysql_fetch_array($res)) {
            $data[] = $rs;
        }
        
		//echo "<pre>";print_r($data);exit;
		return $data;
		
    }



    function forgetPassword()
    {
       
         $db = new db;
        $arrUser = array();
        $error = '';

        $arrUser['email'] = $_POST['email'];
        $query = "select * from user where email = '". $arrUser['email']."'";
        $res = mysql_query($query) or die(mysql_error());
        $rs = mysql_fetch_array($res);
       $mail = $rs['email'];
        if($mail != '')
            {
          $mailObj = new emails();
          $mailObj->forgetPasswordEmail($mail);
         $_SESSION['MESSAGE'] = CHECK_MAIL;
         $url = BASE_URL.'forgotPassword.php';
         $this->reDirect($url);
          exit();
        }

        $_SESSION['MESSAGE'] = WRONG_MAILID;
         $url = BASE_URL.'forgotPassword.php';
         $this->reDirect($url);
          exit();

     }


      function saveChangeForgotPassword($email) {
   
        $inoutObj = new inOut();
        $db = new db();
        $arrUser = array();
        $error = '';

        $arrUser['passwd'] = $_POST['pwd'];

        $query = "select * from user where email = '".$email."'";
         $res= $db->query($query);
         $rs = mysql_fetch_array($res);
         $uId = $rs['u_id'];

            $password_sha256 = $arrUser['passwd'];
           $password_hash = hash_hmac('sha256', $password_sha256, $uId);

        $QUE = "UPDATE user SET passwd = '" . $password_hash . "' WHERE email = '" . $email . "'";
        $res = mysql_query($QUE) or die("Get Company : " . mysql_error());
        
            $_SESSION['MESSAGE'] = NOW_LOGIN;
            $url = BASE_URL . 'login.php';
            $inoutObj->reDirect($url);
            exit();

        }

    }

?>