<?php

/* File Name : activate.php
 *  Description : Activation class and functions
 *  Author  : HImanshu Singh  Date: 4th,Dec,2010
 */

class activate {
    /* Function Header :svrActivateDefault()
     *             Args: none
     *           Errors: none
     *     Return Value: none
     *      Description: User Activate default function
     */

    function svrActivateDefault() {

        if (isset($_REQUEST['m']) && $_REQUEST['m'] != '') {
            $mode = $_REQUEST['m'];
        } else {
            $mode = '';
        }

        switch ($mode) {
            default:
                return $this->activationProcess();
                break;
        }
    }

    /* Function Header :activationProcess()
     *             Args: none
     *           Errors: none
     *     Return Value: none
     *      Description: To fetch data from Campaign for sponsored campaign.
     */

    function activationProcess() {

        $inoutObj = new inOut();
        $data = array();
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}
        //echo "Select * FROM campaign WHERE u_id='".$_SESSION['userid']."'";
       //echo $_SESSION['userid'];
        $res = $db->query("Select campaign.*,lang_text.text,keyw.text as keyword FROM campaign
            LEFT JOIN  category_names_lang_list ON  category_names_lang_list.category = campaign.category
         LEFT JOIN  lang_text ON  lang_text.id = category_names_lang_list.names_lang_list
         LEFT JOIN  campaign_offer_slogan_lang_list   ON  campaign_offer_slogan_lang_list.campaign_id = campaign.campaign_id
         LEFT JOIN  campaign_keyword   ON  campaign_keyword.campaign_id = campaign.campaign_id
         LEFT JOIN  lang_text as sloganT ON  campaign_offer_slogan_lang_list.offer_slogan_lang_list = sloganT.id
         LEFT JOIN  lang_text as keyw ON  campaign_keyword.offer_keyword = keyw.id

         WHERE u_id='" . $_SESSION['userid'] . "' AND sloganT.lang = lang_text.lang");
        $rs = mysqli_fetch_array($res);
        $data = $rs;

        if (mysqli_num_rows($res)) 
        {        
            $actArr['camp'] = 1;            
            $actArr['advt'] = 0;
            $actArr['prod'] = 0;
        } 
        else                                                                        
        {                                    
            $res = $db->query("Select advertise.*,lang_text.text,keyw.text as keyword FROM advertise
            LEFT JOIN  category_names_lang_list ON  category_names_lang_list.category = advertise.category
            LEFT JOIN  lang_text ON  lang_text.id = category_names_lang_list.names_lang_list
            LEFT JOIN  advertise_offer_slogan_lang_list   ON  advertise_offer_slogan_lang_list.advertise_id = advertise.advertise_id
            LEFT JOIN  advertise_keyword   ON  advertise_keyword.advertise_id = advertise.advertise_id
            LEFT JOIN  lang_text as sloganT ON  advertise_offer_slogan_lang_list.offer_slogan_lang_list = sloganT.id
            LEFT JOIN  lang_text as keyw ON  advertise_keyword.offer_keyword = keyw.id

            WHERE u_id='" . $_SESSION['userid'] . "' AND sloganT.lang = lang_text.lang");
           $rs = mysqli_fetch_array($res);
           $data = $rs;
             if (mysqli_num_rows($res)) {
                    $actArr['advt'] = 1;
                    $actArr['camp'] = 0;            
                    $actArr['prod'] = 0;
                    
                }
            else {
            //echo "Product";
            $query = ("SELECT product.*,lang_text.text as lang,sloganT.text,keyw.text as keyword FROM product
            LEFT JOIN  category_names_lang_list ON  category_names_lang_list.category = product.category
            LEFT JOIN  lang_text ON  lang_text.id = category_names_lang_list.names_lang_list
            LEFT JOIN   product_offer_slogan_lang_list  ON   product_offer_slogan_lang_list.product_id = product.product_id
            LEFT JOIN    lang_text as sloganT  ON   product_offer_slogan_lang_list.offer_slogan_lang_list  = sloganT.id
            LEFT JOIN   product_keyword  ON   product_keyword.product_id = product.product_id
            LEFT JOIN    lang_text as keyw  ON   product_keyword.offer_keyword  = keyw.id
           WHERE u_id='" . $_SESSION['userid'] . "' AND sloganT.lang = lang_text.lang");
            $resProd = mysqli_query($conn,$query) or die(mysql_error());
            $row = mysqli_fetch_array($resProd);
            //print_r($row);
            //die();
            if (mysqli_num_rows($resProd)) {
                $data = $row;
                $actArr['prod'] = 1;
            } else {
                $actArr['prod'] = 0;
            }

            //echo "here"; die();
            $actArr['camp'] = 0;
            $actArr['advt'] = 0;
        }
        }
        $data['act_camp'] = $actArr['camp'];
        $data['act_advt'] = $actArr['advt'];
        $data['act_prod'] = $actArr['prod'];
        return $data;
        exit();
    }

}
?>
