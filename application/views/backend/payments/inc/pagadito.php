<?php if(check()==1): ?>
<?php $pagadito = json_decode($settings['pagadito_config']??'',true); ?>
<?php  if(!empty($pagadito['pagadito_wsk_key'])):?>
<div class="payment_content text-center <?= is_package;?>">
	<div class="payment_icon payment">
		<img src="<?php echo base_url('assets/frontend/images/payout/pagadito.jpg'); ?>" alt="">
	</div>
	<div class="payment_details">
		<h4> <?= isset($u_info['username'])?html_escape($u_info['username']):'';?></h4>
		<div class="">
			<h2><?= get_currency('icon');?> <?= isset($total_price)?html_escape($total_price):'';?> / <?= !empty(lang($package['package_type']))?lang($package['package_type']):$package['package_type']?></h2>
			<p><b><?= lang('package'); ?> : </b> <?= html_escape($package['package_name']);?></p>
		</div>
	</div>
	<form action='<?=base_url("payment/pagadito/{$u_info['username']}/{$package['slug']}");?>' method='post'>
		<?= csrf();;?>
		<input type='hidden' name='customer_email' class='form-control' required value="<?= $u_info['email'] ;?>" />
		<input type='hidden' name='amount' class='form-control' required value="<?= $total_price ;?>" />
		<input type='hidden' name='precio1' class='form-control' required value="<?= $total_price ;?>" />
		<input type='hidden' name='slug' value='<?= $u_info['username'] ;?>'  class='form-control'/>
		<input type='hidden' name='account_slug' value='<?= $package['slug'] ;?>'  class='form-control'/>
		<input type='hidden' name='descripcion1' value='<?= $package['slug'] ;?>'  class='form-control'/>
		<input type='hidden' name='cantidad1' value='1'  class='form-control'/>
		<input type='hidden' name='url1' value='<?= base_url();?>'  class='form-control'/>
		<?php if(is_demo()==0): ?>
			<button type="submit" class="btn btn-success buy_now"><?= !empty(lang('pay_now'))?lang('pay_now'):"Pay Now"?> &nbsp;( <?= get_currency('icon');?> <?= isset($total_price)?html_escape($total_price):'';?> )</button>
		<?php endif;?>
	</form>

</div><!-- payment_content -->
<?php else: ?>
	<div class="payment_content text-center">
		<h4><?= !empty(lang('credentials_not_found'))?lang('credentials_not_found'):"Credentials not found" ;?></h4>
	</div>
<?php endif;?>

<?php endif;?>