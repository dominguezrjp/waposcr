<div class="row">
	<?php include APPPATH."views/backend/dashboard/admin_inc/alert_info.php"; ?>
</div>
<div class="row">
	<?php include 'inc/leftsidebar.php'; ?>
	<form class="email_setting_form" action="<?= base_url('admin/settings/add_appearance') ?>" method="post" enctype= "multipart/form-data" autocomplete="off">
		<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" autocomplete="off">
		<div class="col-md-6">
			<div class="card">
				<div class="card-body">

					<div class="row">
						<div class="form-group col-md-6">
							<label><?= lang('frontend_color');?></label>
							<div class="input-group my-colorpicker2 colorpicker-element">
								<input type="text" name="site_color" class="form-control" autocomplete="off" value="<?= !empty($settings['site_color'])?'#'.$settings['site_color']:"#29c7ac;";?>">
								<div class="input-group-addon">
									<i style="background-color: #29c7ac;"></i>
								</div>
							</div>

						</div>
					</div> <!-- row -->
					<div class="row mt-20">
						<hr>
						<div class="col-md-6">
							<div class="form-group">
								<label ><?= lang('light');?></label>
								<label class="pointer custom-radio layoutImg">
									<div class="layouts">
										<img src="<?= base_url("assets/frontend/images/dashboard_layouts/light_dashboard.png");?>" class="img-thumbnail box-shadow" alt="">
									</div>
									<input type="radio" name="site_theme" value="1" <?= isset($settings['site_theme']) && $settings['site_theme']==1?"checked":"";?>>
								</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label ><?= lang('dark');?></label>
								<label class="pointer custom-radio layoutImg">
									<div class="layouts">
										<img src="<?= base_url("assets/frontend/images/dashboard_layouts/dark_dashboard.png");?>" class="img-thumbnail box-shadow" alt="">
									</div>
									<input type="radio" name="site_theme" value="2" <?= isset($settings['site_theme']) && $settings['site_theme']==2?"checked":"";?>>
								</label>
							</div>
						</div>
					</div>

				</div><!-- card-body -->
				<div class="card-footer">
					<input type="hidden" name="id" value="<?= isset($settings['id'])?html_escape($settings['id']):0; ?>">
					<button type="submit" class="btn btn-secondary btn-block"><i class="fa fa-save"></i> &nbsp;<?= !empty(lang('save_change'))?lang('save_change'):"Save Change";?></button>
				</div>
			</div><!-- card -->
		</div><!-- col-9 -->
	</form>
</div>
