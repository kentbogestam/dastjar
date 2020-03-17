<?php
require(dirname(__DIR__).'/config/dbConfig.php');
require(dirname(__DIR__).'/classes/db.php');
require(dirname(__DIR__).'/config/config.php');

error_reporting(-1);
ini_set('display_errors', 'On');

$db = new db();
$conn = $db->makeConnection();

if($conn)
{
	// Get all user
	$query = "SELECT store_id, phone FROM store WHERE 1";
	$res = mysqli_query($conn , $query) or die(mysqli_error($conn));

	if( mysqli_num_rows($res) )
	{
		while ($rs = mysqli_fetch_assoc($res)) {
			$phone = null;
			$prefix = 46;

			// 
			if( !is_null($rs['phone']) && !empty($rs['phone']) && is_numeric($rs['phone']) )
			{
				$phone = $rs['phone'];
				$pre = substr($phone, 0, 2);

				if($pre == '91' || $pre == '46')
				{
					$prefix = $pre;
					$phone = substr($phone, 2);
				}

				$phone = ltrim($phone, '0');
				$phone = str_replace("-", "", $phone);
				$phone = str_replace(" ", "", $phone);
			}

			if(0)
			// if( is_null($phone) || is_null($mobile_phone) || is_null($prefix) )
			{
				echo 'Id: '.$rs['id'].'; Prefix: '.$prefix.', Phone: '.$phone.', Mobile: '.$mobile_phone.'<br>';
			}
			else
			{
				$phone = !empty($phone) ? "'$phone'" : "NULL";

				$query = "UPDATE store SET phone_prefix = '$prefix', phone = $phone WHERE store_id = '{$rs['store_id']}'";
				// mysqli_query($conn , $query) or die(mysqli_error($conn));
				echo $query.'<br>';
			}
        }
	}
	else{
		echo 'No record found.';
	}
}
?>