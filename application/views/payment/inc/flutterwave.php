<?php if(check()==1): ?>
<?php $flutterwave = !empty($shop['flutterwave_config'])?json_decode($shop['flutterwave_config'],true):''; ?>
<?php  if(!empty($flutterwave['fw_public_key'])):?>
<div class="payment_content text-center <?= $pay['slug'];?>">
	<div class="payment_icon payment">
		<img src="<?php echo base_url('assets/frontend/images/payout/flutterwave.jpeg'); ?>" alt="">
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
	<form action='#' method='post'>
		<?= csrf();;?>
		<input type='hidden' name='customer_email' class='form-control' required value="<?= $user['email'] ;?>" />
		<input type='hidden' name='amount' class='form-control' required value="<?= $total_amount ;?>" />
		<input type='hidden' name='currency' value='NGN' readonly class='form-control'/>
		<input type='hidden' name='payment_plan' value='<?= $user['username'] ;?>'  class='form-control'/>
		<input type='hidden' name='slug' value='<?= $user['username'] ;?>'  class='form-control'/>
		<?php if(is_demo()==0): ?>
			<button type="button" class="btn btn-success buy_now" id="start-payment-button" onclick="makePayment()"><?= !empty(lang('pay_now'))?lang('pay_now'):"Pay Now"?> &nbsp;( <?=  isset($total_amount)?currency_position($total_amount,$shop['id']):'';?> )</button>
		<?php endif;?>


		<?php 
			$title = $shop['username'];
			$currency = $shop['currency_code'];
			$base_url = base_url();
			$slug = $user['username'];
			$email = $user['email'];
			$account_slug = 'empty';
			$amount = $total_amount;
			$public_key = $flutterwave['fw_public_key'];
			$rand_id = $slug.'_'.random_string('alnum',12);
			$phone = $payment['phone']??0;
			$redirect_url = base_url("user_payment/flutterwave_payment_status/?slug={$slug}");
	 	?>


	</form>
	
</div><!-- payment_content -->
<?php else: ?>
	<div class="payment_content text-center">
		<h4><?= !empty(lang('credentials_not_found'))?lang('credentials_not_found'):"Credentials not found" ;?></h4>
	</div>
<?php endif;?>



<?php include APPPATH.'views/common/flutterwave-js.php'; ?>
<?php endif;?>