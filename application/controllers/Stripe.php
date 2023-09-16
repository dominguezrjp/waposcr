<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stripe extends CI_Controller {

	public function index()
	{

		//connect User

		// $stripe = new \Stripe\StripeClient(
		// 	'sk_test_51L2ubFSIMZk7vDdJIWnjkTiRCPX9yCtKipD2X9Dcq8XGPH5evL2hImSse3MXxSiGHPGblyyjIwYXisA0vokNrtek00pMnZcAy2'
		// );
		// $stripe->accounts->create([
		// 	'type' => 'custom',
		// 	'country' => 'US',
		// 	'email' => 'nm.rosen@example.com',
		// 	'capabilities' => [
		// 		'card_payments' => ['requested' => true],
		// 		'transfers' => ['requested' => true],
		// 	],
		// ]);


		// false code

		// Set your secret key. Remember to switch to your live secret key in production.
// See your keys here: https://dashboard.stripe.com/apikeys
		// $stripe = new \Stripe\StripeClient('sk_test_4eC39HqLyjWDarjtT1zdp7dc');

		// $stripe->accounts->create(
		// 	[
		// 		'country' => 'US',
		// 		'type' => 'express',
		// 		'capabilities' => [
		// 			'card_payments' => ['requested' => true],
		// 			'transfers' => ['requested' => true],
		// 		],
		// 		'business_type' => 'individual',
		// 		'business_profile' => ['url' => 'https://example.com'],
		// 	]
		// );



		// $stripe = new \Stripe\StripeClient('sk_test_4eC39HqLyjWDarjtT1zdp7dc');
		// $stripe->accounts->create(['type' => 'standard']);


		// $stripe = new \Stripe\StripeClient('sk_test_4eC39HqLyjWDarjtT1zdp7dc');

		// 	$stripe->accountLinks->create(
		// 	[
		// 		'account' => 'acct_1032D82eZvKYlo2C',
		// 		'refresh_url' => 'localhost/qmenu',
		// 		'return_url' => 'localhost/qmenu',
		// 		'type' => 'account_onboarding',
		// 	]
		// );

		// false code



		$stripe = new \Stripe\StripeClient('sk_test_51L2ubFSIMZk7vDdJIWnjkTiRCPX9yCtKipD2X9Dcq8XGPH5evL2hImSse3MXxSiGHPGblyyjIwYXisA0vokNrtek00pMnZcAy2');

		$stripe->products->create(
		  [
		    'name' => 'Basic Dashboard',
		    'default_price_data' => [
		      'unit_amount' => 1000,
		      'currency' => 'usd',
		      'recurring' => ['interval' => 'month'],
		    ],
		    'expand' => ['default_price'],
		  ]
		);




	}

	public function t(){

		echo '<html>
			  <head>
			    <title>Checkout</title>
			  </head>
			  <body>
			    <form action="'.$this->make_req().'" method="POST">
			      <button type="submit">Checkout</button>
			    </form>
			  </body>
			</html>';
	}

	public function make_req(){
		\Stripe\Stripe::setApiKey('sk_test_51L2ubFSIMZk7vDdJIWnjkTiRCPX9yCtKipD2X9Dcq8XGPH5evL2hImSse3MXxSiGHPGblyyjIwYXisA0vokNrtek00pMnZcAy2');

		$session = \Stripe\Checkout\Session::create([
		  'line_items' => [[
		    'price' => 'price_1L3HSTSIMZk7vDdJmQETC3TO',
		    'quantity' => 1,
		  ]],
		  'mode' => 'payment',
		  'success_url' => 'https://example.com/success',
		  'cancel_url' => 'https://example.com/failure',
		  'payment_intent_data' => [
		    'application_fee_amount' => 123,
		    'transfer_data' => [
		      'destination' => 'acct_1L3EY8H1Jy3tpkVr',
		    ],
		  ],
		]);
	}

}

/* End of file Stripe.php */
/* Location: ./application/controllers/Stripe.php */