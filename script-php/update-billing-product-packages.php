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
	$query = "SELECT id, package_id FROM billing_products WHERE package_id != 'NULL'";
	$res = mysqli_query($conn , $query) or die(mysqli_error($conn));

	if( mysqli_num_rows($res) )
	{
		while($row = mysqli_fetch_array($res))
		{
			// 
			$q1 = "SELECT id FROM billing_product_packages WHERE billing_product_id = '{$row['id']}' AND package_id = '{$row['package_id']}'";
			$r1 = mysqli_query($conn , $q1) or die(mysqli_error($conn));

			if(!mysqli_num_rows($r1))
			{
				$q2 = "INSERT INTO billing_product_packages(billing_product_id, package_id) VALUES('{$row['id']}', '{$row['package_id']}')";

				$r2 = mysqli_query($conn , $q2) or die(mysqli_error($conn));
			}
		}
	}
}
?>