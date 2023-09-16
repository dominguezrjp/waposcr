<?php $mercado = json_decode($shop['mercado_config'],true); ?>
<?php  if(!empty($mercado['access_token'])):?>
<?php $init = $this->user_payment_m->mercado_init($slug);?>
<div class="payment_content text-center <?= $pay['slug'];?>">
	<div class="payment_icon payment">
		<img src="<?php echo base_url('assets/frontend/images/payout/mercadopago.png'); ?>" alt="">
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
		<a href="<?= prep_url($init['init']); ?>" class="btn btn-success buy_now"><?= !empty(lang('pay_now'))?lang('pay_now'):"Pay Now"?> &nbsp;(  <?= isset($total_amount)?currency_position($total_amount,$shop['id']):'';?> )</a>
	<?php endif;?>
</div><!-- payment_content -->
<?php else: ?>
	<div class="payment_content text-center">
		<h4><?= !empty(lang('credentials_not_found'))?lang('credentials_not_found'):"Credentials not found" ;?></h4>
	</div>
<?php endif;?>