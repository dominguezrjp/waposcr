
<?php $stripe_fpx = json_decode($shop['fpx_config']); ?>
<?php if(!empty($stripe_fpx->fpx_secret_key)): ?>
<style>
	.ElementsApp, .ElementsApp .SelectField, .ElementsApp .SelectField-control{
		border: 1px solid #eee!important;
		border-radius: 5px!important;
	}
	.payment_content {
	    padding-bottom: 183px!important;
	}
</style>
<?php 
	\Stripe\Stripe::setApiKey($stripe_fpx->fpx_secret_key);

	$payment_intent = \Stripe\PaymentIntent::create([
		'payment_method_types' => ['fpx'],
		'amount' => round($total_amount*100),
		'currency' => 'myr',
	]);

?>
<div class="payment_content text-center <?= $pay['slug'];?>">
	<div class="payment_icon payment" style="background: url(<?php echo base_url('assets/frontend/images/payout/fpx.png'); ?>);">
	</div>
	<div class="payment_details">
		<div class="userInfo">
			<h4> <?= isset($payment['name'])?html_escape($payment['name']):'';?></h4>
			<p><?= lang('phone'); ?>: <?= isset($payment['phone'])?html_escape($payment['phone']):'';?></p>
		</div>
		<div class="">

			<h2> <?= isset($total_amount)?currency_position($total_amount,$shop['id']):'';?> </h2>

		</div>
	</div>
	<?php if(is_demo()==0): ?>
		<form id="payment-form" role="form" action="<?= base_url('user_payment/stript_fpx');?>" method="get">
			<div class="form-row">
				<div class="w_100">
					<label for="fpx-bank-element">
						FPX Bank
					</label>
					<div style="width: 350px; margin: 20px auto;">
						<div id="fpx-bank-element" class="bankNames">
							<!-- A Stripe Element will be inserted here. -->
						</div>
					</div>
				</div>
			</div>
			<input type="hidden" name="id" value="<?= $user['id'] ;?>">
			<div class="">
				<button id="fpx-button" class="btn btn-primary" data-secret="<?= $payment_intent->client_secret;?>">
					<?= lang('pay_now'); ?>
				</button>

			</div>
			<!-- Used to display form errors. -->
			<div id="error-message" role="alert"></div>
		</form>
	<?php endif;?>
</div><!-- payment_content -->

<script src="https://js.stripe.com/v3/"></script>

<script>
	var stripe = Stripe(`<?= $stripe_fpx->fpx_public_key ;?>`);
	var elements = stripe.elements();
	var style = {
		  base: {
		    // Add your base input styles here. For example:
		    padding: '10px 12px',
		    color: '#32325d',
		    fontSize: '16px',
		  },
	};

		// Create an instance of the fpxBank Element.
	var fpxBank = elements.create(
	  'fpxBank',
	  {
	    style: style,
	    accountHolderType: 'individual',
	  }
	);

	// Add an instance of the fpxBank Element into the container with id `fpx-bank-element`.
	fpxBank.mount('#fpx-bank-element');


	var form = document.getElementById('payment-form');

	form.addEventListener('submit', function(event) {
	  event.preventDefault();

	  var fpxButton = document.getElementById('fpx-button');
	  var clientSecret = fpxButton.dataset.secret;
	  stripe.confirmFpxPayment(clientSecret, {
	    payment_method: {
	      fpx: fpxBank,
	    },
	    // Return URL where the customer should be redirected after the authorization
	    return_url: `<?= base_url();?>user_payment/stripe_fpx?slug=<?= $slug ;?>`,
	  }).then((result) => {
	    if (result.error) {
	      // Inform the customer that there was an error.
	      var errorElement = document.getElementById('error-message');
	      errorElement.textContent = result.error.message;
	    }
	  });
	});




</script>

<?php else: ?>
	<div class="payment_content text-center">
		<h4><?= !empty(lang('credentials_not_found'))?lang('credentials_not_found'):"Credentials not found" ;?></h4>
	</div>
<?php endif;?>