<?
// include_once("cumbari.php");
require('config/dbConfig.php');
require('classes/db.php');
require('config/config.php');
// require('classes/billing.php');
require_once('/var/www/html/vendor/autoload.php');
// require_once('vendor/autoload.php');

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

/**
 * 
 */
class Billing
{
	// Apply discount/coupon on subscription
    function applyDiscountOnSubscription($subscriptionId = null)
    {
        $db = new db();
        $db->makeConnection();

        if($subscriptionId != null)
        {
        	\Stripe\Stripe::setApiKey(STRPIE_CLIENT_SECRET);

            $date = date('Y-m-d 00:00:00');
            $discountTotal = 0;

            // Select plan having trial periods on
            // $query = "SELECT price FROM billing_products BP INNER JOIN user_subscription_items USI ON BP.plan_id = USI.plan_id WHERE BP.trial_period != 0 AND USI.subscription_id = '{$subscriptionId}' AND USI.coupon_trial_from <= '{$date}' AND USI.coupon_trial_to >= '{$date}'";
            $query = "SELECT price FROM billing_products BP INNER JOIN user_subscription_items USI ON BP.plan_id = USI.plan_id WHERE BP.trial_period != 0 AND USI.subscription_id = '{$subscriptionId}' AND USI.coupon_trial_from <= '{$date}' AND USI.coupon_trial_to > '{$date}' AND USI.status = '1'";
            $res = $db->query($query);

            if($db->numRows($res))
            {
                while ($rs = mysqli_fetch_array($res))
                {
                    $discountTotal += $rs['price'];
                }

                //
                if($discountTotal)
                {
                    // Fetch if coupon exist, otherwise create
                    $couponId = 'OFF-'.$discountTotal;

                    try {
                        // Retrieve coupon
                        $coupon = \Stripe\Coupon::retrieve($couponId);
                    } catch (\Stripe\Error\Base $e) {
                        // Create coupon
                        $coupon = \Stripe\Coupon::create([
                            'id' => $couponId,
                            'amount_off' => ($discountTotal*100),
                            'currency' => 'SEK',
                            'duration' => 'once',
                            // 'duration' => 'repeating',
                            // 'duration_in_months' => 3,
                        ]);
                    }

                    // Apply coupon on subscription
                    if($coupon)
                    {
                        try {
                            // Update subscription
                            \Stripe\Subscription::update(
                                $subscriptionId,
                                ['coupon' => $coupon->id]
                            );
                        } catch (\Stripe\Error\Base $e) {}
                    }
                }
                else
                {
                	try {
                        $sub = \Stripe\Subscription::retrieve($subscriptionId);

                        if( isset($sub->discount) && ($sub->discount != null) )
                        {
                            $sub->deleteDiscount();
                        }
                    } catch (\Stripe\Error\Base $e) {}
                }
            }
            else
            {
            	try {
                    $sub = \Stripe\Subscription::retrieve($subscriptionId);

                    if( isset($sub->discount) && ($sub->discount != null) )
                    {
                        $sub->deleteDiscount();
                    }
                } catch (\Stripe\Error\Base $e) {}
            }
        }
    }
}
?>