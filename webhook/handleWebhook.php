<?php
/*$str = 'Test';
$fileName = 'handleWebhook.log';
$filePath = dirname(__DIR__).'/logs/';

$fp = fopen($filePath.$fileName, 'a');
fwrite($fp, $str);
fclose($fp);
exit;*/
//
include_once(dirname(__DIR__).'/cumbari.php');
require_once(dirname(__DIR__).'/vendor/autoload.php');

class handleWebhook {
	function __construct() {
		\Stripe\Stripe::setApiKey(STRPIE_CLIENT_SECRET);

		// Retrieve the request's body and parse it as JSON
		$payload = @file_get_contents('php://input');

		// Verifying the event
		$endpoint_secret = HANDLE_WEBHOOK_ENDPOINT_SECRET;
		
		$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
		$event = null;

		try {
			//
			$event = \Stripe\Webhook::constructEvent(
				$payload, $sig_header, $endpoint_secret
			);

			// You might want to take specific actions in response to certain events, such as:
			// Emailing the customer when a payment fails
			// Extending the length of time that a customer can use your service
			// Terminating access when a subscription is canceled
			if( isset($event) && $event->type == "customer.subscription.created" )
			{
				$this->handleCustomerSubscriptionCreated($event);
			}
			elseif( isset($event) && $event->type == "invoice.payment_succeeded" )
			{
				$this->handleInvoicePaymentSuccess($event);
			}
			elseif( isset($event) && $event->type == "invoice.payment_failed" )
			{
				$this->handleInvoicePaymentFailure($event);
			}
			elseif( isset($event) && $event->type == "customer.subscription.deleted" )
			{
				$this->handleCustomerSubscriptionDeleted($event);
			}
			elseif( isset($event) && $event->type == "invoice.created" )
			{
				$this->handleInvoiceCreated($event);
			}
		} catch(\UnexpectedValueException $e) {
			// Invalid payload
			http_response_code(400); // PHP 5.4 or greater
			exit();
		} catch(\Stripe\Error\SignatureVerification $e) {
			// Invalid signature
			http_response_code(400); // PHP 5.4 or greater
			exit();
		}
	}

	/**
	 * Update subscription on event 'customer.subscription.created' fired after 'invoice.payment_succeeded'
	 * @param  [type] $event [description]
	 * @return [type]        [description]
	 */
	function handleCustomerSubscriptionCreated($event = null)
	{
		$eventData = $event->data->object;

		if( !empty($eventData) )
		{
			$subscriptionId = $eventData->id;

			// 
			$subscription = \Stripe\Subscription::retrieve($subscriptionId);

			if( !empty($subscription) && $subscription->status != 'incomplete' )
			{
				$invoiceId = $eventData->latest_invoice;
				$invoice = \Stripe\Invoice::retrieve($invoiceId);

				if( !empty($invoice) )
				{
					$this->onUpdateSubscriptionToActive($invoice, 'customer.subscription.created');
				}
			}
		}
	}

	/**
	 * Update subscription on payment success
	 * @param  [object] $event [description]
	 */
	public function handleInvoicePaymentSuccess($event = null)
	{
		/*$event = $this->getTestEvent();
		$event = json_decode($event, true);
		$event = json_decode(json_encode($event));
		$invoice = $event->object;*/

		// Get the invoice
		$invoice = $event->data->object;

		if( !empty($invoice) )
		{
			$this->onUpdateSubscriptionToActive($invoice, 'invoice.payment_succeeded');
		}
	}

	/**
	 * Cancel subscription
	 * @return [type] [description]
	 */
	public function handleCustomerSubscriptionDeleted($event = null)
	{
		$str = "======".date('Y-m-d H:i:s')."======\n";
		$str .= "Event Type: customer.subscription.deleted\n";

		// Get event data
		$subscription = $event->data->object;

		if( !empty($subscription) )
		{
			$db = new db();
			$conn = $db->makeConnection();
			
			// Check connection
			if($conn)
			{
				$subscriptionId = $subscription->id;

				// Check if Subscription exist in DB
				$query = "SELECT UP.id, UP.user_id, S.store_name FROM user_plan UP INNER JOIN store S ON UP.store_id = S.store_id WHERE UP.subscription_id = '{$subscriptionId}'";
				$res = mysqli_query($conn , $query) or die(mysqli_error($conn));

				if( mysqli_num_rows($res) )
				{
					// Update subscription in DB
					$query = "UPDATE user_plan SET status = '2' WHERE subscription_id = '{$subscriptionId}'";
					$res = mysqli_query($conn , $query) or die(mysqli_error($conn));

					$str .= "Query: {$query}\n";
				}
				else
				{
					$str .= "Subscription {$subscriptionId} not found in DB\n";
				}
			}
			else
			{
				$str .= "Connection failed\n";
			}
		}
		else
		{
			$str .= "Event empty\n";
		}

		$str .= "\n\n";
		$this->log($str);
	}

