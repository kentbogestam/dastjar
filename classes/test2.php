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


    function stripePayment(){
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}

        $q = $db->query("SELECT * FROM store WHERE online_payment='1' AND  s_activ='1'");
        $q2 = $db->query("SELECT * FROM user WHERE stripe_user_id != null");

        while ($rs = mysqli_fetch_array($q)) {
           print_r($rs);
        }

        while ($rs2 = mysqli_fetch_array($q2)) {
            print_r($rs2);
        }
/*
        if($data[0]['online_payment'] == 1 && $data2[0]['stripe_user_id'] != null){
            return "Yes";
        }else{
            return "No";
        }
        */
    }




}
?>
