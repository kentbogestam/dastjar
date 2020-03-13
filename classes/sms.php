<?php
/*  File Name : sms.php
*  Description : This Scripts use to send mail.
*/

class sms {

    /* Function Header :sendVarificationSms()
        Description: To send a varification sms in the first step of registration procces
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
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        while ($row = mysqli_fetch_array($res))
        $result = $row['email'];
        mysqli_close($conn);
        $message="Your Dastjar verification code is ".$email_varify_code;       
        $to =$result; 
        $this->apiSendTextMessage($recipients , $message );//Send sms

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
}

?>
