<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/payments/secrets.php';

$ticketId = $_COOKIE['ticketId'];
$ticket = new Ticket();
$ticketDetails = $ticket->find($ticketId);

$stripe = new \Stripe\StripeClient($stripeSecretKey);
header('Content-Type: application/json');

$YOUR_DOMAIN = 'https://kanid.dk/';

$checkout_session = $stripe->checkout->sessions->create([
  'ui_mode' => 'embedded',
  'line_items' => [[
    # Provide the exact Price ID (e.g. price_1234) of the product you want to sell
    'price' => '{{PRICE_ID}}',
    'quantity' => 1,
  ]],
  'mode' => 'payment',
  'return_url' => $YOUR_DOMAIN . '/return.html?session_id='.$ticketDetails["CheckoutSessionID"].'}',
]);

echo json_encode(array('clientSecret' => $checkout_session->client_secret));