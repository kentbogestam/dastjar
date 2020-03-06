<?php
require(dirname(__DIR__).'/config/dbConfig.php');
require(dirname(__DIR__).'/classes/db.php');
require(dirname(__DIR__).'/config/config.php');
require_once(dirname(__DIR__).'/vendor/autoload.php');

error_reporting(-1);
ini_set('display_errors', 'On');

$db = new db();
$conn = $db->makeConnection();

if($conn)
{
	// 
	$page = 1;

	if(!empty($_GET['page'])) {
		$page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
		if(false === $page) {
			$page = 1;
		}
	}

	// set the number of items to display per page
	$items_per_page = 20;
	$offset = ($page - 1) * $items_per_page;


	// Get all 'active' subscription
	$query = "SELECT UP.id, UP.subscription_id FROM user_plan UP INNER JOIN user_subscription_items USI ON UP.subscription_id = USI.subscription_id WHERE UP.status = '1' ORDER BY UP.id LIMIT {$offset}, {$items_per_page}";
	$res = mysqli_query($conn , $query) or die(mysqli_error($conn));

	if( mysqli_num_rows($res) )
	{
		\Stripe\Stripe::setApiKey(STRPIE_CLIENT_SECRET);

		while ($rs = mysqli_fetch_assoc($res)) {
			$subscriptionId = $rs['subscription_id'];
			// echo $subscriptionId;

			try {
                // Retrieve sub
                $sub = \Stripe\Subscription::retrieve($subscriptionId);

                if($sub)
                {
					// Get the subscribed plan
					$subscriptionItems = $sub->items->data;

					if( !empty($subscriptionItems) )
                    {
                        foreach($subscriptionItems as $item)
                        {
                        	$query = "SELECT id FROM user_subscription_items WHERE subscription_id = '{$subscriptionId}' AND plan_id = '{$item->plan->id}'";
                        	$res2 = mysqli_query($conn , $query) or die(mysqli_error($conn));

                        	if( mysqli_num_rows($res2) )
                        	{
                        		while ($rs2 = mysqli_fetch_assoc($res2)) {
                        			$id = $rs2['id'];

                        			$query = "UPDATE user_subscription_items SET subscription_item = '{$item->id}' WHERE id = '{$id}'";
                        			// echo $query.'<br>';
                        			mysqli_query($conn , $query) or die(mysqli_error($conn));
                        		}
                        	}
                        }
                    }
                }
            } catch (\Stripe\Error\Base $e) {}
        }
	}
	else{
		echo 'No subs found.';
	}
}
?>