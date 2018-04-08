<?php
/* File Name : feedback.php
 *  Description : Feedback class and functions
 *  Author  : Deo Date: 11th,Jan,2011
*/
class feedback {

    /* Function Header :svrRegDflt()
*             Args: none
*           Errors: none
*     Return Value: none
*      Description: User feedback default function
    */
    function svrRegDflt() {

        if(isset($_REQUEST['m']) && $_REQUEST['m']!='') {
            $mode=$_REQUEST['m'];
        }else {
            $mode='';
        }

        switch($mode) {

            case 'savefeedback':
                $this->saveFeedbackDetails();
                break;
        }
    }
    
    function saveFeedbackDetails() {
        //print_r($_POST); die();
        $inoutObj = new inOut();
        $db = new db();
        $arrUser = array();
        $error='';
        $arrUser['message'] = $_POST['message'];
        $arrUser['ccid'] = $_POST['ccid'];
        $arrUser['cos'] = $_POST['cos'];

// Add feedback details in the database
        $query = "INSERT INTO feedback_messages(client_id,client_os,message)
                VALUES ('".$arrUser['ccid']."','".$arrUser['cos']."', '".$arrUser['message']."');";
        $res = mysqli_query($query) or die(mysqli_error());

        $url = BASE_URL.'feedBackMessage.php';
        $inoutObj->reDirect($url);
        exit();
    }
}
?>
