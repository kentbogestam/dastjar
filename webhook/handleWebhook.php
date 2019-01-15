<?php
//
include_once("../cumbari.php");
require_once("../vendor/autoload.php");

class handleWebhook {
	function __construct() {
		\Stripe\Stripe::setApiKey(STRPIE_CLIENT_SECRET);

		// Retrieve the request's body and parse it as JSON
		$payload = @file_get_contents('php://input');

		// Verifying the event
		$endpoint_secret = 'whsec_D1bSEfnuaEvHv3AJez3KKU26mE2FXMoM';
		
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
			if( isset($event) && $event->type == "invoice.payment_succeeded" )
			{
				$this->handleInvoicePaymentSuccess($event);
			}
			elseif( isset($event) && $event->type == "invoice.payment_failed" )
			{
				$this->handleInvoicePaymentFailure($event);
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
	 * Update subscription on payment success
	 * @param  [object] $event [description]
	 */
	public function handleInvoicePaymentSuccess($event = null)
	{
		$str = "======".date('Y-m-d H:i:s')."======\n";

		// Get the invoice
		$invoice = $event->data->object;

		if( !empty($invoice) )
		{
			$subscriptionId = $invoice->subscription;
			$subscriptionEndAt = date('Y-m-d H:i:s', $invoice->period_end);
			$updatedAt = date('Y-m-d H:i:s');

			$str .= "subscription: {$subscriptionId}\nperiod_end: {$subscriptionEndAt}\n";
			
			// Get the invoice line items
			$invoiceLineItems = $invoice->lines->data;

			if( !empty($invoiceLineItems) )
			{
				foreach($invoiceLineItems as $lineItem)
				{
					$planId = $lineItem->plan->id;

					$str .= "plan: {$planId}\n";

					// Update subscription in DB
					$db = new db();
					$conn = $db->makeConnection();

					// Check connection
					if ($conn)
					{
						$query = "UPDATE user_plan SET subscription_end_at = '{$subscriptionEndAt}', updated_at = '{$updatedAt}' WHERE subscription_id = '{$subscriptionId}' AND plan_id = '{$planId}'";
						$res = mysqli_query($conn , $query) or die(mysqli_error($conn));

						$str .= "query: {$query}\n";
					}
					else
					{
						$str .= "Connection failed\n";
					}
				}
			}
			else
			{
				$str .= "Line item empty\n";
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
			$subscriptionId = $invoice->subscription;
			$str .= "subscription: {$subscriptionId}\n";
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
		$filePath = '../logs/';

		$fp = fopen($filePath.$fileName, 'a');
		fwrite($fp, $str);
		fclose($fp);
	}
}

$webhook = new handleWebhook();
// $webhook->handleInvoicePaymentSuccess();
?>