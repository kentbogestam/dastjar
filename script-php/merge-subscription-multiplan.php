<?php
//
include_once(dirname(__DIR__).'/cumbari.php');

error_reporting(-1);
ini_set('display_errors', 'On');

$db = new db();
$conn = $db->makeConnection();

if($conn)
{
	// Get billing_product_packages
	$query = "SELECT * FROM user_plan WHERE subscription_id IS NOT NULL AND subscription_id != '' AND plan_id IS NOT NULL AND status = '1' ORDER BY id";
	$res = mysqli_query($conn , $query) or die(mysqli_error($conn));

	if( mysqli_num_rows($res) )
	{
		while($row = mysqli_fetch_array($res))
		{
			// 
			$q1 = "SELECT id FROM user_subscription_items WHERE subscription_id = '{$row['subscription_id']}' AND plan_id = '{$row['plan_id']}'";
			$r1 = mysqli_query($conn , $q1) or die(mysqli_error($conn));

			if(!mysqli_num_rows($r1))
			{
				$q2 = "INSERT INTO user_subscription_items(subscription_id, plan_id) VALUES('{$row['subscription_id']}', '{$row['plan_id']}')";

				$r2 = mysqli_query($conn , $q2) or die(mysqli_error($conn));
			}
		}
	}
}
?>