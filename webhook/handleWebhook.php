<?php
//
include_once("../cumbari.php");
require_once("../vendor/autoload.php");

class handleWebhook {
	function __construct() {
		\Stripe\Stripe::setApiKey(STRPIE_CLIENT_SECRET);

		// Verifying the event
		$endpoint_secret = 'whsec_D1bSEfnuaEvHv3AJez3KKU26mE2FXMoM';

		// Retrieve the request's body and parse it as JSON
		$payload = @file_get_contents('php://input');
		$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
		$event = null;

		if( !is_null($sig_header) )
		{
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
	}

	/**
	 * Send invoice email to customer on payment success
	 * @param  [object] $event [description]
	 */
	public function handleInvoicePaymentSuccess($event = null)
	{
		$str = "======".date('Y-m-d H:i:s')."======\n";

		if( !is_null($event) )
		{
			$invoice = $event->data->object;



			$str .= print_r($invoice, true);
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
//$webhook->handleInvoicePaymentSuccess();
?>