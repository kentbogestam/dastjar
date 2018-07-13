<?php // Create a customer using a Stripe token

// If you're using Composer, use Composer's autoload:
require_once('cumbari.php');
require_once('vendor/autoload.php');

// Be sure to replace this with your actual test API key
// (switch to the live key later)
\Stripe\Stripe::setApiKey("sk_test_EypGXzv2qqngDIPIkuK6aXNi");

try
{
  $customer = \Stripe\Customer::create(array(
    'email' => $_POST['stripeEmail'],
    'source'  => $_POST['stripeToken'],
  ));

  $plan = \Stripe\Plan::create(array(
      "amount" => 2000,
      "interval" => "month",
      "currency" => "sek",
      "id" => uuid(),
      'product' => array(
          'name' => "Gold large"
        )      
  ));

  $subscription = \Stripe\Subscription::create(array(
    'customer' => $customer->id,
    // 'items' => array(array('plan' => $plan)),
    'plan' => $plan
  ));

  print_r($customer);
  // print_r($plan);
  print_r($subscription);

  $db = new db();
  $db->makeConnection();

  $stripe_id = $customer->id;
  $stripe_plan = $subscription->plan->id;
  $card_brand = $customer->sources->data[0]->brand;
  $card_last_four = $customer->sources->data[0]->last4;
  $quantity = $subscription->plan->amount;
  $trial_ends_at = "";
  $subscription_ends_at = "";
  $created_at = date("Y-m-d H:i:s", time());
  $updated_at = date("Y-m-d H:i:s", time());

  $query = "insert into subscriptions(stripe_id, stripe_plan, card_brand, card_last_four, quantity, created_at, updated_at) values('$stripe_id', '$stripe_plan', '$card_brand', '$card_last_four', $quantity, '$created_at', '$updated_at')";

  $db->query($query);

}
catch(Exception $e)
{
  // header('Location:oops.html');
  print_r("unable to sign up customer:" . $_POST['stripeEmail'].
    ", error:" . $e->getMessage());
}