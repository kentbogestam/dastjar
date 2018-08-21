<?php

require_once('cumbari.php');

class test1
{
    
    function verifyUser()
    {
        if(isset($_GET['email'])){
            $db = new db();
            $conn = $db->makeConnection();
            // Check connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }else{}

            $inoutObj = new inOut();

            $query = "select * from user where email='" . $_GET['email'] . "'";
            $res = mysqli_query($conn, $query) or die(mysql_error());
            $result = mysqli_fetch_array($res);

                $query = "UPDATE user SET email_varify_code='0', activ='1' where email='" . $_GET['email'] . "'";
                $res = mysqli_query($conn ,$query) or die(mysql_error());

                $_SESSION['userid'] = $result['u_id'];
                $_SESSION['userrole'] = $result['role'];
                $_SESSION['username'] = $result['fname'] . " " . $result['lname'];
                $_SESSION['useremailid'] = $result['email'];

                $_SESSION['MESSAGE'] = SUCCESS_EMAIL_VALID;
                $_SESSION['REG_STEP'] = 1;

                unset($_SESSION['usersessionid']);
                unset($_SESSION['MAIL_URL']);
                unset($_SESSION['createStore']);
                unset($_SESSION['ccode']);
                unset($_SESSION['temp_campId']);
                unset($_SESSION['temp_ccode']);
                unset($_SESSION['temp_uId']);

                $url = BASE_URL . 'registrationStep.php';


                $inoutObj->reDirect($url);      
    }
}
}

$test1 = new test1();
$test1->verifyUser();

?>