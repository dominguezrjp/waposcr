<?php if(check()==1): ?>
	<?php include APPPATH."views/backend/common/payment_form_list.php"; ?>
<?php else: ?>
	<?php if(isset($settings['purchase_date']) && $settings['purchase_date'] <= '2021-10-01 00:00:00'): ?>
		<div class="row">
			<?php include 'inc/leftsidebar.php'; ?>
			<form class="email_setting_form" action="<?= base_url('admin/settings/add_payment_settings') ?>" method="post" enctype= "multipart/form-data" autocomplete="off">
				<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" autocomplete="off">
				<?php $data = json_decode($settings['seo_settings'],true); ?>
				<div class="col-md-8">
					<div class="card">
						<div class="card-header">
							<h4><?= !empty(lang('paypal_payment'))?lang('paypal_payment'):"Paypal Payment";?></h4>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="form-group  col-md-6 col-sm-6 col-xs-6">
									<?php $paypal = json_decode($settings['paypal_config']); ?>
									<label for=""><?= !empty(lang('status'))?lang('status'):"Status";?></label>
									<div class="">
										<input type="checkbox" name="is_paypal" class=""  value="1"  <?= isset($settings['is_paypal']) && $settings['is_paypal']==1?'checked':'';?> data-toggle="toggle" data-on="<i class='fa fa-check'></i> <?= lang('active'); ?>" data-off="<i class='fa fa-pause'></i> <?= lang('off'); ?>">

									</div>
								</div>

								<div class="form-group  col-md-12 col-sm-12 col-xs-12">
									<label for=""><?= !empty(lang('paypal_environment'))?lang('paypal_environment'):"Paypal Environment";?></label>
									<div class="">
										<select name="is_live" class="form-control">
											<option value="0" <?= isset($paypal->is_live) && $paypal->is_live==0?"selected":"" ;?>><?= lang('sandbox'); ?></option>
											<option value="1" <?= isset($paypal->is_live) && $paypal->is_live==1?"selected":"" ;?>><?= lang('live'); ?></option>
										</select>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label class=""><?= !empty(lang('paypal_email'))?lang('paypal_email'):"Paypal Email";?></label>
										<div class="">
											<input type="text" name="paypal_email" placeholder="<?= !empty(lang('paypal_business_email'))?lang('paypal_business_email'):"Paypal Business Email";?>" class="form-control" value="<?= !empty($paypal->paypal_email)?html_escape($paypal->paypal_email):'';  ?>">
										</div>
									</div>
								</div>
							</div><!-- row -->

						</div><!-- card-body -->
					</div><!-- card -->
					<div class="card">
						<div class="card-header mt-1">
							<h4><?= !empty(lang('stripe_payment_gateway'))?lang('stripe_payment_gateway'):"Stripe paytment Gateway";?></h4>
						</div>
						<div class="card-body">
							<div class="row">
								<?php $stripe = json_decode($settings['stripe_config']); ?>
								<div class="form-group  col-md-6 col-sm-6 col-xs-12">
									<label for=""><?= !empty(lang('status'))?lang('status'):"Status";?></label>
									<div class="">
										<input type="checkbox" name="is_stripe" class="" value="1"  <?= isset($settings['is_stripe']) && $settings['is_stripe']==1?'checked':'';?> data-toggle="toggle" data-on="<i class='fa fa-check'></i> <?= lang('active'); ?>" data-off="<i class='fa fa-pause'></i> <?= lang('off'); ?>">

									</div>
								</div>
							</div><!-- row -->
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="form-group">
										<label class=""><?= !empty(lang('stripe_public_key'))?lang('stripe_public_key'):"Stripe Public key";?></label>
										<div class="">
											<input type="text" name="public_key" placeholder="<?= !empty(lang('stripe_public_key'))?lang('stripe_public_key'):"Stripe Public key";?>" class="form-control" value="<?= !empty($stripe->public_key)?html_escape($stripe->public_key):'';  ?>">
										</div>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="form-group">
										<label class=""><?= !empty(lang('stripe_secret_key'))?lang('stripe_secret_key'):"Stripe Secret key";?></label>
										<div class="">
											<input type="text" name="secret_key" placeholder="<?= !empty(lang('stripe_secret_key'))?lang('stripe_secret_key'):"Stripe Secret key";?>" class="form-control" value="<?= !empty($stripe->secret_key)?html_escape($stripe->secret_key):'';  ?>">
										</div>
									</div>
								</div>
							</div>

						</div><!-- card-body -->
					</div><!-- card -->

					<div class="card">
						<div class="card-header mt-1">
							<h4><?= !empty(lang('razorpay_payment'))?lang('razorpay_payment'):"Razorpay paytment Gateway";?></h4>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="form-group  col-md-6 col-sm-6 col-xs-6">
									<label for=""><?= !empty(lang('status'))?lang('status'):"status";?></label>
									<div class="">
										<input type="checkbox" name="is_razorpay" class=""  value="1"  <?= isset($settings['is_razorpay']) && $settings['is_razorpay']==1?'checked':'';?> data-toggle="toggle" data-on="<i class='fa fa-check'></i> <?= lang('active'); ?>" data-off="<i class='fa fa-pause'></i> <?= lang('off'); ?>">

									</div>
								</div>

							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label class=""><?= !empty(lang('razorpay_key_id'))?lang('razorpay_key_id'):"Razorpay Key Id";?></label>
										<div class="">
											<input type="text" name="razorpay_key_id" placeholder="<?= !empty(lang('razorpay_key_id'))?lang('razorpay_key_id'):"Razorpay key";?>" class="form-control" value="<?= !empty($settings['razorpay_key_id'])?html_escape($settings['razorpay_key_id']):'';  ?>">
										</div>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label class=""><?= !empty(lang('secret_key'))?lang('secret_key'):"Secret Key";?></label>
										<div class="">
											<input type="text" name="razorpay_key" placeholder="<?= !empty(lang('razorpay_key'))?lang('razorpay_key'):"Razorpay Key";?>" class="form-control" value="<?= !empty($settings['razorpay_key'])?html_escape($settings['razorpay_key']):'';  ?>">
										</div>
									</div>
								</div>

							</div>

						</div><!-- card-body -->
						<div class="card-footer">
							<input type="hidden" name="id" value="<?= isset($settings['id'])?html_escape($settings['id']):0; ?>">
							<button type="submit" class="btn btn-primary btn-block"><i class="fa fa-save"></i> &nbsp;<?= !empty(lang('save_change'))?lang('save_change'):"Save Change";?></button>
						</div>
					</div><!-- card -->
					
				</div><!-- col-9 -->
			</form>
		</div>
	<?php else: ?>
		<?php include 'inc/leftsidebar.php'; ?>
		<div class="col-md-8">
			<div class="callout callout-default">
			<h4 class="mb-3"><i class="icon fa fa-question-circle"></i> Info!</h4>

			<p>Payment Method is available only in the <b>Extended license</b>.</p>
			<p>Please read  about the envato license rules&nbsp; <u><a href="https://codecanyon.net/licenses/standard" class="c_black" target="blank">Click Here</a></u></p>

			<p class="font-italic">*[ Upgrade your item in the extended license ]</p>
		</div>
		</div>
	<?php endif;?>
<?php endif;?>