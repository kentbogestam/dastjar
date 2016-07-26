<?php
/*  File Name : emails.php
*  Description : This Scripts use to send mail.
*  Author  : Sushil Singh  Date: 20th,Jul,2010  Added Header
*/

class emails {

    /* Function Header :sendVarificationEmail()
*             Args: $emailId
*           Errors: none
*     Return Value: none
*      Description: To send a varification mail in the first step of registration procces
    */
    function sendVarificationEmail($uId, $email_varify_code) {

        $_SQL = "select * from user where u_id='".$uId."'";
        $res = mysql_query($_SQL) or die(mysql_error());
        $result = mysql_fetch_array($res);

        $varCode ="u_id=".$uId."&vc=".$email_varify_code."&rtlr=".$_SESSION["Retailers"];
        $link = BASE_URL."registrationAction.php?act=emailVar&ucode=".base64_encode($varCode); //die();
         $fMsg = "<a href=".$link.">".$link."</a>";
        $message= "Hi,<br>
               Please click on the following link or Copy and Paste in your browser to validate your e-mail address:<br>
              ".$fMsg."
          <br>
        Moblyo Team";
        
        $to =$result['email']; // Recipent email Id

        $headers  = "From: Moblyo Admin <admin@moblyo.com> \r\n"; // header of mail content
        $headers .= "Content-type: text/html\r\n";
        $subject = "Moblyo: Email varification"; // subject of mail

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
        
        $_SQL = "select email from user where u_id='".$uId."'";
        $res = mysql_query($_SQL) or die(mysql_error());
        $result = mysql_fetch_array($res);

        $to =$result['email']; // Recipent email Id

        $headers  = "From: Moblyo Admin<admin@cumbari.com> \r\n"; // header of mail content
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
         $_SQL = "select * from user where email='".$mail."'";
        $res = mysql_query($_SQL) or die(mysql_error());
        $result = mysql_fetch_array($res);
        $name = $result['fname'];

        $link = BASE_URL."changeForgotPassword.php?email=$mail";
        $fmsg = "<a href=".$link.">".$link."</a>";
        $message = "Hi,$name <br>
        Please click on the following link $fmsg "; 

        $to = $result['email'];

       $headers  = "From: Moblyo Admin<admin@cumbari.com> \r\n"; // header of mail content
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

        $_SQL = "select * from user where u_id='".$uId."'";
        $res = mysql_query($_SQL) or die(mysql_error());
        $result = mysql_fetch_array($res);

        $varCode ="u_id=".$uId."&vc=".$email_varify_code."&rtlr=".$_SESSION["Retailers"];
        $link = BASE_URL."registrationAction.php?act=emailVarReseller&ucode=".base64_encode($varCode); //die();
         $fMsg = "<a href=".$link.">".$link."</a>";
        $message= "Hi,<br>
               Please click on the following link or Copy and Paste in your browser to validate your e-mail address:<br>
              ".$fMsg."
          <br>
        Moblyo Team";
        
        $to =$result['email']; // Recipent email Id

        $headers  = "From: Moblyo Admin <admin@cumbari.com> \r\n"; // header of mail content
        $headers .= "Content-type: text/html\r\n";
        $subject = "Moblyo: Email varification"; // subject of mail

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
    $_SQL = "SELECT * FROM user_support";
    $res = mysql_query($_SQL) or die(mysql_error());
    $result = mysql_fetch_array($res);
    $to = $result['email'];

    $headers  = "From: Moblyo Admin<admin@cumbari.com> \r\n"; // header of mail content
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
    $_SQL = "SELECT * FROM user where u_id = '" . $uId . "'";
    $res = mysql_query($_SQL) or die(mysql_error());
    $result = mysql_fetch_array($res);
    $to = $result['email'];

    $headers  = "From: Moblyo Admin<admin@cumbari.com> \r\n"; // header of mail content
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
    $_SQL = "SELECT * FROM user where u_id = '" . $uId . "'";
    $res = mysql_query($_SQL) or die(mysql_error());
    $result = mysql_fetch_array($res);
    $to = $result['email'];

    $headers  = "From: Moblyo Admin<admin@cumbari.com> \r\n"; // header of mail content
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


}

?>
