<?php if(check()==1): ?>
<?php $stripe_fpx = json_decode($setting['fpx_config']); ?>
<?php  if(!empty($stripe_fpx->fpx_secret_key)):?>
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
		'amount' => $total_price*100,
		'currency' => 'myr',
	]);

?>

<div class="payment_content text-center <?= is_package;?>">
	<div class="payment_icon payment" style="background: url(<?php echo base_url('assets/frontend/images/payout/fpx.png'); ?>);">
	</div>
	<div class="payment_details">
		<h4> <?= isset($u_info['username'])?html_escape($u_info['username']):'';?></h4>
		<div class="">
			<h2>MYR <?= isset($total_price)?html_escape($total_price):'';?> / <?= !empty(lang($package['package_type']))?lang($package['package_type']):$package['package_type']?></h2>
			<p><b><?= lang('package'); ?> : </b> <?= html_escape($package['package_name']);?></p>
		</div>
	</div>
	<?php if(is_demo()==0): ?>
		<form id="payment-form" role="form" action="<?= base_url('payment/stript_fpx');?>" method="get">
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
			<input type="hidden" name="id" value="1">
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
	    return_url: `<?= base_url();?>payment/stripe_fpx?slug=<?= $slug ;?>&account_slug=<?= $account_type ;?>`,
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


<?php endif;?>