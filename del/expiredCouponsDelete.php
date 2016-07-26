<?php
include_once("classes/db.php");
require('config/dbConfig.php');

class cronJob {
		
		function expiredCouponsDeletion() {

			$db = new db();
			$db->makeConnection();
			
			$sql_c_s_rel = "SELECT * FROM c_s_rel WHERE end_of_publishing < CURDATE() AND coupon_id <>''";
			$res_c_s_rel = mysql_query($sql_c_s_rel) or die("Err-1000".mysql_error());

			while($row_c_s_rel = mysql_fetch_array($res_c_s_rel)) {

					$campaignId = "";
					$productId = "";
					$advertiseId = "";
					$storeId = "";
					$couponId = "";
					
					$campaignId = $row_c_s_rel['campaign_id'];
					$productId = $row_c_s_rel['product_id']; 
					$advertiseId = $row_c_s_rel['advertise_id'];
					$storeId = $row_c_s_rel['store_id'];
					$couponId = $row_c_s_rel['coupon_id'];


					if (strlen($campaignId)>0 || strlen($productId)>0 || strlen($advertiseId)>0) {

						$sql_DelCoupon = "DELETE FROM coupon WHERE coupon_id = '" . $couponId . "'";
						mysql_query($sql_DelCoupon) or die("Err-1001".mysql_error());
						
												
						$sql_DelTittle_lang_list = "DELETE FROM coupon_offer_title_lang_list WHERE coupon = '" . $couponId . "'";
						mysql_query($sql_DelTittle_lang_list) or die("Err-1002".mysql_error());

						$sql_DelKeyword_lang_list = "DELETE FROM coupon_keywords_lang_list WHERE coupon = '" . $couponId . "'";
						mysql_query($sql_DelKeyword_lang_list) or die("Err-1003".mysql_error());

						
						if (strlen($campaignId)>0){
							$sql_DelPeriod_list = "DELETE FROM coupon_limit_period_list WHERE coupon = '" . $couponId . "'";
							mysql_query($sql_DelPeriod_list) or die("Err-1004".mysql_error());
						}

						if (strlen($productId)>0){

							$delID = "";

							$sql_Slogan_lang_list = "SELECT offer_slogan_lang_list FROM coupon_offer_slogan_lang_list WHERE coupon = '" . $couponId . "'";
							$res_Slogan_lang_list = mysql_query($sql_Slogan_lang_list) or die("Err-1005".mysql_error());

							$row_Slogan_lang_list = mysql_fetch_array($res_Slogan_lang_list);
							$delID = $row_Slogan_lang_list['offer_slogan_lang_list'];

							if (strlen($delID)>0)
							{
								$sql_DelLang_text = "DELETE FROM lang_text WHERE id = '" . $delID . "'";
								mysql_query($sql_DelLang_text) or die("Err-1006".mysql_error());
							}
						}

						$sql_DelSlogan_lang_list = "DELETE FROM coupon_offer_slogan_lang_list WHERE coupon = '" . $couponId . "'";
						mysql_query($sql_DelSlogan_lang_list) or die("Err-1007".mysql_error());

						if (strlen($campaignId)>0)
							$sql_UptC_s_rel = "update c_s_rel SET `activ`='2' WHERE coupon_id='".$couponId."' AND campaign_id='".$campaignId."' AND store_id='" . $storeId . "'";
						elseif (strlen($productId)>0)
							$sql_UptC_s_rel = "update c_s_rel SET `activ`='2' WHERE coupon_id='".$couponId."' AND product_id='".$productId."' AND store_id='" . $storeId . "'";
						else
							$sql_UptC_s_rel = "update c_s_rel SET `activ`='2' WHERE coupon_id='".$couponId."' AND advertise_id='".$advertiseId."' AND store_id='" . $storeId . "'";
						
						mysql_query($sql_UptC_s_rel) or die("Err-1008".mysql_error());
					}
			}
		}
}

 $cronJobObj = new cronJob();
 $cronJobObj->expiredCouponsDeletion();
echo("success");
?>
