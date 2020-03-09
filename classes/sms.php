<?php
/*  File Name : emails.php
*  Description : This Scripts use to send mail.
*  Author  : Sushil Singh  Date: 20th,Jul,2010  Added Header
*/

class sms {

    /* Function Header :sendVarificationEmail()
*             Args: $emailId
*           Errors: none
*     Return Value: none
*      Description: To send a varification mail in the first step of registration procces
    */
    function sendVarificationSms($uId, $email_varify_code,$recipients) {

        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        
        $_SQL = "select * from user where u_id='".$uId."'";

        $res = mysqli_query($conn, $_SQL);

        if ($res) {
            //echo "Get data successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        //$res = mysql_query($_SQL) or die(mysql_error());
        //print $res;
        while ($row = mysqli_fetch_array($res))
            $result = $row['email'];
            //$result = mysql_fetch_array($res);


        mysqli_close($conn);
        $message="Your Dastjar verification code is ".$email_varify_code;       
        $to =$result; 
        $subject = "Dastjar: Email varification"; // subject of mail
        $this->apiSendTextMessage($recipients , $message );//Send sms
        //print_r($ok); die();
        // if($ok) {
        //     return 'sucess' ; // Sucessfull Insertion.
        // }
        // else {
        //     return 'email_error'; //Error in  sending mail.
        // }

    }


    //send sms api
    public  function apiSendTextMessage($recipients = array(), $message = '')
    {
        if( !is_array($recipients) && empty($recipients) )
        {
            return false;
        }

        //
        $url = "https://gatewayapi.com/rest/mtsms";
        $api_token = "BP4nmP86TGS102YYUxMrD_h8bL1Q2KilCzw0frq8TsOx4IsyxKmHuTY9zZaU17dL";
        
        $json = [
            'sender' => 'Dastjar',
            'message' => ''.$message.'',
            'recipients' => [],
        ];

        foreach ($recipients as $msisdn)
        {
            $json['recipients'][] = ['msisdn' => $msisdn];
        }

        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
        curl_setopt($ch,CURLOPT_USERPWD, $api_token.":");
        curl_setopt($ch,CURLOPT_POSTFIELDS, json_encode($json));
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
    /* Function Header :sendEmailRetailers()
*             Args: $emailId
*           Errors: none
*     Return Value: none
*      Description: To send a email to the retailers.
    */
    function sendEmailRetailers($uId, $emails, $messages='') {
        //echo $emails; exit;
       //echo $uId; exit;
        //echo $emails;
        $db = new db();

        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}
        
        $_SQL = "select email from user where u_id='".$uId."'";
        $res = mysqli_query($conn , $_SQL) or die(mysqli_error($conn));
        $result = mysqli_fetch_array($res);

        $to =$result['email']; // Recipent email Id

        $headers  = "From: Dastjar Admin<admin@dastjar.com> \r\n"; // header of mail content
        $headers .= "Content-type: text/html\r\n";
        $subject = "Invitation To Retailers"; // subject of mail
       $message =$messages;
        //echo $headers;
        $ok = mail($emails,$subject,$message,$headers);//Send mail

        if($ok) {
            return 'sucess' ;
            // Sucessfull Insertion.
        }
        else {
            //echo 'helloooooo';
            return 'email_error'; //Error in  sending mail.
        }

    }

    function forgetPasswordEmail($mail)
    {
         $db = new db();

        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}

         $_SQL = "select * from user where email='".$mail."'";
        $res = mysqli_query($conn , $_SQL) or die(mysqli_error($conn));
        $result = mysqli_fetch_array($res);
        $name = $result['fname'];

        $link = BASE_URL."changeForgotPassword.php?email=$mail";
        $fmsg = "<a href=".$link.">".$link."</a>";
        $message = "Hi,$name <br>
        Please click on the following link $fmsg "; 

        $to = $result['email'];

       $headers  = "From: Dastjar Admin<admin@dastjar.com> \r\n"; // header of mail content
        $headers .= "Content-type: text/html\r\n";
        $subject = "Change Password"; //

        $ok = mail($to,$subject,$message,$headers);
           if($ok) {
            return 'sucess' ; // Sucessfull Insertion.
        }
        else {
            return 'email_error'; //Error in  sending mail.
        }

    }



     function sendResellerVarificationEmail($uId, $email_varify_code) {
         $db = new db();

        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}

