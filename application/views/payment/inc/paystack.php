<?php $paystack = json_decode($shop['paystack_config'],true); ?>
<?php  if(!empty($paystack['paystack_public_key'])):?>
<div class="payment_content text-center <?= $pay['slug'];?>">
	<div class="payment_icon payment">
		<img src="<?php echo base_url('assets/frontend/images/payout/paystack.png'); ?>" alt="">
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
	<form id="paymentForm">
		<?= csrf();;?>
		<input type="hidden" name="email" id="email" value="<?= $user['email'] ;?>"  />
		<input type="hidden" id="amount" name="amount" value="<?= round($total_amount) ;?>"  />
		<input type="hidden" id="username" name="username" value="<?=  $user['username'];?>"  />
		<input type="hidden" id="currency" name="currency" value="<?= $shop['currency_code'] ;?>"  />
		<input type='hidden' name='slug' value='<?= $user['username'] ;?>'  class='form-control'/>

		
		<?php if(is_demo()==0): ?>
			<button type="submit" class="btn btn-success" onclick="payWithPaystack()"> <?= !empty(lang('pay_now'))?lang('pay_now'):"Pay Now"?> &nbsp;( <?=  isset($total_amount)?currency_position($total_amount,$shop['id']):'';?> ) </button>

		<?php endif;?>
	</form>
	
</div><!-- payment_content -->
<?php else: ?>
	<div class="payment_content text-center">
		<h4><?= !empty(lang('credentials_not_found'))?lang('credentials_not_found'):"Credentials not found" ;?></h4>
	</div>
<?php endif;?>



<script src="https://js.paystack.co/v1/inline.js"></script> 

 <script>
 	var KEYS = '<?php echo $paystack['paystack_public_key']; ?>';
 	var base_url = '<?= base_url();?>';
 	const paymentForm = document.getElementById('paymentForm');
 	paymentForm.addEventListener("submit", payWithPaystack, false);
 	function payWithPaystack(e) {
 		e.preventDefault();
 		var username = document.getElementById("username").value;
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
			    	window.location = `${base_url}user_payment/verify_payment/${response.reference}?user=${username}` ;
			    }
			});
 		handler.openIframe();
 	}
 </script>	