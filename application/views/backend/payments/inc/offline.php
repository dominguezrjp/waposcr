<?php $offline = json_decode($setting['offline_config'],true); ?>
<div class="payment_content text-center">
	<div class="payment_icon payment">
		<img src="<?php echo base_url('assets/frontend/images/offline.png'); ?>" alt="">
	</div>
	<div class="payment_details">
		<h4> <?= isset($u_info['username'])?html_escape($u_info['username']):'';?></h4>
		<div class="">
			<h2><?= get_currency('icon');?> <?= isset($total_price)?html_escape($total_price):'';?> / <?= !empty(lang($package['package_type']))?lang($package['package_type']):$package['package_type']?></h2>
			<p><b><?= lang('package'); ?> : </b> <?= html_escape($package['package_name']);?></p>
		</div>
		<div class="">
			<pre class="pre-code">
				<?= $offline['offline_details'];?>
			</pre>
		</div>
		
	</div>
	<?php if(isset($offline['is_transaction_field']) && $offline['is_transaction_field']==1): ?>
		<div class="offlinePayment">
			<form action="<?= base_url("payment/offline_payment_request/{$u_info['username']}/{$package['slug']}");?>" method="post">
				<?= csrf();?>
				<div class="row d-flex-center flex-column">
					<div class="col-md-6 form-group text-left">
						<label for=""><?= lang('transaction_id');?></label>
						<input type="text" name="transaction_id" class="form-control" placeholder="<?= lang('transaction_id');?>" required>

					</div>
					<div class="col-md-6 form-group">
						<input type="hidden" name="username" value="<?= $u_info['username'];?>">
						<input type="hidden" name="package_slug" value="<?= $package['slug'];?>">
						<input type="hidden" name="is_txn_required" value="1">
						<button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> <?= lang('verify_payment');?></button>
					</div>
					
				</div>
			</form>
		</div>
	<?php endif ?>
	<?php if(isset($offline['is_transaction_field']) && $offline['is_transaction_field']==0): ?>
		<?php if(is_demo()==0): ?>
			<a href="<?php echo base_url('offline-payment/'.html_escape($u_info['username']).'/'.html_escape($package['slug'])); ?>" class="btn btn-success pay_now"><?= lang('verify_payment');?></a>
		<?php endif;?>
	<?php endif;?>
</div><!-- payment_content -->