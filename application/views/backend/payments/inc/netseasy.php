

<?php if(check()==1): ?>
<?php  if(!empty($init->paymentId)):?>
<div class="payment_content text-center <?= is_package;?>">
	<div class="payment_icon payment">
		<img src="<?php echo base_url('assets/frontend/images/payout/netseasy.png'); ?>" alt="">
	</div>
	<div class="payment_details">
		<h4> <?= isset($u_info['username'])?html_escape($u_info['username']):'';?></h4>
		<div class="">
			<h2><?= get_currency('icon');?> <?= isset($total_price)?html_escape($total_price):'';?> / <?= !empty(lang($package['package_type']))?lang($package['package_type']):$package['package_type']?></h2>
			<p><b><?= lang('package'); ?> : </b> <?= html_escape($package['package_name']);?></p>
		</div>
	</div>
	<?php if(is_demo()==0): ?>
		<button type="button" class="btn btn-success netseasyBtn"><?= !empty(lang('pay_now'))?lang('pay_now'):"Pay Now"?> &nbsp;( <?= get_currency('icon');?> <?= isset($total_price)?html_escape($total_price):'';?> )</button>
	<?php endif;?>

</div><!-- payment_content -->

<?php else: ?>
	<div class="payment_content text-center">
		<?php echo "<pre>";print_r($init);?>
	</div>
<?php endif;?>


<script>
	
	$(document).on("click",".netseasyBtn",function(){
		window.location = `<?= base_url("payment/netseasy/{$slug}/{$account_slug}?paymentId={$init->paymentId}");?>`;
	})
</script>


<?php endif;?>