<?php
//
include_once(dirname(__DIR__).'/cumbari.php');

error_reporting(-1);
ini_set('display_errors', 'On');

$db = new db();
$conn = $db->makeConnection();

if($conn)
{
	// Get user/company have the stripe detail
	$query = "SELECT U.id, U.u_id, C.company_id, U.stripe_customer_id, U.access_token, U.stripe_user_id, U.refresh_token, U.stripe_publishable_key FROM user U INNER JOIN company C ON U.u_id = C.u_id WHERE (U.stripe_customer_id != 'NULL' OR U.stripe_user_id != 'NULL') GROUP BY U.u_id ORDER BY U.id";
	$res = mysqli_query($conn , $query) or die(mysqli_error($conn));

	if( mysqli_num_rows($res) )
	{
		while($row = mysqli_fetch_array($res))
		{
			// Add/update if company already have the stripe detail entered 
			$q1 = "SELECT id FROM company_subscription_detail WHERE company_id = '{$row['company_id']}'";
			$r1 = mysqli_query($conn , $q1) or die(mysqli_error($conn));

			if(!mysqli_num_rows($r1))
			{
				$q2 = "INSERT INTO company_subscription_detail(company_id, stripe_customer_id, access_token, stripe_user_id, refresh_token, stripe_publishable_key) VALUES('{$row['company_id']}', '{$row['stripe_customer_id']}', '{$row['access_token']}', '{$row['stripe_user_id']}', '{$row['refresh_token']}', '{$row['stripe_publishable_key']}')";
			}
			else
			{
				$q2 = "UPDATE company_subscription_detail SET stripe_customer_id = '{$row['stripe_customer_id']}', access_token = '{$row['access_token']}', stripe_user_id = '{$row['stripe_user_id']}', refresh_token = '{$row['refresh_token']}', stripe_publishable_key = '{$row['stripe_publishable_key']}' WHERE company_id = '{$row['company_id']}'";
			}

			$r2 = mysqli_query($conn , $q2) or die(mysqli_error($conn));
		}
	}
}
?>