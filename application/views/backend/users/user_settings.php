<div class="row">
	<?php include APPPATH.'views/backend/users/inc/leftsidebar.php'; ?>
	
		<div class="col-md-5">
			<form class="email_setting_form" action="<?= base_url('admin/auth/add_email_settings') ?>" method="post" enctype= "multipart/form-data" autocomplete="off">
						<?= csrf() ;?>
				<div class="card">
					<div class="card-body">
						<div class="row p-15">
							<div class="email_areas">
								<div class="email_content">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label><?= lang('color_picker'); ?>:</label>

												<div class="color_picker">
													<div class="input-group my-colorpicker2 colorpicker-element">
														<input type="text" class="form-control" name="colors" value="<?= $this->my_info['colors'];?>">

														<div class="input-group-addon">
															<i style="background-color: rgb(0, 0, 0);"></i>
														</div>
													</div>
													<!-- /.input group -->		
												</div>
											</div>
										</div>
										<div class="col-md-12 ">
											<div class="form-group">
												<label class=""><?= lang('contact_email'); ?></label>
												<div class="">
													<input type="text" name="smtp_mail" placeholder="<?= lang('contact_email'); ?>" class="form-control" value="<?= !empty($settings['smtp_mail'])?html_escape($settings['smtp_mail']):'';  ?>">
													<span class="error"><?= form_error('email'); ?></span>
												</div>
											</div>
										</div>
										
										<div class="form-group col-md-12">
											<label class=""><?= !empty(lang('default_email'))?lang('default_email'):"Default Email";?></label>
											<div class="">
												<select name="email_type"  class="form-control email_option">
													<option value="1" <?= isset($settings['email_type']) && $settings['email_type']==1?'selected':''?>> <?= lang('php_mail'); ?></option>
													<option value="2" <?= isset($settings['email_type']) && $settings['email_type']==2?'selected':''?>> <?= lang('smtp'); ?></option>
													<option value="3" <?= isset($settings['email_type']) && $settings['email_type']==3?'selected':''?>> <?= lang('sendgrid'); ?></option>
													
												</select>
											</div>
										</div>
									</div>

									<div class="row">
										<?php $smtp = json_decode(!empty($settings['smtp_config'])?$settings['smtp_config']:'',TRUE); ?>
										<div class="smtpArea " style="display:<?= isset($settings['email_type'])  &&  $settings['email_type']==2?'block':'none'?>">

											<div class="col-md-12">
												<div class="callout callout-primary">
													<h4><i class="fa fa-envelope-o"></i> Gmail Smtp</h4>

													<p>Gmail Host:&nbsp;&nbsp;smtp.gmail.com <br>
													Gmail Port:&nbsp;&nbsp;465</p>

													<ol>
														<li>Login to your gmail</li>
														<li>Go to Security setting and Enable 2 factor authentication</li>
														<li>After enabling this you can see app passwords option</li>
														<li>And then, from Your app passwords tab select Other option and put your app name and click GENERATE button to get new app password. </li>
														<li>Finally copy the 16 digit of password and click done. Now use this password instead of email password to send mail via your app.</li>
													</ol>

												</div>
											</div>


											<div class="form-group col-md-6">
												<label class=""><?= lang('smtp_host'); ?></label>
												<div class="">
													<input type="text" name="smtp_host" placeholder="<?= lang('smtp_host'); ?>" class="form-control" value="<?= !empty($smtp['smtp_host'])?html_escape($smtp['smtp_host']):'';  ?>">
													<span class="error"><?= form_error('smtp_host'); ?></span>
												</div>
											</div>

											<div class="form-group col-md-6 ">
												<label class=""><?= lang('smtp_port'); ?></label>
												<div class="">
													<input type="text" name="smtp_port" placeholder="<?= lang('smtp_port'); ?>" class="form-control" value="<?= !empty($smtp['smtp_port'])?html_escape($smtp['smtp_port']):'';  ?>" autocomplete="off">
													<span class="error"><?= form_error('smtp_port'); ?></span>
												</div>
											</div>
											<div class="form-group col-md-6">
												<label><?= lang('smtp_password'); ?></label>
												<div class="">
													<input type="password" name="smtp_password" placeholder=" <?= lang('smtp_password'); ?>" class="form-control" value="<?= !empty($smtp['smtp_password'])?html_escape(base64_decode($smtp['smtp_password'])):'';  ?>" autocomplete="off">
													<span class="error"><?= form_error('smtp_password'); ?></span>
												</div>
											</div>

										</div>
									</div>	
									<div class="row sendGrid">
										<div class="sendGrid" style="display: <?= isset($settings['email_type']) && $settings['email_type']==3?'block':'none'?>;">
											<div class="form-group col-md-12">
												<label><?= lang('sendgrid_api_key');?></label>
												<input type="text" name="sendgrid_api_key" class="form-control" value="<?= isset($settings['sendgrid_api_key'])?$settings['sendgrid_api_key']:"";?>" placeholder="<?= lang('sendgrid_api_key');?>">
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-12 text-left">
											<a href="<?= base_url("admin/auth/test_mail");?>" target="blank" class="btn btn-secondary"><?= lang('test_mail');?></a>
										</div>
									</div>
								</div><!-- email_content -->
							</div><!-- email_area -->
						</div><!-- row -->
							
					</div><!-- card-body -->
					<div class="card-footer">
						<input type="hidden" name="id" value="<?= isset($settings['id'])?html_escape($settings['id']):0; ?>">
						<button type="submit" class="btn btn-primary btn-block"><i class="fa fa-save"></i> &nbsp;<?= !empty(lang('save_change'))?lang('save_change'):"Save Change";?></button>
					</div>
				</div><!-- card -->
			</form>
		</div><!-- col-9 -->

	<?php if((isset($settings['sendgrid_api_key']) && !empty($settings['sendgrid_api_key'])) || isset($smtp['smtp_password']) && (!empty($smtp['smtp_password']))):?>
		<div class="col-md-4">
			<form action="<?= base_url("admin/auth/order_mail_config");?>" method="post" class="validForm">
				<?= csrf();?>
				<div class="card">
					<div class="card-header"> <h4 class="m-0 mr-4"> <?= lang('order_mail');?></h4></div>
					<div class="card-body">
						<div class="">
							<?php $mail = !empty($settings['order_mail_config'])?json_decode(@$settings['order_mail_config']):'';?>
						
							<div class="custom-control custom-switch prefrence-item m-0">
								<div class="gap">
									<input type="checkbox" id="is_order_mail" name="is_order_mail" class="switch-input " <?= isset($mail->is_order_mail) && $mail->is_order_mail==1?"checked" : "" ;?>>

									<label for="is_order_mail" class="switch-label"> <span class="toggle--on"> <i class="fa fa-check c_green"></i> <?= !empty(lang('on'))?lang('on'):"On";?></span><span class="toggle--off"><i class="fa fa-ban c_red"></i> <?= !empty(lang('off'))?lang('off'):"Off";?></span></label>

								</div>
								<div class="preText">
									<div class="">
										<label class="custom-control-label"><?= lang('order_mail') ;?></label>
										<p class="text-muted"><small><?= !empty(lang('enable_to_allow_in_your_system'))?lang('enable_to_allow_in_your_system'):"Enable to allow in your system"; ?>.</small></p>
									</div>
								</div>
							</div><!-- custom-control -->
						</div>
						<div class="form-group">
							<label><?= lang('subject');?> <span class="error">*</span></label>
							<input type="text" name="subject" class="form-control" value="<?= !empty($mail->subject)?$mail->subject:'';?>" required>
						</div>

						<div class="form-group">
							<label><?= lang('order_receive_mail');?> <span class="error">*</span></label>
							<input type="text" name="order_receiver_mail" class="form-control" value="<?= !empty($mail->order_receiver_mail)?$mail->order_receiver_mail:$settings['smtp_mail'];?>" required>
						</div>
						<div class="form-group">
							<div class="form-group">

							<label><?= lang('message');?>  <span class="error">*</span></label>
								<div class="mb-5">
									<code>{CUSTOMER_NAME}, {ORDER_ID}, {ITEM_LIST}, {SHOP_NAME}, {SHOP_ADDRESS}</code>
								</div>
								<textarea name="message" class="form-control textarea" cols="5" rows="15" required><?= !empty($mail->message)?json_decode($mail->message):'';?></textarea>

							</div>
						</div>
						<div class="form-group">
							<label><?= lang('enable_mail');?></label>
							<div class="mt-5">
								<label class="custom-checkbox"><input type="checkbox" name="is_owner_mail" id="is_owner_mail" value="1" <?= isset($mail->is_owner_mail) && $mail->is_owner_mail==1?"checked" :"";;?>> <?= lang('restaurant_owner');?></label>

								<label class="custom-checkbox ml-10"><input type="checkbox" name="is_dboy_mail" id="is_dboy_mail" value="1" <?= isset($mail->is_dboy_mail) && $mail->is_dboy_mail==1? "checked":"";;?>> <?= lang('delivery_staff');?></label>

								<label class="custom-checkbox ml-10"><input type="checkbox" name="is_customer_mail" id="is_customer_mail" value="1" <?= isset($mail->is_customer_mail) && $mail->is_customer_mail==1? "checked":"";;?>> <?= lang('customer_mail');?></label>
							</div>
						</div>
					</div><!-- card-body -->
					<div class="card-footer text-right"> 
						<input type="hidden" name="id" value="<?= !empty($settings['id'])?$settings['id']:0;?>">
						<button class="btn btn-secondary" type="submit"><?= lang('save_change');?></button>
					</div>
				</div><!-- card -->
			</form>
		</div>
	<?php endif; ?>	
	
</div>



