<div class="row">
	<form class="email_setting_form" action="<?= base_url('admin/dashboard/add_email_settings') ?>" method="post" enctype= "multipart/form-data" autocomplete="off">
		<div class="col-md-8">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title"><?= !empty(lang('email'))?lang('email'):"Email";?> <?= !empty(lang('settings'))?lang('settings'):"Settings";?> </h3>
				</div>
				<div class="box-body">
					<div class="post">
							<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
							
							<div class="rows">
								<div class="">
									<div class="email_content">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group ">
													<label class=""><?= !empty(lang('email_sub'))?lang('email_sub'):"Email Subject";?> (<?= !empty(lang('registration'))?lang('registration'):"registration";?>)</label>
													<div class="">
														<input type="text" name="reg_subject" placeholder="<?= !empty(lang('registration'))?lang('registration'):"registration";?> <?= !empty(lang('email_sub'))?lang('email_sub'):"Email Subject";?>" class="form-control" value="<?= !empty($setting['reg_subject'])?html_escape($setting['reg_subject']):'';  ?>">
													</div>
												</div>
											</div>
											
											<div class="col-sm-6">
												<div class="form-group ">
													<label class=""><?= !empty(lang('email_sub'))?lang('email_sub'):"Email Subject";?> (<?= !empty(lang('payment_gateway'))?lang('payment_gateway'):"payment_gateway";?>)</label>
													<div class="">
														<input type="text" name="paypal_subject" placeholder="<?= !empty(lang('payment_gateway'))?lang('payment_gateway'):"payment_gateway";?> <?= !empty(lang('email_sub'))?lang('email_sub'):"Email Subject";?> " class="form-control" value="<?= !empty($setting['paypal_subject'])?html_escape($setting['paypal_subject']):'';  ?>">
													</div>
												</div>
											</div>
											
											<div class="col-md-6">
												<div class="form-group ">
													<label class=""><?= !empty(lang('email_sub'))?lang('email_sub'):"Email Subject";?> (<?= !empty(lang('recovery_password_heading'))?lang('recovery_password_heading'):"Recovery Passowrd";?>)</label>
													<div class="">
														<input type="text" name="recovery_subject" placeholder="<?= !empty(lang('recovery_password_heading'))?lang('recovery_password_heading'):"Recovery Passowrd";?>" class="form-control" value="<?= !empty($setting['recovery_subject'])?html_escape($setting['recovery_subject']):'';  ?>">
														<span class="error"><?= form_error('recovery_subject'); ?></span>
													</div>
												</div>
											</div>
											
											
										</div><!-- row -->

										<div class="row email_area">
											<div class="col-md-6">
												<div class="form-group">
													<label class=""><?= !empty(lang('admin_email'))?lang('admin_email'):"Admin Email";?></label>
													<div class="">
														<input type="text" name="email" placeholder="<?= !empty(lang('admin_email'))?lang('admin_email'):"Admin Email";?>" class="form-control" value="<?= !empty($setting['email'])?html_escape($setting['email']):'';  ?>">
													</div>
												</div>
											</div>
											<div class="col-sm-12">
												<div class="email_select">
													<label><input type="radio" name="email_type" value="1" <?= $setting['email_type']==1?'checked':''?> class="email_option"> <?= lang('php_mail'); ?></label> &nbsp;
													<label><input type="radio" name="email_type" value="2" <?= $setting['email_type']==2?'checked':''?> class="email_option"> <?= lang('smtp'); ?></label>
												</div>
											</div>
										</div>

										<div class="row email_area">

											<div class="smtp_area" style="display: <?= $setting['email_type']==2?'block':'none'?>;">
												<div class="form-group col-md-6">
													<label class=""><?= lang('smtp_host'); ?></label>
													<div class="">
														<input type="text" name="smtp_host" placeholder="<?= lang('smtp_host'); ?>" class="form-control" value="<?= !empty($setting['smtp_host'])?html_escape($setting['smtp_host']):'';  ?>">
													</div>
												</div>

												<div class="form-group col-md-6 ">
													<label class=""><?= lang('smtp_port'); ?></label>
													<div class="">
														<input type="text" name="smtp_port" placeholder="<?= lang('smtp_port'); ?>" class="form-control" value="<?= !empty($setting['smtp_port'])?html_escape($setting['smtp_port']):'';  ?>" autocomplete="off">
													</div>
												</div>
												<div class="form-group col-md-6">
													<label><?= lang('smtp_password'); ?></label>
													<div class="">
														<input type="password" name="password" placeholder="<?= lang('smtp_password'); ?>" class="form-control" value="<?= !empty($setting['password'])?html_escape($setting['password']):'';  ?>" autocomplete="off">
													</div>
												</div>
											</div>
										</div>	
										
									</div><!-- email_content -->
								</div><!-- email_area -->
							</div>

							<div class="form-group mt-20">
								<div class="col-sm-offset-2 col-sm-10 text-right">
									<input type="hidden" name="id" value="<?= isset($setting['id'])?html_escape($setting['id']):0; ?>">
									<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> &nbsp;<?= !empty(lang('save_change'))?lang('save_change'):"Save Change";?></button>
								</div>
							</div>
						
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="row">
				<div class="col-md-12">
					<div class="box box-info">
						<div class="box-header with-border">
							<h3 class="box-title"><?= !empty(lang('paypal'))?lang('paypal'):"Paypal";?> <?= !empty(lang('payment_gateway'))?lang('payment_gateway'):"Payment Gateway";?></h3>
							<div class="box-tools pull-right">
								<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
							</div>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<div class="upcoming_events">
								<div class="row">
									<div class="form-group  col-md-6 col-sm-6 col-xs-6">
										<label for=""><?= !empty(lang('paypal'))?lang('paypal'):"Paypal Payment";?></label>
										<div class="">
											<input type="checkbox" name="is_paypal" class="setting_option"  data-type="is_paypal" data-value="<?= check_setting_value('is_paypal'); ?>" value="1"  <?= isset($setting['is_paypal']) && $setting['is_paypal']==1?'checked':'';?> data-toggle="toggle" data-on="<i class='fa fa-check'></i> Active" data-off="<i class='fa fa-pause'></i> Off">
											
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<label class=""><?= !empty(lang('email'))?lang('email'):"Paypal Email";?></label>
											<div class="">
												<input type="text" name="paypal_email" placeholder="Paypal Business email" class="form-control" value="<?= !empty($setting['paypal_email'])?html_escape($setting['paypal_email']):'';  ?>">
												<span class="error"><?= form_error('paypal_email'); ?></span>
											</div>
										</div>
									</div>

								</div>
							</div>	
						</div><!-- /.box-body -->
						<div class="box-footer text-right">
							<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> &nbsp;<?= !empty(lang('save_change'))?lang('save_change'):"Save Change";?></button>
						</div>
					</div>
				</div>


				<div class="col-md-12">
					<div class="box box-info">
						<div class="box-header with-border">
							<h3 class="box-title"><?= !empty(lang('stripe'))?lang('stripe'):"stripe";?> <?= !empty(lang('payment_gateway'))?lang('payment_gateway'):"Payment Gateway";?></h3>
							<div class="box-tools pull-right">
								<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
							</div>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<div class="upcoming_events">
								<div class="row">
									<div class="form-group  col-md-6 col-sm-6 col-xs-12">
										<label for=""><?= !empty(lang('payment_gateway'))?lang('payment_gateway'):"Payment Gateway";?></label>
										<div class="">
											<input type="checkbox" name="is_stripe" class="setting_option"  data-type="is_stripe" data-value="<?= check_setting_value('is_stripe'); ?>" value="1"  <?= isset($setting['is_stripe']) && $setting['is_stripe']==1?'checked':'';?> data-toggle="toggle" data-on="<i class='fa fa-check'></i> Active" data-off="<i class='fa fa-pause'></i> Off">
											
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<label class=""><?= !empty(lang('stripe_public_key'))?lang('stripe_public_key'):"Stripe Public key";?></label>
											<div class="">
												<input type="text" name="public_key" placeholder="<?= !empty(lang('stripe_public_key'))?lang('stripe_public_key'):"Stripe Public key";?>" class="form-control" value="<?= !empty($setting['public_key'])?html_escape($setting['public_key']):'';  ?>">
												<span class="error"><?= form_error('public_key'); ?></span>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<label class=""><?= !empty(lang('stripe_secret_key'))?lang('stripe_secret_key'):"Stripe Secret key";?></label>
											<div class="">
												<input type="text" name="secret_key" placeholder="<?= !empty(lang('stripe_secret_key'))?lang('stripe_secret_key'):"Stripe Secret key";?>" class="form-control" value="<?= !empty($setting['secret_key'])?html_escape($setting['secret_key']):'';  ?>">
												<span class="error"><?= form_error('secret_key'); ?></span>
											</div>
										</div>
									</div>

								</div>
							</div>	
						</div><!-- /.box-body -->
						<div class="box-footer text-right">
							<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> &nbsp;<?= !empty(lang('save_change'))?lang('save_change'):"save Change";?></button>
						</div>
					</div>
				</div>
			</div>
			
		</div>
	</form>
</div>