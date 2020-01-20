<?
// include_once("cumbari.php");
require('config/dbConfig.php');
require('classes/db.php');
require('config/config.php');
require('classes/billing.php');

$db = new db();
$conn = $db->makeConnection();

if($conn)
{
	// Get all 'active' subscription
	$query = "SELECT UP.id, UP.subscription_id FROM user_plan UP INNER JOIN user_subscription_items USI ON UP.subscription_id = USI.subscription_id WHERE UP.status = '1' GROUP BY UP.subscription_id";
	$res = mysqli_query($conn , $query) or die(mysqli_error($conn));

	if( mysqli_num_rows($res) )
	{
		while ($rs = mysqli_fetch_assoc($res)) {
			$subscriptionId = $rs['subscription_id'];

			// Apply discount on subscription
            $billingObj = new billing();
			$billingObj->applyDiscountOnSubscription($subscriptionId);
        }
	}
}
?>