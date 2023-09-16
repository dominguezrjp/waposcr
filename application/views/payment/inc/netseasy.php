
<?php $netseasy_init = $this->user_payment_m->netseasy_init($slug,$total_amount); ?>
<?php if(isset($netseasy_init) && !empty($netseasy_init->paymentId)): ?>
<div class="payment_content text-center <?= $pay['slug'];?>">
	<div class="payment_icon payment">
		<img src="<?php echo base_url('assets/frontend/images/payout/netseasy.png'); ?>" alt="">
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
	<button type="button" class="btn btn-success netseasyBtn"><?= !empty(lang('pay_now'))?lang('pay_now'):"Pay Now"?> &nbsp;( <?= isset($total_amount)?currency_position($total_amount,$shop['id']):'';?> )</button>

	<script>

		$(document).on("click",".netseasyBtn",function(){
			window.location = `<?= base_url("user_payment/netseasy/{$slug}?paymentId={$netseasy_init->paymentId}");?>`;
		})
	</script>

</div><!-- payment_content -->
<?php else: ?>
	<div class="payment_content text-center">
		<h4><?= !empty(lang('credentials_not_found'))?lang('credentials_not_found'):"Credentials not found" ;?></h4>
		<?php echo "<pre>";print_r($netseasy_init);?>
	</div>
<?php endif;?>