<div class="row">
	<?php include APPPATH."views/backend/dashboard/admin_inc/alert_info.php"; ?>
</div>
<div class="row">
	<?php include 'inc/leftsidebar.php'; ?>
	<form class="email_setting_form" action="<?= base_url('admin/settings/map_config') ?>" method="post" enctype= "multipart/form-data" autocomplete="off">
		<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" autocomplete="off">
		<div class="col-md-6">
			<?php $gmap = !empty($settings['gmap_config'])?json_decode($settings['gmap_config'],true):''; ?>
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="custom-control custom-switch prefrence-item ml-10">
							<div class="gap">
								<input type="checkbox" id="is_gmap_key" name="is_gmap_key" class="switch-input " value="1" <?= isset($gmap['is_gmap_key']) && $gmap['is_gmap_key']==1?"checked" : "" ;?>>

								<label for="is_gmap_key" class="switch-label"> <span class="toggle--on"> <i class="fa fa-check c_green"></i> <?= !empty(lang('on'))?lang('on'):"On";?></span><span class="toggle--off"><i class="fa fa-ban c_red"></i> <?= !empty(lang('off'))?lang('off'):"Off";?></span></label>

							</div>
							<div class="preText">
								<div class="">
									<label class="custom-control-label"><?= !empty(lang('google_map_api_key'))?lang('google_map_api_key'):'Google Map Api Key' ;?></label>
									<p class="text-muted"><small><?= !empty(lang('allow_access_google_map_key'))?lang('allow_access_google_map_key'):"Allow to access google map api key"; ?></small></p>
									
								</div>
							</div>
						</div><!-- custom-control -->

						<div class="form-group col-md-12">
							<label><?= lang('google_map_api_key');?></label>
							<input type="text" name="gmap_key" id="url" class="form-control" placeholder="<?= lang('google_map_api_key');?>" value="<?= isset($gmap['gmap_key'])?html_escape($gmap['gmap_key']):""; ?>">
						</div>

					</div>
					<hr>
					<div class="row">
						<div class="form-group col-md-12">
							<label for=""><?= lang('nearby_radius');?></label>
							<div class="input-group">
								<input type="number" name="nearby_length" class="form-control" pattern="[0-9]" min="1" placeholder="<?= lang('nearby_radius');?>" value="<?=!empty($settings['nearby_length'])?$settings['nearby_length']:5;?>">
								<span class="input-group-addon">KM</span>

							</div>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="form-group col-md-12">
							<label><?= lang('google_font_name');?></label>
							<input type="text" name="system_fonts" id="url" class="form-control" placeholder="<?= lang('google_font_name');?>" value="<?= isset($settings['system_fonts'])?html_escape($settings['system_fonts']):""; ?>">
						</div>
					</div>


					<div class="row">
						<div class="form-group col-md-12">
							<label><?= lang('custom_css');?></label>
							<textarea name="custom_css" id="custom_css" class="form-control" cols="30" rows="10" placeholder="<?= lang('custom_css');?>" ><?= isset($settings['custom_css'])?html_escape($settings['custom_css']):""; ?></textarea>
							
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