	/**
	 * Apply coupon on subscription
	 * @param  [type] $event [description]
	 * @return [type]        [description]
	 */
	function handleInvoiceCreated($event = null)
	{

	}

	/**
	 * Update subscription status to 'active' and send confirmation email
	 */
	function onUpdateSubscriptionToActive($invoice = array(), $eventType)
	{
		$str = "======".date('Y-m-d H:i:s')."======\n";
		$str .= "Event Type: {$eventType}\n";

		if( !empty($invoice) )
		{
			$db = new db();
			$conn = $db->makeConnection();

			// Check connection
			if($conn)
			{
				$subscriptionId = $invoice->subscription;
				$str .= "Subscription ID: {$subscriptionId}\n";

				// Retrieve subscription and update subscription in DB
				$subscription = \Stripe\Subscription::retrieve($subscriptionId);

				if( !empty($subscription) )
				{
					$endAt = date('Y-m-d H:i:s', $subscription->current_period_end);
					$str .= "Subscription end at: {$endAt}\n";
					
					$query = "UPDATE user_plan SET subscription_end_at = '{$endAt}' WHERE subscription_id = '{$subscriptionId}'";
					$res = mysqli_query($conn , $query) or die(mysqli_error($conn));
					$str .= "Query: {$query}\n";
				}
				
				// Check if Subscription exist in DB
				// $query = "SELECT UP.id, UP.user_id, BP.plan_nickname, S.store_name FROM user_plan UP INNER JOIN billing_products BP ON UP.plan_id = BP.plan_id INNER JOIN store S ON UP.store_id = S.store_id WHERE UP.subscription_id = '{$subscriptionId}' AND status = '0'";
				$query = "SELECT UP.id, UP.user_id, S.store_name FROM user_plan UP INNER JOIN store S ON UP.store_id = S.store_id WHERE UP.subscription_id = '{$subscriptionId}'";
				$res = mysqli_query($conn , $query) or die(mysqli_error($conn));

				if( mysqli_num_rows($res) )
				{
					$subsDetail = mysqli_fetch_assoc($res);
					$emailContent = '';
					
					include_once(dirname(__DIR__).'/classes/billing.php');
					include_once(dirname(__DIR__).'/classes/emails.php');

					// Get the invoice line items
					$invoiceLineItems = $invoice->lines->data;

					if( !empty($invoiceLineItems) )
					{
						$subtotal = number_format(($invoice->subtotal/100), 2, '.', '');
						$tax = number_format(($invoice->tax/100), 2, '.', '');
						$total = number_format(($invoice->total/100), 2, '.', '');

						// $updatedAt = date('Y-m-d H:i:s');
						foreach($invoiceLineItems as $lineItem)
						{
							$amount = number_format(($lineItem->plan->amount/100), 2, '.', '');
							$plan_nickname = '';

							// Start test
							$str .= "ILI Period Start: ".date('Y-m-d H:i:s', $lineItem->period->start)."\n";
							$str .= "ILI Period End: ".date('Y-m-d H:i:s', $lineItem->period->end)."\n";
							// End test
							
							$planId = $lineItem->plan->id;
							$str .= "Plan ID: {$planId}\n";

							// Get plan detail from DB
							$query = "SELECT plan_nickname FROM billing_products WHERE plan_id = '{$planId}'";
							$res = mysqli_query($conn , $query) or die(mysqli_error($conn));

							if( mysqli_num_rows($res) )
							{
								$billingProducts = mysqli_fetch_assoc($res);
								$plan_nickname = $billingProducts['plan_nickname'];
							}

							// 
							$emailContent .= "
	                        <tr>
                                <td align='left' vertical-align='top' style='padding:5px 15px;'>
                                    <div style='font-family:Lato, Helvetica, Arial, sans-serif;font-size:14px;line-height:1;color:#222222;'>{$plan_nickname}</div>
                                </td>
                                <td align='right' style='padding: 5px 15px;'>{$amount} (SEK)</td>
                            </tr>";
						}

						// 
						if($emailContent != '')
						{
							$str .= "Email content\n";

							// 
							$emailContent .= "
							<tr>
	                            <td align='right' vertical-align='top' style='padding:5px 10px 1px; background-color:#CCCD99;'>
	                                <div style='font-family:Lato, Helvetica, Arial, sans-serif;font-size:14px;line-height:1;color:#222222;'>Sub Total:</div>
	                            </td>
	                            <td align='right' style='padding:5px 10px 1px;background-color: #CCCD99;'>{$subtotal} (SEK)</td>
	                        </tr>
	                        <tr>
	                            <td align='right' vertical-align='top' style='padding:1px 10px 1px; background-color:#CCCD99;'>
	                                <div style='font-family:Lato, Helvetica, Arial, sans-serif;font-size:14px;line-height:1;color:#222222;'>Tax:</div>
	                            </td>
	                            <td align='right' style='padding:1px 10px 1px;background-color: #CCCD99;'>{$tax} (SEK)</td>
	                        </tr>
	                        <tr>
	                            <td align='right' vertical-align='top' style='padding:1px 10px 5px; background-color:#CCCD99;'>
	                                <div style='font-family:Lato, Helvetica, Arial, sans-serif;font-size:14px;line-height:1;color:#222222;'>Total:</div>
	                            </td>
	                            <td align='right' style='padding:1px 10px 5px;background-color: #CCCD99;'>{$total} (SEK)</td>
	                        </tr>
							";

							// 
							$billingObj = new billing();
    						$user = $billingObj->getUserCompanySubsDetail($subsDetail['user_id']);

	                        // Send thank-you email
	                        $template = file_get_contents(BASEPATH.'email-templates/subscription-confirmation-email.html');

	                        $find = array('{{orgNo}}', '{{userName}}', '{{companyAddress}}', '{{storeName}}', '{{theContent}}');
	                        $replace = array($user['orgnr'], $user['userName'], $user['companyAddress'], $subsDetail['store_name'], $emailContent);
	                        $template = str_replace($find, $replace, $template);

	                        $mailObj = new emails();
	                        $mailObj->sendSubscriptionThankYouEmail($user['email'], $template);

	                        // echo $template;
	                        $str .= "Email sent\n";
						}
					}
				}
				else
				{
					$str .= "Subscription not found in DB\n";
				}
			}
			else
			{
				$str .= "Connection failed\n";
			}
		}
		else
		{
			$str .= "Invoice empty\n";
		}

		$str .= "\n\n";
		$this->log($str);
	}

