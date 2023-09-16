<div class="single_track bg-gray">
	<div class="card bg-gray">
		<h5 class="card-header"><?= lang('track_order'); ?></h5>
		<div class="card-body">
			<span class="reg_msg"></span>
			<form action="<?= base_url('profile/track_order_list/'.$slug) ;?>" method="post" class="track_form validForm">
				<?= csrf() ;?>
				<div class="form-group">
					<label for=""><?= lang('phone_number'); ?> <span class="error">*</span></label>
					<input type="text" name="phone" class="form-control remove_char" data-char="+" placeholder="<?= lang('phone_number');?>">
				</div>
				<div class="form-group">
					<label for=""><?= lang('order_id'); ?></label>
					<input type="text" name="order_id" class="form-control" placeholder="<?= lang('order_id');?>">
				</div>
				<?php if(restaurant($id)->is_pin==1): ?>
			        <div class="form-group">
			        	<label for=""><?= lang('security_pin'); ?></label>
			        	<input type="password" name="pin_number" class="form-control" placeholder="<?= lang('security_pin'); ?>">
			        </div>
			      <?php endif;?>
				<div class="track-footer text-right">
					<input type="hidden" name="shop_id" value="<?= base64_encode(restaurant($id)->id) ;?>">
					<button type="submit" class="btn btn-primary custom_btn"><?= lang('check'); ?></button>
				</div>
			</form>
		</div>
	</div>
</div>