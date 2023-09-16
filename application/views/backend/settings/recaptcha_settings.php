<div class="row">
	<?php include APPPATH."views/backend/dashboard/admin_inc/alert_info.php"; ?>
</div>
<div class="row">
	<?php include 'inc/leftsidebar.php'; ?>
	<form class="email_setting_form" action="<?= base_url('admin/settings/add_recaptcha');?>" method="post" enctype= "multipart/form-data" autocomplete="off">
		<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" autocomplete="off">
		<div class="col-md-8">
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="form-group  col-md-6 col-sm-6 col-xs-6">
							<?php $captcha = json_decode($settings['recaptcha_config']); ?>
							<label ><?= !empty(lang('recaptcha'))?lang('recaptcha'):"Google Recaptcha";?></label>
							<div class="gap">
								<input type="checkbox" name="is_recaptcha" value="1"  <?= isset($settings['is_recaptcha']) && $settings['is_recaptcha']==1?'checked':'';?> data-toggle="toggle" data-on="<i class='fa fa-check'></i> <?= lang('active'); ?>" data-off="<i class='fa fa-pause'></i> <?= lang('off'); ?>">

							</div>
						</div>

							<?php if(isset($settings['is_recaptcha']) && $settings['is_recaptcha']==1): ?>
							<div class="col-md-6">
								<div class="g-recaptcha" data-sitekey="<?= !empty($captcha->site_key)?html_escape($captcha->site_key):'';  ?>"></div>
							</div>
							<?php endif;?>

							<div class="col-md-12">
								<div class="form-group">
									<label class="gap"><?= !empty(lang('g_site_key'))?lang('g_site_key'):"recaptcha site key";?></label>
									<div class="gap">
										<input type="text" name="site_key" placeholder="<?= !empty(lang('g_site_key'))?lang('g_site_key'):"Site Key";?>" class="form-control" value="<?= !empty($captcha->site_key)?html_escape($captcha->site_key):'';  ?>">

									</div>
								</div>
							</div>

							<div class="col-md-12">
								<div class="form-group">
									<label class="gap"><?= !empty(lang('g_secret_key'))?lang('g_secret_key'):"secret Key";?></label>
									<div class="gap">
										<input type="text" name="secret_key" placeholder="<?= !empty(lang('g_secret_key'))?lang('g_secret_key'):"secret Key";?>" class="form-control" value="<?= !empty($captcha->secret_key)?html_escape($captcha->secret_key):'';  ?>">

									</div>
								</div>
							</div>
					</div><!-- row -->
						
				</div><!-- card-body -->
				<div class="card-footer">
					<input type="hidden" name="id" value="<?= isset($settings['id'])?html_escape($settings['id']):0; ?>">
					<button type="submit" class="btn btn-primary btn-block"><i class="fa fa-save"></i> &nbsp;<?= !empty(lang('save_change'))?lang('save_change'):"Save Change";?></button>
				</div>
			</div><!-- card -->
		</div><!-- col-9 -->
	</form>
</div>