        $_SQL = "select * from user where u_id='".$uId."'";
        $res = mysqli_query($conn , $_SQL) or die(mysqli_error($conn));
        $result = mysqli_fetch_array($res);

        $varCode ="u_id=".$uId."&vc=".$email_varify_code."&rtlr=".$_SESSION["Retailers"];
        $link = BASE_URL."registrationAction.php?act=emailVarReseller&ucode=".base64_encode($varCode); //die();
         $fMsg = "<a href=".$link.">".$link."</a>";
        $message= "Hi,<br>
               Please click on the following link or Copy and Paste in your browser to validate your e-mail address:<br>
              ".$fMsg."
          <br>
        Dastjar Team";
        
        $to =$result['email']; // Recipent email Id

        $headers  = "From: Dastjar Admin <admin@dastjar.com> \r\n"; // header of mail content
        $headers .= "Content-type: text/html\r\n";
        $subject = "Dastjar: Email varification"; // subject of mail

        $message =$message;
        $ok = mail($to,$subject,$message,$headers);//Send mail
        //echo "mail".$ok; die();
        if($ok) {
            return 'sucess' ; // Sucessfull Insertion.
        }
        else {
            return 'email_error'; //Error in  sending mail.
        }

    }

function sendCategoryAdminMail($category)
{
    $db = new db();

    $conn = $db->makeConnection();
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }else{}

    $_SQL = "SELECT * FROM user_support";
    $res = mysqli_query($conn , $_SQL) or die(mysqli_error($conn));
    $result = mysql_fetch_array($res);
    $to = $result['email'];

    $headers  = "From: Dastjar Admin<admin@dastjar.com> \r\n"; // header of mail content
    $headers .= "Content-type: text/html\r\n";
    $subject = "CATEGORY"; // subject of mail
   $messages = "We Found New Category on adv. i.e. ".$category;
       $message =$messages;
        //echo $headers;
        $ok = mail($to,$subject,$message,$headers);//Send mail

        if($ok) {
            return 'sucess' ;
            // Sucessfull Insertion.
        }
        else {
            //echo 'helloooooo';
            return 'email_error'; //Error in  sending mail.
        }
}

function sendLessPreloadedValueMail($uId)
{
    $db = new db();

    $conn = $db->makeConnection();
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }else{}
    $_SQL = "SELECT * FROM user where u_id = '" . $uId . "'";
    $res = mysqli_query($conn , $_SQL) or die(mysqli_error($conn));
    $result = mysqli_fetch_array($res);
    $to = $result['email'];

    $headers  = "From: Dastjar Admin<admin@dastjar.com> \r\n"; // header of mail content
    $headers .= "Content-type: text/html\r\n";
    $subject = "PRE LOADED VALUE"; // subject of mail
   $messages = "We Have Deactivate Your account due to less balance";
       $message =$messages;
        //echo $headers;
        $ok = mail($to,$subject,$message,$headers);//Send mail

        if($ok) {
            return 'sucess' ;
            // Sucessfull Insertion.
        }
        else {
            //echo 'helloooooo';
            return 'email_error'; //Error in  sending mail.
        }
}

function sendDeactivateCampaignPreloadedMail($uId)
{
    $db = new db();

    $conn = $db->makeConnection();
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }else{}

    $_SQL = "SELECT * FROM user where u_id = '" . $uId . "'";
    $res = mysqli_query($conn , $_SQL) or die(mysqli_error($conn));
    $result = mysqli_fetch_array($res);
    $to = $result['email'];

    $headers  = "From: Dastjar Admin<admin@dastjar.com> \r\n"; // header of mail content
    $headers .= "Content-type: text/html\r\n";
    $subject = "PRE LOADED VALUE"; // subject of mail
   $messages = "Your Campaign are deactivate due to less balance";
       $message =$messages;
        //echo $headers;
        $ok = mail($to,$subject,$message,$headers);//Send mail

        if($ok) {
            return 'sucess' ;
            // Sucessfull Insertion.
        }
        else {
            //echo 'helloooooo';
            return 'email_error'; //Error in  sending mail.
        }
}

    /**
     * Send subscription thank-you email
     * @param  [type] $to       [description]
     * @param  [type] $template [description]
     */
    function sendSubscriptionThankYouEmail($to, $template)
    {
        // Send email
        $subject = 'Thank you for subscription!';

        $headers = "From: Dastjar Admin<admin@dastjar.com> \r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        mail($to, $subject, $template, $headers);
    }
}

?>
