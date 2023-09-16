<?php $paypal_info = json_decode($settings['paypal_config'],true); ?>
<?php  if(!empty($paypal_info['paypal_email'])):?>
<div class="payment_content text-center <?= is_package;?>">
	<div class="payment_icon payment">
		<img src="<?php echo base_url('assets/frontend/images/payout/paypal.png'); ?>" alt="">
	</div>

	<div class="payment_details">
		<h4> <?= isset($u_info['username'])?html_escape($u_info['username']):'';?></h4>
		<div class="">
			<h2><?= get_currency('icon');?> <?= isset($total_price)?html_escape($total_price):'';?> / <?= !empty(lang($package['package_type']))?lang($package['package_type']):$package['package_type']?></h2>
			<p><b><?= lang('package'); ?> : </b> <?= html_escape($package['package_name']);?></p>
		</div>
		<p class="payment_text">* <?= !empty(lang('payment_via'))?lang('payment_via'):"Payment via"?> <i class="fa fa-cc-paypal fa-2x"></i></p>
	</div>
	<form action="<?= isset($paypal_info['is_live']) && $paypal_info['is_live']==1?"https://www.paypal.com/cgi-bin/webscr":"https://www.sandbox.paypal.com/cgi-bin/webscr" ;?>" method="post" target="_top">
		<!-- csrf token -->
		<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
		<input type='hidden' name='business'
		value='<?= isset($paypal_info['paypal_email']) && !empty($paypal_info['paypal_email'])?$paypal_info['paypal_email']:'' ;?>'>
		<input type='hidden'
		name='item_name' value='<?=  html_escape($package['slug']);?>'>

		<input type='hidden'
		name='item_number' value='1'>

		<input type='hidden'
		name='amount' value='<?=  $total_price;?>'> 

		<input type='hidden'
		name='no_shipping' value='1'>

		<input type='hidden'
		name='currency_code' value='<?= get_currency('currency_code');?>'>

		<input type='hidden' name='notify_url' value='<?= base_url('payment/success/'.$slug.'/'.$account_type) ;?>'>

		<input type='hidden' name='cancel_return'
		value='<?= base_url('payment/cancel/'.$slug) ;?>'>

		<input type='hidden' name='return'
		value='<?= base_url('paypal-success/'.$slug.'/'.$account_type) ;?>'>

		<input type="hidden" name="cmd" value="_xclick">
		<?php if(is_demo()==0): ?>
			<button type="submit" name="pay_now" id="pay_now" class="btn btn-success pay_now"
			> <?= !empty(lang('pay_now'))?lang('pay_now'):"Pay Now"?> &nbsp;(<?= get_currency('icon');?> <?= isset($total_price)?html_escape($total_price):'';?> )</button>
		<?php endif;?>
	</form>
</div><!-- payment_content -->
<?php else: ?>
	<div class="payment_content text-center">
		<h4><?= !empty(lang('credentials_not_found'))?lang('credentials_not_found'):"Credentials not found" ;?></h4>
	</div>
<?php endif;?>