<?php
  require_once('vendor/autoload.php');
//  require_once('config/db.php');
  require_once('lib/pdo_db.php');
 // require_once('models/Customer.php');
 // require_once('models/Transaction.php');

  \Stripe\Stripe::setApiKey('sk_YOURSERVERKEY');

 // Sanitize POST Array
 $POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);

 $first_name = $POST['first_name'];
 $last_name = $POST['last_name'];
 $email = $POST['email'];
 $token = $POST['stripeToken'];

// Create Customer In Stripe
$customer = \Stripe\Customer::create(array(
  "email" => $email,
  "source" => $token
));

// Charge Customer
$charge = \Stripe\Charge::create(array(
  "amount" => 50000,
  "currency" => "inr",
  "description" => "subcribing to a movie",
  "customer" => $customer->id
));

// Customer Data
$customerData = [
  'id' => $charge->customer,
  'first_name' => $first_name,
  'last_name' => $last_name,
  'email' => $email
];

// Redirect to success
header('Location: index.php);