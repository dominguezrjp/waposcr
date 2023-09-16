<?php if(check()==1): ?>
<?php $mercado = json_decode($settings['mercado_config'],true); ?>
<?php  if(!empty($mercado['access_token'])):?>
<div class="payment_content text-center <?= is_package;?>">
	<div class="payment_icon payment">
		<img src="<?php echo base_url('assets/frontend/images/payout/mercado.png'); ?>" alt="">
	</div>
	<div class="payment_details">
		<h4> <?= isset($u_info['username'])?html_escape($u_info['username']):'';?></h4>
		<div class="">
			<h2><?= get_currency('icon');?> <?= isset($total_price)?html_escape($total_price):'';?> / <?= !empty(lang($package['package_type']))?lang($package['package_type']):$package['package_type']?></h2>
			<p><b><?= lang('package'); ?> : </b> <?= html_escape($package['package_name']);?></p>
		</div>
	</div>
	<?php if(is_demo()==0): ?>
		<a href="<?= prep_url($init); ?>" class="btn btn-success buy_now"><?= !empty(lang('pay_now'))?lang('pay_now'):"Pay Now"?> &nbsp;( <?= get_currency('icon');?> <?= isset($total_price)?html_escape($total_price):'';?> )</a>
	<?php endif;?>
</div><!-- payment_content -->
<?php else: ?>
	<div class="payment_content text-center">
		<h4><?= !empty(lang('credentials_not_found'))?lang('credentials_not_found'):"Credentials not found" ;?></h4>
	</div>
<?php endif;?>

<?php endif;?>