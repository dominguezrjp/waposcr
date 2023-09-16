<?php $razorpay = json_decode($shop['razorpay_config'],true); ?>
<?php if(!empty($razorpay['razorpay_key_id'])): ?>
<div class="payment_content text-center <?= $pay['slug'];?>">
	<div class="payment_icon payment">
		<img src="<?php echo base_url('assets/frontend/images/payout/razorpay.png'); ?>" alt="">
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
		<a href="javascript:;" data-key="<?= !empty($razorpay['razorpay_key'])?$razorpay['razorpay_key_id']:'' ;?>" data-amount="<?= isset($total_amount)?number_format((float)$total_amount, 2, '.', ''):'';?>" data-id="<?= isset($shop['id'])?$shop['id']:0;?>" data-customer="<?= $payment['name'] ;?>" data-currency="<?= $shop['currency_code'];?>" data-phone="<?= $payment['phone'] ;?>" data-name="<?=  $slug;?>" class="btn btn-success" id="rzp-button1"><?= !empty(lang('pay_now'))?lang('pay_now'):"Pay Now"?> &nbsp;(<?= isset($total_amount)?currency_position($total_amount,$shop['id']):'';?> )</a>
	<?php endif;?>
</div><!-- payment_content -->
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<?php else: ?>
	<div class="payment_content text-center">
		<h4><?= !empty(lang('credentials_not_found'))?lang('credentials_not_found'):"Credentials not found" ;?></h4>
	</div>
<?php endif;?>