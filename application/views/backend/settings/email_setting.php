<div class="row">
	<?php include APPPATH."views/backend/dashboard/admin_inc/alert_info.php"; ?>
</div>
<div class="row">
	<?php include 'inc/leftsidebar.php'; ?>
		<form class="email_setting_form" action="<?= base_url('admin/settings/add_email_settings') ?>" method="post" enctype= "multipart/form-data" autocomplete="off">
			<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" autocomplete="off">
			<div class="col-md-5">
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group ">
									<?php $sub = json_decode($settings['subjects']) ?>
									<label class=""><?= !empty(lang('registration_subject'))?lang('registration_subject'):"registration Subject";?></label>
									<div class="">
										<input type="text" name="registration" placeholder="<?= !empty(lang('registration_subject'))?lang('registration_subject'):"registration Subject";?>" class="form-control" value="<?= !empty($sub->registration)?html_escape($sub->registration):'';  ?>">
									</div>
								</div>
							</div>
							<div class="col-sm-12">
								<div class="form-group ">
									<label class=""><?= !empty(lang('payment_mail_subject'))?lang('payment_mail_subject'):"Payment mail subject";?></label>
									<div class="">
										<input type="text" name="payment" placeholder="<?= !empty(lang('payment_mail_subject'))?lang('payment_mail_subject'):"Paypal email subject";?>" class="form-control" value="<?= !empty($sub->payment)?html_escape($sub->payment):'';  ?>">

									</div>
								</div>
							</div>


							<div class="col-md-12">
								<div class="form-group ">
									<label class=""><?= !empty(lang('email_sub'))?lang('email_sub'):"Email Subject";?> (<?= !empty(lang('recovery_password_heading'))?lang('recovery_password_heading'):"Recovery Passowrd";?>)</label>
									<div class="">
										<input type="text" name="recovery" placeholder="<?= !empty(lang('recovery_password_heading'))?lang('recovery_password_heading'):"Recovery Passowrd";?>" class="form-control" value="<?= !empty($sub->recovery)?html_escape($sub->recovery):'';  ?>">

									</div>
								</div>
							</div>	
						</div><!-- row -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group ">
									<label class=""><?= !empty(lang('default_email'))?lang('default_email'):"Default Email";?></label>
									<div class="">
										<select name="email_type"  class="form-control email_option">
											<option value="1" <?= $settings['email_type']==1?'selected':''?>> <?= lang('php_mail'); ?></option>
											<option value="2" <?= $settings['email_type']==2?'selected':''?>> <?= lang('smtp'); ?></option>
											<option value="3" <?= $settings['email_type']==3?'selected':''?>> <?= lang('sendgrid'); ?></option>
											
										</select>
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label class=""><?= !empty(lang('email_or_username'))?lang('email_or_username'):"Email / username";?></label>
									<div class="">
										<input type="text" name="smtp_mail" placeholder="<?= !empty(lang('email_or_username'))?lang('email_or_username'):"Email / username";?>" class="form-control" value="<?= !empty($settings['smtp_mail'])?html_escape($settings['smtp_mail']):'';  ?>">
									</div>
								</div>
							</div>
							<div class="row smtpArea" >
								<div class="smtpArea col-md-12" style="display: <?= $settings['email_type']==2?'block':'none'?>;">
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
									<?php $smtp = json_decode($settings['smtp_config']); ?>
									<div class="form-group col-md-12">
										<label class=""><?= lang('smtp_host'); ?></label>
										<div class="">
											<input type="text" name="smtp_host" placeholder="<?= lang('smtp_host'); ?>" class="form-control" value="<?= !empty($smtp->smtp_host)?html_escape($smtp->smtp_host):'';  ?>">
										</div>
									</div>

									<div class="form-group col-md-12 ">
										<label class=""><?= lang('smtp_port'); ?></label>
										<div class="">
											<input type="text" name="smtp_port" placeholder="<?= lang('smtp_port'); ?>" class="form-control" value="<?= !empty($smtp->smtp_port)?html_escape($smtp->smtp_port):'';  ?>" autocomplete="off">
										</div>
									</div>
									<div class="form-group col-md-12">
										<label><?= lang('smtp_password'); ?></label>
										<div class="">
											<input type="password" name="smtp_password" placeholder="<?= lang('smtp_password'); ?>" class="form-control" value="<?= !empty($smtp->smtp_password)?base64_decode($smtp->smtp_password):'';  ?>" autocomplete="off">
										</div>
									</div>

									<div class="form-group col-md-12 hidden">
										<label><?= !empty(lang('send_mail_from'))?lang('send_mail_from'):"Send Emails From (Email)"; ?></label>
										<div class="">
											<input type="password" name="send_mail_from" placeholder="do-not-reply@xxx.com" class="form-control" value="<?= !empty($smtp->smtp_password)?base64_decode($smtp->smtp_password):'';  ?>" autocomplete="off">
										</div>
									</div>
								</div>
							</div>
							<div class="row sendGrid">
								<div class="col-md-12 sendGrid" style="display: <?= $settings['email_type']==3?'block':'none'?>;">
									<div class="form-group col-md-12">
										<label><?= lang('sendgrid_api_key');?></label>
										<input type="text" name="sendgrid_api_key" class="form-control" value="<?= isset($settings['sendgrid_api_key'])?$settings['sendgrid_api_key']:"";?>" placeholder="<?= lang('sendgrid_api_key');?>">
									</div>
								</div>
							</div>	
							<div class="row">
								<div class="col-md-12">
									<div class="form-group col-md-12 mt-20">
										
										<div class="">
											<a href="<?= base_url('home/test_mail') ;?>" target="_blank" class="btn btn-secondary"><?= lang('test_mail'); ?></a>
										</div>
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
		<div class="col-md-4">
			<form class="dynamic_mail_form" action="<?= base_url('admin/settings/add_email_content'); ?>" method="post" enctype= "multipart/form-data" autocomplete="off">
				<?= csrf() ;?>
				<?php $emailType = mail_type(); ?>
				<?php $getMsg = isJson($settings['email_template_config'])?json_decode($settings['email_template_config']):''; ?>
				<div class="card">
					<div class="card-body">
						<div class="form-group">
							<label>	<?= lang('email_template')?></label>
							<select name="type" id="type" class="form-control">
								<option value=""><?= lang('select');?></option>
								<?php foreach ($emailType as $key => $value): ?>
									<option value="<?= $key;?>"><?= !empty(lang($key))?lang($key):$key;?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<?php foreach ($emailType as $keys => $values): ?>
							<div class="emailTemplate_content emailTemp <?= $keys;?> dis_none">
								<div class="form-group">
									<label for=""><?= lang('subject');?></label>
									<input type="text" name="subject[<?= $keys;?>]" class="form-control" value="<?= !empty($getMsg->$keys->subject)?$getMsg->$keys->subject:'';?>">
								</div>
								<div class="form-group ">
									<div class="codeContent">
										<code>
											<?php foreach ($values as $content): ?>
											<span>{<?= $content;?>}</span>,
											<?php endforeach; ?>
										</code>
									</div>
									<label for=""><?= $keys;?></label>
									<textarea name="message[<?= $keys;?>]" id="email_content" class="form-control textarea" cols="30" rows="10"><?= !empty($getMsg->$keys->message)?$getMsg->$keys->message:'';?></textarea>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
					<div class="card-footer text-right">
						<input type="hidden" name="id" value="<?= isset($settings['id'])?html_escape($settings['id']):0; ?>">
						<button class="btn btn-secondary"><?= lang('submit');?></button>
					</div>
				</div>	
			</form>
		</div>
</div>

<script>
	$(document).on('change','[name="type"]',function(){
		let val = $(this).val();
		$('.emailTemp').slideUp();
		$('.'+val).slideDown();
	});
</script>