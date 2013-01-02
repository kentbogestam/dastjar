<?php

/*  File Name : reportView.php
 *  Description :Report View class and functions.
 *  Author  :Himanshu Singh  Date: 10th,December,2010  Creation
 */
//$_SESSION['COMP_ID']="";
include('lib/resizer/resizer.php');

class reportView {
    /* Function Header :svrReportDflt()
     *             Args: none
     *           Errors: none
     *     Return Value: none
     *      Description: User Report View default function
     */

    function svrReportDflt() {

        switch ($mode) {
            default:
                return $this->getReportViewDetails();
                break;
        }
    }

    function getReportViewDetails() {
        $db = new db();
        $db->makeConnection();
        $data = array();
        $error = '';
        //echo $_SESSION['userid'];
        //die;
         $query0 = "SELECT coupon_usage_statistics.*,campaign.campaign_name,campaign.start_of_publishing  
						FROM coupon_usage_statistics
                        LEFT JOIN         coupon        ON    coupon_usage_statistics.coupon_id  = coupon.coupon_id
                        LEFT JOIN         c_s_rel       ON    c_s_rel.coupon_id  = coupon.coupon_id
                        LEFT JOIN         campaign      ON    c_s_rel.campaign_id = campaign.campaign_id  
                        WHERE campaign.u_id='" . $_SESSION['userid'] . "'";
						
		  $query = "SELECT sum(coupon_usage_statistics_history.num_consumes) num_consumes, sum(coupon_usage_statistics_history.num_views) num_views, 
						campaign.campaign_name,campaign.start_of_publishing 
						FROM campaign 
						LEFT JOIN c_s_rel on c_s_rel.campaign_id = campaign.campaign_id
						LEFT JOIN  coupon_usage_statistics_history ON coupon_usage_statistics_history.coupon_id  = c_s_rel.coupon_id
						LEFT JOIN  coupon ON    c_s_rel.coupon_id  = coupon.coupon_id 
                        WHERE   campaign.u_id='" . $_SESSION['userid'] . "' group by campaign.campaign_name";
						
						
						
 						

        $q = $db->query($query);
        while ($rs = mysql_fetch_array($q)) {
            $financeDetails[] = $rs;
        }

        return ($financeDetails);
    }

    function getReportStandardViewDetails() {
        $db = new db();
        $db->makeConnection();
        $data = array();
        $error = '';
        //echo $_SESSION['userid'];



         $query0 = "SELECT coupon_usage_statistics.*,product.product_name,product.start_of_publishing as published  FROM coupon_usage_statistics
                        LEFT JOIN         coupon                     ON    coupon_usage_statistics.coupon_id  = coupon.coupon_id
                         LEFT JOIN         c_s_rel                    ON    c_s_rel.coupon_id  = coupon.coupon_id
                        LEFT JOIN         product                    ON    c_s_rel.product_id = product.product_id
                        WHERE product.u_id='" . $_SESSION['userid'] . "'";
						
		 $query = "SELECT sum(coupon_usage_statistics.num_consumes) num_consumes, sum(coupon_usage_statistics.num_views) num_views, 
						product.product_name,product.is_public as published
						FROM product 
						LEFT JOIN c_s_rel on c_s_rel.product_id = product.product_id
						LEFT JOIN  coupon_usage_statistics ON coupon_usage_statistics.coupon_id  = c_s_rel.coupon_id
						LEFT JOIN  coupon ON    c_s_rel.coupon_id  = coupon.coupon_id 
                        WHERE product.u_id='" . $_SESSION['userid'] . "' group by product.product_name";
						
						
						
        $q = $db->query($query);
		
		if  ($db->numRows($q) > 0)
		{
			while ($rs = mysql_fetch_array($q)) {
			
			 if ($rs['product_name'] <> '')
				$financeDetails[] = $rs;
			}
			return $financeDetails;
		}
    }

    function getReportStoreViewDetails() {
        $db = new db();
        $db->makeConnection();
        $data = array();
        $error = '';
        //echo $_SESSION['userid'];

		$query0 = "SELECT distinct(coupon_usage_statistics.coupon_id), coupon_usage_statistics.*,store.*  FROM coupon_usage_statistics
					LEFT JOIN       coupon                     ON    coupon_usage_statistics.store_id  = coupon.store
					LEFT JOIN         store                    ON    store.store_id = coupon.store
					WHERE store.u_id='" . $_SESSION['userid'] . "'";
		
		
		 $query =	"SELECT sum(coupon_usage_statistics.num_consumes) num_consumes, sum(coupon_usage_statistics.num_views) num_views, store.* 
					FROM coupon_usage_statistics 
					LEFT JOIN  coupon ON coupon_usage_statistics.store_id  = coupon.store
					LEFT JOIN  store ON    store.store_id = coupon.store 
					WHERE store.u_id='" . $_SESSION['userid'] . "' group by store.store_id";


        $q = $db->query($query);
		if  ($db->numRows($q) > 0)
		{
			while ($rs = mysql_fetch_array($q)) {
				
			 if ($rs['store_name'] <> '')
				$financeDetails[] = $rs;
			}
			return $financeDetails;
		}
		
    }
//
//
//
//
//     function getReportsponserDetails() {
//        $db = new db();
//        $db->makeConnection();
//        $data = array();
//        $error = '';
//        //echo $_SESSION['userid'];
//
//
//
//        $query = "SELECT coupon_usage_statistics.store_id  FROM coupon_usage_statistics
//        LEFT JOIN       coupon                     ON    coupon_usage_statistics.store_id  = coupon .store_id
//        LEFT JOIN         store                    ON    store.store_id = coupon.store
//        WHERE store.u_id='" . $_SESSION['userid'] . "'";
//
//        $q = $db->query($query);
//        while ($rs = mysql_fetch_array($q)) {
//             $query = "SELECT  COUNT(coupon.is_sponsored) as sponcount   FROM coupon
//       LEFT JOIN         store                    ON    store.store_id = coupon.store
//        WHERE store.store_id='" . $rs . "'";
//        }
//      $res = mysql_query($query) or die(mysql_error());
//       $row = mysql_fetch_array($res);
//      $storeId = $row['store_id'];
//
//
//    echo "<pre>";
//    print_r($storeId);
//    echo "</pre>";
//    die();
//
//
//    }
}
