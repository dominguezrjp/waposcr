<div class="row">
	<?php include APPPATH."views/backend/dashboard/admin_inc/alert_info.php"; ?>
</div>
<div class="row">
	<?php include 'inc/leftsidebar.php'; ?>
	<form class="email_setting_form" action="<?= base_url('admin/settings/add_landing_page') ?>" method="post" enctype= "multipart/form-data" autocomplete="off">
		<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" autocomplete="off">
		<div class="col-md-6">
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="custom-control custom-switch prefrence-item ml-10">
							<div class="gap">
								<input type="checkbox" id="is_landing_page" name="is_landing_page" class="switch-input " value="1" <?= isset($settings['is_landing_page']) && $settings['is_landing_page']==1?"checked" : "" ;?>>

								<label for="is_landing_page" class="switch-label"> <span class="toggle--on"> <i class="fa fa-check c_green"></i> <?= !empty(lang('on'))?lang('on'):"On";?></span><span class="toggle--off"><i class="fa fa-ban c_red"></i> <?= !empty(lang('off'))?lang('off'):"Off";?></span></label>

							</div>
							<div class="preText">
								<div class="">
									<label class="custom-control-label"><?= !empty(lang('custom_landing_page'))?lang('custom_landing_page'):'Custom Landing Page' ;?></label>
									<p class="text-muted"><small><?= !empty(lang('enable_custom_landing_page'))?lang('enable_custom_landing_page'):"Enable Custom Landing page"; ?>.</small></p>
									<p><?= lang('custom_landing_page_msg'); ?></p>
								</div>
							</div>
						</div><!-- custom-control -->

						<div class="form-group col-md-12">
							<label><?= !empty(lang('landing_page_url'))?lang('landing_page_url'):"Landing page url";?></label>
							<input type="text" name="landing_page_url" id="url" class="form-control" placeholder="example.com" value="<?= isset($settings['landing_page_url'])?html_escape($settings['landing_page_url']):""; ?>">
						</div>
					
					<div class="col-md-12">
						 <hr>
					</div>
				
					 <div class="form-group col-md-12">
					 	<label><?= lang('restaurant_demo');?></label>
					 	<div class="input-group">
					 		<span class="input-group-addon" title="restaurant_demo"><i class="fa fa-user-circle-o"></i> <?= base_url(); ?></span>
					 		<input type="text" class="form-control" name="restaurant_demo" autocomplete="off" placeholder="<?= lang('restaurant_demo'); ?>" value="<?= !empty($settings['restaurant_demo'])?html_escape($settings['restaurant_demo']):'';  ?>">
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
