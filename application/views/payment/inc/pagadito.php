<?php $pagadito = !empty($shop['pagadito_config'])?json_decode($shop['pagadito_config'],true):""; ?>
<?php  if(!empty($pagadito['pagadito_uid'])):?>
<div class="payment_content text-center <?= $pay['slug'];?>">
	<div class="payment_icon payment">
		<img src="<?php echo base_url('assets/frontend/images/payout/pagadito.jpg'); ?>" alt="">
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

	<form action='<?=base_url("user_payment/pagadito/{$user['username']}");?>' method='post'>
		<?= csrf();;?>
		<input type='hidden' name='customer_email' class='form-control' required value="<?= $user['email'] ;?>" />
		<input type='hidden' name='amount' class='form-control' required value="<?= $total_amount ;?>" />
		<input type='hidden' name='precio1' class='form-control' required value="<?= $total_amount ;?>" />
		<input type='hidden' name='slug' value='<?= $user['username'] ;?>'  class='form-control'/>
		<input type='hidden' name='descripcion1' value='<?= $user['username'] ;?>'  class='form-control'/>
		<input type='hidden' name='cantidad1' value='1'  class='form-control'/>
		<input type='hidden' name='url1' value='<?= base_url($user['username']);?>'  class='form-control'/>
		<?php if(is_demo()==0): ?>
			<button type="submit" class="btn btn-success buy_now"><?= !empty(lang('pay_now'))?lang('pay_now'):"Pay Now"?> &nbsp;( <?= isset($total_amount)?currency_position($total_amount,$shop['id']):'';?>)</button>
		<?php endif;?>
	</form>

</div><!-- payment_content -->
<?php else: ?>
	<div class="payment_content text-center">
		<h4><?= !empty(lang('credentials_not_found'))?lang('credentials_not_found'):"Credentials not found" ;?></h4>
	</div>
<?php endif;?>