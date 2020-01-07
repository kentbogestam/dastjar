<?
include_once("cumbari.php");

$subscriptionId = isset($_GET['subscriptionId']) ? $_GET['subscriptionId'] : null;

// Apply discount on subscription
if( !is_null($subscriptionId) )
{
	$billingObj = new billing();
	$billingObj->applyDiscountOnSubscription($subscriptionId);
}
?>