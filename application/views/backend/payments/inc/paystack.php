<div class="payment_content text-center">
	<div class="payment_icon payment">
		<img src="<?php echo base_url('assets/frontend/images/payout/paystack-2.png'); ?>" alt="">
	</div>
	<?php $paystack = json_decode($setting['paystack_config']); ?>
	<div class="payment_details">
		<h4> <?= isset($u_info['username'])?html_escape($u_info['username']):'';?></h4>
		<div class="">
			<h2><?= get_currency('icon');?> <?= isset($total_price)?html_escape($total_price):'';?> / <?= !empty(lang($package['package_type']))?lang($package['package_type']):$package['package_type']?></h2>
			<p><b><?= !empty(lang('package_name'))?lang('package_name'):"Package Name"?> : </b> <?= html_escape($package['package_name']);?></p>
		</div>
		<p class="payment_text">* <?= !empty(lang('payment_by'))?lang('payment_by'):"Payment via"?> <i class="fa fa-credit-card-alt"></i></p>
	</div>

	<form id="paymentForm">
		<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

		<input type="hidden" name="email" id="email" value="<?= $u_info['email'] ;?>"  />
		<input type="hidden" id="amount" name="amount" value="<?= isset($total_price)?html_escape($total_price):'';?>"  />
		<input type="hidden" id="username" name="username" value="<?=  $u_info['username'];?>"  />
		<input type="hidden" id="currency" name="currency" value="<?=  get_currency('currency_code');?>"  />
		<input type="hidden" name="package_name" id="package_name" value="<?= $account_type;?>"> 



		<div class="form-submit">
			<button type="submit" class="btn btn-success" onclick="payWithPaystack()"> <?= !empty(lang('pay_now'))?lang('pay_now'):"Pay Now"?> &nbsp;( <?= isset($total_price)?html_escape($total_price):'';?> ) </button>
		</div>

	</form>

</div><!-- payment_content -->

<script src="https://js.paystack.co/v1/inline.js"></script> 

 <script>
 	var KEYS = '<?php echo $paystack->paystack_public_key; ?>';
 	const paymentForm = document.getElementById('paymentForm');
 	paymentForm.addEventListener("submit", payWithPaystack, false);
 	function payWithPaystack(e) {
 		e.preventDefault();
 		var username = document.getElementById("username").value;
 		var package_name = document.getElementById("package_name").value;
 		let handler = PaystackPop.setup({
			    key: KEYS, // Replace with your public key
			    email: document.getElementById("email").value,
			    amount: document.getElementById("amount").value * 100,
			    currency:document.getElementById("currency").value,
			    ref: ''+Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
			    // label: "Optional string that replaces customer email"
			    onClose: function(){
			    	alert('Window closed.');
			    },
			    callback: function(response){
			    	let message = 'Payment complete! Reference: ' + response.reference;
			    	window.location = `${base_url}payment/verify_payment/${response.reference}?user=${username}&package=${package_name}` ;
			    }
			});
 		handler.openIframe();
 	}
 </script>	