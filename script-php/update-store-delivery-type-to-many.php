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
	$query = "SELECT store_id, delivery_type FROM store WHERE 1";
	$res = mysqli_query($conn , $query) or die(mysqli_error($conn));

	if( mysqli_num_rows($res) )
	{
		while($row = mysqli_fetch_array($res))
		{
			if($row['delivery_type'] == 0)
			{
				$delivery_type = array(1, 2);
			}
			else
			{
				$delivery_type = array($row['delivery_type']);
			}

			// if store already have added delivery type
			$q1 = "SELECT id FROM store_delivery_type WHERE store_id = '{$row['store_id']}'";
			$r1 = mysqli_query($conn , $q1) or die(mysqli_error($conn));

			if(!mysqli_num_rows($r1))
			{
				foreach($delivery_type as $rs)
				{
					$q2 = "INSERT INTO store_delivery_type(store_id, delivery_type) VALUES('{$row['store_id']}', '{$rs}')";
					mysqli_query($conn , $q2) or die(mysqli_error($conn));
					// echo $q2.'<br>';
				}
			}
		}
	}
}
?>