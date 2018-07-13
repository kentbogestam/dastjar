<?php
require_once("cumbari.php");
// require_once("vendor/stripe/stripe-php/init.php");
require_once('vendor/autoload.php');

\Stripe\Stripe::setApiKey("sk_test_EypGXzv2qqngDIPIkuK6aXNi");
// Get the token from the JS script
$token = $_POST['stripeToken'];
// Create a Customer
$customer = \Stripe\Customer::create(array(
    "email" => "mayankkv1@gmail.com",
    "source" => $token
));
// or you can fetch customer id from the database too.
// Creates a subscription plan. This can also be done through the Stripe dashboard.
// You only need to create the plan once.
$subscription = \Stripe\Plan::create(array(
    "amount" => 2000,
    "interval" => "month",
    "currency" => "sek",
    "id" => "gold123",
  	'product' => array(
         'name' => "Gold large"
    )         
));
// Subscribe the customer to the plan
$subscription = \Stripe\Subscription::create(array(
    "customer" => $customer->id,
    "plan" => "gold123"
));

print_r($subscription);

?>