<?php if(check()==1): ?>
<?php $flutterwave = json_decode($settings['flutterwave_config'],true); ?>
<?php  if(!empty($flutterwave['fw_public_key'])):?>
	
	<div class="payment_content text-center <?= is_package;?>">
		<div class="payment_icon payment">
			<img src="<?php echo base_url('assets/frontend/images/payout/flutterwave.jpeg'); ?>" alt="">
		</div>
		<div class="payment_details">
			<h4> <?= isset($u_info['username'])?html_escape($u_info['username']):'';?></h4>
			<div class="">
				<h2><?= get_currency('icon');?> <?= isset($total_price)?html_escape($total_price):'';?> / <?= !empty(lang($package['package_type']))?lang($package['package_type']):$package['package_type']?></h2>
				<p><b><?= lang('package'); ?> : </b> <?= html_escape($package['package_name']);?></p>
			</div>
		</div>
		<form action='#' method='post'>
			<?= csrf();;?>
			<input type='hidden' name='customer_email' class='form-control' required value="<?= $u_info['email'] ;?>" />
			<input type='hidden' name='amount' class='form-control' required value="<?= $total_price ;?>" />
			<input type='hidden' name='currency' value='NGN' readonly class='form-control'/>
			<input type='hidden' name='payment_plan' value='<?= $u_info['username'] ;?>'  class='form-control'/>
			<input type='hidden' name='slug' value='<?= $u_info['username'] ;?>'  class='form-control'/>
			<input type='hidden' name='account_slug' value='<?= $package['slug'] ;?>'  class='form-control'/>
			<?php if(is_demo()==0): ?>
				<button type="button" class="btn btn-success buy_now" id="start-payment-button" onclick="makePayment()"><?= !empty(lang('pay_now'))?lang('pay_now'):"Pay Now"?> &nbsp;( <?= get_currency('icon');?> <?= isset($total_price)?html_escape($total_price):'';?> )</button>
			<?php endif;?>
		</form>

		<?php 
			$title = $settings['site_name'];
			$currency = get_currency('currency_code');
			$base_url = base_url();
			$slug = $u_info['username'];
			$email = $u_info['email'];
			$account_slug = $package['slug'];
			$amount = $total_price;
			$public_key = $flutterwave['fw_public_key'];
			$rand_id = $slug.'_'.random_string('alnum',12);
			$redirect_url = base_url("payment/flutterwave_payment_status/?slug={$slug}&account_slug={$account_slug}");
	 	?>
		
	</div><!-- payment_content -->
<?php else: ?>
	<div class="payment_content text-center">
		<h4><?= !empty(lang('credentials_not_found'))?lang('credentials_not_found'):"Credentials not found" ;?></h4>
	</div>
<?php endif;?>
<?php include APPPATH.'views/common/flutterwave-js.php'; ?>
<?php endif;?>