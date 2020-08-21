<?php
class storeCampaign {
	// 
	function isCampaignValid($campaign_id = null)
	{
		$status = 0;

		if( !is_null($campaign_id) )
		{
			$db = new db();
			$conn = $db->makeConnection();
			
			// Check connection
			if (!$conn) {
				die("Connection failed: " . mysqli_connect_error());
			}

			// 
			$date = date('Y-m-d');
			$query = "SELECT id FROM store_campaign WHERE campaign_id = '{$campaign_id}' AND DATE(start_date) <= '{$date}' AND DATE(end_date) >= '{$date}'";
        	$res = mysqli_query($conn, $query);
        	$result = mysqli_fetch_array($res);

        	if(!empty($result))
        	{
        		$status = 1;
        	}
		}

		return $data = array('status' => $status);
	}

	// 
	function getCampaignProducts($campaign_id = null)
	{
		$db = new db();
		$conn = $db->makeConnection();
		
		// Check connection
		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}

		$campaignProducts = array();
		$query = "SELECT product_id FROM store_campaign SC INNER JOIN store_campaign_product SCP ON SC.id = SCP.campaign_id WHERE SC.campaign_id = '{$campaign_id}'";
    	$res = mysqli_query($conn, $query);

    	if($res->num_rows >= 1)
        {
            while ($rs = mysqli_fetch_assoc($res))
            {
                $campaignProducts[] = $rs['product_id'];
            }
        }
    	
    	return $campaignProducts;
	}
}
?>