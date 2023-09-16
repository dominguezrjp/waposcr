<?php $paypal = json_decode($shop['paypal_config'],true); ?>
<?php  if(!empty($paypal['paypal_email'])):?>
<div class="payment_content text-center <?= $pay['slug'];?>">
	<div class="payment_icon payment">
	<img src="<?php echo base_url('assets/frontend/images/payout/paypal.png'); ?>" alt="">
</div>

	<div class="payment_details">
		<div class="userInfo">
			<h4> <?= isset($payment['name'])?html_escape($payment['name']):'';?></h4>
			<p><?= lang('phone'); ?>: <?= isset($payment['phone'])?html_escape($payment['phone']):'';?></p>
		</div>
		<div class="">

			<h2> <?= isset($total_amount)?currency_position($total_amount,$shop['id']):'';?> </h2>

		</div>
		<p class="payment_text">* <?= !empty(lang('payment_by'))?lang('payment_by'):"Payment via"?> <i class="fa fa-cc-paypal fa-2x"></i></p>
	</div>



	<form action="<?= isset($paypal['is_live']) && $paypal['is_live']==1?"https://www.paypal.com/cgi-bin/webscr":"https://www.sandbox.paypal.com/cgi-bin/webscr" ;?>"
		method="post" target="_top">
		<!-- csrf token -->
		<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
		<input type='hidden' name='business'
		value='<?= !empty($paypal['paypal_email'])?$paypal['paypal_email']:'';?>'>
		<input type='hidden'
		name='item_name' value='<?=  html_escape($total_amount);?>'>

		<input type='hidden'
		name='item_number' value='1'>

		<input type='hidden'
		name='amount' value='<?= number_format((float)$total_amount, 2, '.', '');?>'> 

		<input type='hidden'
		name='no_shipping' value='1'>

		<input type='hidden'
		name='currency_code' value='<?= $shop['currency_code'] ;?>'>

		<input type='hidden' name='notify_url' value='<?= base_url('user_payment/paypal/'.$slug) ;?>'>

		<input type='hidden' name='cancel_return'
		value='<?= base_url('user_payment/payment_cancel/'.$slug) ;?>'>

		<input type='hidden' name='return'
		value='<?= base_url('user_payment/paypal/'.$slug) ;?>'>

		<input type="hidden" name="cmd" value="_xclick">
		<?php if(is_demo()==0): ?>
			<button
			type="submit" name="pay_now" id="pay_now" class="btn btn-success pay_now"
			> <?= !empty(lang('pay_now'))?lang('pay_now'):"Pay Now"?> &nbsp;(<?= isset($total_amount)?currency_position($total_amount,$shop['id']):'';?> ) <i class="icofont-paypal"></i> </button>
		<?php endif;?>
	</form>

	</div><!-- payment_content -->
<?php else: ?>
	<div class="payment_content text-center">
		<h4><?= !empty(lang('credentials_not_found'))?lang('credentials_not_found'):"Credentials not found" ;?></h4>
	</div>
<?php endif;?>