	/**
	 * Sends email to customer on payment failed
	 * @param  [type] $event [description]
	 * @return [type]        [description]
	 */
	public function handleInvoicePaymentFailure($event)
	{
		// $customer = \Stripe\Customer::retrieve($event->data->object->customer);
		// $email = $customer->email;
		// // Sending your customers the amount in pennies is weird, so convert to dollars
		// $amount = sprintf('$%0.2f', $event->data->object->amount_due / 100.0);
		
		$str = "======".date('Y-m-d H:i:s')."======\n";
		$str .= "Payment Failed\n";

		// Get the invoice
		$invoice = $event->data->object;

		if( !empty($invoice) )
		{
			$db = new db();
			$conn = $db->makeConnection();

			// Check connection
			if($conn)
			{
				$subscriptionId = $invoice->subscription;
				$str .= "subscription: {$subscriptionId}\n";

				// Check if Subscription exist in DB
				$query = "SELECT id FROM user_plan WHERE subscription_id = '{$subscriptionId}'";
				$res = mysqli_query($conn , $query) or die(mysqli_error($conn));

				if( mysqli_num_rows($res) )
				{
					// Update subscription in DB
					$query = "UPDATE user_plan SET status = '0' WHERE subscription_id = '{$subscriptionId}'";
					$res = mysqli_query($conn , $query) or die(mysqli_error($conn));

					$str .= "Query: {$query}\n";
				}
				else
				{
					$str .= "Subscription not found in DB\n";
				}
			}
			else
			{
				$str .= "Connection failed\n";
			}
		}
		else
		{
			$str .= "Invoice empty\n";
		}

		$str .= "\n\n";
		$this->log($str);
	}

	/**
	 * [log description]
	 * @param  [type] $str [description]
	 * @return [type]      [description]
	 */
	function log($str)
	{
		$fileName = 'handleWebhook.log';
		$filePath = dirname(__DIR__).'/logs/';

		$fp = fopen($filePath.$fileName, 'a');
		fwrite($fp, $str);
		fclose($fp);
	}
}

$webhook = new handleWebhook();
// $webhook->handleInvoicePaymentSuccess();
?>