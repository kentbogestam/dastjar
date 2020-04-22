<?php
/*  File Name : emails.php
*  Description : This Scripts use to send mail.
*  Author  : Sushil Singh  Date: 20th,Jul,2010  Added Header
*/

use Aws\Ses\SesClient;
use Aws\Exception\AwsException;

class emails {

    /* Function Header :sendVarificationEmail()
*             Args: $emailId
*           Errors: none
*     Return Value: none
*      Description: To send a varification mail in the first step of registration procces
    */
    function sendVarificationEmail($uId, $email_varify_code) {

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

        $varCode ="u_id=".$uId."&vc=".$email_varify_code."&rtlr=".$_SESSION["Retailers"];
        $link = BASE_URL."registrationAction.php?act=emailVar&ucode=".base64_encode($varCode); //die();
         $fMsg = "<a href=".$link.">".$link."</a>";
        $message= "Hi,<br>
               Please click on the following link or Copy and Paste in your browser to validate your e-mail address:<br>
              ".$fMsg."
          <br>
        Dastjar Team";
        
        $to =$result; // Recipent email Id

        $headers  = "From: Dastjar Admin <admin@dastjar.com> \r\n"; // header of mail content
        $headers .= "Content-type: text/html\r\n";
        $subject = "Dastjar: Email varification"; // subject of mail

        $message =$message;
        // echo $to;
        // echo $subject;
        // echo $message;
        // echo $headers;
        // die();
        $ok = mail($to,$subject,$message,$headers);//Send mail
		//echo "mail".$ok; die();
        if($ok) {
            return 'sucess' ; // Sucessfull Insertion.
        }
        else {
            return 'email_error'; //Error in  sending mail.
        }

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

    // Send email thorugh AWS PHP SDK
    function awsSendEmail($to = array(), $subject = 'Test subject', $message = 'Test email')
    {
        if( is_array($to) !empty($to) )
        {
            $SesClient = new SesClient([
                'version' => '2010-12-01',
                'region'  => AWS_DEFAULT_REGION,
                // 'profile' => 'default',
                'credentials' => [
                    'key' => AWS_ACCESS_KEY_ID,
                    'secret' => AWS_SECRET_ACCESS_KEY
                ]
            ]);

            // This address must be verified with Amazon SES.
            $sender_email = 'admin@dastjar.com';
            
            $plaintext_body = 'This email was sent with Dastjar SES using the AWS SDK for PHP.';
            $char_set = 'UTF-8';

            try {
                $result = $SesClient->sendEmail([
                    'Destination' => [
                        'ToAddresses' => $to,
                    ],
                    'ReplyToAddresses' => [$sender_email],
                    'Source' => $sender_email,
                    'Message' => [
                      'Body' => [
                          'Html' => [
                              'Charset' => $char_set,
                              'Data' => $message,
                          ],
                          'Text' => [
                              'Charset' => $char_set,
                              'Data' => $plaintext_body,
                          ],
                      ],
                      'Subject' => [
                          'Charset' => $char_set,
                          'Data' => $subject,
                      ],
                    ],
                ]);

                return $result;
            } catch (AwsException $e) {
                // output error message if fails
                echo $e->getMessage();
                echo("The email was not sent. Error message: ".$e->getAwsErrorMessage()."\n");
                echo "\n";
            }
        }
    }
}
?>