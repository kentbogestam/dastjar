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
	$query = "SELECT id, phone, mobile_phone FROM user WHERE 1";
	$res = mysqli_query($conn , $query) or die(mysqli_error($conn));

	if( mysqli_num_rows($res) )
	{
		while ($rs = mysqli_fetch_assoc($res)) {
			$phone = $mobile_phone = null;
			$prefix = 46;

			// 
			if( !empty($rs['phone']) && is_numeric($rs['phone']) )
			{
				$pre = substr($rs['phone'], 0, 2);

				if($pre == '91' || $pre == '46')
				{
					$prefix = $pre;
				}
			}
			elseif( !empty($rs['mobile_phone']) && is_numeric($rs['mobile_phone']) )
			{
				$pre = substr($rs['mobile_phone'], 0, 2);

				if($pre == '91' || $pre == '46')
				{
					$prefix = $pre;
				}
			}
			
			// 
			$phone = mix($rs['phone']);
			$mobile_phone = mix($rs['mobile_phone']);

			if(0)
			// if( is_null($phone) || is_null($mobile_phone) || is_null($prefix) )
			{
				echo 'Id: '.$rs['id'].'; Prefix: '.$prefix.', Phone: '.$phone.', Mobile: '.$mobile_phone.'<br>';
			}
			else
			{
				$phone = !empty($phone) ? "'$phone'" : "NULL";
				$mobile_phone = !empty($mobile_phone) ? "'$mobile_phone'" : "NULL";

				$query = "UPDATE user SET phone_prefix = '$prefix', phone = $phone, mobile_phone = $mobile_phone WHERE id = '{$rs['id']}'";
				// mysqli_query($conn , $query) or die(mysqli_error($conn));
				echo $query.'<br>';
			}
        }
	}
	else{
		echo 'No record found.';
	}
}

// 
function mix($str = null)
{
	if( !empty($str) && is_numeric($str) )
	{
		$pre = substr($str, 0, 2);

		if($pre == '91' || $pre == '46')
		{
			$str = substr($str, 2);
		}

		$str = ltrim($str, '0');
		$str = str_replace("-", "", $str);
		$str = str_replace(" ", "", $str);
	}

	return $str;
}
?>